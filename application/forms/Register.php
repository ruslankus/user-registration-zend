<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setName('form_user');

        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Имя пользователя')->setRequired(true);
        $username->addValidator('NotEmpty')->addValidator('Alnum');
        $username->addValidator('Db_NoRecordExists', false, [
            'table' => 'user','field' => 'username'
        ]);
        //$username->addFilter('StringTrim');


        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Пароль')->setRequired(true);

        $password_confirm = new Zend_Form_Element_Password('password_confirm');
        $password_confirm->setLabel('Введите пароль еще раз')->setRequired(true);
        $password_confirm->addPrefixPath('Validator','Validator','validate');
        $password_confirm->addValidator('Passwordconfirm');


        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')->setRequired(true);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Сохранить');

        $this->addElements([$username,$password,$password_confirm, $email,$submit]);
    }


}
