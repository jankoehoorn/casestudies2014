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
		?>
		<?php echo '<title>' . $title . ' :: Casestudies :: Jan Koehoorn</title>'; ?>
		<script type="text/javascript" src="../../js/plugins/jeditable.min.js"></script>
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

			<div id="form-container">
				<p id="name" name="name" class="edit" title="This is the hint-text for name"></p>
				<p id="email" name="email" class="edit"></p>
				<p id="phone" name="phone" class="edit"></p>
				<p id="biography" name="biography" class="edit-area"></p>
				<p id="month" name="month" class="edit-select"></p>
			</div>
		</div>
	</body>
</html>