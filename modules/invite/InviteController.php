<?

class InviteController extends Socnet_Controller_Action
{
	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
    	parent::__construct($request, $response, $invokeArgs);
    	$this->params = $this->_getAllParams();
        $this->_page->Template->assign('menuContent', '_design/menu_content/menu_content.tpl');
    }

	// if (registered user) else->invite
    //public function indexAction()       {include_once('action.index.php');}        
    
    //public function okAction()  	{include_once('action.ok.php');	    }
    
    public function loginAction()   { include_once('action.login.php'); }    
    
    /*public function indexAction()    
    {
    	include_once('action.invite.php');
    	echo "asdfasd";
    }*/
    public function noRouteAction()	{$this->_redirect('/'); }
}


?>