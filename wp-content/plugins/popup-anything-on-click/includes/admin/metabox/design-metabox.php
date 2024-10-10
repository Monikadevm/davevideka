<?php
/**
 * Handles Design Setting metabox HTML
 * 
 * @package Popup Anything on Click
 * @since 2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some function data
$effect_data	= popupaoc_popup_effects();
$position_data	= popupaoc_position_options();

// Take some variables
$design				= get_post_meta( $post->ID, $prefix.'design', true );
$fullscreen_popup	= ! empty( $design['fullscreen_popup'] )	? 1							: 0;
$speed_in			= ! empty( $design['speed_in'] )			? $design['speed_in']		: 0.5;
$speed_out			= ! empty( $design['speed_out'] )			? $design['speed_out']		: 0.25;
$height				= isset( $design['height'] )				? $design['height']			: '';
$width				= isset( $design['width'] )					? $design['width']			: '';
$effect				= isset( $design['effect'] )				? $design['effect']			: 'fadein';
$mn_position		= isset( $design['mn_position'] )			? $design['mn_position']	: 'center-center';
$loader_color		= isset( $design['loader_color'] )			? $design['loader_color']	: '';
?>

<div id="paoc_design_sett" class="paoc-vtab-cnt paoc-design-sett paoc-clearfix">

	<div class="paoc-tab-info-wrap">
		<div class="paoc-tab-title"><?php esc_html_e('Design Settings', 'popup-anything-on-click'); ?></div>
		<span class="paoc-tab-desc"><?php esc_html_e('Set various popup design settings.', 'popup-anything-on-click'); ?></span>
	</div>

	<table class="form-table paoc-tbl">
		<tbody>
			<tr>
				<th>
					<label for="paoc-fullscreen"><?php _e('Full Screen Popup', 'popup-anything-on-click'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo popupaoc_esc_attr( $prefix ); ?>design[fullscreen_popup]" value="1" <?php checked( $fullscreen_popup, 1 ); ?> class="paoc-checkbox paoc-show-hide paoc-fullscreen" id="paoc-fullscreen" data-label="screen" data-prefix="full" /><br />
					<span class="description"><?php _e('Check this box if you want to display full screen popup.', 'popup-anything-on-click'); ?></span>
				</td>
			</tr>

			<tr class="paoc-show-hide-row-full paoc-hide-if-full-screen" style="<?php if( $fullscreen_popup == '1' ) { echo 'display: none;'; } ?>">
				<td class="paoc-no-padding" colspan="2">
					<table class="form-table paoc-tbl">
						<tr>
							<th>
								<label for="paoc-popup-width"><?php _e('Popup Width', 'popup-anything-on-click'); ?></label>
							</th>
							<td>
								<input type="text" name="<?php echo popupaoc_esc_attr( $prefix ); ?>design[width]" value="<?php echo popupaoc_esc_attr( $width ); ?>" class="paoc-medium-text paoc-text paoc-popup-width" id="paoc-popup-width" /><br/>
								<span class="description"><?php _e('Set popup width in (px, em OR %). Leave empty for default width. e.g. 800px, 80% OR 1em.', 'popup-anything-on-click'); ?></span>
							</td>
						</tr>

						<tr>
							<th>
								<label for="paoc-popup-height"><?php _e('Popup Height', 'popup-anything-on-click'); ?></label>
							</th>
							<td>
								<input type="text" name="<?php echo popupaoc_esc_attr( $prefix ); ?>design[height]" value="<?php echo popupaoc_esc_attr( $height ); ?>" class="paoc-medium-text paoc-number paoc-popup-height" id="paoc-popup-height" /> <?php esc_html_e('PX', 'popup-anything-on-click'); ?><br />
								<span class="description"><?php _e('Set popup height in PX. Leave empty for default height.', 'popup-anything-on-click'); ?></span>
							</td>
						</tr>

						<tr>
							<th>
								<label for="paoc-popup-mn-position"><?php _e('Popup Position', 'popup-anything-on-click'); ?></label>
							</th>
							<td>
								<select name="<?php echo popupaoc_esc_attr( $prefix ); ?>design[mn_position]" class="paoc-select paoc-popup-mn-position" id="paoc-popup-mn-position">
									<?php foreach ( $position_data as $position_key => $position_val ) { ?>
										<option value="<?php echo popupaoc_esc_attr( $position_key ); ?>" <?php selected( $mn_position, $position_key ); ?>><?php echo $position_val; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<th>
					<label for="paoc-popup-effect"><?php _e('Popup Effect', 'popup-anything-on-click'); ?></label>
				</th>
				<td>
					<select name="<?php echo popupaoc_esc_attr( $prefix ); ?>design[effect]" class="paoc-select paoc-popup-effect" id="paoc-popup-effect">
						<?php foreach ( $effect_data as $effect_key => $effect_val ) { ?>
							<option value="<?php echo popupaoc_esc_attr( $effect_key ); ?>" <?php selected( $effect, $effect_key ); ?>><?php echo $effect_val; ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>

			<tr>
				<th>
					<label for="paoc-speed-in"><?php _e('Speed In', 'popup-anything-on-click'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo popupaoc_esc_attr( $prefix ); ?>design[speed_in]" value="<?php echo popupaoc_esc_attr( $speed_in ); ?>" id="paoc-speed-in" class="paoc-medium-text paoc-text paoc-speed-in" /> <?php _e('Sec', 'popup-anything-on-click'); ?><br/>
					<span class="description"><?php _e('Enter the popup opening animation speed. Default value is 0.5 Sec.', 'popup-anything-on-click'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="paoc-speed-out"><?php _e('Speed Out', 'popup-anything-on-click'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo popupaoc_esc_attr( $prefix ); ?>design[speed_out]" value="<?php echo popupaoc_esc_attr( $speed_out ); ?>" id="paoc-speed-out" class="paoc-medium-text paoc-text paoc-speed-out" /> <?php _e('Sec', 'popup-anything-on-click'); ?><br/>
					<span class="description"><?php _e('Enter the popup closing animation speed. Default value is 0.25 Sec.', 'popup-anything-on-click'); ?></span>
				</td>
			</tr>

			<tr class="paoc-show-hide-row-overlay paoc-hide-if-overlay-1" style="<?php if( ! empty( $hide_overlay ) ) { echo 'display: none;'; } ?>">
				<th>
					<label for="paoc-loader-clr"><?php _e('Loader Color', 'popup-anything-on-click'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo popupaoc_esc_attr( $prefix ); ?>design[loader_color]" value="<?php echo popupaoc_esc_attr( $loader_color ); ?>" id="paoc-loader-clr" class="paoc-colorpicker paoc-loader-clr" /><br/>
					<span class="description"><?php _e('Choose popup loader color.', 'popup-anything-on-click'); ?></span>
				</td>
			</tr>

			<input type="hidden" name="<?php echo popupaoc_esc_attr( $prefix ); ?>design[template]" value="design-3" />

			<!-- Pro Feature - Start -->
			<tr class="paoc-pro-feature">
				<td colspan="2" class="paoc-no-padding">
					<table class="form-table">
						<tbody>
							<tr>
								<th colspan="2">
									<div class="paoc-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Image & Color Settings', 'popup-anything-on-click'); ?> <span class="paoc-pro-tag"><?php _e('PRO','popup-anything-on-click');?></span></div>
								</th>
							</tr>

							<tr>
								<th>
									<label for="paoc-popup-img"><?php _e('Popup Image', 'popup-anything-on-click'); ?></label>
								</th>
								<td>
									<input type="text" name="" value="" class="regular-text paoc-url paoc-popup-img paoc-img-upload-input" id="paoc-popup-img" disabled="disabled" />
									<input type="button" name="" class="button-secondary paoc-image-upload" value="<?php esc_html_e( 'Upload Image', 'popup-anything-on-click'); ?>" disabled="disabled" />
									<input type="button" name="" class="button button-secondary paoc-image-clear" value="<?php esc_html_e( 'Clear', 'popup-anything-on-click'); ?>" disabled="disabled" /> <br />
									<span class="description"><?php _e('Set popup background image.', 'popup-anything-on-click'); ?></span><br />
								</td>
							</tr>

							<tr>
								<th>
									<label for="paoc-bg-color"><?php _e('Popup Background Color', 'popup-anything-on-click'); ?></label>
								</th>
								<td class="paoc-pro-disabled">
									<input type="text" name="" value="" class="paoc-colorpicker paoc-bg-color" id="paoc-bg-color" data-alpha="true" disabled="disabled" /><br />
									<span class="description"><?php _e('Choose popup background color.', 'popup-anything-on-click'); ?></span>
								</td>
							</tr>

							<tr>
								<th>
									<label for="paoc-overlay-img"><?php _e('Popup Overlay Image', 'popup-anything-on-click'); ?></label>
								</th>
								<td>
									<input type="text" name="" value="" class="regular-text paoc-url paoc-overlay-img paoc-img-upload-input" id="paoc-overlay-img" disabled="disabled" />
									<input type="button" name="" class="button-secondary paoc-image-upload" value="<?php esc_html_e( 'Upload Image', 'popup-anything-on-click'); ?>" disabled="disabled" />
									<input type="button" name="" class="button button-secondary paoc-image-clear" value="<?php esc_html_e( 'Clear', 'popup-anything-on-click'); ?>" disabled="disabled" /> <br />
									<span class="description"><?php _e('Set popup overlay background image.', 'popup-anything-on-click'); ?></span><br />
								</td>
							</tr>

							<tr>
								<th>
									<label for="paoc-overlay-color"><?php _e('Popup Overlay Color', 'popup-anything-on-click'); ?></label>
								</th>
								<td class="paoc-pro-disabled">
									<input type="text" name="" value="" class="paoc-colorpicker paoc-overlay-color" id="paoc-overlay-color" data-alpha="true" disabled="disabled" /><br />
									<span class="description"><?php _e('Choose overlay background color. Leave empty for default color.', 'popup-anything-on-click'); ?></span><br/>
									<span class="description"><?php _e('<strong>Note:</strong> This will only work when overlay background image is not there or image is transparent.', 'popup-anything-on-click'); ?></span>
								</td>
							</tr>

							<tr>
								<th colspan="2">
									<div class="paoc-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Heading Settings', 'popup-anything-on-click'); ?> <span class="paoc-pro-tag"><?php _e('PRO','popup-anything-on-click');?></span></div>
								</th>
							</tr>
							<tr>
								<th>
									<label for="paoc-mheading-fontsize"><?php _e('Main Heading Font Size', 'popup-anything-on-click'); ?></label>
								</th>
								<td>
									<input type="text" name="" value="" class="paoc-medium-text paoc-number paoc-mheading-fontsize" id="paoc-mheading-fontsize" disabled="disabled" /> <?php esc_html_e('PX', 'popup-anything-on-click'); ?><br />
									<span class="description"><?php _e('Enter main heading font size.', 'popup-anything-on-click'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="paoc-sheading-fontsize"><?php _e('Sub Heading Font Size', 'popup-anything-on-click'); ?></label>
								</th>
								<td>
									<input type="text" name="" value="" class="paoc-medium-text paoc-number paoc-sheading-fontsize" id="paoc-sheading-fontsize" disabled="disabled" /> <?php esc_html_e('PX', 'popup-anything-on-click'); ?><br />
									<span class="description"><?php _e('Enter sub heading font size.', 'popup-anything-on-click'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="paoc-mheading-txtclr"><?php _e('Main Heading Text Color', 'popup-anything-on-click'); ?></label>
								</th>
								<td class="paoc-pro-disabled">
									<input type="text" name="" value="" class="paoc-colorpicker paoc-mheading-txtclr" id="paoc-mheading-txtclr" /><br />
									<span class="description"><?php _e('Choose main heading text color.', 'popup-anything-on-click'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="paoc-sheading-txtcolor"><?php _e('Sub Heading Text Color', 'popup-anything-on-click'); ?></label>
								</th>
								<td class="paoc-pro-disabled">
									<input type="text" name="" value="" class="paoc-colorpicker paoc-sheading-txtcolor" id="paoc-sheading-txtcolor"><br />
									<span class="description"><?php _e('Choose sub heading text color.', 'popup-anything-on-click'); ?></span>
								</td>
							</tr>
							<tr>
								<th colspan="2">
									<div class="paoc-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Other Settings', 'popup-anything-on-click'); ?> <span class="paoc-pro-tag"><?php _e('PRO','popup-anything-on-click');?></span></div>
								</th>
							</tr>
							<tr>
								<th>
									<label for="paoc-content-color"><?php _e('Content Color', 'popup-anything-on-click'); ?></label>
								</th>
								<td class="paoc-pro-disabled">
									<input type="text" name="" value="" class="paoc-colorpicker paoc-content-color" id="paoc-content-color"><br />
									<span class="description"><?php _e('Choose content text color.', 'popup-anything-on-click'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="paoc-secondary-con-clr"><?php _e('Secondary Content Color', 'popup-anything-on-click'); ?></label>
								</th>
								<td class="paoc-pro-disabled">
									<input type="text" name="" value="" class="paoc-colorpicker paoc-secondary-con-clr" id="paoc-secondary-con-clr"><br />
									<span class="description"><?php _e('Choose secondary content text color.', 'popup-anything-on-click'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="paoc-cus-close-txt-clr"><?php _e('Custom Close Text Color', 'popup-anything-on-click'); ?></label>
								</th>
								<td class="paoc-pro-disabled">
									<input type="text" name="" value="" class="paoc-colorpicker paoc-cus-close-txt-clr" id="paoc-cus-close-txt-clr"><br />
									<span class="description"><?php _e('Choose custom close text color.', 'popup-anything-on-click'); ?></span>
								</td>
							</tr>
							<tr>
								<th>
									<label for="paoc-secur-note-color"><?php _e('Security Note Text Color', 'popup-anything-on-click'); ?></label>
								</th>
								<td class="paoc-pro-disabled">
									<input type="text" name="" value="" class="paoc-colorpicker paoc-secur-note-color" id="paoc-secur-note-color"><br />
									<span class="description"><?php _e('Choose security note text color.', 'popup-anything-on-click'); ?></span>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .paoc-design-sett -->