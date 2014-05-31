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
$cacheMisses = $data['data']['summary']['noncache_hit'];

$hits[] = array(
    'c' => array(
        array(
            'v' => $modx->lexicon('mcdn.reporting_cache_hits')
        ),
        array(
            'v' => (int)$cacheHits
        )
    )
);
$hits[] = array(
    'c' => array(
        array(
            'v' => $modx->lexicon('mcdn.reporting_non_cache_hits')
        ),
        array (
            'v' => (int)$cacheMisses
        )
    )
);

$stats = array(
    'cols' => array(
        array(
            'id' => '',
            'label' => $modx->lexicon('mcdn.reporting_cache_hit_state'),
            'pattern' => '',
            'type' => 'string'
        ),
        array(
            'id' => '',
            'label' => $modx->lexicon('mcdn.reporting_number'),
            'pattern' => '',
            'type' => 'number'
        )
    ),
    'rows' => $hits
);

return $modx->toJSON($stats);
