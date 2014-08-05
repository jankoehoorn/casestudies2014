<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';
	require_once 'class.template.php';
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
				try {
					$Template = new Template ( 'template.xml' );
					$Template -> setValue ( 'intro', 'id intro should get this value: Triple&nbsp;P' );
					$Template -> setAttribute ( 'intro', 'class', 'class1' );
					$Template -> setAttribute ( 'intro', 'class', 'class2' );
					$Template -> addAttribute ( 'intro', 'class', 'class3' );

					$lis = array (
						'item 01',
						'item 02',
						'item 03',
						'item 04',
					);

					foreach ( $lis as $li ) {
						$Template -> addChild ( 'list', 'li', $li );
					}

					echo $Template;
				}
				catch ( Exception $e ) {
					s ( $e );
				}
			?>
		</div>
	</body>
</html>