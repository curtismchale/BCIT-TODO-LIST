jQuery(document).ready(function($) {

	$( '#bcit-todo-form' ).submit( function( e ){

		e.preventDefault();

		var form        = $( '#bcit-todo-form' );
		var action      = $( form ).attr( 'action' );
		var title       = $( form ).find( '#bcit-todo-item' ).val();
		var description = $( form ).find( '#bcit-todo-item-description' ).val();
		var responsediv = $( form ).find( '#bcit_ajax_response' );
		var spinner     = $( form ).find( '.bcit-todo-ajax-spinner' );

		$( spinner ).show();

		var data = {
			action: action,
			title: title,
			description: description,
			security: BCITTODO.bcit_todo_ajax_nonce
		}

		$.post( BCITTODO.ajaxurl, data, function( response ){

			$( spinner ).hide();

			if ( response.data.success === true ){
				$( responsediv ).append( '<p class="response-message success">'+response.data.message+'</p>' );
				$( responsediv ).find( '.response-message' ).delay( '4000' ).fadeOut( '4000' );
				clear_form( form );
			} // if success true

			if ( response.data.success === false ){
				$( responsediv ).append( '<p class="response-message error">'+response.data.message+'</p>' );
				$( responsediv ).find( '.response-message' ).delay( '4000' ).fadeOut( '4000' );
			} // if sucess false
		});

	});

	/**
	 * Clears our form for us
	 *
	 * @since 1.0
	 * @author ME
	 *
	 * @param object  form      required        jquery form object
	 */
	function clear_form( form ){
		$( form ).find( 'input[type="text"], textarea' ).val( '' );
	} // clear_form


	/**
	 * Getting our edit form for todo tasks
	 */
	$( '.bcit-button.edit' ).click( function(e){

		e.preventDefault();

		var button       = $(this);
		var post_id      = $(button).attr('href');
		var list_wrapper = $(button).parents('.bcit-single-task');
		var spinner      = $(list_wrapper).find('.bcit-todo-ajax-spinner');
		var form_holder  = $(list_wrapper).find('.form-holder');
		var task_wrapper = $(list_wrapper).find( '.task-wrapper' );

		$(spinner).show();

		var data = {
			action: 'bcit_todo_edit_form',
			post_id: post_id,
			security: BCITTODO.bcit_todo_ajax_nonce
		}

		$.post( BCITTODO.ajaxurl, data, function( response ) {

			$(spinner).hide();

			if ( response.data.success === true ) {
				$( task_wrapper ).hide();
				$( list_wrapper ).find(form_holder).empty().append( response.data.message );
			}

			if ( response.data.success === false ) {
				$( list_wrapper ).append( '<p class="error response-message">'+response.data.message+'</p>' );
				$( responsediv ).find( '.response-message' ).delay('4000').fadeOut('4000').remove();
			}

		});

	});
});
