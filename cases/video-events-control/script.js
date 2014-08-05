/**
 * jQuery
 */

$ ( 'document' ).ready ( function ( ) {
	var video = document.getElementById ( 'vid1' );
	var cur_video = 0;
	var can_click = false;
	var $debug = $ ( '#debug' );

	video.addEventListener ( 'ended', function ( ) {
		can_click = true;
		video.style.cursor = 'pointer';
	}, false );

	video.addEventListener ( 'click', function ( ) {
		if ( can_click ) {
			can_click = false;
			video.style.cursor = 'auto';
			cur_video = play_next_video ( video, cur_video );
		}
		else {
			alert ( 'not yet' );
		}
	}, false );

	$ ( '#play' ).click ( function ( ) {
		can_click = false;
		video.play ( );
	} );

	$ ( '#pause' ).click ( function ( ) {
		video.pause ( );
	} );

} );

function play_next_video ( video, cur_video ) {
	var videos = [ 'ava1.webm', 'ava2.webm', 'ava3.webm', 'ava4.webm' ];

	cur_video++;
	video.src = videos[ cur_video ];
	video.loop = ( cur_video == 3 );
	video.play ( );
	
	return cur_video;
}
