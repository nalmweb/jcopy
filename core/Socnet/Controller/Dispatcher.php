<?php

require_once 'Zend/Controller/Dispatcher/Standard.php';

class Socnet_Controller_Dispatcher extends Zend_Controller_Dispatcher_Standard
{
    /**
     * Dispatch to a controller/action
     *
     * @param Zend_Controller_Request_Abstract $request
     * @param Zend_Controller_Response_Abstract $response
     * @return boolean
     */
    public function dispatch(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response)
    {

        $this->setResponse($response);
        /**
         * Get controller directories
         */
        $directories  = $this->getControllerDirectory();

        /**
         * Get controller class
         */

        $className = $this->getControllerClass($request);
        if (!$className) {
                $className = $this->getDefaultControllerClass($request);
            }

        /**
         * If no class name returned, report exceptional behaviour
         */
        if (!$className) {
            throw new Zend_Controller_Dispatcher_Exception('"' . $request->getControllerName() . '" controller does not exist');
        }
        /**
         * Load the controller class file
         *
         * Attempts to load the controller class file from {@link getControllerDirectory()}.
         */

        Zend_Loader::loadClass($className, $this->getControllerDirectory());

        /**
         * Instantiate controller with request, response, and invocation
         * arguments; throw exception if it's not an action controller
         */

        //  XAJAX CALL
        //__________________________________________________________________
        if ( isset($_GET["xajax"]) || isset($_POST["xajax"]) ) {
            $function_name = ( isset($_GET["xajax"]) ) ? $_GET["xajax"] : $_POST["xajax"];
            if ( $function_name == "" ) {
                $className = ucfirst($request->getParam('xajaxcontext', 'ajax')).'Controller';
                Zend::loadClass($className, array(DOC_ROOT.'/../modules/'.$request->getParam('context', 'ajax')));
                $controller = new $className($request, $this->getResponse(), $this->getParams());
                if (!$controller instanceof Zend_Controller_Action) {
                    throw new Zend_Controller_Dispatcher_Exception("Controller '$className' is not an instance of Zend_Controller_Action");
                }
                $action = $this->getActionMethod($request);
                $doCall = !method_exists($controller, $action);
                $request->setDispatched(true);
                $controller->preDispatch();
                if ($request->isDispatched()) {
                    if ( !$doCall ) {
                		$sContentHeader = "Content-type: text/xml;";
                		if ($controller->_page->Xajax->sEncoding && strlen(trim($controller->_page->Xajax->sEncoding)) > 0) {
                			$sContentHeader .= " charset=".$controller->_page->Xajax->sEncoding;
                	    }
                		$xajaxargs = $controller->_page->Xajax->getRequestParams();
                        $sResponse = call_user_func_array(array(&$controller, $action), $xajaxargs);
                        if (is_a($sResponse, "xajaxResponse")) {
        					$sResponse = $sResponse->getXML();
        				}
                		header($sContentHeader);
        				print $sResponse; exit;
                    }
                }
                exit;
            } else {
                $controller = new $className($request, $this->getResponse(), $this->getParams());
                $controller->_page->needXajaxInit = true;
            }
        }
        //  STANDART CALL
        //__________________________________________________________________
        else {
            $controller = new $className($request, $this->getResponse(), $this->getParams());
        }

        if (!$controller instanceof Zend_Controller_Action) {
            throw new Zend_Controller_Dispatcher_Exception("Controller '$className' is not an instance of Zend_Controller_Action");
        }
        $action = $this->getActionMethod($request);
        $doCall = !method_exists($controller, $action);
        $request->setDispatched(true);
        $controller->preDispatch();
        if ($request->isDispatched()) {
            if ($doCall) {
                $controller->__call($action, array());
            } else {
                $controller->$action();
            }
            $controller->postDispatch();
        }
        // Destroy the page controller instance and reflection objects
        $controller = null;
    }
}