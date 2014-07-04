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

		// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );

	} // construct

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
