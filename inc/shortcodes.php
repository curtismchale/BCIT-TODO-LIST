<?php

class BCIT_TODO_shortcodes{

	function __construct(){

		add_shortcode( 'bcit_todo_add_item_form', array( $this, 'add_item_form' ) );

	} // __construct

	/**
	 * This gives us the form for adding TODO items
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis McHale
	 *
	 * @uses current_user_can()             Returns true if the current user has specified caps
	 * @uses $this->get_form_html()         Returns the HTML we want for our TODO list form
	 * @return string       $html           Our form HTML
	 */
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
