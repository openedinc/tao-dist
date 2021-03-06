<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 */

namespace oat\taoDeliveryRdf\controller;

use oat\generis\model\kernel\persistence\smoothsql\search\ComplexSearchService;
use oat\oatbox\event\EventManagerAwareTrait;
use oat\taoDeliveryRdf\model\DeliveryAssemblyService;
use oat\taoDeliveryRdf\model\DeliveryFactory;
use oat\taoDeliveryRdf\model\tasks\CompileDelivery;
use oat\taoTaskQueue\model\Entity\TaskLogEntity;
use oat\taoTaskQueue\model\QueueDispatcher;
use oat\taoTaskQueue\model\TaskLogActionTrait;
use oat\taoTaskQueue\model\TaskLogInterface;

class RestDelivery extends \tao_actions_RestController
{
    use EventManagerAwareTrait;
    use TaskLogActionTrait;

    const REST_DELIVERY_TEST_ID        = 'test';
    const REST_DELIVERY_ID             = 'delivery';
    const REST_DELIVERY_PARAMS         = 'delivery-params';
    const REST_DELIVERY_CLASS_URI      = 'delivery-uri';
    const REST_DELIVERY_CLASS_LABEL    = 'delivery-label';
    const REST_DELIVERY_CLASS_PARENT   = 'delivery-parent';
    const REST_DELIVERY_CLASS_COMMENT  = 'delivery-comment';
    const TASK_ID_PARAM                = 'id';

    const CLASS_LABEL_PARAM            = 'delivery-label';
    const CLASS_COMMENT_PARAM          = 'delivery-comment';
    const PARENT_CLASS_URI_PARAM       = 'delivery-parent';

    /**
     * Generate a delivery from test uri
     * Test uri has to be set and existing
     */
    public function generate()
    {
        try {
            if (!$this->hasRequestParameter(self::REST_DELIVERY_TEST_ID)) {
                throw new \common_exception_MissingParameter(self::REST_DELIVERY_TEST_ID, $this->getRequestURI());
            }

            $test = new \core_kernel_classes_Resource($this->getRequestParameter(self::REST_DELIVERY_TEST_ID));
            if (!$test->exists()) {
                throw new \common_exception_NotFound('Unable to find a test associated to the given uri.');
            }

            $label = 'Delivery of ' . $test->getLabel();
            $deliveryClass = $this->getDeliveryClassByParameters();

            $deliveryFactory = $this->getServiceManager()->get(DeliveryFactory::SERVICE_ID);
            /** @var \common_report_Report $report */
            $report = $deliveryFactory->create($deliveryClass, $test, $label);

            if ($this->hasRequestParameter(self::REST_DELIVERY_PARAMS)) {
                $customParams = $this->getRequestParameter(self::REST_DELIVERY_PARAMS);
                $customParams = json_decode(html_entity_decode($customParams), true);
                /** @var \core_kernel_classes_Resource $delivery */
                $delivery = $report->getData();
                if ($delivery instanceof \core_kernel_classes_Resource) {
                    $delivery->setPropertiesValues($customParams);
                }
            }

            if ($report->getType() == \common_report_Report::TYPE_ERROR) {
                \common_Logger::i('Unable to generate delivery execution ' .
                    'into taoDeliveryRdf::RestDelivery for test uri ' . $test->getUri());
                throw new \common_Exception('Unable to generate delivery execution.');
            }
            $delivery = $report->getData();
            $this->returnSuccess(array('delivery' => $delivery->getUri()));
        } catch (\Exception $e) {
            $this->returnFailure($e);
        }
    }

    /**
     * Put task to generate a delivery from test uri to the task queue
     * Test uri has to be set and existing
     */
    public function generateDeferred()
    {   
        try {
            if (! $this->hasRequestParameter(self::REST_DELIVERY_TEST_ID)) {
                throw new \common_exception_MissingParameter(self::REST_DELIVERY_TEST_ID, $this->getRequestURI());
            }

            $test = new \core_kernel_classes_Resource($this->getRequestParameter(self::REST_DELIVERY_TEST_ID));
            if (! $test->exists()) {
                throw new \common_exception_NotFound('Unable to find a test associated to the given uri.');
            }

            $deliveryClass = $this->getDeliveryClassByParameters();
            $deliveryResource = \core_kernel_classes_ResourceFactory::create($deliveryClass);
            $label = __("Delivery of %s", $test->getLabel());
            $deliveryResource->setLabel($label);

            $task = CompileDelivery::createTask($test, $deliveryClass, $deliveryResource);

            $result = [
                'reference_id' => $task->getId()
            ];

            /** @var TaskLogInterface $taskLog */
            $taskLog = $this->getServiceManager()->get(TaskLogInterface::SERVICE_ID);

            $report = $taskLog->getReport($task->getId());

            if (!empty($report)) {
                if ($report instanceof \common_report_Report) {
                    //serialize report to array
                    $report = json_decode($report);
                }
                $result['common_report_Report'] = $report;
            }

            return $this->returnSuccess($result);

        } catch (\Exception $e) {
            $this->returnFailure($e);
        }
    }

    /**
     * Update delivery by id
     */
    public function update()
    {
        try {
            if ($this->getRequestMethod() !== \Request::HTTP_POST) {
                throw new \common_exception_NotImplemented('Only post method is accepted to updating delivery');
            }
            if (!$this->hasRequestParameter(self::REST_DELIVERY_ID)) {
                throw new \common_exception_MissingParameter(self::REST_DELIVERY_ID, $this->getRequestURI());
            }
            $delivery = new \core_kernel_classes_Resource(rawurldecode($this->getRequestParameter(self::REST_DELIVERY_ID)));

            /** @var QueueDispatcher $queueDispatcher */
            $queueDispatcher = $this->getServiceManager()->get(QueueDispatcher::SERVICE_ID);

            if ($taskResource = $queueDispatcher->getTaskResource($delivery)) {
                /** @var TaskLogInterface $taskLog */
                $taskLog = $this->getServiceManager()->get(TaskLogInterface::SERVICE_ID);

                $status = $taskLog->getStatus($taskResource->getUri());

                if (in_array($status, [TaskLogInterface::STATUS_ENQUEUED, TaskLogInterface::STATUS_DEQUEUED, TaskLogInterface::STATUS_RUNNING])) {
                    $report = common_report_Report::createInfo(__('Compilation of delivery is in progress.'));
                    $this->returnReport($report);
                    return;
                } else if (in_array($status, [TaskLogInterface::STATUS_COMPLETED, TaskLogInterface::STATUS_FAILED])) {
                    $report = $queueDispatcher->getReportByLinkedResource($delivery);

                    if ($report->getType() == common_report_Report::TYPE_ERROR) {
                        $this->returnReport($report);
                        return;
                    }
                }
            }
            if ($this->hasRequestParameter(self::REST_DELIVERY_PARAMS)) {
                $propertyValues = $this->getRequestParameter(self::REST_DELIVERY_PARAMS);
                $propertyValues = json_decode(html_entity_decode($propertyValues), true);
                foreach ($propertyValues as $rdfKey => $rdfValue) {
                    $property = $this->getProperty($rdfKey);
                    $delivery->editPropertyValues($property, $rdfValue);
                }
            }
            $this->returnSuccess(array('delivery' => $delivery->getUri()));
        }catch (\Exception $e) {
                $this->returnFailure($e);
            }
    }

    /**
     * Action to find delivery by parameters
     */
    public function search()
    {
        try {
            if ($this->getRequestMethod() !== \Request::HTTP_GET) {
                throw new \common_exception_NotImplemented('Only get method is accepted to searching delivery');
            }
            $params = $this->getRequestParameters();
            $where = [];
            if ($params) {
                foreach ($params as $key => $value) {
                    $rdfKey = \tao_helpers_Uri::decode($key);
                    $value = \tao_helpers_Uri::decode($value);
                    $where[$rdfKey] = $value;
                }
            }
            $deliveryModelClass = $this->getDeliveryRootClass();
            $delivery = current($deliveryModelClass->searchInstances($where));
            if (!$delivery instanceof \core_kernel_classes_Resource) {
                throw new \common_exception_NotFound('Unable to find a delivery');
            }
            $this->returnSuccess(array('delivery' => $delivery->getUri()));

        }catch (\Exception $e) {
            $this->returnFailure($e);
        }
    }

    /**
     * Action to retrieve test compilation task status from queue
     */
    public function getStatus()
    {
        try {
            if (!$this->hasRequestParameter(self::TASK_ID_PARAM)) {
                throw new \common_exception_MissingParameter(self::TASK_ID_PARAM, $this->getRequestURI());
            }

            $data = $this->getTaskLogReturnData(
                $this->getRequestParameter(self::TASK_ID_PARAM),
                CompileDelivery::class
            );

            $this->returnSuccess($data);
        } catch (\Exception $e) {
            $this->returnFailure($e);
        }
    }

    /**
     * @param TaskLogEntity $taskLogEntity
     * @return array
     */
    protected function addExtraReturnData(TaskLogEntity $taskLogEntity)
    {
        $data = [];

        if ($taskLogEntity->getReport()) {
            $plainReport = $this->getPlainReport($taskLogEntity->getReport());

            //the second report is the report of the compilation test
            if (isset($plainReport[1]) && isset($plainReport[1]->getData()['uriResource'])) {
                $data['delivery'] = $plainReport[1]->getData()['uriResource'];
            }
        }

        return $data;
    }


    /**
     * Create a Delivery Class
     *
     * Label parameter is mandatory
     * If parent class parameter is an uri of valid delivery class, new class will be created under it
     * If not parent class parameter is provided, class will be created under root class
     * Comment parameter is not mandatory, used to describe new created class
     *
     * @return \core_kernel_classes_Class
     */
    public function createClass()
    {
        try {
            $class = $this->createSubClass($this->getDeliveryRootClass());

            $result = [
                'message' => __('Class successfully created.'),
                'delivery-uri' => $class->getUri(),
            ];

            $this->returnSuccess($result);
        } catch (\common_exception_ClassAlreadyExists $e) {
            $result = [
                'message' => $e->getMessage(),
                'delivery-uri' => $e->getClass()->getUri(),
            ];
            $this->returnSuccess($result);
        } catch (\Exception $e) {
            $this->returnFailure($e);
        }
    }

    /**
     * Get a delivery class based on parameters
     *
     * If an uri parameter is provided, and it is a delivery class, this delivery class is returned
     * If a label parameter is provided, and only one delivery class has this label, this delivery class is returned
     *
     * @return \core_kernel_classes_Class
     * @throws \common_Exception
     * @throws \common_exception_NotFound
     */
    protected function getDeliveryClassByParameters()
    {
        $rootDeliveryClass = $this->getDeliveryRootClass();

        // If an uri is provided, check if it's an existing delivery class
        if ($this->hasRequestParameter(self::REST_DELIVERY_CLASS_URI)) {
            $deliveryClass = new \core_kernel_classes_Class($this->getRequestParameter(self::REST_DELIVERY_CLASS_URI));
            if ($deliveryClass == $rootDeliveryClass
                || ($deliveryClass->exists() && $deliveryClass->isSubClassOf($rootDeliveryClass))) {
                return $deliveryClass;
            }
            throw new \common_Exception(__('Delivery class uri provided is not a valid delivery class.'));
        }

        if ($this->hasRequestParameter(self::REST_DELIVERY_CLASS_LABEL)) {
            $label = $this->getRequestParameter(self::REST_DELIVERY_CLASS_LABEL);

            $deliveryClasses = $rootDeliveryClass->getSubClasses(true);
            $classes = [$rootDeliveryClass->getUri()];
            foreach ($deliveryClasses as $class) {
                $classes[] = $class->getUri();
            }

            /** @var ComplexSearchService $search */
            $search = $this->getServiceManager()->get(ComplexSearchService::SERVICE_ID);
            $queryBuilder = $search->query();
            $criteria = $queryBuilder->newQuery()
                ->add(RDFS_LABEL)->equals($label)
                ->add(RDFS_SUBCLASSOF)->in($classes)
            ;
            $queryBuilder->setCriteria($criteria);
            $result = $search->getGateway()->search($queryBuilder);

            switch ($result->count()) {
                case 0:
                    throw new \common_exception_NotFound(__('Delivery with label "%s" not found', $label));
                case 1:
                    return new \core_kernel_classes_Class($result->current()->getUri());
                default:
                    $availableClasses = [];
                    foreach ($result as $raw) {
                        $availableClasses[] = $raw->getUri();
                    }
                    throw new \common_exception_NotFound(__('Multiple delivery class found for label "%s": %s',
                        $label, implode(',',$availableClasses)
                    ));
            }
        }

        return $rootDeliveryClass;
    }

    /**
     * Get the delivery root class
     *
     * @return \core_kernel_classes_Class
     */
    protected function getDeliveryRootClass()
    {
        return new \core_kernel_classes_Class(DeliveryAssemblyService::CLASS_URI);
    }

}
