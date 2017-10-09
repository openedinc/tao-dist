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
 * A Caliper AssessmentEvent models learner interactions with assessments instruments such as online tests or quizzes.
 *
 * https://github.com/openedinc/caliper-spec/blob/master/caliper.md#assessmentEvent
 *
 */
class AssessmentEvent implements Event
{
    const TYPE              = 'AssessmentEvent';
    const CONTEXT           = 'http://purl.imsglobal.org/ctx/caliper/v1p1';
    const ED_APP            = 'https://tao-staging.opened.com';
    const ACTION_SUBMITTED  = 'Submitted';
    const ACTION_STARTED    = 'Started';

    private $id;
    private $ltiSessionId;
    private $eventTime;
    private $type;
    private $edApp;
    private $context;
    private $session;
    private $action;
    private $actorUri;
    private $actorLabel;

    /**
     * @return string
     */
    public function getName()
    {
        return __CLASS__;
    }

    /**
     * AssessmentEvent constructor.
     * @param AssessmentTestSession                     $session
     * @param \common_session_Session                   $testTakerSession
     * @param \taoLti_models_classes_LtiLaunchData      $launchData
     */
    public function __construct(AssessmentTestSession $session, \common_session_Session $testTakerSession, \taoLti_models_classes_LtiLaunchData $launchData)
    {
        $this->id               = Uuid::uuid4();
        $this->ltiSessionId     = Uuid::uuid4();
        $this->type             = static::TYPE;
        $this->edApp            = static::ED_APP;
        $this->context          = static::CONTEXT;
        $this->action           = static::ACTION_SUBMITTED;
        $this->eventTime        = date('c');
        $this->session          = $session;
        $this->launchData       = $launchData;
        $this->actorUri         = $testTakerSession->getUserUri();
        $this->actorLabel       = $testTakerSession->getUserLabel();
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
     * @return Array
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
                'id'        => $this->session->getAssessmentTest()->getIdentifier(),
                'type'      => 'Assessment',
                'name'      => $this->session->getAssessmentTest()->getTitle()
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
            'edApp'         => $this->edApp
        ];
    }
}
