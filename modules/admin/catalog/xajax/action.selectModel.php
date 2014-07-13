<?php
    $objResponse = new xajaxResponse();
      
    if ( null !== $modelId && 0 !== $modelId)
    {
        $objResponse->addClear('modification_block', 'InnerHTML');
        $form = new Socnet_Form('changeModification', 'POST', '/admin/modification/');
        $this->_page->Template->assign('form',$form);

        $model = new Socnet_Catalog_Model_Item( $modelId );

        $modelModification = new Socnet_Catalog_Model_Modification_List( $modelId );
        $modelModification->setIdModel( $modelId );
        $modelModification->returnAsAssoc(false);
        $modelsModification = $modelModification->getList();

        //print_f($modelsModification);

        $this->_page->Template->assign('modelId', $modelId);
        $this->_page->Template->assign('modification', $modelsModification);
        $this->_page->Template->assign('markId', $model->getIdTrademark() );

        $objResponse->addScript("document.getElementById('models_block').style.display = 'block'");
        $output = $this->_page->Template->getContents ( 'admin/catalog/modificationBlock.tpl' ) ;
        $objResponse->addAssign ( 'modification_block', 'innerHTML', $output ) ;
    }