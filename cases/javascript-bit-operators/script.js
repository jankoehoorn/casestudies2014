
	/**
	 * jQuery
	 * See: http://michalbe.blogspot.nl/2013/03/javascript-less-known-parts-bitwise.html
	 * Tested with 281474976710656 (2^48) so we can surely go to max 48 levels this way
	 */
	var filtermask;
	var $markers;
	
	$ ( 'document' ).ready ( function ( ) {
		$result = $ ( '#result' );
		$getal1 = $ ( '#getal1' );
		$getal2 = $ ( '#getal2' );
		$markers = $ ( '#markers tr' );
	
		$ ( '#calc' ).submit ( function ( e ) {
			e.preventDefault ( );
	
			var getal1 = parseInt ( $getal1.val ( ) );
			var getal2 = parseInt ( $getal2.val ( ) );
			var result = getal1 & getal2;
	
			if ( result ) {
				result += ' (match)';
			}
			else {
				result += ' (no match)';
			}
	
			result += '<br>';
			result += str_pad ( getal1.toString ( 2 ), 8, '0' );
			result += '<br>';
			result += str_pad ( getal2.toString ( 2 ), 8, '0' );
	
			$result.html ( result );
		} );
	
		$ ( '#filters input' ).click ( function ( ) {
			filterTable ( );
		} );
	
		initTable ( );
	} );
	
	function str_pad ( input, width, fill ) {
		fill = fill || '0';
		input = input + '';
	
		return input.length >= width ? input : new Array ( width - input.length + 1 ).join ( fill ) + input;
	}
	
	function initTable ( ) {
		$ ( '#markers tr' ).each ( function ( i, tr ) {
			$ ( tr ).find ( 'td' ).each ( function ( j, td ) {
				var levelmask = parseInt ( $ ( tr ).attr ( 'value' ) );
				var level_on = levelmask & Math.pow ( 2, j );
	
				$ ( td ).addClass ( level_on ? 'on' : 'off' );
			} );
		} );
	}
	
	function filterTable ( ) {
		filtermask = 0;
	
		$ ( '#filters input:checked' ).each ( function ( i, input ) {
			filtermask += parseInt ( $ ( input ).val ( ) );
		} );
	
		$markers.each ( function ( i, child ) {
			var tr = $ ( child );
			var levelmask = parseInt ( tr.attr ( 'value' ) );
	
			if ( filtermask & levelmask ) {
				tr.addClass ( 'on' );
			}
			else {
				tr.removeClass ( 'on' );
			}
		} );
	}