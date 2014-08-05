<?php
	$spl = new SplFileObject ( 'plaatsen-postcodes.csv' );
	$spl -> setFlags ( SplFileObject :: READ_CSV );

	header ( 'Content-type: application/javascript' );

	echo "
	$ ( document ).ready ( function ( ) {
		$(function() {
		var availableTags = [
	";
	
	foreach ($spl as $item) {
		echo PHP_EOL;
		echo '"' . $item[0] . '",';	
	}

	echo "
		];
			$( '#searchfor' ).autocomplete({
				source: availableTags
			});
		});
	}); 	
	";	
?>