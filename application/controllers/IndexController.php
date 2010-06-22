<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->addHelperPath('Zfx/View/Helper', 'Zfx_View_Helper');
        $registerForm = new Application_Form_Register();
        $this->view->registerForm = $registerForm;
    }


}

