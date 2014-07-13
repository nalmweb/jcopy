<?php

$objResponse = new xajaxResponse();
$id_modification = 13;
if ($id_modification && $id_modification != 0) {

  $propertyList = new Socnet_Catalog_Property_List();
  $propertyList->returnAsAssoc(false);
  $aPropertyList = $propertyList->getList();

  $modification = new Socnet_Catalog_Model_Modification_Item($id_modification);

  $tmpProps = array();
  if ($modification->getProperties())
    foreach ($modification->getProperties() as $key => $val) {
      $tmpProps[$val->getIdProperty()] = $val;
    }

  $propertyList->returnAsAssoc(true);
  $taProp = $propertyList->getList();
  foreach ($taProp as $key => $v) {
    if (isset($tmpProps[$key])) {
      $taProp[$key] = $tmpProps[$key];
    } else {
      $tmp = new Socnet_Catalog_Model_Property_Item();
      $tmp->setIdProperty($key);
      $tmp->setIdModification($id_modification);
      $taProp[$key] = $tmp;
    }

    if ($taProp[$key]->getProperty()->getIdTypeProperty() == 3) {
      foreach ($taProp[$key]->getValuesListData()->getData() as $keys => $item) {
        $objResponse->addScript('document.getElementById("name_'. $keys .'").checked = '. ($taProp[$key]->checkPropertyValueList($keys, 'id_modification', $modification->getId()) ? 'true' : 'false') .';');
      }
    } else {
      $objResponse->addScript('document.getElementById("Tproperty'. $taProp[$key]->getProperty()->getId() .'").value = "'. $taProp[$key]->getValue() .'";');
    }
  }
}

return $objResponse;