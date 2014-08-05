$ ( document ).ready ( function ( ) {
	$ ( function ( ) {
		var employees = [ 'Jan', 'Joris', 'Ernst', 'Sanne', 'Saartje', 'Danny', 'John', 'Manuela', 'Lot', 'Eva', 'Liselotte' ];
		$ ( '#employee' ).autocomplete ( {
			source : employees
		} );
	} );
} );
