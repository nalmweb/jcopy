{literal}
<script type="text/javascript">
<!--
	function grabForm()
	{
		var params = new Array();
		var map_form = document.getElementById('map_form');
		params['users'] = map_form.rb_users.checked;
		params['friends_only'] = map_form.friends_only.checked;
		params['meetings'] = map_form.rb_meetings.checked;
		params['fast'] = map_form.fast.checked;
		params['passed'] = map_form.passed.checked;
		params['with_photo'] = map_form.with_photo.checked;
		return params;
	}
	
	function setRB( rb )
	{
		var what = new Array();
		switch ( rb ) {
			case 'meetings' : {	what = ['users', 'places'];	} break;
			case 'users' : { what = ['meetings', 'places'];	} break;
			case 'places' : { what = ['meetings', 'users'];	} break;
		}
		for ( k=0;k<what.length;k++){
			var td = document.getElementById('td_'+what[k]);
			if ( td ) { 
				var inps = td.getElementsByTagName("input");
				for (i=0; i<inps.length; i++) {	inps[i].checked = false; }
				document.getElementById('h_'+what[k]).style.display = 'none';
				document.getElementById('h_'+rb).style.display = '';
			}
		}
	}
//-->
</script>
{/literal}

<div class="full">
 {if $enableGmap}
    {$outputLayer}
    {$google_map}
 {/if}
</div>
<div  align="center">
<form action="" method="POST" id="map_form" >
<table with="100%" border="0">
<tr height="100px;">
	<td width="150px;">
		<div id="td_users">
		<input type="radio" name="who" id="rb_users" value="1" onClick="setRB('users');"/> Пользователи<br />
		<div id="h_users" style="display:none;">
		<input type="checkbox" name="friends_only" id="chb_friends_only" onClick="setRB('users');" /> Только друзья
		</div>
		</div>
	</td>
	<td width="150px;">
		<div id="td_meetings"> 
		<input type="radio" name="who" id="rb_meetings"  onClick="setRB('meetings');"/> Встречи<br />
		<div id="h_meetings" style="display:none;">
		<input type="checkbox" name="fast" id="chb_fast" onClick="setRB('meetings');" /> скоро состоятся<br />
		<input type="checkbox" name="passed" id="chb_passed" onClick="setRB('meetings');" /> прошедшие<br />
		<input type="checkbox" name="with_photo" id="chb_with_photo" value="1"  onClick="setRB('meetings');"/> с фото<br />
		</div>
		</div>
	</td> 
	{*
	<!-- 
	 <td width="150px;">
		<div id="td_places"> 
		<input type="radio" name="who"  id="rb_places"  onClick="setRB('places');" /> Места<br />
		<div id="h_places" style="display:none;">
		<input type="checkbox" name="st" id="st" onClick="setRB('places');" /> для стантрайтинга<br />
		<input type="checkbox" name="st2" id="st2" onClick="setRB('places');" /> для стантрайтинга<br />
		</div>
		</div>
	 </td>
	 -->
	*}
</tr>
<tr><td colspan="2"><div style="padding-left: 70px;">{linkbutton name="Применить фильтр" onclick="xajax_setFilter( grabForm() ); return true;"}</div></td></tr>
</table>
</form>
</div>
<div style="display:none">
  <img src="http://{$BASE_HTTP_HOST}/images/gmap/chopper_helmet.png"  />
  <img src="http://{$BASE_HTTP_HOST}/images/gmap/chopper_helmet_shadow.png"  />
  <img src="http://{$BASE_HTTP_HOST}/images/gmap/cross_helmet.png"  />
  <img src="http://{$BASE_HTTP_HOST}/images/gmap/cross_helmet_shadow.png"  />
  <img src="http://{$BASE_HTTP_HOST}/images/gmap/flag-shadow.png"  />
  <img src="http://{$BASE_HTTP_HOST}/images/gmap/helmets_meeting.png"  />
  <img src="http://{$BASE_HTTP_HOST}/images/gmap/helmets_meeting_shadow.png"  />
  <img src="http://{$BASE_HTTP_HOST}/images/gmap/sport_helmet.png"  />
  <img src="http://{$BASE_HTTP_HOST}/images/gmap/sport_helmet_shadow.png"  />
</div>
<!-- <input type="hidden" name="outputLayer" value="" id="outputLayer" > -->
