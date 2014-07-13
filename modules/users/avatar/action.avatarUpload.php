<?php
// user authorization is required
if (! $this->_page->_user->hasAccess ( $this->currentUser )) {
	$this->_redirect ( '/' );
}

$form = new Socnet_Form('auForm', 'POST', $this->_page->_user->getUserPath('avatarupload'));
$avatarListObj = new Socnet_User_Avatar_List($this->_page->_user->getId());
$avatarsCount = $avatarListObj->getCount();
$error = null;
if ($_FILES) $uploaded = false; else $uploaded = true;
foreach($_FILES as $i => $FILE) {
   
   $error = ($error === null)?($FILE["error"] == 4?$error:false):$error;
   if ($avatarsCount < 12){
    	if ($FILE["error"] == 0){  
    		 $data = Socnet_File_Item::isImage($FILE["name"], $FILE["tmp_name"]);
  	         if ($data === false) {
            	$form->addCustomErrorMessage($FILE["name"]." файл - не рисунок");
            	$error = true;
            	continue;
    	     }

        	 $new_avatar = new Socnet_User_Avatar();

             $new_avatar->setUserId($this->_page->_user->getId());
             $new_avatar->setByDefault(0);
             $new_avatar->save();

            //create thumbnail
             $r0 = Socnet_Image_Thumbnail::makeThumbnail($FILE["tmp_name"], "./upload/user_avatars/".md5($this->_page->_user->getId().$new_avatar->getId())."_orig.jpg", $data[0], $data[1], true);

             $avatarsCount++;
             $uploaded = true;
        }
   } else break;
}
if($error === false) {	
	$this->_redirect($this->currentUser->getUserPath("avatars"));
}
if($error === null && $uploaded == false) {
	$form->addCustomErrorMessage("Пожалуйста, выберите файлы");
}

$this->_page->Template->assign('form', $form);
$this->_page->Template->assign('user', $this->_page->_user);
$this->_page->Template->assign('avatarsLeft', 12-$avatarListObj->getCount());
$this->_page->Template->assign('bodyContent', 'users/avatar/avatar_upload.tpl');

