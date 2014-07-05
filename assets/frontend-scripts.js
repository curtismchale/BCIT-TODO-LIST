jQuery(document).ready(function($) {

	$( '#bcit-todo-form' ).submit( function(e){

		e.preventDefault();

		var form        = $( '#bcit-todo-form' );
		var action      = $( form ).attr( 'action' );
		var title       = $( form ).find( '#bcit-todo-item' ).val();
		var description = $( form ).find( '#bcit-todo-item-description' ).val();

		var data = {
			action: action,
			title: title,
			description: description,
			security: BCITTODO.bcit_todo_ajax_nonce
		}

		$.post( BCITTODO.ajaxurl, data, function( response ) {

			if ( response.success === true ) {
				clear_form( form );
			}

			if ( response.success === false ) {

			}

		}); // end AJAX post


	});

	/**
	 * Clears our form for us
	 *
	 * @param object    form        This is the jquery form object passed
	 */
	function clear_form( form ){
		$( form ).find( 'input[type="text"], textarea' ).val( '' );
	}

});
