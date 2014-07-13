<?php

    $objResponse = new xajaxResponse();
/*
    $objResponse->addScript('var models = document.getElementById("yearId");');    
    $objResponse->addScript('models.disabled = false;');
    $objResponse->addScript('models.length = 0;');
    $objResponse->addScript('models.options.add(new Option("[Выберите модель]", "0"));');
*/
    $objResponse->addScript('var nick = document.getElementById("nick");');
    $objResponse->addScript('nick.style.backgroundColor=#000;');
    
    /*$objResponse->addAlert(dump_str($markId));
    return $objResponse;*/ 
    // get bike type
    // set helmet icon:
    /*
       document.getElementById('nick').style.backgroundImage = "url(/images/helmets/chopper.gif)";
       document.getElementById('nick').style.background = "background-repeat:no";
    */
    // dump_str()
    // markId = Это id модели, а нам надо idModelGod 
    $year = $values['year'];
    $modelId = $values['modelId'];
    
    $sql = $this->_db->select()->from('catalog__model_god')->where("id_model=?",$modelId)->where("god=?",$year);
    $id_model_god=$this->_db->fetchOne($sql);
//  $objResponse->addAlert("model=$modelId, model_god=$id_model_god");
    $bike 	= new Socnet_Catalog_Model_Year_Item ($id_model_god); 
    $helmetImg='';
   /* 
    if ( null == $bike->getCategory() )
        $category = 'чоппер';
    else 
    	$category = $bike->getCategory()->getName();
    switch ($category){
        case 'чоппер': 
            $helmetImg = '/images/helmets/chopper.gif';
            break;
        case 'спорт':
            $helmetImg = '/images/helmets/sport.gif';
            break;
        case 'кросс':
            $helmetImg = '/images/helmets/cross.gif';
            break;
        default:
            $helmetImg = '/images/helmets/sport.gif';
    }
   */
   $helmetImg = '/images/helmets/';
   $category = $bike->getCategory();
   // $objResponse->addAlert("cat=[".$category);
    if ( null == $category )
        $category = 'спорт';
    else 
    	$category = $bike->getCategory()->getName();
    	
    switch ($category)
    {
        case 'чоппер':
        case 'туристический': 
            $helmetImg .= 'chopper.gif';
            break;
        case 'спорт':
        case 'супер-спорт' :
        case 'спорт-турист' : 
        case 'дорожный' : 
        case 'нейкед' : 
        case 'макси-скутер' : 
            $helmetImg .= 'sport.gif';
            break;
        case 'кроссовый':
        case 'эндуро':
        case 'мотард':
            $helmetImg .= 'cross.gif';
            break;
            
        default:
            $helmetImg .= 'sport.png';
    }
    $objResponse->addScript('document.getElementById("nick").style.backgroundImage ="url('.$helmetImg.')"');
    $objResponse->addScript("document.getElementById('nick').style.backgroundRepeat = 'no'");
    $objResponse->addScript("document.getElementById('nick').style.backgroundColor = '#000'");
	$objResponse->addScript("document.getElementById('nick').style.paddingLeft = '25px'");
	$objResponse->addScript("document.getElementById('nick').style.width = '429px'");
/*} else {
	
}
    $helmetImg .= 'sport_helmet.png';
*/
    
    
/*
if ( null !== $this->currentUser->getBikeId() ) 
{
    $bike = $this->currentUser->getBike();
    
    if ( null == $bike->getCategory() )
        $category = 'чоппер';
    else 
    	$category = $bike->getCategory()->getName();
    switch ($category){
        case 'чоппер':
        case 'туристический ': 
            $helmetImg .= 'chopper_helmet.png';
            $helmetImgShadow = '';
            break;
        case 'спорт':
        case 'супер-спорт' :
        case 'спорт-турист' : 
        case 'дорожный' : 
        case 'нейкед' : 
        case 'макси-скутер' : 
            $helmetImg .= 'sport_helmet.png';
            $helmetImgShadow = '';
            break;
        case 'кроссовый':
        case 'эндуро':
        case 'мотард':
            $helmetImg .= 'cross_helmet.png';
            $helmetImgShadow = '';
            break;
            
        default:
            $helmetImg .= 'sport_helmet.png';
            $helmetImgShadow = '';
    }
} else {
    $helmetImg .= 'sport_helmet.png';
    $helmetImgShadow = '';
}
*/
    
    // $objResponse->addAlert("name=$name");
    
      
   /*if ( $markId !== 0 )
   {
        $model = new Socnet_Catalog_Model_List($markId);
        $model->setIdTrademark( $markId );
        $model->returnAsAssoc(true);
        $models = $model->getList();
        
        ksort($models);
         
        foreach ( $models as $_id => $_name ) {
            $objResponse->addScript('models.options.add(new Option("'.$_name.'","'.$_id.'"));');
        }
      // change icon
      $objResponse->addScript('document.getElementById("nick").style.backgroundImage ="url('.$helmetImg.')"');
      $objResponse->addScript("document.getElementById('nick').style.background = 'background-repeat:no'");
      $objResponse->addScript("document.getElementById('nick').style.backgroundColor = '#000'");
   }*/