<?php
	$objResponse = new xajaxResponse();
	$objResponse->addScript('var kinds = document.getElementById("kindId");');
	$objResponse->addScript('kinds.disabled=false;');
	$objResponse->addScript('kinds.length = 0;');
	$objResponse->addScript('kinds.options.add(new Option("[Выберите вид]", "0"));');
	// $objResponse->addAlert("mark =$markId");
	
	if($markId!=0)
	{
	   $model=new Socnet_Catalog_Outfit_List();
	   $types = $model->getKinds($markId);
	   
	  if(!empty($types))
	  {  
		   ksort($types);
		    
		   foreach ( $types as $_id => $_name )
		   {
		      $objResponse->addScript('kinds.options.add(new Option("'.$_name.'","'.$_id.'"));');
		   }
	  }
	  else
	  {
	  	$_name = "Без вида";
	  	$_id = 0;
	  	//$objResponse->addScript('kinds.options.add(new Option("'.$_name.'","'.$_id.'"));');
	  	$objResponse->addScript('kinds.disabled="disabled";');
	  }  
	}
	return $objResponse;