<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';

	function cmyk_to_rgb ( $c, $m, $y, $k ) {
		$r = 255 - round ( 2.55 * ($c + $k) );
		$g = 255 - round ( 2.55 * ($m + $k) );
		$b = 255 - round ( 2.55 * ($y + $k) );

		if ( $r < 0 )
			$r = 0;
		if ( $g < 0 )
			$g = 0;
		if ( $b < 0 )
			$b = 0;

		// Return as hexadecimal numbers
		return sprintf ( '%02X%02X%02X', $r, $g, $b );
	}

	function hex_avg ( $a, $b ) {
		$ra = hexdec ( substr ( $a, 0, 2 ) );
		$ga = hexdec ( substr ( $a, 2, 2 ) );
		$ba = hexdec ( substr ( $a, 4, 2 ) );
		$rb = hexdec ( substr ( $b, 0, 2 ) );
		$gb = hexdec ( substr ( $b, 2, 2 ) );
		$bb = hexdec ( substr ( $b, 4, 2 ) );

		$r = round ( ($ra + $rb) / 2 );
		$g = round ( ($ga + $gb) / 2 );
		$b = round ( ($ba + $bb) / 2 );

		// Return as hexadecimal numbers
		return sprintf ( '%02X%02X%02X', $r, $g, $b );
	}

	$colors = array (
		array (
			'cmyk' => array (
				0,
				100,
				0,
				0
			),
			'rgb' => 'E6007E'
		),
		array (
			'cmyk' => array (
				0,
				100,
				100,
				0
			),
			'rgb' => 'DB0812'
		),
		array (
			'cmyk' => array (
				75,
				100,
				0,
				0
			),
			'rgb' => '662483'
		),
		array (
			'cmyk' => array (
				80,
				0,
				100,
				0
			),
			'rgb' => '13A538'
		),
		array (
			'cmyk' => array (
				40,
				0,
				80,
				0
			),
			'rgb' => 'ADCB53'
		),
		array (
			'cmyk' => array (
				100,
				0,
				0,
				0
			),
			'rgb' => '009FE3'
		),
		array (
			'cmyk' => array (
				50,
				0,
				0,
				0
			),
			'rgb' => '83D0F5'
		),
		array (
			'cmyk' => array (
				45,
				0,
				25,
				0
			),
			'rgb' => '98D1CB'
		),
		array (
			'cmyk' => array (
				75,
				0,
				40,
				0
			),
			'rgb' => '00B1AA'
		),
	);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php echo '<title>' . $title . ' :: Casestudies :: Jan Koehoorn</title>'; ?>
		<?php
			require_once '../../elements/header-required.php';
		?>
	</head>

	<body>
		<div id="container">
			<ul id="nav">
				<li>
					<a href="../../">back</a>
				</li>
			</ul>

			<?php echo '<h1>' . $title . '</h1>'; ?>
			<h2>Casestudies :: Jan Koehoorn</h2>

			<table>
				<tr>
					<td>CMYK</td>
					<td>RGB voorgesteld creatie</td>
					<td>RGB gemiddelde</td>
					<td>officiele RGB conversie</td>
				</tr>

				<?php
					foreach ( $colors as $color ) {
						list ( $c, $m, $y, $k ) = $color[ 'cmyk' ];
						$rgb_calculated = cmyk_to_rgb ( $c, $m, $y, $k );
						$rgb_average = hex_avg ( $color[ 'rgb' ], $rgb_calculated );

						echo '<tr>';
						echo '<td>' . implode ( ', ', $color[ 'cmyk' ] ) . '</td>';
						echo '<td style="background: #' . $color[ 'rgb' ] . ';">' . $color[ 'rgb' ] . '</td>';
						echo '<td style="background: #' . $rgb_average . ';">' . $rgb_average . '</td>';
						echo '<td style="background: #' . $rgb_calculated . ';">' . $rgb_calculated . '</td>';
						;
						echo '</tr>';
					}
				?>
			</table>
		</div>
	</body>
</html>
