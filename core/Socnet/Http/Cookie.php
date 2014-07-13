<?
class Socnet_Http_Cookie extends Zend_Http_Cookie
{
    /**
     * Cookie object constructor
     *
     * @todo Add validation of each one of the parameters (legal domain, etc.)
     *
     * @param string $name
     * @param string $value
     * @param int $expires
     * @param string $domain
     * @param string $path
     * @param bool $secure
     */
    public function __construct($name, $value, $domain, $expires = null, $path = null, $secure = false)
    {
        parent::__construct($name, $value, $domain, $expires, $path, $secure);
    }

    public function setCookie()
    {
            setcookie($this->getName(),
                      $this->getValue(),
                      time()+$this->getExpiryTime(),
                      $this->getPath(),
                      $domain= ".".BASE_HTTP_HOST,
                      /*$this->getDomain(),*/
                      $this->isSecure());
	    //dump_str($this->getDomain());
    }

    public static function setCookieStatic($name, $value,  $expires = null, $domain = '', $path = "/", $secure = false)
    {
    	//dump_str("domain=[".$domain."]");    	
    	$domain= ".".BASE_HTTP_HOST;
    	//exit;
        	setcookie($name,
                      $value,
                      time() + $expires,
                      $path,
                      $domain,
                      $secure);
    }

    public static function unsetCookie($key = null)
    {
        if (isset($_COOKIE[$key])) {
            
            $cookie_params = session_get_cookie_params();

			$cookie_params['domain'] = ".".BASE_HTTP_HOST;

            setcookie(
                $key,
                false,
                315554400, // strtotime('1980-01-01'),
                $cookie_params['path'],
                $cookie_params['domain'],
                $cookie_params['secure']
                );
        }
    }

    public function getCookieNamed($key = null)
    {
        return Zend_Controller_Request_Http::getCookie($key,false);
    }
}
?>