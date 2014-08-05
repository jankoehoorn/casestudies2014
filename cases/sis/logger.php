<?php
	class Logger {
		private static $logfile = 'log.txt';

		public static function log ( $string ) {
			if ( $fp = fopen ( self :: $logfile, 'a' ) ) {
				$datetime = '[ ' . strftime ( '%F %T' ) . ' ] ';
				$line = $datetime . $string . PHP_EOL . PHP_EOL;

				if ( !fwrite ( $fp, $line, strlen ( $line ) ) ) {
					$err = 'Couldn\'t write to ' . self :: $logfile;
				}

				fclose ( $fp );
			}
			else {
				$err = 'Couldn\'t open ' . self :: $logfile;
			}
		}

		public static function read ( ) {
			return file_get_contents ( self :: $logfile );
		}

		public static function clear ( ) {
			echo __METHOD__;
			if ( $fp = fopen ( self :: $logfile, 'w' ) ) {
				if ( !fwrite ( $fp, '', 0 ) ) {
					$err = 'Couldn\'t write to ' . self :: $logfile;
				}

				fclose ( $fp );
			}
			else {
				$err = 'Couldn\'t open ' . self :: $logfile;
			}
		}

	}
?>