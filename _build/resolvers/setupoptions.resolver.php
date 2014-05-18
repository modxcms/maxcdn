<?php
$success= false;
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        $settings = array(
            'alias',
            'consumer_key',
            'consumer_secret',
            'zone_id',
            'url_preview_param',
            'enabled'
        );
        foreach ($settings as $key) {
            if (isset($options[$key])) {
                $setting = $object->xpdo->getObject('modSystemSetting',array('key' => 'mcdn.'.$key));
                if ($setting != null) {
                    $setting->set('value',$options[$key]);
                    $setting->save();
                } else {
                    $object->xpdo->log(xPDO::LOG_LEVEL_ERROR,'[MaxCDN] '.$key.' setting could not be found, so the setting could not be changed.');
                }
            }
        }

        $success= true;
        break;
    case xPDOTransport::ACTION_UPGRADE:
    case xPDOTransport::ACTION_UNINSTALL:
        $success= true;
        break;
}
return $success;