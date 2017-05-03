<?php

class RMP_Register_RestMenu extends RMP_Register_Register {

	public    static $option      = 'restmenu';
	protected static $plugin_file = 'rmp-restmenu/rmp-restmenu.php';

	protected static function activate_tasks() {
		self::initialize_options();
	}

	private static function initialize_options() {
		$options = get_option( 'tcc_options_restmenu', array() );
		if ( empty( $options ) ) {
			$restmenu = new RMP_Options_RestMenu;
			$options  = $restmenu->get_default_options();
			update_option( 'tcc_options_restmenu', $options );
		}
	}

}
