<?php

class Socnet_Session extends Zend_Session
{
    /**
     * Default number of seconds the session will be remembered for when asked to be remembered
     *
     * @var int
     */
    private static $_rememberMeSeconds = 1209600; // 2 weeks


    public function __construct()
    {
    
    }
	/**
	 *  Запоминает пользователя.
	 */ 
    public static function rememberMe( $seconds = null )
    {
        $seconds = ($seconds > 0) ? $seconds : self::$_rememberMeSeconds;
        parent::rememberMe($seconds);
        Socnet_Http_Cookie::setCookieStatic('SOCNET_REMEMBER',1,$seconds);
    }
    
	/**
	 *  Забывает пользователя. Обнуляет все куки.
	 */ 
    public static function forgetMe()
    {
        parent::forgetMe();
        //parent::destroy(true);
        unset($_SESSION['user_id']);
        Socnet_Http_Cookie::unsetCookie('SOCNET_REMEMBER');
        Socnet_Http_Cookie::unsetCookie('SOCNET_USER');
        Socnet_Http_Cookie::unsetCookie('SOCNET_LOGIN');
        Socnet_Http_Cookie::unsetCookie('SOCNET_PASSWORD');
    }
    
    public static function getExpirie(){
        return self::$_rememberMeSeconds;
    }
}
?>