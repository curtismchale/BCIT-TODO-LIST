<?php

class BCIT_TODO_Ajax_Requests{

	function __construct(){

		add_action( 'wp_ajax_bcit_todo_add_todo_item', array( $this, 'process_todo_item' ) );
		add_action( 'wp_ajax_nopriv_bcit_todo_add_todo_item', array( $this, 'process_todo_item' ) );

		add_action( 'wp_ajax_bcit_todo_edit_form', array( $this, 'get_edit_form' ) );
		add_action( 'wp_ajax_nopriv_bcit_todo_edit_form', array( $this, 'get_edit_form' ) );

	} // __construct

	public function get_edit_form(){

		if ( current_user_can( 'update_todo_list' ) ){
			$args = array(
				'success' => true,
				'message' => bcit_todo_get_form_html( absint( $_POST['post_id'] ) ),
			);
		} else {
			$args = array(
				'success' => false,
				'message' => 'You are not allowed to edit todo items',
			);
		}

		wp_send_json_success( $args );
	}

	/**
	 * Process submitted TODO item
	 *
	 * @since 1.0
	 * @author ME
	 *
	 * @uses check_ajax_referer()                       Check our ajax nonce
	 * @uses current_user_can()                         Returns true if current user has given cap
	 * @uses $this->save_task()                         Saves our task and returns args
	 * @uses wp_send_json_success()                     JSON encodes response and add 'success' as first param
	 */
	public function process_todo_item(){

		check_ajax_referer( 'bcit_todo_ajax_nonce', 'security' );

		$save_me = false;

		if ( isset( $_POST['title'] ) && ! empty( $_POST['title'] ) && current_user_can( 'create_todo_list' ) ){
			$save_me = true;
		}

		if ( true === $save_me ){

			$args = $this->save_task( $_POST );

		} else {
			$args = array(
				'success' => false,
				'message' => 'Task not saved',
			);
		}

		wp_send_json_success( $args );

	} // process_todo_item

	/**
	 * Save my task and return arguements
	 *
	 * @since 1.0
	 * @author ME
	 *
	 * @param array         $posted_values      required        Array of values from $_POST
	 * @uses esc_attr()                                         Keep things safe
	 * @uses wp_kses_post()                                     Safety for 'post like' content
	 * @uses get_current_user_id()                              Returns current user_id
	 * @uses wp_insert_post()                                   Insert post to WP database
	 * @uses is_wp_error()                                      Returns true if passed value is an WP error object
	 * @return array        $args                               Success/fail args
	 */
	private function save_task( $posted_values ){

		$post_content = isset( $posted_values['description'] ) ? $posted_values['description'] : '';

		$post_args = array(
			'post_title'   => esc_attr( $posted_values['title'] ),
			'post_type'    => 'bcit_todo',
			'post_content' => wp_kses_post( $post_content ),
			'post_author'  => absint( get_current_user_id() ),
			'post_status'  => 'publish',
		);

		if ( isset( $posted_values['post_id'] ) && ! empty( $posted_values['post_id'] ) ){
			$post_args['ID'] = absint( $posted_values['post_id'] );
		}

		$post_id = wp_insert_post( $post_args );

		if ( ! is_wp_error( $post_id ) ){
			$args = array(
				'success' => true,
				'message' => 'Task saved',
			);

			if ( $post_id == $posted_values['post_id'] ){
				$args['updated']          = true;
				$args['task_title']       = esc_attr( $posted_values['title'] );
				$args['task_description'] = esc_textarea( $posted_values['description'] );
			} else {
				$task         = get_post( $post_id );
				$args['html'] = bcit_todo_get_single_task( $task );
			}

		} else {
			$args = array(
				'success' => false,
				'message' => 'Had a post title but somethin went wrong saving the task',
			);
		}

		return $args;

	} // save_taks

} // BCIT_TODO_Ajax_Requests

new BCIT_TODO_Ajax_Requests();
