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

		wp_send_json_success();

	} // process_todo_item

} // BCIT_TODO_Ajax_Requests

new BCIT_TODO_Ajax_Requests();
