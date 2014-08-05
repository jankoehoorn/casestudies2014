
	/**
	 * jQuery
	 */
	$ ( 'document' ).ready ( function ( ) {
		stage = new createjs.Stage ( 'canv1' );
		circle = new createjs.Shape ( );
	
		circle.graphics.beginFill ( 'red' ).drawCircle ( 0, 0, 140 );
		circle.x = stage.canvas.width / 2;
		circle.y = stage.canvas.height / 2;
	
		stage.addChild ( circle );
		stage.update ( );
	
		createjs.Ticker.addEventListener ( 'tick', handle_tick );
	
		function handle_tick ( ) {
			circle.x += 2;
	
			if ( circle.x > stage.canvas.width ) {
				circle.x = 0;
			}
	
			stage.update ( );
		}
	
	} );
