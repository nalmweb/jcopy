<?php
   
   $cat_id=BIKES;
      
   $this->checkCanAdd($cat_id);

   $form=new Socnet_QuickForm_Page('add', 'post', "/board/addauto/",true);
   
   $this->_page->Xajax->registerUriFunction("changeCountry","/ajax/changeCountry/");
   $this->_page->Xajax->registerUriFunction("changeCity","/ajax/changeCity/");
   $this->_page->Xajax->registerUriFunction("changeTrademarkBoard","/ajax/changeTrademarkBoard/");
   $this->_page->Xajax->registerUriFunction("changeModel","/ajax/changeModel/");
   $this->_page->Xajax->registerUriFunction("changeYearBoard","/ajax/changeYearBoard/");
   
   $modelId='';
   $models ="";
   $markId ="";
   $cities ="";
   $years  ="";

   // OPTIONS
   $options = new Socnet_Board_Options();
   $options_array = $options->setOptionsListAssoc();

   // PRICES
   $prices = new Socnet_Board_Price();
   $prices_array = $prices->setPriceListAssoc();

   // set html elements
   $country = new Socnet_Location();
   $countries = $country->getCountriesListAssoc();
   $countries[0] = "[Выберите страну]";
   ksort($countries);

   if(isset($this->params['markId']) && 0 != $this->params['markId']){
   	  $markId = $this->params['markId'];
   	  $this->_page->Template->assign('markId',$markId);
   	  $modelId = isset($this->params['modelId'])?$this->params['modelId']:0;
   	  
   	  if(empty($modelId)){
   		$modelList = new Socnet_Catalog_Model_List();
    	$models    = $modelList->getListAssoc($markId);
   	  }
   }
    
   if(isset($this->params['countryId']) && 0 != $this->params['countryId']){
     $this->_page->Template->assign('countryId',$this->params['countryId']);
     $country = new Socnet_Location_Country($this->params['countryId']);
     $cities = $country->getCitiesListAssoc();
   }
   
   if(isset($this->params['cityId']) && 0 != $this->params['cityId']){
     $this->_page->Template->assign('cityId',$this->params['cityId']);
     $city = new Socnet_Location_City($this->params['cityId']);
   }
   
   if(isset($this->params['typeId']) && 0 != $this->params['typeId']){
     $this->_page->Template->assign('typeId',$this->params['typeId']);
   }
   if(isset($this->params['modelId']) && 0 != $this->params['modelId']){
   	 
     $modelId = $this->params['modelId'];  
     $this->_page->Template->assign('modelId',$this->params['modelId']);
     //$models
     $modelList = new Socnet_Catalog_Model_List();
     $models    = $modelList->getListAssoc($markId);
     
     $yearId = isset($this->params['year'])?$this->params['year']:0;
	 
	 if(empty($yearId)){
	     $this->_page->Template->assign('year',$this->params['year']);
	     $model=new Socnet_Catalog_Model_Year_List();
	     $model->setIdModel($modelId);
	     $model->returnAsAssoc(true);
	     $years = $model->getList();
	 }
   }
   else{
    if(empty($models))
    {
   	  $modelList = new Socnet_Catalog_Model_List();
      $models    = $modelList->getListAssoc(4);
    }
   }
   
   if(isset($this->params['year']) && 0 != $this->params['year'] && null != $modelId ){
      $this->_page->Template->assign('year',$this->params['year']);
      $model=new Socnet_Catalog_Model_Year_List();
      $model->setIdModel($modelId);
      $model->returnAsAssoc(true);
      $years = $model->getList();
   }
   
   $markList = new Socnet_Catalog_Trademark_List();
   $markList->addWhere("id_type_auto=1");
   $markList->returnAsAssoc(true);
   $marks   =$markList->getList();
   
   $marks[0] = "Выберите производителя";
   ksort($marks);
   $bikeType = new Socnet_Catalog_Property_Item();
   $bikeType->setId(1);
   $types = $bikeType->getListData();   
   $types[0]="Укажите тип ;-)";
   ksort($types);

   $startTypes[0] = 'Неизвестно';

   $form->addElement('select','typeId',null,$types, array( 'id' => 'typeId','style'=>"width:200px;"));
   
   $form->addElement('select','markId',null,$marks, array( 'id' => 'markId',
   														   'onChange'=>"xajax_changeTrademarkBoard(this.options[this.selectedIndex].value,this.options[this.selectedIndex].text);",
   														   'style'=>"width:200px;"));
   $models[0] = "Выберите модель";   
   
   // dump($models);
   
   if(empty($modelId)&&empty($markId))
   {
      $form->addElement('select','modelId',null,$models, array('id' => 'modelId',
   														       'onChange'=>"xajax_changeModel(this.options[this.selectedIndex].value);",
   														       'style'=>"width:200px;",'disabled'=>'true'));
   }
   else
   {
   	  $form->addElement('select','modelId',null,$models, 
   	  					array('id' => 'modelId','onChange'=>"xajax_changeModel(this.options[this.selectedIndex].value);",
						'style'=>"width:200px;"));
   }
   
   $years[0]="Выберите год";
   ksort($years);
   if(count($years) ==1 )
   {
     $form->addElement('select','year',null,$years, array('id'=>'yearId', 'style'=>"width:200px;",'disabled'=>'true',
   												        'onChange'=>"xajax_changeYearBoard(this.options[this.selectedIndex].value,document.getElementById('isYear').value);"
   					  ));
   }
   else
   {
   	$form->addElement('select','year',null,$years, array('id'=>'yearId', 'style'=>"width:200px;",
   												        'onChange'=>"xajax_changeYearBoard(this.options[this.selectedIndex].value,document.getElementById('isYear').value);"
   					 ));
   }
   
   $form->addElement('text','volume',null,array('style'=>"width:200px;",'id'=>'volumeId'));
   $form->addElement('text','probeg',null,array('style'=>"width:200px;"));

   //$form->addElement('select','kpp',null,array('style'=>"width:200px;",'id'=>'kppId'));
   $form->addElement('select','kpp',null,$startTypes, array( 'id' => 'kppId','style'=>"width:200px;",'disabled'=>'true'));
   $form->addElement('select','kppVid',null,$startTypes, array( 'id' => 'kppVidId','style'=>"width:200px;",'disabled'=>'true'));
   $form->addElement('select','kppStup',null,$startTypes, array( 'id' => 'kppStupId','style'=>"width:200px;",'disabled'=>'true'));

   $form->addElement('select','privod',null,$startTypes, array( 'id' => 'privodId','style'=>"width:200px;",'disabled'=>'true'));
   $form->addElement('select','kuzov',null,$startTypes, array( 'id' => 'kuzovId','style'=>"width:200px;",'disabled'=>'true'));
   $form->addElement('select','color',null,$startTypes, array( 'id' => 'colorId','style'=>"width:200px;",'disabled'=>'true'));

   $form->addElement('text','kapRemont',null,array( 'id' => 'kapRemontId','style'=>"width:200px;",'disabled'=>'true'));
   $form->addElement('text','places',null,array( 'id' => 'placesId','style'=>"width:200px;",'disabled'=>'true'));
   $form->addElement('text','dveri',null,array( 'id' => 'dveriId','style'=>"width:200px;",'disabled'=>'true'));


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
  
   $form->addRule('title', 'Введите, пожалуйста, заголовок.','required');
   $form->addRule('markId', 'Выберите, пожалуйста, производителя.','nonzero');
   $form->addRule('countryId', 'Выберите, пожалуйста, страну.','nonzero');
   $form->addRule('cityId', 'Выберите, пожалуйста, город.','nonzero');
   $form->addRule('countryId', 'Выберите, пожалуйста, страну.','required');
   $form->addRule('cityId', 'Выберите, пожалуйста, город.','required');
   $form->addRule('price', 'Укажите, пожалуйста, правильную цену.','nonzero');
   $form->addRule('price', 'Укажите, пожалуйста, правильную цену.','required');
   $form->addRule('condition', 'Введите, пожалуйста, состояние.','required');

   $form->addRule('volume', 'Укажите, пожалуйста, <b>правильный объем двигателя.</b>','nonzero');
   $form->addRule('volume', 'Укажите, пожалуйста, объем двигателя.','required');

   //$form->addRule('typeId','Укажите, пожалуйста, объем двигателя.','required');
   $form->addRule('typeId', 'Укажите, пожалуйста, тип мотоцикла.','nonzero');
   $form->addRule('probeg', 'Укажите пробег в виде числа, например: 100000000000000.','nonzero');

   if($form->validate()){
     $values = $form->getSubmitValues();
     // $txt = nl2br($values['content']);
     // echo " <pre> $txt </pre> ";
     $oBoard=new Socnet_Board_Item($cat_id);
     $oBoard->country_id=$values['countryId'];

     if(isset($values['custom_name']) && !empty($values['custom_name'])){
       $oBoard->model_id=0;
       $oBoard->mark_id=70;
     }else{
       $oBoard->model_id=$values['modelId'];// $values['year'];
       $oBoard->mark_id =$values['markId'];
     }
     
	   $oBoard->type_id=$values['typeId'];
     $oBoard->user_id=$_SESSION['user_id'];
     $oBoard->probeg=$values['probeg'];
     $oBoard->power=$values['power'];
     $oBoard->kpp=$values['kpp'];
     $oBoard->title=$values['title'];
          
     $oBoard->custom_name=isset($values['custom_name'])?$values['custom_name']:'';
     $oBoard->condition=$values['condition'];
     $oBoard->volume=$values['volume'];
     $oBoard->skype=$values['skype'];
     // get only numbers!
     $oBoard->icq =preg_replace("/\D/","",$values['icq']);
     $oBoard->phone=$values['phone'];
     $oBoard->city_id=$values['cityId'];
     $oBoard->price_rur=$values['price'];
     
     $oBoard->setIsActive(1);
     // $oBoard->year=$_POST['year'];
     $year = $_POST['year'];
     
     if(!empty($year)){
       $modelYear = new Socnet_Catalog_Model_Year_Item($year);
       $oBoard->year=$modelYear->getYear();
     }else
         $oBoard->year=0;
	  
	 $torg = isset ($values['is_torg'])?$values['is_torg']:0;
     $oBoard->setIsTorg($torg);
	   // clear from unnecessary tags
     $oBoard->content= Socnet_Censure::removeTags($values['content']);
     $id=$oBoard->save();
     // add photos:
     // exit;
     $boardPhotos= new Socnet_Board_Photo();
     $boardPhotos->savePhotos($id,$cat_id);
     $this->_redirect('http://'.BASE_HTTP_HOST."/board/item/bikes/$id.html");
   }
   
   $this->_page->Template->assign('crumbs', $this->crumbs);
   $renderer = new Socnet_QuickForm_Renderer_ArraySmarty($page->Template);
   $form->accept($renderer);
   $this->_page->Template->assign('formContent', $renderer->toArray());
   $this->_page->Template->assign('options', $options_array);
   $this->_page->Template->assign('prices', $prices_array);
   $this->_page->Template->assign('bodyContent', 'board/board.add_bike.tpl');
?>