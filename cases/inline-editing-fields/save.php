<?php
	if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

		switch( $_POST['id'] ) {

			case 'name':
				echo $_POST[ 'value' ];
				break;

			case 'email':
				echo $_POST[ 'value' ];
				break;

			case 'phone':
				echo $_POST[ 'value' ];
				break;

			case 'month':
				echo $_POST[ 'value' ];
				break;

		}

	}
?>