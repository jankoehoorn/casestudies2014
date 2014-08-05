<?php
	$src = (empty ( $_POST[ 'src' ] )) ? ('') : (trim ( $_POST[ 'src' ] ));
	$result = '';

	if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
		$dom = new DOMDocument ( );
		$return = @$dom -> loadHTML ( $_POST[ 'src' ] );

		$downloads = $dom -> getElementsByTagName ( 'a' );

		foreach ( $downloads as $download ) {
			$href = $download -> getAttribute ( 'href' );

			if ( strpos ( $href, 'downloads' ) !== false ) {
				$result .= PHP_EOL;
				$result .= '<h2>' . $download -> nodeValue . '</h2>';
				$result .= '<p>' . $href . '</p>';
			}
		}

	}
?>