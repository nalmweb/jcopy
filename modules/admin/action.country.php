<?php

$form = new Socnet_QuickForm_Page('countries', 'post', '/admin/countries/', false);
$form->addElement('text','country', 'Введите название новой страны:', array('id' => 'country', 'style' => 'width: 400px'));

$form->applyFilter('country','trim');
$form->addFormRule('uniqueCountry');

//MAX_NUMBER_LINE

if ($form->validate()){
  $fields = $form->getSubmitValues();
  $oCountry = new Socnet_Location_Country();
  $oCountry->name = $fields['country'];
  $oCountry->save();
}else
  $this->_page->Template->assign('errors', $form->getElementError('country'));

$form->addElement('submit', 'submitForm', 'Сохранить');

$renderer = new Socnet_QuickForm_Renderer_ArraySmarty($this->_page->Template);
$form->accept($renderer);

$countries = new Socnet_Location();

$paginator = new Socnet_Paginator_Item('http://' . BASE_HTTP_HOST . '/admin/countries/', $countries->getCountriesCount());
$pgr = $paginator->getInfo();
$this->_page->Template->assign('pgr', $pgr);

$countries_array = $countries->getCountriesListAssoc($pgr['current']);
$this->_page->Template->assign('countries_array', $countries_array);


$this->_page->setTitle('Админка::Страны');
$this->_page->Template->assign('formContent', $renderer->toArray());

$this->_page->Template->assign(array('bodyContent'   => 'admin/country.tpl'));
$this->_page->Template->assign('menuPodTab','country');

function uniqueCountry($fields){
  if (true === Socnet_Location_Country::isCountryExists($fields['country'])){
      return array('country' => "Страна \"{$fields['country']}\" в базе уже существует.");
  }
  return true;
}

?>
