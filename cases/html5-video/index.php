<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';
?>
<!DOCTYPE html>

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
				HTML5 video browser support.
			</p>

			<ul>
				<li>
					<ul>
						<h3>Desktop browsers</h3>
						<li><input type="checkbox" checked="checked" /> Firefox, latest version</li>
						<li><input type="checkbox" checked="checked" /> Chrome, latest version</li>
						<li><input type="checkbox" checked="checked" /> Safari, latest version</li>
						<li><input type="checkbox" checked="checked" /> Internet Explorer 9 (no autostart)</li>
						<li><input type="checkbox" /> Internet Explorer 8 and earlier</li>
					</ul>
				</li>
				<li>
					<ul>
						<h3>Mobile browsers</h3>
						<li><input type="checkbox" checked="checked" /> iOS Chrome, latest version (no autostart)</li>
						<li><input type="checkbox" checked="checked" /> iOS Safari, latest version (no autostart)</li>
					</ul>
				</li>
			</ul>

			<video width="962" height="540" poster="http://www.lorempixel.com/962/540/" loop autostart controls>
				<source src="tpol.webm" type="video/webm" />
				<source src="tpol.mp4" type="video/mp4" />
				<source src="tpol.ogg" type="video/ogg" />
				<p class="err">This browser doesn't support the HTML5 video tag</p>
			</video>

			</video>
		</div>
	</body>
</html>
