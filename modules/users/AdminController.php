<?php

class UsersController extends Socnet_Controller_Action
{
    public $currentUser;
    public $params;
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);

        $this->currentUser = null;
        $this->params = $this->_getAllParams();
        if ( isset($this->params['name']) ) {
            if ( USE_USER_PATH && Socnet_User::isUserExists('login', $this->params['name']) ) {
                $this->currentUser = new Socnet_User('login', $this->params['name']);
            } else {
                $this->_redirect('http://'.BASE_HTTP_HOST.'/users/index/');
            }
        } elseif ( isset($this->params['userid']) ) {
            if ( Socnet_User::isUserExists('id', $this->params['userid']) ) {
                $this->currentUser = new Socnet_User('id', $this->params['userid']);
            } else {
                $this->_redirect('http://'.BASE_HTTP_HOST.'/users/index/');
            }
        }elseif ( isset($this->params['id']) ) {
            if ( Socnet_User::isUserExists('id', $this->params['id']) ) {
                $this->currentUser = new Socnet_User('id', $this->params['id']);
            } else {
                $this->_redirect('http://'.BASE_HTTP_HOST.'/users/index/');
            }
        }

        if ( $this->currentUser === null ) {
            $this->currentUser = $this->_page->_user;
        }
        if ( $this->currentUser->id == $this->_page->_user->id ) {
            $this->_page->Template->assign('menuColor', "blue");
        } else {
            $this->_page->Template->assign('menuColor', "red");
        }
        $this->_page->Template->assign('currentUser', $this->currentUser);
        $this->_page->setTitle(Socnet::t('Members'));
        $this->_page->setStyle('calendar.css');

        $this->_page->Template->assign('menuContent', '_design/menu_content/menu_content.tpl');
        // REGISTER AJAX FUNCTIONS
        //_______________________________________________________________
        $this->_page->Xajax->registerUriFunction("loadphoto", "/users/loadphoto/");
        $this->_page->Xajax->registerUriFunction("loadavatar", "/users/loadavatar/");
    }

    public function indexAction()          {include_once('/admin/action.index.php');}





}


