<?php

class QuestionController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $db = Zend_Registry::get('db1');
        $select = $db->select();
        $select->from(['q' => 'questions'])
            ->join(['u' => 'user'],'q.author_id = u.id', 'username')
            ->joinLeft(['a' => 'answers'], 'a.question_id = q.id', ['answers_count' => 'COUNT(a.id)'])
            ->group('q.id');



        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));

        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(1);

        $this->view->paginator = $paginator;

    }


    public function addAction()
    {

        $form = new Application_Form_QuestionAdd();
        $request = $this->getRequest();

        if($request->isPost()){

            if($form->isValid($request->getPost())){

                $questionModel = new Application_Model_Question();
                $questionModel->fill($form->getValues());
                $questionModel->created = date('Y-m-g H:t:s');
                //zapolniaem is sessii
                $questionModel->author_id = Zend_Auth::getInstance()->getIdentity()->id;

                $questionModel->save();
                $this->forward('index');
            }

        }


        $this->view->form = $form;
        $this->render();

    }//add


    public function viewAction()
    {
        $questionId = (int)$this->_getParam('id');

        $questionModel = new Application_Model_Question($questionId);
        $form = new Application_Form_AnswerAdd();
        $request = $this->getRequest();

        if($request->isPost()){

            $postData = $request->getPost();

            if($form->isValid($postData)){

                $answerModel = new Application_Model_Answers();
                $answerModel->fill($form->getValues());
                $answerModel->created = date('Y-m-g H:t:s');
                //zapolniaem is sessii
                $answerModel->author_id = Zend_Auth::getInstance()->getIdentity()->id;
                $answerModel->question_id = $questionId;

                $answerModel->save();
                $this->_helper->redirector->gotoSimple('view', null,null,['id' => $questionId]);
            }

        }


        $this->view->question = $questionModel;
        $this->view->author = $questionModel->getAuthor();
        $this->view->answers = $questionModel->getAnswers();
        $this->indentity = Zend_Auth::getInstance()->getIdentity();
        $this->view->form = $form;

    }



}

