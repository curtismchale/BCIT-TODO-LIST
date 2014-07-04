<?php

class BCIT_TODO_shortcodes{

	function __construct(){

		add_shortcode( 'bcit_todo_add_item_form', array( $this, 'add_item_form' ) );

	} // __construct

	public function add_item_form(){

		$html = '';

		if ( current_user_can( 'create_todo_list' ) || current_user_can( 'edit_todo_list' ) ) {

			$html .= $this->get_form_html();

		} else {
			$html .= 'Sorry you are not allowed to add todo items';
		}

		return $html;

	} // add_item_form

	private function get_form_html(){

		$html = 'this will be our form';

		return $html;

	} // get_form_html

} // BCIT_TODO_shortcodes

new BCIT_TODO_shortcodes();
