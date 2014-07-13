<?php

    $objResponse = new xajaxResponse();
    
    $objResponse->addScript('var metroes = document.getElementById("metroId");');
    $objResponse->addScript('metroes.length = 0;');
    $objResponse->addScript('metroes.options.add(new Option("[Выберите метро]", "0"));');
    
    if ( $cityId != 0 ) {
        $city = new Socnet_Location_City($cityId);
        $metroes = $city->getMetroesListAssoc();
        foreach ( $metroes as $_id => $_name ) {
            $objResponse->addScript('metroes.options.add(new Option("'.$_name.'","'.$_id.'"));');
        }
    }