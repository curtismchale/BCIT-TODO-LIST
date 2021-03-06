jQuery(document).ready(function($) {

	$( 'body' ).on( 'submit', '#bcit-todo-form', function(e){

		e.preventDefault();

		var form        = $( this );
		var action      = $( form ).attr( 'action' );
		var title       = $( form ).find( '#bcit-todo-item' ).val();
		var description = $( form ).find( '#bcit-todo-item-description' ).val();
		var post_id     = $( form ).find( '#bcit-todo-submit' ).data('post_id');
		var responsediv = $( form ).find( '#bcit_ajax_response' );
		var spinner     = $( form ).find( '.bcit-todo-ajax-spinner' );

		$(spinner).show();

		var data = {
			action: action,
			title: title,
			description: description,
			post_id: post_id,
			security: BCITTODO.bcit_todo_ajax_nonce
		}

		$.post( BCITTODO.ajaxurl, data, function( response ) {

			$(spinner).hide();

			if ( response.data.success === true ) {
				$( responsediv ).append( '<p class="response-message success">'+response.data.message+'</p>' );
				$( responsediv ).find( '.response-message' ).delay('4000').fadeOut('4000');
				console.log( 'clear' );
				clear_form( form );

				if ( response.data.updated === true ){
					var list_wrapper = $(form).parents('.bcit-single-task');
					var task_wrapper = $(list_wrapper).find( '.task-wrapper' );

					$(task_wrapper).find('.task-title').empty().append( response.data.task_title );
					$(task_wrapper).find('.task-description').empty().append( response.data.task_description );

					$(task_wrapper).show();
					$(form).remove();
				} else {
					$('#bcit-task-list').prepend( response.data.html );
				}
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

		/**
	 * Handling the cancel edit of a form
	 */

	$( 'body' ).on( 'click', '#bcit-todo-cancel', function(e){

		e.preventDefault();

		var list_wrapper = $(this).parents('.bcit-single-task');
		var form_holder  = $(list_wrapper).find('.form-holder');
		var task_wrapper = $(list_wrapper).find( '.task-wrapper' );

		$(form_holder).empty();
		$(task_wrapper).show();

	});
});
