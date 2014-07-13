<?php

class ErrorController extends Socnet_Controller_Action
{
	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
    	parent::__construct($request, $response, $invokeArgs);
        $this->_page->setTitle(Socnet::t('Homepage'));
        $this->_page->Template->assign('menuContent', '_design/menu_content/menu_content.tpl');
    }

    public function errorAction()       {include_once('action.index.php');}

    public function noRouteAction()		{$this->_redirect('/'); }

}