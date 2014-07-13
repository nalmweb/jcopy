<?php

class MailtemplatesController extends Socnet_Controller_Action
{
    public $use_user_path;

    public $currentUser;
    public $params;

	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
    	parent::__construct($request, $response, $invokeArgs);
      	
    	if (!$this->_page->_user->isAdmin()){
        	$this->_redirect('http://'.BASE_HTTP_HOST.'/');
  		}
    	
  		$this->currentUser = null;
    	$this->use_user_path = null;

    	$this->params = $this->_getAllParams();
    	
    	if ( isset($this->params['name']) ) {
            if ( USE_USER_PATH && Socnet_User::isUserExists('login', $this->params['name']) ) {
                $this->currentUser = new Socnet_User('login', $this->params['name']);
            } else {
                $this->_redirect('http://'.BASE_HTTP_HOST.'/news/');
            }
        } elseif ( isset($this->params['userid']) ) {
            if ( Socnet_User::isUserExists('id', $this->params['userid']) ) {
                $this->currentUser = new Socnet_User('id', $this->params['userid']);
            } else {
                $this->_redirect('http://'.BASE_HTTP_HOST.'/news/');
            }
        }
    	
    	if ( $this->currentUser === null ) {
    	     $this->currentUser = $this->_page->_user;
    	}

    	$this->use_user_path = 'http://'.BASE_HTTP_HOST.'/mailtemplates';
            
    	$this->_page->Template->assign('currentUser', $this->currentUser);

    	$this->_page->Template->assign('use_user_path', $this->use_user_path);

    	$this->_page->setTitle(Socnet::t('Mail templates'));
    	//@todo author Akexander Komarovski $this->_page->Template->assign('menuContent', '_design/menu_content/menu_content.tpl');
    }

    public function indexAction()         {include_once('action.index.php');    }
    public function viewtplAction()       {include_once('action.viewtpl.php');  }
    public function addtplAction()        {include_once('action.addtpl.php');   }
    
    public function viewmessAction()      {include_once('action.viewmess.php'); }
    public function addmessAction()       {include_once('action.addmess.php');  }
    public function settingsAction()      {include_once('action.settings.php'); }
    public function adduserAction()       {include_once('action.adduser.php');  }
    public function adduserokAction()     {include_once('action.adduserok.php');}
    public function deleteuserAction()    {include_once('action.deleteuser.php');}

	public function noRouteAction()
	{
        $this->_redirect('/');
	}

}

