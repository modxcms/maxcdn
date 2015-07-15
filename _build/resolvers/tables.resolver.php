<?php
/* @var modX $modx */

if ($object->xpdo) {
    $modx =& $object->xpdo;
    $modelPath = $modx->getOption('mcdn.core_path',null,$modx->getOption('core_path').'components/maxcdn/').'model/';
    $modx->addPackage('maxcdn',$modelPath, '');
    $manager = $modx->getManager();

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_UPGRADE:
            $manager->alterField('mcdnRule', 'cdn_url', array());
            break;
        case xPDOTransport::ACTION_INSTALL:
            $loglevel = $modx->setLogLevel(modX::LOG_LEVEL_ERROR);
            
            $objects = array('mcdnRule');
            foreach ($objects as $obj) {
                $manager->createObjectContainer($obj);
            }

            $modx->setLogLevel($loglevel);
        break;
    }

}
return true;

