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
 * Copyright (c) 2015 (original work) Opened;
 *
 */

namespace oat\taoCaliper\models\events;

use oat\oatbox\event\Event;
use oat\taoLti\models\classes\LtiLaunchData;
use qtism\runtime\tests\AssessmentTestSession;
use Ramsey\Uuid\Uuid;

/**
 * A Caliper AssessmentItemEvent models a learner's interaction with an individual AssessmentItem.
 *
 * https://github.com/openedinc/caliper-spec/blob/master/caliper.md#assessmentItemEvent
 *
 */
class AssessmentItemEvent implements Event
{
    const CONTEXT   = 'http://purl.imsglobal.org/ctx/caliper/v1p1';
    const ED_APP    = 'https://tao-staging.opened.com';
    const TYPE      = 'AssessmentItemEvent';
    const ACTION    = 'Completed';

    private $id;
    private $type;
    private $edApp;
    private $context;
    private $actorUri;
    private $actorLabel;
    private $session;
    private $response;
    private $responseIRI;
    private $eventTime;
    private $duration;
    private $ltiSessionId;
    private $launchData;
    private $action;

    /**
     * @return string
     */
    public function getName()
    {
        return __CLASS__;
    }

    /**
     * AssessmentItemEvent constructor.
     * @param AssessmentTestSession                 $session
     * @param Array                                 $itemSessionAttempt
     * @param \common_session_Session               $testTakerSession
     * @param \taoLti_models_classes_LtiLaunchData  $launchData
     */
    public function __construct(AssessmentTestSession $session, Array $itemSessionAttempt, \common_session_Session $testTakerSession, \taoLti_models_classes_LtiLaunchData $launchData)
    {
        $this->id               = Uuid::uuid4();
        $this->type             = static::TYPE;
        $this->edApp            = static::ED_APP;
        $this->context          = static::CONTEXT;
        $this->action           = static::ACTION;
        $this->actorUri         = $testTakerSession->getUserUri();
        $this->actorLabel       = $testTakerSession->getUserLabel();
        $this->session          = $session;
        $this->response         = $this->getResponseFromArray($itemSessionAttempt['RESPONSE']);
        $this->responseIRI      = Uuid::uuid4();
        $this->eventTime        = date('c');
        $this->duration         = $itemSessionAttempt['duration']['base']['duration'];
        $this->ltiSessionId     = Uuid::uuid4();
        $this->launchData       = $launchData;
    }

    /**
     * Get request signature Header
     * @return Array
     */
    public function getRequestSignatureHeader()
    {
        $oauthSecretProperty = new \core_kernel_classes_Property('http://www.tao.lu/Ontologies/TAO.rdf#OauthSecret');
        $ltiConsumer = \taoLti_models_classes_LtiService::singleton()->getLtiConsumerResource($this->launchData);

        return [
            'X-Request-Signature' => hash_hmac( "md5" , $this->id, $ltiConsumer->getPropertyValues($oauthSecretProperty)[0]),
            'Authorization' => 'Token token='. $this->getCustomAuthToken()
        ];
    }

    /**
     * Get custom caliper url/endpoint from LTI session data
     * @return string
     */
    public function getCustomURL()
    {
        return $this->launchData->getVariable(\taoLti_models_classes_LtiLaunchData::CUSTOM_CALIPER_ENDPOINT);
    }

    /**
     * Get custom caliper auth token from LTI session data
     * @return string
     */
    public function getCustomAuthToken()
    {
        return $this->launchData->getVariable(\taoLti_models_classes_LtiLaunchData::CUSTOM_CALIPER_APIKEY);
    }

    /**
     * Get output Caliper-like array structure
     */
    public function getOutput()
    {
        return [
            '@context'      => $this->context,
            'id'            => 'urn:uuid:'. $this->id,
            'type'          => $this->type,
            'actor' => [
                'id'        => $this->actorUri,
                'type'      => 'Person',
                'name'      => $this->actorLabel
            ],
            'action'        => $this->action,
            'object' => [
                'id'        => $this->session->getCurrentAssessmentItemSession()->getAssessmentItem()->getHref(),
                'type'      => 'AssessmentItem',
                'name'      => $this->session->getCurrentAssessmentItemSession()->getAssessmentItem()->getIdentifier()
            ],
            'federatedSession' => [
                'id'        => 'urn:uuid:'.$this->ltiSessionId,
                'type'      => 'LtiSession',
                'messageParameters' => [
                    'resource_link_id'              => $this->launchData->getResourceLinkID(),
                    'context_id'                    => $this->launchData->getVariable(\taoLti_models_classes_LtiLaunchData::CONTEXT_ID),
                    'roles'                         => $this->launchData->getUserRoles(),
                    'user_id'                       => $this->launchData->getUserID(),
                    'lis_course_section_sourcedid'  => $this->launchData->getVariable(\taoLti_models_classes_LtiLaunchData::LIS_COURSE_SECTION_SOURCE_ID),
                ]
            ],
            'eventTime'     => $this->eventTime,
            'edApp'         => $this->edApp,
            'generated' => [
                'id'        => 'urn:uuid:'. $this->responseIRI,
                'type'      => 'Response',
                'name'      => $this->response,
                'duration'  => $this->duration
            ]
        ];
    }

    /**
     * Get parsed response from an Array
     *
     * @param       Array           $response
     * @return      string|Array
     */
    protected function getResponseFromArray(Array $response)
    {
        if (array_key_exists('base', $response)) {
            if (array_key_exists('string', $response['base'])) {
                return $response['base']['string'];
            }
            return $response['base']['identifier'];
        } else {
            return $response['list']['identifier'];
        }
    }
}
