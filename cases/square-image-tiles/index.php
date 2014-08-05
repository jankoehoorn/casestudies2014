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

			<div id="tiles" class="wrapper outer clearer">

				<span class="tile w80"> <img src="http://lorempixel.com/380/300/sports" /> </span>
				<span class="tile w80"> <img src="http://lorempixel.com/480/300/nightlife" /> </span>
				<span class="tile w80"> <img src="http://lorempixel.com/580/300/fashion" /> </span>
				<span class="tile w80"> <img src="http://lorempixel.com/680/300/animals" /> </span>
				<span class="tile w80"> <img src="http://lorempixel.com/380/800/sports" /> </span>
				<span class="tile w80"> <img src="http://lorempixel.com/480/800/nightlife" /> </span>
				<span class="tile w80"> <img src="http://lorempixel.com/580/800/fashion" /> </span>
				<span class="tile w80"> <img src="http://lorempixel.com/680/800/animals" /> </span>
				<span class="tile w80"> <img src="http://lorempixel.com/680/800/animals" /> </span>

			</div>
		</div>
	</body>
</html>
