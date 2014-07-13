<?php
class SwfuploadController extends Socnet_Controller_Action
{
    public $currentUser;
    public $params;
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);

        $this->params = $this->_getAllParams();

    }

    public function thumbnailAction()       {include_once('action.thumbnail.php'); return $objResponse;}
    public function uploadAction()          {include_once('action.upload.php'); return $objResponse;}
}
?>