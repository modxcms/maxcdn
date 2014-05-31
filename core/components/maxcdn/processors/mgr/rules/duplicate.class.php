<?php
/**
 * Duplicates a mcdnRule object
 */
class mcdnRuleDuplicateProcessor extends modObjectDuplicateProcessor {
    public $classKey = 'mcdnRule';
    public $languageTopics = array('maxcdn:default');

    public function getNewName() {
        $newName = $this->modx->lexicon('mcdn.duplicate_of') . $this->object->get('name');
        return $newName;
    }

    /**
     * Before saving, we disable the duplicated rule.
     * @return bool
     */
    public function beforeSave() {
        $this->newObject->set('disabled', true);
        return parent::beforeSave();
    }
}
return 'mcdnRuleDuplicateProcessor';
