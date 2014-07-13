<?php
   // user authorization is required
    if (!$this->_page->_user->hasAccess($this->_page->_user)){
        $this->_redirect('/error/registration/');
	}
$this->_page->Xajax->registerUriFunction("sendMessage","/ajax/sendMessage/");
$this->_page->Xajax->registerUriFunction("sendMessageDo","/ajax/sendMessageDo/");
	
$cfgGmap = new Zend_Config(new Zend_Config_Xml(CONFIG_DIR."cfg.gmap.xml", 'gmap'));

$this->_page->Xajax->registerUriFunction ( "setFilter", "/map/setFilter/" );

$map = new Socnet_Google_MapAPI('grossMap','grossMap');
$map->setAPIKey($cfgGmap->google_map_key);
$map->setUseMarkerManager( true );

$map->prepareMap(9, "100%", "430", true);

if ( $this->_page->_user->getCityId() )
	$map->addMarkerByAddress( $this->_page->_user->getCountry()->getName(). ", ". $this->_page->_user->getCity()->getName() );
else $map->addMarkerByAddress( "Russia, Moscow" );


function utf8_strlen($s)
{
    return preg_match_all('/./u', $s, $tmp);
}

function utf8_substr($s, $offset, $len = 'all')
{
	if ($offset < 0) $offset = utf8_strlen($s) + $offset;
	
	$s = preg_replace('#\r?\n#', '<br />', wordwrap($s, 55) ); 
	
	if ( $len != 'all' ) {
       if ( $len < 0 ) $len = utf8_strlen($s) - $offset + $len;
       $xlen = utf8_strlen($s) - $offset;
       $len = ( $len > $xlen ) ? $xlen : $len;
       preg_match('/^.{' . $offset . '}(.{0,'.$len.'})/us', $s, $tmp);
    } else {
       preg_match('/^.{' . $offset . '}(.*)/us', $s, $tmp);
    }
    
    return (isset($tmp[1])) ? $tmp[1] : false;
}


function getMeetingHTML( Socnet_Meeting $item) {
	$html = '';
	if (! empty ( $item )) {
	$html = "
	<table height=\"100%\" style=\"text-align:left;\">
	<tr><td>";
	
	if ( null !== $item->getRandomPhoto() )
		$html .= "<img src=\"http://".BASE_HTTP_HOST."/upload/meetings/{$item->getId()}/".md5($item->getRandomPhoto()).".jpg\">";
		
	$html .= "</td><td>
		<strong><a href='".BASE_URL."/meetings/view/id/{$item->id}/'>".utf8_substr($item->getName(), 0 , 20)."</a></strong><br />
		<b>Описание:</b> ".  utf8_substr($item->info, 0, 90)  . "<br />
		<b>Дата встречи:</b> ". substr($item->meet_datetime,0, strlen( $item->meet_datetime )-3 )  . "</span><br />
		<b>Участников:</b> ". $item->getSubscribersCount(). "<br />
		<b>Комментариев:</b> ". $item->num_comments. "
	</td>
	</tr>
	</table>";
	}

	return preg_replace('#\r?\n#', '', addslashes( $html ) );
}


$meetingsList = new Socnet_Meeting_List ( );
$meetings = $meetingsList->getList();

// setup default markers:
 $start = '<script> var outputLayer = [
  {
    "zoom": [0, 17],
    "places": [  ';
    
    $size  = count($meetings);
    $count = 0;
    $char = ",";
    
$outputLayer = "";     
    
    
//    echo "c=".count($meetings);
    
    foreach ( $meetings as $item )
    {
       $count ++;
       
       if($count==$size) 
           $char = ''; 
       
       $outputLayer .= '{ "name": "'.addslashes( $item->getName() ).'",
			"icon": ["helmets_meeting", "helmets_meeting_shadow"],
			"posn": ['.$item->getLatitude ().','.$item->getLongitude ().'],
			"html": "'.getMeetingHTML ( $item ).'"
			} '.$char.'
		';
   }
   
   $content  = $start. "  " . $outputLayer;
   
   $outputLayer = $content;   
      
   $outputLayer .= " ]
			  }" .
	   "]; </script> ";
   
// fdump($outputLayer); 
   
$this->_page->Template->assign('outputLayer',$outputLayer);

$this->_page->Template->assign('google_map_header',$map->getHeaderJS());
$this->_page->Template->assign('google_map_js',$map->getMapJS());
$this->_page->Template->assign('google_map',$map->getMap());
$this->_page->Template->assign('enableGmap',true);

$this->_page->Template->assign('onload_attributes','onload="onLoad()"');   
$this->_page->Template->assign('bodyContent', 'map/index.tpl');
?>