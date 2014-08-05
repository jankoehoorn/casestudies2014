
	<!-- Webfonts by Google -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic,300,300italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700,700italic,400italic' rel='stylesheet' type='text/css'>
	<!-- reset.css by Eric Meyer -->
	<link rel="stylesheet" type="text/css" media="all" href="/casestudies2014/css/reset.css" />
	<link rel="stylesheet" type="text/css" media="all" href="/casestudies2014/css/stylesheet.css" />
	<link rel="stylesheet" type="text/css" media="all" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
	<?php
		if ( file_exists ( 'stylesheet.css' ) ) {
			echo PHP_EOL;
			echo '		<link rel="stylesheet" type="text/css" media="all" href="stylesheet.css" />';
		}
	?>
	
	<!-- jQuery script hosted from Google API -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<?php
		if ( file_exists ( 'script.js' ) ) {
			echo PHP_EOL;
			echo '		<script type="text/javascript" src="script.js?t=' . time ( ) . '"></script>';
		}
	?>
	
