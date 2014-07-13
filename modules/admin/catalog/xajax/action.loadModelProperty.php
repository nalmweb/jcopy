<?php

$objResponse = new xajaxResponse();

if ($id_model && $id_model != 0) {

  $propertyList = new Socnet_Catalog_Property_List();
  $propertyList->returnAsAssoc(false);
  $aPropertyList = $propertyList->getList();

  $model = new Socnet_Catalog_Model_Item($id_model);

  $tmpProps = array();
  if ($model->getProperties())
    foreach ($model->getProperties() as $key => $val) {
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
      $taProp[$key] = $tmp;
    }

    if ($taProp[$key]->getProperty()->getIdTypeProperty() == 3) {
      foreach ($taProp[$key]->getValuesListData()->getData() as $keys => $item) {
        $objResponse->addScript('document.getElementById("name_'. $keys .'").checked = '. ($taProp[$key]->checkPropertyValueList($keys, 'id_model', $model->getId()) ? 'true' : 'false') .';');
      }
    } else {
      $objResponse->addScript('document.getElementById("Tproperty'. $taProp[$key]->getProperty()->getId() .'").value = "'. $taProp[$key]->getValue() .'";');
    }
  }
}
return $objResponse;