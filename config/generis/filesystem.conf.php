<?php
/**
 * Configuration of the filesystem service
 * default implementation is oat\oatbox\filesystem\FileSystemService
 *
 * @author Open Assessment Technologies SA
 */

return new oat\oatbox\filesystem\FileSystemService(array(
    'filesPath' => '/Users/lars/code/opened/tao/data/',
    'adapters' => array(
        'http://tao.local/mytao.rdf#i149696370299861' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/Users/lars/code/opened/tao/data/tao/upload/'
            )
        ),
        'http://tao.local/mytao.rdf#i149696370281232' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/Users/lars/code/opened/tao/data/tao/public/'
            )
        ),
        'http://tao.local/mytao.rdf#i149696370256393' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/Users/lars/code/opened/tao/data/tao/private/'
            )
        ),
        'http://tao.local/mytao.rdf#i149696370359864' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/Users/lars/code/opened/tao/data/taoItems/itemData/'
            )
        ),
        'taoQtiItem' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/Users/lars/code/opened/tao/data/taoQtiItem'
            )
        ),
        'http://tao.local/mytao.rdf#i1496963713142727' => array(
            'class' => 'Local',
            'options' => array(
                'root' => '/Users/lars/code/opened/tao/data/taoQtiTest/'
            )
        )
    )
));
