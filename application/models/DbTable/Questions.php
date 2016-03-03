<?php

class Application_Model_DbTable_Questions extends Zend_Db_Table_Abstract
{

    protected $_name = 'questions';
    protected $_dependentTables =  ['Application_Model_DbTable_Answers'];
    protected $_referenceMap = [
        'User' => [
            'columns' => 'author_id',
            'refTableClass' => 'Application_Model_DbTable_User',
            'refColumns' => 'id',
            'onDelete' => self::CASCADE
        ]
    ];


}

