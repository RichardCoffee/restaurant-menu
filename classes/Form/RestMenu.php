<?php

class RMP_Form_RestMenu extends RMP_Form_Admin {


	protected $slug = 'restmenu';
	protected $menu_text;
	/*  properties inherited from Form_Admin class  */
#	protected $hook_suffix;
#	protected $render;

	use RMP_Trait_Singleton;


	protected function __construct() {
		$this->menu_text = __( 'Restaurant Menu', 'rmp-restmenu' );
		add_filter( "form_text_{$this->slug}", array( $this, 'form_trans_text' ), 10, 2 );
		parent::__construct();
	}

	public function add_menu_option() {
		$cap = 'update_core';
		if ( current_user_can( $cap ) ) {
			$page = $this->menu_text;
			$menu = $this->menu_text;
			$func = array( $this, $this->render );
			$this->hook_suffix = add_pages_page( $page, $menu, $cap, $this->slug, $func );
		}
	}

	public function admin_enqueue_scripts( $hook ) {
#		$paths = PMW_Plugin_Paths::instance();
#		wp_register_style(  'privacy-form.css', $paths->get_plugin_file_uri( 'css/pmw-admin-form.css' ), null, $paths->version );
#		wp_register_script( 'privacy-form.js',  $paths->get_plugin_file_uri( 'js/pmw-admin-form.js' ), array( 'jquery' ), $paths->version, true );
#		wp_enqueue_style(   'privacy-form.css' );
#		wp_enqueue_script(  'privacy-form.js' );
	}

	public function enqueue_theme_scripts() {
#		$paths = PMW_Plugin_Paths::instance();
#		wp_register_style(  'privacy-form.css', $paths->get_plugin_file_uri( 'css/pmw-theme-form.css' ), null, $paths->version );
#		wp_enqueue_style(   'privacy-form.css' );
	}

	protected function form_layout( $form = array() ) {
		$options = new RMP_Options_RestMenu;
		$form    = $options->default_form_layout();
		$form['title'] = $this->menu_text;
		return $form;
	}

	public function form_trans_text( $text, $orig ) {
		$text['submit']['object']  = $this->menu_text;
		$text['submit']['subject'] = $this->menu_text;
		return $text;
	} //*/



}
