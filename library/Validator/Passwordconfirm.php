<?php

class Validator_Passwordconfirm extends Zend_Validate_Abstract
{

    const NOT_MATCH = 'notMatch';

    protected $_messageTemplates = array(
        self::NOT_MATCH => 'Пароли не совпадают'
    );

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  mixed $value
     * @return boolean
     * @throws Zend_Validate_Exception If validation of $value is impossible
     */
    public function isValid($value, $context = null)
    {
        $value = (string)$value;

        if(is_array($context)) {
            if(isset($context['password'])  && $value == $context['password'] ){
                return true;

            }

        }elseif(is_string($context) && $value == $context ){
            return true;

        }else{

            $this->_error(self::NOT_MATCH);
            return false;

        }

    }
}