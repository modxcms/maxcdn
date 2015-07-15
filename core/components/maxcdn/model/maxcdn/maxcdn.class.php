<?php
class MaxCDN {
    /**
     * @var modX|null $modx
     */
    public $modx = null;
    /**
     * @var NetDNA|null $api
     */
    public $api = null;
    /**
     * @var array
     */
    public $config = array();
    /**
     * @var bool
     */
    public $debug = false;
    /**
     * @var array
     */
    public $cacheOptions = array(
        xPDO::OPT_CACHE_KEY => 'maxcdn',
    );


    /**
     * @param \modX $modx
     * @param array $config
     */
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('mcdn.core_path',$config,$this->modx->getOption('core_path').'components/maxcdn/');
        $assetsUrl = $this->modx->getOption('mcdn.assets_url',$config,$this->modx->getOption('assets_url').'components/maxcdn/');
        $assetsPath = $this->modx->getOption('mcdn.assets_path',$config,$this->modx->getOption('assets_path').'components/maxcdn/');
        $this->config = array_merge(array(
            'basePath' => $corePath,
            'corePath' => $corePath,
            'modelPath' => $corePath.'model/',
            'processorsPath' => $corePath.'processors/',
            'elementsPath' => $corePath.'elements/',
            'templatesPath' => $corePath.'templates/',
            'assetsPath' => $assetsPath,
            'jsUrl' => $assetsUrl.'js/',
            'cssUrl' => $assetsUrl.'css/',
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl.'connector.php',
        ),$config);

        $modelPath = $this->config['modelPath'];
        $this->modx->addPackage('maxcdn',$modelPath, '');
        $this->modx->lexicon->load('maxcdn:default');
        $this->debug = (bool)$this->modx->getOption('mcdn.debug',null,false);
        $this->autoload();
    }

    public function autoload() {
        require_once $this->config['corePath'].'model/vendor/autoload.php';
    }

    public function authenticate() {
        $alias = $this->modx->getOption('mcdn.alias', null, '');
        $consumerKey = $this->modx->getOption('mcdn.consumer_key', null, '');
        $consumerSecret = $this->modx->getOption('mcdn.consumer_secret', null, '');
        if (!empty($alias) && !empty($consumerKey) && !empty($consumerSecret)) {
            $this->api = new NetDNA($alias, $consumerKey, $consumerSecret);
            return true;
        }
        return false;
    }

    public function isDisabled($checkTV = false) {
        if ($this->modx->getOption('mcdn.enabled', null, false) == false) {
            return true;
        }
        if ($checkTV) {
            $tvName = $this->modx->getOption('mcdn.resource_inclusion_tv', null, '');
            if (!empty($tvName) && $this->modx->resource !== null) {
                $include = $this->modx->resource->getTVValue($tvName);
                if (!$include) {
                    return true;
                }
            }
        }
        return false;
    }

    public function purge($params = array()) {
        $zone = $this->modx->getOption('mcdn.zone_id', null, '');
        if ($this->api == null) {
            $this->authenticate();
        }
        if (!empty($params)) {
            return $this->api->delete('/zones/pull.json/' . $zone . '/cache', $params);
        } else {
            return $this->api->delete('/zones/pull.json/' . $zone . '/cache');
        }
    }

    public function purgeFile($file) {
        $params = array(
            'file' => $file
        );
        return $this->purge($params);
    }

    public function purgeFiles($files) {
        $params = array(
            'files' => $files
        );
        return $this->purge($params);
    }
}

