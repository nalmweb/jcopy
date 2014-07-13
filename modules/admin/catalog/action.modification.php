<?

$this->_page->Xajax->registerUriFunction("changeTrademark", "/ajax/changeTrademark/");
$this->_page->Xajax->registerUriFunction("selectModel", "/admin/selectModel/");
$this->_page->Xajax->registerUriFunction("setVisibleModification", "/admin/setVisibleModification/");

$form = new Socnet_Form('selectModel', "POST");

// set html elements

$markList = new Socnet_Catalog_Trademark_List();
$markList->setIdTypeAuto(1);
$markList->returnAsAssoc(true);
$marks = $markList->getList();
$marks[0] = "[Выберите производителя]";
ksort($marks);
$this->_page->Template->assign('marks', $marks);

if (isset($this->params['modelId'])) {
  $model = new Socnet_Catalog_Model_List($this->params['modelId']);
  $model->returnAsAssoc(true);
  $models = $model->getList();
  $this->_page->Template->assign('models', $models);
  
  if (isset($this->params['modelId'])) {

    if (isset($this->params['modification'])) {
      $new = $this->params['modification']['new'];
      unset($this->params['modification']['new']);
      if ('' !== trim($new)) {
        $modelModification = new Socnet_Catalog_Model_Modification_Item();
        $modelModification->setIdModel($this->params['modelId']);
        $modelModification->setModification($new);
        $modelModification->save();
        unset($modelModification);
      }
      if (sizeof($this->params['modification']) > 0) {
        foreach ($this->params['modification'] as $key => $name) {
          if ('' !== trim($name)) {
            $modelModification = new Socnet_Catalog_Model_Modification_Item($key);
            $modelModification->setIdModel($this->params['modelId']);
            $modelModification->setModification($name);
            $modelModification->save();
          } else {
            $modelModification = new Socnet_Catalog_Model_Modification_Item($key);
            $modelModification->delete();
          }
          unset($modelYear);
        }
      }
    }
    $this->_page->Template->assign('modelId', $this->params['modelId']);
  }

  $modelModification = new Socnet_Catalog_Model_Modification_List();
  $modelModification->setIdModel($this->params['modelId']);
  $modelModification->returnAsAssoc();
  $Modification = $modelModification->getList();
  $this->_page->Template->assign('modification', $Modification);
  $this->_page->Template->assign('markId', $this->params['markId']);

}

$this->_page->Template->assign('form', $form);

$this->_page->Template->assign('bodyContent', 'admin/catalog/modification.tpl');
$this->_page->Template->assign('menuTab','catalog');
$this->_page->Template->assign('menuPodTab','modification');