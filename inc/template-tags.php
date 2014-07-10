<?php

/**
 * Returns our form HTML
 *
 * @since 1.0
 * @author SFNdesign, Curtis McHale
 *
 * @param int       $post_id        optional    If we're editing a task need to set the post_id
 * @uses bcit_todo_get_response_section()       Returns the seciton that we use for our ajax responses
 * @return string       $html                   Our HTML form
 */
function bcit_todo_get_html_form( $post_id = NULL ){

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
function bcit_todo_get_response_section(){

	$html = '<section id="bcit_ajax_response">';
		$html .= '<img src="'. plugins_url( '/bcit-todo-list/assets/images/spinner.gif' ).'" class="bcit-todo-ajax-spinner" />';
	$html .= '</section>';

	return $html;

} // get_response_section

/**
 * Returns the HTML for our single task
 *
 * @since 1.0
 * @author SFNdesign, Curtis McHale
 *
 * @param object        $task           required            Post Object
 * @uses esc_attr()                                         Making sure our title is safe
 * @uses wp_kses_post()                                     making sure our 'post like' content is safe
 * @return string       $html                               Our assembled HTML for a single task
 */
function bcit_todo_get_single_task( $task ){

	$html = '<li class="bcit-single-task">';
		$html .= '<span class="task-wrapper">';
			$html .= '<span class="task-title">'. esc_attr( get_the_title( $task->ID ) ) .'</span>';
			$html .= '<span class="task-description">'. wp_kses_post( $task->post_content ) .'</span>';
			$html .= '<a href="'. absint( $task->ID ) .'" class="bcit-button edit">Edit</a>';
			$html .= '<img src="'. plugins_url( '/bcit-todo-list/assets/images/spinner.gif' ).'" class="bcit-todo-ajax-spinner" />';
		$html .= '</span>';
		$html .= '<span class="form-holder"></span>';
	$html .= '</li>';

	return $html;

} // get_single_task
