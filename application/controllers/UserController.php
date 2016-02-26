<?php

class UserController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $this->view->title = "Список юзеров";
        $this->view->headTitle($this->view->title, 'PREPEND');

        $userModel = new Application_Model_User();

        $this->view->users = $userModel->getAllUsers();

    }


    public function addAction()
    {
        $this->view->title = "Добавить юзеров";
        $this->view->headTitle($this->view->title, 'PREPEND');

        $form = new Application_Form_User();

        $request = $this->getRequest();

        if($request->isPost()){

            $data = $request->getPost();
            if($form->isValid($data)){

                $userModel = new Application_Model_User();
                $userModel->fill($form->getValues());
                $userModel->password = sha1($userModel->password);
                $userModel->created = date('Y-m-g H:t:s');
                $userModel->save();

                $this->_helper->redirector('index');
            }

        }

        $this->view->form = $form;


    }//addAction


    public function deleteAction()
    {
        //$this->view->title = "Добавить юзеров";
        //$this->view->headTitle($this->view->title, 'PREPEND');
        $id = $this->_getParam('id');
        $userModel = new Application_Model_User((int)$id);
        $userModel->delete();
        $this->_helper->redirector('index');

    }//deleteaction



    public function viewAction()
    {
        $this->view->title = "Детали юзера";
        $this->view->headTitle($this->view->title, 'PREPEND');

        $id = $this->_getParam('id');
        $userModel = new Application_Model_User((int)$id);

        $this->view->user = $userModel;

    }//viewAction


    public function editAction()
    {
        $this->view->title = "Редактирование юзера";
        $this->view->headTitle($this->view->title, 'PREPEND');

        $request = $this->getRequest();
        $id = $this->_getParam('id');
        $userModel = new Application_Model_User($id);
        $form = new Application_Form_User();

        if($request->isPost()){
            $data = $request->getPost();
            if($form->isValid($data)) {

                $userModel->fill($form->getValues());
                $userModel->password = sha1($userModel->password);
                $userModel->modified = date('Y-m-g H:t:s');
                $userModel->save();

                $this->_helper->redirector('index');
            }

        }else{
            $form->populate($userModel->populateForm());
        }

        $this->view->form = $form;
    }//editAction


    public function registerAction()
    {
        $this->view->title = "Регистрация юзеров";
        $this->view->headTitle($this->view->title, 'PREPEND');

        $form = new Application_Form_Register();

        $request = $this->getRequest();

        if($request->isPost()){

            $data = $request->getPost();
            if($form->isValid($data)){

                $userModel = new Application_Model_User();
                $userModel->fill($form->getValues());
                $userModel->password = sha1($userModel->password);
                $userModel->code = uniqid();
                $userModel->created = date('Y-m-g H:t:s');
                $userModel->save();
                $userModel->sendActivationEmail();
                $this->_helper->redirector('index');
            }

        }

        $this->view->form = $form;

    }//registerAction


    public function confirmAction(){

        $user_id = $this->_getParam('id');
        $code = $this->_getParam('code');

        $userModel = new Application_Model_User($user_id);

        if($userModel->activated){
            $this->view->message = 'Ваш аккаунт уже активирован';
        }else{
            if($userModel->code == $code){
                $userModel->activated = true;
                $userModel->save();
                $this->view->message = 'Ваш аккаунт активирован';

            }else{
                $this->view->message = 'Неправильные данные активации';
            }


        }
    }


}