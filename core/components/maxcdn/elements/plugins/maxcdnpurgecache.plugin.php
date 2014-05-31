<?php
$event = $modx->event->name;
switch ($event) {
    case 'OnSiteRefresh':
        $path = $modx->getOption('mcdn.core_path', null, $modx->getOption('core_path') . 'components/maxcdn/');
        $maxcdn = $modx->getService('maxcdn','MaxCDN', $path.'model/maxcdn/');

        if ($maxcdn->isDisabled()) {
            break;
        }

        $purgeCache = $modx->getOption('mcdn.purge_on_clear_cache', null, true);
        if ($purgeCache == false) {
            break;
        }

        if ($maxcdn->authenticate()) {
            $response = $maxcdn->purge();
            $response = $modx->fromJSON($response);
            if ($response['code'] !== 200) {
                $modx->log(modX::LOG_LEVEL_ERROR, $response['error']['type']. ': ' .$response['error']['message']);
            }
            $modx->log(modX::LOG_LEVEL_INFO, $modx->lexicon('mcdn.purge_request_sent'));
        } else {
            $modx->log(modX::LOG_LEVEL_ERROR, $modx->lexicon('mcdn.purge_request_no_auth'));
        }
        break;
    default:
        break;
}