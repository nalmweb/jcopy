<?php
// Если уже залогинены - отправляемся на главную станицу
// dump($this->_page->_user);

if ($this->_page->_user->id){
   $this->_redirect('/');
}
$this->_page->Xajax->registerUriFunction("changeTrademark","/ajax/changeTrademark/");
$this->_page->Xajax->registerUriFunction("changeModel","/ajax/changeModel/");

$this->_page->Xajax->registerUriFunction("changeCountry","/ajax/changeCountry/");
$this->_page->Xajax->registerUriFunction("changeCity","/ajax/changeCity/");

$form = new Socnet_QuickForm_Page('registrationForm', 'post', '/registration/',true);

$verify_code                = (isset($_SESSION['verify_code'])) ? $_SESSION['verify_code'] : null;
$verify_image               = Socnet_Image_Captcha::generateCaptcha($verify_code);
$_SESSION['verify_code']    = $verify_code;

$form->getRegisteredRules();
$form->addElement(new Socnet_QuickForm_errorsummary());

$form->addElement('text','nikname', 'Ник:', array('style' => 'width:180px;', 'id' => 'nikname'));

$form->addElement('date','birthday', 'Дата рождения:',
				  array('language' => 'ru', 'format' => 'dFY', 'minYear' => 1950, 'maxYear' => date('Y',time())));

$form->addElement('date','experience', 'Опыт с:',
				  array('language' => 'ru', 'format' => 'FY', 'minYear' => 1950, 'maxYear' =>  date('Y',time())));

$form->addElement('text','login', 'Email:', array('style' => 'width:180px;'));
$form->addElement('password','pass', 'Пароль:', array('style' => 'width:180px;'));
$form->addElement('password','pass_confirm', 'и еще раз', array('style' => 'width:180px;'));
$form->addElement('radio','gender', 'Пол:',null,'male',array('checked=/"checked/"'));
$form->addElement('radio','gender','&nbsp;',null,'female',array());
$form->addElement('advcheckbox','birthdayPrivate', null, null, null, array(0,1));

$countries = array(); $cities = array(); $metroes = array();
$country = new Socnet_Location();
$countries = $country->getCountriesListAssoc();
$countries[0] = "[Выберите страну]";
ksort($countries);

if (isset($this->params['countryId']) && 0 != $this->params['countryId']) {
       $this->_page->Template->assign('countryId',$this->params['countryId']);
        $country = new Socnet_Location_Country($this->params['countryId']);
        $cities = $country->getCitiesListAssoc();
}
if (isset($this->params['cityId']) && 0 != $this->params['cityId']) {
    $this->_page->Template->assign('cityId',$this->params['cityId']);
    $city = new Socnet_Location_City($this->params['cityId']);
    $metroes = $city->getMetroesListAssoc();
}
$form->addElement('select','countryId',null,$countries, array('id' => 'countryId',
                                                              'onchange'=>"xajax_changeCountry(this.options[this.selectedIndex].value);",
                                                              'style'=>"width: 200px;"));
$form->addElement('select','cityId',null,$cities, array('id' => 'cityId',
                                                        'onchange'=>"xajax_changeCity(this.options[this.selectedIndex].value);",
                                                        'style'=>"width: 200px;"));
$form->addElement('select','metroId',null,$metroes, array('id' => 'metroId',
                                                          'style'=>"width: 200px;"));
$form->addElement('text','verify_code', 'Введите цифры с картинки:', array('style' => 'width:180px;'));
$form->addElement('static','verify_image', null, $verify_image);
$form->addElement('advcheckbox','agree', null, 'Я согласен(а) с <a href="/info/terms/" target="_blank">Пользовательским соглашением</a>', null, array(0,1));
$form->addElement('hidden', '', null, 'Я согласен(а) с <a href="/info/terms/" target="_blank">Пользовательским соглашением</a>', null, array(0,1));

$form->applyFilter('nikname', 'trim');
$form->applyFilter('login', 'trim');
$form->addRule('login','Введите, пожалуйста, Email.','required');
$form->addRule('login','Введите, пожалуйста, корректный Email.','email');
$form->addRule('nikname','Введите, пожалуйста, ник.','required');
$form->addRule('pass','Введите, пожалуйста, пароль.','required');
$form->addRule('pass','Минимальная длина пароля 6 символов.','minlength', 6);

$form->addRule('pass_confirm','Введите, пожалуйста, подтверждение пароля.','required');
$form->addRule(array('pass', 'pass_confirm'), 'Пароли не совпадают.', 'compare');
//$form->addRule('birthday','Введите, пожалуйста, дату рождения.','required');
$form->addRule('countryId','Выберите, пожалуйста, страну.','nonzero');
$form->addRule('cityId','Выберите, пожалуйста, город.','nonzero');
$form->addRule('cityId','Выберите, пожалуйста, город.','required');
$form->addRule('verify_code','Введите, пожалуйста, верификационный код.','required', null, 'server');
$form->addRule('agree','','required');
$form->addRule('agree', 'Вы должны согласиться с пользовательским соглашением.', 'nonzero');

$form->addFormRule('compareVerifyCode');
$form->addFormRule('uniqueUser');

$form->setDefaults(array(
    'birthday'      => array('Y' => 1990, 'M' => 9, 'd' => 29),
    'experience'    => array('Y' => date('Y',time()), 'M' => date('m',time()), 'd' => date('d',time())),
    )
);

$TMList = new Socnet_Catalog_Trademark_List();
$TMList = $TMList->returnAsAssoc()->getList();

 $TMList[0] = "[У меня нет байка]";
 ksort($TMList);
 $form->addElement('select','marks',null,$TMList, array('id' => 'markId',
                                                          'style'=>"width: 200px;",
                                                          'onChange'=>"xajax_changeTrademark(this.options[this.selectedIndex].value);")
                                                          );

if ( isset( $this->params['marks'] ) && 0 !== $this->params['marks'] ){
    $modelsList = new Socnet_Catalog_Model_List($this->params['marks']);
    $models = $modelsList->returnAsAssoc()->getList();
} else {
    $models = array();
}
$form->addElement('select','models',null,$models, array('id' => 'modelId',
                                                          'style'=>"width: 200px;",
                                                          'onChange'=>"xajax_changeModel(this.options[this.selectedIndex].value);")
                                                          );

if ( isset( $this->params['models'] ) && 0 !== $this->params['models'] ){
    $modelsList = new Socnet_Catalog_Model_Year_List();
    $modelsYear = $modelsList->setIdModel($this->params['models'])->returnAsAssoc()->getList();

} else {
    $modelsYear = array();
}
$form->addElement('select','years',null,$modelsYear, array('id' => 'yearId',
                                                          'style'=>"width: 200px;")
                                                          );

    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    //                                                       //
    //  FORM Hendler
    //                                                       //
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

if (isset($this->params['code']) && $this->params['code']){
    $user = new Socnet_User('register_code', $this->params['code']);
    if (!$user->id || $user->status != 'pending') {
        $this->_redirect('/');
    }

    $user->pkColName = 'id';
    $user->status = 'active';
    $user->save();
    $user->authenticate($user->login,$user->pass);
    $this->_redirect('/registration/registrationcompleted/');

}elseif ($form->validate()){
	
    $user = new Socnet_User();
    $user->setId(null);
	
    $user->setCityId($this->params['cityId']);
    $user->setMetroId(isset($this->params['metroId']) ? $this->params['metroId'] : null);
    $user->setBirthday($this->params['birthday']['Y'].'-'.$this->params['birthday']['F'].'-'.$this->params['birthday']['d']);
    $user->setGender($this->params['gender']);
    $user->setLogin($this->params['login']);
    $user->setPass(md5($this->params['pass']));
    $user->setAdmin(false);
    $user->setStatus('pending');
    $user->setRegisterDate(date('Y-m-d H:i:s', time()));
	  $user->setExperience($this->params['experience']['Y'].'-'.$this->params['experience']['F'].'-01');
    $user->setNikname($this->params['nikname']);
    //$user->setBirthdayPrivate($this->params['birthdayPrivate']);
    $user->setBirthdayPrivate(1);

    $user->setview_as       = 1;
    $user->user_num_comments= 0;

    unset($_SESSION['reg_user']);
    
    //get coords
    $city = new Socnet_Location_City($this->params["cityId"]);
    $user->latitude          =  $city->getLatitude();
    $user->longitude         = $city->getLongitude();
	
    $user->save();

    if ( isset( $this->params['newBike'] ) && '' !==  trim( $this->params['newBike'] ) ){
        $data['userId'] = $user->getId();
        $data['request'] = $this->params['newBike'];
        $request = new Socnet_Admin_Collection();
        $request->addRequestToNewBike($data);
    } elseif ( isset( $this->params['years'] ) ) {
        $user->setBikeId($this->params['years']);    
        $user->save();
    }
    unset($_SESSION['verify_code']);
    $mail_confirm_url = $user->registerCode;

    //  Send message
    $this->_db->query("SET NAMES koi8r");
    $mail = new Socnet_Mail_Template('template_key', 'USER_REGISTER');
    $mail->setEmailCharset('KOI8-R');
    $sender_object = new Socnet_User();
    $mail->setSender($sender_object);
    $mail->addRecipient($user);
    $mail->sendToEmail(true);
    // $mail->sendEmailHTMLPart(true);
    $mail->send();
    
    $this->_db->query("SET NAMES utf8");

    $_SESSION['reg_user'] = array('login'  => $this->params['login']);
    $this->_redirect('/registration/completed/');
}

//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

//$renderer = new Socnet_QuickForm_Renderer_Default();
$renderer = new Socnet_QuickForm_Renderer_ArraySmarty($page->Template);
$form->accept($renderer);

//$this->_page->setTitle('Registration');
$this->_page->Template->assign('form',$form);
$this->_page->Template->assign('formContent', $renderer->toArray());
$this->_page->Template->assign('bodyContent', 'registration/index.tpl');

/**
 * Функция валидации ввода кода верификации
 *
 * @param array $fields
 * @return mixed
 */
function compareVerifyCode($fields){
    //$session = Zend_Registry::get('Session');
    if ( $fields['verify_code'] != $_SESSION['verify_code']) {
        return array('verify_code' => 'Неправильный код проверки.');
    }
    return true;
}

function uniqueUser ($fields){
    if (true === Socnet_User::isUserExists('login',$fields['login'])) {
        return array('login' => 'Пользователь с логином '.$fields['login']. ' уже зарегистрирован в системе.');
    }

    if (true === Socnet_User::isUserExists('nikname',$fields['nikname'])) {
       return array('nikname' => 'Пользователь с ником '.$fields['nikname']. ' уже зарегистрирован в системе.');
    }
    return true;
}