<?php

class BCIT_TODO_shortcodes{

	function __construct(){

		add_shortcode( 'bcit_todo_list_tasks', array( $this, 'list_tasks' ) );

		add_shortcode( 'bcit_todo_add_item_form', array( $this, 'add_item_form' ) );

	} // __construct

	/**
	 * This should list all the tasks that are in our TODO list
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis McHale
	 *
	 * @uses $this->get_tasks()                 Returns posts from get_posts
	 * @uses $this->get_task_list_html()        Returns the HTML for our task list
	 */
	public function list_tasks(){

		$html = '<section id="bcit-task-list-wrapper">';

			$tasks = $this->get_task_posts();

			$html .= $this->get_task_list_html( $tasks );

		$html .= '</section>';

		return $html;

	} // list_tasks

	/**
	 * Returns our task list HTML
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis McHale
	 *
	 * @param array         $tasks          required            The posts that we want to render as tasks
	 * @uses is_wp_error()                                      Returns true if the object passed is a WP_ERROR object
	 * @uses $this->get_single_task()                           Returns the single task HTML as an li
	 */
	private function get_task_list_html( $tasks ){

		$html = '';

		if ( is_wp_error( $tasks ) || empty( $tasks ) ){
			$html .= 'No tasks';
		} else {

			$html .= '<ul id="bcit-task-list">';
			foreach( $tasks as $t ){
					$html .= $this->get_single_task( $t );
			} // foreach
			$html .= '</ul>';

		} // if is_wp_error, empty

		return $html;

	} // get_task_list_html

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
	private function get_single_task( $task ){

		$html = '<li class="bcit-single-task">';
			$html .= '<span class="task-title">'. esc_attr( get_the_title( $task->ID ) ) .'</span>';
			$html .= '<span class="task-description">'. wp_kses_post( $task->post_content ) .'</span>';
			$html .= '<a href="'. absint( $task->ID ) .'" class="bcit-button edit">Edit</a>';
			$html .= '<img src="'. plugins_url( '/bcit-todo-list/assets/images/spinner.gif' ).'" class="bcit-todo-ajax-spinner" />';
		$html .= '</li>';

		return $html;

	} // get_single_task

	/**
	 * Returns our post object containing our tasks
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis McHale
	 *
	 * @uses get_posts()                    Returns posts given post args
	 * @return array        $todo_posts     Our posts matching the args
	 */
	private function get_task_posts(){

		$query_args = array(
			'post_type'      => 'bcit_todo',
			'posts_per_page' => -1,
		);

		$todo_posts = get_posts( $query_args );

		return $todo_posts;

	} // get_tasks

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

		if ( current_user_can( 'create_todo_list' ) || current_user_can( 'update_todo_list' ) ) {

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
