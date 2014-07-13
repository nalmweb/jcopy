<?php
class SearchController extends Socnet_Controller_Action
{
    public $currentUser;
    public $params;
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);

        $this->params = $this->_getAllParams();

        $this->_page->setTitle(Socnet::t('Поиск'));

        $this->_page->Template->assign('menuContent', '_design/menu_content/menu_content.tpl');
    }

    public function indexAction()       {include_once('action.index.php');}
    public function pageAction()       {include_once('action.index.php');}
}
?>