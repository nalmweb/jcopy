<?php
    $objResponse = new xajaxResponse();
      
    if ( null !== $markId && 0 !== $markId)
    {
    $objResponse->addClear('models_block', 'InnerHTML');
    $form = new Socnet_Form('changeModels', 'POST', '/admin/models/');
    $this->_page->Template->assign('form',$form);
        $model = new Socnet_Catalog_Model_List( $markId );
        $model->returnAsAssoc(false);
        $model->setOrder('name ASC');
        $models = $model->getList();
    
    $this->_page->Template->assign('models', $models);
    $this->_page->Template->assign('markId', $markId);
    
    $objResponse->addScript("document.getElementById('models_block').style.display = 'block'");
    $output = $this->_page->Template->getContents ( 'admin/catalog/modelsBlock.tpl' ) ;
    $objResponse->addAssign ( 'models_block', 'innerHTML', $output ) ;
    }