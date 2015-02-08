<?php

// http://stackoverflow.com/questions/18997774/add-draggable-sections-in-wordpress-plugin-page

class Restaurant_Menu_Admin {

  private static $menu_slug = 'restaurant';

  public static function admin_menu_setup() {
    $general   = get_option('tcc_options_general');
    $setup     = get_option('tcc_options_menu-setup');
	if (!$setup) $setup = Restaurant_Menu_Options::options_defaults('menu-setup');
    $item_name = __('Restaurant Menu','tcc-theme-options');
	$item_cap  = 'manage_options';
    $menu_func = array('Restaurant_Items','render_page');
	if (($general['loca']=='dashboard') && ($setup['loca']=='tcc')) {
	  add_submenu_page(TCC_Theme_Options_Admin::$menu_slug,$item_name,$item_name,$item_cap,self::$menu_slug,$menu_func);
	} else if ($setup['loca']=='pages') {
	  add_pages_page($item_name,$item_name,'edit_pages',self::$menu_slug,$menu_func);
	} else if ($setup['loca']=='settings') {
	  add_options_page($item_name,$item_name,$item_cap,self::$menu_slug,$menu_func);
	} else {
      $icon_name = 'dashicons-carrot';
      $priority  = ($setup['wp_posi']=='top') ? '1.11' : '99.9122473782';
      add_menu_page($item_name,$item_name,$item_cap,self::$menu_slug,$menu_func,$icon_name,$priority);
    }
	add_action('admin_enqueue_scripts', array(__CLASS__,'load_admin_scripts'));
	add_action('tcc_enqueue_scripts',   array(__CLASS__,'load_options_scripts'));
  }

  public static function load_admin_scripts($hook) {
    wp_register_script('rmp-items', RMP_URL.'js/items.js',   array('jquery','tcc-library'), false, true);
	wp_register_style('rmp-items',  RMP_URL.'css/items.css', false);
	if (strpos(self::$menu_slug,$hook)==-1) return;
    wp_enqueue_script('rmp-items');
	wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_style('tcc-awesome');
	wp_enqueue_style('tcc-columns');
    wp_enqueue_style('rmp-items');
  }

  public static function load_options_scripts() {
    wp_register_script('rmp-admin', RMP_URL.'js/admin.js',   array('jquery','tcc-library'), false, true);
	wp_enqueue_script('rmp-admin');
  }

  public static function describe_menu() {
    $string  = '<p>'.__('The restaurant menu can be placed on any desired page by using the shortcode [restaurant-menu].','tcc-theme-options').'</p>';
	$string .= '<p>'.__('The menu consists of sections, which are divided into groups, which contain the individual items.','tcc-theme-options').'</p>';
	$string .= '<p>Go to the <a href="/wp-admin/admin.php?page=restaurant">menu creater</a>.</p>';
    echo $string;
  }

  public static function describe_items() {
    echo "menu items will be input here";
  }

}

?>