<?php
	// function to generate and print all N! permutations of $str. (N = strlen($str)).
	function permute ( $str, $i, $n ) {
		global $permutations;
		if ( $i == $n )
			$permutations[ ] = $str;
		else {
			for ( $j = $i; $j < $n; $j++ ) {
				swap ( $str, $i, $j );
				permute ( $str, $i + 1, $n );
				swap ( $str, $i, $j );
			}
		}
	}

	// function to swap the char at pos $i and $j of $str.
	function swap ( &$str, $i, $j ) {
		$temp = $str[ $i ];
		$str[ $i ] = $str[ $j ];
		$str[ $j ] = $temp;
	}
?>