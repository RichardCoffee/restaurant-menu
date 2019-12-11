<?php

class RMP_Options_RestMenu extends RMP_Options_Options {

	protected $base     = 'restmenu';
	protected $priority = 550;  #  internal theme option

	protected function form_title() {
		return __( 'Restaurant Menu', 'rmp-restmenu' );
	}

	public function describe_options() {
		$short   = esc_html__( 'The restaurant menu can be placed on any desired page by using the shortcode [restaurant-menu].', 'rmp-restmenu' );
		$section = esc_html__( 'The menu consists of sections, which are divided into groups, which contain the individual items.', 'rmp-restmenu' );
		$creator = esc_html_x( 'Go to the %smenu creator%s.', 'placeholders are an html anchor tag set', 'rmp-restmenu' );
		printf( '<p>%s</p><p>%s</p><p>%s</p>', $short, $section, sprintf( $creator, '<a href="/wp-admin/admin.php?page=restaurant">', '</a>' ) );
	}

	protected function options_layout( $all = false ) {
		$layout  = array( 'default' => true );
		$layout['menu'] = array(
			'label'  => __( 'Menu Settings', 'rmp-restmenu' ),
			'text'   => __( "These options control the Menu's general settings", 'rmp-restmenu' ),
			'render' => 'display',
		);
		$layout['layout'] = array(
			'default' => 'double',
			'label'   => __( 'Menu Layout', 'rmp-restmenu' ),
			'text'    => __( 'Not applicable to mobile devices', 'rmp-restmenu' ),
			'render'  => 'radio',
			'source'  => array(
				'single' => __( 'Single Column', 'rmp-restmenu' ),
				'double' => __( 'Two Columns',   'rmp-restmenu' ),
			),
		); /*
		$layout['showtab'] = array(
			'default' => 'show',
			'label'   => __( 'Header Tab', 'rmp-restmenu' ),
			'text'    => __( 'Show a special menu tab in the header, if the theme supports it', 'rmp-restmenu' ),
			'render'  => 'radio',
			'source'  => array(
				'show' => __( 'Show', 'rmp-restmenu' ),
				'hide' => __( 'Hide', 'rmp-restmenu' ),
			),
			'change'  => 'showhideTab();',
			'class'   => 'rmp-tab',
		);
		$layout['tabtext'] = array(
			'default' => __( 'Our Menu and Specials', 'rmp-restmenu' ),
			'label'   => __( 'Tab Text', 'rmp-restmenu' ),
			'render'  => 'text',
			'class'   => 'tcc_text_30em rmp-tabInfo',
		);
		$layout['tabpage'] = array(
			'default' => "0",
			'label'   => __( 'Tab Page', 'rmp-restmenu' ),
			'text'    => __( 'Set this to the name of the page to be called by the Header Tab', 'rmp-restmenu' ),
			'render'  => 'wp_dropdown',
			'source'  => 'pages',
			'args'    => array(),
			'class'   => 'rmp-tabInfo',
		); //*/
		$layout['symbol'] = array(
			'default' => '$',
			'label'   => __( 'Currency', 'rmp-restmenu' ),
			'text'    => __( 'Your local currency symbol', 'rmp-restmenu' ),
			'render'  => 'text',
			'class'   => 'tcc_text_3em',
		);
		$layout['colors'] = array(
			'label'   => '<h3>' . __( 'Color Settings', 'rmp-restmenu' ). '</h3>',
			'text'    => '<h4>' . __( 'These options control specific color options of the front end menu', 'rmp-restmenu' ) . '</h4>',
			'render'  => 'display',
		);
		$layout['stitle'] = array(
			'default' => '#000000',
			'label'   => __( 'Section Title', 'rmp-restmenu' ),
			'text'    => __( 'This color is for the title of the menu sections', 'rmp-restmenu' ),
			'render'  => 'colorpicker',
			'class'   => 'tcc_text_10em',
		);
		$layout['gtitle'] = array(
			'default' => '#000000',
			'label'   => __( 'Group Title', 'rmp-restmenu' ),
			'text'    => __( 'This color is for the title of the menu groups', 'rmp-restmenu' ),
			'render'  => 'colorpicker',
			'class'   => 'tcc_text_10em',
		);
		$layout['ititle'] = array(
			'default' => '#000000',
			'label'   => __( 'Item Title', 'rmp-restmenu' ),
			'text'    => __( 'This color is for the title of the menu items', 'rmp-restmenu' ),
			'render'  => 'colorpicker',
			'class'   => 'tcc_text_10em',
		); /*
		$layout['plugin'] = array(
			'label'   => '<h3>' . $text['plugin']['label'] . '</h3>',
			'text'    => '<h4>' . $text['plugin']['text'] . '</h4>',
			'render'  => 'display',
		);
		$layout['loca'] = array(
			'default' => 'dashboard',
			'label'   => $text['loca']['label'],
			'text'    => __('You can choose where the Restaurant Menu page appears','rmp-restmenu'),
			'render'  => 'radio',
			'source'  => array(
				'tcc'        => __('Theme Options menu','rmp-restmenu'),
				'dashboard'  => $text['loca']['source']['dashboard'],
				'pages'      => __('Pages menu - use this to allow Editor access','rmp-restmenu'),
				'settings'   => $text['loca']['source']['settings']
			),
			'change'  => 'showhidePosi();',
			'class'   => 'tcc-loca'
		);
		$layout['wp_posi'] = array(
			'default' => 'top',
			'label'   => $text['wp_posi']['label'],
			'text'    => __('This controls where on the WordPress Dashboard that the Restaurant Menu will appear','rmp-restmenu'),
			'render'  => 'select',
			'source'  => $text['wp_posi']['source'],
			'class'   => 'tcc-wp_posi'
		);
		$layout['deactive'] = array(
			'default' => 'no',
			'label'   => $text['deactive']['label'],
			'text'    => $text['deactive']['text'],
			'render'  => 'checkbox'
		);
		$layout['uninstall'] = array(
			'default' => 'yes',
			'label'   => $text['uninstall']['label'],
			'text'    => $text['uninstall']['text'],
			'render'  => 'checkbox'
		);
		$current = get_option('tcc_options_about');
		if ($current && ($current['loca']!=='dashboard')) unset($ret['loca']['source']['tcc']);
		//*/
		return apply_filters( "tcc_options_layout_{$this->base}", $layout );
	}


}
