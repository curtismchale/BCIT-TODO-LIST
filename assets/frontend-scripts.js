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

			console.log( response );

		});

	});

});
