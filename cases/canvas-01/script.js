/**
 * jQuery
 */
$ ( 'document' ).ready ( function ( ) {
	var canvas1 = document.getElementById ( 'canvas1' );
	var context1 = canvas1.getContext ( '2d' );
	var w1 = canvas1.width;
	var h1 = canvas1.height;
	var image_data = context1.createImageData ( w1, h1 );

	// draw random dots
	for ( i = 0; i < 10000; i++ ) {
		x = Math.random ( ) * w1 | 0;
		// |0 to truncate to Int32
		y = Math.random ( ) * h1 | 0;
		r = Math.random ( ) * 256 | 0;
		g = Math.random ( ) * 256 | 0;
		b = Math.random ( ) * 256 | 0;

		// 255 = alpha opaque
		setPixel ( image_data, x, y, r, g, b, 255 );
	}

	context1.putImageData ( image_data, 0, 0 );
} );

function setPixel ( image_data, x, y, r, g, b, a ) {
	index = ( x + y * image_data.width ) * 4;
	image_data.data[ index + 0 ] = r;
	image_data.data[ index + 1 ] = g;
	image_data.data[ index + 2 ] = b;
	image_data.data[ index + 3 ] = a;
}