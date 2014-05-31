<?php
/**
 * The name of the controller is based on the path (home) and the
 * namespace. This home controller is the main client view.
 */
class MaxCDNHomeManagerController extends MaxCDNManagerController {
    /**
     * Any specific processing we need on the Home controller.
     * @param array $scriptProperties
     */
    public function process(array $scriptProperties = array()) {
    }

    /**
     * The pagetitle to put in the <title> attribute.
     * @return null|string
     */
    public function getPageTitle() {
        return $this->modx->lexicon('mcdn');
    }

    /**
     * Register all the needed javascript files. Using this method, it will automagically
     * combine and compress them if enabled in system settings.
     */
    public function loadCustomCssJs() {
        $this->addHtml('<script type="text/javascript" src="https://www.google.com/jsapi"></script>');
        $this->addJavascript($this->mcdn->config['jsUrl'].'mgr/widgets/combos.js');
        $this->addJavascript($this->mcdn->config['jsUrl'].'mgr/widgets/rules.windows.js');
        $this->addJavascript($this->mcdn->config['jsUrl'].'mgr/widgets/rules.grid.js');
        $this->addLastJavascript($this->mcdn->config['jsUrl'].'mgr/sections/home.js');
        $this->addLastJavascript($this->mcdn->config['jsUrl'].'mgr/maxcdn.reporting.js');
    }

    /**
     * The name for the template file to load.
     * @return string
     */
    public function getTemplateFile() {
        return $this->mcdn->config['templatesPath'].'home.tpl';
    }
}
