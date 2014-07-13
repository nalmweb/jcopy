<?php

    $objResponse = new xajaxResponse();
    
    $objResponse->addScript('var cities = document.getElementById("cityId");');
    $objResponse->addScript('cities.length = 0;');
    $objResponse->addScript('cities.options.add(new Option("[Выберите город]", "0"));');
    
    $objResponse->addScript('var metroes = document.getElementById("metroId");');
    $objResponse->addScript('metroes.length = 0;');
    $objResponse->addScript('metroes.options.add(new Option("[Выберите метро]", "0"));');
    
    // $objResponse->addAlert("=".$countryId);
    
    if ( !$countryId == 0 ) {
        $country = new Socnet_Location_Country($countryId);
        $cities = $country->getCitiesListAssoc();
        foreach ( $cities as $_id => $_name ) {
            $objResponse->addScript('cities.options.add(new Option("'.$_name.'","'.$_id.'"));');
        }
    }