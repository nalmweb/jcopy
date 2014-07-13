<?php
class Socnet_Controller_Front extends Zend_Controller_Front
{
    /**
     * Set the dispatcher object.  The dispatcher is responsible for
     * taking a Zend_Controller_Dispatcher_Token object, instantiating the controller, and
     * call the action method of the controller.
     *
     * @param Zend_Controller_Dispatcher_Interface $dispatcher
     * @return Zend_Controller_Front
     */
    public function setDispatcher(Zend_Controller_Dispatcher_Interface $dispatcher)
    {
        $this->_dispatcher = $dispatcher;
        return $this;
    }
    /**
     * Convenience feature, calls setControllerDirectory()->setRouter()->dispatch()
     *
     * In PHP 5.1.x, a call to a static method never populates $this -- so run()
     * may actually be called after setting up your front controller.
     *
     * @param string|array $controllerDirectory Path to Zend_Controller_Action
     * controller classes or array of such paths
     * @return void
     * @throws Zend_Controller_Exception if called from an object instance
     */
    static public function run($controllerDirectory)
    {
//        require_once 'Zend/Controller/Router.php';

        $frontController = self::getInstance();
        $frontController->setDispatcher(new Socnet_Controller_Dispatcher);
        $frontController->_throwExceptions = THROW_EXCEPTIONS;
        $request = new Socnet_Controller_Request_Http();

        $request
            ->setControllerName(Socnet::$controllerName)
            ->setActionName(Socnet::$actionName);
        
        $frontController
            ->setControllerDirectory($controllerDirectory)
            ->setRouter(new Socnet_Controller_Router())
            ->dispatch($request);
    }
}