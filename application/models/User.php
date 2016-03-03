<?php

class Application_Model_User extends Abstract_Model
{


    public function __construct($id = null)
    {
        parent::__construct(new Application_Model_DbTable_User(), $id);
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
        $mail->send();
    }


    public function authorize($username, $password){

        $auth = Zend_Auth::getInstance();

        $authAdapter = new Zend_Auth_Adapter_DbTable(

            Zend_Db_Table::getDefaultAdapter(),'user','username','password','SHA1(?)'
        );

        $authAdapter->setIdentity($username)->setCredential($password);
        //peredajem auth adapter
        $result = $auth->authenticate($authAdapter);


        if($result->isValid()){

            $storage = $auth->getStorage();

            $storage->write($authAdapter->getResultRowObject(null,['password']));

            return true;
        }

        return false;

    }//authorize


}
