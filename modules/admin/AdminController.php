<?
class AdminController extends Socnet_Controller_Action {
  public $currentUser;
  public $params;

  private $pageSize = 5;
  private $frameSize = 10;
  public $oUrl;
  public $oPaginator;
  static $iCount;

  public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
    parent::__construct($request, $response, $invokeArgs);
    $this->currentUser = null;
    self::$iCount = 0;
    $this->params = $this->_getAllParams();

    // Для админки будем выводить другой дизайн
    $this->_page->Template->setLayout('admin.tpl');

    //print_f($this->_page->_user->isAdmin());
    if (!$this->_page->_user->isAdmin() || $this->_page->_user->isAdmin() != 2) {
      $this->_redirect('http://' . BASE_HTTP_HOST . '/cp');
    }
    // used for paging
    $this->oUrl = new Socnet_URL("http://" . BASE_HTTP_HOST);
    $this->oPaginator = new Socnet_Paginator($this->oUrl, 5, 1, $this->pageSize, $this->frameSize);

    // REGISTER AJAX FUNCTIONS
    //_______________________________________________________________
    $this->_page->Xajax->registerUriFunction("loadphoto", "/users/loadphoto/");
    $this->_page->Xajax->registerUriFunction("loadavatar", "/users/loadavatar/");
    $this->_page->Xajax->registerUriFunction("approve", "/admin/approve/");

    $this->_page->Xajax->registerUriFunction("saveText", "/admin/savetext/");
    $this->_page->Xajax->registerUriFunction("editNews", "/admin/editNews/");

    $admin_js = '<script type="text/javascript" src="/js/admin.js"></script>';
    $this->_page->Template->assign('admin_js', $admin_js);
  }


  function indexAction() {
    require_once(ADMIN_DIR . "action.index.php");
  }

  function utilityAction() {
    require_once(ADMIN_DIR . "action.utility.php");
  }

  function countriesAction() {
    require_once(ADMIN_DIR . "action.country.php");
  }

  function citiesAction() {
    require_once(ADMIN_DIR . "action.city.php");
  }


  /*
      Edit?
  */
  function meetingsAction() {
    require_once (ADMIN_DIR . "action.meetings.php");
  }

  /*
      block, remove. ban(ip?), send message (1,N)
  */
  function usersAction() {
    require_once (ADMIN_DIR . "action.users.php");
  }

  /*********************************
   * Каталог
   */
  public function catalogAction() {
    include_once(ADMIN_DIR . "catalog/action.index.php");
  }

  public function trademarksAction() {
    include_once(ADMIN_DIR . "catalog/action.trademarks.php");
  }

  public function modificationAction() {
    include_once(ADMIN_DIR . "catalog/action.modification.php");
  }


  public function modelsAction() {
    include_once(ADMIN_DIR . "catalog/action.models.php");
  }

  public function yearsAction() {
    include_once(ADMIN_DIR . "catalog/action.years.php");
  }

  public function selectTrademarkAction($markId = null) {
    include_once(ADMIN_DIR . "catalog/xajax/action.selectTrademark.php");
    return $objResponse;
  }

  public function selectModelAction($modelId = null) {
    include_once(ADMIN_DIR . "catalog/xajax/action.selectModel.php");
    return $objResponse;
  }

  public function selectModificationAction($modificationId = null, $markId = null, $modelId = null) {
    include_once(ADMIN_DIR . "catalog/xajax/action.selectModification.php");
    return $objResponse;
  }

  public function changeTMLogoAction($markId = null) {
    include_once(ADMIN_DIR . "catalog/xajax/action.changeTMLogo.php");
    return $objResponse;
  }

  public function setBikeCategoriesAction($modelId, $bike_category_id) {
    include_once(ADMIN_DIR . "catalog/xajax/action.setBikeCategories.php");
    return $objResponse;
  }

  public function catalogPropertiesSettingsAction() {
    include_once(ADMIN_DIR . "catalog/action.properties.settings.php");
  }

  public function viewPropertiesAction() {
    include_once(ADMIN_DIR . "catalog/action.properties.view.php");
  }

  public function checkPropertyAction($id = null, $view = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.check.prop.php");
    return $objResponse;
  }

  public function changeModelAction($modelId = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.changeModel.php");
    return $objResponse;
  }

  public function SMchangeModelAction($modelId = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.setPropModels.changeModel.php");
    return $objResponse;
  }

  public function changeYearAction($modificationGodId = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.changeYear.php");
    return $objResponse;
  }

  public function changeModificationAction($modificationId = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.changeModification.php");
    return $objResponse;
  }

  public function saveYearPropertiesAction($params = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.saveYearProperties.php");
    return $objResponse;
  }

  public function saveModificationPropertiesAction($params = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.saveModificationProperties.php");
    return $objResponse;
  }

  public function saveModelPropertiesAction($params = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.setPropModels.saveProperties.php");
    return $objResponse;
  }

  public function addListDataAction($propertyId = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.addListProperty.php");
    return $objResponse;
  }

  public function changePropNameAction($id = null, $value = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.changePropName.php");
    return $objResponse;
  }

  public function changePropCharAction($id = null, $value = null, $char = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.changePropChar.php");
    return $objResponse;
  }

  public function deletePropAction($id = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.deleteProp.php");
    return $objResponse;
  }

  public function addPropertyValueAction($params = null, $action = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.addPropertyValue.php");
    return $objResponse;
  }

  public function addNewPropertyAction() {
    include_once (ADMIN_DIR . "catalog/xajax/action.addNewProperty.php");
    return $objResponse;
  }

  public function addNewPropertyDoAction($data = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.addNewPropertyDo.php");
    return $objResponse;
  }

  public function setPropertyDescAction($propertyId = null, $data = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.setPropertyDesc.php");
    return $objResponse;
  }

  public function setVisibleModelAction($modelId = null, $checked = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.setVisibleModel.php");
    return $objResponse;
  }

  public function setVisibleYearAction($modelId = null, $checked = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.setVisibleYear.php");
    return $objResponse;
  }

  public function setVisibleModificationAction($modelId = null, $checked = null) {
    include_once (ADMIN_DIR . "catalog/xajax/action.setVisibleModification.php");
    return $objResponse;
  }

  public function setPropYearsAction() {
    require_once (ADMIN_DIR . 'catalog/action.setPropYears.php');
  }

  public function setPropModelsAction() {
    require_once (ADMIN_DIR . 'catalog/action.setPropModels.php');
  }

  public function setPropModificationAction() {
    require_once (ADMIN_DIR . 'catalog/action.setPropModification.php');
  }

  // mail
  function addMailTemplateAction() {
    require_once (ADMIN_DIR . "mail/action.addMailTemplate.php");
  }

  function mailAction() {
    require_once (ADMIN_DIR . "mail/action.index.php");
  }

  function mailtemplatesAction() {
    require_once (ADMIN_DIR . 'mail/action.mailtemplates.php');
  }

  // one template
  function mailtemplateAction() {
    require_once (ADMIN_DIR . "mail/action.template.php");
  }

  function sendmailAction() {
    require_once (ADMIN_DIR . "mail/action.sendMail.php");
  }

  function sendDemoMailAction() {
    require_once (ADMIN_DIR . "mail/action.sendDemoMail.php");
  }

  /*public function sendDemoMailAction ($tpl_key,$email)
{include_once (ADMIN_DIR."mail/xajax/action.sendDemoMail.php"); return $objResponse; }*/

  function deleteTemplateAction() {
    require_once (ADMIN_DIR . "mail/action.deleteTemplate.php");
  }

  function editTemplateAction() {
    require_once (ADMIN_DIR . "mail/action.editTemplate.php");
  }

  function createMailingListAction() {
    require_once (ADMIN_DIR . "mail/action.sendMail.php");
  }

  public function mailarchiveAction() {
    require_once (ADMIN_DIR . 'mail/action.mailarchive.php');
  }

  // send many mails simultaneously
  public function massmailAction() {
    require_once (ADMIN_DIR . 'mail/action.massmail.php');
  }

  public function testSendAction() {
    require_once (ADMIN_DIR . 'mail/action.testSend.php');
  }

  // This IS ThaT...
  public function changePhotoAction($item_id, $photo_id) {
    include_once(ADMIN_DIR . "mail/xajax/action.changePhoto.php");
    return $objResponse;
  }

  // *************************** LOAD ******************************
  /**
   * @param null $id_model
   */
  public function loadModelPropertyAction($id_model = null){
    include_once (ADMIN_DIR . "catalog/xajax/action.loadModelProperty.php");
    return $objResponse;
  }

  /**
   * @param null $id_modification
   */
  public function loadModificationPropertyAction($id_modification = null){
    include_once (ADMIN_DIR . "catalog/xajax/action.loadModificationProperty.php");
    return $objResponse;
  }

  /**
   *  Board
   */
  public function boardAction() {
    include_once(ADMIN_DIR . "board/action.board.index.php");
  }

  public function boardOptionsAction() {
    include_once(ADMIN_DIR . "board/action.board.options.php");
  }

  public function boardPriceAction() {
    include_once(ADMIN_DIR . "board/action.board.price.php");
  }


  /**
   *  Partner "CATALOG"
   */
  public function partnerAction() {
    include_once(ADMIN_DIR . "partner/action.index.php");
  }

  public function partnerListAction() {
    include_once(ADMIN_DIR . "partner/action.list.php");
  }

  public function partnerAddAction() {
    include_once(ADMIN_DIR . "partner/action.add.php");
  }

  public function partnerDeleteAction() {
    include_once(ADMIN_DIR . "partner/action.delete.php");
  }

  //********************************
  function save($str) {
    $fh = fopen("out.txt", "w+");
    fwrite($fh, $str);
    fclose($fh);
  }
}

?>