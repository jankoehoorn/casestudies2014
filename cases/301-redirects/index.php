<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';

	// Set this to true to generate comments in the htaccess rules
	$with_comments = false;
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
			<h2>301 Redirects for Alberta :: Casestudies :: Jan Koehoorn</h2>

			<?php
				$filename = 'redirects-alberta.csv';
				$fp = fopen ( $filename, 'rb+' );
				$previous_301_url = '';

				echo '<textarea id="htaccess" class="microtext">';

				while ( $row = fgetcsv ( $fp, 4096 ) ) {

					if ( $row[ 1 ] == '-' ) {
						$row[ 1 ] = $previous_301_url;
					}
					else {
						$previous_301_url = $row[ 1 ];
					}

					$uri = str_replace ( 'http://alberta.triplep-staypositive.net/', '', $row[ 0 ] );
					$comment = ($with_comments) ? ('  # ') : ('  ');

					echo PHP_EOL, $comment, 'RewriteCond %{HTTP_HOST} ^alberta.triplep-staypositive.net$ [NC]', PHP_EOL;
					echo $comment, 'RewriteCond %{REQUEST_URI} ^/', $uri, '$', PHP_EOL;
					echo $comment, 'RewriteRule ^(.*)$ ', $row[ 1 ], ' [R=301,L]', PHP_EOL;

				}

				echo '</textarea>';
				fclose ( $fp );
			?>
		</div>
	</body>
</html>
