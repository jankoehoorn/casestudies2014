<?php
	class Container {
		protected $params = array ( );
		static protected $shared = array ( );

		public function __construct ( array $params = array() ) {
			$this -> params = $params;
		}

		public function getMailer ( ) {
			if ( isset ( self :: $shared[ 'mailer' ] ) ) {
				return self :: $shared[ 'mailer' ];
			}

			$class = $this -> params[ 'mailer' ];
			$mailer = new $class;

			return self :: $shared[ 'mailer' ] = $mailer;
		}

	}

	class PHPMailer {
		public function __construct ( ) {
		}

		public function send ( ) {

		}

	}

	class SwiftMailer {
		public function __construct ( ) {
		}

	}
?>