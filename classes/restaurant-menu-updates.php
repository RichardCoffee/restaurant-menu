<?php

class Restaurant_Menu_Updates extends TCC_Theme_Options_Updates {

  private static $dbvers  = RMP_DBVERS;
  private static $version = RMP_VERSION;
  private static $option  = 'tcc_options_menu';

  public static function redirect_about() {
    if (!current_user_can('manage_options')) return;
    if (!get_transient('show_rmp_setup_page')) return;
    delete_transient('show_rmp_setup_page');
    wp_safe_redirect(admin_url('admin.php?page=tcc_options_menu&tab=menu'));
    exit;
  }

}

?>