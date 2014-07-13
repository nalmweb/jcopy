<?php

	if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/admin/');
    }

    $form = new Socnet_QuickForm_Page('addMailTemplate', 'post', '/admin/addMailTemplate/',true);
    
    $form->addElement ('text','templateKey', 'Ключ, пример:INVITE',array('style'=>'width:180px;','id' => 'templateKey','maxlength' =>'250'));    
    $form->addElement ('text','description', 'Описание:(просто текст).',array('style'=>'width:180px;','id' => 'description','maxlength' =>'250'));
        
    $form->addElement('textarea','content', 'Текстовая часть письма.', array('style' =>'width:600px;height:600px;','id' => 'content'));
    //$form->addElement('textarea','html_part', 'HTML часть письма.', array('style' =>'width:600px;height:400px;','id' => 'html_part'));

    $form->addElement ('submit','applay', 'Создать', 'gray');
    //$form->applyFilter('content', 'trim');
    
    $form->addRule('text_part',' ','required');
    $form->addRule('html_part',' ','required');    
    $form->addRule('templateKey',' ','required');
    
    $form->addRule ('description','Введите, пожалуйста, описание.','required');
    $form->addRule ('text_path','Введите, пожалуйста, текстовую часть письма.','required');
    $form->addRule ('html_part','Введите, пожалуйста, html часть письма.','required');
    
    $form->applyFilter('description', 'trim');

	if ($form->validate())
    {
    	//dump($_POST);
        $formValues = $form->getSubmitValues();
        //dump($formValues);
        // print_r($formValues);
        // exit;
		$oItem = new Socnet_Mail_Item();
		$oItem ->setTemplateKey($formValues['templateKey']);
				
		$oItem ->setCreatorId ($_SESSION['user_id']);
		$oItem ->setChangerId ($_SESSION['user_id']);
		// 
		$oItem ->setCreateDate(date('Y-m-d H:i:s', time())); 
		$oItem ->setChangeDate(date('Y-m-d H:i:s', time()));
		 	
		$oItem ->setDescription($formValues['description']);
		$oItem ->setContent    ($formValues['content']);
		
		$res = $oItem -> save();
		/*echo "res = $res ";
		exit;*/
		//exit;
		$this->_redirect('http://'.BASE_HTTP_HOST.'/admin/mailTemplates/');
    }
    
  $renderer = new Socnet_QuickForm_Renderer_ArraySmarty($page->Template);
  $form->accept($renderer);

  $this->_page->Template->assign('formContent', $renderer->toArray());
  $this->_page->Template->assign('bodyContent', 'admin/mail/mail.addTemplate.tpl'); 
?>
