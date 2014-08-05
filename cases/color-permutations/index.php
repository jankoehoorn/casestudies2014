<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';
	require_once 'lib.php';

	$parts = '012';
	$color = (empty ( $_POST[ 'color' ] )) ? ('009FDA') : (trim ( strtoupper ( $_POST[ 'color' ] ) ));
	$permutations = array ( );
	permute ( $parts, 0, 3 );
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
			<h2>Fill in a six-figure color hexcode</h2>
			<form method="post" action="" accept-charset="utf-8">

				<input type="text" id="color" name="color" value="<?php echo $color; ?>" />
				<input type="submit" value="submit" />

			</form>

			<?php
				echo '<table style="width: 800px;">';
				foreach ( $permutations as $p ) {

					$r = $p{0} * 2;
					$g = $p{1} * 2;
					$b = $p{2} * 2;
					$colorstr = '#' . substr ( $color, $r, 2 ) . substr ( $color, $g, 2 ) . substr ( $color, $b, 2 );

					echo '<tr style="height: 36px;">';
					echo '<td style="font: 14px Monaco; color: #999; text-align: right; padding-right: 20px;">';
					echo $colorstr;
					echo '</td>';
					echo '<td style="width: 400px; background: ' . $colorstr . ';">';
					echo '</td>';
					echo '</tr>';
				}
				echo '</table>';
			?>
		</div>
	</body>
</html>
