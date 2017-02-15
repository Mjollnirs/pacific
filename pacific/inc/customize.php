<?php
/**
 * Pacific customizer initiation
 *
 * Initializes Pacific's customization options and controls.
 *
 * @package Pacific
 */

# Prevent direct access to this file
if ( 1 == count( get_included_files() ) ) {
	header( 'HTTP/1.1 403 Forbidden' );
	return;
}

/**
 * Extend Textarea Customize Control
 */
include_once ABSPATH . WPINC . '/class-wp-customize-control.php';

class Flat_Message extends WP_Customize_Control {
    private $message = '';
    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct( $manager, $id, $args );
        if( ! empty( $args['flat_message'] ) ) {
            $this->message = $args['flat_message'];
        }
    }
    
    public function render_content() {
        echo '<span class="customize-control-title">' . $this->label . '</span>';
        echo $this->message;
    }
}

/**
 * Register customizer controls
 *
 * @param object $wp_customize The WordPress customizer object
 */
function pacific_customize_register( $wp_customize ) {
	# Logo
	$wp_customize->add_setting( 'pacific_theme_options[logo]', array(
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
		'label' => __( 'Site Logo', 'pacific' ),
		'section' => 'title_tagline',
		'settings' => 'pacific_theme_options[logo]',
	) ) );

	# Site Title Font Family
	$wp_customize->add_setting( 'pacific_theme_options[site_title_font_family]', array(
		'default' => 'Amatic+SC',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'pacific_sanitize_site_title_font_family',
	) );
	$wp_customize->add_control( 'site_title_font_family', array(
		'settings' => 'pacific_theme_options[site_title_font_family]',
		'label' => __( 'Site Title Font Family', 'pacific' ),
		'section' => 'title_tagline',
		'type' => 'select',
		'choices' => array(
			'Amatic+SC' => 'Amatic SC',
			'Yesteryear' => 'Yesteryear',
			'Pacifico' => 'Pacifico',
			'Dancing+Script' => 'Dancing Script',
			'Satisfy' => 'Satisfy',
			'Handlee' => 'Handlee',
			'Lobster' => 'Lobster',
			'Lobster+Two' => 'Lobster Two',
		),
	) );

	# Header Display
	$wp_customize->add_setting( 'pacific_theme_options[header_display]', array(
		'default' => 'site_title',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'pacific_sanitize_header_display',
	) );
	$wp_customize->add_control( 'header_display', array(
		'settings' => 'pacific_theme_options[header_display]',
		'label' => 'Display as',
		'section' => 'title_tagline',
		'type' => 'select',
		'choices' => array(
			'site_title' => __( 'Site Title', 'pacific' ),
			'site_logo' => __( 'Site Logo', 'pacific' ),
			'both_title_logo' => __( 'Both Title and Logo', 'pacific' ),
		),
	) );

	# Favicon
	$wp_customize->add_setting( 'pacific_theme_options[favicon]', array(
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'favicon', array(
		'label' => __( 'Site Favicon', 'pacific' ),
		'section' => 'title_tagline',
		'settings' => 'pacific_theme_options[favicon]',
	) ) );

	if ( class_exists( 'WP_Customize_Panel' ) ) {
		$wp_customize->add_panel( 'panel_design', array(
			'priority' => 29,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Design', 'pacific' )
		) );
			
		$wp_customize->get_section('colors')->panel = 'panel_design';
		
		# Color
		$wp_customize->add_setting( 'pacific_theme_options[sidebar_background_color]', array(
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'default' => '#333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_background_color', array(
			'label' => __( 'Sidebar Background Color', 'pacific' ),
			'section' => 'colors',
			'settings' => 'pacific_theme_options[sidebar_background_color]',
		) ) );
		
		$wp_customize->get_section('background_image')->panel = 'panel_design';
		# Background Size
		$wp_customize->add_setting( 'pacific_theme_options[background_size]', array(
			'default' => 'cover',
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'sanitize_callback' => 'pacific_sanitize_background_size',
		) );
		$wp_customize->add_control( 'background_size', array(
			'settings' => 'pacific_theme_options[background_size]',
			'label' => __( 'Background size', 'pacific' ),
			'section' => 'background_image',
			'type' => 'radio',
			'choices' => array(
				'cover' => __( 'Cover', 'pacific' ),
				'contain' => __( 'Contain', 'pacific' ),
				'initial' => __( 'Initial', 'pacific' ),
			),
		) );
		# Typography
		$wp_customize->add_section( 'typography', array(
			'title' => __( 'Typography', 'pacific' ),
			'priority' => 50,
			'panel' => 'panel_design'
		) );
		# Global Font Family
		$wp_customize->add_setting( 'pacific_theme_options[global_font_family]', array(
			'default' => 'Roboto:400,700',
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'sanitize_callback' => 'pacific_sanitize_global_font_family',
		) );
		$wp_customize->add_control( 'global_font_family', array(
			'settings' => 'pacific_theme_options[global_font_family]',
			'label' => __( 'Global Font Family', 'pacific' ),
			'section' => 'typography',
			'type' => 'select',
			'choices' => array(
				'Roboto:400,700' => 'Roboto',
				'Lato:400,700' => 'Lato',
				'Droid+Sans:400,700' => 'Droid Sans',
				'Open+Sans:400,700' => 'Open Sans',
				'PT+Sans:400,700' => 'PT Sans',
				'Source+Sans+Pro:400,700' => 'Source Sans Pro',
			),
		) );
		# Heading Font Family
		$wp_customize->add_setting( 'pacific_theme_options[heading_font_family]', array(
			'default' => 'Roboto+Slab',
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'sanitize_callback' => 'pacific_sanitize_heading_font_family',
		) );
		$wp_customize->add_control( 'heading_font_family', array(
			'settings' => 'pacific_theme_options[heading_font_family]',
			'label' => __( 'Heading Font Family', 'pacific' ),
			'section' => 'typography',
			'type' => 'select',
			'choices' => array(
				'Roboto+Slab' => 'Roboto Slab',
				'Droid+Serif' => 'Droid Serif',
				'Lora' => 'Lora',
				'Bitter' => 'Bitter',
				'Arvo' => 'Arvo',
				'PT+Serif' => 'PT Serif',
				'Rokkitt' => 'Rokkitt',
				'Open+Sans+Condensed' => 'Open Sans Condensed',
			),
		) );
		# Sub-Heading Font Family
		$wp_customize->add_setting( 'pacific_theme_options[sub_heading_font_family]', array(
			'default' => 'Roboto+Condensed',
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'sanitize_callback' => 'pacific_sanitize_subheading_font_family',
		) );
		$wp_customize->add_control( 'sub_heading_font_family', array(
			'settings' => 'pacific_theme_options[sub_heading_font_family]',
			'label' => __( 'Sub-Heading Font Family', 'pacific' ),
			'section' => 'typography',
			'type' => 'select',
			'choices' => array(
				'Roboto+Condensed' => 'Roboto Condensed',
				'Open+Sans+Condensed' => 'Open Sans Condensed',
				'PT+Sans+Narrow' => 'PT Sans Narrow',
				'Dosis' => 'Dosis',
				'Abel' => 'Abel',
				'News+Cycle' => 'News Cycle',
			),
		) );
	} else {
		# Color
		$wp_customize->add_setting( 'pacific_theme_options[sidebar_background_color]', array(
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'default' => '#333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_background_color', array(
			'label' => __( 'Sidebar Background Color', 'pacific' ),
			'section' => 'colors',
			'settings' => 'pacific_theme_options[sidebar_background_color]',
		) ) );
		# Background Size
		$wp_customize->add_setting( 'pacific_theme_options[background_size]', array(
			'default' => 'cover',
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'sanitize_callback' => 'pacific_sanitize_background_size',
		) );
		$wp_customize->add_control( 'background_size', array(
			'settings' => 'pacific_theme_options[background_size]',
			'label' => __( 'Background size', 'pacific' ),
			'section' => 'background_image',
			'type' => 'radio',
			'choices' => array(
				'cover' => __( 'Cover', 'pacific' ),
				'contain' => __( 'Contain', 'pacific' ),
				'initial' => __( 'Initial', 'pacific' ),
			),
		) );
		# Typography
		$wp_customize->add_section( 'typography', array(
			'title' => __( 'Typography', 'pacific' ),
			'priority' => 50,
		) );
		# Global Font Family
		$wp_customize->add_setting( 'pacific_theme_options[global_font_family]', array(
			'default' => 'Roboto',
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'sanitize_callback' => 'pacific_sanitize_global_font_family',
		) );
		$wp_customize->add_control( 'global_font_family', array(
			'settings' => 'pacific_theme_options[global_font_family]',
			'label' => __( 'Global Font Family', 'pacific' ),
			'section' => 'typography',
			'type' => 'select',
			'choices' => array(
				'Roboto:400,700' => 'Roboto',
				'Lato:400,700' => 'Lato',
				'Droid+Sans:400,700' => 'Droid Sans',
				'Open+Sans:400,700' => 'Open Sans',
				'PT+Sans:400,700' => 'PT Sans',
				'Source+Sans+Pro:400,700' => 'Source Sans Pro',
			),
		) );
		# Heading Font Family
		$wp_customize->add_setting( 'pacific_theme_options[heading_font_family]', array(
			'default' => 'Roboto Slab',
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'sanitize_callback' => 'pacific_sanitize_heading_font_family',
		) );
		$wp_customize->add_control( 'heading_font_family', array(
			'settings' => 'pacific_theme_options[heading_font_family]',
			'label' => __( 'Heading Font Family', 'pacific' ),
			'section' => 'typography',
			'type' => 'select',
			'choices' => array(
				'Roboto+Slab' => 'Roboto Slab',
				'Droid+Serif' => 'Droid Serif',
				'Lora' => 'Lora',
				'Bitter' => 'Bitter',
				'Arvo' => 'Arvo',
				'PT+Serif' => 'PT Serif',
				'Rokkitt' => 'Rokkitt',
				'Open+Sans+Condensed' => 'Open Sans Condensed',
			),
		) );
		# Sub-Heading Font Family
		$wp_customize->add_setting( 'pacific_theme_options[sub_heading_font_family]', array(
			'default' => 'Roboto Condensed',
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'sanitize_callback' => 'pacific_sanitize_subheading_font_family',
		) );
		$wp_customize->add_control( 'sub_heading_font_family', array(
			'settings' => 'pacific_theme_options[sub_heading_font_family]',
			'label' => __( 'Sub-Heading Font Family', 'pacific' ),
			'section' => 'typography',
			'type' => 'select',
			'choices' => array(
				'Roboto+Condensed' => 'Roboto Condensed',
				'Open+Sans+Condensed' => 'Open Sans Condensed',
				'PT+Sans+Narrow' => 'PT Sans Narrow',
				'Dosis' => 'Dosis',
				'Abel' => 'Abel',
				'News+Cycle' => 'News Cycle',
			),
		) );
	}

	# Single Post Settings
	$wp_customize->add_section( 'layout_single', array(
		'title' => __( 'Single Post', 'pacific' ),
		'priority' => 110,
	) );

	# Single Featured Image
	$wp_customize->add_setting( 'pacific_theme_options[single_featured_image]', array(
		'default' => '1',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'pacific_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'single_featured_image', array(
		'label' => __( 'Hide Featured Image', 'pacific' ),
		'section' => 'layout_single',
		'settings' => 'pacific_theme_options[single_featured_image]',
		'type' => 'checkbox',
	) );

	# Single Metadata
	$wp_customize->add_setting( 'pacific_theme_options[single_metadata]', array(
		'default' => '1',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'pacific_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'single_metadata', array(
		'label' => __( 'Hide Metadata', 'pacific' ),
		'section' => 'layout_single',
		'settings' => 'pacific_theme_options[single_metadata]',
		'type' => 'checkbox',
	) );

	# Single Author Box
	$wp_customize->add_setting( 'pacific_theme_options[single_author_box]', array(
		'default' => '1',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'pacific_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'single_author_box', array(
		'label' => __( 'Hide Author Box', 'pacific' ),
		'section' => 'layout_single',
		'settings' => 'pacific_theme_options[single_author_box]',
		'type' => 'checkbox',
	) );

	# Archive Settings
	$wp_customize->add_section( 'layout_archive', array(
		'title' => __( 'Blog Index &amp; Archive Pages', 'pacific' ),
		'priority' => 100,
	) );

	# Archive Featured Image
	$wp_customize->add_setting( 'pacific_theme_options[archive_featured_image]', array(
		'default' => '1',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'pacific_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'archive_featured_image', array(
		'label' => __( 'Hide Featured Image', 'pacific' ),
		'section' => 'layout_archive',
		'settings' => 'pacific_theme_options[archive_featured_image]',
		'type' => 'checkbox',
	) );

	# Archive Metadata
	$wp_customize->add_setting( 'pacific_theme_options[archive_metadata]', array(
		'default' => '1',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'pacific_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'archive_metadata', array(
		'label' => __( 'Hide Metadata', 'pacific' ),
		'section' => 'layout_archive',
		'settings' => 'pacific_theme_options[archive_metadata]',
		'type' => 'checkbox',
	) );

	# Archive Content
	$wp_customize->add_setting( 'pacific_theme_options[archive_content]', array(
		'default' => '1',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'pacific_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'archive_content', array(
		'label' => __( 'Show Post Excerpt', 'pacific' ),
		'section' => 'layout_archive',
		'settings' => 'pacific_theme_options[archive_content]',
		'type' => 'checkbox',
	) );
}
add_action( 'customize_register', 'pacific_customize_register' );

/**
 * Sanitize Settings
 */
function pacific_sanitize_site_title_font_family( $site_title_font_family ) {
	if ( ! in_array( $site_title_font_family, array( 'Amatic+SC', 'Yesteryear', 'Pacifico', 'Dancing+Script', 'Satisfy', 'Handlee', 'Lobster', 'Lobster+Two' ) ) ) {
		$site_title_font_family = 'Yesteryear';
	}

	return $site_title_font_family;
}

function pacific_sanitize_global_font_family( $global_font_family ) {
	if ( ! in_array( $global_font_family, array( 'Roboto:400,700', 'Lato:400,700', 'Droid+Sans:400,700', 'Open+Sans:400,700', 'PT+Sans:400,700', 'Source+Sans+Pro:400,700' ) ) ) {
		$global_font_family = 'Roboto:400,700';
	}

	return $global_font_family;
}

function pacific_sanitize_heading_font_family( $heading_font_family ) {
	if ( ! in_array( $heading_font_family, array( 'Roboto+Slab', 'Droid+Serif', 'Lora', 'Bitter', 'Arvo', 'PT+Serif', 'Rokkitt', 'Open+Sans+Condensed' ) ) ) {
		$heading_font_family = 'Roboto+Slab';
	}

	return $heading_font_family;
}

function pacific_sanitize_subheading_font_family( $subheading_font_family ) {
	if ( ! in_array( $subheading_font_family, array( 'Roboto+Condensed', 'Open+Sans+Condensed', 'PT+Sans+Narrow', 'Dosis', 'Abel', 'News+Cycle' ) ) ) {
		$subheading_font_family = 'Roboto+Condensed';
	}

	return $subheading_font_family;
}

function pacific_sanitize_checkbox( $input ) {
	if ( 1 == $input ) {
		return 1;
	} else {
		return '';
	}
}

function pacific_sanitize_header_display( $header_display ) {
	if ( ! in_array( $header_display, array( 'site_title', 'site_logo', 'both_title_logo' ) ) ) {
		$header_display = 'site_title';
	}

	return $header_display;
}

function pacific_sanitize_background_size( $background_size ) {
	if ( ! in_array( $background_size, array( 'cover', 'contain', 'initial' ) ) ) {
		$background_size = 'cover';
	}

	return $background_size;
}

/**
 * Get Theme Options
 */
function pacific_get_theme_option( $option_name, $default = '' ) {
	$options = get_option( 'pacific_theme_options' );

	if ( isset( $options[ $option_name ] ) ) {
		return $options[ $option_name ];
	}

	return $default;
}

/**
 * Change Favicon
 */
function pacific_favicon() {
	$icon_path = esc_url( pacific_get_theme_option( 'favicon' ) );

	if ( ! empty( $icon_path ) ) {
		echo '<link type="image/x-icon" href="' . esc_attr( $icon_path ) . '" rel="shortcut icon">';
	}
}
add_action( 'wp_head', 'pacific_favicon' );

/**
 * Custom CSS
 */
function pacific_custom_css() {
	echo '<style type="text/css">';
	$custom_style = '';
	$sidebar_background_color = pacific_get_theme_option( 'sidebar_background_color' );

	if ( ! empty( $sidebar_background_color ) ) {
		$custom_style .= '#page:before, .sidebar-offcanvas, #secondary { background-color: ' . $sidebar_background_color . '; }';
		$custom_style .= '@media (max-width: 1199px) { #page > .container { background-color: ' . $sidebar_background_color . '; } }';
	}

	$background_size = pacific_get_theme_option( 'background_size' );

	if ( ! empty( $background_size ) ) {
		$custom_style .= 'body { background-size: ' . $background_size . '; }';
	}

	echo esc_attr( $custom_style );
	echo '</style>';
}
add_action( 'wp_head', 'pacific_custom_css' );

/**
 * Custom Font
 */
function pacific_custom_font() {
	$site_title_font_family = pacific_get_theme_option( 'site_title_font_family', 'Amatic+SC' );
	$global_font_family = pacific_get_theme_option( 'global_font_family', 'Roboto:400,700' );
	$heading_font_family = pacific_get_theme_option( 'heading_font_family', 'Roboto+Slab' );
	$sub_heading_font_family = pacific_get_theme_option( 'sub_heading_font_family', 'Roboto+Condensed' );

	echo '<style type="text/css">';
		echo '#masthead .site-title {font-family:' . esc_attr( str_replace( array( '+', ':400,700'), array( ' ', '' ), $site_title_font_family ) ) . '}';
		echo 'body {font-family:' . esc_attr( str_replace( array( '+', ':400,700'), array( ' ', ' ' ), $global_font_family ) ) . '}';
		echo 'h1,h2,h3,h4,h5,h6 {font-family:' . esc_attr( str_replace( array( '+', ':400,700'), array( ' ', ' ' ), $heading_font_family ) ) . '}';
		echo '#masthead .site-description, .hentry .entry-meta {font-family:' . esc_attr( str_replace( array( '+', ':400,700'), array( ' ', ' ' ), $sub_heading_font_family ) ) . '}';
	echo '</style>';
}
add_action( 'wp_head', 'pacific_custom_font' );

/**
 * Get Custom Fonts URL
 */
function pacific_fonts_url() {
	$fonts_url = '';
	$fonts = array();
	$fonts[] = pacific_get_theme_option( 'site_title_font_family', 'Amatic+SC' );
	$fonts[] = pacific_get_theme_option( 'global_font_family', 'Roboto:400,700' );
	$fonts[] = pacific_get_theme_option( 'heading_font_family', 'Roboto+Slab' );
	$fonts[] = pacific_get_theme_option( 'sub_heading_font_family', 'Roboto+Condensed' );

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => esc_attr( implode( '%7C', $fonts ) )
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Display Logo
 */
function pacific_logo() {
	$header_display = pacific_get_theme_option( 'header_display', 'site_title' );

	if ( 'both_title_logo' === $header_display ) {
		$header_class = 'display-title-logo';
	} else if ( 'site_logo' === $header_display ) {
		$header_class = 'display-logo';
	} else {
		$header_class = 'display-title';
	}

	$logo = esc_url( pacific_get_theme_option( 'logo' ) );
	$tagline = get_bloginfo( 'description' );

	echo '<h1 class="site-title ' . esc_attr( $header_class ) . '"><a href="' . esc_url( home_url( '/' ) ) . '" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">';

	if ( 'display-title' !== $header_class ) {
		echo '<img itemprop="primaryImageofPage" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" src="' . esc_attr( $logo ) . '" />';
	}
	if ( 'display-logo' !== $header_class ) {
		echo '<span itemprop="name">' . esc_attr( get_bloginfo( 'name' ) ) . '</span>';
	}

	echo '</a></h1>';

	if ( $tagline ) {
		echo '<h2 itemprop="description" class="site-description">' . esc_attr( $tagline ) . '</h2>';
	}
}
