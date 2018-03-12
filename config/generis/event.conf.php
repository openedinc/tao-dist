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
        'oat\\taoItems\\model\\event\\ItemRdfUpdatedEvent' => array(
            array(
                'oat\\taoQtiItem\\model\\Listener\\ItemUpdater',
                'catchItemRdfUpdatedEvent'
            )
        ),
        'oat\\tao\\model\\event\\LoginFailedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\LoginSucceedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\RoleRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\RoleCreatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\RoleChangedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\UserCreatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\UserUpdatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\tao\\model\\event\\UserRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\funcAcl\\model\\event\\AccessRightAddedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\funcAcl\\model\\event\\AccessRightRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTests\\models\\event\\TestExportEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTests\\models\\event\\TestImportEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTests\\models\\event\\TestCreatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTests\\models\\event\\TestUpdatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTests\\models\\event\\TestRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTests\\models\\event\\TestDuplicatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTestTaker\\models\\events\\TestTakerClassCreatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTestTaker\\models\\events\\TestTakerClassRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTestTaker\\models\\events\\TestTakerCreatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTestTaker\\models\\events\\TestTakerUpdatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTestTaker\\models\\events\\TestTakerRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTestTaker\\models\\events\\TestTakerExportedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoTestTaker\\models\\events\\TestTakerImportedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoItems\\model\\event\\ItemExportEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoItems\\model\\event\\ItemImportEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoItems\\model\\event\\ItemCreatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoItems\\model\\event\\ItemUpdatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoItems\\model\\event\\ItemRemovedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoItems\\model\\event\\ItemDuplicatedEvent' => array(
            array(
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoDelivery\\models\\classes\\execution\\event\\DeliveryExecutionState' => array(
            array(
                'taoQtiTest/QtiTestListenerService',
                'executionStateChanged'
            ),
            array(
                'taoProctoring/DeliveryMonitoring',
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
                'taoProctoring/DeliverySync',
                'onDeliveryCreated'
            )
        ),
        'oat\\taoDelivery\\models\\classes\\execution\\event\\DeliveryExecutionCreated' => array(
            array(
                'taoProctoring/DeliveryMonitoring',
                'executionCreated'
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
                'oat\\taoEventLog\\model\\LoggerService',
                'logEvent'
            )
        ),
        'oat\\taoDeliveryRdf\\model\\event\\DeliveryUpdatedEvent' => array(
            array(
                'taoProctoring/DeliverySync',
                'onDeliveryUpdated'
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
