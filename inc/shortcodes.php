<?php

class BCIT_TODO_Shortcodes{

	function __construct(){

		add_shortcode( 'bcit_todo_add_item_form', array( $this, 'add_item_form' ) );

	} // __construct

	/**
	 * This gives us the form for adding TODO items
	 */
	public function add_item_form(){

		$html = '';

		if ( current_user_can( 'create_todo_list' ) || current_user_can( 'update_todo_list' ) ){

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
	 * @author ME
	 *
	 * @return string           $html           Our HTML form
	 */
	private function get_form_html(){

		$html = '<form action="bcit_todo_add_todo_item" id="bcit-todo-form" >';
			$html .= '<p>';
				$html .= '<label for="bcit-todo-item">Task</label>';
				$html .= '<input id="bcit-todo-item" name="bcit-todo-item" type="text" placeholder="Task Name" />';
			$html .= '</p>';

			$html .= '<p>';
				$html .= '<label for="bcit-todo-item-description">Description</label>';
				$html .= '<textarea id="bcit-todo-item-description" name="bcit-todo-item-description" placeholder="Task Description"></textarea>';
			$html .= '</p>';

			$html .= '<input type="submit" id="bcit-todo-submit" value="Save Task">';

			$html .= $this->get_response_section();

		$html .= '</form>';

		return $html;

	}

	/**
	 * Returns a response section
	 *
	 * @since 1.0
	 * @author ME
	 *
	 * @uses plugins_url()                      returns URL to plugins directory
	 * @return string                           Returns HTML for our response section
	 */
	private function get_response_section(){

		$html = '<section id="bcit_ajax_response">';
			$html .= '<img src="'. plugins_url( '/bcit-todo-list/assets/images/spinner.gif' ) .'" class="bcit-todo-ajax-spinner" />';
		$html .= '</section>';

		return $html;

	} // get_response_section

} // BCIT_TODO_Shortcodes

new BCIT_TODO_Shortcodes();
