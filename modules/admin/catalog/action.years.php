<?php
if (!$this->_page->_user->isAuthenticated()) {
  $this->_redirect('http://' . BASE_HTTP_HOST . '/');
} elseif (!$this->_page->_user->isAdmin()) {
  $this->_redirect('http://' . BASE_HTTP_HOST . '/');
}

$this->_page->Xajax->registerUriFunction("changeTrademark", "/ajax/changeTrademark/");
$this->_page->Xajax->registerUriFunction("changeModel", "/ajax/changeModel/");
$this->_page->Xajax->registerUriFunction("selectModel", "/admin/selectModel/");
$this->_page->Xajax->registerUriFunction("selectModification", "/admin/selectModification/");
$this->_page->Xajax->registerUriFunction("setVisibleYear", "/admin/setVisibleYear/");

$form = new Socnet_Form('selectModel', "POST");

// set html elements

$markList = new Socnet_Catalog_Trademark_List();
$markList->setIdTypeAuto(1);
$markList->returnAsAssoc(true);
$marks = $markList->getList();
$marks[0] = "[Выберите производителя]";
ksort($marks);
$this->_page->Template->assign('marks', $marks);

if (isset($this->params['modificationId'])) {
  
  $model = new Socnet_Catalog_Model_List($this->params['markId']);
  $model->returnAsAssoc(true);
  $models = $model->getList();
  $this->_page->Template->assign('models', $models);
  
  if (isset($this->params['modificationId'])) {

    if (isset($this->params['years'])) {
      
      $new = $this->params['years']['new'];
      unset($this->params['years']['new']);
      
      if ('' !== trim($new)) {
        
        $modelYear = new Socnet_Catalog_Model_Year_Item();
        $modelYear->setYear($new);
        $modelYear->setIdModification($this->params['modificationId']);
        $modelYear->save();
        unset($modelYear);
        
      }
      
      if (sizeof($this->params['years']) > 0) {
        foreach ($this->params['years'] as $key => $name) {
          if ('' !== trim($name)) {
            
            $modelYear = new Socnet_Catalog_Model_Year_Item($key);
            $modelYear->setYear($name);
            $modelYear->setIdModification($this->params['modificationId']);
            $modelYear->save();
            
          } else {
            
            $modelYear = new Socnet_Catalog_Model_Year_Item($key);
            $modelYear->delete();
            
          }
          unset($modelYear);
        }
      }
    }
    $this->_page->Template->assign('modelId', $this->params['modelId']);
    $this->_page->Template->assign('modificationId', $this->params['modificationId']);
  }
  
  $modelYears = new Socnet_Catalog_Model_Year_List();
  $modelYears->setIdModification($this->params['modificationId']);
  $modelYears->returnAsAssoc();
  $years = $modelYears->getList();
  $this->_page->Template->assign('years', $years);
 
  $modelModification = new Socnet_Catalog_Model_Modification_List( $this->params['modelId'] );
  $modelModification->setIdModel( $this->params['modelId'] );
  $modelModification->returnAsAssoc(true);
  $modelsModification = $modelModification->getList();
  $this->_page->Template->assign('modification', $modelsModification);  
  
  $this->_page->Template->assign('markId', $this->params['markId']);
  
}

$this->_page->Template->assign('form', $form);
$this->_page->Template->assign('bodyContent', 'admin/catalog/years.tpl');

$this->_page->Template->assign('menuTab', 'catalog');
$this->_page->Template->assign('menuPodTab', 'years');
?>