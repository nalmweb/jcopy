<?php
/*
 * Created on 02.07.2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 
    // user authorization is required
    if (!$this->_page->_user->hasAccess($this->_page->_user)){
        $this->_redirect('/error/registration/');
	}
	
$cfgGmap = new Zend_Config(new Zend_Config_Xml(CONFIG_DIR."cfg.gmap.xml", 'gmap'));

$this->_page->Xajax->registerUriFunction ( "setFilter", "/map/setFilter/" );

$map = new Socnet_Google_MapAPI('grossMap','grossMap');
$map->setAPIKey($cfgGmap->google_map_key);
$map->setUseMarkerManager( true );

$map->prepareMap(9, "100%", "430", true);

if ( $this->_page->_user->getCityId() )
	 $map->addMarkerByAddress( $this->_page->_user->getCountry()->getName(). ", ". $this->_page->_user->getCity()->getName() );

else 
    $map->addMarkerByAddress( "Russia, Moscow" );

// google js
$this->_page->Template->assign('google_map_header',$map->getHeaderJS());

// return js to display the map
$this->_page->Template->assign('google_map_js',$map->getMapJS());

// print the map itself
$this->_page->Template->assign('google_map',$map->getMap());
$this->_page->Template->assign('enableGmap',true);

$this->_page->Template->assign('onload_attributes','onload="onLoad()"');   
$this->_page->Template->assign('bodyContent', 'map/index.tpl');
 
 
 
?>
