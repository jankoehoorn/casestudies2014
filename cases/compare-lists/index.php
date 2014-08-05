<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';

	$title = 'Compare Lists';

	$left = (isset ( $_POST[ 'left' ] )) ? (($_POST[ 'left' ])) : ('');
	$right = (isset ( $_POST[ 'right' ] )) ? (($_POST[ 'right' ])) : ('');

	if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

		$newlines = array (
			"\n\r",
			"\n",
			"\r",
		);
		$l = str_replace ( $newlines, '|', $left );
		$r = str_replace ( $newlines, '|', $right );

		$l = strtolower ( str_replace ( ' ', '', $l ) );
		$r = strtolower ( str_replace ( ' ', '', $r ) );

		$a_left = array_unique ( array_filter ( explode ( '|', $l ) ) );
		$a_right = array_unique ( array_filter ( explode ( '|', $r ) ) );

		sort ( $a_left );
		sort ( $a_right );

		$arrays_equal = ($a_left == $a_right);

		$a_both = array_intersect ( $a_left, $a_right );
		$a_left_yes_right_no = array_diff ( $a_left, $a_right );
		$a_left_no_right_yes = array_diff ( $a_right, $a_left );

		$left = implode ( PHP_EOL, $a_left );
		$right = implode ( PHP_EOL, $a_right );
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
				This script performs a check between to lists of values to see if they are equal, regardless of sorting order.
				Written as tool for the Bureau Blanco Vlogging script.
			</p>

			<?php
				if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
					echo '<div class="info">';

					if ( $arrays_equal ) {
						echo '<h2>The two lists are <strong>equal</strong></h2>';
					}
					else {
						echo '<h2>The two lists are <strong>different</strong></h2>';
					}

					echo '</div>';
				}
			?>

			<form method="post" action="">
				<input type="submit" value="compare lists" />
				<div id="cols" class="clearer">
					<div id="col-1">
						<label for="left">In DB:</label>
						<textarea id="left" name="left"><?php echo $left; ?></textarea>
						<?php
							if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
								echo '<div class="info">';
								echo '<h3>Extra in this column:</h3>';
								foreach ( $a_left_yes_right_no as $v ) {
									echo '<p>&quot;';
									echo $v;
									echo '&quot;</p>';
								}
								if ( count ( $a_left_yes_right_no ) == 0 ) {
									echo '<p>zero elements</p>';
								}
								echo '</div>';
							}
						?>
					</div>
					<div id="col-2">
						<label for="right">In Excel:</label>
						<textarea id="right" name="right"><?php echo $right; ?></textarea>
						<?php
							if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
								echo '<div class="info">';
								echo '<h3>Extra in this column:</h3>';
								foreach ( $a_left_no_right_yes as $v ) {
									echo '<p>&quot;';
									echo $v;
									echo '&quot;</p>';
								}
								if ( count ( $a_left_no_right_yes ) == 0 ) {
									echo '<p>zero elements</p>';
								}
								echo '</div>';
							}
						?>
					</div>
				</div>
			</form>
			<?php
				if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
					echo '<div class="info">';
					echo '<h3>Present in both arrays:</h3>';
					foreach ( $a_both as $v ) {
						echo '<p>';
						echo $v;
						echo '</p>';
					}
					if ( count ( $a_both ) == 0 ) {
						echo '<p>zero elements</p>';
					}

					echo '</div>';
				}
			?>
		</div>
	</body>
</html>