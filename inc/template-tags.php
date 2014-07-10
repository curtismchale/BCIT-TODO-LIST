<?php

/**
 * Returns our form HTML
 *
 * @since 1.0
 * @author SFNdesign, Curtis McHale
 *
 * @return string       $html           Our HTML form
 */
function bcit_todo_get_html_form(){

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
