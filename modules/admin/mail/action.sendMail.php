<?php
//status = pending | active 
 // dump($_POST);//
 $users = isset($_POST['uid'])?$_POST['uid']:null;
 $template_key = isset($_POST['template_key'])?$_POST['template_key']:null;
 $count = 0;
 
 // send to all users?
 if(empty($users))
 {
  	// select all 
  	$oUserCollection = new Socnet_User_Collection();
  	//echo "[$count_users]";
  	$list = new Socnet_User_List();
  	$list->returnAsAssoc(true);   
  	$users =$list->getList();
  	$count_users = $this->getCount(); 
  	/*echo count($users);
  	dump($users);*/
  	//exit;
  }
  
  $template_key = 25;
  $users    	= array( 40=>"konan.com@gmail.com" );
  
  //
  if(!empty($template_key))
  {
	ini_set('max_execution_time',0);
 	$this->_db->query("SET NAMES koi8r");
 	$current_date = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
 	
 	$oBroadcast = new Socnet_Mail_Broadcast();
	$oBroadcast->setTitle('рассылка');
	$oBroadcast->setTemplateKey($template_key);
	$oBroadcast->setDate($current_date);
	$broadcast_id = $oBroadcast->save();
	
	foreach ($users as $user_id=> $email)
	{	
		   $user=new Socnet_User("id",$user_id);
		   // echo "$user = $email ";
		   // dump($user);
		   // foreach ( $date as $user )
		   // {
		   // $user->setPass($user->restorePasswordOnly());
		   $mail=new Socnet_Mail_Template('id',$template_key);
		   $mail->setEmailCharset('KOI8-R');
		   
		   $sender_object = new Socnet_User();
	       $mail->setSender($sender_object);
		   $mail->addRecipient( $user );
		   $mail->sendToEmail(true);
		   $mail->sendEmailHTMLPart(true);
		   $mail->sendEmailTextPart(true);
		   
		   $attachments=array();
		    // get files:
		    
		   $files = Socnet_File_Item :: getFileList(ATTACHMENT_DIR.$template_key.'/');
		    
		   // file, type, encoding.
		   foreach ($files as $file)
	       {
	          $attach = new Socnet_Mail_Attachment();
	          $attach->filename	   = $template_key.'/'.$file;
	          $attach->originalName= $file;
	          
	          $size = getimagesize(ATTACHMENT_DIR.$template_key.'/'.$file);
	          $attach->mimeType=$size['mime'];
	          $attachments[] = $attach;
	       }
	       $mail->setAttachments($attachments);
		   $mail->send();
		   
		   // UPDATE USER INFO:->>
		   $mailStatus=new Socnet_Mail_Status_Item();
		   $mailStatus->setItemId($broadcast_id);
		   $mailStatus->setUserId($user_id);
		   $mailStatus->setIsSent(true);
		   $mailStatus->setDate($current_date);
		   $mailStatus->save();
		   $count++;
		   
		   // if($count > 3000) 
		   //  break;
		   //echo " mail = ".$user->getLogin();
		   //$files= array('enter.gif','hr.gif','motofriends_logo_small.gif','head_img.jpg');
		   /*$mail->addParam('nikname',$user->getNikname());
		   $mail->addParam('login',$user->getLogin());
		   $mail->addParam('pass',$user->getPass());
		   $mail->addParam('registerCode',$user->getRegisterCode() );*/
		  // $attachments=array();
		   // file, type, encoding.
		 /*  foreach ($files as $file)
	       {
	          $attach = new Socnet_Mail_Attachment();
	          $attach->filename='invite/'.$file;
	          $attach->originalName=$file;
	          $size = getimagesize(ATTACHMENT_DIR.'invite/'.$file);
	          $attach->mimeType=$size['mime'];
	          $attachments[] = $attach;
	       }*/
	       //$mail->setAttachments($attachments);
	}
	ini_set('max_execution_time',30);
 	$this->_db->query("SET NAMES utf8");
 	// exit;
 }
 else{
 	$message= "Не был указан шаблон для отправки.";
 	$this->_page->Template->assign('message',$message);
 }
// }
 $this->_page->Template->assign('count',$count);
 $this->_page->Template->assign('bodyContent','admin/mail/mailstatus.tpl');
?>
