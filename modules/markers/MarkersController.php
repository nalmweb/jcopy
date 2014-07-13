<?php
class MarkersController extends Socnet_Controller_Action
{
   public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
   {
        parent::__construct($request, $response, $invokeArgs);
        $this->params = $this->_getAllParams();
    }

    public function indexAction()  {include('action.index.php');}
}