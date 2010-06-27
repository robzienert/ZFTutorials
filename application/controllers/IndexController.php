<?php
class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
    }
    
    public function pageAction()
    {
        if ($this->_hasParam('slug')) {
            // If we get a slug param, then it's time to go searching for our
            // static page. We wrap it in a try/catch and do a simple check for
            // whether or not the view script was found. If it wasn't, then we
            // just ignore the exception and send the user onto the error_handler
            try {
                $page = strtolower($this->_getParam('slug'));
                $this->render($page);
                return;
            } catch (Zend_View_Exception $e) {
                // Simple check for the view being unable to find the page that
                // is being requested. If we don't have a match, then throw the
                // original exception.
                if (false === strpos($e->getMessage(), 'not found in path')) {
                    throw $e;
                }
            }
        }

        // We're artificially invoking an Exception here so that the error
        // controller can handle it as it wants. It's almost too easy.
        $error = new stdClass();
        $error->type = Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION;
        $error->exception = new Zend_Controller_Action_Exception(
                'The page you are looking for does not exist', 404);
        $error->request = clone $this->getRequest();
        
        $this->getRequest()->setParam('error_handler', $error);
        
        $this->_forward('error', 'error');
    }
}

