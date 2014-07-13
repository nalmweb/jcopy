<?php
 
 // dump($_POST);  
  if ( isset ( $_POST['photo'] ) )
  {
        // dump($_POST);
         
        foreach($_FILES as $i => $FILE)
        {
            if ($FILE["error"] == 0){  
                 $data = Socnet_File_Item::isImage($FILE["name"], $FILE["tmp_name"]);
                 if ($data === false) {
                    $form->addCustomErrorMessage($FILE["name"]." файл - не рисунок");
                    $error = true;
                    continue;
                 }                 
                 $photos_id = intval($_POST['photo']);
                 $uploaded = false;
                 
                 if(!empty ($photos_id)){
	                 $board    = new Socnet_Board_Photo( $photos_id );
	                 $item_id =  $this->params['item'];
	                 $bUpdate = true;
	                 $board->savePhotos($item_id,$cat_id,$bUpdate);
	                 $uploaded = true;
                 }
            }
        }
      // exit;
   }
   $form=new Socnet_QuickForm_Page('editBike', 'post', "/users/adsEdit/cat/$cat_id/item/$item_id/",true);   
   $this->_page->Xajax->registerUriFunction("changeCountry","/ajax/changeCountry/");
   $this->_page->Xajax->registerUriFunction("changeCity","/ajax/changeCity/");
   $this->_page->Xajax->registerUriFunction("changeTrademarkBoard","/ajax/changeTrademarkBoard/");
   $this->_page->Xajax->registerUriFunction("changeModel","/ajax/changeModel/");
   $this->_page->Xajax->registerUriFunction("changeYearBoard","/ajax/changeYearBoard/");
   $this->_page->Xajax->registerUriFunction("delPhoto","/ajax/delPhoto/");
   $this->_page->Xajax->registerUriFunction("changePhotoDialog","/ajax/changePhotoDialog/");
   
   $modelId=''; $models =""; $markId =""; $cities ="";
   
   // set html elements
   $country = new Socnet_Location();
   $countries = $country->getCountriesListAssoc();
   $countries[0] = "[Выберите страну]";
   ksort($countries);

   // dump($this->params);
    
   if(isset($this->params['markId']) && 0 != $this->params['markId'])
   {
   	// dump ($countries);
   	  $markId = $this->params['markId'];
   	  $this->_page->Template->assign('markId',$markId);
   }
    
   if(isset($this->params['countryId']) && 0 != $this->params['countryId'])
   {
     $this->_page->Template->assign('countryId',$this->params['countryId']);
     $country = new Socnet_Location_Country($this->params['countryId']);
     $cities = $country->getCitiesListAssoc();
    // dump($cities);
   }
   
   if(isset($this->params['cityId']) && 0 != $this->params['cityId'])
   {
     $this->_page->Template->assign('cityId',$this->params['cityId']);
     $city = new Socnet_Location_City($this->params['cityId']);
   }
   
   if(isset($this->params['typeId']) && 0 != $this->params['typeId']){
     $this->_page->Template->assign('typeId',$this->params['typeId']);
   }
   if(isset($this->params['modelId']) && 0 != $this->params['modelId'])
   {
     $modelId = $this->params['modelId'];  
     $this->_page->Template->assign('modelId',$this->params['modelId']);
     //$models
     $modelList = new Socnet_Catalog_Model_List();
     $models    = $modelList->getListAssoc($markId);
   }
   else{
   	$modelList = new Socnet_Catalog_Model_List();
    $models    = $modelList->getListAssoc(4);
   }
   
   if(isset($this->params['year']) && 0 != $this->params['year'] && null != $modelId ){
      $this->_page->Template->assign('year',$this->params['year']);
      $model=new Socnet_Catalog_Model_Year_List();
      $model->setIdModel($modelId);
      $model->returnAsAssoc(true);
      $years = $model->getList();
   }
   
  // $ad = new Socnet_Board_Item($cat_id,$item_id);
  $year_id = 0;
   
   if($_SERVER['REQUEST_METHOD']!='POST'){
	   $modelId=$ad->getModelId();
	   $model=new Socnet_Catalog_Model_Year_List();
	   $model->setIdModel($modelId);
	   $model->returnAsAssoc(true);
	   $years = $model->getList();
	   $year = $ad->getYear();
	   
	   // get the year for current model
	   foreach($years as $key => $value){
	   	 if($value==$year) 
	   	  {
	   	  	 $year_id = $key;
	   	  	 break;
	   	  }
	   }
	   // set models for the checkbox
	    $model = new Socnet_Catalog_Model_List();
        $model->setIdTrademark( $ad->getMarkId() );
        $model->returnAsAssoc(true);
        $models = $model->getList();
         ksort($models);
	   
	   // dump($years);
	   // echo "yearId= = $year_id";
	   //$this->_page->Template->assign('yearId',$year_id );
	   $this->_page->Template->assign('cityId',$ad->getCityId() );
	   
       $country = new Socnet_Location_Country ($ad->getCountryId());
       $cities  = $country->getCitiesListAssoc();
   }
   
   $markList = new Socnet_Catalog_Trademark_List();
   $markList->addWhere("id_type_auto=1");
   $markList->returnAsAssoc(true);
   $marks   =$markList->getList();
   
   $marks[0]="Выберите производителя";
   ksort($marks);
   $bikeType = new Socnet_Catalog_Property_Item();
   $bikeType->setId(1);
   $types = $bikeType->getListData();   
   $types[0]="Укажите тип ;-)";
   ksort($types);
   $form->addElement('select','typeId',null,$types, array( 'id' => 'typeId','style'=>"width:200px;"));
   
   $form->addElement('select','markId',null,$marks, array( 'id' => 'markId',
   														   'onChange'=>"xajax_changeTrademarkBoard(this.options[this.selectedIndex].value,this.options[this.selectedIndex].text);",
   														   'style'=>"width:200px;"));

   $models[0] = "Выберите модель";
   
   if(empty($modelId)){
      $form->addElement('select','modelId',null,$models, array('id' => 'modelId',
   														    'onChange'=>"xajax_changeModel(this.options[this.selectedIndex].value);",
   														    'style'=>"width:200px;"
   														    ));
   }
   else
   {
   	  $form->addElement('select','modelId',null,$models, 
   	  					array('id' => 'modelId','onChange'=>"xajax_changeModel(this.options[this.selectedIndex].value);",
						'style'=>"width:200px;"						
						));
   }
   
   $years[0]="Выберите год";
   ksort($years);
   
   //dump($years);
   if(count($years) ==1 )
   {
     $form->addElement('select','yearId',null,$years, array('id'=>'yearId', 'style'=>"width:200px;",
   												        'onChange'=>"xajax_changeYearBoard(this.options[this.selectedIndex].value,document.getElementById('isYear').value);"
   					  ));
   }
   else
   {
   	$form->addElement('select','yearId',null,$years, array('id'=>'yearId', 'style'=>"width:200px;",
   												        'onChange'=>"xajax_changeYearBoard(this.options[this.selectedIndex].value,document.getElementById('isYear').value);"
   					 ));
   }
   
   $form->addElement('text','volume',null,array('style'=>"width:200px;",'id'=>'volumeId'));
   $form->addElement('text','probeg',null,array('style'=>"width:200px;"));
   $form->addElement('text','kpp',null,array('style'=>"width:200px;",'id'=>'kppId'));
   $form->addElement('text','condition',null,array('style'=>"width:200px;"));
   $form->addElement('text','power',null,array('style'=>"width:200px;",'id'=>'powerId'));
   $form->addElement('checkbox','is_torg',null);
   $form->addElement('select','countryId',null,$countries, array('id' => 'countryId',
                                                                  'onchange'=>"xajax_changeCountry(this.options[this.selectedIndex].value);", 
                                                                  'style'=>"width: 200px;"));
                                                                  
   $cities[0] = 'Выберите город';
   $form->addElement('select','cityId',null,$cities, array('id' => 'cityId','style'=>"width: 200px;"));
                                                            
   $form->addElement('text','title', 'Заголовок:', array('style' => 'width:200px;'));
   $form->addElement('text','price', 'Цена:',  array('style' => 'width:60px;'));
   $form->addElement('text','skype', 'Skype:', array('style'=>"width:200px;",'value'=>$this->_page->_user->skype));
   $form->addElement('text','icq','ICQ:',array('style'=>"width:200px;",'value'=>$this->_page->_user->icq));
   $form->addElement('text','phone','Телефон:',array('style'=>"width:200px;",'value'=>$this->_page->_user->phone));
   $form->addElement('textarea','content', 'Дополнительная иформация:', array('style' => 'width:350px;height:150px'));
   // $form->addElement('text','volume',null,array('style'=>"width:200px;"));
   // photos
   $form->addElement('file','photo_0', 'фото1', array('style' => 'width:180px;'));                                                            	  
   $form->addElement('file','photo_1', 'фото2', array('style' => 'width:180px;'));
   $form->addElement('file','photo_2', 'фото3', array('style' => 'width:180px;'));
   $form->addElement('file','photo_3', 'фото4', array('style' => 'width:180px;'));
   $form->addElement('file','photo_4', 'фото5', array('style' => 'width:180px;'));
  
   $form->addRule('title','Введите, пожалуйста, заголовок.','required'); 
   $form->addRule('markId','Выберите, пожалуйста, производителя.','nonzero');                                                               
   $form->addRule('countryId','Выберите, пожалуйста, страну.','nonzero');
   $form->addRule('cityId','Выберите, пожалуйста, город.','nonzero');   
   $form->addRule('countryId','Выберите, пожалуйста, страну.','required');
   $form->addRule('cityId','Выберите, пожалуйста, город.','required');
   $form->addRule('price','Укажите, пожалуйста, правильную цену.','nonzero');
   $form->addRule('price','Укажите, пожалуйста, правильную цену.','required');
   $form->addRule('condition','Введите, пожалуйста, состояние.','required');
   
   $form->addRule('volume','Укажите, пожалуйста, <b>правильный объем двигателя.</b>','nonzero');
   $form->addRule('volume','Укажите, пожалуйста, объем двигателя.','required');
   $form->addRule('typeId','Укажите, пожалуйста, тип мотоцикла.','nonzero');
   $form->addRule('probeg','Укажите пробег в виде числа, например: 100000000000000.','nonzero');

   if($form->validate())
   {
     $values = $form->getSubmitValues();
     // dump($values);
     // $txt = nl2br($values['content']);
     // echo " <pre> $txt </pre> ";
     // new Socnet_Board_Item($cat_id,$item_id );
     $ad->country_id=$values['countryId'];
     
     if (isset($values['custom_name']) && !empty($values['custom_name'])){
       $ad->model_id=0;
       $ad->mark_id=70;
     }
     else{
       $ad->model_id=$values['modelId'];// $values['year'];
       $ad->mark_id =$values['markId'];
     }
     $ad->setUserId($_SESSION['user_id']);
	 $ad->type_id=$values['typeId'];     	 
     $ad->user_id=$_SESSION['user_id'];
     $ad->probeg=$values['probeg'];
     $ad->power=$values['power'];
     $ad->kpp=$values['kpp'];
     $ad->title=$values['title'];
          
     $ad->custom_name=isset($values['custom_name'])?$values['custom_name']:'';
     $ad->condition=$values['condition'];
     $ad->volume=$values['volume'];
     $ad->skype=$values['skype'];
     // get only numbers!
     $ad->icq =preg_replace("/\D/","",$values['icq']);
     $ad->phone=$values['phone'];
     $ad->city_id=$values['cityId'];
     $ad->price_rur=$values['price'];
     
     $torg = isset ($values['is_torg'])?$values['is_torg']:0;
     $ad->setIsTorg($torg);
     // $ad->year=$_POST['year'];	
     $year = isset($_POST['year'])?$_POST['year']:0;
     
     if(empty($year)){
     	$year = isset($_POST['yearId'])?$_POST['yearId']:0;
     }
     
     if(!empty($year)){
       $modelYear = new Socnet_Catalog_Model_Year_Item($year);
       $ad->year=$modelYear->getYear();
     }
     else
         $ad->year=0;
	  
	 // clear from unnecessary tags
      $ad->content= Socnet_Censure::removeTags($values['content']);
      $id=$ad->save();
      //echo "[$id]" ;
      // add photos:
      // exit;
      $boardPhotos= new Socnet_Board_Photo();
      $boardPhotos->savePhotos($id,$cat_id);
      // exit;
      $this->_redirect('http://'.BASE_HTTP_HOST."/users/ads/cat/$cat_id/item/$item_id/");
   }
   // --->
   $form->setDefaults( array (
					   'typeId' => $ad->getTypeId(),   
					   'markId' => $ad->getMarkId(),   	
					   'modelId'=> $ad->getModelId(),   
					   'yearId'   => $year_id,///$ad->getYear(),
					   'volume' => $ad->getVolume(),
					   'probeg' => $ad->getProbeg(),
					   'kpp'	=> $ad->getKpp(),
					   'condition'=> $ad->getCondition(),
					   'power'=> $ad->getPower(), 
					   'is_torg'=> $ad->getIsTorg(),
					   'countryId'=> $ad->getCountryId(),                                                                  
					   'cityId' => $ad->getCityId(),                                                            
					   'title' => $ad->getTitle(), 
					   'price' => $ad->getPrice(), 
					   'skype' => $ad->getSkype(), 
					   'icq' => $ad->getIcq(),
					   'phone'=> $ad->getPhone(),
					   'content' => $ad->getContent() 
                       )
                      );
   // 	                      
   $photos =$ad->getImages();
   $this->_page->Template->assign('photos',$photos);
   $numPhotos = $ad->getNumPhotos();
   $maxPhotos = 5;
   $rand = mt_rand(0,13120);
   $this->_page->Template->assign('rand', $rand ); 
   $this->_page->Template->assign('maxPhotos', $maxPhotos );      
   $this->_page->Template->assign('numPhotos', $numPhotos );
   $this->_page->Template->assign('item_id',$item_id);   
   $this->_page->Template->assign('cat_id',$cat_id);
   
   $this->_page->Template->assign('js', Socnet_Photo_Config::getJS());
   $photos_type = Socnet_Photo::getIdByPhotoTable("board__bikes");
   $this->_page->Template->assign('photos_type',$photos_type);                         
   
   $renderer = new Socnet_QuickForm_Renderer_ArraySmarty($page->Template);
   $form->accept($renderer);
   $this->_page->Template->assign('formContent', $renderer->toArray());
   $this->_page->Template->assign('bodyContent', 'users/private/board.edit.bike.tpl');
?>
