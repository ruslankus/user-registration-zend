<?php

class Application_Model_Question extends Abstract_Model
{
    public function __construct($id = null)
    {
        parent::__construct(new Application_Model_DbTable_Questions() , $id);
    }


    public function getAuthor()
    {
        return $this->_row->findParentRow(new Application_Model_DbTable_User(),'User');
    }

    public function getAnswers()
    {
        return $this->_row->findDependentRowset(new Application_Model_DbTable_Answers(),'Question');
    }
}