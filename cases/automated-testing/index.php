<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';

	$required = array (
		'name' => '',
		'email' => '',
	);

	if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
		foreach ( $required as $k => $v ) {
			if ( empty ( $_POST[ $k ] ) ) {
				$required[ $k ] = 'err';
			}

			if ( $k == 'email' ) {
				if ( !filter_var ( $_POST[ $k ], FILTER_VALIDATE_EMAIL ) ) {
					$required[ $k ] = 'err';
				}
			}
		}
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
				<label for="name">Name:</label>
				<input class="<?php echo $required[ 'name' ]; ?>" type="text" id="name" name="name" value="" />

				<label for="email">email:</label>
				<input class="<?php echo $required[ 'email' ]; ?>" type="text" id="email" name="email" value="" />

				<input type="submit" value="submit" />
			</form>
		</div>
	</body>
</html>