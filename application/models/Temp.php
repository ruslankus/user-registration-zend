<?php

class Application_Model_Temp extends Abstract_Model
{


    public function __construct($id = null)
    {
        parent::__construct(new Application_Model_DbTable_Temp(), $id);
    }


    public function getAllUsers(){
        return $this->_dbTable->fetchAll();
    }


    public function populateForm()
    {
        return $this->_row->toArray();
    }


    public function sendActivationEmail()
    {
        $mail = new My_Mail();
        $mail->addTo($this->_row->email);
        $mail->setSubject('Activation');
        $mail->setBodyView('activation',['user' => $this]);
        $result = $mail->send();

        return $result;
    }


}
