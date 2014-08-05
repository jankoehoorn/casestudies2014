<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';
	require_once 'logger.php';

	$video_ids = array (
		'30838667',
		'30895919',
		'30779000',
	);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="vimeo.js"></script>
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
			<h3>Testcase Hyperlinks</h3>
			<p>
				Click the links to see the result logged.
			</p>
			<ul>
				<li>
					<a id="through-navigation-button" class="sis-click" href="http://www.bureaublanco.nl/">Hyperlink #1 to bureaublanco.nl that is tracked by SIS</a>
				</li>
				<li>
					<a id="through-carousel" class="sis-click" href="http://www.bureaublanco.nl/">Hyperlink #2 to bureaublanco.nl that is tracked by SIS</a>
				</li>
				<li>
					<a class="" href="http://www.google.nl/">This hyperlink to Google is not tracked by SIS</a>
				</li>
			</ul>

			<h3>Testcase Hover Time</h3>

			<p>
				Move your mouse in and out to see the result logged.
			</p>

			<div id="hovers">
				<?php
					for ( $i = 1; $i <= 3; $i++ ) {
						echo '
							<div class="hover-container">
							<p>
							Hover tracker #' . $i . '
							</p>
							<div id="tracker-hover-' . $i . '" class="hover-wrapper sis-hover">
							<div class="hover-content">
							<p>
							Lorem ipsum dolor sit amet, consectetur ...
							</p>
							<p>
							Lorem ipsum dolor sit amet, consectetur ...
							</p>
							<p>
							Lorem ipsum dolor sit amet, consectetur ...
							</p>
							<p>
							Lorem ipsum dolor sit amet, consectetur ...
							</p>
							<p>
							Lorem ipsum dolor sit amet, consectetur ...
							</p>
							<p>
							Lorem ipsum dolor sit amet, consectetur ...
							</p>
							</div>
							</div>
							</div>
							';
					}
				?>
				<div class="clearer"></div>
			</div>

			<div id="video-wrapper">
			<?php
				foreach ( $video_ids as $video_id ) {
					echo '
						<div class="vimeo">
							<iframe
							id="video-' . $video_id . '"
							src="http://player.vimeo.com/video/' . $video_id . '/?color=009FDA&api=1&player_id=' . $video_id . '"
							width="320"
							height="180"
							frameborder="0"
							webkitAllowFullScreen
							mozallowfullscreen
							allowFullScreen
							></iframe>
						</div>
						';
				}
			?>
				<div class="clearer"></div>
			</div>

			<h3>AJAX response</h3>
			<p>
				<input id="clear-log" type="button" value="clear log" />
			</p>
			<pre id="response"><?php echo Logger :: read ( ); ?></pre>
		</div>
	</body>
</html>