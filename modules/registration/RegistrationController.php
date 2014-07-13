<?php

class RegistrationController extends Socnet_Controller_Action{

	  public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()){
    	parent::__construct($request, $response, $invokeArgs);
    	$this->params = $this->_getAllParams();
    	$this->_page->setTitle(Socnet::t('Регистрация'));
    	$this->_page->setFeed(Socnet::t('Регистрация'));
    }

    public function indexAction(){
      include_once('action.index.php');
    }

    public function completedAction(){
      include_once('action.completed.php');
    }

    public function registrationcompletedAction(){
      include_once('action.registrationcompleted.php');
    }

    public function confirmAction(){
      include_once('action.confirm.php');
    }

    public function confirmcompletedAction(){
      include_once('action.confirmcompleted.php');
    }

    public function pswdstrengthAction(){
      include_once('action.pswdstrength.php');
    }
}

