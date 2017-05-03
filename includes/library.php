<?php

if ( ! function_exists( '__return_is_numeric' ) ) {
	function __return_is_numeric( $param ) {
		return is_numeric( $param );
	}
}

if ( ! function_exists( '__return_intval' ) ) {
	function __return_intval ( $param ) {
		return intval( $param, 10 );
	}
}
