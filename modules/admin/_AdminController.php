<?
class AdminController extends Socnet_Controller_Action
{
    public $currentUser;
    public $params;

    private $pageSize = 5;
    private $frameSize = 10;
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


    function indexAction()
    {
        require_once(ADMIN_DIR . "action.index.php");
    }

    function utilityAction()
    {
        require_once(ADMIN_DIR . "action.utility.php");
    }

    function countriesAction()
    {
        require_once(ADMIN_DIR . "action.country.php");
    }

    function citiesAction()
    {
        require_once(ADMIN_DIR . "action.city.php");
    }


    /*
        Edit?
    */
    function meetingsAction()
    {
        require_once (ADMIN_DIR . "action.meetings.php");
    }

    /*
        block, remove. ban(ip?), send message (1,N)
    */
    function usersAction()
    {
        require_once (ADMIN_DIR . "action.users.php");
    }

    /*********************************
     * Каталог
     */
    public function catalogAction()
    {
        include_once(ADMIN_DIR . "catalog/action.index.php");
    }

    public function trademarksAction()
    {
        include_once(ADMIN_DIR . "catalog/action.trademarks.php");
    }

    public function modificationAction()
    {
        include_once(ADMIN_DIR . "catalog/action.modification.php");
    }

    /**
     *
     */
    public function modelsAction()
    {
        include_once(ADMIN_DIR . "catalog/action.models.php");
    }

    /**
     *
     */
    public function yearsAction()
    {
        include_once(ADMIN_DIR . "catalog/action.years.php");
    }

    /**
     * @param null $markId
     * @return xajaxResponse
     */
    public function selectTrademarkAction($markId = null)
    {
        include_once(ADMIN_DIR . "catalog/xajax/action.selectTrademark.php");
    }

    /**
     * @param null $modelId
     * @return xajaxResponse
     */
    public function selectModelAction($modelId = null)
    {
        include_once(ADMIN_DIR . "catalog/xajax/action.selectModel.php");
    }

    /**
     * @param null $modificationId
     * @param null $markId
     * @param null $modelId
     * @return xajaxResponse
     */
    public function selectModificationAction($modificationId = null, $markId = null, $modelId = null)
    {
        include_once(ADMIN_DIR . "catalog/xajax/action.selectModification.php");
    }

    /**
     * @param null $markId
     * @return xajaxResponse
     */
    public function changeTMLogoAction($markId = null)
    {
        include_once(ADMIN_DIR . "catalog/xajax/action.changeTMLogo.php");
    }

//    /**
//     *
//     */
//    public function changeTrademarkAction()
//    {
//      include_once(ADMIN_DIR . "../ajax/action.changeTrademark.php");
//    }

    /**
     * @param $modelId
     * @param $bike_category_id
     * @return xajaxResponse
     */
    public function setBikeCategoriesAction($modelId, $bike_category_id)
    {
        include_once(ADMIN_DIR . "catalog/xajax/action.setBikeCategories.php");
    }

    public function catalogPropertiesSettingsAction()
    {
        include_once(ADMIN_DIR . "catalog/action.properties.settings.php");
    }

    public function viewPropertiesAction()
    {
        include_once(ADMIN_DIR . "catalog/action.properties.view.php");
    }

    /**
     * @param null $id
     * @param null $view
     * @return xajaxResponse
     */
    public function checkPropertyAction($id = null, $view = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.check.prop.php");
    }

    public function changeModelAction($modelId = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.changeModel.php");
    }

    /**
     * @param null $modelId
     * @return xajaxResponse
     */
    public function SMchangeModelAction($modelId = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.setPropModels.changeModel.php");
    }

    public function changeYearAction($modificationGodId = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.changeYear.php");
    }

    public function changeModificationAction($modificationId = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.changeModification.php");
    }

    public function saveYearPropertiesAction($params = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.saveYearProperties.php");
    }

    public function saveModificationPropertiesAction($params = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.saveModificationProperties.php");
    }

    public function saveModelPropertiesAction($params = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.setPropModels.saveProperties.php");
    }

    public function addListDataAction($propertyId = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.addListProperty.php");
    }

    public function changePropNameAction($id = null, $value = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.changePropName.php");
    }

    public function changePropCharAction($id = null, $value = null, $char = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.changePropChar.php");
    }

    public function deletePropAction($id = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.deleteProp.php");
    }

    public function addPropertyValueAction($params = null, $action = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.addPropertyValue.php");
    }

    public function addNewPropertyAction()
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.addNewProperty.php");
    }

    public function addNewPropertyDoAction($data = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.addNewPropertyDo.php");
    }

    public function setPropertyDescAction($propertyId = null, $data = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.setPropertyDesc.php");
    }

    public function setVisibleModelAction($modelId = null, $checked = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.setVisibleModel.php");
    }

    public function setVisibleYearAction($modelId = null, $checked = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.setVisibleYear.php");
    }

    public function setVisibleModificationAction($modelId = null, $checked = null)
    {
        include_once (ADMIN_DIR . "catalog/xajax/action.setVisibleModification.php");
    }

    public function setPropYearsAction()
    {
        require_once (ADMIN_DIR . 'catalog/action.setPropYears.php');
    }

    public function setPropModelsAction()
    {
        require_once (ADMIN_DIR . 'catalog/action.setPropModels.php');
    }

    public function setPropModificationAction()
    {
        require_once (ADMIN_DIR . 'catalog/action.setPropModification.php');
    }

    // mail
    function addMailTemplateAction()
    {
        require_once (ADMIN_DIR . "mail/action.addMailTemplate.php");
    }

    function mailAction()
    {
        require_once (ADMIN_DIR . "mail/action.index.php");
    }

    function mailtemplatesAction()
    {
        require_once (ADMIN_DIR . 'mail/action.mailtemplates.php');
    }

    // one template
    function mailtemplateAction()
    {
        require_once (ADMIN_DIR . "mail/action.template.php");
    }

    function sendmailAction()
    {
        require_once (ADMIN_DIR . "mail/action.sendMail.php");
    }

    function sendDemoMailAction()
    {
        require_once (ADMIN_DIR . "mail/action.sendDemoMail.php");
    }

    /*public function sendDemoMailAction ($tpl_key,$email)
{include_once (ADMIN_DIR."mail/xajax/action.sendDemoMail.php"); return $objResponse; }*/

    function deleteTemplateAction()
    {
        require_once (ADMIN_DIR . "mail/action.deleteTemplate.php");
    }

    function editTemplateAction()
    {
        require_once (ADMIN_DIR . "mail/action.editTemplate.php");
    }

    function createMailingListAction()
    {
        require_once (ADMIN_DIR . "mail/action.sendMail.php");
    }

    public function mailarchiveAction()
    {
        require_once (ADMIN_DIR . 'mail/action.mailarchive.php');
    }

    // send many mails simultaneously
    public function massmailAction()
    {
        require_once (ADMIN_DIR . 'mail/action.massmail.php');
    }

    public function testSendAction()
    {
        require_once (ADMIN_DIR . 'mail/action.testSend.php');
    }

    // This IS ThaT...
    public function changePhotoAction($item_id, $photo_id)
    {
        include_once(ADMIN_DIR . "mail/xajax/action.changePhoto.php");
    }

    /**
     *  Board
     */
    public function boardAction()
    {
        include_once(ADMIN_DIR . "board/action.board.index.php");
    }

    public function boardOptionsAction()
    {
        include_once(ADMIN_DIR . "board/action.board.options.php");
    }

    public function boardPriceAction()
    {
        include_once(ADMIN_DIR . "board/action.board.price.php");
    }


    // *************************** LOAD ******************************
    /**
     * @param null $id_model
     */
    public function loadModelPropertyAction($id_model = null){
      include_once (ADMIN_DIR . "catalog/xajax/action.loadModelProperty.php");
    }

    /**
     * @param null $id_modification
     */
    public function loadModificationPropertyAction($id_modification = null){
      include_once (ADMIN_DIR . "catalog/xajax/action.loadModificationProperty.php");
    }

    /**
     * @param $str
     */
    //********************************
    function save($str)
    {
        $fh = fopen("out.txt", "w+");
        fwrite($fh, $str);
        fclose($fh);
    }
}

?>