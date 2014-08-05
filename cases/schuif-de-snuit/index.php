<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';

	$size = 150;

	// clean up old pieces
	foreach ( glob ( 'piece*.jpg' ) as $piece ) {
		unlink ( $piece );
	}

	$img_src = 'image.jpg';
	$jpg = imagecreatefromjpeg ( $img_src );
	list ( $w, $h ) = getimagesize ( $img_src );

	$rows = $h / $size;
	$cols = $w / $size;

	// text

	for ( $i = 0; $i < $cols; $i++ ) {
		for ( $j = 0; $j < $rows; $j++ ) {
			$piece = imagecreatetruecolor ( $size, $size );
			imagecopyresampled ( $piece, $jpg, 0, 0, ($i * $size), ($j * $size), $size, $size, $size, $size );

			// Number the images to make things a little easier
			$black = imagecolorallocate ( $piece, 0, 0, 0 );
			$white = imagecolorallocate ( $piece, 255, 255, 255 );
			$text = sprintf ( '%02d', 1 + $i + ($j * $cols) );
			$font = '/casestudies2013/cases/schuif-de-snuit/DroidSansMono.ttf';
			imagefilledrectangle ( $piece, 10, 10, 29, 29, $white );
			imagestring ( $piece, 4, 12, 12, $text, $black );

			imagejpeg ( $piece, 'piece' . sprintf ( '%02d', $i ) . '-' . sprintf ( '%02d', $j ) . '.jpg' );
			imagedestroy ( $piece );
		}
	}

	$imgs = glob ( 'piece*.jpg' );
	array_pop ( $imgs );
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

			<div id="game-wrapper">
				<?php
					foreach ( $imgs as $img ) {
						echo '<img id="' . str_replace ( '.jpg', '', $img ) . '" src="' . $img . '"/>';
					}
				?>
				<div id="piece-empty"></div>
			</div>
		</div>
	</body>
</html>
