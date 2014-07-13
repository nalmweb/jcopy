<?php

$this->params['photo'] = (isset($this->params['photo']))? $this->params['photo'] : 1;
$photo = new Socnet_Photo_Item($this->params['photo']);
$this->_page->Template->assign('photo', $photo);//->photo_path."_orig.jpg");
print $this->_page->Template->GetContents("photopopup.tpl");
exit;
