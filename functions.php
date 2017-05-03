<?php

require_once( 'includes/loader.php' );
require_once( 'includes/debugging.php' );

function rmp_header_logo() {
	$options = Restaurant_Menu_Options::get_setup();
	if ( ( $options['showtab'] === 'show' ) ) {
		if ( ( $pageID = intval( $options['tabpage'] ) ) > 0 ) {
			if ( $perma = get_permalink( $pageID ) ) { ?>
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
