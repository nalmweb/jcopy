<?php
    $objResponse = new xajaxResponse();
    $objResponse->addScript('var modification = document.getElementById("modificationId");');
    $objResponse->addScript('modification.disabled=false;');
    $objResponse->addScript('modification.length = 0;');
    $objResponse->addScript('modification.options.add(new Option("[Выберите модификацию]", "0"));');
    // $objResponse->addAlert("mark =$markId");
    if ($modelId != 0)
    {
        $model=new Socnet_Catalog_Model_Modification_List();
        $model->setIdModel($modelId);
        $model->returnAsAssoc(true);
        $years = $model->getList();
        
        foreach ( $years as $_id => $_name ) {
            $objResponse->addScript('modification.options.add(new Option("'.$_name.'","'.$_id.'"));');
        }
    }
    return $objResponse; 