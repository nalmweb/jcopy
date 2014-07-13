var icons = [];
var allmarkers = [];
var counter = 0;

var iconData = {
  "helmets_meeting": { width: 64, height: 48 },
  "helmets_meeting_shadow": { width: 64, height: 48 },
  "chopper_helmet": { width: 28, height: 28 },
  "chopper_helmet_shadow": { width: 28, height: 28 },
  "cross_helmet": { width: 28, height: 28 },
  "cross_helmet_shadow": { width: 28, height: 28 },
  "sport_helmet": { width: 28, height: 28 },
  "sport_helmet_shadow": { width: 28, height: 28 }
};

function getIcon(images) {
      var icon3 = null;
      if (images) {
        if (icons[images[0]]) {
          icon3 = icons[images[0]];
        } else {
          icon3 = new GIcon();
          icon3.image = "/images/gmap/" + images[0] + ".png";
          var size =  iconData[images[0]]; 
          icon3.iconSize = new GSize(size.width, size.height);
          icon3.iconAnchor = new GPoint(size.width >> 1, size.height >> 1);
          icon3.infoWindowAnchor = new GPoint(size.width/2,0);
          icon3.shadow = "/images/gmap/" + images[1] + ".png";
		  size = iconData[images[1]];
          icon3.shadowSize = new GSize(size.width, size.height);
          icons[images[0]] = icon3;
        }
      }
      return icon3;
    }
        
function setupMarkers()
{    
  allmarkers.length = 0;
  var size = outputLayer.length;
  var tmp_markers = [];  
  
  for (var i=0; i< size; i++)
  {    
    var layer = outputLayer[i];
    var places_size = layer["places"].length;
    
    for (var j=0; j <places_size; j++ ){
      var place = layer["places"][j];
      var icon2 =  getIcon(place["icon"]);
      var posn = new GLatLng(place["posn"][0], place["posn"][1]);

	  allmarkers.push(createMarker(posn,place["name"],place["html"]  ,icon2)); 
      tmp_markers.push(createMarker(posn,place["name"], place["html"],icon2));
    }
//  mgr.addMarkers(allmarkers, layer["zoom"][0], layer["zoom"][1]);
    mgr.addMarkers(tmp_markers, layer["zoom"][0], layer["zoom"][1]);
  }
  mgr.refresh();
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
    
 