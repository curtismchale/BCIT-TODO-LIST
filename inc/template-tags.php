<?php

/**
 * Returns our form HTML
 *
 * @since 1.0
 * @author ME
 *
 * @param int        $post_id        optional    The id of a post if we want to check it
 * @uses bcit_todo_get_response_section()       Returns response section
 * @return string           $html               Our HTML form
 */
function bcit_todo_get_form_html( $post_id = null ){

	$post_object = isset( $post_id ) ? get_post( absint( $post_id ) ) : '';
	$title = ! empty( $post_object ) ? $post_object->post_title : '';
	$description = ! empty( $post_object ) ? $post_object->post_content : '';

	$html = '<form action="bcit_todo_add_todo_item" id="bcit-todo-form" >';
		$html .= '<p>';
			$html .= '<label for="bcit-todo-item">Task</label>';
			$html .= '<input id="bcit-todo-item" type="text" value="'. esc_attr( $title ) .'" placeholder="Task Name" />';
		$html .= '</p>';

		$html .= '<p>';
			$html .= '<label for="bcit-todo-item-description">Description</label>';
			$html .= '<textarea id="bcit-todo-item-description" placeholder="Task Description">'. esc_textarea( $description ) .'</textarea>';
		$html .= '</p>';

		$html .= '<input type="submit" id="bcit-todo-submit" data-post_id="'. absint( $post_id ) .'" value="Save Task">';
		if ( ! empty( $post_object ) ){
			$html .= '<input type="submit" id="bcit-todo-cancel" value="Cancel" />';
		}

		$html .= bcit_todo_get_response_section();

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
function bcit_todo_get_response_section(){

	$html = '<section id="bcit_ajax_response">';
		$html .= '<img src="'. plugins_url( '/bcit-todo-list/assets/images/spinner.gif' ) .'" class="bcit-todo-ajax-spinner" />';
	$html .= '</section>';

	return $html;

} // get_response_section
