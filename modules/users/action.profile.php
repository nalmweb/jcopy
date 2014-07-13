<?php

if($this->currentUser->status == 'pending') $this->_redirect ( '/' );

$cfgGmap = new Zend_Config(new Zend_Config_Xml(CONFIG_DIR."cfg.gmap.xml", 'gmap'));

$zoom  = $this->currentUser->zoom != null ? $this->currentUser->zoom : 10;

$this->_page->Xajax->registerUriFunction("delComment","/ajax/delComment/");
$this->_page->Xajax->registerUriFunction("addComment","/ajax/addComment/");
$this->_page->Xajax->registerUriFunction("rateComment","/ajax/rateComment/");

// makes only one call of friendStatus() (there are more than 1 checks)
$map = new Socnet_Google_MapAPI();
$map->setAPIKey($cfgGmap->google_map_key);
$map->prepareMap($zoom, 530);

if (isset($this->currentUser->latitude) && isset($this->currentUser->longitude)){
  $map->addMarkerByCoords($this->currentUser->longitude,$this->currentUser->latitude);
}else{
    $map->addMarkerByAddress('Minsk','Минск','<div id="text">Привет, Jus<br><a href="http://soc.net/users/profile/userid/4/">Настройки</a> | <a href="/users/messages/folder/inbox/masterjus@gmail.com"><img src="/images/mail_icon.gif"> (0)</a><br><a href="http://soc.net/users/logout/">Выход </a></div>');
	// $gm->SetAddress($this->_page->_user->getCountry()->name." ".$this->_page->_user->getCity()->name);
}

// $map->addMarkerByAddress('Minsk','Минск','<div id="text">Привет, Jus<br><a href="http://soc.net/users/profile/userid/4/">Настройки</a> | <a href="/users/messages/folder/inbox/masterjus@gmail.com"><img src="/images/mail_icon.gif"> (0)</a><br><a href="http://soc.net/users/logout/">Выход </a></div>',true);
// $geocode = $map->geoGetCoords('Moscow');
// $map->addMarkerByCoords($geocode['lon'],$geocode['lat'],'Москва');
// $map->addMarkerIcon('/images/user_icon_s.gif');

   $date = new HTML_QuickForm_date();
   $months = $date->_locale['ru']['months_long'];
   $birthday = strtotime($this->currentUser->birthday);
//-->SET COMMENTS BLOCK
$this->_page->Template->assign('type' ,'user');
$this->_page->Template->assign('table','user');

// TODO: pass a list of params::
//$oComments = new Socnet_Comments($this->m_table);
//$oComments->loadComments($this->currentUser->num_comments,$this->currentUser->comment_id,$this->currentUser->id);

if ( null == $this->currentUser->getBikeId() && 0 == $this->currentUser->getBikeId() ) {
    $bike = Socnet_Admin_Collection::getCustomBukeForUser( $this->currentUser );
    if ( null !== $bike ) {
        $this->_page->Template->assign('custom_bike', $bike);
    }
}

//dump( $this->currentUser->getBike());
$helmetImg = '/images/gmap/';
$helmetImgShadow =  null !==  $this->currentUser->getHelmetShadowIcon() ?
					$helmetImg. $this->currentUser->getHelmetShadowIcon(). ".png" :
					null;
$helmetImg .= $this->currentUser->getHelmetIcon(). ".png";

$map->addMarkerIcon($helmetImg, $helmetImgShadow);

// assign Smarty variables;
$this->_page->Template->assign('google_map_header',$map->getHeaderJS());
$this->_page->Template->assign('google_map_js',$map->getMapJS());
$this->_page->Template->assign('google_map',$map->getMap());
$this->_page->Template->assign('enableGmap',true);

//dump($this->currentUser);

$this->_page->Template->assign('onload_attributes','onload="onLoad()"');
$this->_page->Template->assign('birthday', $months[date("n",$birthday)-1]. " ". date("d",$birthday). ", ". date("Y",$birthday));

$this->_page->Template->assign('loginnedUser', $this->_page->_user);
$this->_page->Template->assign('bodyContent', 'users/profile.tpl');
