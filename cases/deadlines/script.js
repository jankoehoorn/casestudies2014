/**
 * jQuery
 */
$ ( 'document' ).ready ( function ( ) {
	var deadline = $ ( '#deadline' );
	var timer = window.setInterval ( function ( ) {
		$.ajax ( {
			url : 'deadline.php',
			dataType : 'text',
			success : function ( response ) {
				deadline.html ( response );
			}
		} );

	}, 1000 );

	$.ajax ( {
		url : 'deadline.php',
		dataType : 'text',
		success : function ( response ) {
			deadline.html ( response );
		}
	} );

} );
