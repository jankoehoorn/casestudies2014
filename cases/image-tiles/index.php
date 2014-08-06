<?php
	define ( 'TILE_W', 100 );
	define ( 'TILE_H', 100 );

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

			<?php
				$images = glob ( 'images/*.jpg' );

				foreach ( $images as $image ) {
					$src = imagecreatefromjpeg ( $image );
					$dst = imagecreatetruecolor ( TILE_W, TILE_H );

					list ( $w, $h ) = getimagesize ( $image );

					if ( $w > $h ) {
						imagecopyresampled ( $dst, $src, 0, 0, round ( ($w - $h) / 2 ), 0, TILE_W, TILE_H, $h, $h );
					}
					else {
						imagecopyresampled ( $dst, $src, 0, 0, 0, 0, TILE_W, TILE_H, $w, $w );
					}

					imagejpeg ( $dst, 'tiles/' . basename ( $image ), 100 );
					imagedestroy ( $dst );
				}
			?>

			<h3>Tiles</h3>
			<div id="dst">
				<?php
					$tiles = glob ( 'tiles/*.jpg' );

					foreach ( $tiles as $tile ) {
						echo '<img src="' . $tile . '" />';
					}
				?>
			</div>

			<h3>Original images</h3>
			<div id="src">
				<?php
					foreach ( $images as $image ) {
						echo '<img src="' . $image . '" />';
					}
				?>
			</div>
		</div>
	</body>
</html>
