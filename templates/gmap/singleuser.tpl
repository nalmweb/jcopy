{literal}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps JavaScript API</title>
    {/literal}
    {$gm->GmapsKey()}

{literal}

</head>
  <body>
  {/literal}
  {$gm->MapHolder()}
  {$gm->InitJs()}
  {literal}
<script type="text/javascript">
//<![CDATA[
	var lat = {/literal}{$lat}{literal};
	var lng = {/literal}{$lng}{literal};

function update_coord(){
   document.getElementById("lat").value = lat;
   document.getElementById("lng").value = lng;
	}
{/literal}
{if $draggable}
	   {literal}
	   GEvent.addListener(marker, "dragstart", function() {
		  //map.closeInfoWindow();
  		});

		GEvent.addListener(marker, "dragend", function() {
			var curr = marker.getPoint();
			lat = curr.lat();
			lng = curr.lng();
			update_coord();
		});
		{/literal}
		{/if}

		{literal}
    //]]>
	</script>
	{/literal}
  {*$gm->GetSideClick()*}
  {$gm->UnloadMap()}
  {literal}

<input type="hidden" name="lat" id="lat">
<input type="hidden" name="lng" id="lng">
<script type="text/javascript"> update_coord(); </script>
  </body>
</html>
{/literal}