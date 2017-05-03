<?php
/*
Plugin Name: Restaurant Menu Plugin
Plugin URI: https://entechpc.com
Description: Restaurant Menu plugin for TCC themes
Version: 1.3
Author: Richard Coffee & James Gaither
Author URI: https://entechpc.com
Text Domain: restaurant-menu
Domain Path: /languages
License: GPLv2 or later
*/

defined('ABSPATH') || exit;

if (class_exists('RMP_Theme_Options_Register')) {

  define('RMP_VERSION','1.3');
  define('RMP_DBVERS','0');
  define('RMP_LOCATE',plugin_dir_path(__FILE__));
  define('RMP_URL',plugin_dir_url(__FILE__));

  if (is_admin()) {
    require_once(RMP_LOCATE.'classes/restaurant-menu-register.php');
    register_activation_hook(  __FILE__,array('Restaurant_Menu_Register','activate'));
    register_deactivation_hook(__FILE__,array('Restaurant_Menu_Register','deactivate'));
    register_uninstall_hook(   __FILE__,array('Restaurant_Menu_Register','uninstall'));
  }

  function restaurant_menu_initialize() {
    require_once(RMP_LOCATE.'functions.php');
    include_once(RMP_LOCATE.'classes/restaurant-menu-options.php');
    if (is_admin()) {
      include_once(RMP_LOCATE.'classes/restaurant-menu-updates.php');
      include_once(RMP_LOCATE.'classes/restaurant-menu-admin.php');
      include_once(RMP_LOCATE.'classes/restaurant-items.php');
      Restaurant_Menu_Updates::check_update('rmp_');
      $lang_dir = RMP_LOCATE.'languages/';
      load_plugin_textdomain( 'tcc-theme-options', false, $lang_dir );
      add_action('admin_init',              array('Restaurant_Menu_Updates','redirect_about'),1);
      add_filter('tcc_options_menu_array',  array('Restaurant_Menu_Options','options_menu_array'),11);
      add_filter('tcc_about_options_layout',array('Restaurant_Menu_Options','about_options'));
      add_filter('tcc_admin_menu_setup',    array('Restaurant_Menu_Admin','admin_menu_setup'));
      add_action('wp_ajax_save_rmp_menu',   array('Restaurant_Items','save_menu_items'));
    } else {
      add_action('init','rmp_register_shortcodes');
      add_action('wp_enqueue_scripts','rmp_enqueue_scripts');
      add_action('wp_head',array('Restaurant_Menu_Options','generate_options_css'));
    }
  }
  add_action('plugins_loaded','restaurant_menu_initialize',11);

} else {
#  require_once(ABSPATH.'wp-admin/include/plugin.php');
#  deactivate_plugins(plugin_basename( __FILE__ ));
#  wp_die( 'This plugin requires the TCC Theme Option plugin.  Sorry about that.' );
}

?>
