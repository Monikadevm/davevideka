<?php
/**
 * Plugin Solutions & Features Page
 *
 * @package Popup Anything on Click
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variables
$popup_add_link = add_query_arg( array( 'post_type' => POPUPAOC_POST_TYPE ), admin_url( 'post-new.php' ) );
?>

<div id="wrap">
	<div class="popupaoc-sf-wrap">
		<div class="popupaoc-sf-inr">
			<!-- Start - Welcome Box -->
			<div class="popupaoc-sf-welcome-wrap">
				<div class="popupaoc-sf-welcome-inr">
					<div class="popupaoc-sf-welcome-left">
						<div class="popupaoc-sf-subtitle">Getting Started</div>
						<h2 class="popupaoc-sf-title">Welcome to Popup Anything</h2>
						<p class="popupaoc-sf-content">Instantly grow your email list, get more leads and increase sales with the #1 most powerful conversion optimization toolkit in the world.</p>
						<a href="<?php echo esc_url( $popup_add_link ); ?>" class="popupaoc-sf-btn">Launch Popup With Free Features</a></br> <b>OR</b> </br><a href="<?php echo POPUPAOC_PLUGIN_LINK_WELCOME; ?>"  target="_blank" class="popupaoc-sf-btn popupaoc-sf-btn-orange">Grab Now Pro Features</a>
						<div class="popupaoc-rc-wrap">
							<div class="popupaoc-rc-inr popupaoc-rc-bg-box">
								<div class="popupaoc-rc-icon">
									<img src="<?php echo esc_url( POPUPAOC_URL ); ?>assets/images/popup-icon/14-days-money-back-guarantee.png" alt="14-days-money-back-guarantee" title="14-days-money-back-guarantee" />
								</div>
								<div class="popupaoc-rc-cont">
									<h3>14 Days Refund Policy</h3>
									<p>14-day No Question Asked Refund Guarantee</p>
								</div>
							</div>
							<div class="popupaoc-rc-inr popupaoc-rc-bg-box">
								<div class="popupaoc-rc-icon">
									<img src="<?php echo esc_url( POPUPAOC_URL ); ?>assets/images/popup-icon/popup-design.png" alt="popup-design" title="popup-design" />
								</div>
								<div class="popupaoc-rc-cont">
									<h3>Include Done-For-You Popup Setup</h3>
									<p>Our conversion experts will design 2 free popup / month for you to get maximum results.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="popupaoc-sf-welcome-right">
						<div class="popupaoc-sf-fp-ttl">Free vs Pro</div>
						<div class="popupaoc-sf-fp-box-wrp">
							<div class="popupaoc-sf-fp-box">
								<i class="dashicons dashicons-desktop"></i>
								<div class="popupaoc-sf-box-ttl">Page Load</div>
								<div class="popupaoc-sf-tag">Free</div>
							</div>
							<div class="popupaoc-sf-fp-box">
								<i class="dashicons dashicons-admin-links"></i>
								<div class="popupaoc-sf-box-ttl">Simple Link</div>
								<div class="popupaoc-sf-tag">Free</div>
							</div>
							<div class="popupaoc-sf-fp-box">
								<i class="dashicons dashicons-format-image"></i>
								<div class="popupaoc-sf-box-ttl">Image Click</div>
								<div class="popupaoc-sf-tag">Free</div>
							</div>
							<div class="popupaoc-sf-fp-box">
								<i class="dashicons dashicons-button"></i>
								<div class="popupaoc-sf-box-ttl">Button Click</div>
								<div class="popupaoc-sf-tag">Free</div>
							</div>
							<div class="popupaoc-sf-fp-box popupaoc-sf-pro-box">
								<i class="dashicons dashicons-no"></i>
								<div class="popupaoc-sf-box-ttl">Inactivity Popup</div>
								<div class="popupaoc-sf-tag">Pro</div>
							</div>
							<div class="popupaoc-sf-fp-box popupaoc-sf-pro-box">
								<i class="dashicons dashicons-arrow-down-alt"></i>
								<div class="popupaoc-sf-box-ttl">Scroll Down</div>
								<div class="popupaoc-sf-tag">Pro</div>
							</div>
							<div class="popupaoc-sf-fp-box popupaoc-sf-pro-box">
								<i class="dashicons dashicons-arrow-up-alt"></i>
								<div class="popupaoc-sf-box-ttl">Scroll Up</div>
								<div class="popupaoc-sf-tag">Pro</div>
							</div>
							<div class="popupaoc-sf-fp-box popupaoc-sf-pro-box">
								<i class="dashicons dashicons-exit"></i>
								<div class="popupaoc-sf-box-ttl">Exit Intent</div>
								<div class="popupaoc-sf-tag">Pro</div>
							</div>
							<div class="popupaoc-sf-fp-box popupaoc-sf-pro-box">
								<i class="dashicons dashicons-external"></i>
								<div class="popupaoc-sf-box-ttl">HTML Element Click</div>
								<div class="popupaoc-sf-tag">Pro</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End - Welcome Box -->
			
			<!-- Start - Popup Anything - Features -->
			<div class="popupaoc-features-section">
				<div class="paoc-center popupaoc-features-ttl">
					<h2 class="popupaoc-sf-ttl">Powerful Pro Features, Simplified</h2>
					<div class="popupaoc-sf-cont">Convert Your Visitors into Subscribers & Customers</div>
				</div>
				<div class="popupaoc-features-section-inr">
					<div class="popupaoc-features-box-wrap">
						<ul class="popupaoc-features-box-grid">
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/popup.png" /></div>
							Modal Popup							
							</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/bar-popup.png" /></div>
							Bar Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/push-popup.png" /></div>
							Push Notification Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/exit-popup.png" /></div>
							Exit Intent Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/popup.png" /></div>
							Annoucement Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/bar-popup.png" /></div>
							Collect Lead Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/link-popup.png" /></div>
							Target URL Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/bar-popup.png" /></div>
							Phone Calls Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/location-popup.png" /></div>
							Geo-Location Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/bar-popup.png" /></div>
							Referrer Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/utm-popup.png" /></div>
							UTM Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/bar-popup.png" /></div>
							Cookie Based Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/ads-popup.png" /></div>
							Adblocker Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/time-popup.png" /></div>
							Schedule Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/bar-popup.png" /></div>
							Inline Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/full-screen-popup.png" /></div>
							Fullscreen Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/slide-in-popup.png" /></div>
							Slide In Popup</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/a-b-testing-popup.png" /></div>
							A/B Testing</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/mail-chimp-popup.png" /></div>
							Mailchimp Integration</li>
							<li>
							<div class="popupaoc-popup-icon"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/popup-icon/popup.png" /></div>
							Popup Live Preview</li>
						</ul>
					</div>
					<a href="<?php echo POPUPAOC_PLUGIN_LINK_WELCOME; ?>" target="_blank" class="popupaoc-sf-btn popupaoc-sf-btn-orange"><span class="dashicons dashicons-cart"></span> Grab Now Pro Features</a>
					<div class="popupaoc-rc-wrap">
						<div class="popupaoc-rc-inr popupaoc-rc-bg-box">
							<div class="popupaoc-rc-icon">
								<img src="<?php echo esc_url( POPUPAOC_URL ); ?>assets/images/popup-icon/14-days-money-back-guarantee.png" alt="14-days-money-back-guarantee" title="14-days-money-back-guarantee" />
							</div>
							<div class="popupaoc-rc-cont">
								<h3>14 Days Refund Policy</h3>
								<p>14-day No Question Asked Refund Guarantee</p>
							</div>
						</div>
						<div class="popupaoc-rc-inr popupaoc-rc-bg-box">
							<div class="popupaoc-rc-icon">
								<img src="<?php echo esc_url( POPUPAOC_URL ); ?>assets/images/popup-icon/popup-design.png" alt="popup-design" title="popup-design" />
							</div>
							<div class="popupaoc-rc-cont">
									<h3>Include Done-For-You Popup Setup</h3>
									<p>Our conversion experts will design 2 free popup / month for you to get maximum results.</p>
								</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End - Popup Anything - Features -->
			
			<!-- Start - Industry Wise Solutions -->
			<div class="paoc-center popupaoc-solutions-section">
				<h2 class="popupaoc-sf-ttl">Industry Wise Solutions</h2>
				<div class="popupaoc-solutions-section-inr">
					<div class="popupaoc-solutions-box-wrap">
						<div class="popupaoc-solutions-box-grid">
							<div class="popupaoc-box-ttl">Publishers</div>
							<ul>
								<li>Grow Your Email List</li>
								<li>Increase Your Pageviews</li>
								<li>Reduce Cart Abandonment</li>
								<li>Targeted Website Messages</li>
								<li>Onsite Retargeting</li>
								<li>Increase Sales Conversion</li>
							</ul>
						</div>
						<div class="popupaoc-solutions-box-grid">
							<div class="popupaoc-box-ttl">E-commerce</div>
							<ul>
								<li>Reduce Cart Abandonment</li>
								<li>Onsite Retargeting</li>
								<li>Increase Sales Conversion</li>
								<li>Grow Your Email List</li>
								<li>Increase Your Pageviews</li>
								<li>Targeted Website Messages</li>
							</ul>
						</div>
						<div class="popupaoc-solutions-box-grid">
							<div class="popupaoc-box-ttl">Agencies</div>
							<ul>
								<li>Custom Branding</li>
								<li>Complete Access Control</li>
								<li>Grow Your Email List</li>
								<li>Increase Your Pageviews</li>
								<li>Targeted Website Messages</li>
								<li>Onsite Retargeting</li>
							</ul>
						</div>
						<div class="popupaoc-solutions-box-grid">
							<div class="popupaoc-box-ttl">B2B</div>
							<ul>
								<li>Grow Your Email List</li>
								<li>Increase Your Pageviews</li>
								<li>Targeted Website Messages</li>
								<li>Custom Branding</li>
								<li>Complete Access Control</li>
								<li>Onsite Retargeting</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- End - Industry Wise Solutions -->

			

			<!-- Start - Testimonial Section -->
			<div class="popupaoc-sf-testimonial-wrap">
				<div class="paoc-center popupaoc-features-ttl">
					<h2 class="popupaoc-sf-ttl">Looking for a Reason to Use Popup Anything? Here are 40+...</h2>				
										
				</div>
				<div class="popupaoc-testimonial-section-inr">
					<div class="popupaoc-testimonial-box-wrap">
						<div class="popupaoc-testimonial-box-grid">
								<h3 class="popupaoc-testimonial-title">Super Helpful, Great Plugin</h3>
								<div class="popupaoc-testimonial-desc">Anytime I run into an issue or run into something I don’t understand the support team is there to assist. Love the plugins they offer for the price they sell it at. All around, great plugin, great support – definitely recommend.</div>
								<div class="popupaoc-testimonial-clnt">@cmnerds</div>
								<div class="popupaoc-testimonial-rating"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/rating.png" /></div>
						</div>
						<div class="popupaoc-testimonial-box-grid">
								<h3 class="popupaoc-testimonial-title">Nice plugin and good customer service</h3>
								<div class="popupaoc-testimonial-desc">Plugin is working well and the customer support was good!.</div>
								<div class="popupaoc-testimonial-clnt">@juuzo</div>
								<div class="popupaoc-testimonial-rating"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/rating.png" /></div>
						</div>
						<div class="popupaoc-testimonial-box-grid">
								<h3 class="popupaoc-testimonial-title">Great plugin and support</h3>
								<div class="popupaoc-testimonial-desc">This plugin enabled me to easily achieve what i needed. I also had responsive support when i needed assistance for an issue i was having that was resolved quickly by the plugin developer.</div>
								<div class="popupaoc-testimonial-clnt">@vivdesign</div>
								<div class="popupaoc-testimonial-rating"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/rating.png" /></div>
						</div>
						
						<div class="popupaoc-testimonial-box-grid">
								<h3 class="popupaoc-testimonial-title">Better than the other pop up plugins</h3>
								<div class="popupaoc-testimonial-desc">the other pop up plugins are complicated and buggy. that is easy and convenient.</div>
								<div class="popupaoc-testimonial-clnt">@carinajae</div>
								<div class="popupaoc-testimonial-rating"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/rating.png" /></div>
						</div>
						<div class="popupaoc-testimonial-box-grid">
								<h3 class="popupaoc-testimonial-title">Awesome support – quick fix on found bug</h3>
								<div class="popupaoc-testimonial-desc">I found a bug in an update. Reported it and they fixed it on my app during chat. Awesome support!</div>
								<div class="popupaoc-testimonial-clnt">@jaltman</div>
								<div class="popupaoc-testimonial-rating"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/rating.png" /></div>
						</div>
						<div class="popupaoc-testimonial-box-grid">
								<h3 class="popupaoc-testimonial-title">Great popup with great support</h3>
								<div class="popupaoc-testimonial-desc">This is a great looking popup with plenty of useful options. Had a few issues with a recent update which were fixed pretty quickly.</div>
								<div class="popupaoc-testimonial-clnt">@joncon62</div>
								<div class="popupaoc-testimonial-rating"><img src="<?php echo POPUPAOC_URL; ?>/assets/images/rating.png" /></div>
						</div>
					</div>
					<a href="https://wordpress.org/support/plugin/popup-anything-on-click/reviews/?filter=5" target="_blank" class="popupaoc-sf-btn"><span class="dashicons dashicons-star-filled"></span> View All Reviews</a> OR <a href="<?php echo POPUPAOC_PLUGIN_LINK_WELCOME; ?>"  target="_blank" class="popupaoc-sf-btn popupaoc-sf-btn-orange">Grab Now Pro Features</a>
					<div class="popupaoc-rc-wrap">
						<div class="popupaoc-rc-inr popupaoc-rc-bg-box">
							<div class="popupaoc-rc-icon">
								<img src="<?php echo esc_url( POPUPAOC_URL ); ?>assets/images/popup-icon/14-days-money-back-guarantee.png" alt="14-days-money-back-guarantee" title="14-days-money-back-guarantee" />
							</div>
							<div class="popupaoc-rc-cont">
								<h3>14 Days Refund Policy</h3>
								<p>14-day No Question Asked Refund Guarantee</p>
							</div>
						</div>
						<div class="popupaoc-rc-inr popupaoc-rc-bg-box">
							<div class="popupaoc-rc-icon">
								<img src="<?php echo esc_url( POPUPAOC_URL ); ?>assets/images/popup-icon/popup-design.png" alt="popup-design" title="popup-design" />
							</div>
							<div class="popupaoc-rc-cont">
									<h3>Include Done-For-You Popup Setup</h3>
									<p>Our conversion experts will design 2 free popup / month for you to get maximum results.</p>
								</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End - Testimonial Section -->
		</div>
	</div><!-- end .popupaoc-sf-wrap -->
</div><!-- end .wrap -->