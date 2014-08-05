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

			<form>
				<select id="dialog-open">
					<option value="accept">accept</option>
					<option value="decline">decline</option>
					<option value="ignore">ignore</option>
				</select>
			</form>
		</div>

		<div id="dialog">
			<h2>Dialog title</h2>
			<hr />
			<p>
				Dialog content, lorem ipsum dolor sit amet...
			</p>
			<label for="naam">Naam:</label>
			<input type="text" id="naam" name="naam" />
			<label for="email">E-mail:</label>
			<input type="text" id="email" name="email" />
			<label for="body">Body text:</label>
			<textarea id="body" name="body"></textarea>
		</div>
	</body>
</html>
