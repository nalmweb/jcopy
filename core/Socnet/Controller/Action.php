<?php

abstract class Socnet_Controller_Action extends Zend_Controller_Action
{

    public $_page;
    protected $_db;
    public $_params;
    //protected $_session;

    public function __construct(Zend_Controller_Request_Abstract  $request, 
    							Zend_Controller_Response_Abstract $response,
    							array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);
        
        $this->_page = Zend_Registry::get("Page");
        $this->_db   = Zend_Registry::get("DB");
        //$this->_params = $this->_getAllParams();
        //$this->_session = Zend_Registry::get("Session");
    }


    public function _redirectError($message = "Error Occured")
    {
        $this->_page->Template->assign('message', $message);
        $this->_page->Template->assign('bodyContent', 'customerror.tpl');
        $this->_page->Template->render($this->_page->Template->layout); exit;
    }
    
}

?>
