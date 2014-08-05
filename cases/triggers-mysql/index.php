<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';

	$tablename  = (isset ( $_POST[ 'tablename' ] )) ? (trim ( $_POST[ 'tablename' ] )) : ('');
	$sql_create = '';
	$sql_update = '';

	if ( !empty ( $tablename ) ) {
		$sql_create = "
			DELIMITER |
			CREATE TRIGGER " . $tablename . "_created BEFORE INSERT ON " . $tablename . "
			FOR EACH ROW
			BEGIN
			SET new.doc := NOW();
			SET new.dlm := NOW();
			END;
			|
			DELIMITER ;			
			";

		$sql_update = "
			DELIMITER |
			CREATE TRIGGER " . $tablename . "_updated BEFORE UPDATE ON " . $tablename . "
			FOR EACH ROW
			BEGIN
			SET new.dlm := NOW();
			END;
			|
			DELIMITER ;			
			";
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

			<p>
				Fill in the tablename for which to create INSERT and UPDATE triggers:
			</p>

			<form method="post" action="" accept-charset="utf-8">
				<label for="tablename">Table name:</label>
				<input id="tablename" name="tablename" type="text" value="<?php echo $tablename; ?>" />
				<input type="submit" value="verzenden" />

				<?php
					echo '<h2>Click the labels to select the textarea\'s content.</h2>';
					echo '<label for="create">Create trigger statement:</label>';
					echo '<textarea id="create">';
					print_r ( str_replace ( "\t", '', $sql_create ) );
					echo '</textarea>';
					echo '<label for="update">Update trigger statement:</label>';
					echo '<textarea id="update">';
					print_r ( str_replace ( "\t", '', $sql_update ) );
					echo '</textarea>';
				?>
			</form>
		</div>
	</body>
</html>