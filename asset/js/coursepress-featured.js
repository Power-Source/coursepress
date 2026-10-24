/*! CoursePress - v2.1.2
 * https://cp-psource.github.io/coursepress/
 * Copyright (c) 2017; * Licensed GPLv2+ */
(function( $ ){
	var navigateSameOrigin = function( url ) {
		var destination;

		try {
			destination = new URL( url, window.location.origin );
		} catch ( error ) {
			console.warn( 'CoursePress could not navigate to the featured course.', error );
			return false;
		}

		if ( destination.origin !== window.location.origin ) {
			console.warn( 'CoursePress prevented navigation to an external featured course.' );
			return false;
		}

		window.location.assign( destination.href );
		return true;
	};

    $( document ).ready( function() {
		$( '.cp_featured_widget_course_link .apply-button.apply-button-details' ).on( 'click', function( e ) {
			var target = e.currentTarget;

			if ( $( target ).attr( 'data-link' ) ) {
				navigateSameOrigin( $( target ).attr( 'data-link' ) );
			}
		} );
    
    } );
})( jQuery );