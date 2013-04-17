<?php
class sfValidatorStringAlphabet extends sfValidatorString
{
    protected function doClean($value)
    {
        if(!preg_match("/^[a-z]*$/i", $value)){
            throw new sfValidatorError($this, 'разрешены только латинские символы.', array('value' => $value));
        }

        return parent::doClean($value);
    }
}