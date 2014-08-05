<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';

	$info = pathinfo ( $_SERVER[ 'REQUEST_URI' ] );
	$path = "http://" . $_SERVER[ 'SERVER_NAME' ] . $info[ 'dirname' ];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php echo '<title>' . $title . ' :: Casestudies :: Jan Koehoorn</title>'; ?>
		<?php
			require_once '../../elements/header-required.php';
		?>
		<script type="text/javascript" src="plupload.full.min.js"></script>

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

			<div id="filelist">
				Your browser doesn't have Flash, Silverlight or HTML5 support.
			</div>

			<div id="uploadcontainer">
				<a id="pickfiles" href="javascript:;">[Select files]</a>
				<a id="uploadfiles" href="javascript:;">[Upload files]</a>
			</div>

			<br />
			<pre id="console"></pre>																														

			<div id="images">
				<?php
					$jpgs = glob ( 'images/*.*' );

					if ( is_array ( $jpgs ) ) {
						foreach ( $jpgs as $jpg ) {
							echo '<img src="' . $jpg . '" />';
						}
					}
				?>
			</div>

	</body>
</html>
