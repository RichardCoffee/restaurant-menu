<?php
/**
 * Restaurant Menu
 *
 * @package   Restaurant_Menu
 * @author    Richard Coffee <richard.coffee@gmail.com>
 * @copyright 2019 Richard Coffee
 * @license   GPLv2  <need uri here>
 * @link      link
 *
 * @wordpress-plugin
 * Plugin Name:       Restaurant Menu Plugin
 * Plugin URI:        rtcenterprises.net
 * Description:       Restaurant Menu plugin to control and display menu items
 * Version:           3.0.0
 * Requires at least: 4.7.0
 * Requires WP:       4.7.0
 * Tested up to:      5.2.0
 * Requires PHP:      5.3.6
 * Author:            Richard Coffee
 * Author URI:        author uri
 * GitHub Plugin URI: github uri needed if using plugin-update-checker
 * License:           GPLv2
 * Text Domain:       plugin-domain
 * Domain Path:       /languages
 * Tags:              what, where, when, who, how, why
 */

# https://github.com/helgatheviking/Nav-Menu-Roles/blob/master/nav-menu-roles.php
if ( ! defined('ABSPATH') || ! function_exists( 'is_admin' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

define( 'RMP_PLUGIN_DIR' , plugin_dir_path( __FILE__ ) );

require_once( 'functions.php' );

$rmp_plugin = RMP_Plugin_RestMenu::get_instance( [ 'file' => __FILE__ ] );

register_activation_hook( __FILE__, [ 'RMP_Register_Plugin', 'activate' ] );
