var $iframes;
var position;
var $response;
var anim_speed = 1000;
var time_mouse_enter = 0;
var time_mouse_leave = 0;

$ ( 'document' ).ready ( function ( ) {

	$response = $ ( '#response' );

	// Video tracking section
	$iframes = $ ( '#video-wrapper iframe' );

	// Keep for later ...
	// url = $(child).attr('src').split('?')[ 0 ];

	// Listen for messages from the player
	if ( window.addEventListener ) {
		window.addEventListener ( 'message', onMessageReceived, false );
	}
	else {
		window.attachEvent ( 'onmessage', onMessageReceived, false );
	}

	// Click tracking section
	$ ( 'a.sis-click' ).click ( function ( e ) {
		// Comment the following line to follow the hyperlinks after the AJAX call
		e.preventDefault ( );

		$.ajax ( {
			async : false,
			url : 'ajax.php',
			data : {
				action : 'append-log-track-click',
				link_id : $ ( this ).attr ( 'id' ),
				link_href : $ ( this ).attr ( 'href' ),
				page_url : location.href
			},
			success : function ( ajax_response ) {
				$response.text ( ajax_response );
				$response.animate ( {
					scrollTop : $response.prop ( 'scrollHeight' )
				}, anim_speed );
			}
		} );
	} );

	// Hover tracking section
	$ ( '.sis-hover' ).mouseenter ( function ( ) {
		time_mouse_enter = +new Date ( );
	} );

	$ ( '.sis-hover' ).mouseleave ( function ( ) {
		time_mouse_leave = +new Date ( );
		time_mouse_hover = ( time_mouse_leave - time_mouse_enter ) / 1000;
		time_mouse_hover = time_mouse_hover.toFixed ( 1 );

		$.ajax ( {
			async : false,
			url : 'ajax.php',
			data : {
				action : 'append-log-track-hovertime',
				link_id : $ ( this ).attr ( 'id' ),
				hovertime : time_mouse_hover
			},
			success : function ( ajax_response ) {
				$response.text ( ajax_response );
				$response.animate ( {
					scrollTop : $response.prop ( 'scrollHeight' )
				}, anim_speed );
			}
		} );

	} );

	$ ( '#clear-log' ).click ( function ( ) {
		$.ajax ( {
			url : 'ajax.php',
			data : {
				action : 'clear-log'
			},
			success : function ( ajax_response ) {
				$response.text ( '' );
			}
		} );
	} );

} );
