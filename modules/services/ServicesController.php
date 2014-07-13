<?php

class ServicesController extends Socnet_Controller_Action
{
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);
        $this->params = $this->_getAllParams();
    }

    public function cronAction()       
    {
        $select = $this->_db->select();
        $select->from( 'mail__queue', 'id' );
        $select->where( 'date <= NOW()' );
        $aResult = $this->_db->fetchCol( $select );
        
        foreach ( $aResult as $row ) {
        	$stuff = new Socnet_Mail_Distribution( $row );
        	$stuff->send();
        }
        exit;
    }
}
?>