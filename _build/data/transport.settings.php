<?php

$s = array(
    //'admin_groups' => 'Administrator',
    //'clear_cache' => true,
);

$settings = array();

foreach ($s as $key => $value) {
    if (is_string($value) || is_int($value)) { $type = 'textfield'; }
    elseif (is_bool($value)) { $type = 'combo-boolean'; }
    else { $type = 'textfield'; }

    $parts = explode('.',$key);
    if (count($parts) == 1) { $area = 'Default'; }
    else { $area = $parts[0]; }
    
    $settings['mcdn.'.$key] = $modx->newObject('modSystemSetting');
    $settings['mcdn.'.$key]->set('key', 'mcdn.'.$key);
    $settings['mcdn.'.$key]->fromArray(array(
        'value' => $value,
        'xtype' => $type,
        'namespace' => 'mcdn',
        'area' => $area
    ));
}

return $settings;


