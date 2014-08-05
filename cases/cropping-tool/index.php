<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';
	require_once 'classes/image.php';

	$filename = 'orkas.jpg';

	if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
		$Image = new Image ( $_FILES );

		if ( $response = $Image -> upload ( ) ) {
			$filename = $response;
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
		<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css" />
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

			<ul>
				<li>
					Move the image by dragging with your mouse
				</li>
				<li>
					Resize by dragging the right or bottom border, or the corner on the right bottom
				</li>
			</ul>

			<form id="upload" method="post" action="" enctype="multipart/form-data">
				<input type="file" name="userfile" />
				<input class="inline" type="submit" value="upload" />
				<input class="inline" type="button" id="crop" value="crop" />
			</form>

			<h2>Original image</h2>
			<div id="resizable">
				<img id="draggable" src="images/<?php echo $filename; ?>" title="<?php echo $filename; ?>" />
			</div>

			<h2>Cropped image</h2>
			<div id="response"></div>
		</div>
	</body>
</html>
