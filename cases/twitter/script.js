/**
 * jQuery
 */
$ ( 'document' ).ready ( function ( ) {
	$ ( '#twitter-carousel' ).bxSlider ( {
		adaptiveHeight : true,
		auto : true,
		controls : false,
		pager : false,
		pause : 5000
	} );

	$ ( '#twitter-ticker' ).bxSlider ( {
		minSlides : 2,
		maxSlides : 2,
		slideWidth : 400,
		slideMargin : 0,
		ticker : true,
		speed : 250000
	} );
} );
