<?php

  if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/admin/');
  }
  //
  $this->_page->Xajax->registerUriFunction("delPhoto","/ajax/delPhoto/");
  $this->_page->Xajax->registerUriFunction("changePhoto","/admin/changePhoto/");
  
  $id	= intval(getUrlParam('id'));
  
  $form = '';
  $item = new Socnet_Mail_Item($id);
  $form = new Socnet_QuickForm_Page('editTemplate', 'post', "/admin/editTemplate/id/$id/",true);
  
  
  
  
  
  if($form->validate())
  {      	
       /*dump($_POST);
       dump($_FILES);*/       
      $values = $form->getSubmitValues ();
      $item->setContent($values['content']);
      $item->setTemplateKey($values['templateKey']);
      $item->setDescription($values['description']);
      $item->save();
      
      $common = $_POST['common'];
      $photoObject = new Socnet_Photo_Config();      
      $photoObject ->setTypeId($common['type']);
      $photoObject = $photoObject->getObject();
      $photoObject ->setItemId($common['item']);
      $photoObject ->setId($common['photo']);
      $update	   = true;
      $photoObject->savePhotos($update);
      // exit;
      $this->_redirect("/admin/editTemplate/id/$id/");
  }
  else if ( $_SERVER['REQUEST_METHOD']=='POST'){
  	  $common 	  =$_POST['common'];
      $photoObject=new Socnet_Photo_Config();      
      $photoObject->setTypeId($common['type']);
      $photoObject=$photoObject->getObject();
      $photoObject->setItemId($common['item']);
      $photoObject->setId($common['photo']);
      $update	  =true;
      $photoObject->savePhotos($update);
      // exit;
      $this->_redirect("/admin/editTemplate/id/$id/");
  }
    
  if(!empty($id))
  {
    $form->addElement ('text','templateKey','Ключ, пример:INVITE',array('style'=>'width:180px;',
					   'id' =>'templateKey','maxlength' =>'250','value'=>$item->getTemplateKey()));
    $form->addElement ('text','description','Описание:(просто текст).',array('style'=>'width:180px;',
					   'value'=>$item->getDescription() ,'id' => 'description','maxlength' =>'250'));
    // $content =  addslashes($item->getContent());
    $content =  $item->getContent();
    $form->addElement('textarea','content', 'Текстовая часть письма.', array('style' =>'width:700px;height:800px;','id' => 'content'));
     //$form->addElement('textarea','html_part', 'HTML часть письма.', array('style' =>'width:600px;height:400px;','id' => 'html_part'));
    $form->addElement ('submit','applay', 'Сохранить', 'gray');
        
    //$form->applyFilter('content', 'trim');
    $form->addRule('content',' ','required');
    $form->addRule('templateKey',' ','required');
        
    $form->addRule ('description','Введите, пожалуйста, описание.','required');
    $form->addRule ('content','Введите, пожалуйста, текст письма.','required');
    $form->applyFilter('description', 'trim');    
    $form->setDefaults ( array ('content' => $content));
    
    // get photos
    $photos= new Socnet_Mail_Photo_List();
    $photos->setItemId($id);
    $photos = $photos->getList();
    // dump($photos);
    $this->_page->Template->assign('photos', $photos);
   }
   // $this->_redirect("/admin/mailtemplates/");
   $renderer = new Socnet_QuickForm_Renderer_ArraySmarty($page->Template);
   $form->accept($renderer);
   
   $photoConfig['item_id']  = $id;
   $photoConfig['photo_id'] = 36;
   $photoConfig['type'] 	= Socnet_Photo_Config::$MAIL;   //
   
   
   $js="<script language='javascript' src='/js/window_lib.js'></script> ".
        "<script language='javascript'src='/js/window_ext.js'></script>";
   $this->_page->Template->assign('js', $js);      
   // $form = new Socnet_Form('setTrademarks', "POST");
   $this->_page->Template->assign('SWFUploadID', session_id() );
   
   $rand=mt_rand(0,200);
   $this->_page->Template->assign('common', $photoConfig);
   $this->_page->Template->assign('rand', $rand);
   $this->_page->Template->assign('formContent', $renderer->toArray());
   $this->_page->Template->assign('bodyContent', 'admin/mail/mail.editTemplate.tpl');
?>