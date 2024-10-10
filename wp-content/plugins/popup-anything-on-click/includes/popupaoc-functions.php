<?php
/**
 * Plugin generic functions file
 *
 * @package Popup Anything On Click
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Set Settings Default Option Page
 * 
 * Handles to return all settings value
 *
 * @package Popup Anything On Click
 * @since 1.6.1
 */
function popupaoc_default_settings() {

	global $popupaoc_options;

	$default_options = array(
						'add_js'				=> '',
						'enable'				=> 1,
						'cookie_prefix'			=> 'paoc_popup',
						'welcome_popup'			=> '',
						'welcome_display_in'	=> array(),
					);

	$default_options = apply_filters('popupaoc_default_settings', $default_options );

	// Update default options
	update_option( 'popupaoc_options', $default_options );

	// Overwrite global variable when option is update
	$popupaoc_options = popupaoc_get_settings();
}

/**
 * Get Settings From Option Page
 * 
 * Handles to return all settings value
 * 
 * @package Popup Anything On Click
 * @since 1.6.1
 */
function popupaoc_get_settings() {
	
	$options    = get_option('popupaoc_options');
	$settings   = is_array( $options ) ? $options : array();

	return $settings;
}

/**
 * Get an option
 * Looks to see if the specified setting exists, returns default if not
 * 
 * @package Popup Anything On Click
 * @since 1.6.1
 */
function popupaoc_get_option( $key = '', $default = false ) {

	global $popupaoc_options;

	$value = ! empty( $popupaoc_options[ $key ] ) ? $popupaoc_options[ $key ] : $default;
	$value = apply_filters( 'popupaoc_get_option', $value, $key, $default );

	return apply_filters( 'popupaoc_get_option_' . $key, $value, $key, $default );
}

/**
 * Escape Tags & Slashes
 *
 * Handles escapping the slashes and tags
 *
 * @package Popup Anything on Click
 * @since 1.0
 */
function popupaoc_esc_attr( $data ) {
	return esc_attr( stripslashes( $data ) );
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * 
 * @package Popup Anything on Click
 * @since 1.0
 */
function popupaoc_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'popupaoc_clean', $var );
	} else {
		$data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		return wp_unslash($data);
	}
}

/**
 * Sanitize number value and return fallback value if it is blank
 * 
 * @package Popup Anything on Click
 * @since 1.0
 */
function popupaoc_clean_number( $var, $fallback = null, $type = 'int' ) {

	$var = trim( $var );
	$var = is_numeric( $var ) ? $var : 0;

	if ( $type == 'number' ) {
		$data = intval( $var );
	} else if ( $type == 'abs' ) {
		$data = abs( $var );
	} else if ( $type == 'float' ) {
		$data = (float)$var;
	} else {
		$data = absint( $var );
	}

	return ( empty( $data ) && isset( $fallback ) ) ? $fallback : $data;
}

/**
 * Sanitize URL
 * 
 * @package Popup Anything on Click
 * @since 1.0
 */
function popupaoc_clean_url( $url ) {
	return esc_url_raw( trim( $url ) );
}

/**
 * Sanitize Hex Color
 * 
 * @package Popup Anything on Click
 * @since 1.2.2
 */
function popupaoc_clean_color( $color, $fallback = null ) {

	if ( false === strpos( $color, 'rgba' ) ) {
		
		$data = sanitize_hex_color( $color );

	} else {

		$red    = 0;
		$green  = 0;
		$blue   = 0;
		$alpha  = 0.5;

		// By now we know the string is formatted as an rgba color so we need to further sanitize it.
		$color = str_replace( ' ', '', $color );
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
		$data = 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
	}

	return ( empty( $data ) && $fallback ) ? $fallback : $data;
}

/**
 * Allow Valid Html Tags
 * It will sanitize HTML (strip script and style tags)
 *
 * @package Popup Anything on Click
 * @since 1.0
 */
function popupaoc_clean_html( $data = array() ) {

	if ( is_array( $data ) ) {

		$data = array_map( 'paoc_pro_clean_html', $data );

	} elseif ( is_string( $data ) ) {
		$data = trim( $data );
		$data = wp_filter_post_kses( $data );
	}

	return $data;
}

/**
 * Strip Html Tags
 * It will sanitize text input (strip html tags, and escape characters)
 * 
 * @package Popup Anything on Click
 * @since 1.0
 */
function popupaoc_nohtml_kses( $data = array() ) {

	if ( is_array( $data ) ) {

	$data = array_map('popupaoc_nohtml_kses', $data);

	} elseif ( is_string( $data ) ) {
		$data = trim( $data );
		$data = wp_filter_nohtml_kses( $data );
	}

	return $data;
}

/**
 * Sanitize Multiple HTML class
 * 
 * @package Popup Anything on Click
 * @since 2.0.2
 */
function popupaoc_sanitize_html_classes( $classes, $sep = " " ) {
	$return = "";

	if( $classes && ! is_array( $classes ) ) {
		$classes = explode( $sep, $classes );
	}

	if( ! empty( $classes ) ) {
		foreach( $classes as $class ){
			$return .= sanitize_html_class( $class ) . " ";
		}
		$return = trim( $return );
	}

	return $return;
}

/**
 * Function to add array after specific key
 * 
 * @package Popup Anything on Click
 * @since 1.0
 */
function popupaoc_add_array( &$array, $value, $index, $from_last = false ) {

	if( is_array( $array ) && is_array( $value ) ) {

		if( $from_last ) {
			$total_count    = count( $array );
			$index          = ( ! empty( $total_count ) && ( $total_count > $index ) ) ? ( $total_count - $index ): $index;
		}
		
		$split_arr  = array_splice( $array, max( 0, $index ) );
		$array      = array_merge( $array, $value, $split_arr );
	}
	
	return $array;
}

/**
 * Function to get unique value number
 * 
 * @package Popup Anything on Click
 * @since 1.0
 */
function popupaoc_get_unique() {
	static $unique = 0;
	$unique++;

	return $unique;
}

/**
 * Function to get popup appearance options
 * 
 * @since 2.0
 */
function popupaoc_when_appear_options() {

	$popup_appear = array(
						'page_load'		=>  esc_html__('Page Load', 'popup-anything-on-click'),
						'simple_link'	=>  esc_html__('Simple Link', 'popup-anything-on-click'),
						'image'			=>  esc_html__('Image Click', 'popup-anything-on-click'),
						'button'		=>  esc_html__('Button Click', 'popup-anything-on-click'),
						'inactivity'	=>  esc_html__('After X Second of Inactivity (PRO)', 'popup-anything-on-click'),
						'scroll'		=>  esc_html__('When Page Scroll Down (PRO)', 'popup-anything-on-click'),
						'scroll_up'		=>  esc_html__('When Page Scroll UP (PRO)', 'popup-anything-on-click'),
						'exit'			=>  esc_html__('Exit Intent (PRO)', 'popup-anything-on-click'),
						'html_element'	=>  esc_html__('HTML Element Click (PRO)', 'popup-anything-on-click'),
					);

	return apply_filters('popuppaoc_when_appear_options', $popup_appear );
}

/**
 * When popup goal function
 * 
 * @since 2.0
 */
function popupaoc_popup_goals() {

	$popup_goals = array(
						'announcement'	=>	array(
												'name'	=> esc_html__('Announcement', 'popup-anything-on-click'),
												'icon'	=> "dashicons dashicons-megaphone",
											),
						'email-lists'	=>	array(
												'name'	=> esc_html__('Collect Lead', 'popup-anything-on-click'),
												'icon'	=> "dashicons dashicons-email-alt",
											),
						'target-url'	=>	array(
												'name'	=> esc_html__('Target URL', 'popup-anything-on-click'),
												'icon'	=> "dashicons dashicons-admin-links",
											),
						'phone-calls'	=>	array(
												'name'	=> esc_html__('Phone Calls', 'popup-anything-on-click'),
												'icon'	=> "dashicons dashicons-phone",
											),
					);

	return apply_filters('popupaoc_popup_goals', $popup_goals );
}

/**
 * When popup type function
 * 
 * @since 2.0
 */
function popupaoc_popup_types() {

	$popup_types = array(
						'modal'				=>	array(
													'name'	=> esc_html__('Modal Popup', 'popup-anything-on-click'),
													'icon'	=> "dashicons dashicons-admin-page",
												),
						'bar'				=>	array(
													'name'	=> esc_html__('Bar', 'popup-anything-on-click'),
													'icon'	=> "dashicons dashicons-schedule",
												),
						'push-notification'	=>	array(
													'name'	=> esc_html__('Push Notification', 'popup-anything-on-click'),
													'icon'	=> "dashicons dashicons-admin-comments",
												),
						'slide-in'			=>	array(
													'name'	=> esc_html__('Slide In', 'popup-anything-on-click'),
													'icon'	=> "dashicons dashicons-align-right",
												),
					);

	return apply_filters('popupaoc_popup_types', $popup_types );
}

/**
 * Function to get popup effects
 * 
 * @package Popup Anything on Click
 * @since 1.0
 */
function popupaoc_popup_effects() {
	$popup_effect = array(
						'fadein'		=> esc_html__('Fadein', 'popup-anything-on-click'),
						'slide'			=> esc_html__('Slide', 'popup-anything-on-click'),
						'newspaper'		=> esc_html__('Newspaper', 'popup-anything-on-click'),
						'superscaled'	=> esc_html__('Super Scaled', 'popup-anything-on-click'),
						'corner'		=> esc_html__('Corner', 'popup-anything-on-click'),
						'scale'			=> esc_html__('Scale', 'popup-anything-on-click'),
						'slidetogether'	=> esc_html__('Slide Together', 'popup-anything-on-click'),
					);
	return apply_filters('popupaoc_popup_effects', $popup_effect );
}

/**
 * Function to get modal & push notification popup position options
 * 
 * @since 1.0
 */
function popupaoc_position_options() {

	$position_option = array(
							'left-top'		=> esc_html__('Left Top', 'popup-anything-on-click'),
							'left-center'	=> esc_html__('Left Center', 'popup-anything-on-click'),
							'left-bottom'	=> esc_html__('Left Bottom', 'popup-anything-on-click'),
							'center-top'	=> esc_html__('Center Top', 'popup-anything-on-click'),
							'center-center'	=> esc_html__('Center Center', 'popup-anything-on-click'),
							'center-bottom'	=> esc_html__('Center Bottom', 'popup-anything-on-click'),
							'right-top'		=> esc_html__('Right Top', 'popup-anything-on-click'),
							'right-center'	=> esc_html__('Right Center', 'popup-anything-on-click'),
							'right-bottom'	=> esc_html__('Right Bottom', 'popup-anything-on-click'),
						);
	return apply_filters('popupaoc_position_options', $position_option );
}

/**
 * Function to get time options
 * 
 * @since 2.0
 */
function popupaoc_time_options() {

	$time_options = array(	
					'day'		=> esc_html__('Days', 'popup-anything-on-click'),
					'hour'		=> esc_html__('Hours (PRO)', 'popup-anything-on-click'),
					'minutes'	=> esc_html__('Minutes (PRO)', 'popup-anything-on-click'),
				);
	return apply_filters( 'popupaoc_time_options', $time_options );
}

/**
 * Function to enqueue public script at last
 * 
 * @package Popup Anything on Click
 * @since 2.0
 */
function popupaoc_enqueue_script() {

	if( wp_script_is( 'popupaoc-public-js', 'enqueued' ) ) {

		// Dequeue Public JS
		wp_dequeue_script( 'popupaoc-public-js' );

		// Enqueue Public JS
		wp_enqueue_script('popupaoc-public-js');
	}
}

/**
 * Function to display message, norice etc
 * 
 * @package Popup Anything on Click
 * @since 2.0
 */
function popupaoc_display_message( $type = 'update', $msg = '', $echo = 1 ) {

	switch ( $type ) {
		case 'reset':
			$msg = !empty( $msg ) ? $msg : __( 'All settings reset successfully.', 'popup-anything-on-click');
			$msg_html = '<div id="message" class="updated notice notice-success is-dismissible">
							<p><strong>' . $msg . '</strong></p>
						</div>';
			break;

		case 'error':
			$msg = !empty( $msg ) ? $msg : __( 'Sorry, Something happened wrong.', 'popup-anything-on-click');
			$msg_html = '<div id="message" class="error notice is-dismissible">
							<p><strong>' . $msg . '</strong></p>
						</div>';
			break;

		default:
			$msg = !empty( $msg ) ? $msg : __('Your changes saved successfully.', 'popup-anything-on-click');
			$msg_html = '<div id="message" class="updated notice notice-success is-dismissible">
							<p><strong>'. $msg .'</strong></p>
						</div>';
			break;
	}

	if( $echo ) {
		echo $msg_html;
	} else {
		return $msg_html;
	}
}

/**
 * Function to get popup preview HTML
 * 
 * @since 2.0
 */
function popupaoc_preview_popup( $args = array() ) {

	$default_args = array(
							'title' 		=> '',
							'preview_link'	=> '',
							'info'			=> '',
						);
	$args = wp_parse_args( $args, $default_args );
?>
	<div class="paoc-popup-modal paoc-cnt-wrap">
		<div class="paoc-popup-modal-act-btn-wrp">
			<span class="paoc-popup-modal-act-btn paoc-popup-modal-info" title="<?php echo esc_html__("Note: Preview will be displayed according to responsive layout mode. Live preview may display differently when added to your page based on inheritance from some styles.", 'popup-anything-on-click') ."<br/><br/>". $args['info']; ?>"><i class="dashicons dashicons-info"></i></span>
			<span class="paoc-popup-modal-act-btn paoc-popup-modal-close paoc-popup-close" title="<?php esc_html_e('Close', 'popup-anything-on-click'); ?>"><i class="dashicons dashicons-no-alt"></i></span>
		</div>
		<div class="paoc-popup-modal-title-wrp">
			<span class="paoc-popup-modal-title"><?php echo $args['title']; ?></span>
		</div>
		<div class="paoc-popup-modal-cnt">
			<iframe src="about:blank" data-src="<?php echo esc_url( $args['preview_link'] ); ?>" class="paoc-preview-frame" name="paoc_preview_frame" scrolling="auto" frameborder="0"></iframe>
			<div class="paoc-popup-modal-loader"></div>
		</div>
	</div>
	<div class="paoc-popup-modal-overlay"></div>
<?php
}

/**
 * Popup Preview Data
 * 
 * @since 2.0
 */
function popupaoc_preview_data( $post_data ) {

	$prefix			= POPUPAOC_META_PREFIX;
	$show_credit	= isset( $post_data[ $prefix.'advance' ]['show_credit'] ) ? $post_data[ $prefix.'advance' ]['show_credit'] : '';

	unset( $post_data[ $prefix.'advance'] );

	$post_data[ $prefix.'advance' ]['show_credit']	= $show_credit;
	$post_data[ $prefix.'popup_appear' ]			= 'page_load';
	$post_data[ $prefix.'behaviour' ]['open_delay'] = '';
	$post_data[ $prefix.'behaviour']['disappear']	= '';

	return $post_data;
}

/**
 * Function to get current page URL
 * 
 * @since 2.0
 */
function popupaoc_get_current_page_url( $args = array() ) {

	$curent_page_url = is_ssl() ? 'https://' : 'http://';

	// Check server port is not 80
	if ( $_SERVER["SERVER_PORT"] != "80" ) {
		$curent_page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$curent_page_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}

	// Remove Query Args
	if( isset( $args['remove_args'] ) ) {
		$curent_page_url = remove_query_arg( $args['remove_args'], $curent_page_url );
	}

	return apply_filters( 'popupaoc_get_current_page_url', $curent_page_url );
}

/**
 * Function to get popup appear meta on suggestion type
 * 
 * @package Popup Anything on Click
 * @since 2.0
 */
function popupaoc_sugg_meta_data( $appear_meta ) {

	$meta_data = array();

	// Page_load, Scroll, Inactivity appear meta
	if( $appear_meta == 'welcome' ) {
		$meta_data	= array(
							'relation' => 'OR',
							array(
								'key'	=> '_aoc_popup_appear',
								'value'	=> 'page_load',
							),
						);
	}

	return apply_filters( 'popupaoc_sugg_meta_data', $meta_data );
}

/**
 * Function to get registered post types
 * 
 * @package Popup Anything on Click
 * @since 2.0
 */
function popupaoc_get_post_types( $args = array(), $exclude_post = array() ) {     

	$post_types 		= array();
	$args       		= ( ! empty( $args ) && is_array( $args ) ) ? $args : array( 'public' => true );
	$default_post_types = get_post_types( $args, 'name' );
	$exclude_post 		= ! empty( $exclude_post ) ? (array) $exclude_post : array();

	if( ! empty( $default_post_types ) ) {
		foreach ($default_post_types as $post_type_key => $post_data) {
			if( ! in_array( $post_type_key, $exclude_post ) ) {
				$post_types[$post_type_key] = $post_data->label;
			}
		}
	}

	return apply_filters('popupaoc_get_post_types', $post_types );
}

/**
 * Function to display location.
 * 
 * @package Popup Anything on Click
 * @since 2.0
 */
function popupaoc_display_locations( $type = 'all', $all = true, $exclude = array() ) {

	$locations		= array();
	$exclude		= array_merge( array('attachment', 'revision', 'nav_menu_item'), $exclude);
	$all_post_types	= popupaoc_get_post_types();
	$post_types		= array();

	foreach ( $all_post_types as $post_type => $post_data ) {
		if( $all ) {
			$type_label = esc_html__( 'All', 'popup-anything-on-click' ) .' '. $post_data;
		} else {
			$type_label = $post_data;
		}

		$locations[ $post_type ] = $type_label;
	}

	if ( 'global' != $type ) {
		
		$glocations = array(
			'is_front_page'	=> esc_html__( 'Front Page', 'popup-anything-on-click' ),
			'is_search'		=> esc_html__( 'Search Results', 'popup-anything-on-click' ),
			'is_404'		=> esc_html__( '404 Error Page', 'popup-anything-on-click' ),
			'is_archive'	=> esc_html__( 'All Archives', 'popup-anything-on-click' ),
			'all'			=> esc_html__( 'Whole Site', 'popup-anything-on-click' ),
		);

		$locations = array_merge( $locations, $glocations );	
	}

	// Exclude some post type or location
	if( ! empty( $exclude ) ) {
		foreach ($exclude as $location_key) {
			unset( $locations[ $location_key ] );
		}
	}

	return $locations;
}

/**
 * Get post meta
 * If preview is there then get run time post meta
 * 
 * @since 2.0
 */
function popupaoc_get_post_status( $post_id ) {

	global $paoc_preview;

	$post_status = get_post_status( $post_id );

	// If popup preview is there
	if( $paoc_preview && ! empty( $_POST['paoc_preview_form_data'] ) ) {
		$post_status = 'publish';
	}

	return $post_status;
}

/**
 * Get popup default meta data
 * 
 * @since 2.0
 */
function popupaoc_popup_default_meta() {

	$prefix = POPUPAOC_META_PREFIX;

	$default_meta = array(
		'content'			=> __('Primary Content – Primary Content Goes Here.', 'popup-anything-on-click'),
		$prefix.'behaviour'	=> array(
								'close_overlay'	=> 1,
							),
		$prefix.'content'	=> array(
									'main_heading'		=> __('Main Heading Goes Here', 'popup-anything-on-click'),
									'sub_heading'		=> __('Sub Heading Goes Here', 'popup-anything-on-click'),
									'cust_close_txt'	=> __('No, thank you. I do not want.', 'popup-anything-on-click'),
									'security_note'		=> __('100% secure your website.', 'popup-anything-on-click'),
								),
		$prefix.'advance'	=> array(
									'show_credit' => 1,
								),
	);

	return apply_filters( 'popupaoc_popup_default_meta', $default_meta );
}

/**
 * Get post meta
 * If preview is there then get run time post meta
 * 
 * @since 2.0
 */
function popupaoc_get_meta( $post_id, $meta_key, $flag = true ) {

	global $pagenow, $paoc_preview;

	$post_meta = get_post_meta( $post_id, $meta_key, $flag );

	// If popup preview is there
	if( $paoc_preview && ! empty( $_POST['paoc_preview_form_data'] ) ) {

		$form_data = $_POST['paoc_preview_form_data'];
		$post_meta = isset( $form_data[ $meta_key ] ) ? stripslashes_deep( $form_data[ $meta_key ] ) : '';

	} else {

		$default_meta	= popupaoc_popup_default_meta();
		$post_meta		= ( $pagenow == 'post-new.php' && isset( $default_meta[ $meta_key ] ) ) ? $default_meta[ $meta_key ] : $post_meta;
	}

	return $post_meta;
}

/**
 * Function to return wheather popup is active or not.
 * 
 * @since 2.0
 */
function popupaoc_check_active( $glob_locs = array() ) {

	global $post, $paoc_popup_active;

	$prefix 			= POPUPAOC_META_PREFIX;
	$paoc_post_type		= isset( $post->post_type ) ? $post->post_type : '';
	$custom_location	= false;
	$paoc_popup_active	= false;

	// Whole Website
	if( ! empty( $glob_locs['all'] ) ) {
		$paoc_popup_active = true;
	}

	// Post Type Wise
	if( ! empty( $glob_locs[ $paoc_post_type ] ) && is_singular() ) {
		$paoc_popup_active = true;
	}

	// Checking custom locations
	if( is_search() ) {
		$custom_location = "is_search";
	} else if( is_404() ) {
		$custom_location = "is_404";
	} else if( is_archive() ) {
		$custom_location = "is_archive";
	} else if( is_front_page() ) {
		$custom_location = "is_front_page";
	}

	if( $custom_location && ! empty( $glob_locs[ $custom_location ] ) ) {
		$paoc_popup_active = true;
	}

	return $paoc_popup_active;
}

/**
 * Function to render popup content.
 * An alternate solution of apply_filter('the_content')
 *
 * Prioritize the function in a same order apply_filter('the_content') wp-includes/default-filters.php
 * 
 * @since 2.0
 */
function popupaoc_render_popup_content( $popup_content = '' ) {

	if ( empty( $popup_content ) ) {
		return false;
	}

	global $wp_embed;

	$popup_content		= $wp_embed->run_shortcode( $popup_content );
	$popup_content		= $wp_embed->autoembed( $popup_content );
	$popup_content		= wptexturize( $popup_content );
	$popup_content		= wpautop( $popup_content );
	$popup_content		= shortcode_unautop( $popup_content );

	// Since Version 5.5.0
	if ( function_exists('wp_filter_content_tags') ) {
		$popup_content = wp_filter_content_tags( $popup_content );
	}

	// Since Version 5.7.0
	if ( function_exists( 'wp_replace_insecure_home_url' ) ) {
		$popup_content = wp_replace_insecure_home_url( $popup_content );
	}

	$popup_content	= do_shortcode( $popup_content );
	$popup_content	= convert_smilies( $popup_content );
	$popup_content	= str_replace( ']]>', ']]&gt;', $popup_content );

	return $popup_content;
}

/**
 * Function to create popup HTML
 * 
 * @since 2.0
 */
function popupaoc_generate_popup_style( $popup_id = 0 ) {

	global $paoc_design_sett, $paoc_behaviour_sett, $paoc_advance_sett, $paoc_custom_css;

	// If valid post is there
	if( empty( $popup_id ) ) {
		return false;
	}

	// Taking some data
	$style['inline']	= '';
	$prefix				= POPUPAOC_META_PREFIX;
	$design				= empty( $paoc_design_sett )	? get_post_meta( $popup_id, $prefix.'design', true )		: $paoc_design_sett;
	$behaviour			= empty( $paoc_behaviour_sett )	? get_post_meta( $popup_id, $prefix.'behaviour', true )		: $paoc_behaviour_sett;
	$advance			= empty( $paoc_advance_sett )	? get_post_meta( $popup_id, $prefix.'advance', true )		: $paoc_advance_sett;
	$custom_css			= empty( $paoc_custom_css )		? get_post_meta( $popup_id, $prefix.'custom_css', true )	: $paoc_custom_css;

	$popup_width		= isset( $design['width'] ) 			? $design['width']				: '';
	$popup_height		= isset( $design['height'] ) 			? $design['height']				: '';
	$fullscreen_popup	= isset( $design['fullscreen_popup'] ) 	? $design['fullscreen_popup']	: '';
	$hide_overlay		= ! empty( $behaviour['hide_overlay'] )	? 1 : 0;

	// Show Credit
	$show_credit = ! empty( $advance['show_credit'] ) ? 1 : 0;

	// Custom CSS
	$custom_css = isset( $custom_css ) ? $custom_css : '';

	if( $popup_width ) {
		if( ! $hide_overlay ) {
			$style['inline'] .= ".paoc-popup-{$popup_id}{max-width: {$popup_width};}";
		} else {
			$style['inline'] .= ".paoc-cb-popup-{$popup_id}.paoc-hide-overlay.custombox-content {max-width: {$popup_width};}";
		}
	}

	if( $popup_height && ! $fullscreen_popup ) {

		$style['inline'] .= ".paoc-popup-{$popup_id} {height: {$popup_height}px;}";
		$style['inline'] .= ".paoc-popup-{$popup_id} .paoc-popup-inr-wrap{height: 100%;}";
		$style['inline'] .= ".paoc-popup-{$popup_id} .paoc-popup-inr{overflow-y:auto;}";
	}

	// Show Credit
	if( $show_credit ) {
		if( ! $hide_overlay ) {
			$style['inline'] .= ".custombox-y-bottom .paoc-popup-{$popup_id}{margin-bottom: 34px;}";
			$style['inline'] .= ".paoc-popup-{$popup_id}.paoc-inline-popup{margin-bottom: 49px;}";
		}
	}

	if ( $hide_overlay ) {
		if( $show_credit ) {
			$style['inline'] .= ".admin-bar .paoc-popup-{$popup_id}{max-height: calc(100vh - 66px) !important; margin-bottom: 34px;}";
			$style['inline'] .= ".paoc-popup-{$popup_id}{max-height: calc(100vh - 32px) !important; margin-bottom: 34px !important;}";
			$style['inline'] .= ".paoc-popup-{$popup_id}.paoc-inline-popup{margin-bottom: 49px !important;}";
		} else {
			$style['inline'] .= ".admin-bar .paoc-popup-{$popup_id}{max-height: calc(100vh - 32px) !important;}";
		}
	}

	// Custom CSS
	$style['inline'] .= $custom_css;

	return $style;
}