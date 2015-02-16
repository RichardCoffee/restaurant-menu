<?php

function rmp_register_shortcodes(){
  add_shortcode('restaurant-menu', 'rmp_display_menu');
}

function rmp_display_menu() {
  require_once(RMP_LOCATE.'classes/restaurant-menu.php');
  return Restaurant_Menu::display_menu();
}

function rmp_enqueue_scripts() {
  wp_register_style('rmp-menu-tab',RMP_URL.'css/restaurant-tab.css',false);
  wp_enqueue_style('rmp-menu-tab');
}

function rmp_header_logo() {
  $options = Restaurant_Menu_Options::get_setup();
  if (($options['showtab']=='show')) {
    if (($pageID=intval($options['tabpage']))>0) {
	  if (($perma=get_permalink($pageID))) { ?>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
          <a href="<?php echo $perma; ?>">
	        <div class="menutab">
		      <h2><?php echo $options['tabtext']; ?></h2>
		    </div>
	      </a>
        </div><?php
	  }
	}
  }
}

if (!function_exists('tcc_log_entry')) {
  function tcc_log_entry($message,$mess2='') {
    if (WP_DEBUG) {
      if (is_array($message) || is_object($message)) {
        error_log(print_r($message, true));
      } else {
        error_log($message);
      }
      if ($mess2) tcc_log_entry($mess2);
    }
  }
}

?>
