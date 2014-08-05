<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';

	$num_levels = 8;
	$num_markers = 1024;
	$markers = array ( );
	$str_th = '';

	for ( $i = 0; $i < $num_markers; $i++ ) {
		$markers[ $i ] = mt_rand ( 1, pow ( 2, $num_levels ) - 1 );
	}
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

			<p>
				This checks two decimal number with the bitwise AND operator &. The binairy representation is shown in the red outcome field.
			</p>

			<div id="result"></div>

			<h2>Bit calculation memo</h2>
			<p><img src="bit-memo.png" />
			</p>

			<form id="calc" method="post" action="">
				<label for="getal1">Getal 1:</label>
				<input id="getal1" name="getal1" type="text" value="" />

				<label for="getal2">Getal 2:</label>
				<input id="getal2" name="getal2" type="text" value="" />

				<input type="submit" value="submit" />

				<fieldset id="filters">
					<legend>
						Filters
					</legend>

					<?php
						for ( $i = 0; $i < $num_levels; $i++ ) {
							$level_nr = $i + 1;
							$level_mask = pow ( 2, $i );
							$str_th .= '<th>Level ' . $level_nr . '</th>';

							echo '
<span>
<input type="checkbox" value="' . $level_mask . '" />
<label class="inline">level ' . $level_nr . '</label>
</span>
';
						}
					?>
				</fieldset>

			</form>

			<table id="markers">
				<?php
					echo '<tr>' . $str_th . '</tr>';

					foreach ( $markers as $levelmask ) {
						echo '
<tr value="' . $levelmask . '">
' . str_repeat ( '<td></td>', $num_levels ) . '
</tr>
';
					}
				?>
			</table>

		</div>
	</body>
</html>
