<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initAutoload()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Abstract_');
        $autoloader->registerNamespace('My_');
    }


    protected function _initViewHelper(){

        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();

        $view->headTitle('SimpleBlog');
        $view->headTitle()->setSeparator(" :: ");


    }//_initViewHelper


    protected function _initEmail()
    {
        $email_config = [

            'auth' => 'login',
            'username' => 'no-reply@prophp.eu',
            'password' => 'BlakuApykarstisNubraidinti',
            'port' => '465',
            'ssl' => 'ssl'

        ];

        $trs = new Zend_Mail_Transport_Smtp('dinodonas.serveriai.lt',$email_config);
        Zend_Mail::setDefaultTransport($trs);
    }

}



