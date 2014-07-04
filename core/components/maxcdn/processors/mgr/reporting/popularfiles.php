<?php
$files = array();
$data = $modx->cacheManager->get('popularfiles_monthly', $modx->mcdn->cacheOptions);
if (!$data) {
    if ($modx->mcdn->authenticate()) {
        $zone = $modx->getOption('mcdn.zone_id', null, '');
        $stats = $modx->mcdn->api->get('/reports/' . $zone . '/popularfiles.json', array(
            'date_from' => date('Y-m-d', strtotime('-1 month')),
            'date_to' => date('Y-m-d'),
            'page_size' => 20
        ));
        $data = $modx->fromJSON($stats);
        if (is_array($data)) {
            $modx->cacheManager->set('popularfiles_monthly', $data, 300, $modx->mcdn->cacheOptions);
        }
    }
}

foreach ($data['data']['popularfiles'] as $obj) {
    $files[] = array($obj['uri'],(int)$obj['hit']);
}

$stats = array(
    'cols' => array(
        array('type' => 'string','name' => $modx->lexicon('mcdn.reporting_uri')),
        array('type' => 'number','name' => $modx->lexicon('mcdn.reporting_hits'))
    ),
    'rows' => $files
);

return $modx->toJSON($stats);