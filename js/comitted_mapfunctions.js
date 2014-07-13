    var icons = {};
    var allmarkers = [];
    var counter = 0;
    var outputLayer = '';

    function getIcon(images) {
      var icon = null;
      if (images) {
        if (icons[images[0]]) {
          icon = icons[images[0]];
        } else {
          icon = new GIcon();
          icon.image = "/images/gmap/" + images[0] + ".png";
          var size = {width:28,height:28};// iconData[images[0]];
          icon.iconSize = new GSize(size.width, size.height);
          icon.iconAnchor = new GPoint(size.width >> 1, size.height >> 1);
          icon.infoWindowAnchor = new GPoint(size.width/2,0);
          icon.shadow = "/images/gmap/" 
              + images[1] + ".png";
		  size = {width:28,height:28} // iconData[images[1]];
          icon.shadowSize = new GSize(size.width, size.height);
          icons[images[0]] = icon;
        }
      }
      return icon;
    }

    function setupMarkers()
    {
      allmarkers.length=0;
//    alert(outputLayer.length);
//	  var outputLayerTest = document.getElementById('outputLayer');
      for (var i=0; i < outputLayer.length; i++)
      {
        var layer = outputLayer[i];
        var markers = [];
        var size = layer["places"].length;
        for (var j = 0; j < size; j++ ) {
	 	  // alert(j);
          var place = layer["places"][j];
          var icon = getIcon(place["icon"]);
         // var icon = getIcon();
          var title = place["name"];
          var posn = new GLatLng(place["posn"][0], place["posn"][1]);
          var marker = createMarker(posn,title,place["html"] ,icon); 
          markers.push(marker);
          allmarkers.push(marker);
        }
        mgr.addMarkers(markers, layer["zoom"][0], layer["zoom"][1]);
//		alert( "=" + layer["zoom"][0] + "l1=" +  layer["zoom"][1] );
		mgr.addMarkers(allmarkers, layer["zoom"][0], layer["zoom"][1]);
      }
      mgr.refresh();
     // alert("c = "+count);
    }

    function deleteMarker() {
      var markerNum = parseInt(document.getElementById("markerNum").value);
      mgr.removeMarker(allmarkers[markerNum]);
    }
   
    function clearMarkers() {
      mgr.clearMarkers();
    }
   
    function reloadMarkers() {
      mgr.clearMarkers();
      setupMarkers();
    }