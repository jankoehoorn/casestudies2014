<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';

	$search_plain = array (
		PHP_EOL,
		'’',
		'–',
		'  ',
	);
	$replace_plain = array (
		PHP_EOL . PHP_EOL,
		'\'',
		'-',
		' ',
	);
	$search_html = array (
		PHP_EOL,
		'’',
		'–',
		'Triple P',
		'  ',
	);
	$replace_html = array (
		PHP_EOL . PHP_EOL,
		'\'',
		'&ndash;',
		'Triple&nbsp;P',
		' ',
	);

	$src = (isset ( $_POST[ 'src' ] )) ? ($_POST[ 'src' ]) : ('');
	$text_w = (isset ( $_POST[ 'text_w' ] )) ? ($_POST[ 'text_w' ]) : ('60');

	$dst_plain = trim ( $src );
	$dst_plain = str_replace ( $search_plain, $replace_plain, $dst_plain );
	$dst_plain = wordwrap ( $dst_plain, $text_w, PHP_EOL );

	$dst_html = trim ( $src );
	$dst_html = str_replace ( $search_html, $replace_html, $dst_html );
	$dst_html = htmlentities ( $dst_html, ENT_QUOTES, 'UTF-8' );
	$dst_html = wordwrap ( $dst_html, $text_w, PHP_EOL );
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

			<form method="post" accept-charset="UTF-8" action="">
				<fieldset>
					<input type="submit" value="format text" />
					<label for="width" style="display: inline;">text width in characters:</label>
					<input type="text" id="text_w" name="text_w" value="<?php echo $text_w; ?>" />
					<label for="src">source text:</label>
					<textarea id="src" name="src"><?php echo $src; ?></textarea>
					<label for="dst_plain">destiny plain text:</label>
					<textarea id="dst_plain" name="dst_plain"><?php echo $dst_plain; ?></textarea>
					<label for="dst_html">destiny HTML text:</label>
					<textarea id="dst_html" name="dst_html"><?php echo $dst_html; ?></textarea>
				</fieldset>
			</form>
		</div>
	</body>
</html>
