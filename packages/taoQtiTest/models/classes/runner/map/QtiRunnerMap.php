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
 * Copyright (c) 2016 (original work) Open Assessment Technologies SA ;
 */
/**
 * @author Jean-Sébastien Conan <jean-sebastien.conan@vesperiagroup.com>
 */

namespace oat\taoQtiTest\models\runner\map;

use oat\oatbox\service\ConfigurableService;
use oat\taoQtiTest\models\ExtendedStateService;
use oat\taoQtiTest\models\runner\config\RunnerConfig;
use oat\taoQtiTest\models\runner\QtiRunnerServiceContext;
use oat\taoQtiTest\models\runner\RunnerServiceContext;
use qtism\data\NavigationMode;
use qtism\runtime\tests\AssessmentTestSession;
use taoQtiTest_helpers_TestRunnerUtils as TestRunnerUtils;

/**
 * Class QtiRunnerMap
 * @package oat\taoQtiTest\models\runner\map
 */
class QtiRunnerMap extends ConfigurableService implements RunnerMap
{
    const SERVICE_ID = 'taoQtiTest/QtiRunnerMap';

    /**
     * Fallback index in case of the delivery was compiled without the index of item href
     * @var array
     */
    protected $itemHrefIndex;

    /**
     * Gets the file that contains the href for the AssessmentItemRef Identifier
     * @param QtiRunnerServiceContext $context
     * @param string $itemIdentifier
     * @return \oat\oatbox\filesystem\File
     */
    protected function getItemHrefIndexFile(QtiRunnerServiceContext $context, $itemIdentifier)
    {
        $compilationDirectory = $context->getCompilationDirectory()['private'];
        return $compilationDirectory->getFile(\taoQtiTest_models_classes_QtiTestCompiler::buildHrefIndexPath($itemIdentifier));
    }

    /**
     * Checks if the AssessmentItemRef Identifier is in the index.
     *
     * @param QtiRunnerServiceContext $context
     * @param string $itemIdentifier
     * @return boolean
     */
    protected function hasItemHrefIndexFile(QtiRunnerServiceContext $context, $itemIdentifier)
    {
        $indexFile = $this->getItemHrefIndexFile($context, $itemIdentifier);
        return $indexFile->exists();
    }

    /**
     * Gets AssessmentItemRef's Href by AssessmentItemRef Identifier.
     * 
     * Returns the AssessmentItemRef href attribute value from a given $identifier.
     * 
     * @param QtiRunnerServiceContext $context
     * @param string $itemIdentifier
     * @return boolean|string The href value corresponding to the given $identifier. If no corresponding href is found, false is returned.
     */
    public function getItemHref(QtiRunnerServiceContext $context, $itemIdentifier)
    {
        $href = false;

        $indexFile = $this->getItemHrefIndexFile($context, $itemIdentifier);
        if ($indexFile->exists()) {
            $href = $indexFile->read();
        } else {
            if (!isset($this->itemHrefIndex)) {
            $storage = $this->getServiceLocator()->get(ExtendedStateService::SERVICE_ID);
                $this->itemHrefIndex = $storage->loadItemHrefIndex($context->getTestExecutionUri());
        }
            if (isset($this->itemHrefIndex[$itemIdentifier])) {
                $href = $this->itemHrefIndex[$itemIdentifier];
        }
        }
        
        return $href;
    }
    
    /**
     * Builds the map of an assessment test
     * @param RunnerServiceContext $context The test context
     * @param RunnerConfig $config The runner config
     * @return mixed
     * @throws \common_exception_InvalidArgumentType
     */
    public function getMap(RunnerServiceContext $context, RunnerConfig $config)
    {
        if (!($context instanceof QtiRunnerServiceContext)) {
            throw new \common_exception_InvalidArgumentType(
                'QtiRunnerMap',
                'getMap',
                0,
                'oat\taoQtiTest\models\runner\QtiRunnerServiceContext',
                $context
            );
        }
        
        $map = [
            'parts' => [],
            'jumps' => []
        ];

        // get config for the sequence number option
        $reviewConfig = $config->getConfigValue('review');
        $checkInformational = $config->getConfigValue('checkInformational');
        $forceTitles = !empty($reviewConfig['forceTitle']);
        $useTitle = !empty($reviewConfig['useTitle']);
        $uniqueTitle = isset($reviewConfig['itemTitle']) ? $reviewConfig['itemTitle'] : '%d';
        $displaySubsectionTitle = isset($reviewConfig['displaySubsectionTitle']) ? (bool) $reviewConfig['displaySubsectionTitle'] : true;

        /* @var AssessmentTestSession $session */
        $session = $context->getTestSession();

        if ($session->isRunning() !== false) {
            $route = $session->getRoute();
            $store = $session->getAssessmentItemSessionStore();
            $routeItems = $route->getAllRouteItems();
            $offset = $route->getRouteItemPosition($routeItems[0]);
            $offsetPart = 0;
            $offsetSection = 0;
            $lastPart = null;
            $lastSection = null;

            // fallback index in case of the delivery was compiled without the index of item href
            $this->itemHrefIndex = [];
            $shouldBuildItemHrefIndex = !$this->hasItemHrefIndexFile($context, $session->getCurrentAssessmentItemRef()->getIdentifier());
            \common_Logger::t('Store index ' . ($shouldBuildItemHrefIndex ? 'must be built' : 'is part of the package'));
            
            /** @var \qtism\runtime\tests\RouteItem $routeItem */
            foreach ($routeItems as $routeItem) {
                // access the item reference
                $itemRef = $routeItem->getAssessmentItemRef();
                $occurrence = $routeItem->getOccurence();

                // get the jump definition
                $itemSession = $store->getAssessmentItemSession($itemRef, $occurrence);

                // load item infos
                $testPart = $routeItem->getTestPart();
                $partId = $testPart->getIdentifier();

                if ($displaySubsectionTitle) {
                    $section = $routeItem->getAssessmentSection();
                } else {
                    $sections = $routeItem->getAssessmentSections()->getArrayCopy();
                    $section = $sections[0];
                }
                $sectionId = $section->getIdentifier();
                $itemId = $itemRef->getIdentifier();
                $itemDefinition = $itemRef->getHref();
                $itemUri = strstr($itemDefinition, '|', true);
                
                if ($lastPart != $partId) {
                    $offsetPart = 0;
                    $lastPart = $partId;
                }
                if ($lastSection != $sectionId) {
                    $offsetSection = 0;
                    $lastSection = $sectionId;
                }

                if ($forceTitles) {
                    $label = __($uniqueTitle, $offsetSection + 1);
                } else {
                    if ($itemUri) {
                        if ($useTitle) {
                            $label = $context->getItemIndexValue($itemUri, 'title');
                        } else {
                            $label = '';
                        }
                        
                        if (!$label) {
                            $label = $context->getItemIndexValue($itemUri, 'label');
                        }
                        
                        if (!$label) {
                            $item = new \core_kernel_classes_Resource($itemUri);
                            $label = $item->getLabel();
                        }
                    } else {
                        // The item URI could not be parsed as expected. Maybe it's an adaptive placeholder?
                        $adaptivePlaceholderCategory = \taoQtiTest_models_classes_QtiTestCompiler::ADAPTIVE_PLACEHOLDER_CATEGORY;
                        if (in_array($adaptivePlaceholderCategory, $itemRef->getCategories()->getArrayCopy())) {
                            // Use the section label as the label of this "position" in the test.
                            $label = $section->getTitle();
                        }
                    }
                }

                // fallback in case of the delivery was compiled without the index of item href
                if ($shouldBuildItemHrefIndex) {
                    $this->itemHrefIndex[$itemId] = $itemRef->getHref();
                }

                $itemInfos = [
                    'id' => $itemId,
                    'uri' => $itemUri,
                    'definition' => $itemDefinition,
                    'label' => $label,
                    'position' => $offset,
                    'positionInPart' => $offsetPart,
                    'positionInSection' => $offsetSection,
                    'index' => $offsetSection + 1,
                    'occurrence' => $occurrence,
                    'remainingAttempts' => $itemSession->getRemainingAttempts(),
                    'answered' => TestRunnerUtils::isItemCompleted($routeItem, $itemSession),
                    'flagged' => TestRunnerUtils::getItemFlag($session, $routeItem),
                    'viewed' => $itemSession->isPresented(),
                ];
                
                if ($checkInformational) {
                    $itemInfos['informational'] = TestRunnerUtils::isItemInformational($routeItem, $itemSession);
                }
                
                // update the map
                $map['jumps'][] = [
                    'identifier' => $itemId,
                    'section' => $sectionId,
                    'part' => $partId,
                    'position' => $offset,
                    'uri' => $itemUri,
                ];
                if (!isset($map['parts'][$partId])) {
                    $map['parts'][$partId]['id'] = $partId;
                    $map['parts'][$partId]['label'] = $partId;
                    $map['parts'][$partId]['position'] = $offset;
                    $map['parts'][$partId]['isLinear'] = $testPart->getNavigationMode() == NavigationMode::LINEAR;
                }
                if (!isset($map['parts'][$partId]['sections'][$sectionId])) {
                    $map['parts'][$partId]['sections'][$sectionId]['id'] = $sectionId;
                    $map['parts'][$partId]['sections'][$sectionId]['label'] = $section->getTitle();
                    $map['parts'][$partId]['sections'][$sectionId]['position'] = $offset;
                }
                $map['parts'][$partId]['sections'][$sectionId]['items'][$itemId] = $itemInfos;
                
                // update the stats
                $this->updateStats($map, $itemInfos);
                $this->updateStats($map['parts'][$partId], $itemInfos);
                $this->updateStats($map['parts'][$partId]['sections'][$sectionId], $itemInfos);
                
                $offset ++;
                $offsetPart ++;
                $offsetSection ++;
            }
            
            // fallback in case of the delivery was compiled without the index of item href
            if ($shouldBuildItemHrefIndex) {
                \common_Logger::t('Store index of item href into the test state storage');
                $storage = $this->getServiceLocator()->get(ExtendedStateService::SERVICE_ID);
                $storage->storeItemHrefIndex($context->getTestExecutionUri(), $this->itemHrefIndex);
            }
        }
        
        return $map;
    }

    /**
     * Update the stats inside the target
     * @param array $target
     * @param array $itemInfos
     */
    protected function updateStats(&$target, $itemInfos)
    {
        if (!isset($target['stats'])) {
            $target['stats'] = [
                'questions' => 0,
                'answered' => 0,
                'flagged' => 0,
                'viewed' => 0,
                'total' => 0,
            ];
        }

        if (empty($itemInfos['informational'])) {
            $target['stats']['questions'] ++;
        }
        
        if (!empty($itemInfos['answered'])) {
            $target['stats']['answered'] ++;
        }
        
        if (!empty($itemInfos['flagged'])) {
            $target['stats']['flagged'] ++;
        }
        
        if (!empty($itemInfos['viewed'])) {
            $target['stats']['viewed'] ++;
        }
        
        $target['stats']['total'] ++;
    }
}
