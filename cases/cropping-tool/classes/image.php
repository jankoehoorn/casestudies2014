<?php
	Class Image {
		public $extensions = array ( 'jpg' );
		public $name;
		public $type;
		public $tmp_name;
		public $error;
		public $size;
		public $path;

		public function __construct ( ) {
			$this -> name = $_FILES[ 'userfile' ][ 'name' ];
			$this -> type = $_FILES[ 'userfile' ][ 'type' ];
			$this -> tmp_name = $_FILES[ 'userfile' ][ 'tmp_name' ];
			$this -> error = $_FILES[ 'userfile' ][ 'error' ];
			$this -> size = $_FILES[ 'userfile' ][ 'size' ];
			$this -> path = getcwd ( ) . '/images/';
		}

		public function upload ( ) {
			if ( $this -> error == 0 ) {
				if ( is_uploaded_file ( $this -> tmp_name ) ) {
					move_uploaded_file ( $this -> tmp_name, $this -> path . $this -> name );
				}
			}
			else {
				return false;
			}

			return $this -> name;
		}

	}
