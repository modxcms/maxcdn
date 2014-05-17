<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('mcdn.core_path',null,$modx->getOption('core_path').'components/maxcdn/');
require_once $corePath.'model/maxcdn/maxcdn.class.php';
$modx->mcdn = new MaxCDN($modx);

$modx->lexicon->load('maxcdn:default');

/* handle request */
$path = $modx->getOption('processorsPath',$modx->mcdn->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));