<?
class PanelController extends Socnet_Controller_Action
{
    public $currentUser;
    public $params;
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);

        $this->currentUser = null;


        // REGISTER AJAX FUNCTIONS
        //_______________________________________________________________
        $this->_page->Xajax->registerUriFunction("loadphoto", "/users/loadphoto/");
        $this->_page->Xajax->registerUriFunction("loadavatar", "/users/loadavatar/");
    }


    function indexAction() {require_once(ADMIN_DIR."index.php");}


}

?>