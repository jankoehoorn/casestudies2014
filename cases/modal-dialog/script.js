
	/**
	 * jQuery
	 */
	$ ( 'document' ).ready ( function ( ) {
		var dialog = $ ( '#dialog' ).dialog ( {
			autoOpen : false,
			height : 450,
			width : 600,
			modal : true,
			buttons : {
				'Ok' : function ( ) {
					alert ( 'Dialog button Ok was clicked' );
					dialog.dialog ( 'close' );
				}
			}
		} );
	
		$ ( '#dialog-open' ).change ( function ( e ) {
			if ( $ ( this ).val ( ) == 'decline' ) {
				dialog.dialog ( 'open' );
			}
		} );
	} );
