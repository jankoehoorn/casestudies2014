<?php
	Class FormHelper {
		public static function coalesce ( ) {
			foreach ( func_get_args( ) as $arg ) {
				if ( !empty ( $arg ) ) {
					return $arg;
				}
			}

			return false;
		}

		public static function post ( $key ) {
			if ( isset ( $_POST[ $key ] ) ) {
				return (trim ( $_POST[ $key ] ));
			}

			return ('');
		}

	}
?>