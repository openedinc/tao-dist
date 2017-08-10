<?php
/**
 * Configuration of the filesystem service
 * default implementation is oat\oatbox\filesystem\FileSystemService
 *
 * @author Open Assessment Technologies SA
 */

return new oat\oatbox\filesystem\FileSystemService(array(
    'filesPath' => FILES_PATH,
    'adapters' => array(
        LOCAL_NAMESPACE.'#i150237991640531' => array(
            'class' => 'Local',
            'options' => array(
                'root' => FILES_PATH.'tao/upload/'
            )
        ),
        LOCAL_NAMESPACE.'#i150237991753522' => array(
            'class' => 'Local',
            'options' => array(
                'root' => FILES_PATH.'tao/public/'
            )
        ),
        LOCAL_NAMESPACE.'#i150237991854493' => array(
            'class' => 'Local',
            'options' => array(
                'root' => FILES_PATH.'tao/private/'
            )
        ),
        LOCAL_NAMESPACE.'#i150238011578594' => array(
            'class' => 'Local',
            'options' => array(
                'root' => FILES_PATH.'taoItems/itemData/'
            )
        ),
        'taoQtiItem' => array(
            'class' => 'Local',
            'options' => array(
                'root' => FILES_PATH.'taoQtiItem'
            )
        ),
        LOCAL_NAMESPACE.'#i1502380445525727' => array(
            'class' => 'Local',
            'options' => array(
                'root' => FILES_PATH.'taoQtiTest/'
            )
        )
    )
));
