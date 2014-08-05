<?php
	$filesystemiterator = new FilesystemIterator ( 'cases', FilesystemIterator :: SKIP_DOTS );
	$cases = array ( );

	foreach ( $filesystemiterator as $fileinfo ) {
		$dir = $fileinfo -> getFilename ( );

		if ( $dir != 'boilerplate' ) {
			$text = str_replace ( array (
				'-',
				'-'
			), ' ', $dir );

			$cases[ $dir ] = $text;
		}
	}

	ksort ( $cases );

	echo '<ul>';
	foreach ( $cases as $dir => $text ) {
		echo '<li class="case"><a href="cases/' . $dir . '/">' . $text . '</a></li>';
	}
	echo '</ul>';
?>