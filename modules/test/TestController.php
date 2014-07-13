<?php

class TestController extends Socnet_Controller_Action
{
   public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
   {
        parent::__construct($request, $response, $invokeArgs);
        $this->params = $this->_getAllParams();
        $this->_page->setTitle(Socnet::t('ТЕст'));
    }

  // --->   	
  public function testMapAction() { include('action.testMap.php'); }
    
    
  // 
  public function testMap2Action() { include('action.testMap2.php'); }
  // public function setFilterAction( $params = array() ) {require_once 'action.ajax.setFilter.php'; return $objResponse;}
}