<?php
/**
 * Socnet Framework
 *
 * @package    Socnet
 * @copyright  Copyright (c) 2006-2007
 */

/* Определяем константы. */
  define( 'APP_HOME_DIR', realpath( dirname( __FILE__)));

/**
 * Application var.
 */
  define( 'APP_VAR_DIR' , realpath(APP_HOME_DIR . '/../var'));

/**
 * Document root
 */
  define('DOC_ROOT', realpath($_SERVER['DOCUMENT_ROOT']) );

/**
 * Socnet Framework directory.
 */
  define('ENGINE_DIR', realpath(dirname(__FILE__)));

/**
 * Zend Framework directory.
 */
  define('ZEND_DIR', ENGINE_DIR.'/Zend/');

/**
 * Socnet Framework классы.
 */
  define('SOCNET_DIR', ENGINE_DIR.'/Socnet/');

/**
 * PEAR классы.
 */
  define('PEAR_DIR', ENGINE_DIR.'/PEAR/');

/**
 * Путь к Smarty.
 */
  define('SMARTY_DIR', ENGINE_DIR.'/Smarty/');
  define('SMARTY_DIR_PLUGINS', SMARTY_DIR.'plugins/');

/**
 * Имя папки в которую устанавливаем Socnet MANAGMENT SYSTEM (SMS)
 */
  define('ADMIN_DIR_NAME', 'modules/admin/');
  define('CP_DIR_NAME', 'modules/cp/');

/**
 * Папка системы администрирования.
 */
  define('ADMIN_DIR', DOC_ROOT.'/'.ADMIN_DIR_NAME.'/');
  define('CP_DIR', DOC_ROOT.'/'.CP_DIR_NAME.'/');

/**
 * Папка конфигов
 */
  define('CONFIG_DIR', ENGINE_DIR.'/_configs/');

  define ('NEWS_DIR',DOC_ROOT.'/upload/news/');
  define ('NEWS_DEF_PHOTO','/upload/news/default.jpg');
  define ('NEWS_PHOTOS','/upload/news/');


  define ('PHOTO_DIR', DOC_ROOT.'/upload/user_photos/');
  define ('USER_PHOTOS', '/upload/user_photos/');
  define ('ALBUMS_PHOTOS',DOC_ROOT.'/upload/albums_thumbs/');
  define ('ALBUMS_WEBPHOTOS','/upload/albums_thumbs/');
  define ('MEETINGS_PHOTOS',DOC_ROOT.'/upload/meetings/');
  define ('BOARD_PHOTOS',DOC_ROOT.'/upload/board_photos/');
  define ('BOARD_WEBPHOTOS','/upload/board_photos/');

  define ('MAIL_PHOTOS',DOC_ROOT.'/upload/mail_photos/');
  define ('MAIL_WEBPHOTOS','/upload/mail_photos/');

  define ('UGON_PHOTOS',DOC_ROOT.'/upload/ugon_photos/');
  define ('UGON_WEBPHOTOS','/upload/ugon_photos/');

  define ('ALBUM_DIR',DOC_ROOT.'/images/albums/');
  define ('CATALOG_PHOTOS',DOC_ROOT.'/images/catalog/pic/');
  define ('CATALOG_LOGOS',DOC_ROOT.'/images/catalog/logo/');

/**
 * attachments upload directory.
 */
  // define('ATTACHMENT_DIR', DOC_ROOT.'/upload/attachments/');
  define('ATTACHMENT_DIR', DOC_ROOT.'/upload/mail_photos/');

  // for using ImageMagick on server for saving photos
  define ('LOCALHOST',true);

/**
 * Папка с базой GeoIp
 */
  define('GEOIP_DIR', DOC_ROOT.'/upload/geoip/');

/**
 * Передавать ли исключительные ситуации
 */
  define('THROW_EXCEPTIONS', true);

/**
 * Определяет, можно ли использовать короткие урлы для пользоватлей (http://login.users.host/)
 */
  define('USE_USER_PATH', true);

/**
 * Определяем Windows или *nix.
 */
 if (!defined('PATH_SEPARATOR')) define('PATH_SEPARATOR', getenv('COMSPEC') ? ';' : ':');
 if (!defined('DIRECTORY_SEPARATOR')) define('DIRECTORY_SEPARATOR', '/');

/**
 * Устанавливаем пути поиска файлов и классов.
 */
  set_include_path(
      '.' . PATH_SEPARATOR .
      ENGINE_DIR . PATH_SEPARATOR .
      ZEND_DIR . PATH_SEPARATOR .
      SOCNET_DIR . PATH_SEPARATOR .
      PEAR_DIR . PATH_SEPARATOR .
      SMARTY_DIR . PATH_SEPARATOR .
      SMARTY_DIR_PLUGINS . PATH_SEPARATOR .
      str_replace('.:','',get_include_path()) . PATH_SEPARATOR
  );

/**
 * Настройки php
 */
  error_reporting(0);
  ini_set('display_errors', 0);

/**
 * Zend
 */
  require_once 'Zend.php';

/**
 * Функция автоматической загрузки классов.
 * Используем вместе с функцией ZF loadClass.
 *
 * @param string $className
 */
  function class_autoloader($className) {
      Zend_Loader::loadClass($className);
  }

  spl_autoload_register("class_autoloader");

  // Начало генерации страницы
  global $start_time;

/**
 * Загружаем конфигурационные файлы.
 */

/* Конфиг TMS */
  $cfgTms  = new Zend_Config_Xml( CONFIG_DIR . "cfg.tms.xml", 'tms');

/*
 * Конфиг сайта
 */
  $cfgSite = new Zend_Config_Xml(CONFIG_DIR."cfg.site.xml", 'site');
  $cache = Socnet_Cache::getFileCache();

  define('BASE_URL',                  'http://'.$cfgSite->base_http_host);
  define('BASE_URL_SECURE',           'https://'.$cfgSite->base_http_host);
  define('BASE_HTTP_HOST',            $cfgSite->base_http_host);
  define("SITE_NAME_AS_STRING",       $cfgSite->site_name_as_string);
  define("SITE_NAME_AS_STRING_UPPER", strtoupper($cfgSite->site_name_as_string));
  define("SITE_NAME_AS_DOMAIN",       $cfgSite->site_name_as_domain);
  define("SITE_NAME_AS_FULL_DOMAIN",  $cfgSite->site_name_as_full_domain);
  define("DOMAIN_FOR_EMAIL",          $cfgSite->domain_for_email);
  define("PREFIX", 'SOCNET_');

  // Config for details:
  define( "ALL_DETAILS_MARKS" , -1 );
  define( "ALL_DETAILS_MODELS", -2 );
  define( "BIKES",  1 );
  define( "DETAILS",2 );
  define( "OUTFIT", 3 );

  define( "DETAILS_TRADEMARK", 3 );
  define( "OUTFIT_TRADEMARK" , 2 );
  define( "BIKES_TRADEMARK"  , 1 );

  define( "BOARD_MAX_ADS", 3);

  // Basic defines for timing functions.
  define('SECOND',1);
  define('MINUTE',60 * SECOND);
  define('HOUR',  60 * MINUTE);
  define('DAY',   24 * HOUR);
  define('WEEK',  7  * DAY);
  define('MONTH', 30 * DAY);
  define('YEAR',  365* DAY);

  /*
   * Минимальный размер одного списка
   * для пагинатора
   * */
  define('MAX_NUMBER_LINE',  30);
  define('MIN_NUMBER_LINE',  30);

/* Конфиг базы данных */
  $cfgDb = new Zend_Config_Xml( CONFIG_DIR . "cfg.db.xml", 'database');

/**
 * Стартуем сессию.
 */
  //$session = new Zend_Session_Namespace(SITE_NAME_AS_STRING_UPPER);
  //Zend_Registry::set('Session', $session);
  session_start();
  $SWFUploadID = (isset($_REQUEST['SWFUploadID'])) ? $_REQUEST['SWFUploadID'] : null;
  if ( $SWFUploadID !== null ) {
      session_id($SWFUploadID);
  }

/**
 * Используем или нет БД. Параметр в конфиге.
 */
  if ($cfgDb->use == 'true'){
      $params = array (
          'host'     => $cfgDb->host,
          'username' => $cfgDb->username,
          'password' => $cfgDb->password,
          'dbname'   => $cfgDb->name
      );

      try
      {
          $db = Zend_Db::factory($cfgDb->type, $params);
          Zend_Db_Table::setDefaultAdapter($db);
          Zend_Registry::set("DB", $db);

          $sql = "SET NAMES utf8";
          $db->query($sql);

          $fields = array(
  					'left' => 'cleft',
  					'right' => 'cright',
  					'level' => 'clevel'
  				 );
          $gbl_db_tree = new Socnet_DBTree('','','');

          Zend_Registry::set('DBTREE', $gbl_db_tree);

      }catch (Zend_Db_Adapter_Exception $error) {
          die("<p style='font-size:11px;'>Извините, на портале проводятся технические работы. Попробуйте зайти позже.</p>");
      }
  }

  final class Socnet {

      static public $locale           = 'ru';
      static public $controllerName   = 'index';
      static public $actionName       = 'index';
      static public $urlParams        = '';

      /**
       * Parse the scheme-specific portion of the URI and place its parts into instance variables.
       */
      static function parseURI() {
          $params = explode('/', $_SERVER['QUERY_STRING']);
          $params = explode('/', $_SERVER['REQUEST_URI']);

          self::$urlParams = $params;

          if ( isset($params[1]) && $params[1] != '') {

          	if ($params[1] != ADMIN_DIR_NAME) {
                      if ( isset($params[1]) && $params[1]!='' ) {
                          self::$controllerName = $params[1];
                      }
                      if (isset($params[2]) && $params[2]!='')  {
                          self::$actionName = $params[2];	// это контент сайта
                      }

          	} else {
          		define('ADMIN_MODE', true);
          		if ( isset($params[2]) && $params[2]!='' ) {
                              self::$controllerName = $params[2];
                          }

      			if (isset($params[3]) && $params[3]!='') {
      			 self::$actionName = $params[3];	// это контент сайта
                          }
          	}
          }
      }

      public static function t($key) {
          return $key;
      }
  }

/**
 * Создаем объект страницы
 */
  $page = new Socnet_Common_Page();
  Zend_Registry::set("Page", $page);

/**
 * Создаем объект аутентификации.
 */
  $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'user', 'login', 'pass');
  Zend_Registry::set("Auth", $authAdapter);

/**
 * Создаем объект пользователя
 */
  $_SESSION['user_id'] = ( !isset($_SESSION['user_id']) ) ? null : $_SESSION['user_id'];
  $user = new Socnet_User("id", $_SESSION['user_id']);
  //$user->updateLastAccessDate();
  $page->_user =& $user;
  $page->Template->assign("user", $user);
  Zend::register("User", $user);

/**
 *  Название сайта по-умолчанию. Прописано в конфиге.
 */
  $page->Template->assign('SITE_NAME', iconv("UTF-8","Windows-1251", $cfgSite->name));


/**
 * 
 */
  $page->Template->assign('BASE_HTTP_HOST', BASE_HTTP_HOST);

/**
 * данные из конфига.
 */
  $page->Template->assign('SITE_NAME_AS_STRING', SITE_NAME_AS_STRING);
  $page->Template->assign('SITE_NAME_AS_DOMAIN', SITE_NAME_AS_DOMAIN);
  $page->Template->assign('SITE_NAME_AS_FULL_DOMAIN', SITE_NAME_AS_FULL_DOMAIN);
  $page->Template->assign('DOMAIN_FOR_EMAIL', DOMAIN_FOR_EMAIL);

/**
 *
 */
  $page->Template->assign('USE_USER_PATH', USE_USER_PATH);

/**
 * Устанавливаем папки для шаблонов Smarty.
 */
  $page->Template->setTemplatesDir(DOC_ROOT.'/templates/');
  $page->Template->setCompiledDir(DOC_ROOT.'/var/_compiled/site/');

/**
 * Дополнительные настройки Smarty.
 */
  $page->Template->setDebug(false);
  // Цвет иконак в админке
  define("ICON_FOLDER", 'gray_dark');
  $page->Template->assign('icon_page', '/images/admin/icon/' . ICON_FOLDER);

/**
 * Временные функции для дебага.
 */
 function print_f($array = null, $param = false){
   echo '<pre class="preMessage">';
   print_r($array);
   echo '</pre>';
   if($param)
     die();
 }
function print_t($text = null, $param = false){
  echo '<div class="preMessage">';
  print($text);
  echo '</div>';
  if($param)
    die();
}
