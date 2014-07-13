<?php

class UsersController extends Socnet_Controller_Action
{
  public $currentUser;
  public $params;

  private $oDbtree;
  private $table_name = "comment__user";
  private $m_table = "user";

  public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
  {
    parent::__construct($request, $response, $invokeArgs);

    $this->currentUser = null;
    $this->params = $this->_getAllParams();
    if (isset($this->params['name'])) {
      if (USE_USER_PATH && Socnet_User::isUserExists('login', $this->params['name'])) {
        $this->currentUser = new Socnet_User('login', $this->params['name']);
      } else {
        $this->_redirect('http://' . BASE_HTTP_HOST . '/news/');
      }
    } elseif (isset($this->params['userid'])) {
      if (Socnet_User::isUserExists('id', $this->params['userid'])) {
        $this->currentUser = new Socnet_User('id', $this->params['userid']);
      } else {
        $this->_redirect('http://' . BASE_HTTP_HOST . '/news/');
      }
    }

    if ($this->currentUser === null) {
      $this->currentUser = $this->_page->_user;
    }

    //print_f($this->_page->_user->isAutohouse());
    $this->_page->Template->assign('is_autohouse', $this->_page->_user->isAutohouse());

    $this->_page->Template->assign('currentUser', $this->currentUser);
    $this->_page->setTitle(Socnet::t('Кабинет'));
    $this->_page->setStyle('calendar.css');
    $this->_page->Template->assign('menuContent', '_design/menu_content/menu_content.tpl');

    // REGISTER AJAX FUNCTIONS
    //_______________________________________________________________
    $this->_page->Xajax->registerUriFunction("loadphoto", "/users/loadphoto/");
    $this->_page->Xajax->registerUriFunction("loadavatar", "/users/loadavatar/");
    // comments:: is it needed here?
    $this->_page->Xajax->registerUriFunction("addFriend", "/ajax/addFriend/");

    $this->oDbtree = new Socnet_DBTree($this->table_name, 'cid', array('cleft', 'cright', 'clevel'));
  }

  public function indexAction()
  {
    if($this->_page->_user->isAutohouse()){
      include_once('autohouse/action.index.php');
    }else
      include_once('user/action.index.php');
  }

  //public function loginAction()	       {include_once('action.login.php');}
  public function logoutAction()
  {
    include_once('action.logout.php');
  }

  public function restoreAction()
  {
    include_once('action.restore.php');
  }

  public function profileAction()
  {
    include_once('action.profile.php');
  }

  public function searchAction()
  {
    include_once('action.search.php');
  }

  public function avatarsAction()
  {
    include_once('avatar/action.avatar.php');
  }

  public function avatarDeleteAction()
  {
    include_once('avatar/action.avatarDelete.php');
  }

  public function avatarUploadAction()
  {
    include_once('avatar/action.avatarUpload.php');
  }

  public function avatarMakePrimaryAction()
  {
    include_once('avatar/action.avatarMakePrimary.php');
  }

  public function editAction()
  {
    include_once('action.edit.php');
  }

  //  START User Messages Actions Block
  //**********************************************

  public function autocompleteLoadContactListAction($filter = "", $function_name)
  {
    include_once('xajax/action.autocompleteLoadContactList.php');
    return $objResponse;
  }

  //**********************************************
  //  END User Messages Actions Block


  //  AJAX function
  //_________________________________________________________________________
  /**
   * AJAX function - show new photo and all photo atributes in "view gallery"
   * @param int $photoId
   * @param int $galleryId
   * @return unknown
   */
  public function loadphotoAction($photoId, $galleryId)
  {
    include_once('xajax/action.loadphoto.php');
    return $objResponse;
  }

  /**
   * AJAX function - show new avatar in "view avatars" section
   * @param int $avatarId
   * @return xAJAX response
   */
  public function loadavatarAction($avatarId)
  {
    include_once('xajax/action.loadavatar.php');
    return $objResponse;
  }

  /**
   * Messages AJAX Functions
   */
  public function messagesMarkAsReadAction($messages_ids = array(), $url)
  {
    include_once('xajax/action.messagesMarkAsRead.php');
    return $objResponse;
  }

  public function messagesMarkAsUnreadAction($messages_ids = array(), $url)
  {
    include_once('xajax/action.messagesMarkAsUnread.php');
    return $objResponse;
  }

  public function passwordAction()
  {
    include_once('action.password.php');
  }

  public function isValid()
  {
    if (isset ($_SESSION['user_id'])) return true; else return false;
  }


  // BOARD:
  public function adsAction()
  {
    if($this->_page->_user->isAutohouse()){
      include_once('autohouse/action.index.php');
    }else
      include_once('user/action.index.php');
  }

  public function adsEditAction()
  {
    include_once ('private/action.board.edit.php');
  }

  public function adsDeleteAction()
  {
    include_once ('private/action.board.delete.php');
  }


  public function cantmodify()
  {
    include_once ('action.cantmodify.php');
  }

}