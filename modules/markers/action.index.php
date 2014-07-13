<?php
header ("Content-Type: text/javascript; charset=utf-8");

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


$cfgGmap = new Zend_Config(new Zend_Config_Xml(CONFIG_DIR."cfg.gmap.xml", 'gmap'));


$map = new Socnet_Google_MapAPI('MapJS','MapJS');
$map->setAPIKey($cfgGmap->google_map_key);
/*
$meeting = new Socnet_Meeting();

$cities = $meeting->getMeetCities();
*/

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

function getCoordinates( $cityName, &$map ) {
  $coords = $map->geoGetCoords( $cityName );
  print $coords['lat']. ', '. $coords['lon'];
}

?>
var iconData = {
  "helmets_meeting": { width: 64, height: 48 },
  "helmets_meeting_shadow": { width: 64, height: 48 },
  "chopper_helmet": { width: 28, height: 28 },
  "chopper_helmet_shadow": { width: 28, height: 28 },
  "cross_helmet": { width: 28, height: 28 },
  "cross_helmet_shadow": { width: 28, height: 28 },
  "sport_helmet": { width: 28, height: 28 },
  "sport_helmet_shadow": { width: 28, height: 28 },
  
};

var outputLayer = [
  {
    "zoom": [0, 17],
    "places": [
    <?php $size = count($meetings); $char=','; $count=0; foreach ( $meetings as $item )  : ?>
    {
	"name": "<?=addslashes( $item->getName() )?>",
	"icon": ["helmets_meeting", "helmets_meeting_shadow"],
	"posn": [<?=$item->getLatitude ()?>, <?=$item->getLongitude ();?>],
	"html": "<?=getMeetingHTML ( $item )?>"
	} <?  $count++; if($size==$count)$char=''; else echo $char; ?>
	<?php endforeach; ?>
    ]
  }
];

<?php 
exit;
?>