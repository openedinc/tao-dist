<?php
/**
 * Default config header created during install
 */

return new oat\oatbox\filesystem\FileSystemService(array(
    'filesPath' => '/home/poseydon/projects/tao-dist/data/',
    'adapters' => array(
        'taskQueueStorage' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/home/poseydon/projects/tao-dist/data/taskQueueStorage'
            )
        ),
        'fileUploadDirectory' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/home/poseydon/projects/tao-dist/data/tao/upload'
            )
        ),
        'public' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/home/poseydon/projects/tao-dist/data/tao/public'
            )
        ),
        'private' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/home/poseydon/projects/tao-dist/data/tao/private'
            )
        ),
        'log' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/home/poseydon/projects/tao-dist/data/tao/log'
            )
        ),
        'sharedTmp' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/home/poseydon/projects/tao-dist/data/tmp'
            )
        ),
        'stateBackup' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/home/poseydon/projects/tao-dist/data/stateBackup'
            )
        ),
        'itemDirectory' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/home/poseydon/projects/tao-dist/data/taoItems/itemData'
            )
        ),
        'taoQtiItem' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/home/poseydon/projects/tao-dist/data/taoQtiItem'
            )
        ),
        'qtiItemPci' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/home/poseydon/projects/tao-dist/data/qtiItemPci'
            )
        ),
        'qtiItemImsPci' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/home/poseydon/projects/tao-dist/data/qtiItemImsPci'
            )
        ),
        'portableElementStorage' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/home/poseydon/projects/tao-dist/data/portableElementStorage'
            )
        ),
        'taoQtiTest' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/home/poseydon/projects/tao-dist/data/taoQtiTest'
            )
        ),
        'taoQtiTestSessionFilesystem' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/home/poseydon/projects/tao-dist/data/taoQtiTestSessionFilesystem'
            )
        )
    )
));
