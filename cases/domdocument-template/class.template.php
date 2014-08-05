<?php
	Class Template {
		public $dom;

		public function __construct ( $xml ) {
			$this -> dom = new DOMDocument ( '1.0', 'utf-8' );
			$this -> dom -> preserveWhiteSpace = false;
			$this -> dom -> validateOnParse = true;
			$this -> dom -> formatOutput = true;
			$this -> dom -> loadXML ( file_get_contents ( $xml ) );
		}

		public function __toString ( ) {
			$html = $this -> dom -> saveHTML ( );
			$html = str_replace ( 'xml:id', 'id', $html );

			return $html;
		}

		public function setAttribute ( $id, $name, $value ) {
			$element = $this -> dom -> getElementById ( $id );
			$element -> setAttribute ( $name, $value );
		}

		public function addAttribute ( $id, $name, $value ) {
			$element = $this -> dom -> getElementById ( $id );
			$attr = $element -> getAttribute ( $name );
			if ( !empty ( $attr ) ) {
				$value = ($attr . ' ' . $value);
			}
			$element -> setAttribute ( $name, $value );
		}

		public function setValue ( $id, $value ) {
			$element = $this -> dom -> getElementById ( $id );
			$element -> nodeValue = $value;
		}

		public function addChild ( $id, $tagname, $value ) {
			$element = $this -> dom -> getElementById ( $id );

			if ( $element == null ) {
				throw new Exception ( 'No element with id: ' . $id );
			}

			$child = $this -> dom -> createElement ( $tagname, $value );
			$element -> appendChild ( $child );
		}

	}
?>