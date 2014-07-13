<?php
if (!$this->_page->_user->isAuthenticated()) {
  $this->_redirect('http://' . BASE_HTTP_HOST . '/');
} elseif (!$this->_page->_user->isAdmin()) {
  $this->_redirect('http://' . BASE_HTTP_HOST . '/');
}


$objResponse = new xajaxResponse();
if (null !== $params) {
  $model = new Socnet_Catalog_Model_Year_Item($params['modelGodId']);
  $model->deleteProperties();

  if (isset($params['dp']) && is_array($params['dp'])) {
    if (isset($params['pp']) && in_array($params['pp'], $params['dp'])) {
      unset($params['pp']);
    }
    Socnet_Catalog_Metadata_Item::deleteByIds($params['dp']);
  }

  if (isset($params['pp'])) {
    $photoId = Socnet_Catalog_Metadata_Item::getIdByName($params['pp']);
    $model = new Socnet_Catalog_Model_Year_Item($params['modelGodId']);
    $model->setIdPhoto($photoId);
    $model->save();
  }

  foreach ($params['property'] as $key => $value)
  {
    if ( (int)$value > 0 && $key > 0 ) {
      $prop = new Socnet_Catalog_Model_Year_Property_Item(  );
      $prop->setIdModelGod( $params['modelGodId'] );
      $prop->setIdProperty( $value );
      $prop->setValuesList( $key );
      $prop->save();
    }
  }

  foreach ($params['Tproperty'] as $key => $value)
  {
      if ( '' !== trim( (string)$value ) && $key != 35 ) {
          $prop = new Socnet_Catalog_Model_Year_Property_Item(  );
          $prop->setIdModelGod( $params['modelGodId'] );
          $prop->setIdProperty( $key );
          $prop->setValue( $value );
          $prop->save();
      }
  }

  $objResponse->addRedirect(BASE_URL . '/admin/setPropYears/');
}
?>