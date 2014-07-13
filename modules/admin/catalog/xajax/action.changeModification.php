<?php

$objResponse = new xajaxResponse ();

//очищаем блок с параметрами
$objResponse->addClear('prop_block', 'InnerHTML');

//создаем форму
$form = new Socnet_Form ('changeValues' . 'POST');
$this->_page->Template->assign('form', $form);

$propertyList = new Socnet_Catalog_Property_List ();
$propertyList->returnAsAssoc(false);
$aPropertyList = $propertyList->getList();
$this->_page->Template->assign('propList', $aPropertyList);

$modelModification = new Socnet_Catalog_Model_Modification_Item($modificationId);

$tmpProps = array();
if(is_array($modelModification->getProperties())){
  foreach ($modelModification->getProperties() as $key => $val) {
    $tmpProps [$val->getIdProperty()] = $val;
  }
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
    $tmp->setIdModification($modificationId);
    $taProp [$key] = $tmp;
  }

//  if ($taProp[$key]->getProperty()->getIdTypeProperty() == 3) {
//    foreach ($taProp[$key]->getValuesListData()->getData() as $keys => $item) {
//      echo '<input type="checkbox" id="" value="" '. ($taProp[$key]->checkPropertyValueList($keys, 'id_modification', $modificationId) ? 'checked' : 'false') .'>'. $item .'<br />'; //
//    }
//  } else {
//    echo '<input type="text" id="'. $taProp[$key]->getProperty()->getId() .'" value="'. $taProp[$key]->getValue() .'">';
//  }
//  echo '<br>';

}


$modelModification->setProperties($taProp);

$this->_page->Template->assign('modelGod', $modelModification);
$this->_page->Template->assign('tableValueCheck', 'id_modification');


$objResponse->addScript("document.getElementById('prop_block').style.display = 'block'");
$output = $this->_page->Template->getContents('admin/catalog/changePropertiesValues.tpl');

//print_f($output, true);

$objResponse->addAssign('prop_block', 'innerHTML', $output);

?>