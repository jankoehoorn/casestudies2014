<!DOCTYPE html>
<title>Video/Canvas Demo 4</title>
<script>
	document.addEventListener ( 'DOMContentLoaded', function ( ) {
		var v = document.getElementById ( 'v' );
		var canvas = document.getElementById ( 'c' );
		var context = canvas.getContext ( '2d' );
		var back = document.createElement ( 'canvas' )
		var backcontext = back.getContext ( '2d' );

		var cw, ch;

		v.addEventListener ( 'play', function ( ) {
			cw = v.clientWidth;
			ch = v.clientHeight;
			canvas.width = cw;
			canvas.height = ch;
			back.width = cw;
			back.height = ch;
			draw ( v, context, backcontext, cw, ch );
		}, false );

	}, false );

	function draw ( v, c, bc, cw, ch ) {
		if ( v.paused || v.ended )
			return false;
		// First, draw it into the backing canvas
		bc.drawImage ( v, 0, 0, cw, ch );
		// Grab the pixel data from the backing canvas
		var idata = bc.getImageData ( 0, 0, cw, ch );
		var data = idata.data;
		var w = idata.width;
		var limit = data.length
		// loop through the subpixels
		// alpha 0 = transparent, 255 = opaque
		for ( var i = 0; i < limit; i = i + 4 ) {
			r = data[ i + 0 ];
			g = data[ i + 1 ];
			b = data[ i + 2 ];
			a = data[ i + 3 ];

			if ( r + g + b > 450 ) {
				a = 0;
			}
			else {
				a = 255;
			}

			data[ i + 0 ] = r + 50;
			data[ i + 1 ] = g;
			data[ i + 2 ] = b;
			data[ i + 3 ] = a;
		}
		// Draw the pixels onto the visible canvas
		c.putImageData ( idata, 0, 0 );

		var radius = 50;
		c.beginPath ( );
		c.arc ( i, i, radius, 0, 2 * Math.PI, false );
		c.fillStyle = 'blue';
		c.fill ( );

		// Start over!
		setTimeout ( draw, 20, v, c, bc, cw, ch );
	}

	function rgb_avg ( r, g, b ) {
		return Math.floor ( ( r + g + b ) / 3 );
	}

	function between ( number, min, max ) {
		return ( number >= min && number <= max );
	}
</script>

<video id="v" controls autoplay loop>
	<source src=ava.webm type=video/webm>
</video>
<canvas id="c"></canvas>

<style>
	#c {
		position: absolute;
		top: 40%;
		left: 27%;
		margin: -180px 0 0 20px;
		width: 800px;
		height: 450px;
		background: url(bg-video.png) 0 0 no-repeat;
	}

	#v {
		visibility: hidden;
		position: absolute;
		top: 50%;
		left: 50%;
		margin: -180px 0 0 -500px;
	}
</style>
