<?php
	error_reporting ( E_ALL | E_STRICT );

	$factor = 30;
	$now = new DateTime ( );
	$deadlines = array (
		'Groups' => new DateTime ( '2014-07-30 17:30:00' ),
		'Store Locator 2.0' => new DateTime ( '2014-06-24 17:30:00' ),
		'Vakantie JB' => new DateTime ( '2014-07-03 17:30:00' ),
	);

	foreach ( $deadlines as $title => $deadline ) {
		$diff = $now -> diff ( $deadline );
		$m = $diff -> format ( '%m' );
		$d = $diff -> format ( '%d' );
		$h = $diff -> format ( '%h' );
		$i = $diff -> format ( '%i' );
		$s = $diff -> format ( '%s' );

		$s_w = $factor * $s;
		$i_w = $factor * $i;
		$h_w = $factor * $h;
		$d_w = $factor * $d;
		$m_w = $factor * $m;

		echo '<div class="deadline">';
		echo '<h2>' . $title . ': ' . $deadline -> format ( 'Y-m-d H:i:s' ) . '</h2>';

		if ( $m > 0 ) {
			echo '<div class="padding rounded month" style="width: ' . $m_w . 'px;">' . $m . ' maanden</div>';
		}

		if ( !($m == 0 && $d == 0) ) {
			echo '<div class="padding rounded day" style="width: ' . $d_w . 'px">' . $d . ' dagen</div>';
		}

		if ( $h == 0 ) {
			echo '<div class="padding rounded hour zero" style="width: 100px">' . $h . ' uur</div>';
		}
		else {
			echo '<div class="padding rounded hour" style="width: ' . $h_w . 'px">' . $h . ' uur</div>';
		}

		if ( $i == 0 ) {
			echo '<div class="padding rounded minute zero" style="width: 100px">' . $i . ' minuten</div>';
		}
		else {
			echo '<div class="padding rounded minute" style="width: ' . $i_w . 'px">' . $i . ' minuten</div>';
		}

		if ( $s > 0 ) {
			if ( $s == 1 ) {
				echo '<div class="padding rounded second" style="width: ' . $s_w . 'px">' . $s . ' sec</div>';
			}
			else {
				echo '<div class="padding rounded second" style="width: ' . $s_w . 'px">' . $s . ' seconden</div>';
			}
		}

		echo '</div>';
	}
?>