<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
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
			<div id="levels">
				<input type="checkbox" id="level1" name="levels" checked="checked" value="0" />
				<label for="level1" class="inline">level 1</label>
				<input type="checkbox" id="level2" name="levels" checked="checked" value="1" />
				<label for="level2" class="inline">level 2</label>
				<input type="checkbox" id="level3" name="levels" checked="checked" value="2" />
				<label for="level3" class="inline">level 3</label>
			</div>
			<div id="map-canvas"></div>
		</div>
	</body>
</html>
