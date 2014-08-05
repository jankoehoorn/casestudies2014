<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';

	// See http://www.php.net/manual/en/timezones.php
	$datetime_zone = new DateTimeZone ( 'America/Edmonton' );
	$datetime_server = new DateTime;
	$datetime_alberta = new DateTime ( 'now', $datetime_zone );
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

			<?php
				echo '<p>' . $datetime_server -> format ( 'Y-m-d H:i:s' ) . '</p>';
				echo '<p>' . $datetime_alberta -> format ( 'Y-m-d H:i:s' ) . '</p>';

				!d ( $datetime_zone -> listIdentifiers ( ) );
			?>
		</div>
	</body>
</html>