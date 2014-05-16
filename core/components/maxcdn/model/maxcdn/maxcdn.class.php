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
        $this->modx->addPackage('maxcdn',$modelPath);
        $this->modx->lexicon->load('mcdn:default');
        $this->debug = (bool)$this->modx->getOption('mcdn.debug',null,false);
        $this->autoload();
    }

    protected function autoload() {
        require_once $this->corePath.'model/maxcdn/vendor/autoload.php';
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

    public function purge($params = array()) {
        $zone = $this->modx->getOption('mcdn.zone_id', null, '');
        if ($this->api == null) {
            $this->authenticate();
        }
        return $this->api->delete('zones/pull.json/' . $zone . '/cache/', $params);
    }

    public function purgeFile($file) {
        $params = array(
            'file' => $file
        );
        return $this->purge($zone, $params);
    }
}

