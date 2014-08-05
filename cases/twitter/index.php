<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';

	require_once 'twitter.php';
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

			<div class="wrapper">
				<div id="twitter-carousel">
					<?php
						foreach ( $twitter_data as $tweet ) {
							$datetime = date ( 'Y-m-d H:i', strtotime ( $tweet -> created_at ) );
							$img_profile = $tweet -> user -> profile_image_url;

							echo PHP_EOL;
							echo '<div class="twitter-item">';
							echo '<p class="user"><img src="' . $img_profile . '" /></p>';
							echo '<p class="datetime">' . $datetime . '</p>';
							echo '<p class="text">' . $tweet -> text . '</p>';
							echo '</div>';
							echo PHP_EOL;
						}
					?>
				</div>
			</div>

			<div class="wrapper">
				<div id="twitter-ticker">
					<?php
						foreach ( $twitter_data as $tweet ) {
							$datetime = date ( 'Y-m-d H:i', strtotime ( $tweet -> created_at ) );
							$img_profile = $tweet -> user -> profile_image_url;

							echo PHP_EOL;
							echo '<div class="twitter-item">';
							echo '<p class="user"><img src="' . $img_profile . '" /></p>';
							echo '<p class="datetime">' . $datetime . '</p>';
							echo '<p class="text">' . $tweet -> text . '</p>';
							echo '</div>';
							echo PHP_EOL;
						}
					?>
				</div>
			</div>

			<?php
				!d ( $twitter_data[ 0 ] );
			?>
		</div>

		<!-- START SECTION: JAVASCRIPT INCLUDES -->
		<script type="text/javascript" src="../../js/plugins/bxslider/jquery.bxslider.min.js"></script>
		<!-- END SECTION: JAVASCRIPT INCLUDES -->

	</body>
</html>