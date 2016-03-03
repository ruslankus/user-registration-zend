<?php

class Application_Model_DbTable_Answers extends Zend_Db_Table_Abstract
{

    protected $_name = 'answers';

    protected $_referenceMap = [
        'User' => [
            'columns' => 'author_id',
            'refTableClass' => 'Application_Model_DbTable_User',
            'refColumns' => 'id',
            'onDelete' => self::CASCADE
        ],

        'Question' => [
            'columns' => 'question_id',
            'refTableClass' => 'Application_Model_DbTable_Questions',
            'refColumns' => 'id',
            'onDelete' => self::CASCADE

        ]
    ];


}

