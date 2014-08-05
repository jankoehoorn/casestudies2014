/**
 * jQuery
 */
$ ( 'document' ).ready ( function ( ) {
	$ ( '.tile img' ).each ( function ( index, child ) {
		var img = $ ( child );
		var tile = img.parent ( );
		var tile_w = tile.width ( );
		var tile_h = tile.height ( );
		var img_w = img.width ( );
		var img_h = img.height ( );
		var img_aspect_ratio = img_w / img_h;

		if ( img_aspect_ratio > 1 ) {
			img.css ( {
				'height' : '100%'
			} );

			var img_w_new = img.width ( );
			var margin_left = Math.round ( ( tile_w - img_w_new ) / 2 );

			img.css ( {
				'margin-left' : margin_left + 'px'
			} );

		}
		else {
			img.css ( {
				'width' : '100%'
			} );
		}
	} );
} );
