<?php
	class TableHelper {
		public $attr = array ( );
		public $cols = array ( );
		public $rows = array ( );
		public $primary_key = 'id';
		public $edit = 'edit';
		public $delete = 'delete';
		

		public function __construct ( array $cols = array (), array $rows = array () ) {
			$this -> cols = $cols;
			$this -> rows = $rows;
		}

		public function printTable ( array $attr = array() ) {
			echo '<table' . $this -> getAttrStr ( $attr ) . '>';
			$this -> printHeader ( );

			foreach ( $this -> rows as $row ) {
				$this -> printRow ( $row );
			}

			echo '</table>';
		}

		public function hasCols ( ) {
			return (count ( $this -> cols ) > 0);
		}

		public function printHeader ( ) {
			echo '<thead>';
			echo '<tr>';
			foreach ( $this -> cols as $col ) {
				echo '
					<th> ' . $col . ' </th>
				';
			}
			echo '</tr>';
			echo '</thead>';
		}

		public function printRow ( $row, $attr = false ) {
			echo '<tr>';
			foreach ( $this -> cols as $col ) {
				if ( $col == $this -> primary_key ) {
					$td = '<a href="edit-' . $row[ $col ] . '">' . $this->edit . '</a>';
				}
				else {
					$td = $row[ $col ];
				}
				echo '
					<td> ' . $td . ' </td>
				';
			}
			echo '</tr>';
		}

		public function getAttrStr ( array $attr = array() ) {
			if ( empty ( $attr ) ) {
				return '';
			}

			$str = '';

			foreach ( $attr as $k => $v ) {
				$str .= ' ' . $k . '="' . $v . '"';
			}

			return $str;
		}

	}
?>