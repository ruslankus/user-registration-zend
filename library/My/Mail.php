<?php

class My_Mail extends Zend_Mail
{
    public function __construct($charset = 'utf-8')
    {
        parent::__construct($charset);
        $this->setFrom('noreply@monomobi.com','Monomobi confirm registration ');
    }


    public function setBodyView($script, $params = [])
    {
        $layout = new Zend_Layout(
            ['layoutPath' => APPLICATION_PATH . '/layouts' ]
        );

        $layout->setLayout('email');

        $view = new Zend_View();
        $view->setScriptPath(APPLICATION_PATH . '/views/email');

        foreach($params as $key => $value){
            $view->assign($key,$value);
        }

        $layout->content = $view->render($script. '.phtml');
        $html = $layout->render();
        $this->setBodyHtml($html);

        return $this;
    }
}