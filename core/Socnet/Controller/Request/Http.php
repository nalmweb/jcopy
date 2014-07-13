<?php

require_once 'Zend/Controller/Request/Http.php';

class Socnet_Controller_Request_Http extends Zend_Controller_Request_Http
{
    public function setRequestUri($requestUri = null)
    {
        if ($requestUri === null) {
            if ( isset($_SERVER['QUERY_STRING']) ) {
                $requestUri = $_SERVER['QUERY_STRING'];
            } else {
                return $this;
            }
        } elseif (!is_string($requestUri)) {
            return $this;
        } else {
            // Set GET items, if available
            $_GET = array();
            if (false !== ($pos = strpos($requestUri, '?'))) {
                // Get key => value pairs and set $_GET
                $query = substr($requestUri, $pos + 1);
                parse_str($query, $vars);
                $_GET = $vars;
            }
        }

        $this->_requestUri = $requestUri;
        return $this;
    }
}