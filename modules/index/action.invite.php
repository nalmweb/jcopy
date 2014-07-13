<?php
    /**
        производитель модель год
        check nickName
    */
    // dump($_POST);
    // exit;
    error_reporting(E_ALL);
    ini_set("display_errors",true);
    // $invite = true;
    $template='invite.tpl';
    $this->_page->Xajax->registerUriFunction("changeTrademarkOnInvite","/ajax/changeTrademarkOnInvite/");
    $this->_page->Xajax->registerUriFunction("changeTrademark","/ajax/changeTrademark/");
    $this->_page->Xajax->registerUriFunction("changeModel","/ajax/changeModel/");
    $this->_page->Xajax->registerUriFunction("checkNickname","/ajax/checkNickname/");
    
    $form=new Socnet_QuickForm_Page('frm-invite', 'post', "/index/invite/", true,"");
    // ,array('class'=>'frm-invite','id'=>'frm-invite') 
    
	$markList = new Socnet_Catalog_Trademark_List();
    $markList->addWhere("id_type_auto=1");
    $markList->returnAsAssoc(true);
    $marks = $markList->getList();
    
    $marks[0]="Aaaa";
    $marks[-1]="Aaab";
    $marks[-2]="Aaac";
    
    asort($marks);
    $marks[0]="Производитель";
    $marks[-1]="У меня нет байка";
    $marks[-2]="----------------------------";
    // dump($marks);
    $modelList = new Socnet_Catalog_Model_List();
    $models    = $modelList->getListAssoc(4);
    
    $form->addElement('select','markId',null,$marks, array('id' => 'markId',   														   
    													   'onChange'=>"xajax_changeTrademark(this.options[this.selectedIndex].value);",
   														   'class'=>'select-bike',
   														   'style'=>"width:130px;"));
    $models=array(0=>"модель");   														   
    $form->addElement('select','modelId',null,$models,array('id' => 'modelId',
   														    'onChange'=>"xajax_changeModel(this.options[this.selectedIndex].value);",
   														    'style'=>"width:210px;",
   														    'class'=>'select-bike'));
    $years=array(0=>"год выпуска");
    $form->addElement('select','yearId',null,$years, array('id'=>'yearId',
    														'onChange'=>"onChangeYear()",
    														'class'=>'select-bike', 
														    'style'=>"width:100px;"));
														    
    /*<input style="" class="input-text" type="password" value="pass" name="password" id="password4"
			      		onfocus="resetValue(this.id,'pass');" />*/
    
    $form->addElement('text','email', 'Email:', array('style' => 'width:454px; margin-top:10px;','class'=>'input-text',
    					'id'=>'email1', 'onfocus'=>"if(this.value=='E-mail'){this.value='';}",
    					 'onblur'=>"if(this.value=='' ){this.value='E-mail';}",
    					 'value'=>'E-mail'));
    					 
	$form->addElement('password','password', 'Пароль:', array('style' => 'width: 454px; margin-top:10px;',
						'class'=>"input-text",  'value'=>"pass", 'id'=>"password4",
			      		'onfocus'=> "resetValue(this.id,'pass');"
					  ));
					  

	$form->addElement('text','nick','Ник',array('style'=>'width:454px;background-color:black;',
					   'class'=>'input-text','onblur'=>"setTimeout('checkNickname()',100);if(this.value=='' ){this.value='ник';}",
					   'onfocus'=>"if(this.value=='ник'){this.value='';}",'value'=>'ник'			
					));
    /*<input style="" class="input-text" type="text" value="ник" name="nick" id="nick" 
		  	onblur="" onfocus="if(this.value=='ник'){this.value='';}" />*/    
    $form->applyFilter('nick','trim');
    $form->applyFilter('email','trim');
    
    $form->addRule('email','Введите, пожалуйста, Email.','required');
    $form->addRule('email','Введите, пожалуйста, корректный Email.','email');
    
    $form->addRule('nick','Введите, пожалуйста, ник.','required');
    $form->addRule('nick','Разрешены только a-zA-Z0-9а-яА-я.-_','username');
    $form->addRule('pass','Введите, пожалуйста, пароль.','required');
    $form->addRule('pass','Минимальная длина пароля 6 символов.','minlength', 6);
    
    $validate =$form->validate();
    
    // check that a string contains special chars.
    // echo "valid=[$validate]";
    if($validate)
    {    	
      // dump($this->params);
      /*
        [_qf__frm-invite] => 
    [custom_bike] => Производитель, модель, год
    [markId] => 1
    [modelId] => 10
    [yearId] => 14
    [nick] => qwerty
    [password] => 123321
    [email] => asfsad@asdf.com
    [get_inv] => Пришлите скорее
       * */
    $user = new Socnet_User();
    $user->setId(null);
    $user->setCityId(1);
    $user->setMetroId(1);
    $user->setBirthday('1985-05-05');
    $user->setGender("male");
    $user->setLogin($this->params['email']);
    $user->setPass(md5($this->params['password']));
    $user->setAdmin(false);
    $user->setStatus('pending');
    $user->setRegisterDate(date('Y-m-d H:i:s', time()));
	$user->setExperience('2008-01-01');
    $user->setNikname($this->params['nick']);
    $user->setBirthdayPrivate(1);
    $user->setview_as        =1;
    $user->user_num_comments =0;
    
	  unset($_SESSION['reg_user']);
	  // get coords
	  // $city = new Socnet_Location_City($this->params["cityId"]);
	  $user->latitude  = 55.73948;
	  $user->longitude = 37.62817;
	  $user->save();
    
	  // isset( $this->params['newBike'] ) && '' !==  trim( $this->params['newBike'] ))
	  if( empty ($this->params['markId'] ))
	  {
	      $data['userId'] = $user->getId();
	      $data['request']= $this->params['custom_bike'];
	      $request = new Socnet_Admin_Collection();
	      $request->addRequestToNewBike($data);
	  }
	  else if ($this->params['markId'] == -1 || $this->params['markId'] ==-2 )
	  {
	     $user->setBikeId(0);
	  }
	  else
	  {
	     $user->setBikeId($this->params['yearId']);    
	     $user->save();
	  }
	  unset($_SESSION['verify_code']);
    //$mail_confirm_url=$user->registerCode;
    //  Send message
    //$_SESSION['reg_user'] = array('login'  => $this->params['login']);
    // $_SESSION['register']="OK";
    // $this->_redirect('/index/ok/');
    $template='invite.success.tpl';
    //header("Location :/index/ok/");
    //exit;
    }
    // echo __FILE__;
    $this->_page->Template->assign('invite',true);    
    $this->_page->Template->assign('invite_template',$template);
    
    $renderer = new Socnet_QuickForm_Renderer_ArraySmarty($this->_page->Template);
    $form->accept($renderer);
    $this->_page->Template->assign('formContent', $renderer->toArray());
    $this->_page->Template->assign('bodyContent','index.tpl');
?>
