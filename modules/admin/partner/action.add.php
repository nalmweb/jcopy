<?
// Class
$form = new Socnet_QuickForm_Page('countries', 'post', '/admin/partnerAdd/', false);
$countries = new Socnet_Location();

// Register url
$this->_page->Xajax->registerUriFunction("changeCountry","/ajax/changeCountry/");

// Add element
$form->addElement('text','name', 'Введите имя*:', array('id' => 'name', 'style' => 'width: 400px'));
$form->addElement('text','site_url', 'Адрес сайта:', array('id' => 'site_url', 'style' => 'width: 400px'));
$form->addElement('text','password_key', 'Пароль доступа*:', array('id' => 'password_key', 'style' => 'width: 400px'));
$form->addElement('textarea','description', 'Описание:', array('id' => 'description', 'style' => 'width: 400px'));
$form->addElement('text','unique', 'Уникальных поситителей:', array('id' => 'unique', 'style' => 'width: 400px'));
$form->addElement('text','price', 'Цена размещения (за 1 день)*:', array('id' => 'price', 'style' => 'width: 400px'));
$form->addElement('text','penalty', 'Пеня:', array('id' => 'penalty', 'style' => 'width: 400px'));
$form->addElement('textarea','information', 'Информация о платных услугах:', array('id' => 'information', 'style' => 'width: 400px'));
$form->addElement('text','min_day', 'Минимальное время размещение (в днях):', array('id' => 'min_day', 'style' => 'width: 400px'));
$form->addElement('text','short_number', 'Короткий номер:', array('id' => 'short_number', 'style' => 'width: 400px'));
$form->addElement('text','custom_id', 'Костомный id:', array('id' => 'custom_id', 'style' => 'width: 400px'));

$form->addElement('text','longitude', 'Широта:', array('id' => 'longitude', 'style' => 'width: 400px'));
$form->addElement('text','latitude', 'Долгота:', array('id' => 'latitude', 'style' => 'width: 400px'));

$countryArray = $countries->getCountriesListAssoc();
$form->addElement($f2 = new HTML_QuickForm_select('countryId', 'Страна*:', $countryArray, array('id' => 'countryId', 'style' => 'width:400px;', 'onChange' => 'xajax_changeCountry(this.options[this.selectedIndex].value)')));
$form->addElement('select','cityId', 'Город:', array('[Выберите город]'), array('id' => 'cityId', 'style' => 'width: 400px'));

// Filter
$form->applyFilter('name','trim');
$form->applyFilter('site_url','trim');
$form->applyFilter('password_key','trim');
$form->applyFilter('unique','intval');
$form->applyFilter('price','trim');
$form->applyFilter('penalty','trim');
$form->applyFilter('min_day','trim');
$form->applyFilter('short_number','trim');
$form->applyFilter('custom_id','trim');


// Form rule
$form->addFormRule('uniquePartner');

// Save
// Edit
if(isset($this->params['id'])
      && is_numeric($this->params['id'])
      && $this->params['id'] != 0
      && isset($this->params['param'])
      && $this->params['param'] == 'edit'){
  $partner = new Socnet_Partner_Item('id', $this->params['id']);

  $form->setDefaults(array(
    'site_url'    => $partner->getSiteUrl(),
    'unique'      => $partner->getUnique(),
    'price'       => $partner->getPrice(),
    'min_day'     => $partner->getMinDay(),
    'name'        => $partner->getName(),
    'password_key'=> $partner->getPasswordKey(),
    'penalty'     => $partner->getPenalty(),
    'short_number'=> $partner->getShortNumber(),
    'custom_id'   => $partner->getCustomId(),
    'latitude'    => $partner->getLatitude(),
    'longitude'   => $partner->getLongitude(),
    'information' => $partner->getInformation(),
    'description' => $partner->getDescription(),
    'countryId'   => $partner->getCountryId(),
    'cityId'      => $partner->getCityId(),
  ));

  $this->_page->Template->assign('partnerId', $this->params['id']);

}elseif ($form->validate()) {

  $fields = $form->getSubmitValues();
  $partner = new Socnet_Partner_Item();
  $partner->setId($fields['id']);
  $partner->setCityId($fields['cityId']);
  $partner->setCountryId($fields['countryId']);
  $partner->setName($fields['name']);
  $partner->setSiteUrl($fields['site_url']);
  $partner->setPasswordKey($fields['password_key']);
  $partner->setUnique($fields['unique']);
  $partner->setPrice($fields['price']);
  $partner->setPenalty($fields['penalty']);
  $partner->setMinDay($fields['min_day']);
  $partner->setShortNumber($fields['short_number']);
  $partner->setCustomId($fields['custom_id']);
  $partner->setLatitude($fields['latitude']);
  $partner->setLongitude($fields['longitude']);
  $partner->setInformation($fields['information']);
  $partner->setDescription($fields['description']);

  $partner->save();
  header('Location: /admin/partnerList/');

}elseif(count($form->getElementErrorAll()) != 0)
  $this->_page->Template->assign('errors', 'Ошибка запроса, подробности ниже');
else
  $form->setDefaults(array(
    'site_url' => 'http://',
    'unique' => '0',
    'price' => '0',
    'min_day' => '0',
    'price' => '0',
    'id' => '0',
  ));


$form->addElement('submit', 'submitForm', 'Сохранить');
$form->addElement('button', 'cancelForm', 'Отмена', array('onClick' => ''));

// Other
$renderer = new Socnet_QuickForm_Renderer_ArraySmarty($this->_page->Template);
$form->accept($renderer);

$this->_page->setTitle('Админка::Добавить каталог');
$this->_page->Template->assign('formContent', $renderer->toArray());

$this->_page->Template->assign('partnerId', (isset($this->params['id']) ? $this->params['id'] : null));
$this->_page->Template->assign(array('bodyContent'   => 'admin/partner/add.tpl'));

$this->_page->Template->assign('menuPodTab','partneradd');
$this->_page->Template->assign('menuTab','partner');

function uniquePartner($fields){
  if (true === Socnet_Location_Country::isCountryExists($fields['countryId'])){
    return array('countryId' => "Страна в базе уже существует.");
  }

  if($fields['name'] == ''){
    return array('name' => 'Укажите имя');
  }

  if($fields['price'] == ''){
    return array('price' => 'Укажите цену');
  }

  if(!is_numeric($fields['price'])){
    return array('price' => 'Цену должна быть числом');
  }

  if($fields['password_key'] == ''){
    return array('price' => 'Укажите пароль доступа');
  }

  return true;
}