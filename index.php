<?php
	require_once 'elements/error-checking.php';
	require_once 'elements/ip-blocking.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Casestudies :: Jan Koehoorn</title>

		<?php
			require_once 'elements/header-required.php';
		?>
	</head>

	<body>
		<div id="container">
			<h1>Casestudies :: Jan Koehoorn</h1>
			<h2>Current list for 2014</h2>
			<div id="cases">
				<?php
					require_once 'elements/list-cases.php';
				?>
			</div>
		</div>
	</body>
</html>
