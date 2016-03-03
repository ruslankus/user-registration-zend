<?php

class Application_Form_QuestionAdd extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setName('form_question_add');

        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Название вопроса')->setRequired(true);

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Описание вопроса')->setRequired(true);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Сохранить');

        $this->addElements([$title,$description,$submit]);
    }


}

