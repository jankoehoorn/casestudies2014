var map;
var markers = [ ];

$ ( window ).load ( function ( ) {
	var bounds_limit = new google.maps.LatLngBounds ( new google.maps.LatLng ( -46.67439713683608, 97.03648437499999 ), new google.maps.LatLng ( 1.5894024243201075, 176.138046875 ) );
	var MAPTYPE_AREA_LOCATOR = 'Area Locator Tool';
	var styles = [ {
		featureType : 'all',
		stylers : [ {
			color : '#BECBED'
		} ]
	} ];
	var styled_map_options = {
		name : 'Area Locator Tool'
	};
	var center = new google.maps.LatLng ( -24.83969127219106, 136.587265625 );
	var center_latlng_last_valid = center;
	var options = {
		// zoomControl : false,
		// scrollwheel : false,
		// disableDoubleClickZoom : true,
		// streetViewControl : false,
		// mapTypeControl : false,
		zoom : 4,
		center : center,
		mapTypeControlOptions : {
			mapTypeIds : [ google.maps.MapTypeId.ROADMAP, MAPTYPE_AREA_LOCATOR ]
		},
		mapTypeId : google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map ( document.getElementById ( 'map-canvas' ), options );
	var custom_maptype = new google.maps.StyledMapType ( styles, styled_map_options );
	map.mapTypes.set ( MAPTYPE_AREA_LOCATOR, custom_maptype );
	var kmllayer = new google.maps.KmlLayer ( {
		preserveViewport : true,
		url : 'http://www.jankoehoorn.nl/casestudies2013/cases/area-locator-tool/kml/us_states_php_1387023764.kml'
	} );
	kmllayer.setMap ( map );

	// prevent dragging beyond boundary
	google.maps.event.addListener ( map, 'center_changed', function ( ) {
		if ( bounds_limit.contains ( map.getCenter ( ) ) ) {
			center_latlng_last_valid = map.getCenter ( );
			return;
		}

		// map.panTo ( center_latlng_last_valid );
	} );

	// provide feedback about boundaries and center
	google.maps.event.addListener ( map, 'idle', function ( ) {
		center_latlng = map.getCenter ( );
		$ ( '#center_lat' ).val ( center_latlng.lat ( ) );
		$ ( '#center_lng' ).val ( center_latlng.lng ( ) );

		var sw = map.getBounds ( ).getSouthWest ( );
		var ne = map.getBounds ( ).getNorthEast ( );

		$ ( '#sw' ).val ( sw.toString ( ) );
		$ ( '#ne' ).val ( ne.toString ( ) );
		$ ( '#center' ).val ( center_latlng.toString ( ) );

		$ ( '#zoom' ).val ( map.getZoom ( ) );

	} );

	// provide feedback about mouse position
	google.maps.event.addListener ( map, 'click', function ( e ) {
		$ ( '#mouse' ).val ( e.latLng.toString ( ) );
	} );

	// toggle visibility of kmllayer
	$ ( '#toggle' ).click ( function ( ) {
		kmllayer.setMap ( $ ( this ).prop ( 'checked' ) ? map : null );
	} );

	$ ( '#search' ).click ( function ( ) {
		// Clear markers from a eventual previous search
		for ( i = 0; i < markers.length; i++ ) {
			markers[ i ].setMap ( null );
		}

		var searchfor = $ ( '#searchfor' ).val ( );
		var geocoder = new google.maps.Geocoder ( );

		geocoder.geocode ( {
			'address' : searchfor
		}, function ( results, status ) {
			if ( status == google.maps.GeocoderStatus.OK ) {
				var bounds_cur = map.getBounds ( );

				for ( var i in results ) {
					var location = results[ i ].geometry.location;
					var latlng_found = new google.maps.LatLng ( location.lat ( ), location.lng ( ) );
					// Bron icon urls: http://www.lass.it/Web/viewer.aspx?id=4
					var icon_url = 'http://maps.google.com/mapfiles/ms/micons/green-dot.png';

					if ( !bounds_cur.contains ( latlng_found ) ) {
						icon_url = 'http://maps.google.com/mapfiles/ms/micons/red-dot.png';
					}

					var marker = new google.maps.Marker ( {
						icon : icon_url,
						position : latlng_found,
						map : map
					} );
					markers.push ( marker );
					// map.setZoom ( 9 );
					// map.panTo ( latlng_found );
					// }
				}
			}
		} );

		var service = new google.maps.places.PlacesService ( map );
		service.textSearch ( {
			'query' : searchfor
		}, function ( results, status ) {
			if ( status == google.maps.places.PlacesServiceStatus.OK ) {
				var bounds_cur = map.getBounds ( );

				for ( var i in results ) {
					var location = results[ i ].geometry.location;
					var latlng_found = new google.maps.LatLng ( location.lat ( ), location.lng ( ) );
					// Bron icon urls: http://www.lass.it/Web/viewer.aspx?id=4
					var icon_url = 'http://maps.google.com/mapfiles/ms/micons/blue-dot.png';

					if ( !bounds_cur.contains ( latlng_found ) ) {
						icon_url = 'http://maps.google.com/mapfiles/ms/micons/orange-dot.png';
					}

					var marker = new google.maps.Marker ( {
						icon : icon_url,
						position : latlng_found,
						map : map
					} );
					markers.push ( marker );
				}

			}
		} );
	} );

	$ ( 'a.pan-to-area' ).click ( function ( e ) {
		e.preventDefault ( );

		var area = $ ( this ).attr ( 'id' );
		var areas = {
			'netherlands' : {
				'lat' : 51.63635905722937,
				'lng' : 5.036972656250001,
				'zoom' : 7
			},
			'saskatchewan' : {
				'lat' : 54.530578300088884,
				'lng' : -105.22181640625,
				'zoom' : 5
			},
			'australia' : {
				'lat' : -25.79307101009263,
				'lng' : 134.56578125,
				'zoom' : 4
			}
		};
		var latlng = new google.maps.LatLng ( areas[ area ].lat, areas[ area ].lng );

		map.panTo ( latlng );
		map.setZoom ( areas[ area ].zoom );
	} );

	$ ( '#radius' ).change ( function ( ) {
		var r = 1000 * parseInt ( $ ( this ).val ( ) );

		if ( r > 0 ) {
			var c = new google.maps.Circle ( {
				radius : r,
				center : map.getCenter ( )
			} );

			map.fitBounds ( c.getBounds ( ) );
		}
	} );

	$ ( '#set-center-and-zoom' ).click ( function ( ) {
		var latlng = new google.maps.LatLng ( parseFloat ( $ ( '#set-lat' ).val ( ) ), parseFloat ( $ ( '#set-lng' ).val ( ) ) );
		map.setCenter ( latlng );
		map.setZoom ( parseInt ( $ ( '#set-zoom' ).val ( ) ) );
	} );
} );
