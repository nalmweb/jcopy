// autokadabra.ru

// JavaScript Document
var gMap = {
	map : null,
	geocoder : null,
	activeTag : false,
	activeTagWord : null,
	onDocumentLoad : function () {
		if (GBrowserIsCompatible()) {
			// map create and customize
			gMap.map = new GMap2(document.getElementById('map'));
			if (window.map_default_lat && window.map_default_lng) {
				gMap.map.setCenter(new GLatLng(window.map_default_lat, window.map_default_lng), window.map_default_zoom);
			} else {
				gMap.map.setCenter(new GLatLng(55.755, 37.623), 13);
			}
			gMap.map.addControl(new GOverviewMapControl());
			gMap.map.addControl(new GLargeMapControl());
			gMap.map.addControl(new GMapTypeControl());
			gMap.map.enableDoubleClickZoom();
			gMap.map.enableContinuousZoom();
			
			for (var i = 1; i < 12; i++) {
				if ($('maps_markers_t_'+i) && $('maps_markers_t_'+i).checked == true) {
					gMap.markersHandler.markersTypes.include(String(i));
				}
			}
			
			GEvent.addListener(gMap.map, 'load', function() {
				gMap.markersHandler.server.loadMarkers();
			});
			
			GEvent.addListener(gMap.map, 'click', function(overlay, point) {
				if (overlay) return;
				
				if (gMap.markersHandler.markerAddState) {
					if (gMap.markersHandler.currentMarker != null) {
						gMap.markersHandler.currentMarker.setLatLng(point);
						$('maps_add_marker_form').elements['marker_lat'].value = gMap.markersHandler.currentMarker.getLatLng().lat();
						$('maps_add_marker_form').elements['marker_lng'].value = gMap.markersHandler.currentMarker.getLatLng().lng();
						$('maps_add_marker_form_lat').innerHTML = gMap.markersHandler.currentMarker.getLatLng().lat() + '°';
						$('maps_add_marker_form_lng').innerHTML = gMap.markersHandler.currentMarker.getLatLng().lng() + '°';
						
					} else {
						var newPoint = point;
						var newIcon = gMap.iconsHandler.prepareIcon();
						var newMarker = new GMarker(newPoint,{title:'Íîâûé îáúåêò', draggable:true, icon: newIcon});
						
						gMap.markersHandler.currentMarker = newMarker;
						
						GEvent.addListener(newMarker, 'dragend', function() {
							$('maps_add_marker_form').elements['marker_lat'].value = gMap.markersHandler.currentMarker.getLatLng().lat();
							$('maps_add_marker_form').elements['marker_lng'].value = gMap.markersHandler.currentMarker.getLatLng().lng();
							$('maps_add_marker_form_lat').innerHTML = gMap.markersHandler.currentMarker.getLatLng().lat() + '°';
							$('maps_add_marker_form_lng').innerHTML = gMap.markersHandler.currentMarker.getLatLng().lng() + '°';
						});
						
						gMap.map.addOverlay(gMap.markersHandler.currentMarker);
						
						$('maps_add_marker').removeClass('hidden');
						$('maps_add_marker_form').elements['marker_lat'].value = point.lat();
						$('maps_add_marker_form').elements['marker_lng'].value = point.lng();
						$('maps_add_marker_form_lat').innerHTML = point.lat() + '°';
						$('maps_add_marker_form_lng').innerHTML = point.lng() + '°';
					}
				}
				
		 	});
			
			GEvent.addListener(gMap.map, 'moveend', function() {
				gMap.markersHandler.server.loadMarkers();
			});
			
			gMap.geocoder = new GClientGeocoder();
			
			$('maps_search_position').addEvent('keydown', function(event) {
				var event = new Event(event);
				
				if (event.key == 'enter') {
					gMap.showAddressRequest($('maps_search_position').value);
				} else if (event.key == 'esc') {
					$('maps_search_position').value = '';
				}
				
			});
			
			$('maps_search_position_submit').addEvent('click', function () {
				gMap.showAddressRequest($('maps_search_position').value);
			});
			
			$('maps_search_position_example').addEvent('click', function (event) {
				if (!window.ie) event.preventDefault(); else event.returnValue = false;
				
				$('maps_search_position').value = $('maps_search_position_example').getChildren()[0].innerHTML;
				gMap.showAddressRequest($('maps_search_position').value);
			});
			/*
			$('maps_markers_view_switcher_form_checkboxes_button').addEvent('click', function (event) {
				$('maps_markers_view_switcher_form_checkboxes_button').addClass('selected');
				$('maps_markers_view_switcher_form_tags_button').removeClass('selected');
				
				$('maps_markers_view_switcher_form_checkboxes_holder').removeClass('hidden');
				$('maps_markers_view_switcher_form_tags_holder').addClass('hidden');
				
				gMap.activeTag = true;
			});
			
			$('maps_markers_view_switcher_form_tags_button').addEvent('click', function (event) {
				$('maps_markers_view_switcher_form_checkboxes_button').removeClass('selected');
				$('maps_markers_view_switcher_form_tags_button').addClass('selected');
				
				$('maps_markers_view_switcher_form_checkboxes_holder').addClass('hidden');
				$('maps_markers_view_switcher_form_tags_holder').removeClass('hidden');
				
				gMap.activeTag = false;
			});
			
			$$('#maps_markers_view_switcher_form_tags_holder a').each(function (tagLink) {
			
				gMap.markersHandler.tags[tagLink.innerHTML] = [];
			
				tagLink.addEvent('click', function (event) {
					if (!window.ie) event.preventDefault(); else event.returnValue = false;
					
					tagLink.removeClass('active');
					gMap.activeTagWord = tagLink;
				});
			});*/
		}
	},
	onDocumentLoadPreview : function () {
		if (GBrowserIsCompatible()) {
			// map create and customize
			gMap.map = new GMap2(document.getElementById('map_preview'));
			gMap.map.setCenter(new GLatLng(map_preview_lat, map_preview_lng), 16);
			gMap.map.enableDoubleClickZoom();
			gMap.map.enableContinuousZoom();
			
			var newPoint = new GLatLng(map_preview_lat,map_preview_lng);
			var newIcon = gMap.iconsHandler.prepareIcon(map_preview_type);
			var newMarker = new GMarker(newPoint,{title: map_preview_title, draggable:false, icon: newIcon});
			gMap.map.addOverlay(newMarker);
			
		}
	},
	onDocumentLoadEdit : function () {
		if (GBrowserIsCompatible()) {
			// map create and customize
			gMap.map = new GMap2(document.getElementById('map_edit'));
			gMap.map.setCenter(new GLatLng(map_edit_lat, map_edit_lng), 16);
			gMap.map.enableDoubleClickZoom();
			gMap.map.enableContinuousZoom();
			gMap.map.addControl(new GOverviewMapControl());
			gMap.map.addControl(new GLargeMapControl());
			gMap.map.addControl(new GMapTypeControl());
			
			var newPoint = new GLatLng(map_edit_lat,map_edit_lng);
			var newIcon = gMap.iconsHandler.prepareIcon(map_edit_type);
			var newMarker = new GMarker(newPoint,{title: map_edit_title, draggable:true, icon: newIcon});
			
			GEvent.addListener(newMarker, 'dragend', function() {
				$('map_edit_marker_lat').value = newMarker.getLatLng().lat();
				$('map_edit_marker_lng').value = newMarker.getLatLng().lng();
			});
			
			
			gMap.map.addOverlay(newMarker);
			
		}
	},
	onDocumentLoadDefaultPosition : function () {
		if (GBrowserIsCompatible()) {
			// map create and customize
			gMap.map = new GMap2(document.getElementById('map_default_position'));
			if (window.map_default_pos_lat && window.map_default_pos_lng && window.map_default_pos_zoom) {
				gMap.map.setCenter(new GLatLng(window.map_default_pos_lat, window.map_default_pos_lng), window.map_default_pos_zoom);
			} else {
				gMap.map.setCenter(new GLatLng(55.755, 37.623), 13);
			}
			
			gMap.map.enableDoubleClickZoom();
			gMap.map.enableContinuousZoom();
			gMap.map.addControl(new GOverviewMapControl());
			gMap.map.addControl(new GLargeMapControl());
			gMap.map.addControl(new GMapTypeControl());
			
			
			GEvent.addListener(gMap.map, 'moveend', function() {
				$('map_default_position_lat').value = gMap.map.getCenter().lat();
				$('map_default_position_lng').value = gMap.map.getCenter().lng();
				$('map_default_position_zoom').value = gMap.map.getZoom();
			});
			
			
			gMap.geocoder = new GClientGeocoder();
			
			$('maps_search_position_submit').addEvent('click', function () {
				gMap.showAddressRequest($('maps_search_position').value);
			});
			
			/*GEvent.addListener(gMap.map, 'zoomend', function() {
				$('map_default_position_lat').value = gMap.map.getCenter().lat();
				$('map_default_position_lng').value = gMap.map.getCenter().lng();
				$('map_default_position_zoom').value = gMap.map.getZoom();
			});*/
		}
	},
	onDocumentLoadAddEvent : function () {
		if (GBrowserIsCompatible()) {
			// map create and customize
			
			gMap.map = new GMap2(document.getElementById('map_add_event_position'));
			if (window.map_default_pos_lat && window.map_default_pos_lng && window.map_default_pos_zoom) {
				gMap.map.setCenter(new GLatLng(window.map_default_pos_lat, window.map_default_pos_lng), window.map_default_pos_zoom);
			} else {
				gMap.map.setCenter(new GLatLng(55.755, 37.623), 13);
			}
			
			gMap.map.enableDoubleClickZoom();
			gMap.map.enableContinuousZoom();
			gMap.map.addControl(new GOverviewMapControl());
			gMap.map.addControl(new GLargeMapControl());
			gMap.map.addControl(new GMapTypeControl());
			
			
			/*GEvent.addListener(gMap.map, 'moveend', function() {
				$('map_default_position_lat').value = gMap.map.getCenter().lat();
				$('map_default_position_lng').value = gMap.map.getCenter().lng();
				$('map_default_position_zoom').value = gMap.map.getZoom();
			});*/
			
			
			gMap.geocoder = new GClientGeocoder();
			
			$('maps_search_position_submit').addEvent('click', function () {
				gMap.showAddressRequest($('maps_search_position').value);
			});
			
			/*GEvent.addListener(gMap.map, 'zoomend', function() {
				$('map_default_position_lat').value = gMap.map.getCenter().lat();
				$('map_default_position_lng').value = gMap.map.getCenter().lng();
				$('map_default_position_zoom').value = gMap.map.getZoom();
			});*/
			
			GEvent.addListener(gMap.map, 'click', function(overlay, point) {
				
				if (overlay) return;
				
				if (gMap.markersHandler.markerAddState) {
					if (gMap.markersHandler.currentMarker != null) {
						gMap.markersHandler.currentMarker.setLatLng(point);
						$('maps_add_event_form').elements['event[marker_lat]'].value = gMap.markersHandler.currentMarker.getLatLng().lat();
						$('maps_add_event_form').elements['event[marker_lng]'].value = gMap.markersHandler.currentMarker.getLatLng().lng();
						$('maps_add_event_form').elements['event[map_center_lat]'].value = gMap.map.getCenter().lat();
						$('maps_add_event_form').elements['event[map_center_lng]'].value = gMap.map.getCenter().lng();
						$('maps_add_event_form').elements['event[map_zoom]'].value = gMap.map.getZoom();
						/* $('maps_add_marker_form_lat').innerHTML = gMap.markersHandler.currentMarker.getLatLng().lat() + '°';
						$('maps_add_marker_form_lng').innerHTML = gMap.markersHandler.currentMarker.getLatLng().lng() + '°'; */
						
					} else {
						var newPoint = point;
						var newIcon = gMap.iconsHandler.prepareIcon('12');
						var newMarker = new GMarker(newPoint,{title:'Íîâûé îáúåêò', draggable:true, icon: newIcon});
						
						gMap.markersHandler.currentMarker = newMarker;
						
						GEvent.addListener(newMarker, 'dragend', function() {
							$('maps_add_event_form').elements['event[marker_lat]'].value = gMap.markersHandler.currentMarker.getLatLng().lat();
							$('maps_add_event_form').elements['event[marker_lng]'].value = gMap.markersHandler.currentMarker.getLatLng().lng();
							$('maps_add_event_form').elements['event[map_center_lat]'].value = gMap.map.getCenter().lat();
							$('maps_add_event_form').elements['event[map_center_lng]'].value = gMap.map.getCenter().lng();
							$('maps_add_event_form').elements['event[map_zoom]'].value = gMap.map.getZoom();
							/* $('maps_add_marker_form_lat').innerHTML = gMap.markersHandler.currentMarker.getLatLng().lat() + '°';
							$('maps_add_marker_form_lng').innerHTML = gMap.markersHandler.currentMarker.getLatLng().lng() + '°'; */
						});
						
						gMap.map.addOverlay(gMap.markersHandler.currentMarker);
						
						$('maps_add_event_form').elements['event[marker_lat]'].value = point.lat();
						$('maps_add_event_form').elements['event[marker_lng]'].value = point.lng();
						$('maps_add_event_form').elements['event[map_center_lat]'].value = gMap.map.getCenter().lat();
						$('maps_add_event_form').elements['event[map_center_lng]'].value = gMap.map.getCenter().lng();
						$('maps_add_event_form').elements['event[map_zoom]'].value = gMap.map.getZoom();
						/* $('maps_add_marker_form_lat').innerHTML = point.lat() + '°';
						$('maps_add_marker_form_lng').innerHTML = point.lng() + '°'; */
					}
				}
				
		 	});
		}
	},
	onDocumentLoadEventPosition :  function() {
	if (GBrowserIsCompatible()) {
			// map create and customize
			gMap.map = new GMap2(document.getElementById('map_show_event_position'));
			gMap.map.setCenter(new GLatLng(map_event_center_lat, map_event_center_lng), map_event_zoom);

			for (var i = 1; i < 12; i++) {
				gMap.markersHandler.markersTypes.include(String(i));
			}
			
			gMap.map.enableDoubleClickZoom();
			gMap.map.enableContinuousZoom();
			gMap.map.addControl(new GOverviewMapControl());
			gMap.map.addControl(new GLargeMapControl());
			gMap.map.addControl(new GMapTypeControl());
			
			var newPoint = new GLatLng(map_event_lat,map_event_lng);
			var newIcon = gMap.iconsHandler.prepareIcon('12');
			var newMarker = new GMarker(newPoint,{title: map_event_title, draggable:false, icon: newIcon});
			gMap.map.addOverlay(newMarker);


		}
	},
	onDocumentEditEventPosition :  function() {
	if (GBrowserIsCompatible()) {
			// map create and customize
			gMap.map = new GMap2(document.getElementById('map_update_event_position'));
			gMap.map.setCenter(new GLatLng(map_event_center_lat, map_event_center_lng), map_event_zoom);

			for (var i = 1; i < 12; i++) {
				gMap.markersHandler.markersTypes.include(String(i));
			}
			
			gMap.map.enableDoubleClickZoom();
			gMap.map.enableContinuousZoom();
			gMap.map.addControl(new GOverviewMapControl());
			gMap.map.addControl(new GLargeMapControl());
			gMap.map.addControl(new GMapTypeControl());
			
			var newPoint = new GLatLng(map_event_lat,map_event_lng);
			var newIcon = gMap.iconsHandler.prepareIcon('12');
			var newMarker = new GMarker(newPoint,{title:map_event_title, draggable:true, icon: newIcon});
			
			gMap.markersHandler.currentMarker = newMarker;
			
			gMap.map.addOverlay(gMap.markersHandler.currentMarker);
			
			GEvent.addListener(gMap.markersHandler.currentMarker, 'dragend', function() {
				$('maps_add_event_form').elements['event[marker_lat]'].value = gMap.markersHandler.currentMarker.getLatLng().lat();
				$('maps_add_event_form').elements['event[marker_lng]'].value = gMap.markersHandler.currentMarker.getLatLng().lng();
				$('maps_add_event_form').elements['event[map_center_lat]'].value = gMap.map.getCenter().lat();
				$('maps_add_event_form').elements['event[map_center_lng]'].value = gMap.map.getCenter().lng();
				$('maps_add_event_form').elements['event[map_zoom]'].value = gMap.map.getZoom();
			});
			
			GEvent.addListener(gMap.map, 'click', function(overlay, point) {
				
				$('maps_add_event_form').elements['event[marker_lat]'].value = gMap.markersHandler.currentMarker.getLatLng().lat();
				$('maps_add_event_form').elements['event[marker_lng]'].value = gMap.markersHandler.currentMarker.getLatLng().lng();
				$('maps_add_event_form').elements['event[map_center_lat]'].value = gMap.map.getCenter().lat();
				$('maps_add_event_form').elements['event[map_center_lng]'].value = gMap.map.getCenter().lng();
				$('maps_add_event_form').elements['event[map_zoom]'].value = gMap.map.getZoom();
				
		 	});
		}
	},
	onDocumentUnload : function () {
		GUnload();
	},
	iconsHandler : {
		prepareIcon : function (markerType) {
			// defaultIcon
			var newIcon = new GIcon();
			newIcon.shadow = '/i/map/shadowfor32x32.png';
			newIcon.iconSize = new GSize(32, 32);
			newIcon.shadowSize = new GSize(58, 34);
			newIcon.iconAnchor = new GPoint(16, 32);
			newIcon.infoWindowAnchor = new GPoint(16, 2);
			newIcon.infoShadowAnchor = new GPoint(0,0);
			switch(markerType) {
				case '1' : 
					newIcon.image = '/i/map/map_obj_1.png';
					break;
				case '2' :
					newIcon.image = '/i/map/map_obj_2.png';
					break;
				case '3' :
					newIcon.image = '/i/map/map_obj_3.png';
					break;
				case '4' :
					newIcon.image = '/i/map/map_obj_4.png';
					break;
				case '5' :
					newIcon.image = '/i/map/map_obj_5.png';
					break;
				case '6' :
					newIcon.image = '/i/map/map_obj_6.png';
					break;
				case '7' :
					newIcon.image = '/i/map/map_obj_7.png';
					break;
				case '8' :
					newIcon.image = '/i/map/map_obj_8.png';
					break;
				case '9' :
					newIcon.image = '/i/map/map_obj_9.png';
					break;
				case '10' :
					newIcon.image = '/i/map/map_obj_10.png';
					break;
				case '11' :
					newIcon.image = '/i/map/map_obj_11.png';
					break;
				case '12' :
					newIcon.image = '/i/map/map_obj_12.png';
					break;
				default : 
					newIcon.image = '/i/map/default.png';
					break;
			}
			return newIcon;
		}
	},
	markersHandler : {
		markerAddState : false,
		markers : [],
		markersObjects : {1:[],2:[],3:[],4:[],5:[],6:[],7:[],8:[],9:[],10:[],11:[]},
		markersTypes : [],
		tags : [],
		currentMarker : null,
		zoomLimit : 10,
		enableMarkerAddState : function () {
			gMap.markersHandler.markerAddState = true;
			$('maps_add_marker').removeClass('hidden');
		},
		disableMarkerAddState : function () {
			gMap.markersHandler.markerAddState = false;
			if (gMap.markersHandler.currentMarker) {
				gMap.markersHandler.currentMarker.hide();
			}
			gMap.markersHandler.currentMarker = null;
			$('maps_add_marker').addClass('hidden');
			$('maps_add_marker_form').reset();
			$('maps_add_marker_form_lat').innerHTML = '';
			$('maps_add_marker_form_lng').innerHTML = '';
		},
		createMarker : function (point) {
			// Set up our GMarkerOptions object
			var markerOptions = { icon : gMap.iconsHandler.prepareIcon() };
			var marker = new GMarker(point, markerOptions);

			return marker;
		},
		onClickMarker : function () {
			
		},
		server : {
			url : '/ajax/map/',
			saveMarker : function () {
				if (($('maps_add_marker_form').elements['marker_lat'].value != '') && ($('maps_add_marker_form').elements['marker_lng'].value != '')) {
					var data = $('maps_add_marker_form').toQueryString() + '&action=add_marker';
					ajaxLoadPost(gMap.markersHandler.server.url, data, gMap.markersHandler.server.saveMarkerOnload, window);
				} else {
					futu_alert(FAT.gmap_header, FAT.gmap_marker_add_no_marker, true, 'error');
				}
				
				
			},
			saveMarkerOnload : function (ajaxObj) {
				if(ajaxObj && ajaxObj.responseXML){

					var xml = ajaxObj.responseXML;
					var errors = xml.getElementsByTagName('error');
					var messages = xml.getElementsByTagName('message');

					if(errors && errors.length && errors[0].firstChild && errors[0].firstChild.nodeType == 3) {
						futu_alert(FAT.gmap_header, errors[0].firstChild.data, true, 'error');

					} else if (messages && messages.length && messages[0].firstChild && messages[0].firstChild.nodeType == 3 && messages[0].firstChild.data == 'ok') {
					
						var marker_type = xml.getElementsByTagName('marker_type')[0].firstChild.data;
						var marker_id = xml.getElementsByTagName('object_id')[0].firstChild.data;
						var marker_title = xml.getElementsByTagName('marker_title')[0].firstChild.data;
						futu_alert(FAT.gmap_header, FAT.gmap_marker_add_success, false, 'message');
						
						var newPoint = new GLatLng(gMap.markersHandler.currentMarker.getLatLng().lat(),gMap.markersHandler.currentMarker.getLatLng().lng());
						var newIcon = gMap.iconsHandler.prepareIcon(marker_type);
						var newMarker = new GMarker(newPoint,{title:marker_title, draggable:false, icon: newIcon});
						gMap.map.addOverlay(newMarker);
						GEvent.addListener(newMarker, 'click', function() {
							gMap.markersHandler.server.loadMarkerInfo(newMarker, marker_id);
						});
						
						gMap.markersHandler.markersObjects[marker_type].push(newMarker);
						gMap.markersHandler.markers.push(marker_id);
						
						gMap.markersHandler.currentMarker.hide();
						
						gMap.markersHandler.currentMarker = null;
						gMap.markersHandler.disableMarkerAddState();
					}
				}
			},
			loadMarkers : function () {
				var bounds = gMap.map.getBounds();
				var zoom = gMap.map.getZoom();
				if (zoom > gMap.markersHandler.zoomLimit) {
					var sw_bound_lat = bounds.getSouthWest().lat();
					var sw_bound_lng = bounds.getSouthWest().lng();
					var ne_bound_lat = bounds.getNorthEast().lat();
					var ne_bound_lng = bounds.getNorthEast().lng();
					if (gMap.activeTag) {
						var data = 'action=list&sw_lat='+sw_bound_lat+'&sw_lng='+sw_bound_lng+'&ne_lat='+ne_bound_lat+'&ne_lng='+ne_bound_lng+'&zoom='+zoom+'&tag='+gMap.activeTagWord.innerHTML;
					} else {
						var data = 'action=list&sw_lat='+sw_bound_lat+'&sw_lng='+sw_bound_lng+'&ne_lat='+ne_bound_lat+'&ne_lng='+ne_bound_lng+'&zoom='+zoom+'&'+$('maps_markers_view_switcher_form').toQueryString();
					}
					
					
					ajaxLoadPost(gMap.markersHandler.server.url, data, gMap.markersHandler.server.loadMarkersOnload, window);
					
				}
			},
			loadMarkersEvent : function () {
				var bounds = gMap.map.getBounds();
				var zoom = gMap.map.getZoom();
				if (zoom > gMap.markersHandler.zoomLimit) {
					var sw_bound_lat = bounds.getSouthWest().lat();
					var sw_bound_lng = bounds.getSouthWest().lng();
					var ne_bound_lat = bounds.getNorthEast().lat();
					var ne_bound_lng = bounds.getNorthEast().lng();
					
					var types = '';
					for(var i=1; i<12; i++) {
						if(i!=11) {
							types += 'object_type[]=' + i + '&';
						}
						else {
							types += 'object_type[]=' + i;
						}
					}

					var data = 'action=list&sw_lat='+sw_bound_lat+'&sw_lng='+sw_bound_lng+'&ne_lat='+ne_bound_lat+'&ne_lng='+ne_bound_lng+'&zoom='+zoom+'&'+types;
					
					ajaxLoadPost(gMap.markersHandler.server.url, data, gMap.markersHandler.server.loadMarkersOnload, window);
					
				}
			},
			loadMarkersOnload : function (ajaxObj) {
				if(ajaxObj && ajaxObj.responseXML){

					var xml = ajaxObj.responseXML;
					var errors = xml.getElementsByTagName('error');
					var messages = xml.getElementsByTagName('message');

					if(errors && errors.length && errors[0].firstChild && errors[0].firstChild.nodeType == 3) {
						futu_alert(FAT.gmap_header, errors[0].firstChild.data, true, 'error');

					} else if (messages && messages.length && messages[0].firstChild && messages[0].firstChild.nodeType == 3 && messages[0].firstChild.data == 'ok') {
						var markers = xml.getElementsByTagName('marker');
						$A(markers).each(function (marker) {
							if (!gMap.markersHandler.markers.contains(marker.getAttribute('id'))) {
								var newPoint = new GLatLng(marker.getAttribute('lat'),marker.getAttribute('lng'));
								
								var marker_types = marker.getAttribute('marker_type').split(',');
								var newIcon = gMap.iconsHandler.prepareIcon(marker_types[marker_types.length-1]);
								
								var newMarker = new GMarker(newPoint,{title: marker.firstChild.data, draggable:false, icon: newIcon});
								gMap.map.addOverlay(newMarker);
								GEvent.addListener(newMarker, 'click', function() {
									gMap.markersHandler.server.loadMarkerInfo(newMarker, marker.getAttribute('id'));
								});
								
								if (window.map_object_id != marker.getAttribute('id')) {
									$A(marker_types).each(function (marker_type_one) {
										marker_type_one = marker_type_one.toInt();
										gMap.markersHandler.markersObjects[marker_type_one].push(newMarker);
									});
									//gMap.markersHandler.markersObjects[marker.getAttribute('marker_type')].push(newMarker);
								} else {
									window.map_object_id = '';
								}
								gMap.markersHandler.markers.push(marker.getAttribute('id'));
								
							}
						});
						
						for (var i = 1; i < 12; i++) {
							$A(gMap.markersHandler.markersObjects[i]).each(function (mm) {
								mm.hide();
							});
						}
						
						
						for (var i = 1; i < 12; i++) {
							$A(gMap.markersHandler.markersObjects[i]).each(function (mm) {
								
								if (gMap.markersHandler.markersTypes.contains(String(i))) {
									mm.show();
								}
							});
						}
						
					}
				}
			},
			loadMarkerInfo : function (marker, marker_id) {
				marker.openInfoWindowHtml('<div><img src="/i/loading.gif"></div>');
				var data = 'action=get_info'+'&id='+marker_id;
				ajaxLoadPost(gMap.markersHandler.server.url, data, gMap.markersHandler.server.loadMarkerInfoOnload, window, {marker: marker, marker_id:marker_id});
			},
			loadMarkerInfoOnload : function (ajaxObj, opts) {
				if(ajaxObj && ajaxObj.responseXML){
					
					var ourMarker = opts.marker;
					var ourMarkerId = opts.marker_id;
					
					var xml = ajaxObj.responseXML;
					var errors = xml.getElementsByTagName('error');
					var messages = xml.getElementsByTagName('message');

					if(errors && errors.length && errors[0].firstChild && errors[0].firstChild.nodeType == 3) {
						futu_alert(FAT.gmap_header, errors[0].firstChild.data, true, 'error');

					} else if (messages && messages.length && messages[0].firstChild && messages[0].firstChild.nodeType == 3 && messages[0].firstChild.data == 'ok') {
						if (xml.getElementsByTagName('title')[0].firstChild) {
							var markerTitle = xml.getElementsByTagName('title')[0].firstChild.data;
						} else {
							var markerTitle = '';
						}
						if (xml.getElementsByTagName('description')[0].firstChild) {
							var markerDescription = xml.getElementsByTagName('description')[0].firstChild.data;
						} else {
							var markerDescription = '';
						}
						if (xml.getElementsByTagName('score')[0].firstChild) {
							var markerScore = xml.getElementsByTagName('score')[0].firstChild.data;
						} else {
							var markerScore = '';
						}
						
						if (xml.getElementsByTagName('class')[0].firstChild) {
							var markerVoteClass = 'voting ' + xml.getElementsByTagName('class')[0].firstChild.data;
						} else {
							var markerVoteClass = '';
						}
						
						if (xml.getElementsByTagName('id')[0].firstChild) {
							var markerId = xml.getElementsByTagName('id')[0].firstChild.data;
						} else {
							var markerId = '';
						}
						
						if (xml.getElementsByTagName('comments_count')[0].firstChild) {
							var commentsCount = xml.getElementsByTagName('comments_count')[0].firstChild.data;
						} else {
							var commentsCount = null;
						}
						if (xml.getElementsByTagName('new_comments_count')[0].firstChild) {
							var newCommentsCount = xml.getElementsByTagName('new_comments_count')[0].firstChild.data;
						} else {
							var newCommentsCount = null;
						}
						/* markerScore = 100*markerScore/5; */
						var iHTML = '';
						iHTML    += '<table class="title_rate" style="width:300px; margin:0 0 0.5em;"><tbody><tr>';
						iHTML    += '	<td class="rate_name">';
						iHTML    += '		<h3 style="margin-bottom:0;"><span><a href="/map/about/'+ourMarkerId+'/">'+markerTitle+'</a></span></h3>';
						iHTML    += '	</td>';
						iHTML    += '	<td class="rate_voter" style="padding-left:5px; vertical-align:bottom;">';
						iHTML    += '		<div id="map_object'+markerId+'" class="voting_outer rator vote_holder" style="padding:0;">';
						iHTML    += '			<div class="'+markerVoteClass+'">';
						iHTML    += '				<table class="vote_points">';
						iHTML    += '					<tr>';
						iHTML    += '						<td><a class="vote_plus" onclick="return Voter.vote(event, this, \'map_object\', \'plus\');" href=""></a></td>';
						iHTML    += '						<td><em>'+markerScore+'</em></td>';
						iHTML    += '						<td><a class="vote_minus" onclick="return Voter.vote(event, this, \'map_object\', \'minus\');" href=""></a></td>';
						iHTML    += '					</tr>';
						iHTML    += '				</table>';
						iHTML    += '			</div>';
						iHTML    += '		</div>';
						iHTML    += '	</td>';
						iHTML    += '</tr></tbody></table>';
						
/* 						iHTML    += '<table class="title_rate map_rate"><tbody><tr>';
						iHTML    += '	<td class="rate_name">';
						iHTML    += '		<h3><span><a href="/map/about/'+ourMarkerId+'/">'+markerTitle+'</a></span></h3>';
						iHTML    += '	</td>';
						iHTML    += '	<td class="rate_voter" style="padding-left:5px;">';
						iHTML    += '		<div id="map_object'+markerId+'" class="voting_outer rator vote_holder" style="padding:0;">';
						iHTML    += '			<div class="'+markerVoteClass+'">';
						iHTML    += '				<div class="voting_empty" onmouseover="mapVoter.animation.over(event, this);"  onmousemove="mapVoter.animation.over(event, this);" onmouseout="mapVoter.animation.out(event, this, ' + markerScore + ');" onclick="mapVoter.vote(event, this);">';
						iHTML    += '					<div class="voting_full" style="width:' + markerScore + '%;">';
						iHTML    += '					</div>';
						iHTML    += '				</div>';
						iHTML    += '			</div>';
						iHTML    += '		</div>';
						iHTML    += '	</td>';
						iHTML    += '</tr></tbody></table>';*/
						iHTML    += '<div class="gmap_info_window">';
						
						//iHTML    += '	<h3><a href="/map/about/'+ourMarkerId+'/">'+markerTitle+'</a></h3>';
						iHTML    += '	<div class="description block_semi">'+markerDescription+'</div>';
						
						iHTML    += '	<div class="f_right"><span><a href="/map/about/' + ourMarkerId + '#comments_block" class="icon comment"><img src="/i/0.gif" alt="">'+commentsCount;
						if (newCommentsCount) {
							iHTML    += ' / <strong>'+newCommentsCount+'</strong>';
						}
						iHTML    += '	</a></span></div>';
						iHTML    += '</div>';
						
						ourMarker.openInfoWindowHtml(iHTML);
					}
				}
			},
			editMarker : function () {
				var data = $('maps_marker_edit_form').toQueryString() + '&action=update_marker';
				ajaxLoadPost(gMap.markersHandler.server.url, data, gMap.markersHandler.server.editMarkerOnload, window);
			},
			editMarkerOnload : function (ajaxObj) {
				if(ajaxObj && ajaxObj.responseXML){

					var xml = ajaxObj.responseXML;
					var errors = xml.getElementsByTagName('error');
					var messages = xml.getElementsByTagName('message');
					var redirect = xml.getElementsByTagName('redirect');
					
					if(errors && errors.length && errors[0].firstChild && errors[0].firstChild.nodeType == 3) {
						futu_alert(FAT.gmap_header, errors[0].firstChild.data, true, 'error');

					} else if (messages && messages.length && messages[0].firstChild && messages[0].firstChild.nodeType == 3 && messages[0].firstChild.data == 'ok') {
						if (redirect && redirect.length && redirect[0].firstChild && redirect[0].firstChild.nodeType == 3) {
							var redirectLink = redirect[0].firstChild.data;
							window.location.href = redirectLink;
						}
					}
				}
			},
			deleteMarker : function (marker_id) {
				var data = 'action=delete_marker&marker_id='+marker_id;
				ajaxLoadPost(gMap.markersHandler.server.url, data, gMap.markersHandler.server.deleteMarkerOnload, window);
			},
			deleteMarkerOnload : function (ajaxObj) {
				if(ajaxObj && ajaxObj.responseXML){

					var xml = ajaxObj.responseXML;
					var errors = xml.getElementsByTagName('error');
					var messages = xml.getElementsByTagName('message');
					var redirect = xml.getElementsByTagName('redirect');
					
					if(errors && errors.length && errors[0].firstChild && errors[0].firstChild.nodeType == 3) {
						futu_alert(FAT.gmap_header, errors[0].firstChild.data, true, 'error');

					} else if (messages && messages.length && messages[0].firstChild && messages[0].firstChild.nodeType == 3 && messages[0].firstChild.data == 'ok') {
						if (redirect && redirect.length && redirect[0].firstChild && redirect[0].firstChild.nodeType == 3) {
							var redirectLink = redirect[0].firstChild.data;
							window.location.href = redirectLink;
						} else {
							window.location.href = '/map/';
						}
					}
				}
			}
		},
		showMarkersEvent : function () {
			gMap.markersHandler.server.loadMarkersEvent();

			gMap.markersHandler.showMarkersEventListener = GEvent.addListener(gMap.map, 'moveend', function() {
				gMap.markersHandler.server.loadMarkersEvent();
			});
			
			for (var i = 1; i < 12; i++) {
				$A(gMap.markersHandler.markersObjects[i]).each(function (mm) {
					
					if (gMap.markersHandler.markersTypes.contains(String(i))) {
						mm.show();
					}
				});
			}
			
			$('show_markers_event').addClass('hidden');
			$('hide_markers_event').removeClass('hidden');
		},
		hideMarkersEvent : function () {
			for (var i = 1; i < 12; i++) {
				$A(gMap.markersHandler.markersObjects[i]).each(function (mm) {
					
					if (gMap.markersHandler.markersTypes.contains(String(i))) {
						mm.hide();
					}
				});
			}
			
			gMap.map.closeInfoWindow();
			
			GEvent.removeListener(gMap.markersHandler.showMarkersEventListener);
			
			$('hide_markers_event').addClass('hidden');
			$('show_markers_event').removeClass('hidden');
		},
		enableMarkerAddStateEvent : function () {
			gMap.markersHandler.markerAddState = true;
			if (gMap.markersHandler.currentMarker) {
				gMap.markersHandler.currentMarker.show();
				$('maps_add_event_form').elements['event[marker_lat]'].value = gMap.markersHandler.currentMarker.getLatLng().lat();
				$('maps_add_event_form').elements['event[marker_lng]'].value = gMap.markersHandler.currentMarker.getLatLng().lng();
				$('maps_add_event_form').elements['event[map_center_lat]'].value = gMap.map.getCenter().lat();
				$('maps_add_event_form').elements['event[map_center_lng]'].value = gMap.map.getCenter().lng();
				$('maps_add_event_form').elements['event[map_zoom]'].value = gMap.map.getZoom();
			}
			$('maps_set_position_submit').addClass('hidden');
			$('maps_set_position_cancel').removeClass('hidden');
		},
		disableMarkerAddStateEvent : function () {
			gMap.markersHandler.markerAddState = false;
			if (gMap.markersHandler.currentMarker) {
				gMap.markersHandler.currentMarker.hide();
			}
			$('maps_add_event_form').elements['event[marker_lat]'].value = '';
			$('maps_add_event_form').elements['event[marker_lng]'].value = '';
			$('maps_add_event_form').elements['event[map_center_lat]'].value = '';
			$('maps_add_event_form').elements['event[map_center_lng]'].value = '';
			$('maps_add_event_form').elements['event[map_zoom]'].value = '';
			$('maps_set_position_cancel').addClass('hidden');
			$('maps_set_position_submit').removeClass('hidden');
		}
	},
	selectAll : function(what) {
		if (what) {
			for (i = 1; i < 12; i++) {
				if (($('maps_markers_t_'+i)) && ($('maps_markers_t_'+i).checked == false)) {
					$('maps_markers_t_'+i).checked = true;
					gMap.markersHandler.markersTypes.include(String(i));
				}
			}
		} else {
			for (i = 1; i < 12; i++) {
				if (($('maps_markers_t_'+i)) && ($('maps_markers_t_'+i).checked == true)) {
					$('maps_markers_t_'+i).checked = false;
					gMap.markersHandler.markersTypes.remove(String(i));
				}
			}
		}
		gMap.markersHandler.server.loadMarkers();
	},
	showAddressRequest : function (address) {
		if (address.trim() == '') {
			futu_alert(FAT.gmap_header, FAT.gmap_search_place_no_address_error, false, 'error');
		} else {
			gMap.showAddress(address);
		}
	},
	showAddress : function (address) {
		if (gMap.geocoder) {
			gMap.geocoder.getLatLng(address, function(point) {
				if (!point) {
					futu_alert(FAT.gmap_header, 'Ìåñòî «' + address + '» íå íàéäåíî', false, 'error');
				} else {
					gMap.map.setCenter(point);
				}
			});
		}
	},
	setEventZoom : function() {
		$('maps_add_event_form').elements['event[map_center_lat]'].value = gMap.map.getCenter().lat();
		$('maps_add_event_form').elements['event[map_center_lng]'].value = gMap.map.getCenter().lng();
		$('maps_add_event_form').elements['event[map_zoom]'].value = gMap.map.getZoom();
	},
	showCityOnMapEvent : function() {
		if ($$('#listCities_holder select')[0].value != 0) {
			$('maps_search_position').value = $$('#listCountries_holder select')[0].options[$$('#listCountries_holder select')[0].selectedIndex].innerHTML + ' ' + $$('#listCities_holder select')[0].options[$$('#listCities_holder select')[0].selectedIndex].innerHTML;
			gMap.showAddressRequest($('maps_search_position').value);
		}
	}
	
};

window.addEvent('load', function () {
	
	if ($('map')) {
		gMap.onDocumentLoad();
		GEvent.trigger(gMap.map, 'load');
	} else if ($('map_preview')) {
		gMap.onDocumentLoadPreview();
	} else if ($('map_edit')) {
		gMap.onDocumentLoadEdit();
	} else if ($('map_default_position')) {
		gMap.onDocumentLoadDefaultPosition();
	} else if ($('map_show_event_position')) {
		gMap.onDocumentLoadEventPosition();
	} else if ($('map_add_event_position')) {
		gMap.onDocumentLoadAddEvent();
	} else if ($('map_update_event_position')) {
		gMap.onDocumentEditEventPosition();
	}
	
});

window.addEvent('unload', function () {
	if ($('map') || $('map_preview') || $('map_edit')) {
		gMap.onDocumentUnload();
	}
});
