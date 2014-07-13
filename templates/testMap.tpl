<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; 
charset=utf-8"/>
<title>Google Maps JavaScript API Example</title>
{literal}
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAKjsIjsLIyTc-q4kB86GB9xSa6kmTlawIxjXYR5EjTvE8p5wKyBSXz9mdaG698wYGfOHtn-qOUjSTGA" type="text/javascript">
</script>

<script src="/js/markermanager.js" language="javascript" > </script>
<script type="text/javascript">


    
// Создаем маркер с номером point, заданным и текстом label
/* function createMarker(point, number) {
  var marker = new GMarker(point);
  GEvent.addListener(marker, "click", function() {
    marker.openInfoWindowHtml("Marker #<b>" + number + "</b>");
  });
  return marker;
}*/

  var map;
  var mgr;
  var icons = {};
  var allmarkers = [];
  
var icon = [];
icon[0] = new GIcon();
icon[0].image = "http://motofriends.my/images/gmap/helmets_meeting.png";
icon[0].shadow = "http://motofriends.my/images/gmap/helmets_meeting_shadow.png";
icon[0].shadowSize = new GSize(64,48);
icon[0].iconSize = new GSize(64,48);
icon[0].iconAnchor = new GPoint(64,48);
icon[0].infoWindowAnchor = new GPoint(64,48);

var officeLayer = [
  {
    "zoom": [0, 3],
    "places": [
      {
        "name": "USA Offices",
        "icon": ["us", "flag-shadow"],
        "posn": [40, -97]
      },
      {
        "name": "Canadian Offices",
        "icon": ["ca", "flag-shadow"],
        "posn": [58, -101]
      },
    ]
  },
  {
    "zoom": [4, 6],
    "places": [
      {
        "name": "Headquarters",
        "icon": ["headquarters", "headquarters-shadow"],
        "posn": [37.423021, -122.083739]
      },
      {
        "name": "New York Sales & Engineering Office",
        "icon": ["house", "house-shadow"],
        "posn": [40.754606, -73.986794]
      },
      {
        "name": "Atlanta Sales &amp; Engineering Office",
        "icon": ["house", "house-shadow"],
        "posn": [33.781506, -84.387422]
      },
      {
        "name": "Dallas Sales Office",
        "icon": ["house", "house-shadow"],
        "posn": [36.4724385, -101.044637]
      },
      {
        "name": "Cambridge Sales & Engineering Office",
        "icon": ["house", "house-shadow"],
        "posn": [42.362331, -71.083661]
      },
      {
        "name": "Chicago Sales Office",
        "icon": ["house", "house-shadow"],
        "posn": [41.889232, -87.628767]
      },
      {
        "name": "Denver & Boulder Offices",
        "icon": ["house", "house-shadow"],
        "posn": [39.563011, -104.868962]
      },
      {
        "name": "Detroit Sales Office",
        "icon": ["house", "house-shadow"],
        "posn": [42.475482, -83.244587]
      },
      {
        "name": "Santa Monica & Irvine Offices",
        "icon": ["house", "house-shadow"],
        "posn": [33.715585, -118.177435]
      },
      {
        "name": "Phoenix Sales & Engineering Office",
        "icon": ["house", "house-shadow"],
        "posn": [33.411782, -111.926247]
      },
      {
        "name": "Pittsburgh Engineering Office",
        "icon": ["house", "house-shadow"],
        "posn": [40.444541, -79.946254]
      },
      {
        "name": "Seattle Engineering & Sales Offices",
        "icon": ["house", "house-shadow"],
        "posn": [47.664261, -122.274308]
      },
      {
        "name": "Canada Sales Office",
        "icon": ["house", "house-shadow"],
        "posn": [43.645478, -79.378843]
      },
    ]
  },
  {
    "zoom": [7, 17],
    "places": [
      {
        "name": "Headquarters",
        "posn": [37.423021, -122.083739]
      },
      {
        "name": "New York Sales & Engineering Office",
        "posn": [40.754606, -73.986794]
      },
      {
        "name": "Atlanta Sales &amp; Engineering Office",
        "posn": [33.781506, -84.387422]
      },
      {
        "name": "Boulder Sales & Engineering Office",
        "posn": [40.018520, -105.276882]
      },
      {
        "name": "Cambridge Sales & Engineering Office",
        "posn": [42.362331, -71.083661]
      },
      {
        "name": "Chicago Sales Office",
        "posn": [41.889232, -87.628767]
      },
      {
        "name": "Dallas Sales Office",
        "posn": [32.925355, -96.816087]
      },
      {
        "name": "Denver Sales Office",
        "posn": [39.563011, -104.868962]
      },
      {
        "name": "Detroit Sales Office",
        "posn": [42.475482, -83.244587]
      },
      {
        "name": "Irvine Sales & Engineering Office",
        "posn": [33.660021, -117.860142]
      },
      {
        "name": "Phoenix Sales & Engineering Office",
        "posn": [33.411782, -111.926247]
      },
      {
        "name": "Pittsburgh Engineering Office",
        "posn": [40.444541, -79.946254]
      },
      {
        "name": "Santa Monica Sales & Engineering Office",
        "posn": [34.019388, -118.494728]
      },
      {
        "name": "Seattle Engineering Office",
        "posn": [47.678415, -122.195713]
      },
      {
        "name": "Seattle Sales Office",
        "posn": [47.650106, -122.352903]
      },
      {
        "name": "Toronto Sales Office",
        "posn": [43.645478, -79.378843]
      },
    ]
  }
];


function onLoadGoogle(){
 if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map"));
        map.addControl(new GLargeMapControl());
        map.addControl(new GOverviewMapControl());
        map.setCenter(new GLatLng(64, 48), 3);
        map.enableDoubleClickZoom();
        mgr = new MarkerManager(map, {trackMarkers:false});
        window.setTimeout(setupOfficeMarkers, 0);
      }
}


function setupOfficeMarkers()
{    
  for (var i in officeLayer) {
    
    var layer = officeLayer[i];
        
    for (var j in layer["places"])
    {
      var place = layer["places"][j];
      var icon = getIcon('chopper_helmet'); // getIcon(place["icon"]); // 
      var posn = new GLatLng(place["posn"][0], place["posn"][1]);
      
       allmarkers.push(new GMarker(posn, { title: place["name"], icon: icon }));
      //markers.push(createMarker(posn, 'title' + i, "html", icon));
    }
    mgr.addMarkers(allmarkers, layer["zoom"][0], layer["zoom"][1]);
  }
  mgr.refresh();
}

function createMarker(point, title, html, icon)
{
var marker = new GMarker(point, {'icon': icon});
if(isArray(html)) { GEvent.addListener(marker, "click", function() { marker.openInfoWindowTabsHtml(html); }); }
else { GEvent.addListener(marker, "click", function() { marker.openInfoWindowHtml(html); }); }

return marker;
}

function getIcon(name)
{
      var icon = null;
      
      if (name)
      {
          icon = new GIcon();
          icon.image = "/images/gmap/" + name + ".png";
          var size = {width:28,height:28};
          icon.iconSize = new GSize(size.width, size.height);
          icon.iconAnchor = new GPoint(size.width >> 1, size.height >> 1);
          icon.infoWindowAnchor = new GPoint(size.width/2,0);
          icon.shadow = "/images/gmap/" + name + "_shadow" + ".png";
          
          size = {width:28,height:28};
          icon.shadowSize = new GSize(size.width, size.height);
//          icons[name] = icon;
      }
      return icon;
}
    
function onLoad()
{
  /*
     var map = new GMap2(document.getElementById("map"));
		     map.setCenter(new GLatLng(37.4419, -122.1419), 13);
  */
		  
  map = new GMap2(document.getElementById("map"));
  map.setCenter(new GLatLng(41, -98), 4);
	 
 var mgrOptions = { borderPadding: 50, maxZoom: 15, trackMarkers: false };
 
//  var mgr = new MarkerManager(map,mgrOptions);
// Add 10 markers to the map at random LocationS
/*
var bounds = map.getBounds();
var southWest = bounds.getSouthWest();
var northEast = bounds.getNorthEast();
var lngSpan = northEast.lng() - southWest.lng();
var latSpan = northEast.lat() - southWest.lat();

 for (var i = 0; i < 10; i++)
 {
    var point = new GLatLng(southWest.lat() + latSpan * Math.random(),
        southWest.lng() + lngSpan * Math.random());
        
        // add custom marker:
        // map.addOverlay(createMarker(point, 'title' + i, "html", getIcon('chopper_helmet')));
		// map.addOverlay(new GMarker(point));
		
		mgr.addMarker( createMarker(point, 'title' + i, "html", getIcon('chopper_helmet')) );
 }
 
*/

 window.setTimeout(setupOfficeMarkers,0);
 
}

function getRandomPoint()
{
  var bounds = map.getBounds();
  var southWest = bounds.getSouthWest();
  var northEast = bounds.getNorthEast();
  var lngSpan = northEast.lng() - southWest.lng();
  var latSpan = northEast.lat() - southWest.lat();
  
  var point = new GLatLng(southWest.lat() + latSpan * Math.random(), southWest.lng() + lngSpan * Math.random());
 
  return point; 
}

function getWeatherMarkers(n)
{
  var batch = [];
  
  for (var i = 0; i < n; ++i)
  {
     batch.push( createMarker(getRandomPoint(), 'title' + i, "html", getIcon('chopper_helmet')) );
  }
  
   return batch;
}

function loadMarkers() {
  mgr = new MarkerManager(map);
  mgr.addMarkers(getWeatherMarkers(20), 3);
  mgr.addMarkers(getWeatherMarkers(200), 6);
  mgr.addMarkers(getWeatherMarkers(1000), 8);
  mgr.refresh();
}


function load()
{
  var map = new GMap2(document.getElementById("map"));  
	  map.setCenter(new GLatLng(37.4419, -122.1419), 13);
  
	  map.addControl(new GSmallMapControl());
	  map.addControl(new GMapTypeControl());

 GEvent.addListener(map, "click", function(marker, point) {
  						if (marker) {
							  map.removeOverlay(marker);
					   } else {
						    map.addOverlay(createMarker(point,'title','html',getIcon('chopper_helmet')));
					     }
					 });
					 
 var allmarkers    = [];
 allmarkers.length = 0;
 
 // Размещаем 10 маркеров по случайным координатам
 var bounds = map.getBounds();
 var southWest = bounds.getSouthWest();
 var northEast = bounds.getNorthEast();
 var lngSpan = 800;//northEast.lng() — southWest.lng();
 var latSpan = 600;//northEast.lat() — southWest.lat();

 for (var i = 0; i < 10; i++)
 {
    var point  = new GLatLng(100 + 100*i, 100 + 100*i );
    var marker = createMarker(point, 'title' + i, "html", getIcon('chopper_helmet'));
    map.addOverlay(new GMarker(point));
    // map.addOverlay(createMarker(point, 'title' + i, "html", getIcon('chopper_helmet')));
 }
 
/*
 var points = [];
 for (var i = 0; i < 5; i++) {
  points.push(new GLatLng(southWest.lat() + latSpan * Math.random(), southWest.lng() + lngSpan * Math.random()));
 }
 points.sort(function(p1, p2) {
   return p1.lng() — p2.lng();
 });
 map.addOverlay(new GPolyline(points));
 
*/ 
 
// allmarkers.push(marker);
// alert(allmarkers.length);
// var mgr = '';
// mgr = new MarkerManager(map, {trackMarkers:true});
// mgr.addMarkers(allmarkers, 0, 15 );
// mgr.refresh();
// window.setTimeout(setupMarkers, 0);

}

 function setupMarkers() {
      allmarkers.length = 0;
      
//      alert(outputLayer.length);
      for (var i=0; i < outputLayer.length; i++) {
        var layer = outputLayer[i];
        var markers = [];
        
//        alert("places = " + layer["places"].length);
        
        for (var j = 0; j < layer["places"].length; j++ ) {
          var place = layer["places"][j];
          var icon = getIcon(place["icon"]);
         // var icon = getIcon();
          var title = place["name"];
          var posn = new GLatLng(place["posn"][0], place["posn"][1]);
          var marker = createMarker(posn,title,place["html"] ,icon); 
          // alert(marker);
          markers.push(marker);
          allmarkers.push(marker);
        }
//      mgr.addMarkers(markers, layer["zoom"][0], layer["zoom"][1]);
//		alert( "=" + layer["zoom"][0] + "l1=" +  layer["zoom"][1] );
	    mgr.addMarkers(allmarkers, layer["zoom"][0], layer["zoom"][1]);
      }
      mgr.refresh();
      alert("c = "+count);
    }


function isArray(a) {return isObject(a) && a.constructor == Array;}
function isObject(a) {return (a && typeof a == 'object') || isFunction(a);}
function isFunction(a) {return typeof a == 'function';   }

</script>
{/literal}
</head>
<body onload="onLoadGoogle()" >
<div id="map" style="width: 600px; height: 400px"></div>
<div id="message"></div>

</body>
</html>