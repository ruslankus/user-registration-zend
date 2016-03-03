<?php

class Application_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{

    private  $_role = 'guest';

    private $_controller = [
        'controller' => 'error',
        'action' => 'denied'
    ];


    public function __construct()
    {

        $acl = new Zend_Acl();

        //roles
        $acl->addRole(new Zend_Acl_Role('guest'));
        $acl->addRole(new Zend_Acl_Role('user'),'guest');
        $acl->addRole(new Zend_Acl_Role('admin'));

        //resources - na cho deistvujet
        $acl->addResource(new Zend_Acl_Resource('user'));
        $acl->addResource(new Zend_Acl_Resource('index'));

        //permissions
        $acl->deny();
        $acl->allow('admin',null);
        //guest right
        $acl->allow('guest','user',['login','confirm','register']);

        $acl->allow('user','user',['logout','confirm']);
        $acl->allow('guest','index');

        Zend_Registry::set('acl',$acl);

    }


    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $auth = Zend_Auth::getInstance();
        $acl = Zend_Registry::get('acl');


        if($auth->hasIdentity()){
            $this->_role = $auth->getIdentity()->role;
        }

        $controller = $request->controller;
        $action = $request->action;

        if(!$acl->has($controller)){
            $controller = null;
        }

        //esli zapresheno podmeniaem kontroller
        if(!$acl->isAllowed($this->_role,$controller,$action))
        {
            $request->setControllerName($this->_controller['controller']);
            $request->setActionName($this->_controller['action']);
        }


    }
}