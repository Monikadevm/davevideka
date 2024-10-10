<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Popup Anything on click
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Popupaoc_Admin {

	function __construct() {

		// Action to add admin menu
		add_action( 'admin_menu', array($this, 'popupaoc_register_menu') );

		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'popupaoc_post_sett_metabox') );

		// Action to save metabox
		add_action( 'save_post', array($this, 'popupaoc_save_metabox_value') );

		// Action to admin notice
		add_action( 'admin_notices', array($this, 'popupaoc_db_updated_notice') );

		// Admin prior process
		add_action( 'admin_init', array($this, 'popupaoc_admin_init_process') );

		// Admin for the Solutions & Features
		add_action( 'admin_init', array($this, 'popupaoc_admin_init_sf_process') );

		// Action to add custom column to Slider listing
		add_filter( 'manage_'.POPUPAOC_POST_TYPE.'_posts_columns', array($this, 'popupaoc_manage_posts_columns') );

		// Action to add custom column data to Slider listing
		add_action('manage_'.POPUPAOC_POST_TYPE.'_posts_custom_column', array($this, 'popupaoc_post_columns_data'), 10, 2);

		// Action to get post suggestion
		add_action( 'wp_ajax_popupaoc_post_title_sugg', array($this, 'popupaoc_post_title_sugg') );

		// Render Popup Preview
		add_action( 'wp', array($this, 'popupaoc_render_popup_preview') );

		// Action to add little JS code in admin footer
		// add_action( 'admin_footer', array($this, 'popupaoc_upgrade_page_link_blank') );
	}

	/**
	 * Function to add menu
	 * 
	 * @package Popup Anything on Click
	 * @since 1.0.0
	 */
	function popupaoc_register_menu() {

		// Setting page
		add_submenu_page( 'edit.php?post_type='.POPUPAOC_POST_TYPE, __('Settings - Popup Anything On Click', 'popup-anything-on-click'), __('Settings', 'popup-anything-on-click'), 'manage_options', 'popupaoc-settings', array($this, 'popupaoc_settings_page') );

		// Setting page
		add_submenu_page( 'edit.php?post_type='.POPUPAOC_POST_TYPE, __('Solutions & Features - Popup Anything On Click', 'popup-anything-on-click'), '<span style="color:#2ECC71">'. __('Solutions & Features', 'popup-anything-on-click').'</span>', 'manage_options', 'paoc-solutions-features', array($this, 'popupaoc_solutions_features_page') );

		// Register plugin premium page
		add_submenu_page( 'edit.php?post_type='.POPUPAOC_POST_TYPE, __('Upgrade To PRO - Popup Anything On Click', 'popup-anything-on-click'), '<span style="color:#ff2700">'.__('Upgrade To PRO', 'popup-anything-on-click').'</span>', 'manage_options', 'popupaoc-premium', array($this, 'popupaoc_premium_page') );

		//add_submenu_page( 'edit.php?post_type='.POPUPAOC_POST_TYPE, __('Upgrade To PRO - Popup Anything On Click', 'popup-anything-on-click'), '<span class="wpos-upgrade-pro" style="color:#ff2700">' . __('Upgrade To Premium ', 'popup-anything-on-click') . '</span>', 'manage_options', 'popupaoc-upgrade-pro', array($this, 'popupaoc_redirect_page') );
			
	}

	/**
	 * Redirect page HTML
	 * 
	 * @since 1.0
	 */
	// function popupaoc_redirect_page() {
	// }

	/**
	 * Post Settings Metabox
	 * 
	 * @package Popup Anything on click
	 * @since 1.0.0
	 */
	function popupaoc_post_sett_metabox() {

		// Add metabox in popup posts
		add_meta_box( 'popupaoc-post-sett', __( 'Popup Anything - Settings', 'popup-anything-on-click' ), array($this, 'popupaoc_post_sett_mb_content'), POPUPAOC_POST_TYPE, 'normal', 'high' );

		// Add metabox in popup Report
		add_meta_box( 'paoc-popup-report', __( 'Popup Report', 'popup-anything-on-click' ), array($this, 'popupaoc_report_meta_box_content'), POPUPAOC_POST_TYPE, 'side', 'default' );
		
	}

	/**
	 * Post Settings Metabox HTML
	 * 
	 * @package Popup Anything on click
	 * @since 1.0.0
	 */
	function popupaoc_post_sett_mb_content() {
		include_once( POPUPAOC_DIR .'/includes/admin/metabox/post-sett-metabox.php');
	}

	/**
	 * Function to handle metabox content
	 * 
	 * @since 2.0
	 */
	function popupaoc_report_meta_box_content() {
		include_once( POPUPAOC_DIR .'/includes/admin/metabox/report-metabox.php');
	}

	/**
	 * Function to save metabox values
	 * 
	 * @package Popup Anything on click
	 * @since 1.0.0
	 */
	function popupaoc_save_metabox_value( $post_id ) {

		global $post_type;

		$prefix = POPUPAOC_META_PREFIX; // Taking metabox prefix

		// Popup Meta
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )					// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )	// Check Revision
		|| ( $post_type !=  POPUPAOC_POST_TYPE ) )								// Check if current post type is supported.
		{
			return $post_id;
		}

		// Getting saved values
		$tab			= isset( $_POST[$prefix.'tab'] )			? popupaoc_clean( $_POST[$prefix.'tab'] )			: '';
		$popup_appear	= isset( $_POST[$prefix.'popup_appear'] )	? popupaoc_clean( $_POST[$prefix.'popup_appear'] )	: 'page_load';
		$popup_goal		= isset( $_POST[$prefix.'popup_goal'] )		? 'announcement'	: 'announcement';
		$display_type	= isset( $_POST[$prefix.'display_type'] )	? 'modal'			: 'modal';
		
		// Behaviour Settings
		$behaviour						= isset( $_POST[$prefix.'behaviour'] )		? $_POST[$prefix.'behaviour']									: array();
		$behaviour['open_delay']		= isset( $behaviour['open_delay'] )			? popupaoc_clean_number( $behaviour['open_delay'], '', 'abs') 	: '';
		$behaviour['disappear']			= isset( $behaviour['disappear'] )			? popupaoc_clean_number( $behaviour['disappear'], '', 'float')	: '';
		$behaviour['loader_speed']		= ! empty( $behaviour['loader_speed'] )		? popupaoc_clean_number( $behaviour['loader_speed'], '', 'abs')	: 1;
		$behaviour['popup_img_id']		= ! empty( $behaviour['popup_img_id'] )		? popupaoc_clean_number( $behaviour['popup_img_id'] )			: 0;
		$behaviour['image_url']			= isset( $behaviour['image_url'] )			? popupaoc_clean_url( $behaviour['image_url'] )					: '';
		$behaviour['btn_class']			= isset( $behaviour['btn_class'] )			? popupaoc_sanitize_html_classes( $behaviour['btn_class'] )		: '';
		$behaviour['btn_text']			= ! empty( $behaviour['btn_text'] )			? popupaoc_clean_html( $behaviour['btn_text'] )					: '';
		$behaviour['btn_text']			= ! empty( $behaviour['btn_text'] )			? $behaviour['btn_text']										: esc_html__('Click Here!!!', 'popup-anything-on-click');
		$behaviour['link_text']			= ! empty( $behaviour['link_text'] )		? popupaoc_clean_html( $behaviour['link_text'] )				: '';
		$behaviour['link_text']			= ! empty( $behaviour['link_text'] )		? $behaviour['link_text']										: esc_html__('Click Me!!!', 'popup-anything-on-click');
		$behaviour['image_title']		= ! empty( $behaviour['image_title'] )		? 1	: 0;
		$behaviour['image_caption']		= ! empty( $behaviour['image_caption'] )	? 1	: 0;
		$behaviour['hide_close']		= ! empty( $behaviour['hide_close'] )		? 1	: 0;
		$behaviour['clsonesc']			= ! empty( $behaviour['clsonesc'] )			? 1	: 0;
		$behaviour['enable_loader']		= ! empty( $behaviour['enable_loader'] )	? 1	: 0;
		$behaviour['close_overlay']		= ! empty( $behaviour['close_overlay'] )	? 1	: 0;
		$behaviour['hide_overlay']		= ! empty( $behaviour['hide_overlay'] )		? 1	: 0;
		$behaviour['close_overlay']		= ( $behaviour['hide_overlay'] == 1 )		? 0	: $behaviour['close_overlay'];

		// Content Settings
		$content						= isset( $_POST[$prefix.'content'] )		? $_POST[$prefix.'content']										: array();
		$content['main_heading']		= isset( $content['main_heading'] )			? popupaoc_clean_html( $content['main_heading'] )					: '';
		$content['sub_heading']			= isset( $content['sub_heading'] )			? popupaoc_clean_html( $content['sub_heading'] )						: '';
		$content['cust_close_txt']		= isset( $content['cust_close_txt'] )		? popupaoc_clean( $content['cust_close_txt'] )					: '';
		$content['security_note']		= isset( $content['security_note'] )		? popupaoc_clean( $content['security_note'] )					: '';
		$content['secondary_content']	= isset( $content['secondary_content'] )	? popupaoc_clean_html( $content['secondary_content'], true )	: '';

		// Design Settings
		$design							= isset( $_POST[$prefix.'design'] )			? $_POST[$prefix.'design']									: array();
		$design['template']				= isset( $design['template'] )				? popupaoc_clean( $design['template'] )						: 'design-1';
		$design['width']				= isset( $design['width'] )					? popupaoc_clean( $design['width'] )						: '';
		$design['height']				= isset( $design['height'] )				? popupaoc_clean_number( $design['height'], '' )			: '';
		$design['effect']				= isset( $design['effect'] )				? popupaoc_clean( $design['effect'] )						: '';
		$design['speed_in']				= ! empty( $design['speed_in'] )			? popupaoc_clean_number( $design['speed_in'], '', 'abs' )	: 0.5;
		$design['speed_out']			= ! empty( $design['speed_out'] )			? popupaoc_clean_number( $design['speed_out'], '', 'abs' )	: 0.25;
		$design['loader_color']			= ! empty( $design['loader_color'] )		? popupaoc_clean_color( $design['loader_color'] )			: '#000000';
		$design['fullscreen_popup']		= ! empty( $design['fullscreen_popup'] )	? 1	: 0;

		// Advance Settings
		$advance					= isset( $_POST[$prefix.'advance'] )	? $_POST[$prefix.'advance']									: array();
		$advance['cookie_expire']	= isset( $advance['cookie_expire'] )	? popupaoc_clean( $advance['cookie_expire'] ) 				: '';
		$advance['cookie_expire']	= ( $advance['cookie_expire'] != '' )	? popupaoc_clean_number( $advance['cookie_expire'], null )	: '';
		$advance['cookie_unit']		= isset( $advance['cookie_unit'] )		? 'day'														: 'day';

		// Custom CSS Settings
		$custom_css	= isset( $_POST[$prefix.'custom_css'] )	? sanitize_textarea_field( $_POST[$prefix.'custom_css'] ) : '';

		// Update Meta
		update_post_meta( $post_id, $prefix.'tab', $tab );
		update_post_meta( $post_id, $prefix.'popup_goal', $popup_goal );
		update_post_meta( $post_id, $prefix.'display_type', $display_type );
		update_post_meta( $post_id, $prefix.'popup_appear', $popup_appear );
		update_post_meta( $post_id, $prefix.'behaviour', $behaviour );
		update_post_meta( $post_id, $prefix.'content', $content );
		update_post_meta( $post_id, $prefix.'design', $design );
		update_post_meta( $post_id, $prefix.'advance', $advance );
		update_post_meta( $post_id, $prefix.'custom_css', $custom_css );
	}

	/**
	 * Function to display DB updated notice
	 * 
	 * @since 2.0
	 */
	function popupaoc_db_updated_notice() {

		if( isset($_GET['message']) && $_GET['message'] == 'popupaoc-db-update' ) { ?>
			<div id="message" class="updated notice notice-success is-dismissible">
				<p><strong><?php _e('Popup Anything database proccess has been updated.', 'popup-anything-on-click'); ?></strong></p>
			</div>
		<?php }
	}

	/**
	 * Add custom column to Post listing page
	 * 
	 * @package Popup Anything on click
	 * @since 1.0.0
	 */
	function popupaoc_manage_posts_columns( $columns ) {
		
		$new_columns['paoc_popup_goal']		= esc_html__('Goal', 'popup-anything-on-click');
		$new_columns['paoc_display_type']	= esc_html__('Type', 'popup-anything-on-click');
		$new_columns['paoc_popup_appear']	= esc_html__('Appear On', 'popup-anything-on-click');

		$columns = popupaoc_add_array( $columns, $new_columns, 1, true );

		return $columns;
	}

	/**
	 * Add custom column data to Post listing page
	 * 
	 * @package Popup Anything on Click
	 * @since 1.0.0
	 */
	function popupaoc_post_columns_data( $column, $post_id ) {

		$prefix = POPUPAOC_META_PREFIX;

		switch ($column) {
			case 'paoc_popup_goal':
				$popup_goals	= popupaoc_popup_goals();
				$popup_goal		= get_post_meta( $post_id, $prefix.'popup_goal', true );
				$popup_goal		= isset( $popup_goals[ $popup_goal ]['name'] ) ? $popup_goals[ $popup_goal ]['name'] : $popup_goal;

				echo $popup_goal;
				break;

			case 'paoc_display_type':
				$popup_types	= popupaoc_popup_types();
				$display_type	= get_post_meta( $post_id, $prefix.'display_type', true );
				$display_type	= isset( $popup_types[ $display_type ]['name'] ) ? $popup_types[ $display_type ]['name'] : $display_type;

				echo $display_type;
				break;

			case 'paoc_popup_appear':
				$appear_types	= popupaoc_when_appear_options();
				$popup_appear	= get_post_meta( $post_id, $prefix.'popup_appear', true );
				$popup_appear	= isset( $appear_types[ $popup_appear ] ) ? $appear_types[ $popup_appear ] : $popup_appear;
				
				echo $popup_appear;
				break;
		}
	}

	/**
	 * Getting Started Page Html
	 * 
	 * @package Popup Anything on Click
	 * @since 1.0.0
	 */
	function popupaoc_settings_page() {
		include_once( POPUPAOC_DIR . '/includes/admin/settings/settings.php' );
	}

	/**
	 * Solutions & Features Page Html
	 * 
	 * @package Popup Anything on Click
	 * @since 2.0.11
	 */
	function popupaoc_solutions_features_page() {
		include_once( POPUPAOC_DIR . '/includes/admin/settings/solutions-features.php' );
	}

	/**
	 * Getting Started Page Html
	 * 
	 * @package Popup Anything on Click
	 * @since 1.0.0
	 */
	function popupaoc_premium_page() {
	include_once( POPUPAOC_DIR . '/includes/admin/settings/premium.php' );
	}	

	/**
	 * Admin Prior Process
	 * 
	 * @package Popup Anything on Click
	 * @since 1.2.2
	 */
	function popupaoc_admin_init_process() {

		global $typenow, $pagenow;

		$current_page = isset( $_REQUEST['page'] ) ? $_REQUEST['page'] : '';

		// If plugin notice is dismissed
		if( isset($_GET['message']) && $_GET['message'] == 'popupaoc-plugin-notice' ) {
			set_transient( 'popupaoc_install_notice', true, 604800 );
		}

		// Redirect to external page for upgrade to menu
		if( $typenow == POPUPAOC_POST_TYPE ) {

			if( $current_page == 'popupaoc-upgrade-pro' ) {

				wp_redirect( POPUPAOC_PLUGIN_LINK_UPGRADE );
				exit;
			}
		}
	}

	/**
	 * Admin Prior Process for Solutions & Features Page Redirect
	 * 
	 * @package Popup Anything on Click
	 * @since 2.0.11
	 */
	function popupaoc_admin_init_sf_process() {

		if ( get_option( 'popupaoc_sf_optin', false ) ) {

			delete_option( 'popupaoc_sf_optin' );

			$redirect_link = add_query_arg( array( 'post_type' => POPUPAOC_POST_TYPE, 'page' => 'paoc-solutions-features' ), admin_url( 'edit.php' ) );

			wp_safe_redirect( $redirect_link );

			exit;
		}
	}

	/**
	 * Function to get post suggestion based on search input
	 * 
 	 * @since 2.0
	 */
	function popupaoc_post_title_sugg() {

		$return			= array();
		$prefix			= POPUPAOC_META_PREFIX;
		$post_status	= ! empty( $_GET['post_status'] )	? $_GET['post_status']							: 'publish';
		$search			= isset( $_GET['search'] )			? trim( $_GET['search'] )						: '';
		$post_type		= isset( $_GET['post_type'] )		? $_GET['post_type']							: 'post';
		$nonce			= isset( $_GET['nonce'] )			? $_GET['nonce']								: '';
		$post_data		= isset( $_GET['form_data'] )		? parse_str( $_GET['form_data'], $form_data )	: '';
		$meta_data		= isset( $_GET['meta_data'] )		? popupaoc_clean( $_GET['meta_data'] )			: '';
		$meta_data		= json_decode( $meta_data, true );

		// Verify Nonce
		if( $search && wp_verify_nonce( $nonce, 'paoc-post-title-sugg' ) ) {

			$args = array(
						's'						=> $search,
						'post_type'				=> $post_type,
						'post_status'			=> $post_status,
						'order'					=> 'ASC',
						'orderby'				=> 'title',
						'posts_per_page'		=> 20
					);

			// If number is passed
			if( is_numeric( $search ) ) {
				$args['s'] = false;
				$args['p'] = $search;
			}

			// If meta query is set
			if( $meta_data ) {
				$args['meta_query'] = $meta_data;
			}

			// Form data is there
			if( ! empty( $form_data['popup_appear'] ) ) {
				$args['meta_query'][] = array(
											'key'		=> $prefix.'popup_appear',
											'value'		=> $form_data['popup_appear'],
											'compare'	=> '=',
										);
			}

			$search_query = get_posts( $args );

			if( $search_query ) :

				foreach ( $search_query as $search_data ) {
					
					$post_title	= ! empty( $search_data->post_title ) ? $search_data->post_title : esc_html__('Post', 'popup-anything-on-click');
					$post_title	= $post_title . " - (#{$search_data->ID})";

					$return[]	= array( $search_data->ID, $post_title );
				}

			endif;
		}

		wp_send_json( $return );
	}

	/**
	 * Function to handle module preview screen
	 * 
	 * @since 2.0
	 */
	function popupaoc_render_popup_preview() {

		if( isset( $_GET['paoc-popup-preview'] ) && $_GET['paoc-popup-preview'] == 1 && ( isset( $_SERVER['HTTP_REFERER'] ) && (strpos($_SERVER['HTTP_REFERER'], 'post.php') !== false || strpos($_SERVER['HTTP_REFERER'], 'post-new.php') !== false) ) ) {
			include_once( POPUPAOC_DIR . '/includes/admin/preview/preview.php' );
			exit;
		}
	}

	/**
	 * Add JS snippet to admin footer to add target _blank in upgrade link
	 *
	 * @since 1.0.0
	 */
	/*function popupaoc_upgrade_page_link_blank() {

		global $wpos_upgrade_link_snippet;

		// Redirect to external page
		if( empty( $wpos_upgrade_link_snippet ) ) {

			$wpos_upgrade_link_snippet = 1;
	?>
		<script type="text/javascript">
			(function ($) {
				$('.wpos-upgrade-pro').parent().attr( { target: '_blank', rel: 'noopener noreferrer' } );
			})(jQuery);
		</script>
	<?php }
	} */
}

$popupaoc_admin = new Popupaoc_Admin();