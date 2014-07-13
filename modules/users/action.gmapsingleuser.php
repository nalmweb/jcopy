<?php
$cfgGmap = new Zend_Config(new Zend_Config_Xml(CONFIG_DIR."cfg.gmap.xml", 'gmap'));
define('GOOGLE_MAP_KEY', $cfgGmap->google_map_key);

$user_id        = isset($this->params['user'])      ? floor($this->params['user'])  : 0;
$size_x         = isset($this->params['sizex'])     ? floor($this->params['sizex']) : 400;
$size_y         = isset($this->params['sizey'])     ? floor($this->params['sizey']) : 400;
$zoom           = isset($this->params['zoom'])      ? floor($this->params['zoom'])  : 5;
$show_tools     = isset($this->params['showtools']) ? $this->params['showtools']    : 0;
$draggable      = isset($this->params['draggable']) ? $this->params['draggable']    : 0;
$ViewInfoWin    = isset($this->params['viewinfo'])  ? $this->params['viewinfo']     : 0;

$user = new Socnet_User("id", $user_id);


$map = new Socnet_Google_MapAPI();
$map->setAPIKey(GOOGLE_MAP_KEY);

$map->setWidth($size_x);
$map->setHeight($size_y);
$map->setZoomLevel($zoom);
$map->setControlSize('large');
$map->setMapType('hybrid');
$map->disableDirections();
$map->setBoundsFudge(0.01);
$map->enableOverviewControl();
    $geocode = $map->geoGetCoords('Minsk');

    $map->addMarkerByCoords($geocode['lon'],$geocode['lat'],'Минск');
    $geocode = $map->geoGetCoords('Moscow');
    $map->addMarkerByCoords($geocode['lon'],$geocode['lat'],'Москва');
    //$map->addMarkerIcon('/images/user_icon_s.gif');

        // assign Smarty variables;
    $this->_page->Template->assign('google_map_header',$map->getHeaderJS());
    $this->_page->Template->assign('google_map_js',$map->getMapJS());
//    $this->_page->Template->assign('google_map_sidebar',$map->getSidebar());
    $this->_page->Template->assign('google_map',$map->getMap());
    $this->_page->Template->assign('enableGmap',true);

/*

$gm->SetMarkerIconStyle('HOUSE');
$gm->SetMapZoom($zoom);

if (isset($user->latitude) && isset($user->longitude)) {
    $gm->SetAddress("$user->latitude,$user->longitude");
    //$gm->setMode('coord');
} else {
    $gm->SetAddress($user->getCountry()->name.",".$user->getCity()->name);
    //$gm->setMode('addr');
}
$gm->SetMarkerDragMode($draggable);
$gm->SetInfoWindowText($user->intro);
$gm->SetViewInfoWin($ViewInfoWin);

//$gm->SetInfoWindowText("Это Минск");
$gm->SetSideClick('Belarus');

$gm->SetMapWidth($size_x);
$gm->SetMapHeight($size_y);

$this->_page->Template->assign('gm', $gm);
$this->_page->Template->assign('lat', $user->latitude);
$this->_page->Template->assign('lng', $user->longitude);
$this->_page->Template->assign('draggable', $draggable);

if (isset($_POST['lat']) && isset($_POST['lng'])) {
    $user->latitude = $_POST['lat'];
    $user->longitude = $_POST['lng'];
    $user->save();
}
*/

print $this->_page->Template->getContents('gmap/singleuser1.tpl');
exit;

