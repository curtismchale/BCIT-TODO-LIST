<?php

class BCIT_TODO_Shortcodes{

	function __construct(){

		add_shortcode( 'bcit_todo_list_tasks', array( $this, 'list_tasks' ) );

		add_shortcode( 'bcit_todo_add_item_form', array( $this, 'add_item_form' ) );

	} // __construct

	public function list_tasks(){

		$html = '<section id="bcit-task-list-wrapper">';

		if ( current_user_can( 'read_todo_list' ) ){

			$tasks = $this->get_task_posts();

			$html .= $this->get_task_list_html( $tasks );

		} else {
			$html .= 'You are not allowed to see this';
		}

		$html .= '</section>';

		return $html;

	} // list_tasks

	private function get_task_list_html( $tasks ){

		$html = '';

		if ( is_wp_error( $tasks ) || empty( $tasks ) ){
			$html .= 'No tasks';
		} else {

			$html .= '<ul id="bcit-task-list">';
				foreach( $tasks as $t ){
					$html .= $this->get_single_task( $t );
				}
			$html .= '</ul>';

		}

		return $html;

	}

	private function get_single_task( $task ){

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

	}

	private function get_task_posts(){

		$query_args = array(
			'post_type'      => 'bcit_todo',
			'posts_per_page' => -1,
		);

		$todo_posts = get_posts( $query_args );

		return $todo_posts;

	} // get_task_posts

	/**
	 * This gives us the form for adding TODO items.
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis McHale
	 * @access public
	 *
	 * @uses current_user_can()                 Returns true if current user has given cap
	 * @uses $this->get_form_html()             Returns our form HTML
	 * @return string       $html               Our HTML form
	 */
	public function add_item_form(){

		$html = '';

		if ( current_user_can( 'create_todo_list' ) || current_user_can( 'update_todo_list' ) ){

			$html .= bcit_todo_get_form_html();

		} else {
			$html .= 'Sorry you are not allowed to add todo items';
		}

		return $html;

	} // add_item_form

} // BCIT_TODO_Shortcodes

new BCIT_TODO_Shortcodes();
