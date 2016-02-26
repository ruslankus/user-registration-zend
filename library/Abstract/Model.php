<?php

class Abstract_Model
{
    protected $_dbTable;
    protected $_row;

    public function __construct(Zend_Db_Table_Abstract $dbTable, $id = null)
    {
        $this->_dbTable = $dbTable;

        if(!empty($id)){
            $this->_row = $this->_dbTable->find($id)->current();
        }else{
            $this->_row = $this->_dbTable->createRow();
        }
    }


    public function getAll(){
        return $this->_dbTable->fetchAll();
    }


    public function __set($name, $value)
    {
        if(isset($this->_row->$name)){
            $this->_row->$name = $value;
        }
    }


    public function __get($name)
    {
        return (isset($this->_row->$name))? $this->_row->$name : null;
    }


    public function fill($data){

        foreach($data as $key => $value){
            if(isset($this->_row->$key)){
                $this->_row->$key = $value;
            }
        }
    }


    /**
     *
     */
    public function save(){
        $this->_row->save();
    }


    public function delete(){
        $this->_row->delete();
    }
}