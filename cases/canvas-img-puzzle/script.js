/**
 * jQuery
 */

var piecepositions = [ 'a1', 'a2', 'a3', 'a4', 'b1', 'b2', 'b3', 'b4', 'c1', 'c2', 'c3', 'c4' ];
var drawpositions = shuffle ( [ 'a1', 'a2', 'a3', 'a4', 'b1', 'b2', 'b3', 'b4', 'c1', 'c2', 'c3' ] );

var positions = {
	a1 : {
		x : 0,
		y : 0
	},
	a2 : {
		x : 150,
		y : 0
	},
	a3 : {
		x : 300,
		y : 0
	},
	a4 : {
		x : 450,
		y : 0
	},
	b1 : {
		x : 0,
		y : 150
	},
	b2 : {
		x : 150,
		y : 150
	},
	b3 : {
		x : 300,
		y : 150
	},
	b4 : {
		x : 450,
		y : 150
	},
	c1 : {
		x : 0,
		y : 300
	},
	c2 : {
		x : 150,
		y : 300
	},
	c3 : {
		x : 300,
		y : 300
	},
	c4 : {
		x : 450,
		y : 300
	}
}
var piece = {
	width : 150,
	height : 150,
	positions : positions
}

$ ( 'document' ).ready ( function ( ) {

	var c1 = document.getElementById ( 'c1' );
	var ctx1 = c1.getContext ( '2d' );

	var c2 = document.createElement ( 'canvas' );
	c2.width = 600;
	c2.height = 450;
	var ctx2 = c2.getContext ( '2d' );

	var img = new Image ( );
	img.src = 'ps20.png';

	img.onload = function ( ) {
		ctx2.drawImage ( img, 0, 0, 600, 450 );
		var iData = ctx2.getImageData ( 0, 0, 600, 450 );
		var data = iData.data;
		var sample = [ ];

		for ( i = 0; i < data.length; i += 4 ) {
			if ( i % 32 == 0 ) {
				sample = [ data[ i + 0 ], data[ i + 1 ], data[ i + 2 ], data[ i + 3 ] ]
			}

			// data [ i + 0 ] = sample [ 0 ];
			// data [ i + 1 ] = sample [ 1 ];
			// data [ i + 2 ] = sample [ 2 ] + 50;
			data[ i + 3 ] = sample[ 3 ] + 50;
		}

		iData.data = data;

		for ( i = 0; i < piecepositions.length; i++ ) {
			drawpiece ( piece.positions[ piecepositions[ i ] ], positions[ drawpositions[ i ] ], ctx1, iData );
		}
	}
} );

function drawpiece ( piece_position, draw_position, ctx, imgdata ) {
	ctx.putImageData ( imgdata, draw_position.x - piece_position.x, draw_position.y - piece_position.y, piece_position.x, piece_position.y, piece.width, piece.height );
}

function shuffle ( array ) {
	var currentIndex = array.length, temporaryValue, randomIndex;

	// While there remain elements to shuffle...
	while ( 0 !== currentIndex ) {

		// Pick a remaining element...
		randomIndex = Math.floor ( Math.random ( ) * currentIndex );
		currentIndex -= 1;

		// And swap it with the current element.
		temporaryValue = array[ currentIndex ];
		array[ currentIndex ] = array[ randomIndex ];
		array[ randomIndex ] = temporaryValue;
	}

	return array;
}