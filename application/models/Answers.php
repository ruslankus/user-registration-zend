<?php

class Application_Model_Answers extends Abstract_Model
{

    public function __construct($id = null)
    {
        parent::__construct(new Application_Model_DbTable_Answers(), $id);
    }

}