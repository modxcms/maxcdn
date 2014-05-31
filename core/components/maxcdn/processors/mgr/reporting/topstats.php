<?php
$hits = array();
$stats = array();
$data = $modx->cacheManager->get('stats.daily', $modx->mcdn->cacheOptions);
if (!$data) {
    if ($modx->mcdn->authenticate()) {
        $zone = $modx->getOption('mcdn.zone_id', null, '');
        $stats = $modx->mcdn->api->get('/reports/' . $zone . '/stats.json/daily', array(
            'date_from' => date('Y-m-d', strtotime('-1 month')),
            'date_to' => date('Y-m-d')
        ));
        $data = $modx->fromJSON($stats);
        if (is_array($data)) {
            $modx->cacheManager->set('stats.daily', $data, 300, $modx->mcdn->cacheOptions);
        }
    }
}

$cacheHits = $data['data']['summary']['cache_hit'];
$nonCacheHits = $data['data']['summary']['noncache_hit'];
$bytesTransferred = $data['data']['summary']['size'];

return $modx->toJSON(array(
    'cache_hits' => number_format($cacheHits, 0),
    'non_cache_hits' => number_format($nonCacheHits, 0),
    'size' => number_format($bytesTransferred/1048576, 2)
));