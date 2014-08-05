$ ( 'document' ).ready ( function ( ) {
	var alkmaar = new google.maps.LatLng ( 52.633909846747, 4.849268188476563 );
	var schagen = new google.maps.LatLng ( 52.78715015334251, 4.799652099609375 );
	var medemblik = new google.maps.LatLng ( 52.764927647230095, 5.104522705078125 );
	var hoorn = new google.maps.LatLng ( 52.64872938781106, 5.0701904296875 );
	var locations_level_1 = [ alkmaar, schagen, medemblik, hoorn ];

	var denhelder = new google.maps.LatLng ( 52.94996186543991, 4.75433349609375 );
	var enkhuizen = new google.maps.LatLng ( 52.709342606605055, 5.27069091796875 );
	var locations_level_2 = [ denhelder, enkhuizen ];

	var amsterdam = new google.maps.LatLng ( 52.36788548733783, 4.898529052734375 );
	var zaandam = new google.maps.LatLng ( 52.44169704941349, 4.824371337890625 );
	var locations_level_3 = [ amsterdam, zaandam ];

	var levels = [ locations_level_1, locations_level_2, locations_level_3 ];
	var options = {
		center : alkmaar,
		zoom : 9
	};
	var map = new google.maps.Map ( document.getElementById ( 'map-canvas' ), options );
	var icons = [ 'markers/marker-blue.png', 'markers/marker-lightblue.png', 'markers/marker-pink.png' ];

	var markers = [ [ ], [ ], [ ] ];

	for ( i = 0; i < levels.length; i++ ) {
		for ( j = 0; j < levels[ i ].length; j++ ) {
			var marker = new google.maps.Marker ( {
				position : levels[i][ j ],
				map : map,
				icon : 'http://www.jankoehoorn.nl/casestudies2014/cases/store-locator-2/' + icons[ i ]
			} );
			markers[ i ].push ( marker );
		}
	}

	$ ( '#levels input' ).click ( function ( ) {
		if ( $ ( this ).prop ( 'checked' ) ) {
			show_markers ( markers[  $ ( this ).val ( ) ], map );
		}
		else {
			hide_markers ( markers[  $ ( this ).val ( ) ] );
		}
	} );
} );

function hide_markers ( markers ) {
	for ( i = 0; i < markers.length; i++ ) {
		markers[ i ].setMap ( null );
	}
}

function show_markers ( markers, map ) {
	for ( i = 0; i < markers.length; i++ ) {
		markers[ i ].setMap ( map );
	}
}
