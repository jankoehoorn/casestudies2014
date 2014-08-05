<?php
	error_reporting ( E_ALL | E_STRICT );

	$now = new DateTime ( );
	$deadlines = array (
		'Verjaardag Jan' => new DateTime ( '2014-05-11 13:20:00' ),
		'Verjaardag Claudia' => new DateTime ( '2014-07-13 13:20:00' ),
	);

	foreach ( $deadlines as $title => $deadline ) {
		$diff = $now -> diff ( $deadline );

		echo '<div class="deadline">';
		echo '<h2>' . $title . ': ' . $deadline -> format ( 'Y-m-d H:i:s' ) . '</h2>';
		echo '<ul>';
		echo '<li>' . $diff -> format ( '%m' ) . ' maanden</li>';
		echo '<li>' . $diff -> format ( '%d' ) . ' dagen</li>';
		echo '<li>' . $diff -> format ( '%h' ) . ' uren</li>';
		echo '<li>' . $diff -> format ( '%i' ) . ' minuten</li>';
		echo '</ul>';
		echo '</div>';
	}
?>