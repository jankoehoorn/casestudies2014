<?php
	//@formatter:off
	$crop_x   = str_replace ( 'px', '', $_POST[ 'rect_img' ][ 'left' ] ) * -1;
	$crop_y   = str_replace ( 'px', '', $_POST[ 'rect_img' ][ 'top' ] ) * -1;
	$crop_w   = $_POST[ 'rect_crop' ][ 'width' ];
	$crop_h   = $_POST[ 'rect_crop' ][ 'height' ];
	$file_in  = $_POST[ 'userfile' ];
	$file_out = str_replace('.jpg','-cropped.jpg',$file_in);
	//@formatter:on

	$Img = new Imagick ( '../images/' . $file_in );
	$Result = clone $Img;
	$Result -> cropImage ( $crop_w, $crop_h, $crop_x, $crop_y );
	$Result -> writeImage ( '../images/' . $file_out );

	echo json_encode ( 'images/' . $file_out . '?' . time ( ) );
?>