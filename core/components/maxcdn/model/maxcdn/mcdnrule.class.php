<?php
class mcdnRule extends xPDOSimpleObject {
    public function getRegex() {
        return '/'.str_replace('/','\/',$this->get('input')).'/i';
    }
}