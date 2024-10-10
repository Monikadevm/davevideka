<?php
/**
 * Handles Google Analytic Setting metabox HTML
 * 
 * @package Popup Anything on Click
 * @since 2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
<div id="paoc_analytics_sett" class="paoc-vtab-cnt paoc-pro-feature paoc-analytics-sett paoc-clearfix">

	<div class="paoc-tab-info-wrap">
		<div class="paoc-tab-title"><?php esc_html_e('Google Analytics Settings', 'popup-anything-on-click'); ?></div>
		<span class="paoc-tab-desc"><?php esc_html_e('Choose Popup google analytics settings.', 'popup-anything-on-click'); ?></span>
	</div>

	<table class="form-table paoc-tbl">
		<tbody>
			<tr>
				<th>
					<label for="paoc-analytics-enable"><?php _e('Enable', 'popup-anything-on-click'); ?></label>
				</th>
				<td>
					<input type="checkbox" name="" value="1" class="paoc-checkbox paoc-analytics-enable" id="paoc-analytics-enable" disabled="disabled" /><br />
					<span class="description"><?php _e('Check this box to enable google analytic event for popup.', 'popup-anything-on-click'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="paoc-analytics-action"><?php _e('Action', 'popup-anything-on-click'); ?></label>
				</th>
				<td>
					<input type="text" name="" value="" id="paoc-analytics-action" class="paoc-text large-text paoc-analytics-action" disabled="disabled" /><br/>
					<span class="description"><?php _e('Enter google analytic event action.', 'popup-anything-on-click'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="paoc-analytics-category"><?php _e('Category', 'popup-anything-on-click'); ?></label>
				</th>
				<td>
					<input type="text" name="" value="" id="paoc-analytics-category" class="paoc-text large-text paoc-analytics-category" disabled="disabled" /><br/>
					<span class="description"><?php _e('Enter google analytic event category.', 'popup-anything-on-click'); ?></span>
				</td>
			</tr>

			<tr>
				<th>
					<label for="paoc-analytics-label"><?php _e('Label', 'popup-anything-on-click'); ?></label>
				</th>
				<td>
					<input type="text" name="" value="" id="paoc-analytics-label" class="paoc-text large-text paoc-analytics-label" disabled="disabled" /><br/>
					<span class="description"><?php _e('Enter google analytic event label.', 'popup-anything-on-click'); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- end .paoc-analytics-sett -->