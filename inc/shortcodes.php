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

	/**
	 * Returns our form HTML
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis McHale
	 *
	 * @return string       $html           Our HTML form
	 */
	private function get_form_html(){

		$html = '<form action="bcit_todo_add_todo_item" id="bcit-todo-form" >';
			$html .= '<p>';
				$html .= '<label for="bcit-todo-item">Task</label>';
				$html .= '<input id="bcit-todo-item" type="text" placeholder="Task Name" />';
			$html .= '</p>';

			$html .= '<p>';
				$html .= '<label for="bcit-todo-item-description">Description</label>';
				$html .= '<textarea id="bcit-todo-item-description" placeholder="Task Description"></textarea>';
			$html .= '</p>';

			$html .= '<input type="submit" id="bcit-todo-submit" value="Save Task">';

			$html .= $this->get_response_section();

		$html .= '</form>';

		return $html;

	} // get_form_html

	/**
	 * Returns our AJAX response HTML
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis McHale
	 *
	 * @uses plugins_url()          Returns  the HTTP path for the plugin folder
	 * @return string               HTML for our response area
	 */
	private function get_response_section(){

		$html = '<section id="bcit_ajax_response">';
			$html .= '<img src="'. plugins_url( '/bcit-todo-list/assets/images/spinner.gif' ).'" class="bcit-todo-ajax-spinner" />';
		$html .= '</section>';

		return $html;

	} // get_response_section

} // BCIT_TODO_shortcodes

new BCIT_TODO_shortcodes();
