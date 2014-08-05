<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';

	$images = '';
	$titles = '';
	$err = '';
	$num_items = 0;
	$response = array ( );

	if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
		$images = trim ( $_POST[ 'images' ] );
		$titles = trim ( $_POST[ 'titles' ] );

		$response[ 'images' ] = explode ( PHP_EOL, $images );
		$response[ 'titles' ] = explode ( PHP_EOL, $titles );

		if ( count ( $response[ 'images' ] ) != count ( $response[ 'titles' ] ) ) {
			$err = 'Lists are unequal in length!';
		}
		else {
			$num_items = count ( $response[ 'images' ] );
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
				if ( !empty ( $err ) ) {
					echo '<pre class="debug">';
					print_r ( $err );
					echo '</pre>';
				}
			?>

			<form method="post" accept-charset="utf-8" action="">
				<div class="clearer">
					<textarea id="images" name="images"><?php echo $images; ?></textarea>
					<textarea id="titles" name="titles"><?php echo $titles; ?></textarea>
				</div>
				<input type="submit" value="Generate Image Carousel HTML" />
			</form>

			<div id="response">
				<?php
					if ( !empty ( $response ) ) {
						echo '<h2>Response:</h2>';
						echo '<div id="html">';

						for ( $i = 0; $i < $num_items; $i++ ) {
							$thumb = str_replace ( 'large', 'small', $response[ 'images' ][ $i ] );

							$html = '<li class="ad-img-blok-bg">';
							$html .= '<a href="/provider/themes/provider/images/ska-en/image-carousel/' . $response[ 'images' ][ $i ] . '">';
							$html .= '<img src="/provider/themes/provider/images/ska-en/image-carousel/' . $thumb . '" title="' . $response[ 'titles' ][ $i ] . '" alt="" class="image' . $i . '" />';
							$html .= '</a>';
							$html .= '</li>';
							$html .= PHP_EOL;

							echo htmlentities ( $html );
						}

						echo '</div>';
					}
				?>
			</div>
		</div>
	</body>
</html>
