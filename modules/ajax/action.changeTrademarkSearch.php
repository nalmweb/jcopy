<?php
    $objResponse = new xajaxResponse();
    $objResponse->addScript('var models = document.getElementById("modelId");');
    $objResponse->addScript('models.disabled = false;');
    $objResponse->addScript('models.length = 0;');
    $objResponse->addScript('models.options.add(new Option("[Все модели]", "0"));');
        
    if ( $markId !== 0 )
    {
        $model = new Socnet_Catalog_Model_List($markId);
        $model->setIdTrademark( $markId );
        $model->returnAsAssoc(true);
        $models = $model->getList();
        
        ksort($models);
         
        foreach ( $models as $_id => $_name ) {
            $objResponse->addScript('models.options.add(new Option("'.$_name.'","'.$_id.'"));');
        }
    }