jQuery(document).ready(function($) {

	$( '#bcit-todo-form' ).submit( function(e){

		e.preventDefault();

		var form        = $( '#bcit-todo-form' );
		var action      = $( form ).attr( 'action' );
		var title       = $( form ).find( '#bcit-todo-item' ).val();
		var description = $( form ).find( '#bcit-todo-item-description' ).val();
		var responsediv = $( form ).find( '#bcit_ajax_response' );
		var spinner     = $( form ).find( '.bcit-todo-ajax-spinner' );

		$(spinner).show();

		var data = {
			action: action,
			title: title,
			description: description,
			security: BCITTODO.bcit_todo_ajax_nonce
		}

		$.post( BCITTODO.ajaxurl, data, function( response ) {

			$(spinner).hide();

			if ( response.data.success === true ) {
				$( responsediv ).append( '<p class="response-message success">'+response.data.message+'</p>' );
				$( responsediv ).find( '.response-message' ).delay('4000').fadeOut('4000');
				clear_form( form );
			}

			if ( response.data.success === false ) {
				$( responsediv ).append( '<p class="error response-message">'+response.data.message+'</p>' );
				$( responsediv ).find( '.response-message' ).delay('4000').fadeOut('4000');
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

	/**
	 * Getting our edit form for todo tasks
	 */
	$( '.bcit-button.edit' ).click( function(e){

		e.preventDefault();

		var button       = $(this);
		var post_id      = $(this).attr('href');
		var list_wrapper = $(this).parent('.bcit-single-task');
		var spinner      = $(list_wrapper).find('.bcit-todo-ajax-spinner');

		$(spinner).show();

		var data = {
			action: 'bcit_todo_edit_form',
			post_id: post_id,
			security: BCITTODO.bcit_todo_ajax_nonce
		}

		$.post( BCITTODO.ajaxurl, data, function( response ) {

			$(spinner).hide();

			if ( response.data.success === true ) {
				$( list_wrapper ).empty().append( response.data.html );
			}

			if ( response.data.success === false ) {
				$( list_wrapper ).append( '<p class="error response-message">'+response.data.message+'</p>' );
				$( responsediv ).find( '.response-message' ).delay('4000').fadeOut('4000').remove();
			}

		});

	});

});
