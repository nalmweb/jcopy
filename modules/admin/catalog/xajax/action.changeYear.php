<?php
if (!$this->_page->_user->isAuthenticated()) {
  $this->_redirect('http://' . BASE_HTTP_HOST . '/');
} elseif (!$this->_page->_user->isAdmin()) {
  $this->_redirect('http://' . BASE_HTTP_HOST . '/');
}

$objResponse = new xajaxResponse ();

//очищаем блок с параметрами
$objResponse->addClear('prop_block', 'InnerHTML');
//создаем форму
$form = new Socnet_Form ('changeValues' . 'POST');
$this->_page->Template->assign('form', $form);

$propertyList = new Socnet_Catalog_Property_List ();
$propertyList->returnAsAssoc(false);

$modelView = new Socnet_Catalog_Model_View_Item ('id', $modificationGodId, 'view__catalog_modification_god');


$tmpProps = array();
foreach ($modelView->getProperties() as $key => $val) {
  $tmpProps [$val->getIdProperty()] = $val;
}

$propertyList->returnAsAssoc(true);
$taProp = $propertyList->getList();
foreach ($taProp as $key => $v) {
  if (isset ($tmpProps [$key])) {
    $taProp [$key] = $tmpProps [$key];
  } else {
    $tmp = new Socnet_Catalog_Model_Property_Item ();
    //$tmp->setValue('');
    $tmp->setIdProperty($key);
    $taProp [$key] = $tmp;
  }
}

$modelView->setProperties($taProp);

$this->_page->Template->assign('modelGod', $modelView);
$this->_page->Template->assign('tableValueCheck', 'id_model_god');

$objResponse->addScript("document.getElementById('prop_block').style.display = 'block'");
$output = $this->_page->Template->getContents('admin/catalog/changePropertiesValues.tpl');

//print_f($output, true);

$objResponse->addAssign('prop_block', 'innerHTML', $output);
?>