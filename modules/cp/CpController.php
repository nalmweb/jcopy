<?
class CpController extends Socnet_Controller_Action
{
  public $currentUser;
  public $params;

  public $oUrl;
  public $oPaginator;
  static $iCount;

  public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
  {
    parent::__construct($request, $response, $invokeArgs);
    $this->currentUser = null;
    self::$iCount = 0;
    $this->params = $this->_getAllParams();

    // Для админки будем выводить другой дизайн
    $this->_page->Template->setLayout('cp.tpl');

    if (!$this->_page->_user->isAdmin()) {
      $this->_redirect('http://' . BASE_HTTP_HOST . '/');
    }else{
      $this->_page->Template->assign('AdminID', $this->_page->_user->isAdmin());
    }

  }

  function indexAction()
  {
    require_once(CP_DIR . "action.index.php");
  }

  /*
   * USERS
   */
  function usersAction()
  {
    require_once(CP_DIR . "users/action.index.php");
  }

  /*
   * BOARD
   */
  function boardAction()
  {
    require_once(CP_DIR . "board/action.index.php");
  }
  function boardCarsAction()
  {
    require_once(CP_DIR . "board/action.Cars.php");
  }

  //********************************
  function save($str)
  {
    $fh = fopen("out.txt", "w+");
    fwrite($fh, $str);
    fclose($fh);
  }
}

?>