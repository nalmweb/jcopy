<?php
class Socnet_Controller_Router extends Zend_Controller_Router_Abstract
{
    /**
     * Route a request
     *
     * Routes requests of the format /controller/action by default (action may
     * be omitted). Additional parameters may be specified as key/value pairs
     * separated by the directory separator:
     * /controller/action/key/value/key/value.
     *
     * To specify a module to use (basically, subdirectory) when routing the
     * request, set the 'useModules' parameter via the front controller or
     * {@link setParam()}: $router->setParam('useModules', true)
     *
     * @param Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function route(Zend_Controller_Request_Abstract $request)
    {
        if (!$request instanceof Zend_Controller_Request_Http) {
            throw new Zend_Controller_Router_Exception('Zend_Controller_Router requires a Zend_Controller_Request_Http-based request object');
        }

        $pathInfo = $request->getPathInfo();
        $pathSegs = explode('/', trim($pathInfo, '/'));

        /**
         * Retrieve module if useModules is set in object
         */
//        array_shift($pathSegs);
        $useModules = $this->getParam('useModules');
        if (!empty($useModules)) {
            if (isset($pathSegs[0]) && !empty($pathSegs[0])) {
                $module = array_shift($pathSegs);
            }
        }

        /**
         * Get controller and action from request
         * Attempt to get from path_info; controller is first item, action
         * second
         */
        if (isset($pathSegs[0]) && !empty($pathSegs[0])) {
            $controller = array_shift($pathSegs);
        }
        if (isset($pathSegs[0]) && !empty($pathSegs[0])) {
            $action = array_shift($pathSegs);
        }

        /**
         * Any optional parameters after the action are stored in
         * an array of key/value pairs:
         *
         * http://www.zend.com/controller-name/action-name/param-1/3/param-2/7
         *
         * $params = array(2) {
         *              ["param-1"]=> string(1) "3"
         *              ["param-2"]=> string(1) "7"
         * }
         */
        $params = array();
        $segs = count($pathSegs);
        if (0 < $segs) {
            for ($i = 0; $i < $segs; $i = $i + 2) {
                $key = urldecode($pathSegs[$i]);
                $value = isset($pathSegs[$i+1]) ? urldecode($pathSegs[$i+1]) : null;
                $params[$key] = $value;
            }
        }
        $request->setParams($params);
        /**
         * Set module, controller and action, now that params are set
         */

        if (isset($module)) {
            $request->setModuleName(urldecode($module));
        }
        if (isset($controller)) {
            $request->setControllerName(urldecode($controller));
        }
        if (isset($action)) {
            $request->setActionName(urldecode($action));
        }


        return $request;
    }
}
?>