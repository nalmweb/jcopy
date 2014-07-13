<?php
/*
 * Created on 29.01.2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class ErrorController extends Socnet_Controller_Action
 {
	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
    	parent::__construct($request, $response, $invokeArgs);  
        $this->_page->Template->assign('menuContent','_design/menu_content/menu_content.tpl');
        $this->params = $this->_getAllParams();
	    $this->_page->Template->assign('controller', 'main');
    }
    
    public function indexAction ()
    {
  	  include_once('action.index.php');
    }
    
    public function registrationAction ()
    {
  	  include_once('action.register.php');
    }
    
    public function infoAction (){
  	  include_once('action.info.php');
    }
    
    public function cantuploadAction (){
  	  include_once('action.cantupload.php');
    }
 } 
?>
