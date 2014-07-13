<?php
    $objResponse = new xajaxResponse();
    $objResponse->addScript('var types = document.getElementById("typeId");');
    $objResponse->addScript('types.length = 0;');
    $objResponse->addScript('types.options.add(new Option("[Выберите тип]", "0"));');
    //$objResponse->addAlert("mark =$markId");
    
    if ( $markId !== 0 )
    {
        $model = new Socnet_Catalog_Property_List($markId);
        $model->setIdTypeProperty($markId);
        $model->returnAsAssoc(true);
        $models = $model->getList();
        
        ksort($models);
         
        foreach ( $models as $_id => $_name ) {
            $objResponse->addScript('types.options.add(new Option("'.$_name.'","'.$_id.'"));');
        }
    }