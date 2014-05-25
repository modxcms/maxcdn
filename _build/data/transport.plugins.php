<?php
$plugins = array();

/* create the plugin object */
$plugins[0] = $modx->newObject('modPlugin');
$plugins[0]->set('id',1);
$plugins[0]->set('name','MaxCDN Manager');
$plugins[0]->set('description','Provides manager functionality for resources if resources are being cached to MaxCDN.');
$plugins[0]->set('plugincode', getSnippetContent($sources['plugins'] . 'maxcdn.plugin.php'));
$plugins[0]->set('category', 0);
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        $plugins[0]->set('disabled', 1);
        break;
    default:
        break;
}

$events = include $sources['events'].'events.maxcdn.php';
if (is_array($events) && !empty($events)) {
    $plugins[0]->addMany($events);
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events for MaxCDN.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events for MaxCDN!');
}
unset($events);

/* create the plugin object */
$plugins[1] = $modx->newObject('modPlugin');
$plugins[1]->set('id',1);
$plugins[1]->set('name','MaxCDN Linker');
$plugins[1]->set('description','Rewrites frontend links based on MaxCDN Rules specified in the MaxCDN component.');
$plugins[1]->set('plugincode', getSnippetContent($sources['plugins'] . 'maxcdnlinker.plugin.php'));
$plugins[1]->set('category', 0);

$events = include $sources['events'].'events.maxcdnlinker.php';
if (is_array($events) && !empty($events)) {
    $plugins[1]->addMany($events);
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events for MaxCDN Linker.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events for MaxCDN Linker!');
}
unset($events);

return $plugins;
