<?php

require_once dirname(__FILE__) . '/model/maxcdn/maxcdn.class.php';

/**
 * The main Manager Controller.
 * In this class, we define stuff we want on all of our controllers.
 */
abstract class MaxCDNManagerController extends modExtraManagerController {
    /** @var MaxCDN $mcdn */
    public $mcdn = null;

    /**
     * Initializes the main manager controller. In this case we set up the
     * MaxCDN class and add the required javascript on all controllers.
     */
    public function initialize() {
        /* Instantiate the class in the controller */
        $this->mcdn = new MaxCDN($this->modx);

        /* Add the main javascript class and our configuration */
        $this->addJavascript($this->mcdn->config['jsUrl'].'mgr/maxcdn.class.js');
        $this->addCss($this->mcdn->config['cssUrl'].'mgr/maxcdn.css');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            MaxCDN.config = '.$this->modx->toJSON($this->mcdn->config).';
        });
        </script>');
    }

    /**
     * Defines the lexicon topics to load in our controller.
     * @return array
     */
    public function getLanguageTopics() {
        return array('maxcdn:default');
    }

    /**
     * We can use this to check if the user has permission to see this
     * controller. We'll apply this in the admin section.
     * @return bool
     */
    public function checkPermissions() {
        return true;
    }
}

/**
 * The Index Manager Controller is the default one that gets called when no
 * action is present. It's most commonly used to define the default controller
 * which then hands over processing to the other controller ("home").
 */
class IndexManagerController extends MaxCDNManagerController {
    /**
     * Defines the name or path to the default controller to load.
     * @return string
     */
    public static function getDefaultController() {
        return 'home';
    }
}
