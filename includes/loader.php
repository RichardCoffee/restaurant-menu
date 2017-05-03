<?php

function rmp_restmenu_class_loader( $class ) {
	if ( substr( $class, 0, 4 ) === 'RCB_' ) {
		#  these str calls are much faster than an explode, array_pop, implode sequence
		$load = str_replace( '_', '/', substr( $class, ( strpos( $class, '_' ) + 1 ) ) );
		$file = RMP_RESTMENU_DIR . '/classes/' . $load . '.php';
		if ( is_readable( $file ) ) {
			include $file;
		}
	}
}
spl_autoload_register( 'rmp_restmenu_class_loader' );
