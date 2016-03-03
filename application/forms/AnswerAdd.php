<?php

class Application_Form_AnswerAdd extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setName('form_answer_add');



        $answer = new Zend_Form_Element_Textarea('answer');
        $answer->setLabel('Описание ответа')->setRequired(true);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Сохранить');

        $this->addElements([$answer,$submit]);
    }


}

