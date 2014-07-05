<?php

class BCIT_TODO_Ajax_Requests{

	function __construct(){
		add_action( 'wp_ajax_bcit_todo_add_todo_item', array( $this, 'process_todo_item' ) );
		add_action( 'wp_ajax_nopriv_bcit_todo_add_todo_item', array( $this, 'process_todo_item' ) );
	} // __construct

	/**
	 * Processes the submitted TODO item
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis McHale
	 */
	public function process_todo_item(){

		check_ajax_referer( 'bcit_todo_ajax_nonce', 'security' );

		$save_me = false;

		if ( isset( $_POST['title'] ) && ! empty( $_POST['title'] ) && current_user_can( 'create_todo_list' ) ) {
			$save_me = true;
		}

		if ( true === $save_me ){

			$args = $this->save_task( $_POST );

		} else {

			$args = array(
				'success' => false,
				'message' => 'Task was not saved',
			);

		}

		wp_send_json_success( $args );

	} // process_todo_item

	/**
	 * Handles the saving of our task
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis McHale
	 *
	 * @param array     $posted_values      required            The values passed through from $_POST
	 * @return array    $args                                   The success/fail messages for our json response
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

		$post_id = wp_insert_post( $post_args );

		if ( ! is_wp_error( $post_id ) ){
			$args = array(
				'success' => true,
				'message' => 'Task saved',
			);
		} else {
			$args = array(
				'success' => false,
				'message' => 'Had a post title but somethin went wrong with saving the task',
			);
		}

		return $args;

	} // save_task

} // BCIT_TODO_Ajax_Requests

new BCIT_TODO_Ajax_Requests();
