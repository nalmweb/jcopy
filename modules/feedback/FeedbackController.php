<?php
/*
 *  Created on 17.01.2008
 */
class FeedbackController extends Socnet_Controller_Action
{
	private $crumbs;

	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
    	parent::__construct($request, $response, $invokeArgs);
        $this->_page->setTitle(Socnet::t('Связь с нами'));
        $this->_page->Template->assign('menuContent','_design/menu_content/menu_content.tpl');
        $this->params = $this->_getAllParams();        
	    $this->_count=0;
    }
    /**
     *  
     */
    public function indexAction()
    {
      include_once('action.index.php');
    }
    
    /**
     * 
     */ 
    public function sendAction()
    {
      include_once('action.send.php');
    }
}
?>