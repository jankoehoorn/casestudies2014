// Handle messages received from the player
function onMessageReceived ( e ) {
	var data = JSON.parse ( e.data );

	switch (data.event) {
		case 'ready':
			onReady ( );
			break;

		case 'play':
			onPlay ( data );
			break;

		case 'pause':
			onPause ( data );
			break;

		case 'playProgress':
			onPlayProgress ( data );
			break;

		case 'finish':
			onFinish ( data );
			break;
	}
}

// Helper function for sending a message to the player
function post ( f, action, value ) {
	var data = {
		method : action
	};

	if ( value ) {
		data.value = value;
	}

	if ( typeof f.contentWindow != 'undefined' ) {
		f.contentWindow.postMessage ( JSON.stringify ( data ), $ ( f ).attr ( 'src' ).split ( '?' )[ 0 ] );
	}
}

function onReady ( ) {
	// $iframes has to be globally declared!
	for ( var i in $iframes ) {
		post ( $iframes[ i ], 'addEventListener', 'play' );
		post ( $iframes[ i ], 'addEventListener', 'pause' );
		post ( $iframes[ i ], 'addEventListener', 'finish' );
		post ( $iframes[ i ], 'addEventListener', 'playProgress' );
	}
}

function onFinish ( data ) {
	$.ajax ( {
		async : false,
		url : 'ajax.php',
		data : {
			action : 'append-log-track-video-finished',
			video_id : data.player_id
		},
		success : function ( ajax_response ) {
			$response.text ( ajax_response );
			$response.animate ( {
				scrollTop : $response.prop ( 'scrollHeight' )
			}, anim_speed );
		}
	} );
}

function onPlay ( data ) {
	$.ajax ( {
		async : false,
		url : 'ajax.php',
		data : {
			action : 'append-log-track-video-play',
			video_id : data.player_id
		},
		success : function ( ajax_response ) {
			$response.text ( ajax_response );
			$response.animate ( {
				scrollTop : $response.prop ( 'scrollHeight' )
			}, anim_speed );
		}
	} );
}

function onPause ( data ) {
	$.ajax ( {
		async : false,
		url : 'ajax.php',
		data : {
			action : 'append-log-track-video-paused',
			video_id : data.player_id
		},
		success : function ( ajax_response ) {
			$response.text ( ajax_response );
			$response.animate ( {
				scrollTop : $response.prop ( 'scrollHeight' )
			}, anim_speed );
		}
	} );
}

function onPlayProgress ( data ) {
	position = data.seconds;
}
