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

                $userModel = new Application_Model_Temp();


                $userModel->fill($form->getValues());
                $userModel->password = sha1($userModel->password);
                $userModel->code = uniqid();
                $userModel->created = date('Y-m-g H:t:s');
                $userModel->save();
                $result =  $userModel->sendActivationEmail();

                $this->view->message = ($result)? 'Activation letter sent' : 'sent letter failed';

                $this->_helper->viewRenderer('user/sent', null, true);

                //$this->_helper->redirector('index');
            }

        }

        $this->view->form = $form;

    }//registerAction


    public function confirmAction(){

        $user_id = (int)$this->_getParam('id');
        $code = $this->_getParam('code');

        if(!empty($user_id)) {

            $userTmpModel = new Application_Model_Temp($user_id);


            if ($userTmpModel->code == $code){

                $userModel = new Application_Model_User();

                $data = $userTmpModel->populateForm();
                unset($data['id'], $data['activated'], $data['created']);

                $userModel->fill($data);
                $userModel->created = date('Y-m-g H:t:s');
                $userModel->activated = true;
                $userModel->save();

                $this->view->message = "Регистрация завершина";

                $this->render();
                //die();
            }else {

                $this->view->message = 'Неправильные данные активации';
                $this->render();
            }
        }else{
            $this->view->message = 'Неправильные данные активации - не правильный емайл';
        }

    }



    public function loginAction()
    {

        $form = new Application_Form_Login();

        $request = $this->getRequest();

        if($request->isPost() && $form->isValid($request->getPost())){

            $username = $request->getPost('username');
            $pass = $request->getPost('password');
            //authorization
            $userModel = new Application_Model_User();
            $result = $userModel->authorize($username,$pass);
            if($result){
                $this->_helper->redirector('login');
            }else{
                $this->view->message = 'Неверные данные авторизации';
            }


        }

        $this->view->form = $form;
        $this->render();
    }


    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_helper->redirector('login');
    }


}