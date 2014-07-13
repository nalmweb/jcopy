<?php
define('START_TIME', $start_time = array_sum(explode (' ', microtime())));

function debug($var){
    echo '<pre>';
    var_dump($var);
    die();
}

function fdump ()
{
    $fh=fopen("log.txt","a+");
    if($fh==null)return;
	$arg_list = func_get_args ();
	///echo '<pre style="text-align:left">';
	foreach ($arg_list as $v)
	{
		$res=print_r($v,true);
		fwrite($fh,$res);
		fwrite($fh,"\n");
	}
	fclose($fh);
	//echo '</pre>';
}


function fdumpFile($filename)
{
    $fh=fopen($filename,"a+");
    if($fh==null)return;
	   $arg_list = func_get_args ();
	   
	///echo '<pre style="text-align:left">';
	$count =0;
	foreach ($arg_list as $v)
	{
		if($count==0)
		{
			$count ++;
			continue;
		}
		$res=print_r($v,true);
		fwrite($fh,$res);
		fwrite($fh,"\n");
	}
	fclose($fh);
}

function shouldLog()
{
   $flag = 1;
   return $flag;	
}

/**
 *  URL: site/trademark/BMW/
 *  @param: $aUrlParams - array ([0] =>site, 1=>action, 2=>trademark,3=>BMW); 
 *  @param: $param	    - trademark ->
 *  @return: next value after param, i.e. BMW goes after trademark;
 *  TODO: some filter? intval, string value?
 */
function getUrlParam($param){
	
	$aUrlParams = Socnet::$urlParams; 
	
	for($i = 0; $i < count ( $aUrlParams ); $i ++) {
		if ($aUrlParams [$i] == $param) {
			if (isset ( $aUrlParams [$i + 1] ))
				return $aUrlParams [$i + 1]; else
				return null;
		}
	}
}

function isLogged()
{
    global $login;
	return $login=="logged";
}

function isValidSession()
{
	$sid = isset($_SESSION['user_id'])?$_SESSION['user_id']:null;
	return !empty($sid);
}
 
// prepend array with a value.
/**
 *  @param: $value
 *  @param: $array - the array to work on
 *  @param: $index - optional
 */ 
function array_prepend($value,$array,$index=null){
   
   if(empty($index))
   	 $out = array("0"=>$value);
   else
   	 $out = array($index=>$value);	
   
   foreach ($array as $key =>$value){
 	  $out[$key]=$value;
   }
   return $out;
} 
 
function dump() {
	$arg_list = func_get_args ();
	echo '<pre style="text-align:left">';
	foreach ( $arg_list as $v ) {
		print_r ( $v );
		echo "\n";
	}
	echo '</pre>';
}

function dump_str()
{
	$arg_list = func_get_args ();
	$res = '';
	
	foreach ( $arg_list as $v ) {
		$res .= print_r ( $v,true);
		$res .= "\n";
	}
	return $res;
}
/**
 * Функция валидации логина и пароля пользователя в базе
 */
function validateLogin($fields)
{
	if(isset ($fields ['login']) && isset ($fields ['pass']))
	  if (false === Socnet_User::validateLogin($fields ['login'], $fields ['pass'] )) {
	 	 return array ('login' => 'Неправильные логин или пароль' );
	 }
	return true;
}

// ctrl = 'registration'.
/**
 *  users:
 *    1) get code 	
 *    2) check the code is correct
 *    3) set pending = active
 *    4) init user by code
 *    5) redirect user to change password.
 *    6) change pwd using ajax?
 */
/*if( $_SERVER['HTTP_HOST'] == "www.motofriends.ru" )
 header ("Location: http://motofriends.ru");*/
//else if ($_SERVER['HTTP_HOST']=="line3.motofriends.ru")
//  header ("Location: http://line3.motofriends.ru");

//echo $_SERVER['HTTP_HOST'];
global $login;
// подключаем основые модули
require_once ('core/Socnet.php');
// парсим URL
Socnet::parseURI ();

// имя модуля
$page->Template->assign ( 'MOD_NAME', Socnet::$controllerName );
// имя экшена  
$page->Template->assign ( 'ACTION_NAME', Socnet::$actionName );

if (false !== strpos (Socnet::$actionName,"&"))
{	
   Socnet::$actionName = '';
   //$query_string = $_SERVER['QUERY_STRING'];
   $query_string = $_SERVER['REQUEST_URI'];
   // **&sadf => **
   $pos = strpos($query_string,'&');
   $query_string = substr($query_string,0,$pos);
   // ***?sadf => ***
   $request_uri =  $_SERVER['REQUEST_URI'];
   $pos = strpos($request_uri,'?');
   $request_uri = substr($request_uri,0,$pos);
   $_SERVER['QUERY_STRING'] = $query_string;
   $_SERVER['REQUEST_URI']  = $request_uri;
}

# Дефолтные настройки отображеня (404)
$page->Template->assign('MOD_ACTION_NAME', Socnet::$controllerName . "_" . Socnet::$actionName );
$page->Template->assign('bodyContent', 'pagenotfound.tpl');
$page->Template->assign('menu', '_design/menu_content/menu_content.tpl');

/*
 * Выводим окно аутентификации если пользователь не залогинился
 * Создаем форму для логина.
 */
  $form = new Socnet_QuickForm_Page ( 'loginForm', 'post', '/', true);
  $login= 'login';

# Проверяем кукисы:
if ( Socnet_Http_Cookie::getCookieNamed ( 'SOCNET_LOGIN' ) &&
     Socnet_Http_Cookie::getCookieNamed ( 'SOCNET_PASS' ) &&
    (bool) Socnet_Http_Cookie::getCookieNamed ( 'SOCNET_REMEMBER' ) === true
    )
  {
    # Если опознали по данным из кукисов.
    if (Socnet_User::authenticate(Socnet_Http_Cookie::getCookieNamed('SOCNET_LOGIN'), Socnet_Http_Cookie::getCookieNamed('SOCNET_PASS'))){
      # Запомним
      Socnet_Session::rememberMe ();
      # Загружаем Entity по 'login'
      $user = new Socnet_User( 'login', Socnet_Http_Cookie::getCookieNamed ( 'SOCNET_LOGIN' ) );
      # id пользователя в сессию!
	    $_SESSION ['user_id'] = $user->getId();
	  }
}else{
	# Генерируем новый Id для сессии.,т.к. юзер не учтен в системе.
	Socnet_Session::regenerateId();
}

//print_f($user->getAdmin(),true);
$controllerName = Socnet::$controllerName;

if($controllerName=="registration" ){
  # Check for code:
	$code = getUrlParam(Socnet::$urlParams,'code');
	if(!empty($code)){
	  $db   = Zend_Registry::get("DB");
	  $user = new Socnet_User('register_code',$code);

	  if(!empty($user)){
	  	$db->update("user",array("status" =>"active")," id = ".$user->getId());
	  	$login = "logged";
	  	Socnet_User::authenticate ( $user->getLogin(), $user->getPass() );

	  	# Установка пользователя
		  Zend_Registry::set("User", $user );
      $page->_user = &$user;
      $_SESSION['user_id'] = $user->getId();
	  }
	}
}

# Если юзер не залогинен - показываем ему форму дл логина:
if (! $page->_user->getId()){
	$items = array ( );
	$items ['login'] = new HTML_QuickForm_text ( 'login', 'Логин:', array ('style' => 'width:100px;', 'class' => 'in' ) );
	$items ['password'] = new HTML_QuickForm_password ( 'password', 'Пароль:', array ('style' => 'width:100px;', 'class' => 'in' ) );
	$items ['rememberme'] = new HTML_QuickForm_advcheckbox ( 'rememberme', '', 'запомнить' );
	$items ['submit'] = new Socnet_QuickForm_submit ( 'submit', 'ВХОД', 'gray' );

	$form->addElements ( $items );
	$form->addRule ( 'login', 'Enter please Username', 'required' );
	$form->addRule ( 'password', 'Enter please Password', 'required' );
	$form->addFormRule ( 'validateLogin' );

	# если форма валидна
	if ($form->validate ()){
		# получаем данные
		$form_data = $form->exportValues();

		# аутентифицируем.
		if ( Socnet_User::authenticate ( $form_data['login'], md5 ( $form_data ['password'] ) )){
			# если надо - запоминаем
			if ($form_data ['rememberme'] == 1) {
				Socnet_Session::rememberMe ( );
			}

			# Меняем статус
			$DB = Zend_Registry::get("DB");
      $sql = $DB->select()->from("user")->where("login =?",$form_data['login']);
			$rs = $DB->fetchAll($sql);

			if(!empty($rs))
        # Проверяем на pending...
			  if($rs[0]['status'] == 'pending')
			  	$login="login";
			  elseif($rs[0]['status'] == 'active')
			  	$login="logged";
			else
				$login = 'logged';

			# Создаем объект пользователя.
			$user = new Socnet_User('login', $form_data['login']);
			Zend_Registry::set("User", $user);
      $page->_user = & $user;
      $_SESSION['user_id'] = $user->getId();
		}
	}else{
	  # Не создаем пользователя, ибо форма инвалидна.
		$user = new Socnet_User ( 'id', null );
	}

	$renderer = new Socnet_QuickForm_Renderer_ArraySmarty($page->Template);
	$form->accept($renderer);
	$page->Template->assign('loginFormData', $renderer->toArray());

}else{
	$user = new Socnet_User('id', $_SESSION['user_id']);
	$login = 'logged';
}


$page->Template->assign('user', $page->_user );
$page->Template->assign('loginContent', "{$login}.tpl" );

try{
	$path = defined ( "ADMIN_MODE" ) ? "/" . ADMIN_DIR_NAME : "";

	if (Zend_Loader::isReadable ( DOC_ROOT . "/modules/" . Socnet::$controllerName . "/config.xml" )) {
		$config = new Zend_Config ( new Zend_Config_Xml ( DOC_ROOT . $path . "/modules/" . $controllerName . "/config.xml", 'module' ) );
		Zend_Registry::set ( "Config", $config );
	}

	Zend_Registry::set('map_params', $_POST);

	Socnet_Controller_Front::run ( DOC_ROOT . '/modules/' . $controllerName );
	$page->Template->assign ( 'controller', $controllerName );
	$page->Template->assign ( 'action', Socnet::$actionName );

	$active[$controllerName] = "select";

	$page->Template->assign ('activemenu',$active);
}catch( Exception $error ){

	$page->Template->assign ( 'error', $error );
	$page->Template->assign ( 'bodyContent', 'error.tpl' );

}


# Инициализируем Ajax
$page->initAjax();
$page->Template->render($page->Template->layout);

//printf("<center><small>Страница сгенерирована за %f секунд</small></center>", (array_sum(explode (' ', microtime())) - START_TIME));

?>