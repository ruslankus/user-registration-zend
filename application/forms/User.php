<?php

class Application_Form_User extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setName('form_user');

        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Имя пользователя')->setRequired(true);
        $username->addValidator('NotEmpty')->addValidator('Alnum');
        //$username->addFilter('StringTrim');


        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Пароль')->setRequired(true);


        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')->setRequired(true);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Сохранить');

        $this->addElements([$username,$password,$email,$submit]);
    }


}

