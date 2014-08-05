
	/**
	 * jQuery
	 */
	
	var piece_previous = null;
	var index = 0;
	var max_shuffle_moves = 100;
	
	$ ( window ).load ( function ( ) {
	
		var piece_empty = $ ( '#piece-empty' );
	
		var size = $ ( '#game-wrapper img:first-child' ).width ( );
		var cols = $ ( '#game-wrapper' ).width ( ) / size;
		var rows = $ ( '#game-wrapper' ).height ( ) / size;
	
		$ ( '#game-wrapper img' ).each ( function ( i, child ) {
			var top = ( ( i % cols ) * size ) + 'px';
			var left = ( Math.floor ( i / cols ) * size ) + 'px';
	
			$ ( child ).css ( {
				'left' : left,
				'top' : top
			} );
		} );
	
		piece_empty.css ( {
			'left' : ( cols * size - size ) + 'px',
			'top' : ( rows * size - size ) + 'px',
		} );
	
		$ ( '#game-wrapper img' ).click ( function ( ) {
			diff_x = parseInt ( $ ( this ).css ( 'left' ) ) - parseInt ( piece_empty.css ( 'left' ) );
			diff_y = parseInt ( $ ( this ).css ( 'top' ) ) - parseInt ( piece_empty.css ( 'top' ) );
			diff_x_abs = Math.abs ( parseInt ( $ ( this ).css ( 'left' ) ) - parseInt ( piece_empty.css ( 'left' ) ) );
			diff_y_abs = Math.abs ( parseInt ( $ ( this ).css ( 'top' ) ) - parseInt ( piece_empty.css ( 'top' ) ) );
	
			if ( ( diff_x_abs + diff_y_abs ) == size ) {
				swap ( $ ( this ), piece_empty, 250 );
				console.log ( 'schuif niks' );
			}
			else
			if ( diff_x == 0 ) {
				console.log ( 'schuif meerdere verticaal' );
				console.log ( diff_y );
			}
			else
			if ( diff_y == 0 ) {
				console.log ( 'schuif meerdere horizontaal' );
				console.log ( diff_x );
			}
		} );
	
		// shuffle pieces
		timer = window.setInterval ( function ( ) {
			shuffle ( piece_empty, size );
			index++;
	
			if ( index == max_shuffle_moves ) {
				clearInterval ( timer );
			}
		}, 150 );
	
	} );
	
	function swap ( piece_clicked, piece_empty, duration ) {
		piece_empty_css = {
			'left' : piece_empty.css ( 'left' ),
			'top' : piece_empty.css ( 'top' )
		}
		piece_clicked_css = {
			'left' : piece_clicked.css ( 'left' ),
			'top' : piece_clicked.css ( 'top' )
		}
	
		piece_clicked.animate ( piece_empty_css, duration );
		piece_empty.animate ( piece_clicked_css, duration );
	}
	
	function shuffle ( piece_empty, size ) {
		var candidates = new Array ( );
		piece_empty_css = {
			'left' : piece_empty.css ( 'left' ),
			'top' : piece_empty.css ( 'top' )
		}
	
		$ ( '#game-wrapper img' ).each ( function ( i, child ) {
			diff_x = Math.abs ( parseInt ( $ ( child ).css ( 'left' ) ) - parseInt ( piece_empty.css ( 'left' ) ) );
			diff_y = Math.abs ( parseInt ( $ ( child ).css ( 'top' ) ) - parseInt ( piece_empty.css ( 'top' ) ) );
	
			if ( ( diff_x + diff_y ) == size && ( piece_previous == null || $ ( child ).prop ( 'id' ) != piece_previous.prop ( 'id' ) ) ) {
				candidates.push ( $ ( this ) );
			}
		} );
	
		num_candidates = candidates.length;
		var index = Math.floor ( ( Math.random ( ) * num_candidates ) );
		the_piece = candidates [ index ];
		piece_previous = the_piece;
		swap ( the_piece, piece_empty, 100 );
	}
