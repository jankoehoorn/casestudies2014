<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php
			require_once '../../elements/header-required.php';
			echo '<title>' . $title . ' :: Casestudies :: Jan Koehoorn</title>';
		?>
		<script src="http://code.createjs.com/createjs-2013.05.14.min.js"></script>
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

			<div id="canvas-layer">
				<canvas id="canv1" width="800" height="600"></canvas>
				<canvas id="canv2" width="800" height="600"></canvas>
				<video id="vid1" width="400" height="300" autoplay="autoplay" loop="loop">
					<source src="tpol.webm" type="video/webm" />
				</video>
			</div>

		</div>
	</body>
</html>
