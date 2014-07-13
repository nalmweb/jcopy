<?php
    $objResponse = new xajaxResponse();
 
    if ( null !== $modificationId && 0 !== $modificationId)
    {
        $objResponse->addClear('years_block', 'InnerHTML');
        $form = new Socnet_Form('changeYears', 'POST', '/admin/years/');
        $this->_page->Template->assign('form',$form);
        
        //$model = new Socnet_Catalog_Model_Item( $modificationId );

        $modelYear = new Socnet_Catalog_Model_Year_List( $modificationId );
        $modelYear->setIdModification( $modificationId );
        $modelYear->returnAsAssoc(false);
        $modelsYear = $modelYear->getList();
            
        $this->_page->Template->assign('modificationId', $modificationId);
        $this->_page->Template->assign('years', $modelsYear);
        
        //$this->_page->Template->assign('markId', $model->getIdTrademark() );
        $this->_page->Template->assign('markId', $markId );
        $this->_page->Template->assign('modelId', $modelId );
        
        $objResponse->addScript("document.getElementById('models_block').style.display = 'block'");
        $output = $this->_page->Template->getContents ( 'admin/catalog/yearsBlock.tpl' ) ;
        $objResponse->addAssign ( 'years_block', 'innerHTML', $output ) ;
    }  
    
//    
//    if ( null !== $modelId && 0 !== $modelId)
//    {
//        $objResponse->addClear('years_block', 'InnerHTML');
//        $form = new Socnet_Form('changeYears', 'POST', '/admin/years/');
//        $this->_page->Template->assign('form',$form);
//        
//        $model = new Socnet_Catalog_Model_Item( $modelId );
//
//        $modelYear = new Socnet_Catalog_Model_Year_List( $modelId );
//        $modelYear->setIdModel( $modelId );
//        $modelYear->returnAsAssoc(false);
//        $modelsYear = $modelYear->getList();
//            
//        $this->_page->Template->assign('modelId', $modelId);
//        $this->_page->Template->assign('years', $modelsYear);
//        $this->_page->Template->assign('markId', $model->getIdTrademark() );
//        
//        $objResponse->addScript("document.getElementById('models_block').style.display = 'block'");
//        $output = $this->_page->Template->getContents ( 'admin/catalog/yearsBlock.tpl' ) ;
//        $objResponse->addAssign ( 'years_block', 'innerHTML', $output ) ;
//    }