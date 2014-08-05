<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';
	require_once '../../helpers/string.php';

	$classes = get_declared_classes ( );
	require_once 'src.php';
	$classnames = array_values ( array_diff ( get_declared_classes ( ), $classes ) );
	sort ( $classnames );
	reset ( $classnames );
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
			<p>
				Generate Classes UML diagram from: <em>src.php</em>
			</p>
			<p>
				Status: work in progress
			</p>
			<?php
				if ( !empty ( $classnames ) ) {
					$classes = array ( );

					echo '<pre>';
					foreach ( $classnames as $classname ) {
						$reflector = new ReflectionClass ( $classname );

						$class = array (
							'name' => $classname,
							'extension' => $reflector -> getExtensionName ( ),
							'interfaces' => $reflector -> getInterfaceNames ( ),
						);
						$classes[ ] = $class;
						// $constants = $reflector -> getConstants ( );
						// $properties = $reflector -> getProperties ( );
						// $methods = $reflector -> getMethods ( );
					}

					print_r ( $classes );
					echo '</pre>';
				}
			?>
		</div>
	</body>
</html>