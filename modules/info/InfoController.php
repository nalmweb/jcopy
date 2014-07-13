<?php

class InfoController extends Socnet_Controller_Action
{
	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
    	parent::__construct($request, $response, $invokeArgs);
    	$this->_page->setTitle(Socnet::t('Информация'));
    	$this->_page->Template->assign('menuContent', '_design/menu_content/menu_content.tpl');
    }

    public function indexAction()		{ $this->_redirect('/'); }

    public function feedbackAction()	{include_once('action.feedback.php');}
    public function aboutAction()		{include_once('action.about.php');}
    public function contactusAction()   {include_once('action.contactus.php');}
    public function privacyAction()     {include_once('action.privacy.php');}
    public function termsAction()       {include_once('action.terms.php');}
    public function hostfaqAction()     {include_once('action.hostfaq.php');}
    public function siteguideAction()   {include_once('action.siteguide.php');}


	public function noRouteAction()		{ $this->_redirect('/'); }
}