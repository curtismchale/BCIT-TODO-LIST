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

		if ( current_user_can( 'read_todo_list' ) ){

			$tasks = $this->get_task_posts();

			$html .= $this->get_task_list_html( $tasks );

		} else {
			$html .= 'You are not allowed to see tasks';
		}

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
					$html .= bcit_todo_get_single_task( $t );
			} // foreach
			$html .= '</ul>';

		} // if is_wp_error, empty

		return $html;

	} // get_task_list_html

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
	 * @uses bcit_todo_get_html_form()      Returns the HTML we want for our TODO list form
	 * @return string       $html           Our form HTML
	 */
	public function add_item_form(){

		$html = '';

		if ( current_user_can( 'create_todo_list' ) || current_user_can( 'update_todo_list' ) ) {

			$html .= bcit_todo_get_html_form();

		} else {
			$html .= 'Sorry you are not allowed to add todo items';
		}

		return $html;

	} // add_item_form

} // BCIT_TODO_shortcodes

new BCIT_TODO_shortcodes();
