<?php
	define ( 'IP_ADDRESS_JH', $_SERVER[ 'REMOTE_ADDR' ] == '77.248.64.160' );
	define ( 'IP_ADDRESS_BB', $_SERVER[ 'REMOTE_ADDR' ] == '86.95.17.88' );
	define ( 'IP_ADDRESS_JB', $_SERVER[ 'REMOTE_ADDR' ] == '94.210.125.29' );
	define ( 'IP_ADDRESS_LOCAL', $_SERVER[ 'REMOTE_ADDR' ] == '192.168.0.19' );
	define ( 'LOCALHOST_BB', $_SERVER[ 'HTTP_HOST' ] == 'localhost:8888' );
	define ( 'IP_ADDRESSES_ALL', IP_ADDRESS_BB || IP_ADDRESS_JH || IP_ADDRESS_JB || IP_ADDRESS_LOCAL || LOCALHOST_BB );

	if ( !IP_ADDRESSES_ALL ) {
		echo '<h1 style="font: 14px Monaco; color: #009FDA; text-align: center;">access denied</h1>';
		echo '<pre>';
		print_r ( $_SERVER );
		echo '</pre>';
		exit ( 0 );
	}
?>