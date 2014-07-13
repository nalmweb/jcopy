<?php
	// set type, volume, power,
    $objResponse = new xajaxResponse();
    $objResponse->addScript('var models = document.getElementById("yearId");');
    $objResponse->addScript('models.disabled = false;');
    
    if ( $yearId !== 0 )
    {
        $item  = new Socnet_Catalog_Model_Property_Item();
   		$item->setIdModelGod($yearId); // == $idModelGod;
   		// объем двигателя
   		$volume = $item->getPropertyValueById(21);
   		// мощность двигателя.
   		$horsePower = $item->getPropertyValueById(23);   		
   		// КПП-число передач.
   		$kpp = $item->getPropertyValueById(6);
   		$objResponse->addScript("document.getElementById('volumeId').value=$volume;");
   		$objResponse->addScript("document.getElementById('powerId').value =$horsePower;");
   		$objResponse->addScript("document.getElementById('kppId').value   =$kpp;");
    }
    return $objResponse; 
?>