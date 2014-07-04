<?php
/*
Plugin Name: BCIT TODO List
Plugin URI:
Description: Building a TODO list plugin for BCIT WPD01
Version: 1.0
Author: SFNdesign, Curtis McHale
Author URI: http://sfndesign.ca
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

class BCIT_TODO_List{

	function __construct(){

		add_action( 'init', array( $this, 'add_custom_post_types' ) );

		// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );

	} // construct

	/**
	 * Builds out the custom post types for the site
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis McHale
	 * @access public
	 *
	 * @uses    register_post_type
	 */
	public function add_custom_post_types(){

		register_post_type( 'bcit_todo', // http://codex.wordpress.org/Function_Reference/register_post_type
			array(
				'labels'                => array(
					'name'                  => __('TODOS'),
					'singular_name'         => __('TODO'),
					'add_new'               => __('Add New'),
					'add_new_item'          => __('Add New TODO'),
					'edit'                  => __('Edit'),
					'edit_item'             => __('Edit TODO'),
					'new_item'              => __('New TODO'),
					'view'                  => __('View TODO'),
					'view_item'             => __('View TODO'),
					'search_items'          => __('Search TODOS'),
					'not_found'             => __('No TODOS Found'),
					'not_found_in_trash'    => __('No TODOS found in Trash')
					), // end array for labels
				'public'                => true,
				'menu_position'         => 5, // sets admin menu position
				'menu_icon'             => 'dashicons-list-view',
				'hierarchical'          => false, // functions like posts
				'supports'              => array('title', 'editor', 'revisions', 'excerpt', 'thumbnail'),
				'rewrite'               => array('slug' => 'bcit-todo', 'with_front' => true,), // permalinks format
				'can_export'            => true,
			)
		);

	} // add_custom_post_types

	/**
	 * Adds our custom capabilities for the TODO list
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis McHale
	 *
	 * @uses get_role()                 Gets the WP role specified
	 * @uses add_cap()                  Adds capability to the role object
	 */
	public function create_caps(){

		$admin = get_role( 'administrator' );
		$admin->add_cap( 'create_todo_list' );
		$admin->add_cap( 'read_todo_list' );
		$admin->add_cap( 'update_todo_list' );
		$admin->add_cap( 'delete_todo_list' );

	} // create_caps

	/**
	 * Removes our custom capabilities when we deactivate the plugin
	 *
	 * @since 1.0
	 * @author SFNdesign, Curtis McHale
	 *
	 * @uses get_role()                 Gets the WP role specified
	 * @uses remove_cap()               Removes capability to the role object
	 */
	public function remove_caps(){

		$admin = get_role( 'administrator' );
		$admin->remove_cap( 'create_todo_list' );
		$admin->remove_cap( 'read_todo_list' );
		$admin->remove_cap( 'update_todo_list' );
		$admin->remove_cap( 'delete_todo_list' );

	} // remove_caps

	/**
	 * Fired when plugin is activated
	 *
	 * @param   bool    $network_wide   TRUE if WPMU 'super admin' uses Network Activate option
	 */
	public function activate( $network_wide ){

		$this->create_caps();

		$this->add_custom_post_types();
		flush_rewrite_rules();

	} // activate

	/**
	 * Fired when plugin is deactivated
	 *
	 * @param   bool    $network_wide   TRUE if WPMU 'super admin' uses Network Activate option
	 */
	public function deactivate( $network_wide ){

		$this->remove_caps();

	} // deactivate

	/**
	 * Fired when plugin is uninstalled
	 *
	 * @param   bool    $network_wide   TRUE if WPMU 'super admin' uses Network Activate option
	 */
	public function uninstall( $network_wide ){

	} // uninstall

} // BCIT_TODO_List

new BCIT_TODO_List();
