<?php

	class Formatter {
		public function css ( $input, $wrap = 40, $width = 80 ) {
			// Remove whitespace
			$output = preg_replace ( '/\s+/', ' ', $input );
			// Remove comments
			$output = preg_replace ( '/\/\*.*?\*\//', '', $output );
			// Insert linebreaks
			$output = str_replace ( '{', '##{', $output );
			$output = str_replace ( '}', '}||', $output );
			$lines = array_map ( 'strtoupper', explode ( '||', $output ) );
			$output = '';

			foreach ( $lines as $line ) {
				$output .= $line;
				$output .= PHP_EOL;
			}

			return $output;
		}

	}
?>