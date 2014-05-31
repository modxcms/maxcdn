<?php
$data = $modx->cacheManager->get('nodes_monthy', $modx->mcdn->cacheOptions);
if (!$data) {
    if ($modx->mcdn->authenticate()) {
        $zone = $modx->getOption('mcdn.zone_id', null, '');
        $stats = $modx->mcdn->api->get('/reports/'.$zone.'/nodes.json/stats/monthly', array(
            'date_from' => date('Y-m-d', strtotime('-1 month')),
            'date_to' => date('Y-m-d')
        ));
        $data = $modx->fromJSON($stats);
        if (is_array($data)) {
            $modx->cacheManager->set('nodes_monthly', $data, 300, $modx->mcdn->cacheOptions);
        }
    }
}

$stats = array();
$stats[] = array($modx->lexicon('mcdn.reporting_location'),$modx->lexicon('mcdn.reporting_mb_transferred'));
foreach ($data['data']['stats'] as $obj) {
    $loc = $obj['pop_description'];
    $size = round(($obj['size']/1024)/1024, 2);
    if (array_key_exists($loc, $stats)) {
        $size = $stats[$loc][1] + $size;
    }
    $stats[$loc] = array($loc, $size);
}
$stats = array_values($stats);

return $modx->toJSON($stats);