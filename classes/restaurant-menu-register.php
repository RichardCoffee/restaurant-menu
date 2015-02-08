<?php

class Restaurant_Menu_Register extends TCC_Theme_Options_Register {

  public static function activate($transient='show_rmp_setup_page') {
    if (!parent::activate($transient)) return;
    self::add_options();
  }

  protected static function add_options() {
    include_once(RMP_LOCATE.'classes/restaurant-menu-options.php');
    $menu = Restaurant_Menu_Options::options_menu_array();
    foreach($menu as $key=>$data) {
      if (get_option("tcc_options_$key")) continue;
      $section = "tcc_options_$key";
      delete_option($section); // empty option may exist in dbf
      $options = Restaurant_Menu_Options::options_defaults($key);
      add_option($section,$options);
    }
  }

  public static function deactivate() {
    if (!current_user_can('activate_plugins')) return;
    self::delete_options('deactive');
  }

  public static function uninstall() {
    if (!current_user_can('activate_plugins')) return;
    self::delete_options('uninstall');
  }

  protected static function delete_options($action) {
    include_once(RMP_LOCATE.'classes/restaurant-menu-options.php');
    $options = get_option('tcc_options_menu-setup');
    if ($options[$action]=='no') return;
    $menu = Restaurant_Menu_Options::options_menu_array();
    foreach($menu as $key=>$data) {
      delete_option("tcc_options_$key");
    }
  }

}

?>
