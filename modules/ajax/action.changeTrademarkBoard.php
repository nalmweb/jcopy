<?php

    $objResponse = new xajaxResponse();
    
    $objResponse->addScript('var models = document.getElementById("modelId");');
    $objResponse->addScript('models.disabled = false;');
    $objResponse->addScript('models.length = 0;');
    $objResponse->addScript('models.options.add(new Option("[Выберите модель]", "0"));');
    $objResponse->addScript("hideField('custom_name');");
    $objResponse->addScript("document.getElementById('isYear').value='false';");
    // $objResponse->addScript("document.getElementById('modelId').disabled='enabled';");
    // $objResponse->addAlert("mark =$markId, anme = $markName ");
    // если другой, то год OnChange - ни-ни!  isYear = true;
    // $markName
    /*if ($markName=='Другой' )
    {
	  // $objResponse->addAlert("mark =$markId, anme = $markName ");
	 
	  *   hide modelId, yearId; show custom_name 
	  
	  $objResponse->addScript("showField('custom_name');");
	  $objResponse->addScript("document.getElementById('modelId').disabled='disabled';");
	  // set years: setup a list
	  $objResponse->addScript('var years = document.getElementById("yearId");');
	  $objResponse->addScript('var years.length=0;');
	  $objResponse->addScript('years.disabled = false;');
	  $objResponse->addScript("document.getElementById('isYear').value='true';");	  
	  $years = array_reverse( range ( 1940, date('Y',time())) ) ;
	  // if custom - set another model id!
	  foreach ( $years as $_id => $_name )
	  {
        $objResponse->addScript('years.options.add(new Option("'.$_name.'","'.$_id.'"));');
      }      
    }*/
    
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
    
    return $objResponse;