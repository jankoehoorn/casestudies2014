<?php
	require_once 'logger.php';

	switch ($_GET['action']) {
		case 'append-log-track-click':
			$line = PHP_EOL;
			$line .= 'Hyperlink ID: ' . $_GET[ 'link_id' ];
			$line .= PHP_EOL;
			$line .= 'Hyperlink href: ' . $_GET[ 'link_href' ];
			$line .= PHP_EOL;
			$line .= 'Page url: ' . $_GET[ 'page_url' ];

			Logger :: log ( $line );
			echo Logger :: read ( );
			break;

		case 'append-log-track-hovertime':
			$line = PHP_EOL;
			$line .= 'Hyperlink ID: ' . $_GET[ 'link_id' ];
			$line .= PHP_EOL;
			$line .= 'Hover time in seconds: ' . $_GET[ 'hovertime' ];

			Logger :: log ( $line );
			echo Logger :: read ( );
			break;

		case 'append-log-track-video-play':
			$line = PHP_EOL;
			$line .= 'Started playing Video ID: ' . $_GET[ 'video_id' ];

			Logger :: log ( $line );
			echo Logger :: read ( );
			break;

		case 'append-log-track-video-paused':
			$line = PHP_EOL;
			$line .= 'Paused Video ID: ' . $_GET[ 'video_id' ];

			Logger :: log ( $line );
			echo Logger :: read ( );
			break;

		case 'append-log-track-video-finished':
			$line = PHP_EOL;
			$line .= 'Finished playing video ID: ' . $_GET[ 'video_id' ];

			Logger :: log ( $line );
			echo Logger :: read ( );
			break;

		case 'clear-log':
			Logger :: clear ( );
			break;
	}
?>