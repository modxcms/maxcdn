<?php
class mcdnRule extends xPDOSimpleObject {
    public function getRegex() {
        $siteUrl = $this->xpdo->getOption('site_url');
        $baseUrl = $this->xpdo->getOption('base_url');
        $input = $this->get('input');
        $input = str_replace(array('{site_url}', '{base_url}'), array($siteUrl, $baseUrl), $input);

        return '/'.str_replace('/','\/',$input).'/i';
    }

    public function getCdnUrl() {
        return $this->get('scheme').$this->get('cdn_url').'/';

    }
}