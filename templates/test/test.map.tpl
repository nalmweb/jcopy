<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; 
charset=utf-8"/>
<title>Google Maps JavaScript API Example</title>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAKjsIjsLIyTc-q4kB86GB9xSa6kmTlawIxjXYR5EjTvE8p5wKyBSXz9mdaG698wYGfOHtn-qOUjSTGA" type="text/javascript">
</script>
<script type="text/javascript">
//<![CDATA[
function load() {
  if (GBrowserIsCompatible()) {
    var map = new GMap2(document.getElementById("map"));
    map.setCenter(new GLatLng(51.499393, -0.127459), 15);
  }
}
//]]>
</script>
</head>
<body onload="load()" onunload="GUnload()">
<div id="map" style="width: 800px; height: 600px"></div></body>
</html>