<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';
	require_once 'table-helper.class.php';

	define ( 'KB', 1024 );

	$data = array ( );
	$fp = fopen ( 'data.csv', 'r' );
	$first_row = array_values ( fgetcsv ( $fp, KB, ',' ) );
	while ( $next_row = fgetcsv ( $fp, KB, ',' ) ) {
		$data[ ] = array_combine ( $first_row, $next_row );
	}
	fclose ( $fp );

	$table = new TableHelper ( $first_row, $data );
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
				$table -> printTable ( array ( 'class' => 'my_table_class' ) );
			?>
		</div>
	</body>
</html>
