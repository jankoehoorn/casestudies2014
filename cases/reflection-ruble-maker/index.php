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
				Generate Ruby Snippets for Aptana Studio from file: <em>src.php</em>
			</p>
			<?php
				if ( !empty ( $classnames ) ) {
					echo '<textarea>';
					print_r ( "with_defaults :scope => 'source.php' do" . PHP_EOL );

					foreach ( $classnames as $classname ) {
						$reflector = new ReflectionClass ( $classname );

						$properties = $reflector -> getProperties ( );
						sort ( $properties );

						$methods = $reflector -> getMethods ( );
						sort ( $methods );

						print_r ( "\t################################################" . PHP_EOL );
						print_r ( "\t#\tSnippets for Class " . $classname . PHP_EOL );
						print_r ( "\t#\tGenerated on " . date ( 'Y-m-d H:i:s' ) . PHP_EOL );
						print_r ( "\t################################################" . PHP_EOL . PHP_EOL );

						$snippet_trigger_expansion = $classname . ' = new ' . $classname;

						print_r ( "\t" . 'snippet "$' . $snippet_trigger_expansion . '" do |s|' . PHP_EOL );
						print_r ( "\t\t" . 's.trigger = \'$' . $snippet_trigger_expansion . '\'' . PHP_EOL );
						print_r ( "\t\t" . 's.expansion = \'\$' . $snippet_trigger_expansion . ';\'' . PHP_EOL );
						print_r ( "\t" . 'end' . PHP_EOL . PHP_EOL );

						foreach ( $properties as $property ) {
							$propertyname = $property -> getName ( );

							if ( $property -> isStatic ( ) ) {
								$trigger = $classname . ' :: ' . $propertyname;
							}
							else {
								$trigger = '$' . StringHelper :: unCamelCase ( $classname ) . ' -> ' . $propertyname;
							}

							$snippetname = $trigger;
							$snippet = "\t" . 'snippet "' . $snippetname . '" do |s|';
							$expansion = $trigger;
							$expansion = str_replace ( "'", '\'', $expansion );
							$expansion = str_replace ( "$", '\$', $expansion );

							$snippet .= PHP_EOL;
							$snippet .= "\t\t" . 's.trigger = \'' . $trigger . '\'';
							$snippet .= PHP_EOL;
							$snippet .= "\t\t" . 's.expansion = \'' . $expansion . ';\'';
							$snippet .= PHP_EOL;
							$snippet .= "\t" . 'end';
							$snippet .= PHP_EOL;

							print_r ( $snippet );
							echo PHP_EOL;
						}

						foreach ( $methods as $method ) {
							$methodname = $method -> getName ( );

							if ( strpos ( $methodname, '__' ) !== false ) {
								continue;
							}

							if ( $method -> isStatic ( ) ) {
								$trigger = $classname . ' :: ' . $methodname;
							}
							else {
								$trigger = '$' . StringHelper :: unCamelCase ( $classname ) . ' -> ' . $methodname;
							}

							$snippetname = $trigger;
							$snippet = "\t" . 'snippet "' . $snippetname . '" do |s|';
							$expansion = '';

							$params = array ( );
							$i = 1;
							foreach ( $method -> getParameters ( ) as $reflection_parameter_object ) {
								$params[ ] = '${' . $i++ . ':' . $reflection_parameter_object -> name . '}';
							}

							$expansion .= $trigger . ' ( ' . implode ( ', ', $params ) . ' )';
							$expansion = str_replace ( "'", '\'', $expansion );
							$expansion = str_replace ( "$", '\$', $expansion );
							$expansion = str_replace ( '\${', '${', $expansion );

							$snippet .= PHP_EOL;
							$snippet .= "\t\t" . 's.trigger = \'' . $trigger . '\'';
							$snippet .= PHP_EOL;
							$snippet .= "\t\t" . 's.expansion = \'' . $expansion . ';\'';
							$snippet .= PHP_EOL;
							$snippet .= "\t" . 'end';
							$snippet .= PHP_EOL;

							print_r ( $snippet );
							echo PHP_EOL;
						}
					}

					print_r ( "end" );
					echo '</textarea>';
				}
			?>
		</div>
	</body>
</html>