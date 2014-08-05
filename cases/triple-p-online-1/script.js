/**
 * jQuery
 */
$ ( 'document' ).ready ( function ( ) {
	var $items = $ ( '#cubes li' );
	var $prev_item = null;
	var animations = [ 'flash', 'bounce', 'shake', 'tada', 'swing', 'wobble', 'pulse' ];
	var num_items = $items.length;
	var num_animations = animations.length;
	var prev_animation = '';
	var prev_j = 0;

	var timer = window.setInterval ( function ( ) {
		var i = Math.floor ( ( Math.random ( ) * num_items ) );
		do {
			var j = Math.floor ( ( Math.random ( ) * num_animations ) );
		}
		while (j==prev_j);

		$items.removeClass ( 'animated ' + prev_animation );
		$ ( $items [ i ] ).addClass ( 'animated ' + animations [ j ] );

		prev_j = j;
		prev_animation = animations [ j ];
	}, 4000 );

} );
