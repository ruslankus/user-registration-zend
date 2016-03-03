<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract
{

    protected $_name = 'user';
    protected $_primary = 'id';
    protected $_dependentTables = [
        'Application_Model_DbTable_Questions','Application_Model_DbTable_Answers'

    ];
    //protected $_schema = 'zend-local';


    protected function _setupDatabaseAdapter()
    {
        //$cache = Zend_Registry::get('cache');
        //$cache->remove(md5(null));
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $multidb = $bootstrap->getPluginResource('multidb');
        $this->_db = Zend_Registry::get('db1');

    }



}

