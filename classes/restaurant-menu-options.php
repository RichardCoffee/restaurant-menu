<?php /* arrays.php */

class Restaurant_Menu_Options extends TCC_Theme_Options_Values {

  public static function options_menu_array($options=array()) {
    $options['menu-setup'] = array('describe' => array('Restaurant_Menu_Admin','describe_menu'),
                                   'title'    => __('Restaurant','tcc-theme-options'),
                                   'layout'   => self::options_layout('menu'));
    return $options;
  }

  protected static function menu_options_layout() {
    $text = self::translate_text();  // function in TCC_Theme_Options
    $ret = array('menu'      => array('label'   => '<h3>'.__('Menu Settings','tcc-theme-options').'</h3>',
	                                  'text'    => '<h4>'.__("These options control the Menu's general settings",'tcc-theme-options').'</h4>',
									  'render'  => 'display'),
				 'layout'    => array('default' => 'double',
				                      'label'   => __('Menu Layout','tcc-theme-options'),
									  'text'    => __('Not applicable to mobile devices','tcc-theme-options'),
									  'render'  => 'select',
									  'source'  => array('single' => __('Single Column','tcc-theme-options'),
									                     'double' => __('Two Columns',  'tcc-theme-options'))),
				 'showtab'   => array('default' => 'show',
				                      'label'   => __('Header Tab','tcc-theme-options'),
				                      'text'    => __('Show a special menu tab in the header, if the theme supports it','tcc-theme-options'),
									  'render'  => 'radio',
									  'source'  => array('show' => __('Show','tcc-theme-options'),
									                     'hide' => __('Hide','tcc-theme-options')),
									  'change'  => 'showhideTab();',
									  'class'   => 'rmp-tab'),
				 'tabtext'   => array('default' => __('Our Menu and Specials','tcc-theme-options'),
				                      'label'   => __('Tab Text','tcc-theme-options'),
									  'render'  => 'text',
									  'class'   => 'tcc_text_30em rmp-tabInfo'),
				 'tabpage'   => array('default' => "0",
				                      'label'   => __('Tab Page','tcc-theme-options'),
									  'text'    => __('Set this to the name of the page to be called by the Header Tab','tcc-theme-options'),
									  'render'  => 'wp_dropdown',
									  'source'  => 'pages',
									  'args'    => array(),
									  'class'   => 'rmp-tabInfo'),
				 'symbol'    => array('default' => '$',
				                      'label'   => __('Currency','tcc-theme-options'),
									  'text'    => __('Your local currency symbol','tcc-theme-options'),
									  'render'  => 'text',
									  'class'   => 'tcc_text_3em'),
				 'colors'    => array('label'   => '<h3>'.__('Color Settings','tcc-theme-options').'</h3>',
	                                  'text'    => '<h4>'.__('These options control specific color options of the front end menu','tcc-theme-options').'</h4>',
									  'render'  => 'display'),
				 'stitle'    => array('default' => '#000000',
				                      'label'   => __('Section Title','tcc-theme-options'),
									  'text'    => __('This color is for the title of the menu sections','tcc-theme-options'),
									  'render'  => 'colorpicker',
									  'class'   => 'tcc_text_10em'),
				 'gtitle'    => array('default' => '#000000',
				                      'label'   => __('Group Title','tcc-theme-options'),
									  'text'    => __('This color is for the title of the menu groups','tcc-theme-options'),
									  'render'  => 'colorpicker',
									  'class'   => 'tcc_text_10em'),
				 'ititle'    => array('default' => '#000000',
				                      'label'   => __('Item Title','tcc-theme-options'),
									  'text'    => __('This color is for the title of the menu items','tcc-theme-options'),
									  'render'  => 'colorpicker',
									  'class'   => 'tcc_text_10em'),
                 'plugin'    => array('label'   => "<h3>{$text['plugin']['label']}</h3>",
	                                  'text'    => "<h4>{$text['plugin']['text']}</h4>",
									  'render'  => 'display'),
				 'loca'      => array('default' => 'dashboard',
				                      'label'   => $text['loca']['label'],
									  'text'    => __('You can choose where the Restaurant Menu page appears','tcc-theme-options'),
									  'render'  => 'radio',
									  'source'  => array('tcc'        => __('Theme Options menu','tcc-theme-options'),
									                     'dashboard'  => $text['loca']['source']['dashboard'],
									                     'pages'      => __('Pages menu - use this to allow Editor access','tcc-theme-options'),
														 'settings'   => $text['loca']['source']['settings']),
									  'change'  => 'showhidePosi();',
									  'class'   => 'tcc-loca'),
                 'wp_posi'   => array('default' => 'top',
                                      'label'   => $text['wp_posi']['label'],
                                      'text'    => __('This controls where on the WordPress Dashboard that the Restaurant Menu will appear','tcc-theme-options'),
                                      'render'  => 'select',
                                      'source'  => $text['wp_posi']['source'],
									  'class'   => 'tcc-wp_posi'),
                 'deactive'  => array('default' => 'no',
                                      'label'   => $text['deactive']['label'],
                                      'text'    => $text['deactive']['text'],
                                      'render'  => 'checkbox'),
                 'uninstall' => array('default' => 'yes',
                                      'label'   => $text['uninstall']['label'],
                                      'text'    => $text['uninstall']['text'],
                                      'render'  => 'checkbox'));
    $current = get_option('tcc_options_about');
	if ($current && ($current['loca']!=='dashboard')) unset($ret['loca']['source']['tcc']);
	return $ret;
  }

  public static function about_options($layout) {
    $text = self::translate_text();
    $layout['rmp_plugin']  = array('label'   => '<h3>'.__('Restaurant Menu Plugin','tcc-theme-options').'</h3>',
							       'render'  => 'display');
	$layout['rmp_version'] = array('default' => RMP_VERSION,
                                   'label'   => $text['version']['label'],
                                   'render'  => 'display');
    $layout['rmp_dbvers']  = array('default' => RMP_DBVERS,
                                   'label'   => $text['dbvers']['label'],
                                   'render'  => 'skip');
	return $layout;
  }

  public static function get_setup() {
    static $setup;
    if (empty($setup)) {
      $options  = get_option('tcc_options_menu-setup');
      $defaults = self::options_defaults('menu-setup');
      $setup    = array_merge($defaults,$options);
    }
    return $setup;
  }
  
  public static function generate_options_css() {
    $layout  = self::menu_options_layout();
    $options = get_option('tcc_options_menu-setup'); ?>
    <style id='rmp-custom-color-css' type='text/css'><?php
      foreach($layout as $key=>$option) {
	    if (empty($options[$key])) continue;
	    if ($option['render']!=='colorpicker') continue;
		if ($options[$key]=='none') continue;
	    echo ".rmp-$key { color: {$options[$key]}; }";
      } ?>
    </style><?php
  }

}

?>