<?php

class IndexController extends Socnet_Controller_Action
{
	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
    	parent::__construct($request, $response, $invokeArgs);
    	$this->params = $this->_getAllParams();
        $this->_page->setTitle(Socnet::t('Jcopy'));
        $this->_page->Template->assign('menuContent', '_design/menu_content/menu_content.tpl');
    }

	//if (registered user) else->invite
    // public function indexAction()       {include_once('action.index.php');}
    public function okAction()  	{include_once('action.ok.php');	    }
    public function loginAction()   { include_once('action.login.php'); }    
    
    //One more thousand will be necessary.
    public function indexAction()
    {
    	$user_id = isset ($_SESSION['user_id'])?$_SESSION['user_id']:0;
    	// $user_id = 1;
    	// uncomment for invites:
    	/*
    	if(empty($user_id))
    		include_once('action.invite.php');
    	else
    	{*/
    	  $this->_page->Template->assign('invite',false);
    	  include_once('action.index.php');
    	//}
    }
    
    public function noRouteAction()	{$this->_redirect('/'); }
    
    public function changeTrademarkAction($markId) {include_once('xajax/action.changeTrademark.php'); return $objResponse;}
 	public function changeTrademarkOnInviteAction($values) {include_once('xajax/action.changeTrademarkOnInvite.php'); return $objResponse;}
 	public function changeModelAction($modelId) {include_once('xajax/action.changeModel.php');  	return $objResponse;}
    public function checkNicknameAction($nick)  {include_once('xajax/action.checkNickname.php'); return $objResponse; } 	    
}