<?php
/**
 * Gets a list of CDN URLs from MaxCDN.
 */
class comboCDNGetListProcessor extends modProcessor {
    public $languageTopics = array('maxcdn:default');

    public function process() {
        $list = array();

        $defaultCDN = $this->modx->getOption('mcdn.default_cdn_url', null, '');
        if (!empty($defaultCDN)) {
            $list[]['cdn_url'] = 'http://'.$defaultCDN.'/';
        }

        if($this->modx->mcdn->authenticate()) {
            $zone = $this->modx->getOption('mcdn.zone_id', null, '');
            $response = $this->modx->mcdn->api->get('/zones/pull/' . $zone . '/customdomains.json');
            $domains = $this->modx->fromJSON($response);

            foreach ($domains['data']['customdomains'] as $domain) {
                $list[]['cdn_url'] = 'http://'.$domain['custom_domain'].'/';
            }
        }
        return $this->outputArray($list, count($list));
    }
}
return 'comboCDNGetListProcessor';
