<?php
$success= false;
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        $settings = array(
            'alias',
            'consumer_key',
            'consumer_secret',
            'zone_id',
            'default_cdn_url',
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

        if ($options['rules'] == 1) {
            $modelPath = $modx->getOption('mcdn.core_path',null,$modx->getOption('core_path').'components/maxcdn/').'model/';
            $modx->addPackage('maxcdn',$modelPath, '');

            $rules = array();
            $rules['site_url'] = array(
                'name' => 'Site URL src and href links',
                'description' => 'Replace src and href links that start with the site URL',
                'content_type' => 1,
                'all_contexts' => 1,
                'input' => '((?:<(?:a|link|img|script)\b)[^>]*?(?:href|src)=")(?:{site_url})(.*?\.(?:jpe?g|png|gif|ttf|otf|svg|woff|xml|js|css).*?")',
                'output' => '{match1}{cdn_url}{match2}',
                'scheme' => 'http://',
                'cdn_url' => !empty($options['default_cdn_url']) ? $options['default_cdn_url'] : '',
                'sortorder' => 0,
                'disabled' => 0
            );
            $rules['base_url'] = array(
                'name' => 'Base URL src and href links',
                'description' => 'Replace src and href links that start with the base URL',
                'content_type' => 1,
                'all_contexts' => 1,
                'input' => '((?:<(?:a|link|img|script)\b)[^>]*?(?:href|src)=")(?:{base_url})(.*?\.(?:jpe?g|png|gif|ttf|otf|svg|woff|xml|js|css).*?")',
                'output' => '{match1}{cdn_url}{match2}',
                'scheme' => 'http://',
                'cdn_url' => !empty($options['default_cdn_url']) ? $options['default_cdn_url'] : '',
                'sortorder' => 1,
                'disabled' => 0
            );
            $rules['relative_url'] = array(
                'name' => 'Relative URL src and href links',
                'description' => 'Replace relative src and href links',
                'content_type' => 1,
                'all_contexts' => 1,
                'input' => '((?:<(?:a|link|img|script)\b)[^>]*?(?:href|src)=")(?!(?:https?|/))(.*?\.(?:jpe?g|png|gif|ttf|otf|svg|woff|xml|js|css).*?")',
                'output' => '{match1}{cdn_url}{match2}',
                'scheme' => 'http://',
                'cdn_url' => !empty($options['default_cdn_url']) ? $options['default_cdn_url'] : '',
                'sortorder' => 2,
                'disabled' => 0
            );
            foreach ($rules as $rule) {
                $obj = $object->xpdo->newObject('mcdnRule', $rule);
                $obj->save();
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