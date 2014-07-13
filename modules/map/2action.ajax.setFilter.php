<?php
$objResponse = new xajaxResponse ( );
//dump($params);


$cfgGmap = new Zend_Config ( new Zend_Config_Xml ( CONFIG_DIR . "cfg.gmap.xml", 'gmap' ) );

$map = new Socnet_Google_MapAPI ( 'MapJS', 'MapJS' );
$map->setAPIKey ( $cfgGmap->google_map_key );

$objResponse->addScript('mgr.clearMarkers();');

function getCoordinates($cityName, &$map) {
	$coords = $map->geoGetCoords ( $cityName );
	return $coords;
}

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

function getUserHTML( Socnet_User $item = null ) {
	
	$html = "";
	if ( null !== $item ) {
		$html .= "<table width='250'>
		<tr><td>
			<img src='{$item->getAvatar()->getSmall()}'>
		</td>
		<td align=\"left\">
			<strong>{$item->getNikname()}</strong></span><br />";
		if ( !$item->getBirthdayPrivate() && $item->getAge() > 0 ) {
			$html .= "Возраст: {$item->getAge()}<br />";
		}
			if ( $item->getBikeId() )
				$html .= "{$item->getBike()->getModel()->getTrademark()->getName()} {$item->getBike()->getModel()->getName()} {$item->getBike()->getYear()}<br />";
			else {
				$bike = Socnet_Admin_Collection::getCustomBukeForUser( $item );
				if ( $bike ) $html .= "$bike<br />";
			}
				
			if ( $item->getExperience() ) $html .= "Опыт: {$item->getExperience() } <br />";
			$html .= "<a href=\"{$item->getUserPath('profile')}\" target='_blank'>смотреть профиль</a>
		</td>
		</tr></table>";
	}
	return preg_replace('#\r?\n#', '', addslashes( $html ) );
}

function getMeetingHTML( Socnet_Meeting $item) {
	$html = '';
	if (! empty ( $item )) {
	$html = "
	<table height=\"100%\">
	<tr><td>";
	
	if ( null !== $item->getRandomPhoto() )
		$html .= "<img src=\"http://".BASE_HTTP_HOST."/upload/meetings/{$item->getId()}/".md5($item->getRandomPhoto()).".jpg\">";
		
	$html .= "</td><td>
		<strong><a href='".BASE_URL."/meetings/view/id/{$item->id}/'>".utf8_substr($item->getName(), 0 , 20)."</a></strong><br />
		Описание: ".  utf8_substr($item->info, 0, 90)  . "<br />
		Дата: ". substr($item->meet_datetime,0, strlen( $item->meet_datetime )-3 )  . "</span><br />
		Участников: ". $item->getSubscribersCount(). "<br />
		Комментариев: ". $item->num_comments. "
	</td>
	</tr>
	</table>";
	}

	return preg_replace('#\r?\n#', '', addslashes( $html ) );
}

function getCityMeetingHTML($city = array()) {
	
	$html = "<div>";
	if (! empty ( $city )) {
		$html .= "<span><strong>". addslashes( $city['name'] ). "</strong></span><br />";
		$html .= "<span>Встреч: ". addslashes( $city['count'] ). "</span><br />";
		$html .= "<span>Участников: ". addslashes( $city['subscribers'] ). "</span>";
	}
	$html .= "</div>";
	return $html;
}

$outputStart = '[';
/*
$outputLayer0 = "
			  {
			    \"zoom\": [0, 8],
			    \"places\": [  ";
*/
$outputLayer = "
			  {
			    \"zoom\": [0, 17],
			    \"places\": [  ";



if ($params ['users'] == 'true') {
	$out = '';
	if ($params ['friends_only'] == 'true') {
		$oFriendsList = new Socnet_User_Friend_List ( );
		$oFriendsList->setUserId ( $this->_page->_user->getId () )->returnAsAssoc ( false );
		
		$aFriendsList = $oFriendsList->getList ();

		
		
		foreach ( $aFriendsList as $item ) {
			if (null !== $item->getFriend ()->getLatitude () && null !== $item->getFriend ()->getLongitude ()) {
				$helmetImgShadow = (null !==  $item->getFriend()->getHelmetShadowIcon() ) ? 
									$item->getFriend()->getHelmetShadowIcon():
									null;

				$helmetImg = $item->getFriend()->getHelmetIcon();
				
				$out .=  " 
				       	{\"name\": \"". addslashes( $item->getFriend()->getLogin() ). "\",\n
						 \"icon\": [\"$helmetImg\", \"$helmetImgShadow\"],\n
						 \"posn\": [". $item->getFriend ()->getLatitude () . ", " . $item->getFriend ()->getLongitude () ."],\n
						 \"html\": \"" . getUserHTML ( $item->getFriend () ) . "\"\n
				       },\n";
			}
		}
	} else {
		$oUsersList = new Socnet_User_List ( );
		$oUsersList->addWhere('latitude IS NOT NULL' );
		$oUsersList->addWhere('latitude > 0' );
		$oUsersList->addWhere('longitude IS NOT NULL' );
		$oUsersList->addWhere('longitude > 0' );
		
		if ( $oUsersList->getCount() > 100  )
			$oUsersList->setRandomCount( 100 );
		
		$aUsersList = $oUsersList->getList();

		foreach ( $aUsersList as $item ) {
			if (null !== $item->getLatitude () && null !== $item->getLongitude ()) {
				$helmetImgShadow = (null !==  $item->getHelmetShadowIcon() ) ? 
									$item->getHelmetShadowIcon():
									null;

				$helmetImg = $item->getHelmetIcon();
				
				$out .= " 
				       	{\"name\": \"  ". addslashes( $item->getLogin() ). " \",\n
						 \"icon\": [\"$helmetImg\", \"$helmetImgShadow\"],\n
						 \"posn\": [" . $item->getLatitude () . ", " . $item->getLongitude () . " ],\n
						 \"html\": \"" . getUserHTML ( $item ) . "\"
				       },\n";
			}
		}
	}
	
	$outputLayer .= $out;
//	$outputLayer0 .= $out;

	
} elseif ($params ['meetings'] == 'true') {
	$extend = false;
	
	if ($params ['fast'] == 'true') {
/*			$meeting = new Socnet_Meeting();
		$cities = $meeting->getMeetCities( 'future' );
		
	foreach ( $cities as $item ) {
			
			$arr = getCoordinates( $item['name'], $map );
			
			if ( !empty( $arr ) ) {
			$outputLayer0 .= " 
			       	{\"name\": \" ". addslashes( $item['name'] ). " \",
					 \"icon\": [\"helmets_meeting\", \"helmets_meeting_shadow\"],
			 		 \"posn\": [" . $arr['lat'] . ", " . $arr['lon'] . " ],
			 		 \"html\": \"" . getCityMeetingHTML ( $item ) . "\"
			        },";
			}
			$arr = array();
		}
		*/
		$lastMeetingsList = new Socnet_Meeting_List ( );
		
		$lastMeetingsList->setExpired ( false )->setFuture ();
								 
		if ( $params['with_photo'] == 'true' )
			$lastMeetingsList->setHadPhotos( true );
		
		$lastMeetings = $lastMeetingsList->getList();
		
		foreach ( $lastMeetings as $item ) {
			$outputLayer .= " 
			       	{\"name\": \"  ". addslashes( $item->getName() ). " \",
					 \"icon\": [\"helmets_meeting\", \"helmets_meeting_shadow\"],
			 		 \"posn\": [" . $item->getLatitude () . ", " . $item->getLongitude () . " ],
			 		 \"html\": \"" . getMeetingHTML ( $item ) . "\"
			        },";
		}
		$extend = true;
	}
	
	if ($params ['passed'] == 'true')
	{
	  /*	
	    $meeting = new Socnet_Meeting();
		$cities = $meeting->getMeetCities( 'expired' );
		
		foreach ( $cities as $item ) {
			
			$arr = getCoordinates( $item['name'], $map );
			
			if ( !empty( $arr ) ) {
			$outputLayer0 .= " 
			       	{\"name\": \" ". addslashes( $item['name'] ). " \",
					 \"icon\": [\"helmets_meeting\", \"helmets_meeting_shadow\"],
			 		 \"posn\": [" . $arr['lat'] . ", " . $arr['lon'] . " ],
			 		 \"html\": \"" . getCityMeetingHTML ( $item ) . "\"
			        },";
			}
			$arr = array();
		}*/
		
		$expiredMeetingsList = new Socnet_Meeting_List ( );
		
    	$expiredMeetingsList->setExpired(true)->setFuture(false);

		if ( $params['with_photo'] == 'true' )
			$expiredMeetingsList->setHadPhotos( true );
			
		$expiredMeetings = $expiredMeetingsList->getList();
			
		foreach ( $expiredMeetings as $item ) {
			$outputLayer .= " 
			       	{\"name\": \" ". addslashes( $item->getName() ). " \",
					 \"icon\": [\"helmets_meeting\", \"helmets_meeting_shadow\"],
			 		 \"posn\": [" . $item->getLatitude () . ", " . $item->getLongitude () . " ],
			 		 \"html\": \"" . getMeetingHTML ( $item ) . "\"
			        },";
		}
		
		$extend = true;
	} 
	
	if ( !$extend ) {
		$meetingsList = new Socnet_Meeting_List ( );
		
		if ( $params['with_photo'] == 'true' )
			$meetingsList->setHadPhotos( true );
			
			$meetings = $meetingsList->getList();
		
/*			$meeting = new Socnet_Meeting();
			$cities = $meeting->getMeetCities();
			
			foreach ( $cities as $item ) {
				
				$arr = getCoordinates( $item['name'], $map );
				
				if ( !empty( $arr ) ) {
				$outputLayer0 .= " 
				       	{\"name\": \" ". addslashes( $item['name'] ). " \",
						 \"icon\": [\"helmets_meeting\", \"helmets_meeting_shadow\"],
				 		 \"posn\": [" . $arr['lat'] . ", " . $arr['lon'] . " ],
				 		 \"html\": \"" . getCityMeetingHTML ( $item ) . "\"
				        },";
				}
				$arr = array();
			}
			*/
			foreach ( $meetings as $item ) {
				$outputLayer .= " 
				       	{\"name\": \" ". addslashes( $item->getName() ). " \",
						 \"icon\": [\"helmets_meeting\", \"helmets_meeting_shadow\"],
				 		 \"posn\": [" . $item->getLatitude () . ", " . $item->getLongitude () . " ],
				 		 \"html\": \"" . getMeetingHTML ( $item ) . "\"
				        },";
			}
		
	}
}

$outputLayer .= "
			    ]
			  },";
/*
$outputLayer0 .= "
			    ]
			  },";
*/
$outputFinish = "]";

$output = $outputStart . 
//$outputLayer0 .
 $outputLayer . $outputFinish;
//print $outputLayer;
$objResponse->addScript ( 'outputLayer = ' . $output . '; reloadMarkers();' );
?>