<?php
	$dirs = explode ( '/', dirname ( $_SERVER[ 'SCRIPT_NAME' ] ) );
	$title = ucwords ( str_replace ( array (
		'-',
		'_'
	), ' ', array_pop ( $dirs ) ) );
?>