<?php

function rmp_plugin_class_loader( $class ) {
   if ( substr( $class, 0, 4 ) === 'RMP_' ) {
     $load = str_replace( '_', '/', substr( $class, ( strpos( $class, '_' ) + 1 ) ) );
     $file = RMP_PLUGIN_DIR . "/classes/{$load}.php";
     if ( is_readable( $file ) ) {
       include $file;
     }
   }
}
spl_autoload_register( 'rmp_plugin_class_loader' );

