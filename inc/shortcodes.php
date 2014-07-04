<?php

class BCIT_TODO_shortcodes{

	function __construct(){

		add_shortcode( 'bcit_todo_add_item_form', array( $this, 'add_item_form' ) );

	} // __construct

	public function add_item_form(){

		if ( current_user_can( 'create_todo_list' ) || current_user_can( 'edit_todo_list' ) ) {

			$html = 'something';

		} // if current_user_can

		return $html;

	} // add_item_form

} // BCIT_TODO_shortcodes

new BCIT_TODO_shortcodes();
