<?php
    $objResponse = new xajaxResponse();
    $objResponse->addScript('var years = document.getElementById("yearId");');
    $objResponse->addScript('years.disabled=false;');
    $objResponse->addScript('years.length = 0;');
    $objResponse->addScript('years.options.add(new Option("[Выберите год]", "0"));');
    // $objResponse->addAlert("mark =$markId");
    if ($modificationId != 0)
    {
        $model=new Socnet_Catalog_Model_Year_List();
        $model->setIdModification($modificationId);
        $model->returnAsAssoc(true);
        $years = $model->getList();
        
        foreach ( $years as $_id => $_name ) {
            $objResponse->addScript('years.options.add(new Option("'.$_name.'","'.$_id.'"));');
        }
    }
    return $objResponse; 