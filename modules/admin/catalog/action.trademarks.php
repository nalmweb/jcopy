<?php
  if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  } elseif (!$this->_page->_user->isAdmin()){
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  }   

    if ( isset ( $this->params['markId'] ) ) {
        foreach($_FILES as $i => $FILE) {

            if ($FILE["error"] == 0){  
                 $data = Socnet_File_Item::isImage($FILE["name"], $FILE["tmp_name"]);
                 if ($data === false) {
                    $form->addCustomErrorMessage($FILE["name"]." файл - не рисунок");
                    $error = true;
                    continue;
                 }
                 
                 $mark = new Socnet_Catalog_Trademark_Item( $this->params['markId'] );
                 $fileName= $mark->getName().".jpg";
                 
                 if ( 0 !== $mark->getIdLogo() )
                     $logo = $mark->getLogo();
                 else 
                     $logo = new Socnet_Catalog_Metadata_Item();
        
                 $logo->setIdTypeMetadata( 5 );
                 $logo->setFileName( $fileName );
                 
                //create thumbnail
                 $r0 = Socnet_Image_Thumbnail::makeThumbnail($FILE["tmp_name"], "./images/catalog/logo/$fileName", $data[0], $data[1], true);
                 if ( $r0 == 'ok') $logo->save();
                 $uploaded = true;
            }
        }
   }
   
   $this->_page->Xajax->registerUriFunction("changeTMLogo","/admin/changeTMLogo/");
    
   if ( isset( $this->params['trademarks'])) {
       if ( isset($this->params['trademarks']['new'])) {
           $new = $this->params['trademarks']['new']; unset($this->params['trademarks']['new']);
           if ( '' !== trim( $new['name'] ) ) {
               $objTM = new Socnet_Catalog_Trademark_Item();
               $objTM->setIdTypeAuto(1);
               $objTM->setIdCountry( $new['country_id'] );
               $objTM->setName( $new['name'] );
               $objTM->setIdLogo(1);

               if ( isset($_FILES['new'])) {
                    $data = Socnet_File_Item::isImage($_FILES['new']["name"], $_FILES['new']["tmp_name"]);
                    $logo = new Socnet_Catalog_Metadata_Item();
                    $logo->setIdTypeMetadata( 5 );
                    $logo->setFileName( $new['name'].".jpg" );
                    $r0 = Socnet_Image_Thumbnail::makeThumbnail($_FILES['new']["tmp_name"], "./images/catalog/logo/{$new['name']}.jpg", $data[0], $data[1], true);

                    if ( $r0 == 'ok') $logo->save();
                    $objTM->setIdLogo( $logo->getId() );
               }
               $objTM->save();               
               unset( $objTM );
           }
       }
       if ( sizeof( $this->params['trademarks'] ) > 0 ) {
           foreach ($this->params['trademarks'] as $key => $value) {
               if ( trim( $value['name'] ) ) {
                   $objTM = new Socnet_Catalog_Trademark_Item( $key );
                   $objTM->setIdTypeAuto(1);
                   $objTM->setIdCountry( $value['country_id'] );
                   $objTM->setName( $value['name'] );
                   $objTM->setLogo( $value['logo_id'] );
                   $objTM->save();
               } else {
                   $objTM = new Socnet_Catalog_Trademark_Item( $key );
                   $objTM->delete();
               }
               unset( $objTM );
           }
       }
   }
    
   $markList = new Socnet_Catalog_Trademark_List();
   $markList->setIdTypeAuto( 1 );
   $markList->returnAsAssoc( false );
   $marks = $markList->getList();
   $this->_page->Template->assign('marks', $marks );

   //print_f($marks[2]->getLogo()->getDataPath());

    $country = new Socnet_Location();
    $countries = $country->getCountriesListAssoc();
    $countries[0] = "[Выберите страну]";
    ksort($countries);
    $this->_page->Template->assign('countries', $countries);
    $js="<script language='javascript' src='/js/window_lib.js'></script> ".
        "<script language='javascript'src='/js/window_ext.js'></script>";
    $this->_page->Template->assign('js', $js);      
   $form = new Socnet_Form('setTrademarks', "POST");
   $this->_page->Template->assign('SWFUploadID', session_id() );
   $this->_page->Template->assign('form', $form);
   $this->_page->Template->assign('bodyContent', 'admin/catalog/trademarks.tpl');
   $this->_page->Template->assign('menuTab','catalog');
   $this->_page->Template->assign('menuPodTab','trademarks');
?>