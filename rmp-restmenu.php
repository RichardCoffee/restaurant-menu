<?php

/**
 * Restaurant Menu
 *
 * @package   Restaurant_Menu
 * @author    Richard Coffee
 * @copyright 2015-2017 Richard Coffee
 * @license   GPL2
 *
 * @wordpress-plugin
 * Plugin Name:       Restaurant Menu Plugin
 * Description:       Restaurant Menu plugin for TCC themes
 * Version:           2.0.0
 * Requires at least: 4.7.0
 * Requires WP:       4.7.0
 * Tested up to:      4.7.4
 * Requires PHP:      5.3.6
 * Author:            Richard Coffee & James Gaither
 * Author URI:        https://the-creative-collective.com
 * License:           GPLv2 or later
 * Text Domain:       tcc-restaurant
 * Domain Path:       /languages
 * Tags:              restaurant, food, menu
 */

defined( 'ABSPATH' ) || exit;

define( 'RMP_RESTMENU_DIR' , plugin_dir_path( __FILE__ ) );

require_once( 'functions.php' );

RMP_Plugin_RestMenu::get_instance( array( 'file' => __FILE__ ) );

register_activation_hook( __FILE__, array( 'RMP_Register_RestMenu', 'activate' ) );


  function restaurant_menu_initialize() {
    if ( is_admin() ) {
      Restaurant_Menu_Updates::check_update('rmp_');
      add_action('admin_init',              array('Restaurant_Menu_Updates','redirect_about'),1);
      add_filter('tcc_admin_menu_setup',    array('Restaurant_Menu_Admin','admin_menu_setup'));
      add_action('wp_ajax_save_rmp_menu',   array('Restaurant_Items','save_menu_items'));
    } else {
      add_action('wp_head',array('Restaurant_Menu_Options','generate_options_css'));
    }
  }
