$ ( 'document' ).ready ( function ( ) {

	$ ( '#draggable' ).draggable ( );
	$ ( '#resizable' ).resizable ( {
		animate : true
	} );

	$ ( '#crop' ).click ( function ( ) {
		var data = {
			userfile : $ ( '#draggable' ).attr ( 'title' ),
			rect_img : {
				top : $ ( '#draggable' ).css ( 'top' ),
				left : $ ( '#draggable' ).css ( 'left' )
			},
			rect_crop : {
				width : $ ( '#resizable' ).width ( ),
				height : $ ( '#resizable' ).height ( )
			}
		};

		$.ajax ( {
			url : 'ajax/crop.php',
			data : data,
			type : 'POST',
			dataType : 'json',
			success : function ( response ) {
				$ ( '#response' ).html ( '<img src="' + response + '" />' );
			}
		} );

	} );
} );
