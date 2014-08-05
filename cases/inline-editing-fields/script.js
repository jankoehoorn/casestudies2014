
	/**
	 * jQuery
	 */
	$ ( 'document' ).ready ( function ( ) {
		$ ( '.edit' ).editable ( 'save.php', {
			tooltip : 'Click to edit...',
			onsubmit : function ( obj, elem ) {
				$ ( elem ).addClass ( 'err' );
			}
		} );
	
		$ ( '.edit-area' ).editable ( 'save.php', {
			type : 'textarea',
			tooltip : 'Click to edit...'
		} );
	
		$ ( '.edit-select' ).editable ( 'save.php', {
			loadurl : 'http://www.jankoehoorn.nl/casestudies2013/cases/inline-editing-fields/json.php',
			type : 'select'
		} );
	} );
	
