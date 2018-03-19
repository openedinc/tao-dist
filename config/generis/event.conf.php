<?php
/**
 * Default config header created during install
 */

return new oat\oatbox\event\EventManager(array(
    'listeners' => array(
        'oat\\generis\\model\\data\\event\\ResourceCreated' => array(
            array(
                'oat\\generis\\model\\data\\permission\\PermissionManager',
                'catchEvent'
            ),
            array(
                'tao/ResourceWatcher',
                'catchCreatedResourceEvent'
            )
        ),
        'oat\\tao\\model\\event\\FileUploadedEvent' => array(
            array(
                'oat\\tao\\model\\upload\\UploadService',
                'listenUploadEvent'
            )
        ),
        'oat\\tao\\model\\event\\UploadLocalCopyCreatedEvent' => array(
            array(
                'oat\\tao\\model\\upload\\UploadService',
                'listenLocalCopyEvent'
            )
        ),
        'oat\\generis\\model\\data\\event\\ResourceUpdated' => array(
            array(
                'tao/ResourceWatcher',
                'catchUpdatedResourceEvent'
            )
        ),
        'oat\\generis\\model\\data\\event\\ResourceDeleted' => array(
            array(
                'tao/ResourceWatcher',
                'catchDeletedResourceEvent'
            )
        ),
        'oat\\tao\\model\\event\\LoginFailedEvent' => array(
            array(
                'tao/userlocks',
                'catchFailedLogin'
            ),
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\LoginSucceedEvent' => array(
            array(
                'tao/userlocks',
                'catchSucceedLogin'
            ),
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoItems\\model\\event\\ItemRdfUpdatedEvent' => array(
            array(
                'oat\\taoQtiItem\\model\\Listener\\ItemUpdater',
                'catchItemRdfUpdatedEvent'
            )
        ),
        'oat\\taoDelivery\\models\\classes\\execution\\event\\DeliveryExecutionState' => array(
            array(
                'taoQtiTest/QtiTestListenerService',
                'executionStateChanged'
            ),
            array(
                'oat\\taoOutcomeUi\\model\\Wrapper\\ResultServiceWrapper',
                'deleteResultCache'
            ),
            array(
                'taoProctoring/DeliveryMonitoring',
                'executionStateChanged'
            ),
            array(
                'ltiDeliveryProvider/LtiOutcome',
                'deferTransmit'
            ),
            array(
                'ltiDeliveryProvider/LtiDeliveryExecution',
                'executionStateChanged'
            )
        ),
        'oat\\taoQtiTest\\models\\event\\QtiTestStateChangeEvent' => array(
            array(
                'taoQtiTest/QtiTestListenerService',
                'sessionStateChanged'
            ),
            array(
                'taoProctoring/DeliveryMonitoring',
                'qtiTestStatusChanged'
            ),
            array(
                'oat\\taoProctoring\\helpers\\DeliveryHelper',
                'testStateChanged'
            )
        ),
        'oat\\taoDeliveryRdf\\model\\event\\DeliveryCreatedEvent' => array(
            array(
                'oat\\taoDeliveryRdf\\model\\TestRunnerFeatures',
                'enableDefaultFeatures'
            ),
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            ),
            array(
                'taoProctoring/DeliverySync',
                'onDeliveryCreated'
            )
        ),
        'oat\\taoDelivery\\models\\classes\\execution\\event\\DeliveryExecutionCreated' => array(
            array(
                'taoOutcomeUi/ResultsWatcher',
                'catchCreatedDeliveryExecutionEvent'
            ),
            array(
                'taoProctoring/DeliveryMonitoring',
                'executionCreated'
            ),
            array(
                'ltiDeliveryProvider/LtiDeliveryExecution',
                'executionCreated'
            )
        ),
        'oat\\tao\\model\\event\\RoleRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\RoleCreatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\RoleChangedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\UserCreatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\UserUpdatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\UserRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\ClassFormUpdatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoDeliveryRdf\\model\\event\\DeliveryRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoDeliveryRdf\\model\\event\\DeliveryUpdatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            ),
            array(
                'taoProctoring/DeliverySync',
                'onDeliveryUpdated'
            )
        ),
        'oat\\funcAcl\\model\\event\\AccessRightAddedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\funcAcl\\model\\event\\AccessRightRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTests\\models\\event\\TestExportEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTests\\models\\event\\TestImportEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTests\\models\\event\\TestCreatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTests\\models\\event\\TestUpdatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTests\\models\\event\\TestRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTests\\models\\event\\TestDuplicatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTestTaker\\models\\events\\TestTakerClassCreatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTestTaker\\models\\events\\TestTakerClassRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTestTaker\\models\\events\\TestTakerCreatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTestTaker\\models\\events\\TestTakerUpdatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTestTaker\\models\\events\\TestTakerRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTestTaker\\models\\events\\TestTakerExportedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTestTaker\\models\\events\\TestTakerImportedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoItems\\model\\event\\ItemExportEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoItems\\model\\event\\ItemImportEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoItems\\model\\event\\ItemCreatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoItems\\model\\event\\ItemUpdatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoItems\\model\\event\\ItemRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoItems\\model\\event\\ItemDuplicatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\BeforeAction' => array(
            array(
                'taoEventLog/RequestLogStorage',
                'catchEvent'
            ),
            array(
                'taoEventLog/UserLastActivityLog',
                'catchEvent'
            )
        ),
        'oat\\tao\\model\\event\\MetadataModified' => array(
            array(
                'taoProctoring/DeliveryMonitoring',
                'deliveryLabelChanged'
            ),
            array(
                'oat\\taoProctoring\\model\\monitorCache\\update\\TestTakerUpdate',
                'propertyChange'
            )
        ),
        'oat\\taoTests\\models\\event\\TestChangedEvent' => array(
            array(
                'taoProctoring/DeliveryMonitoring',
                'testStateChanged'
            ),
            array(
                'oat\\taoProctoring\\model\\monitorCache\\update\\TestUpdate',
                'testStateChange'
            )
        ),
        'oat\\taoProctoring\\model\\authorization\\AuthorizationGranted' => array(
            array(
                'taoProctoring/DeliveryMonitoring',
                'deliveryAuthorized'
            )
        ),
        'oat\\taoTests\\models\\event\\TestExecutionPausedEvent' => array(
            array(
                'taoDelivery/stateService',
                'catchSessionPause'
            )
        ),
        'oat\\taoProctoring\\model\\event\\DeliveryExecutionFinished' => array(
            array(
                'oat\\taoEventLog\\model\\eventLog\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoCaliper\\models\\events\\AssessmentItemEvent' => array(
            array(
                'oat\\taoCaliper\\models\\testSession\\TestSessionProcessor',
                'catchMove'
            )
        ),
        'oat\\taoCaliper\\models\\events\\AssessmentEvent' => array(
            array(
                'oat\\taoCaliper\\models\\testSession\\TestSessionProcessor',
                'catchFinished'
            )
        ),
        'oat\\taoQtiTest\\models\\event\\RestImportTestBeforeSaveItems' => array(
            array(
                'oat\\taoCaliper\\models\\testSession\\TestSessionProcessor',
                'catchImport'
            )
        )
    )
));
