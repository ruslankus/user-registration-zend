<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setName('form_login');

        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Имя пользователя')->setRequired(true);

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Пароль')->setRequired(true);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Войти');

        $this->addElements([$username,$password,$submit]);
    }


}

