<?php
// user authorization is required
if (! $this->_page->_user->hasAccess ( $this->currentUser )) {
	$this->_redirect ( '/' );
}

$this->_page->Xajax->registerUriFunction ( "changeTrademark", "/ajax/changeTrademark/" );
$this->_page->Xajax->registerUriFunction ( "changeModel", "/ajax/changeModel/" );

$this->_page->Xajax->registerUriFunction("changeCountry","/ajax/changeCountry/");
$this->_page->Xajax->registerUriFunction("changeCity","/ajax/changeCity/");

$cfgGmap = new Zend_Config ( new Zend_Config_Xml ( CONFIG_DIR . "cfg.gmap.xml", 'gmap' ) );

$form = new Socnet_QuickForm_Page ( 'editUserProfile', 'post', "/users/edit/id/{$this->currentUser->id}", true );

if ($form->validate ()) {
	$values = $form->getSubmitValues ();
	$this->currentUser->cityId = $values ['cityId'];
	$this->currentUser->intro = $values ['intro'];
	$this->currentUser->street = $values ['street'];
	$this->currentUser->apartment = $values ['apartment'];
	//        $this->_page->_user->nikname = $values['nikname'];
	$this->currentUser->firstname = $values ['firstname'];
	$this->currentUser->lastname = $values ['lastname'];
	$this->currentUser->middlename = $values ['middlename'];
	$this->currentUser->birthday = $values ['birthday'] ['Y'] . '-' . $values ['birthday'] ['F'] . '-' . $values ['birthday'] ['d'];
	$this->currentUser->birthdayPrivate = $values ['birthdayPrivate'];
	//       $this->_page->_user->view_as = $values['view_as'];
	$this->currentUser->metroId = isset( $values ['metroId'] ) ? $values ['metroId'] : null;
	$this->currentUser->gender = $values ['gender'];
    $this->currentUser->company = $values ['company'];
	$this->currentUser->post = $values ['post'];
	$this->currentUser->skype = $values ['skype'];
	$this->currentUser->icq = preg_replace("/\D/", '', $values ['icq']);
	$this->currentUser->homepage = preg_replace('/^http\:\/\/|^https\:\/\/|^ftp\:\/\//i', '',  $values ['homepage'] );
	$this->currentUser->msn = $values ['msn'];
	$this->currentUser->livejournal = $values ['livejournal'];
	$this->currentUser->phone = $values ['phone'];
	$this->currentUser->build = $values ['build'];
	$this->currentUser->profitId = $values ['profit'];
	$this->currentUser->latitude = $values ['lat'];
	$this->currentUser->longitude = $values ['lon'];
	$this->currentUser->zoom = $values ['zoom'];
	
	if ($values ['utilityes']) {
		$this->currentUser->saveUtility ( $values ['utilityes'] );
	}
	
	if (isset ( $this->params ['newBike'] ) && '' !== trim ( $this->params ['newBike'] )) {
		$data ['userId'] = $this->currentUser->getId ();
		$data ['request'] = $this->params ['newBike'];
		$request = new Socnet_Admin_Collection ( );
		$request->addRequestToNewBike ( $data );
		$this->currentUser->setBikeId ( new Zend_Db_Expr ( 'null' ) );
	} else {
	    if ( isset( $this->params ['years'] ))
		  $this->currentUser->setBikeId ( $this->params ['years'] );
		else $this->currentUser->setBikeId ( new Zend_Db_Expr ( 'null' ) );
	}
	
	$this->currentUser->save ();
	$this->_redirect ( $this->currentUser->getUserPath ( 'profile' ) );
}

$this->_page->Template->assign ( 'login', $this->currentUser->login );
$form->addElement ( 'text', 'nikname', 'Ник: ' );
$form->addElement ( 'text', 'firstname', 'Фамилия: ' );
$form->addElement ( 'text', 'lastname', 'Имя: ' );
$form->addElement ( 'text', 'middlename', 'Отчество: ' );
$form->addElement ( 'date', 'birthday', 'Дата рождения:', array ('language' => 'ru', 'format' => 'dFY', 'minYear' => 1920, 'maxYear' => date ( 'Y', time () ) ) );
$form->addElement ( 'advcheckbox', 'birthdayPrivate', null, null, null, array (0, 1 ) );
$profit = new Socnet_User_Profit ( $this->currentUser->profitId );
$profit_array = $profit->getListToSelect ();
$profit_array [0] = "[ Укажите сферу деятельности ]";
ksort ( $profit_array );

$form->addElement ( 'select', 'profit', 'Сфера Деятельности:', $profit_array );
$form->addElement ( 'select', 'gender', 'Пол:', array ('male' => "Мужчина", 'female' => "Женщина" ) );
$form->addElement ( 'text', 'company', 'Компания: ' );
$form->addElement ( 'text', 'post', 'Должность: ' );
$form->addElement ( 'text', 'skype', 'Skype: ' );
$form->addElement ( 'text', 'icq', 'ICQ: ' );
$form->addElement ( 'text', 'msn', 'MSN: ' );
$form->addElement ( 'text', 'livejournal', 'LiveJournal: ' );
$form->addElement ( 'text', 'homepage', 'Домашняя страница: ' );
$form->addElement ( 'text', 'phone', 'Телефон: ' );

$utility = new Socnet_User_Utility ( );
$utility_array = $utility->setUtilityListAssoc ();

$aUserUtil = $this->currentUser->getUserUtilityes ();

foreach ( $utility_array as $key => $value ) {
	$elements [] = $form->addElement ( 'advcheckbox', $key, "", $value, null, $value );
	if (array_key_exists ( $key, $aUserUtil ))
		$form->setDefaults ( array ($key => $value ) );
}

$form->addGroup ( $elements, 'utilityes', "Полезность", "<br />" );
    
    $countries = array(); $cities = array(); $metroes = array();
    $country = new Socnet_Location();
    $countries = $country->getCountriesListAssoc();
    $countries[0] = "[Выберите страну]";
    ksort($countries);
    
    if ( !isset( $this->params['cityId'] ) || 0 == $this->params['cityId']) {
        $city = new Socnet_Location_City( $this->currentUser->cityId );
    } else {
        $city = new Socnet_Location_City( $this->params['cityId'] );
        $this->_page->Template->assign('cityId',$this->params['cityId']);
    }
    
    if ( !isset( $this->params['countryId'] ) || 0 == $this->params['countryId'] ) {
        $this->_page->Template->assign('countryId',$city->countryId);
        $country = new Socnet_Location_Country($city->countryId);
    } else {
        $this->_page->Template->assign('countryId',$this->params['countryId'] );
        $country = new Socnet_Location_Country( $this->params['countryId'] );
    }
    
    $cities = $country->getCitiesListAssoc();
    $metroes = $city->getMetroesListAssoc();

    $form->addElement('select','countryId',null,$countries, array('id' => 'countryId',
                                                                  'onchange'=>"xajax_changeCountry(this.options[this.selectedIndex].value);", 
                                                                  'style'=>"width: 200px;"));    
    $form->addElement('select','cityId',null,$cities, array('id' => 'cityId',
                                                            'onchange'=>"xajax_changeCity(this.options[this.selectedIndex].value);", 
                                                            'style'=>"width: 200px;"));
    $form->addElement('select','metroId',null,$metroes, array('id' => 'metroId',
                                                              'style'=>"width: 200px;"));

$form->addElement ( 'text', 'name', 'realname' );
$form->addElement ( 'text', 'street', 'улица' );
$form->addElement ( 'text', 'build', 'дом/корпус', array ('style' => 'width:50px;' ) );
$form->addElement ( 'text', 'apartment', 'кв.', array ('style' => 'width:30px;' ) );

$form->addElement ( 'textarea', 'intro', 'Информация о себе:', array ('style' => 'height: 100px; width: 520px;' ) );

$form->addElement ( 'hidden', 'lat', '', array ('id' => 'lat' ) );
$form->addElement ( 'hidden', 'lon', '', array ('id' => 'lon' ) );
$form->addElement ( 'hidden', 'zoom', '', array ('id' => 'zoom' ) );

$form->addElement ( 'submit', 'submitForm', 'Сохранить', array ('onClick' => 'getIframeCoord();' ) );

$TMList = new Socnet_Catalog_Trademark_List ( );
$TMList = $TMList->returnAsAssoc ()->getList ();

$TMList [0] = "[Передвижного средства не имею]";
ksort ( $TMList );

$modelsList = new Socnet_Catalog_Model_List ( );
$modelsYearList = new Socnet_Catalog_Model_Year_List ( );

if (null !== $this->currentUser->getBikeId () && 0 !== $this->currentUser->getBikeId ()) {
	
	$form->setDefaults ( array ('marks' => $this->currentUser->getBike ()->getModel ()->getIdTrademark () ) );
	
	$form->setDefaults ( array ('models' => $this->currentUser->getBike ()->getIdModel () ) );
	$modelsList->setIdTrademark ( $this->currentUser->getBike ()->getModel ()->getIdTrademark () );
	
	$form->setDefaults ( array ('years' => $this->currentUser->getBikeId () ) );
	$modelsYearList->setIdModel ( $this->currentUser->getBike ()->getIdModel () );
	
	$models = $modelsList->returnAsAssoc ()->getList ();
	$modelsYear = $modelsYearList->returnAsAssoc ()->getList ();
} else {
	$bike = Socnet_Admin_Collection::getCustomBukeForUser ( $this->currentUser );
	if (null !== $bike) {
		$this->_page->Template->assign ( 'custom_bike', $bike );
	}
	$models = array();
	$modelsYear = array();
}


    $form->addElement ( 'select', 'marks', null, $TMList, array ('id' => 'markId', 'style' => "width: 200px;", 'onChange' => "xajax_changeTrademark(this.options[this.selectedIndex].value);" ) );
    
    $form->addElement ( 'select', 'models', null, $models, array ('id' => 'modelId', 'style' => "width: 200px;", 'onChange' => "xajax_changeModel(this.options[this.selectedIndex].value);" ) );
    
    $form->addElement ( 'select', 'years', null, $modelsYear, array ('id' => 'yearId', 'style' => "width: 200px;" ) );

$birthday = strtotime ( $this->currentUser->birthday );


$form->setDefaults ( array ('countryId' => $city->countryId, 
                            'intro' => $this->currentUser->intro, 
                            'street' => $this->currentUser->street, 
                            'build' => $this->currentUser->build, 
                            'apartment' => $this->currentUser->apartment, 
                            'nikname' => $this->currentUser->nikname, 
                            'firstname' => $this->currentUser->firstname, 
                            'lastname' => $this->currentUser->lastname, 
                            'middlename' => $this->currentUser->middlename, 
                            'cityId' => $this->currentUser->cityId, 
                            'metroId' => $this->currentUser->metroId, 
                            'birthday' => array ('Y' => date ( "Y", $birthday ), 
                                                 'F' => date ( "n", $birthday ), 
                                                 'd' => date ( "d", $birthday ) ), 
                            'gender' => array ($this->currentUser->gender ), 
                            'company' => $this->currentUser->company, 
                            'post' => $this->currentUser->post, 
                            'skype' => $this->currentUser->skype, 
                            'icq' => $this->currentUser->icq, 
                            'homepage' => $this->currentUser->homepage, 
                            'msn' => $this->currentUser->msn, 
                            'livejournal' => $this->currentUser->livejournal, 
                            'phone' => $this->currentUser->phone, 
                            'profit' => $this->currentUser->profitId, 
                            'lat' => $this->currentUser->latitude, 
                            'lon' => $this->currentUser->longitude, 
                            'zoom' => $this->currentUser->zoom, 
                            'birthdayPrivate' => $this->currentUser->birthdayPrivate )
 );

$renderer = new Socnet_QuickForm_Renderer_ArraySmarty ( $page->Template );
$form->accept ( $renderer );

$map = new Socnet_Google_MapAPI ( );
$map->setAPIKey ( $cfgGmap->google_map_key );

$zoom = $this->currentUser->zoom != null ? $this->currentUser->zoom : 10;

$map->prepareMap ( $zoom, 530 );

if ($this->currentUser->latitude > 0 && $this->currentUser->longitude > 0) {
	$map->addMarkerByCoords ( $this->currentUser->longitude, $this->currentUser->latitude, '', '', true );
} else {
	$map->addMarkerByAddress ( "Moscow", '', '', true );
}

// assign Smarty variables;
$this->_page->Template->assign ( 'google_map_header', $map->getHeaderJS () );
$this->_page->Template->assign ( 'google_map_js', $map->getMapJS () );
$this->_page->Template->assign ( 'google_map', $map->getMap () );
$this->_page->Template->assign ( 'enableGmap', true );
$this->_page->Template->assign ( 'onload_attributes', 'onload="onLoad()"' );

//   dump($form);
$this->_page->Template->assign ( 'formContent', $renderer->toArray () );
$this->_page->Template->assign ( 'bodyContent', 'users/edit.tpl' );