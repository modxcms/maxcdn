<?php
/**
 * Updates a mcdnRule object
 */
class mcdnRuleUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'mcdnRule';
    public $languageTopics = array('maxcdn:default');

    /**
     * Before setting, we check if the name is filled and/or already exists. Also checkboxes.
     * @return bool
     */
    public function beforeSet() {
        $key = $this->getProperty('name');
        if (empty($key)) {
            $this->addFieldError('name',$this->modx->lexicon('mcdn.error.name_not_set'));
        }

        return parent::beforeSet();
    }
}
return 'mcdnRuleUpdateProcessor';
