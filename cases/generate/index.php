<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';

	$doctitle = '';
	$response = '';

	if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
		$doctitle = trim ( $_POST[ 'doctitle' ] );
		$response = preg_replace ( '/[^a-zA-Z0-9 ]/', '', $doctitle );
		$response = ucwords ( $response );
		$response = preg_replace ( '/\s+/', '_', $response );
		$response = date ( 'Ymd' ) . 'JH_IB_' . $response;
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

			<form method="post" accept-charset="utf-8" action="">
				<label for="doctitle">DOC title:</label>
				<input id="doctitle" name="doctitle" type="text" value="<?php echo $doctitle; ?>" class="large" />
				<input type="submit" value="generate" />
			</form>

			<div id="response">
				<?php
					if ( !empty ( $response ) ) {
						echo '<h2>Response:</h2>';
						echo '<p>' . $response . '</p>';
					}
				?>
			</div>
		</div>
	</body>
</html>
