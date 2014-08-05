<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';

	function urlize ( $str ) {
		$regex = '/((http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?)/';
		$replace = '<a href="\1">\1</a>';

		return preg_replace ( $regex, $replace, $str );
	}

	function emailize ( $text ) {
		$regex = '/(\S+@\S+\.\S+)/';
		$replace = '<a href="mailto:$1">$1</a>';

		return preg_replace ( $regex, $replace, $text );
	}

	$src = (isset ( $_POST[ 'src' ] )) ? ( trim ( $_POST[ 'src' ] )) : ('');
	$dst = urlize ( $src );
	$dst = emailize ( $dst );
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

			<form method="post" accept-charset="utf-8" action="">
				<label for="src">Source text:</label>
				<textarea id="src" name="src"><?php echo $src; ?></textarea>
				<label for="dst">Destiny text:</label>
				<textarea id="dst" name="dst"><?php echo $dst; ?></textarea>
				<input type="submit" value="submit" />
			</form>

			<h2>Destiny text as HTML</h2>
			<div>
				<?php
					echo nl2br ( $dst );
				?>
			</div>
		</div>
	</body>
</html>
