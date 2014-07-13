<?php
  if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  } elseif (!$this->_page->_user->isAdmin()){
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  }
   
   $form = new Socnet_Form('setProperties', "POST");
   $this->_page->Xajax->registerUriFunction("changeTrademark","/ajax/changeTrademark/");
   $this->_page->Xajax->registerUriFunction("changeModel","/ajax/changeModel/");
   $this->_page->Xajax->registerUriFunction("changeModification","/admin/changeModification/");

   $this->_page->Xajax->registerUriFunction("loadModelProperty","/admin/loadModelProperty/");

   $this->_page->Xajax->registerUriFunction("setBikeCategories","/admin/setBikeCategories/");
   $this->_page->Xajax->registerUriFunction("saveData","/admin/saveModificationProperties/");
   //set html elements
   
   $markList = new Socnet_Catalog_Trademark_List();
   $markList->setIdTypeAuto( 1 );
   $markList->returnAsAssoc(true);
   $marks = $markList->getList();
   $marks[0] = "[Выберите производителя]";
   ksort($marks);
   $this->_page->Template->assign('marks', $marks );
   $modelList = new Socnet_Catalog_Model_List();
   $modelList->returnAsAssoc( );
   $models = $modelList->getList();
   $this->_page->Template->assign('models', $models );
  
   $form->addRule('markId','Выберите, пожалуйста, производителя.','nonzero');                                                               
         ini_set('memory_limit', '36M');
   $this->_page->Template->assign('form', $form);

   $this->_page->Template->assign('bodyContent', 'admin/catalog/modificationProperties.tpl');

$this->_page->Template->assign('menuTab','catalog');
$this->_page->Template->assign('menuPodTab','setPropModification');

?>