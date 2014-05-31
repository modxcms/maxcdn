<?php
/**
 * Purge Files from MaxCDN
 */
class filesPurgeProcessor extends modProcessor {
    public $languageTopics = array('maxcdn:default');

    public function process() {
        $response = null;
        if ($this->modx->mcdn->authenticate()) {
            if ($this->getProperty('purge_all') == 'true') {
                $response = $this->modx->mcdn->purge();
            } else {
                $files = explode("\n", $this->getProperty('purge_files'));
                foreach ($files as $k => $v) {
                    if (empty($v)) unset($files[$k]);
                }
                if (!empty($files)) {
                    $response = $this->modx->mcdn->purgeFiles($files);
                }
            }
        } else {
            return $this->modx->error->failure($this->modx->lexicon('mcdn.purge_request_no_auth'));
        }

        if ($response == null) {
            return $this->modx->error->failure($this->modx->lexicon('mcdn.purge_nothing_found'));
        } else {
            $response = $this->modx->fromJSON($response);
            if ($response['code'] !== 200) {
                return $this->modx->error->failure($response['error']['type']. ': ' .$response['error']['message']);
            }
            return $this->modx->error->success($this->modx->lexicon('mcdn.purge_request_sent'));
        }
    }
}
return 'filesPurgeProcessor';