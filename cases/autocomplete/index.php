<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php echo '<title>' . $title . ' :: Casestudies :: Jan Koehoorn</title>'; ?>
		<?php
			require_once '../../elements/header-required.php';
		?>
		<link rel="stylesheet" type="text/css" media="all" href="jquery-ui-1.10.4.custom.min.css" />
		<script type="text/javascript" src="script.js.php"></script>
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
				<label for="searchfor">Search for:</label>
				<input id="searchfor" name="searchfor" type="text" value="" />

				<label for="employee">Employee:</label>
				<input id="employee" name="employee" type="text" value="" />

				<input type="submit" value="submit" />
			</form>
		</div>
	</body>
</html>
