<?php

class RMP_Plugin_RestMenu extends RMP_Plugin_Plugin {


	use RMP_Trait_Singleton;
	use RMP_Trait_Logging;


	protected function __construct( $args = array() ) {
		$this->logging_func = 'tcc_log_entry';
		parent::__construct( $args );
	}

	public function initialize() {
		$this->add_actions();
		$this->add_filters();
		register_deactivation_hook( $this->paths->file, array( 'RMP_Register_RestMenu', 'deactivate' ) );
		register_uninstall_hook(    $this->paths->file, array( 'RMP_Register_RestMenu', 'uninstall'  ) );
	}

	public function add_actions() {
		add_action( 'init', array( $this, 'add_shortcode' );
		if ( is_admin() ) {
			add_action( 'admin_menu', array( RMP_Form_RestMenu::instance(), 'add_menu_option' ) );
			add_action( 'tcc_load_form_page', function() {
				add_action( 'admin_enqueue_scripts', array( RMP_Form_RestMenu::instance(), 'enqueue_theme_scripts' ) );
			});
		}
		parent::add_actions();
	}

	public function add_filters() {
		parent::add_filters();
	}

	public function add_shortcode(){
		add_shortcode( 'restaurant-menu', array( $this, 'display_menu' ) );
	}

	public function display_menu() {
		$menu = new RMP_Shortcode_RestMenu;
		$menu->display_menu();
	}


}
