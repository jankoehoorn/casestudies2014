<?php
	require_once '../../elements/error-checking.php';
	require_once '../../elements/ip-blocking.php';
	require_once '../../elements/init.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
		<?php echo '<title>' . $title . ' :: Casestudies :: Jan Koehoorn</title>'; ?>
		<?php
			require_once '../../elements/header-required.php';
		?>
	</head>

	<body>
		<div id="container">
			<ul id="nav">
				<li>
					<a href="../../">back</a>
				</li>
			</ul>

			<?php echo '<h1>' . $title . '</h1>'; ?>

			<div id="search-container" class="wrapper outer">
				<label for="searchfor" class="inline">Search:</label>
				<input id="searchfor" name="searchfor" type="text" value="4068" />
				<input id="search" type="button" value="search" />
				<p style="display:inline;">
					Or, go to an area:
				</p>
				<a id="netherlands" class="pan-to-area">Netherlands</a>
				<a id="saskatchewan" class="pan-to-area">Saskatchewan</a>
				<a id="australia" class="pan-to-area">Australia</a>
				<select id="radius" class="inline small">
					<option value="0"> - radius - </option>
					<option value="10">10 km</option>
					<option value="25">25 km</option>
					<option value="50">50 km</option>
					<option value="100">100 km</option>
					<option value="250">250 km</option>
					<option value="500">500 km</option>
					<option value="1000">1000 km</option>
				</select>
			</div>

			<div id="data">
				<p>
					Latitude, longitude and center data
				</p>

				<label for="sw">South-West:</label>
				<input id="sw" type="text" value="" />

				<label for="ne">North-East:</label>
				<input id="ne" type="text" value="" />

				<label for="center">Center:</label>
				<input id="center" type="text" value="" />

				<label for="mouse">Mouse position (last clicked):</label>
				<input id="mouse" type="text" value="" />

				<label for="zoom">Zoom level:</label>
				<input id="zoom" type="text" value="" />

				<br />
				<input id="toggle" type="checkbox" value="1" checked="checked" />
				<label class="inline" for="toggle">Display KML layer</label>

				<br />
				<br />
				<input type="button" id="set-center-and-zoom" value="Set map to center and zoom values below" />

				<label for="set-lat">Latitude:</label>
				<input id="set-lat" type="text" value="" />

				<label for="set-lng">Longitude:</label>
				<input id="set-lng" type="text" value="" />

				<label for="set-zoom">Zoom level:</label>
				<input id="set-zoom" type="text" value="" />

			</div>

			<div id="map-canvas"></div>

			<div id="csv">
				<?php
					$csvfile = 'csv/us_states.csv';
					$data = array ( );
					if ( $fp = fopen ( $csvfile, 'r' ) ) {
						$dom = new DOMDocument ( '1.0', 'UTF-8' );
						$dom -> formatOutput = true;
						$par_node = $dom -> appendChild ( $dom -> createElementNS ( 'http://earth.google.com/kml/2.2', 'kml' ) );
						$doc_node = $par_node -> appendChild ( $dom -> createElement ( 'Document' ) );

						$style_node = $doc_node -> appendChild ( $dom -> createElement ( 'Style' ) );
						$style_node -> setAttribute ( 'id', 'triple_p_available' );

						$balloonstyle_node = $style_node -> appendChild ( $dom -> createElement ( 'BalloonStyle' ) );
						$balloonstyle_node -> appendChild ( $dom -> createElement ( 'text', '$[description]' ) );

						$linestyle_node = $style_node -> appendChild ( $dom -> createElement ( 'LineStyle' ) );
						$linestyle_node -> appendChild ( $dom -> createElement ( 'width', '0.2' ) );
						$linestyle_node -> appendChild ( $dom -> createElement ( 'color', 'ffffffff' ) );

						$polystyle_node = $style_node -> appendChild ( $dom -> createElement ( 'PolyStyle' ) );
						$polystyle_node -> appendChild ( $dom -> createElement ( 'color', 'ffda7f00' ) );

						while ( $row = fgetcsv ( $fp, 8184 ) ) {
							$polygons = explode ( '|', $row[ 2 ] );
							$placemark_node = $doc_node -> appendChild ( $dom -> createElement ( 'Placemark' ) );
							$name_node = $placemark_node -> appendChild ( $dom -> createElement ( 'name', $row[ 1 ] ) );
							$description_node = $placemark_node -> appendChild ( $dom -> createElement ( 'description' ) );
							$multigeometry_node = $placemark_node -> appendChild ( $dom -> createElement ( 'MultiGeometry' ) );

							foreach ( $polygons as $polygon ) {
								$str_coordinates = '';
								$coordinates = explode ( ' ', $polygon );
								$polygon_node = $multigeometry_node -> appendChild ( $dom -> createElement ( 'Polygon' ) );
								$outerboundaryis_node = $polygon_node -> appendChild ( $dom -> createElement ( 'outerBoundaryIs' ) );
								$linearring_node = $outerboundaryis_node -> appendChild ( $dom -> createElement ( 'LinearRing' ) );

								foreach ( $coordinates as $coordinate ) {
									$str_coordinates .= PHP_EOL . $coordinate . ',0';
								}

								$coordinates = $linearring_node -> appendChild ( $dom -> createElement ( 'coordinates', $str_coordinates ) );
							}
						}

						fclose ( $fp );
						// $bytes_saved = $dom -> save ( $_SERVER[ 'DOCUMENT_ROOT' ] . '/casestudies2013/cases/area-locator-tool/kml/us_states_php_' . time ( ) . '.kml' );
					}
				?>
			</div>
		</div>
	</body>
</html>