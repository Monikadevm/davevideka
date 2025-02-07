<script type="text/javascript" src="<?= plugin_dir_url( __DIR__ ).'Scripts/raphael-min.js';?>"></script>
<script type="text/javascript" src="<?= plugin_dir_url( __DIR__ ).'Scripts/jquery.easing.js';?>"></script>
<script>
					(function ($, window, undefined) {
						var Rich_Web_VSlider_ID = jQuery(".Rich_Web_VSlider_ID<?= $Rich_Web_VSlider_ID; ?>").val();
						var iView<?= $Rich_Web_VSlider_ID; ?> = function (el, options) {
							var iv = this;
							iv.options = options;
							iv.sliderContent = el, iv.sliderInner = iv.sliderContent.html();
							iv.sliderContent.html("<div class='iviewSlider'>" + iv.sliderInner + "</div>");
							iv.slider = $('.iviewSlider', iv.sliderContent);
							iv.slider.css('position', 'relative');
							iv.defs = {
								slide: 0,
								total: 0,
								image: '',
								images: [],
								width: iv.sliderContent.width(),
								height: iv.sliderContent.height(),
								timer: options.timer.toLowerCase(),
								lock: false,
								paused: (options.autoAdvance) ? false : true,
								time: options.pauseTime,
								easing: options.easing
							};
							iv.disableSelection(iv.slider[0]);
							iv.slides = iv.slider.children();
							iv.slides.each(function (i) {
								var slide = $(this);
								iv.defs.images.push(slide.data("iview:image"));
								if (slide.data("iview:thumbnail")) iv.defs.images.push(slide.data("iview:thumbnail"));
								slide.css('display', 'none');
								if (slide.data("iview:type") == "video") {
									var element = slide.children().eq(0),
										video = $('<div class="iview-video'+Rich_Web_VSlider_ID+'-show"><div class="iview-video'+Rich_Web_VSlider_ID+'-container"><a class="iview-video'+Rich_Web_VSlider_ID+'-close" title="' + options.closeLabel + '">&#735;</a></div></div>');
									slide.append(video);
									element.appendTo($('div.iview-video'+Rich_Web_VSlider_ID+'-container', video));
									video.css({ width: iv.defs.width, height: iv.defs.height, top: '-' + iv.defs.height + 'px' }).hide();
									slide.addClass('iview-video'+Rich_Web_VSlider_ID+'').css({ 'cursor': 'pointer' });
								}
								iv.defs.total++;
							}).css({ width: iv.defs.width, height: iv.defs.height });
							iv.sliderContent.append('<div id="iview-preloader<?= $Rich_Web_VSlider_ID; ?>"><div></div></div>');
							var iviewPreloader = $('#iview-preloader<?= $Rich_Web_VSlider_ID; ?>', iv.sliderContent);
							var preloaderBar = $('div', iviewPreloader);
							iviewPreloader.css({
								top: ((iv.defs.height / 2) - (iviewPreloader.height() / 2)) + 'px',
								left: ((iv.defs.width / 2) - (iviewPreloader.width() / 2)) + 'px'
							});
							iv.sliderContent.append('<div id="iview-timer<?= $Rich_Web_VSlider_ID; ?>"><div></div></div>');
							iv.iviewTimer = $('#iview-timer<?= $Rich_Web_VSlider_ID; ?>', iv.sliderContent);
							iv.iviewTimer.hide();
							$('.iview-caption', iv.slider).each(function (i) {
								var caption = $(this);
								caption.html('<div class="caption-contain">' + caption.html() + '</div>');
							});
							options.startSlide = (options.randomStart) ? Math.floor(Math.random() * iv.defs.total) : options.startSlide;
							options.startSlide = (options.startSlide > 0 && options.startSlide >= iv.defs.total) ? iv.defs.total - 1 : options.startSlide;
							iv.defs.slide = options.startSlide;
							iv.defs.image = iv.slides.eq(iv.defs.slide);
							iv.defs.time = (iv.defs.image.data('iview:pausetime')) ? iv.defs.image.data('iview:pausetime') : options.pauseTime;
							iv.defs.easing = (iv.defs.image.data('iview:easing')) ? iv.defs.image.data('iview:easing') : options.easing;
							iv.pieDegree = 0;
							var padding = options.timerPadding,
								diameter = options.timerDiameter,
								stroke = options.timerStroke;
							if (iv.defs.total > 1 && iv.defs.timer != "bar") 
							{
								stroke = (iv.defs.timer == "360bar") ? options.timerStroke : 0;
								var width = (diameter + (padding * 2) + (stroke * 2)),
									height = width,
									r = Raphael(iv.iviewTimer[0], width, height);
								iv.R = (diameter / 2);
								var param = {
									stroke: options.timerBg,
									"stroke-width": (stroke + (padding * 2))
								},
								param2 = {
									stroke: options.timerColor,
									"stroke-width": stroke,
									"stroke-linecap": "round"
								},
								param3 = {
									fill: options.timerColor,
									stroke: 'none',
									"stroke-width": 0
								},
								bgParam = {
									fill: options.timerBg,
									stroke: 'none',
									"stroke-width": 0
								};
								r.customAttributes.arc = function (value, R) {
									var total = 360,
										alpha = 360 / total * value,
										a = (90 - alpha) * Math.PI / 180,
										cx = ((diameter / 2) + padding + stroke),
										cy = ((diameter / 2) + padding + stroke),
										x = cx + R * Math.cos(a),
										y = cy - R * Math.sin(a),
										path;
									if (total == value) {
										path = [["M", cx, cy - R], ["A", R, R, 0, 1, 1, 299.99, cy - R]];
									} else {
										path = [["M", cx, cy - R], ["A", R, R, 0, +(alpha > 180), 1, x, y]];
									}
									return {
										path: path
									};
								};
								r.customAttributes.segment = function (angle, R) {
									var a1 = -90;
									R = R - 1;
									angle = (a1 + angle);
									var flag = (angle - a1) > 180,
										x = ((diameter / 2) + padding),
										y = ((diameter / 2) + padding);
									a1 = (a1 % 360) * Math.PI / 180;
									angle = (angle % 360) * Math.PI / 180;
									return {
										path: [["M", x, y], ["l", R * Math.cos(a1), R * Math.sin(a1)], ["A", R, R, 0, +flag, 1, x + R * Math.cos(angle), y + R * Math.sin(angle)], ["z"]]
									};
								};
								if (iv.defs.total > 1 && iv.defs.timer == "pie") {
									r.circle(iv.R + padding, iv.R + padding, iv.R + padding - 1).attr(bgParam);
								}
								iv.timerBgPath = r.path().attr(param), iv.timerPath = r.path().attr(param2), iv.pieTimer = r.path().attr(param3);
							}
							iv.barTimer = $('div', iv.iviewTimer);
							if (iv.defs.total > 1 && iv.defs.timer == "360bar") { iv.timerBgPath.attr({ arc: [359.9, iv.R] }); }
							if (iv.defs.timer == "bar") 
							{
								iv.iviewTimer.css({
									opacity: options.timerOpacity,
									width: diameter,
									height: stroke,
									border: options.timerBarStroke + 'px ' + options.timerBarStrokeColor + ' ' + options.timerBarStrokeStyle,
									padding: padding,
									background: options.timerBg
								});
								iv.barTimer.css({
									width: 0,
									height: stroke,
									background: options.timerColor,
									'float': 'left'
								});
							}
							else
							{
								iv.iviewTimer.css({
									opacity: options.timerOpacity,
									width: width,
									height: height
								});
							}
							iv.setTimerPosition();
							new ImagePreload(iv.defs.images, function (i) {
								var percent = (i * 10);
							}, function () {
								preloaderBar.stop().animate({
								}, function () {
									iviewPreloader.remove();
									iv.startSlider();
									options.onAfterLoad.call(this);
								});
							});
							iv.sliderContent.bind('swipeleft', function () {
								if (iv.defs.lock) return false;
								iv.cleanTimer();
								iv.goTo('next');
							}).bind('swiperight', function () {
								if (iv.defs.lock) return false;
								iv.cleanTimer();
								iv.defs.slide -= 2;
								iv.goTo('prev');
							});
							if (options.keyboardNav) 
							{
								$(document).bind('keyup.iView<?= $Rich_Web_VSlider_ID; ?>', function (event) {
									if (event.keyCode == '37') {
										if (iv.defs.lock) return false;
										iv.cleanTimer();
										iv.defs.slide -= 2;
										iv.goTo('prev');
									}
									if (event.keyCode == '39') {
										if (iv.defs.lock) return false;
										iv.cleanTimer();
										iv.goTo('next');
									}
								});
							}
							iv.iviewTimer.on('click', function () { if (iv.iviewTimer.hasClass('paused')) { iv.playSlider(); } else { iv.stopSlider(); } });
							iv.sliderContent.bind('iView<?= $Rich_Web_VSlider_ID; ?>:pause', function () { iv.stopSlider(); });
							iv.sliderContent.bind('iView<?= $Rich_Web_VSlider_ID; ?>:play', function () { iv.playSlider(); });
							iv.sliderContent.bind('iView<?= $Rich_Web_VSlider_ID; ?>:previous', function () {
								if (iv.defs.lock) return false;
								iv.cleanTimer();
								iv.defs.slide -= 2;
								iv.goTo('prev');
							});
							iv.sliderContent.bind('iView<?= $Rich_Web_VSlider_ID; ?>:next', function () {
								if (iv.defs.lock) return false;
								iv.cleanTimer();
								iv.goTo('next');
							});
							iv.sliderContent.bind('iView<?= $Rich_Web_VSlider_ID; ?>:goSlide', function (event, slide) {
								if (iv.defs.lock || iv.defs.slide == slide) return false;
								if ($(this).hasClass('active')) return false;
								iv.cleanTimer();
								iv.slider.css('background', 'url("' + iv.defs.image.data('iview:image') + '") no-repeat');
								iv.slider.css('background-size', ''+jQuery("#iview"+Rich_Web_VSlider_ID).width()+'px '+jQuery("#iview"+Rich_Web_VSlider_ID).height()+'px');
								iv.defs.slide = slide - 1;
								iv.goTo('control');
							});
							iv.sliderContent.bind('resize', function () {
								t = $(this),
								tW = t.width(),
								tH = t.height(),
								width = iv.slider.width(),
								height = iv.slider.height();
								if(iv.defs.width != tW){
									var ratio = (tW / width),
										newHeight = Math.round(iv.defs.height * ratio);
									iv.slider.css({
										'-webkit-transform-origin' : '0 0',
										'-moz-transform-origin' : '0 0',
										'-o-transform-origin' : '0 0',
										'-ms-transform-origin' : '0 0',
										'transform-origin' : '0 0',
										'-webkit-transform' : 'scale('+ ratio +')',
										'-moz-transform' : 'scale('+ ratio +')',
										'-o-transform' : 'scale('+ ratio +')',
										'-ms-transform' : 'scale('+ ratio +')',
										'transform' : 'scale('+ ratio +')'
									});
									t.css({ height: newHeight });
									iv.defs.width = tW;
									iv.setTimerPosition();
								}
							});
				$(window).load(function() {			
				var elements = jQuery( '.iview-video'+Rich_Web_VSlider_ID+'' );
				jQuery(elements).each(function(index, el){
                    if(jQuery(el).data('iview:image').length == "0"){
                       	jQuery(el).find('.iview-video'+Rich_Web_VSlider_ID+'-show').css('display','block');
                       	jQuery(el).find('#video_iframe').contents().find("body").html('<video id="videoId" controls loop style="height:92%; width:97%; position:absolute;left: 0;right: 0;margin: auto;top: 0;bottom: 0;outline:none"  name="media"><source src="'+jQuery(el).data('iview:src')+'" type="video/mp4"></video>');
                   }
                   jQuery(el).find('#video_iframe').contents().find("body").click(function(){
                        iv.sliderContent.trigger('iView<?= $Rich_Web_VSlider_ID; ?>:pause');
                        jQuery('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?>').css('display','none');
                   });
				});
				current_slide_key = $('.iview-control.active').attr('rel');
				var t = jQuery( '.iview-video'+Rich_Web_VSlider_ID+'' ).eq(current_slide_key);
				if(jQuery(t).data('iview:image')==""){
					iv.sliderContent.trigger('iView<?= $Rich_Web_VSlider_ID; ?>:play');
  					video = $('.iview-video'+Rich_Web_VSlider_ID+'-show', t);
						var str = t.data('iview:src');
						if(str.indexOf("mp4") >= 0 === true){
                    	    iframe = $('iframe', video);
							src = jQuery(iframe).attr('src');
							var this_iframe = jQuery(t).find('#video_iframe');
                    		this_iframe.contents().find("body").html('<video id="videoId" controls loop style="height:92%; width:97%; position:absolute;left: 0;right: 0;margin: auto;top: 0;bottom: 0;outline:none" name="media"><source src="'+t.data('iview:src')+'" type="video/mp4"></video>');
                        }
					jQuery('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?>').css('display','none');
				}
				});
// end document ready 
			$('.iview-video'+Rich_Web_VSlider_ID+'', iv.slider).click(function(e){
			iv.sliderContent.trigger('iview<?= $Rich_Web_VSlider_ID; ?>:pause');
			var t = $(this),
			video = $('.iview-video'+Rich_Web_VSlider_ID+'-show', t);
				if(!$(e.target).hasClass('iview-video'+Rich_Web_VSlider_ID+'-close') && !$(e.target).hasClass('iview-caption') && !$(e.target).parents().hasClass('iview-caption')){
					var str = t.data('iview:src');
					iframe = $('iframe', video),
					src = jQuery(iframe).attr('src');
					iframe.removeAttr('src').attr('src',t.data('iview:src'));
					video.show().animate({ top: 0 }, 1200, 'easeOutBounce');
					iv.sliderContent.trigger('iView<?= $Rich_Web_VSlider_ID; ?>:pause');
				}
					video.show().animate({ top: 0 }, 1200, 'easeOutBounce');
					jQuery('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?>').css('display','none');
					});

			$('.iview-video'+Rich_Web_VSlider_ID+'-close', iv.slider).click(function(){
				current_slide_key = $('.iview-control.active').attr('rel');
						var this_iview_video = jQuery( '.iview-video'+Rich_Web_VSlider_ID+'' ).eq(current_slide_key);
					if(jQuery(this_iview_video).data('iview:image') != ""){
                        jQuery('.iview-video<?= $Rich_Web_VSlider_ID; ?>').trigger('iview<?= $Rich_Web_VSlider_ID; ?>:pause');
						iv.sliderContent.trigger('iView<?= $Rich_Web_VSlider_ID; ?>').stop();
						var video = $(this).parents('.iview-video'+Rich_Web_VSlider_ID+'-show');
						iv.sliderContent.trigger('iView<?= $Rich_Web_VSlider_ID; ?>:pause');
						iframe = $('iframe', video),
						src = iframe.attr('src');
						iframe.removeAttr('src').attr('src','');
						video.animate({ top: '-' + iv.defs.height + 'px' }, 1200, 'easeOutBounce', function(){
						video.hide();
						iv.sliderContent.trigger('iView<?= $Rich_Web_VSlider_ID; ?>:play');
						jQuery('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?>').css('display','none');
							jQuery('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?>').css('display','block');
						});
					}
					else if(jQuery(this_iview_video).data('iview:image') == ""){
						var elements = jQuery( '.iview-video'+Rich_Web_VSlider_ID+'' );			
						jQuery('.iview-video<?= $Rich_Web_VSlider_ID; ?>').trigger('iview<?= $Rich_Web_VSlider_ID; ?>:pause');
						var video = $(this).parents('.iview-video'+Rich_Web_VSlider_ID+'-show');
						iv.sliderContent.trigger('iView<?= $Rich_Web_VSlider_ID; ?>:pause');
						video.animate({ top: '-' + iv.defs.height + 'px' }, 1200, 'easeOutBounce', function(){
						jQuery('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?>').css('display','none');
						jQuery('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?>').css('display','block');
							});
						}			
				});
			};
				jQuery(window).on('load', function(){
						jQuery('.iview-control').click(function(e){
							jQuery('#iview'+Rich_Web_VSlider_ID).trigger('iView<?= $Rich_Web_VSlider_ID; ?>:pause');
							setTimeout(function(){
								current_slide = $('.iview-control.active').attr('rel');
								var this_iview_video = jQuery( '.iview-video'+Rich_Web_VSlider_ID+'' ).eq(current_slide);
									if(jQuery(this_iview_video).data('iview:image')==""){
										jQuery( '.iview-video'+Rich_Web_VSlider_ID+'' ).removeData('iview:image');
										video = $('.iview-video'+Rich_Web_VSlider_ID+'-show');
										iframe = $('iframe', video);
										jQuery(iframe).removeAttr('src').attr('src','');
										var active = jQuery('.iview-items').find('.iview-control');
										jQuery(active).each(function(index, el){
										setTimeout(function(){
										if(jQuery(el).hasClass('iview-control active')){
		                                current_slide_key = jQuery(el).attr('rel');
										var t = jQuery( '.iview-video'+Rich_Web_VSlider_ID+'' ).eq(current_slide_key);
										if(!$(t.target).hasClass('iview-video'+Rich_Web_VSlider_ID+'-close') && !$(t.target).hasClass('iview-caption') && !$(t.target).parents().hasClass('iview-caption')){
											var str = t.data('iview:src');
											video = $('.iview-video'+Rich_Web_VSlider_ID+'-show', t);
											iframe = $('iframe', video);
											src = jQuery(iframe).attr('src');
											iframe.attr('src',t.data('iview:src'));
											jQuery(t).find('.iview-video<?= $Rich_Web_VSlider_ID; ?>-show').css('display','block');
										}
										jQuery('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?>').css('display','none');
		                                   	}
											},10);
		                                });  
								}
								if(jQuery(this_iview_video).data('iview:image')!=""){
								video = $('.iview-video'+Rich_Web_VSlider_ID+'-show');
								iframe = $('iframe', video);
								jQuery(iframe).removeAttr('src').attr('src','');
								}
							},10);
					});
							jQuery('.iview-controlPrevNav'+Rich_Web_VSlider_ID).click(function(){
                               	jQuery('#iview'+Rich_Web_VSlider_ID).trigger('iView<?= $Rich_Web_VSlider_ID; ?>:pause');
								setTimeout(function(){
									current_slide = $('.iview-control.active').attr('rel');
									var this_iview_video = jQuery( '.iview-video'+Rich_Web_VSlider_ID+'' ).eq(current_slide);
									if(jQuery(this_iview_video).data('iview:image')==""){
										jQuery( '.iview-video'+Rich_Web_VSlider_ID+'' ).removeData('iview:image');
										jQuery(this_iview_video).data('iview:image')
										video = $('.iview-video'+Rich_Web_VSlider_ID+'-show');
										iframe = $('iframe', video);
										jQuery(iframe).removeAttr('src').attr('src','');
										var active = jQuery('.iview-items').find('.iview-control');
										jQuery(active).each(function(index, el){
										setTimeout(function(){
										if(jQuery(el).hasClass('iview-control active')){
		                                current_slide_key = jQuery(el).attr('rel');
										var t = jQuery( '.iview-video'+Rich_Web_VSlider_ID+'' ).eq(current_slide_key);
										if(!$(t.target).hasClass('iview-video'+Rich_Web_VSlider_ID+'-close') && !$(t.target).hasClass('iview-caption') && !$(t.target).parents().hasClass('iview-caption')){
											var str = t.data('iview:src');
											video = $('.iview-video'+Rich_Web_VSlider_ID+'-show', t);
											iframe = $('iframe', video);
											src = jQuery(iframe).attr('src');
											iframe.attr('src',t.data('iview:src'));
											jQuery(t).find('.iview-video<?= $Rich_Web_VSlider_ID; ?>-show').css('display','block');
										}
										jQuery('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?>').css('display','none');
		                                   	}
											},10);
		                                });  
										}
										if(jQuery(this_iview_video).data('iview:image')!=""){
										video = $('.iview-video'+Rich_Web_VSlider_ID+'-show');
										iframe = $('iframe', video);
										jQuery(iframe).removeAttr('src').attr('src','');
										}
							},10);
								});

							jQuery('.iview-controlNextNav').click(function(){
                               	jQuery('#iview'+Rich_Web_VSlider_ID).trigger('iView<?= $Rich_Web_VSlider_ID; ?>:pause');
							setTimeout(function(){
								current_slide = $('.iview-control.active').attr('rel');
								var this_iview_video = jQuery( '.iview-video'+Rich_Web_VSlider_ID+'' ).eq(current_slide);
								if(jQuery(this_iview_video).data('iview:image')==""){
									jQuery( '.iview-video'+Rich_Web_VSlider_ID+'' ).removeData('iview:image');
									video = $('.iview-video'+Rich_Web_VSlider_ID+'-show');
									iframe = $('iframe', video);
									jQuery(iframe).removeAttr('src').attr('src','');
									var active = jQuery('.iview-items').find('.iview-control');
									jQuery(active).each(function(index, el){
									setTimeout(function(){
									if(jQuery(el).hasClass('iview-control active')){
	                                current_slide_key = jQuery(el).attr('rel');
									var t = jQuery( '.iview-video'+Rich_Web_VSlider_ID+'' ).eq(current_slide_key);
									if(!$(t.target).hasClass('iview-video'+Rich_Web_VSlider_ID+'-close') && !$(t.target).hasClass('iview-caption') && !$(t.target).parents().hasClass('iview-caption')){
										var str = t.data('iview:src');
										video = $('.iview-video'+Rich_Web_VSlider_ID+'-show', t);
										iframe = $('iframe', video);
										src = jQuery(iframe).attr('src');
										iframe.attr('src',t.data('iview:src'));
										jQuery(t).find('.iview-video<?= $Rich_Web_VSlider_ID; ?>-show').css('display','block');
									}
									jQuery('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?>').css('display','none');
	                                   	}
										},10);
	                                });  
									}
									if(jQuery(this_iview_video).data('iview:image')!=""){
									video = $('.iview-video'+Rich_Web_VSlider_ID+'-show');
									iframe = $('iframe', video);
									jQuery(iframe).removeAttr('src').attr('src','');
									}
							},10);
								});
					});
						iView<?= $Rich_Web_VSlider_ID; ?>.prototype = {
							timer: null,
							startSlider: function () {
								var iv = this;
								var img = new Image();
								img.src = iv.slides.eq(0).data('iview:image');
								imgWidth = img.width;
								if(imgWidth != iv.defs.width){ iv.defs.width = imgWidth; iv.sliderContent.trigger('resize'); }
								iv.iviewTimer.show();
								iv.slides.eq(iv.defs.slide).css('display', 'block');
								iv.slider.css('background', 'url("' + iv.defs.image.data('iview:image') + '") no-repeat');
								iv.slider.css('background-size', ''+jQuery("#iview"+Rich_Web_VSlider_ID).width()+'px '+jQuery("#iview"+Rich_Web_VSlider_ID).height()+'px');
								iv.setCaption(iv.options);
								iv.iviewTimer.addClass('paused').attr('title', iv.options.playLabel);
								if (iv.options.autoAdvance && iv.defs.total > 1) { iv.iviewTimer.removeClass('paused').attr('title', iv.options.pauseLabel); iv.setTimer(); }
								if (iv.options.directionNav)
								{
									iv.sliderContent.append('<div class="iview-directionNav<?= $Rich_Web_VSlider_ID; ?>"><a class="iview-prevNav<?= $Rich_Web_VSlider_ID; ?>" title="' + iv.options.previousLabel + '">' + iv.options.previousLabel + '</a><a class="iview-nextNav" title="' + iv.options.nextLabel + '">' + iv.options.nextLabel + '</a></div>');
									$('.iview-directionNav<?= $Rich_Web_VSlider_ID; ?>', iv.sliderContent).css({ opacity: iv.options.directionNavHoverOpacity });
									iv.sliderContent.hover(function () {
										$('.iview-directionNav<?= $Rich_Web_VSlider_ID; ?>', iv.sliderContent).stop().animate({ opacity: 1 }, 300);
									}, function () {
										$('.iview-directionNav<?= $Rich_Web_VSlider_ID; ?>', iv.sliderContent).stop().animate({ opacity: iv.options.directionNavHoverOpacity }, 300);
									});
									$('a.iview-prevNav<?= $Rich_Web_VSlider_ID; ?>', iv.sliderContent).on('click', function () {
										if (iv.defs.lock) return false;
										iv.cleanTimer();
										iv.defs.slide -= 2;
										iv.goTo('prev');
									});
									$('a.iview-nextNav', iv.sliderContent).on('click', function () {
										if (iv.defs.lock) return false;
										iv.cleanTimer();
										iv.goTo('next');
									});
								}
								if (iv.options.controlNav) {
									var iviewControl = '<div class="iview-controlNav<?= $Rich_Web_VSlider_ID; ?>">',	iviewTooltip = '';
									if (!iv.options.directionNav && iv.options.controlNavNextPrev) iviewControl += '<a class="iview-controlPrevNav<?= $Rich_Web_VSlider_ID; ?>" title="' + iv.options.previousLabel + '">' + iv.options.previousLabel + '</a>';
									iviewControl += '<div class="iview-items"><ul>';
									for (var i = 0; i < iv.defs.total; i++)
									{
										var slide = iv.slides.eq(i);
										iviewControl += '<li>';
										if (iv.options.controlNavThumbs)
										{
											var thumb = (slide.data('iview:thumbnail')) ? slide.data('iview:thumbnail') : slide.data('iview:image');
											iviewControl += '<a class="iview-control" rel="' + i + '"><img class="iview-control_img" src="' + thumb + '" /></a>';
										}
										else
										{
											var thumb = (slide.data('iview:thumbnail')) ? slide.data('iview:thumbnail') : slide.data('iview:image');
											iviewControl += '<a class="iview-control" rel="' + i + '">' + (i + 1) + '</a>';
											if (iv.options.controlNavTooltip && thumb != "") iviewTooltip += '<div rel="' + i + '"><img class="iview-control_img" src="' + thumb + '" /></div>';
											else if( thumb == ""){iviewTooltip += '<div rel="' + i + '"></div>'}
											
										}
										iviewControl += '</li>';
									}
									iviewControl += '</ul></div>';
									if (!iv.options.directionNav && iv.options.controlNavNextPrev) iviewControl += '<a class="iview-controlNextNav" title="' + iv.options.nextLabel + '">' + iv.options.nextLabel + '</a>';
									iviewControl += '</div>';
									if (!iv.options.controlNavThumbs && iv.options.controlNavTooltip) iviewControl += '<div id="iview-tooltip"><div class="holder"><div class="container">' + iviewTooltip + '</div></div></div>';
									iv.sliderContent.append(iviewControl);
									$('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?> a.iview-control:eq(' + iv.defs.slide + ')', iv.sliderContent).addClass('active');
									$('a.iview-controlPrevNav<?= $Rich_Web_VSlider_ID; ?>', iv.sliderContent).on('click', function () {
										if (iv.defs.lock) return false;
										iv.cleanTimer();
										iv.defs.slide -= 2;
										iv.goTo('prev');
									});
									$('a.iview-controlNextNav', iv.sliderContent).on('click', function () { if (iv.defs.lock) return false; iv.cleanTimer(); iv.goTo('next'); });
									$('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?> a.iview-control', iv.sliderContent).on('click', function () {
										if (iv.defs.lock) return false;
										if ($(this).hasClass('active')) return false;
										iv.cleanTimer();
										iv.slider.css('background', 'url("' + iv.defs.image.data('iview:image') + '") no-repeat');
										iv.slider.css('background-size', ''+jQuery("#iview"+Rich_Web_VSlider_ID).width()+'px '+jQuery("#iview"+Rich_Web_VSlider_ID).height()+'px');
										iv.defs.slide = $(this).attr('rel') - 1;
										iv.goTo('control');
									});
									$('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?>', iv.sliderContent).css({ opacity: iv.options.controlNavHoverOpacity });
									iv.sliderContent.hover(function () {
										$('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?>', iv.sliderContent).stop().animate({ opacity: 1 }, 300);
										iv.sliderContent.addClass('iview-hover');
									},
									 function () {
										$('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?>', iv.sliderContent).stop().animate({ opacity: iv.options.controlNavHoverOpacity }, 300);
										iv.sliderContent.removeClass('iview-hover');
									});

									var tooltipTimer = null;
									$('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?> a.iview-control', iv.sliderContent).hover(function (e) {
										var t = $(this),
											i = t.attr('rel'),
											tooltip = $('#iview-tooltip', iv.sliderContent),
											holder = $('div.holder', tooltip),
											x = t.offset().left - iv.sliderContent.offset().left - (tooltip.outerWidth() / 2) + iv.options.tooltipX,
											y = t.offset().top - iv.sliderContent.offset().top - tooltip.outerHeight() + iv.options.tooltipY,
											imD = $('div[rel=' + i + ']')
											scrollLeft = (i * imD.width());
										tooltip.stop().animate({ left: x, top: y, opacity: 1 }, 300);
										if (tooltip.not(':visible')) tooltip.fadeIn(300);
										holder.stop().animate({ scrollLeft: scrollLeft }, 300);
										clearTimeout(tooltipTimer);
									}, function (e) {
										var tooltip = $('#iview-tooltip', iv.sliderContent);
										tooltipTimer = setTimeout(function () { tooltip.animate({ opacity: 0 }, 300, function () { tooltip.hide(); }); }, 200);
									});
									function resp<?= $Rich_Web_VSlider_ID; ?>()
									{
										if(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').width() <= 90+<?= count($Rich_Web_VSlider_Videos)*17;?>+25 || jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').width() <= 400)
										{
											jQuery(".iview-controlNav<?= $Rich_Web_VSlider_ID; ?> div.iview-items").addClass('iview-items_Anim');
										}
										else
										{
											jQuery(".iview-controlNav<?= $Rich_Web_VSlider_ID; ?> div.iview-items").removeClass('iview-items_Anim');
										}
										if(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').width() <= 400)
										{
											jQuery(".iview-controlNav<?= $Rich_Web_VSlider_ID; ?> a.iview-controlPrevNav<?= $Rich_Web_VSlider_ID; ?>,.iview-controlNav<?= $Rich_Web_VSlider_ID; ?> a.iview-controlNextNav").css({"width":"30px","height":"30px"});
											jQuery(".iview-controlNav<?= $Rich_Web_VSlider_ID; ?>").css("height","30px");
										}
										else
										{
											jQuery(".iview-controlNav<?= $Rich_Web_VSlider_ID; ?> a.iview-controlPrevNav<?= $Rich_Web_VSlider_ID; ?>,.iview-controlNav<?= $Rich_Web_VSlider_ID; ?> a.iview-controlNextNav").css({"width":"44px","height":"44px"});
											jQuery(".iview-controlNav<?= $Rich_Web_VSlider_ID; ?>").css("height","44px");
										}
									}
									resp<?= $Rich_Web_VSlider_ID; ?>();
									jQuery(window).resize(function(){ resp<?= $Rich_Web_VSlider_ID; ?>(); })
								}
								iv.sliderContent.bind('mouseover.iView<?= $Rich_Web_VSlider_ID; ?> mousemove.iView<?= $Rich_Web_VSlider_ID; ?>', function () {
									if (iv.options.pauseOnHover && !iv.defs.paused) iv.cleanTimer();
									iv.sliderContent.addClass('iView<?= $Rich_Web_VSlider_ID; ?>-hover');
								}).bind('mouseout.iView<?= $Rich_Web_VSlider_ID; ?>', function () {
									if (iv.options.pauseOnHover && !iv.defs.paused && iv.timer == null && iv.pieDegree <= 359 && iv.options.autoAdvance) iv.setTimer();
									iv.sliderContent.removeClass('iview-hover');
								});
							},
							setCaption: function () {
								var iv = this,
									slide = iv.slides.eq(iv.defs.slide),
									captions = $('.iview-caption', slide),
									timeEx = 0;
								captions.each(function (i) {
									var caption = $(this),
										fx = (caption.data('transition')) ? $.trim(caption.data('transition').toLowerCase()) : "fade",
										speed = (caption.data('speed')) ? caption.data('speed') : iv.options.captionSpeed,
										easing = (caption.data('easing')) ? caption.data('easing') : iv.options.captionEasing,
										x = (caption.data('x')!="undefined") ? caption.data('x') : "center",
										y = (caption.data('y')!="undefined") ? caption.data('y') : "center",
										w = (caption.data('width')) ? caption.data('width') : caption.width(),
										h = (caption.data('height')) ? caption.data('height') : caption.height(),
										oW = caption.outerWidth(),
										oH = caption.outerHeight();
										if(x == "center") x = ((iv.defs.width/2) - (oW/2));
										if(y == "center") y = ((iv.defs.height/2) - (oH/2));
									var captionContain = $('.caption-contain', caption);
									caption.css({ opacity: 0 });
									captionContain.css({ opacity: 0, position: 'relative', width: w, height: h });
									switch (fx) {
									case "wipedown":
										caption.css({ top: (y - h), left: x });
										captionContain.css({ top: (h + (h * 3)), left: 0 });
										break;
									case "wipeup":
										caption.css({ top: (y + h), left: x });
										captionContain.css({ top: (h - (h * 3)), left: 0 });
										break;
									case "wiperight":
										caption.css({ top: y, left: (x - w) });
										captionContain.css({ top: 0, left: (w + (w * 2)) });
										break;
									case "wipeleft":
										caption.css({ top: y, left: (x + w) });
										captionContain.css({ top: 0, left: (w - (w * 2)) });
										break;
									case "fade":
										caption.css({ top: y, left: x });
										captionContain.css({ top: 0, left: 0 });
										break;
									case "expanddown":
										caption.css({ top: y, left: x, height: 0 });
										captionContain.css({ top: (h + (h * 3)), left: 0 });
										break;
									case "expandup":
										caption.css({ top: (y + h), left: x, height: 0 });
										captionContain.css({ top: (h - (h * 3)), left: 0 });
										break;
									case "expandright":
										caption.css({ top: y, left: x, width: 0 });
										captionContain.css({ top: 0, left: (w + (w * 2)) });
										break;
									case "expandleft":
										caption.css({ top: y, left: (x + w), width: 0 });
										captionContain.css({ top: 0, left: (w - (w * 2)) });
										break;
									}
									setTimeout(function (){ caption.animate({ opacity: iv.options.captionOpacity, top: y, left: x, width: w, height: h }, speed, easing, function (){});}, timeEx);
									setTimeout(function (){ captionContain.animate({ opacity: iv.options.captionOpacity, top: 0, left: 0 }, speed, easing); }, (timeEx + 100));
									timeEx += 250;
								});
							},
							processTimer: function () {
								var iv = this;
								if (iv.defs.timer == "360bar") 
								{
									var degree = (iv.pieDegree == 0) ? 0 : iv.pieDegree + .9;
									iv.timerPath.attr({ arc: [degree, iv.R] });
								}
								else if (iv.defs.timer == "pie")
								{
									var degree = (iv.pieDegree == 0) ? 0 : iv.pieDegree + .9;
									iv.pieTimer.attr({ segment: [degree, iv.R] });
								}
								else
								{
									iv.barTimer.css({ width: ((iv.pieDegree / 360) * 100) + '%' });
								}
								iv.pieDegree += 3;
							},
							transitionEnd: function (iv) {
								iv.options.onAfterChange.call(this);
								iv.defs.lock = false;
								iv.slides.css('display', 'none');
								iv.slides.eq(iv.defs.slide).show();
								iv.slider.css('background', 'url("' + iv.defs.image.data('iview:image') + '") no-repeat');
								iv.slider.css('background-size', ''+jQuery("#iview"+Rich_Web_VSlider_ID).width()+'px '+jQuery("#iview"+Rich_Web_VSlider_ID).height()+'px');
								$('.iview-strip<?= $Rich_Web_VSlider_ID; ?>, .iview-block<?= $Rich_Web_VSlider_ID; ?>', iv.slider).remove();
								iv.defs.time = (iv.defs.image.data('iview:pausetime')) ? iv.defs.image.data('iview:pausetime') : iv.options.pauseTime;
								iv.iviewTimer.animate({ opacity: iv.options.timerOpacity });
								iv.pieDegree = 0;
								iv.processTimer();
								iv.setCaption(iv.options);
								if (iv.timer == null && !iv.defs.paused) iv.timer = setInterval(function () {
									iv.timerCall(iv);
									jQuery('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?>').css('display','block');
								}, (iv.defs.time / 120));
							},
							addStrips: function (vertical, opts) {
								var iv = this;
								opts = (opts) ? opts : iv.options;
								for (var i = 0; i < opts.strips; i++)
								{
									var stripWidth = Math.round(iv.slider.width() / opts.strips),
										stripHeight = Math.round(iv.slider.height() / opts.strips),
										bgPosition = '-' + ((stripWidth + (i * stripWidth)) - stripWidth) + 'px 0%',
										top = ((vertical) ? (stripHeight * i) + 'px' : '0px'),
										left = ((vertical) ? '0px' : (stripWidth * i) + 'px');
									if (vertical) bgPosition = '0% -' + ((stripHeight + (i * stripHeight)) - stripHeight) + 'px';
									if (i == opts.strips - 1)
									{
										var width = ((vertical) ? '0px' : (iv.slider.width() - (stripWidth * i)) + 'px'),
											height = ((vertical) ? (iv.slider.height() - (stripHeight * i)) + 'px' : '0px');
									}
									else
									{
										var width = ((vertical) ? '0px' : stripWidth + 'px'),
											height = ((vertical) ? stripHeight + 'px' : '0px');
									}
									var strip = $('<div class="iview-strip<?= $Rich_Web_VSlider_ID; ?>"></div>').css({
										width: width,
										height: height,
										top: top,
										left: left,
										background: 'url("' + iv.defs.image.data('iview:image') + '") no-repeat ' + bgPosition,
										backgroundSize: ''+jQuery("#iview"+Rich_Web_VSlider_ID).width()+'px '+jQuery("#iview"+Rich_Web_VSlider_ID).height()+'px',
										opacity: 0
									});
									iv.slider.append(strip);
								}
							},
							addBlocks: function () {
								var iv = this,
									blockWidth = Math.ceil(iv.slider.width() / iv.options.blockCols),
									blockHeight = Math.ceil(iv.slider.height() / iv.options.blockRows);
								for (var rows = 0; rows < iv.options.blockRows; rows++)
								{
									for (var columns = 0; columns < iv.options.blockCols; columns++)
									{
										var top = (rows * blockHeight) + 'px',
											left = (columns * blockWidth) + 'px',
											width = blockWidth + 'px',
											height = blockHeight + 'px',
											bgPosition = '-' + ((blockWidth + (columns * blockWidth)) - blockWidth) + 'px -' + ((blockHeight + (rows * blockHeight)) - blockHeight) + 'px';
										if (columns == iv.options.blockCols - 1) width = Math.ceil(iv.slider.width() - (blockWidth * columns)) + 'px';
										var block = $('<div class="iview-block<?= $Rich_Web_VSlider_ID; ?>"></div>').css({
											width: blockWidth + 'px',
											height: blockHeight + 'px',
											top: (rows * blockHeight) + 'px',
											left: (columns * blockWidth) + 'px',
											background: 'url("' + iv.defs.image.data('iview:image') + '") no-repeat ' + bgPosition,
											backgroundSize: ''+jQuery("#iview"+Rich_Web_VSlider_ID).width()+'px '+jQuery("#iview"+Rich_Web_VSlider_ID).height()+'px',
											opacity: 0
										});
										iv.slider.append(block);
									}
								}
							},
							runTransition: function (fx) {
								var iv = this;
								switch (fx) {
								case 'strip-up-right':
								case 'strip-up-left':
									iv.addStrips();
									var timeDelay = 0;
									i = 0, strips = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>', iv.slider);
									if (fx == 'strip-up-left') strips = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>', iv.slider).reverse();
									strips.each(function () {
										var strip = $(this);
										strip.css({ top: '', bottom: '0px' });
										setTimeout(function () {
											strip.animate({ height: '100%', opacity: '1.0' }, iv.options.animationSpeed, iv.defs.easing, function () { if (i == iv.options.strips - 1) iv.transitionEnd(iv);
												i++;
											});
										}, (100 + timeDelay));
										timeDelay += 50;
									});
									break;
								case 'strip-down':
								case 'strip-down-right':
								case 'strip-down-left':
									iv.addStrips();
									var timeDelay = 0,
										i = 0,
										strips = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>', iv.slider);
									if (fx == 'strip-down-left') strips = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>', iv.slider).reverse();
									strips.each(function () {
										var strip = $(this);
										strip.css({ bottom: '', top: '0px' });
										setTimeout(function () {
											strip.animate({ height: '100%', opacity: '1.0' }, iv.options.animationSpeed, iv.defs.easing, function () { if (i == iv.options.strips - 1) iv.transitionEnd(iv);
												i++;
											});
										}, (100 + timeDelay));
										timeDelay += 50;
									});
									break;
								case 'strip-left-right':
								case 'strip-left-right-up':
								case 'strip-left-right-down':
									iv.addStrips(true);
									var timeDelay = 0,
										i = 0,
										v = 0,
										strips = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>', iv.slider);
									if (fx == 'strip-left-right-down') strips = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>', iv.slider).reverse();
									strips.each(function () {
										var strip = $(this);
										if (i == 0)
										{
											strip.css({ right: '', left: '0px' });
											i++;
										}
										else
										{
											strip.css({ left: '', right: '0px' });
											i = 0;
										}
										setTimeout(function () {
											strip.animate({ width: '100%', opacity: '1.0' }, iv.options.animationSpeed, iv.defs.easing, function () { if (v == iv.options.strips - 1) iv.transitionEnd(iv);
												v++;
											});
										}, (100 + timeDelay));
										timeDelay += 50;
									});
									break;
								case 'strip-up-down':
								case 'strip-up-down-right':
								case 'strip-up-down-left':
									iv.addStrips();
									var timeDelay = 0,
										i = 0,
										v = 0,
										strips = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>', iv.slider);
									if (fx == 'strip-up-down-left') strips = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>', iv.slider).reverse();
									strips.each(function () {
										var strip = $(this);
										if (i == 0)
										{
											strip.css({ bottom: '', top: '0px' });
											i++;
										}
										else
										{
											strip.css({ top: '', bottom: '0px' });
											i = 0;
										}
										setTimeout(function () {
											strip.animate({ height: '100%', opacity: '1.0' }, iv.options.animationSpeed, iv.defs.easing, function () { if (v == iv.options.strips - 1) iv.transitionEnd(iv);
												v++;
											});
										}, (100 + timeDelay));
										timeDelay += 50;
									});
									break;
								case 'left-curtain':
								case 'right-curtain':
								case 'top-curtain':
								case 'bottom-curtain':
									if (fx == 'left-curtain' || fx == 'right-curtain') iv.addStrips();
									else iv.addStrips(true);
									var timeDelay = 0,
										i = 0,
										strips = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>', iv.slider);
									if (fx == 'right-curtain' || fx == 'bottom-curtain') strips = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>', iv.slider).reverse();
									strips.each(function () {
										var strip = $(this);
										var width = strip.width();
										var height = strip.height();
										if (fx == 'left-curtain' || fx == 'right-curtain') strip.css({ top: '0px', height: '100%', width: '0px' });
										else strip.css({ left: '0px', height: '0px', width: '100%' });
										setTimeout(function () {
											if (fx == 'left-curtain' || fx == 'right-curtain') strip.animate({ width: width, opacity: '1.0'
											}, iv.options.animationSpeed, iv.defs.easing, function () { if (i == iv.options.strips - 1) iv.transitionEnd(iv); i++; });
											else strip.animate({ height: height, opacity: '1.0'
											}, iv.options.animationSpeed, iv.defs.easing, function () { if (i == iv.options.strips - 1) iv.transitionEnd(iv); i++; });
										}, (100 + timeDelay));
										timeDelay += 50;
									});
									break;
								case 'strip-up-right':
								case 'strip-up-left':
									iv.addStrips();
									var timeDelay = 0,
										i = 0,
										strips = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>', iv.slider);
									if (fx == 'strip-up-left') strips = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>', iv.slider).reverse();
									strips.each(function () {
										var strip = $(this);
										strip.css({ 'bottom': '0px' });
										setTimeout(function () {
											strip.animate({ height: '100%', opacity: '1.0'
											}, iv.options.animationSpeed, iv.defs.easing, function () { if (i == iv.options.strips - 1) iv.transitionEnd(iv); i++; });
										}, (100 + timeDelay));
										timeDelay += 50;
									});
									break;
								case 'strip-left-fade':
								case 'strip-right-fade':
								case 'strip-top-fade':
								case 'strip-bottom-fade':
									if (fx == 'strip-left-fade' || fx == 'strip-right-fade') iv.addStrips();
									else iv.addStrips(true);
									var timeDelay = 0,
										i = 0,
										strips = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>', iv.slider);
									if (fx == 'strip-right-fade' || fx == 'strip-bottom-fade') strips = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>', iv.slider).reverse();
									strips.each(function () {
										var strip = $(this);
										var width = strip.width();
										var height = strip.height();
										if (fx == 'strip-left-fade' || fx == 'strip-right-fade') strip.css({ top: '0px', հeight: '100%', width: width });
										else strip.css({ left: '0px', height: height, width: '100%' });
										setTimeout(function () {
											strip.animate({ opacity: '1.0'
											}, iv.options.animationSpeed * 1.7, iv.defs.easing, function () { if (i == iv.options.strips - 1) iv.transitionEnd(iv); i++; });
										}, (100 + timeDelay));
										timeDelay += 35;
									});
									break;
								case 'slide-in-up':
								case 'slide-in-down':
									opts = { strips: 1 };
									iv.addStrips(false, opts);
									var strip = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>:first', iv.slider),
										top = 0;
									if (fx == 'slide-in-up') top = '-' + iv.defs.height + 'px';
									else top = iv.defs.height + 'px';
									strip.css({ top: top, 'height': '100%', 'width': iv.defs.width });
									strip.animate({ 'top': '0px', opacity: 1 }, (iv.options.animationSpeed * 2), iv.defs.easing, function () { iv.transitionEnd(iv); });
									break;
								case 'zigzag-top':
								case 'zigzag-bottom':
								case 'zigzag-grow-top':
								case 'zigzag-grow-bottom':
								case 'zigzag-drop-top':
								case 'zigzag-drop-bottom':
									iv.addBlocks();
									var totalBlocks = (iv.options.blockCols * iv.options.blockRows),
										timeDelay = 0,
										blockToArr = new Array(),
										blocks = $('.iview-block<?= $Rich_Web_VSlider_ID; ?>', iv.slider);
									for (var rows = 0; rows < iv.options.blockRows; rows++) 
									{
										var odd = (rows % 2),
											start = (rows * iv.options.blockCols),
											end = ((rows + 1) * iv.options.blockCols);
										if (odd == 1) { for (var columns = end - 1; columns >= start; columns--) { blockToArr.push($(blocks[columns])); } }
										else { for (var columns = start; columns < end; columns++) { blockToArr.push($(blocks[columns])); } }
									}
									if (fx == 'zigzag-bottom' || fx == 'zigzag-grow-bottom' || fx == 'zigzag-drop-bottom') blockToArr.reverse();
									blocks.each(function (i) {
										var block = $(blockToArr[i]),
											h = Math.ceil(iv.slider.height() / iv.options.blockRows),
											w = Math.ceil(iv.slider.width() / iv.options.blockCols),
											top = block.css('top');
										if (fx == 'zigzag-grow-top' || fx == 'zigzag-grow-bottom') block.width(0).height(0);
										else if (fx == 'zigzag-drop-top' || fx == 'zigzag-drop-bottom') block.css({ top: '-=50' });
										setTimeout(function () {
											if (fx == 'zigzag-grow-top' || fx == 'zigzag-grow-bottom') block.animate({ opacity: '1', height: h, width: w
											}, iv.options.animationSpeed, iv.defs.easing, function () { if (i == totalBlocks - 1) iv.transitionEnd(iv); });
											else if (fx == 'zigzag-drop-top' || fx == 'zigzag-drop-bottom') block.animate({ top: top, opacity: '1'
											}, iv.options.animationSpeed, iv.defs.easing, function () { if (i == totalBlocks - 1) iv.transitionEnd(iv); });
											else block.animate({ opacity: '1'
											}, (iv.options.animationSpeed * 2), 'easeInOutExpo', function () { if (i == totalBlocks - 1) iv.transitionEnd(iv); });
										}, (100 + timeDelay));
										timeDelay += 20;
									});
									break;
								case 'block-fade':
								case 'block-fade-reverse':
								case 'block-expand':
								case 'block-expand-reverse':
									iv.addBlocks();
									var totalBlocks = (iv.options.blockCols * iv.options.blockRows),
										i = 0,
										timeDelay = 0;
									var rowIndex = 0;
									var colIndex = 0;
									var blockToArr = new Array();
									blockToArr[rowIndex] = new Array();
									var blocks = $('.iview-block<?= $Rich_Web_VSlider_ID; ?>', iv.slider);
									if (fx == 'block-fade-reverse' || fx == 'block-expand-reverse') { blocks = $('.iview-block<?= $Rich_Web_VSlider_ID; ?>', iv.slider).reverse(); }
									blocks.each(function () {
										blockToArr[rowIndex][colIndex] = $(this);
										colIndex++;
										if (colIndex == iv.options.blockCols) { rowIndex++; colIndex = 0; blockToArr[rowIndex] = new Array(); }
									});
									for (var columns = 0; columns < (iv.options.blockCols * 2); columns++)
									{
										var Col = columns;
										for (var rows = 0; rows < iv.options.blockRows; rows++)
										{
											if (Col >= 0 && Col < iv.options.blockCols)
											{
												(function () {
													var block = $(blockToArr[rows][Col]);
													var w = Math.ceil(iv.slider.width() / iv.options.blockCols);
													var h = Math.ceil(iv.slider.height() / iv.options.blockRows);
													if (fx == 'block-expand' || fx == 'block-expand-reverse') { block.width(0).height(0); }
													setTimeout(function () {
														block.animate({ opacity: '1', width: w, height: h
														}, iv.options.animationSpeed / 1.3, iv.defs.easing, function () { if (i == totalBlocks - 1) iv.transitionEnd(iv); i++; });
													}, (100 + timeDelay));
												})();
											}
											Col--;
										}
										timeDelay += 100;
									}
									break;
								case 'block-random':
								case 'block-expand-random':
								case 'block-drop-random':
									iv.addBlocks();
									var totalBlocks = (iv.options.blockCols * iv.options.blockRows),
										timeDelay = 0;
									var blocks = iv.shuffle($('.iview-block<?= $Rich_Web_VSlider_ID; ?>', iv.slider));
									blocks.each(function (i) {
										var block = $(this),
											h = Math.ceil(iv.slider.height() / iv.options.blockRows),
											w = Math.ceil(iv.slider.width() / iv.options.blockCols,
											top = block.css('top'));
										if (fx == 'block-expand-random') block.width(0).height(0);
										if (fx == 'block-drop-random') block.css({ top: '-=50' });
										setTimeout(function () {
											block.animate({ top: top, opacity: '1', height: h, width: w
											}, iv.options.animationSpeed, iv.defs.easing, function () { if (i == totalBlocks - 1) iv.transitionEnd(iv); });
										}, (100 + timeDelay));
										timeDelay += 20;
									});
									break;
								case 'slide-in-right':
								case 'slide-in-left':
								case 'fade':
								default:
									opts = { strips: 1 };
									iv.addStrips(false, opts);
									var strip = $('.iview-strip<?= $Rich_Web_VSlider_ID; ?>:first', iv.slider);
									strip.css({ 'height': '100%', 'width': iv.defs.width });
									if (fx == 'slide-in-right') strip.css({ 'height': '100%', 'width': iv.defs.width, 'left': iv.defs.width + 'px', 'right': '' });
									else if (fx == 'slide-in-left') strip.css({ 'left': '-' + iv.defs.width + 'px' });
									strip.animate({ left: '0px', opacity: 1
									}, (iv.options.animationSpeed * 2), iv.defs.easing, function () { iv.transitionEnd(iv); });
									break;
								}
							},
							shuffle: function (oldArray) {
								var newArray = oldArray.slice();
								var len = newArray.length;
								var i = len;
								while (i--) 
								{
									var p = parseInt(Math.random() * len);
									var t = newArray[i];
									newArray[i] = newArray[p];
									newArray[p] = t;
								}
								return newArray;
							},
							timerCall: function (iv) {
								iv.processTimer();
								if (iv.pieDegree >= 360) { iv.cleanTimer(); iv.goTo(false); }
							},
							setTimer: function () {
								var iv = this;
								iv.timer = setInterval(function () { iv.timerCall(iv); }, (iv.defs.time / 120));
							},
							cleanTimer: function () {
								var iv = this;
								clearInterval(iv.timer);
								iv.timer = null;
							},
							goTo: function (action) {
								var iv = this;
								if (iv.defs && (iv.defs.slide == iv.defs.total - 1)) { iv.options.onLastSlide.call(this); }
								iv.cleanTimer();
								iv.iviewTimer.animate({ opacity: 0 });
								iv.options.onBeforeChange.call(this);
								if (!action)
								{
									iv.slider.css('background', 'url("' + iv.defs.image.data('iview:image') + '") no-repeat');
									iv.slider.css('background-size', ''+jQuery("#iview"+Rich_Web_VSlider_ID).width()+'px '+jQuery("#iview"+Rich_Web_VSlider_ID).height()+'px');
								}
								else
								{
									if (action == 'prev' || action == 'next')
									{
										iv.slider.css('background', 'url("' + iv.defs.image.data('iview:image') + '") no-repeat');
										iv.slider.css('background-size', ''+jQuery("#iview"+Rich_Web_VSlider_ID).width()+'px '+jQuery("#iview"+Rich_Web_VSlider_ID).height()+'px');
									}
								}
								iv.defs.slide++;
								if (iv.defs.slide == iv.defs.total) { iv.defs.slide = 0; iv.options.onSlideShowEnd.call(this); }
								if (iv.defs.slide < 0) iv.defs.slide = (iv.defs.total - 1);
								iv.defs.image = iv.slides.eq(iv.defs.slide);
								if (iv.options.controlNav)
								{
									$('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?> a.iview-control', iv.sliderContent).removeClass('active');
									$('.iview-controlNav<?= $Rich_Web_VSlider_ID; ?> a.iview-control:eq(' + iv.defs.slide + ')', iv.sliderContent).addClass('active');
								}
								var fx = iv.options.fx;
								if (iv.options.fx.toLowerCase() == 'random')
								{
									var transitions = new Array('left-curtain', 'right-curtain', 'top-curtain', 'bottom-curtain', 'strip-down-right', 'strip-down-left', 'strip-up-right', 'strip-up-left', 'strip-up-down', 'strip-up-down-left', 'strip-left-right', 'strip-left-right-down', 'slide-in-right', 'slide-in-left', 'slide-in-up', 'slide-in-down', 'fade', 'block-random', 'block-fade', 'block-fade-reverse', 'block-expand', 'block-expand-reverse', 'block-expand-random', 'zigzag-top', 'zigzag-bottom', 'zigzag-grow-top', 'zigzag-grow-bottom', 'zigzag-drop-top', 'zigzag-drop-bottom', 'strip-top-fade', 'strip-bottom-fade', 'block-drop-random');
									fx = transitions[Math.floor(Math.random() * (transitions.length + 1))];
									if (fx == undefined) fx = 'fade';
									fx = $.trim(fx.toLowerCase());
								}
								if (iv.options.fx.indexOf(',') != -1)
								{
									var transitions = iv.options.fx.split(',');
									fx = transitions[Math.floor(Math.random() * (transitions.length))];
									if (fx == undefined) fx = 'fade';
									fx = $.trim(fx.toLowerCase());
								}
								if (iv.defs.image.data('iview:transition'))
								{
									var transitions = iv.defs.image.data('iview:transition').split(',');
									fx = transitions[Math.floor(Math.random() * (transitions.length))];
									fx = $.trim(fx.toLowerCase());
								}
								iv.defs.easing = (iv.defs.image.data('iview:easing')) ? iv.defs.image.data('iview:easing') : iv.options.easing;
								iv.defs.lock = true;
								iv.runTransition(fx);
							},
							playSlider: function () {
								var iv = this;
								if (iv.timer == null && iv.defs.paused)
								{
									iv.iviewTimer.removeClass('paused').attr('title', iv.options.pauseLabel);
									iv.setTimer();
									iv.defs.paused = false;
									iv.options.onPlay.call(this);
								}
							},
							stopSlider: function () {
								var iv = this;
								iv.iviewTimer.addClass('paused').attr('title', iv.options.playLabel);
								iv.cleanTimer();
								iv.defs.paused = true;
								iv.options.onPause.call(this);
							},
							setTimerPosition: function(){
								var iv = this,
								position = iv.options.timerPosition.toLowerCase().split('-');
								for (var i = 0; i < position.length; i++) {
									if (position[i] == 'top')
									{
										iv.iviewTimer.css({ top: iv.options.timerY + 'px', bottom: '' });
									}
									else if (position[i] == 'middle')
									{
										iv.iviewTimer.css({ top: (iv.options.timerY + (iv.defs.height / 2) - (iv.options.timerDiameter / 2)) + 'px', bottom: '' });
									}
									else if (position[i] == 'bottom')
									{
										iv.iviewTimer.css({ bottom: iv.options.timerY + 'px', top: '' });
									}
									else if (position[i] == 'left')
									{
										iv.iviewTimer.css({ left: iv.options.timerX + 'px', right: '' });
									}
									else if (position[i] == 'center')
									{
										iv.iviewTimer.css({ left: (iv.options.timerX + (iv.defs.width / 2) - (iv.options.timerDiameter / 2)) + 'px', right: '' });
									}
									else if (position[i] == 'right')
									{
										iv.iviewTimer.css({ right: iv.options.timerX + 'px', left: '' });
									}
								}
							},
							disableSelection: function (target) {
								if (typeof target.onselectstart != "undefined") target.onselectstart = function () { return false; };
								else if (typeof target.style.MozUserSelect != "undefined") target.style.MozUserSelect = "none";
								else if (typeof target.style.webkitUserSelect != "undefined") target.style.webkitUserSelect = "none";
								else if (typeof target.style.userSelect != "undefined") target.style.userSelect = "none";
								else target.onmousedown = function () { return false; };
								target.unselectable = "on";
							},
							isTouch: function () {
								return !!('ontouchstart' in window);
							}
						};
						var ImagePreload = function (p_aImages, p_pfnPercent, p_pfnFinished) {
							this.m_pfnPercent = p_pfnPercent;
							this.m_pfnFinished = p_pfnFinished;
							this.m_nLoaded = 0;
							this.m_nProcessed = 0;
							this.m_aImages = new Array;
							this.m_nICount = p_aImages.length;
							for (var i = 0; i < p_aImages.length; i++) this.Preload(p_aImages[i])
						};
						ImagePreload.prototype = {
							Preload: function (p_oImage) {
								var oImage = new Image;
								this.m_aImages.push(oImage);
								oImage.onload = ImagePreload.prototype.OnLoad;
								oImage.onerror = ImagePreload.prototype.OnError;
								oImage.onabort = ImagePreload.prototype.OnAbort;
								oImage.oImagePreload = this;
								oImage.bLoaded = false;
								oImage.source = p_oImage;
								oImage.src = p_oImage
							},
							OnComplete: function () {
								this.m_nProcessed++;
								if (this.m_nProcessed == this.m_nICount) this.m_pfnFinished();
								else this.m_pfnPercent(Math.round((this.m_nProcessed / this.m_nICount) * 10))
							},
							OnLoad: function () {
								this.bLoaded = true;
								this.oImagePreload.m_nLoaded++;
								this.oImagePreload.OnComplete()
							},
							OnError: function () {
								this.bError = true;
								this.oImagePreload.OnComplete()
							},
							OnAbort: function () {
								this.bAbort = true;
								this.oImagePreload.OnComplete()
							}
						}
						$.fn.iView<?= $Rich_Web_VSlider_ID; ?> = function (options) {
							options = jQuery.extend({
								fx: 'random',
								easing: 'easeOutQuad',
								strips: 20,
								blockCols: 10,
								blockRows: 5,
								animationSpeed: 500,
								pauseTime: 15000,
								startSlide: 0,
								directionNav: true,
								directionNavHoverOpacity: 0.6,
								controlNav: false,
								controlNavNextPrev: true,
								controlNavHoverOpacity: 0.6,
								controlNavThumbs: false,
								controlNavTooltip: true,
								captionSpeed: 500,
								captionEasing: 'easeInOutSine',
								captionOpacity: 1,
								autoAdvance: true,
								keyboardNav: true,
								touchNav: true,
								pauseOnHover: false,
								nextLabel: "",
								previousLabel: "",
								playLabel: "Play",
								pauseLabel: "Pause",
								closeLabel: "Close",
								randomStart: false,
								timer: 'pie',
								timerBg: '#000',
								timerColor: '#EEE',
								timerOpacity: 0.5,
								timerDiameter: 30,
								timerPadding: 4,
								timerStroke: 3,
								timerBarStroke: 1,
								timerBarStrokeColor: '#EEE',
								timerBarStrokeStyle: 'solid',
								timerPosition: 'top-right',
								timerX: 10,
								timerY: 10,
								tooltipX: 5,
								tooltipY: -5,
								onBeforeChange: function () {},
								onAfterChange: function () {},
								onAfterLoad: function () {},
								onLastSlide: function () {},
								onSlideShowEnd: function () {},
								onPause: function () {},
								onPlay: function () {}
							}, options);
							$(this).each(function () {
								var el = $(this);
								new iView<?= $Rich_Web_VSlider_ID; ?>(el, options);
							});
						};
						$.fn.reverse = [].reverse;
						var elems = $([]),
							jq_resize = $.resize = $.extend($.resize, {}),
							timeout_id, str_setTimeout = "setTimeout",
							str_resize = "resize",
							str_data = str_resize + "-special-event",
							str_delay = "delay",
							str_throttle = "throttleWindow";
						jq_resize[str_delay] = 250;
						jq_resize[str_throttle] = true;
						$.event.special[str_resize] = {
							setup: function () {
								if (!jq_resize[str_throttle] && this[str_setTimeout]) { return false }
								var elem = $(this);
								elems = elems.add(elem);
								$.data(this, str_data, { w: elem.width(), h: elem.height() });
								if (elems.length === 1) { loopy() }
							},
							teardown: function () {
								if (!jq_resize[str_throttle] && this[str_setTimeout]) { return false }
								var elem = $(this);
								elems = elems.not(elem);
								elem.removeData(str_data);
								if (!elems.length) { clearTimeout(timeout_id) }
							},
							add: function (handleObj) {
								if (!jq_resize[str_throttle] && this[str_setTimeout]) { return false }
								var old_handler;
								function new_handler(e, w, h)
								{
									var elem = $(this),
										data = $.data(this, str_data);
									old_handler.apply(this, arguments)
								}
								if ($.isFunction(handleObj)) { old_handler = handleObj; return new_handler }
								else { old_handler = handleObj.handler; handleObj.handler = new_handler }
							}
						};
						function loopy() {
							timeout_id = window[str_setTimeout](function () {
								elems.each(function () {
									var elem = $(this),
										width = elem.width(),
										height = elem.height(),
										data = $.data(this, str_data);
									if (width !== data.w || height !== data.h) { elem.trigger(str_resize, [data.w = width, data.h = height]) }
								});
								loopy()
							}, jq_resize[str_delay])
						}
						var supportTouch = !! ('ontouchstart' in window),
							touchStartEvent = supportTouch ? "touchstart" : "mousedown",
							touchStopEvent = supportTouch ? "touchend" : "mouseup",
							touchMoveEvent = supportTouch ? "touchmove" : "mousemove";
						$.event.special.swipe = {
							scrollSupressionThreshold: 10,
							durationThreshold: 1200,
							horizontalDistanceThreshold: 30,
							verticalDistanceThreshold: 75,
							setup: function () {
								var thisObject = this,
									$this = $(thisObject);
								$this.bind(touchStartEvent, function (event) {
									var data = event.originalEvent.touches ? event.originalEvent.touches[0] : event,
										start = {
											time: (new Date()).getTime(),
											coords: [data.pageX, data.pageY],
											origin: $(event.target)
										},
										stop;
									function moveHandler(event) {
										if (!start) { return; }
										var data = event.originalEvent.touches ? event.originalEvent.touches[0] : event;
										stop = { time: (new Date()).getTime(), coords: [data.pageX, data.pageY] };
										if (Math.abs(start.coords[0] - stop.coords[0]) > $.event.special.swipe.scrollSupressionThreshold) { event.preventDefault(); }
									}
									$this.bind(touchMoveEvent, moveHandler).one(touchStopEvent, function (event) {
										$this.unbind(touchMoveEvent, moveHandler);
										if (start && stop) {
											if (stop.time - start.time < $.event.special.swipe.durationThreshold && Math.abs(start.coords[0] - stop.coords[0]) > $.event.special.swipe.horizontalDistanceThreshold && Math.abs(start.coords[1] - stop.coords[1]) < $.event.special.swipe.verticalDistanceThreshold)
											{
												start.origin.trigger("swipe").trigger(start.coords[0] > stop.coords[0] ? "swipeleft" : "swiperight");
											}
										}
										start = stop = undefined;
									});
								});
							}
						};
						$.each({
							swipeleft: "swipe",
							swiperight: "swipe"
						}, function (event, sourceEvent) {
							$.event.special[event] = {
								setup: function () { $(this).bind(sourceEvent, $.noop); }
							};
						});
					})(jQuery, this);
				</script>
				<script>
					jQuery(document).ready(function(){
						var dirNavCS = jQuery('.dirNavCS<?= $Rich_Web_VSlider_ID; ?>').val();
						var pauseOnHoveCS = jQuery('.pauseOnHoveCS<?= $Rich_Web_VSlider_ID; ?>').val();
						var RandomStartCS = jQuery('.RandomStartCS<?= $Rich_Web_VSlider_ID; ?>').val();
						var controlNavCS = jQuery('.controlNavCS<?= $Rich_Web_VSlider_ID; ?>').val();
						var controlNextPrevCS = jQuery('.controlNextPrevCS<?= $Rich_Web_VSlider_ID; ?>').val();
						var navTumbsCS = jQuery('.navTumbsCS<?= $Rich_Web_VSlider_ID; ?>').val();
						if(dirNavCS==''){ dirNavCS=false; }else{ dirNavCS=true; }
						if(pauseOnHoveCS==''){ pauseOnHoveCS=false; }else{ pauseOnHoveCS=true; }
						if(RandomStartCS==''){ RandomStartCS=false; }else{ RandomStartCS=true; }
						if(controlNavCS==''){ controlNavCS=false; }else{ controlNavCS=true; }
						if(controlNextPrevCS==''){ controlNextPrevCS=false; }else{ controlNextPrevCS=true; }
						if(navTumbsCS==''){ navTumbsCS=false; }else{ navTumbsCS=true; }
						function opt(){
							jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').iView<?= $Rich_Web_VSlider_ID; ?>({
								fx: '<?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_CE;?>',
								easing: '<?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_EE;?>',
								strips: <?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_S;?>,
								blockCols: <?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_BlC;?>,
								blockRows: <?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_BlR;?>,
								animationSpeed: <?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_AS;?>,
								pauseTime: <?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_PT*1200;?>,
								startSlide: <?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_SS-1;?>,
								directionNav: false,
								directionNavHoverOpacity: 0.6,
								controlNav: controlNavCS,
								controlNavNextPrev: controlNextPrevCS,
								controlNavHoverOpacity: <?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_NO/100;?>,
								controlNavThumbs: navTumbsCS,
								controlNavTooltip: true,
								captionSpeed: <?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_CapS;?>,
								captionEasing: '<?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_CapEs;?>',
								captionOpacity: <?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_CapO/100;?>,
								autoAdvance: dirNavCS,
								keyboardNav: true,
								touchNav: true,
								pauseOnHover: pauseOnHoveCS,
								nextLabel: "",
								previousLabel: "",
								playLabel: "Play",
								pauseLabel: "Pause",
								closeLabel: "Close",
								randomStart: RandomStartCS,
								timer: '<?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_TiT;?>',
								timerBg: '<?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CS_TiBgC;?>',
								timerColor: '<?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CS_TiC;?>',
								timerOpacity: <?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_TiO/100;?>,
								timerDiameter: <?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_TiD;?>*jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').parent().parent().width()/(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').parent().parent().width()+150),
								timerPadding: <?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_TiP;?>*jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').parent().parent().width()/(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').parent().parent().width()+150),
								timerStroke: <?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_TiS;?>*jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').parent().parent().width()/(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').parent().parent().width()+150),
								timerBarStroke: <?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_TiBS;?>,
								timerBarStrokeColor: '<?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_TiBC;?>',
								timerBarStrokeStyle: '<?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_TiBSt;?>',
								timerPosition: '<?= $Rich_Web_VSlider_Eff[0]->Rich_Web_VS_CP_TiPos;?>',
								timerX: 10,
								timerY: 10,
								tooltipX: 5,
								tooltipY: 5
							});
						}
						opt();
					});
				</script>
				<script>
					jQuery(document).ready(function(){
						var slWV=jQuery('.slWV<?= $Rich_Web_VSlider_ID; ?>').val();
						var slHV=jQuery('.slHV<?= $Rich_Web_VSlider_ID; ?>').val();
						var TFSV=jQuery('.TFSV<?= $Rich_Web_VSlider_ID; ?>').val();
						var TitDescType=jQuery('.TitDescType<?= $Rich_Web_VSlider_ID; ?>').val();
						var countVIDEOS=jQuery('.countVIDEOS<?= $Rich_Web_VSlider_ID; ?>').val();
						function resp<?= $Rich_Web_VSlider_ID; ?>(){
							jQuery(".iview-caption").addClass("iview-caption_Anim");
							jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>,#iview<?= $Rich_Web_VSlider_ID; ?> .iviewSlider,.iview-video<?= $Rich_Web_VSlider_ID; ?>,.iview-video<?= $Rich_Web_VSlider_ID; ?>-show,#RW_Load_Content_Navigation_VS<?= $Rich_Web_VSlider_ID; ?>').css('width',slWV+"px");
							jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>,#iview<?= $Rich_Web_VSlider_ID; ?> .iviewSlider,.iview-video<?= $Rich_Web_VSlider_ID; ?>,.iview-video<?= $Rich_Web_VSlider_ID; ?>-show,#RW_Load_Content_Navigation_VS<?= $Rich_Web_VSlider_ID; ?>').css('height',slHV+"px");
							jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>,#iview<?= $Rich_Web_VSlider_ID; ?> .iviewSlider,.iview-video<?= $Rich_Web_VSlider_ID; ?>,.iview-video<?= $Rich_Web_VSlider_ID; ?>-show,#RW_Load_Content_Navigation_VS<?= $Rich_Web_VSlider_ID; ?>').css('max-width',Math.round(jQuery("#iview<?= $Rich_Web_VSlider_ID; ?>").parent().width()));
							jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>,#iview<?= $Rich_Web_VSlider_ID; ?> .iviewSlider,.iview-video<?= $Rich_Web_VSlider_ID; ?>,.iview-video<?= $Rich_Web_VSlider_ID; ?>-show,#RW_Load_Content_Navigation_VS<?= $Rich_Web_VSlider_ID; ?>').css('max-height',Math.round(parseInt(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').width())*slHV/slWV));
							jQuery('#RW_Load_Content_Navigation_VS<?= $Rich_Web_VSlider_ID; ?>').css("padding-bottom","0");
							if(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').width()<=400)
							{
								jQuery('.Desc_Tot').removeClass('iview-caption_Anim');
								jQuery('#iview-timer<?= $Rich_Web_VSlider_ID; ?>').addClass('iview-timer_Anim');
							}
							else
							{
								jQuery('.Desc_Tot').addClass('iview-caption_Anim');
								jQuery('#iview-timer<?= $Rich_Web_VSlider_ID; ?>').removeClass('iview-timer_Anim');
							}
							jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?> .caption-contain,.descCol<?= $Rich_Web_VSlider_ID; ?>_2 .caption-contain h3,.titcol<?= $Rich_Web_VSlider_ID; ?>_3 .caption-contain,.titcol<?= $Rich_Web_VSlider_ID; ?>_4 .caption-contain,.titcol<?= $Rich_Web_VSlider_ID; ?>_5 .caption-contain,.titcol<?= $Rich_Web_VSlider_ID; ?>_6 .caption-contain,.descCol<?= $Rich_Web_VSlider_ID; ?>_7 .caption-contain h3').css('font-size',Math.floor(TFSV*jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').parent().parent().width()/(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').parent().parent().width()+150)));
							if(TitDescType=='type1')
							{
								for(i=1;i<=countVIDEOS;i++)
								{
									var x=jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>'+i).attr('name');
									var y=x.split('');
									var x2=jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>'+i).attr('name');
									var y2=x2.split('');
									if(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>'+i).attr('name')=='')
									{
										jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>'+i).css('padding','0px');
									}
									if(jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>'+i).attr('name')=='')
									{
										jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>'+i).css('padding','0px');
									}
									jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>'+i).attr('data-width',"auto");
									jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>'+i).attr('data-width',"auto");
									jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>'+i).attr('data-height',2*parseInt(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>').css('font-size')));
									jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>'+i).attr('data-height',2*parseInt(jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>').css('font-size')));
									jQuery('.caption-contain').css('line-height',jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>'+i).attr('data-height')+'px');
								}
							}
							else if(TitDescType=='type2')
							{
								for(i=1;i<=countVIDEOS;i++)
								{
									if(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_2'+i).attr('name')=='' && jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_2'+i).attr('name')=='')
									{
										jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_2'+i).css('display','none');
									}
								}
								jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_2').attr('data-width',Math.floor(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').width()/3));
								jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_2').attr('data-height',jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').height());
							}
							else if(TitDescType=='type3')
							{
								jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_3').attr('data-width',Math.floor(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').width()/1.5));
								jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_3').attr('data-height',Math.floor(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').height()/5));
								for(i=1;i<=countVIDEOS;i++)
								{
									if(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_3'+i).attr('name')=='')
									{
										jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_3'+i).css('padding','0px');
									}
									if(jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_3'+i).attr('name')=='')
									{
										jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_3'+i).css('display','none');
									}
									var x=jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_3'+i).attr('name');
									var y=x.split('');
									var x2=jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_3'+i).attr('name');
									var y2=x2.split('');
									jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_3'+i).attr('data-width',Math.floor(parseInt(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_3').css('font-size'))*y.length/1.5));
									jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_3'+i).attr('data-height',2*parseInt(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_3').css('font-size')));
									jQuery('.caption-contain').css('line-height',jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_3'+i).attr('data-height')+'px');
								}
							}
							else if(TitDescType=='type4')
							{
								for(i=1;i<=countVIDEOS;i++)
								{
									if(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_4'+i).attr('name')=='')
									{
										jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_4'+i).css('padding','0px');
									}
									if(jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_4'+i).attr('name')=='')
									{
										jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_4'+i).css('padding','0px');
									}
									var x=jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_4'+i).attr('name');
									var y=x.split('');
									var x2=jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_4'+i).attr('name');
									var y2=x2.split('');
									jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_4'+i).attr('data-width',Math.floor(parseInt(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_4').css('font-size'))*y.length/1.5));
									jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_4'+i).attr('data-width',Math.floor(parseInt(jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_4').css('font-size'))*y2.length/1.5));
									jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_4'+i).attr('data-height',2*parseInt(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_4').css('font-size')));
									jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_4'+i).attr('data-height',2*parseInt(jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_4').css('font-size')));
									jQuery('.caption-contain').css('line-height',jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_4'+i).attr('data-height')+'px');
								}
							}
							else if(TitDescType=='type5')
							{
								for(i=1;i<=countVIDEOS;i++)
								{
									if(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_5'+i).attr('name')=='')
									{
										jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_5'+i).css('padding','0px');
									}
									if(jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_5'+i).attr('name')=='')
									{
										jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_5'+i).css('padding','0px');
									}
									var x=jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_5'+i).attr('name');
									var y=x.split('');
									var x2=jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_5'+i).attr('name');
									var y2=x2.split('');
									jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_5'+i).attr('data-width',Math.floor(parseInt(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_5').css('font-size'))*y.length/1.5));
									jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_5'+i).attr('data-width',Math.floor(parseInt(jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_5').css('font-size'))*y2.length/1.5));
									jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_5'+i).attr('data-height',2*parseInt(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_5').css('font-size')));
									jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_5'+i).attr('data-height',2*parseInt(jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_5').css('font-size')));
									jQuery('.caption-contain').css('line-height',jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_5'+i).attr('data-height')+'px');
									jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_5'+i).attr('data-x',Math.floor(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').width()/8));
									jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_5'+i).attr('data-y',"75%");
									jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_5'+i).attr('data-x',"25%");
									jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_5'+i).attr('data-y',"30%");
								}
							}
							else if(TitDescType=='type6')
							{
								jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_6').attr('data-width',Math.floor(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').width()/1.5));
								jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_6').attr('data-height',Math.floor(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').height()/5));
								for(i=1;i<=countVIDEOS;i++)
								{
									if(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_6'+i).attr('name')=='')
									{
										jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_6'+i).css('padding','0px');
									}
									if(jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_6'+i).attr('name')=='')
									{
										jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_6'+i).css('display','none');
									}
									var x=jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_6'+i).attr('name');
									var y=x.split('');
									var x2=jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_6'+i).attr('name');
									var y2=x2.split('');
									jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_6'+i).attr('data-width',Math.floor(parseInt(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_6').css('font-size'))*y.length/1.5));
									jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_6'+i).attr('data-height',2*parseInt(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_6').css('font-size')));
									jQuery('.caption-contain').css('line-height',jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_6'+i).attr('data-height')+'px');
									jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_6'+i).attr('data-x',Math.floor(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').width()/1.5-20));
									jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_6'+i).attr('data-y',Math.floor(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').height()/8));
									jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_6'+i).attr('data-x',Math.floor(parseInt(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_6'+i).attr('data-x'))/8+2*parseInt(jQuery('.iview-caption').css('padding'))-5));
									jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_6'+i).attr('data-y',Math.floor(parseInt(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_6'+i).attr('data-y'))+1.5*parseInt(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_6'+i).attr('data-height'))+2*parseInt(jQuery('.iview-caption').css('padding'))+5));
								}
							}
							else if(TitDescType=='type7')
							{
								for(i=1;i<=countVIDEOS;i++)
								{
									if(jQuery('.titcol<?= $Rich_Web_VSlider_ID; ?>_7'+i).attr('name')=='' && jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_7'+i).attr('name')=='')
									{
										jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_7'+i).css('display','none');
									}
								}
								jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_7').attr('data-width',Math.floor(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').width()/3));
								jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_7').attr('data-height',jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').height());
								jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_7').attr('data-x',parseInt(jQuery('#iview<?= $Rich_Web_VSlider_ID; ?>').width())-parseInt(jQuery('.descCol<?= $Rich_Web_VSlider_ID; ?>_7').attr('data-width')));
							}
						}
							jQuery(window).on('load resize',function(){ resp<?= $Rich_Web_VSlider_ID; ?>(); })
						var array_content_VS<?= $Rich_Web_VSlider_ID; ?>=[];
						jQuery(".rw_cs_img<?= $Rich_Web_VSlider_ID; ?>").each(function(){
							if( jQuery(this).attr("src") != "" ) {
								array_content_VS<?= $Rich_Web_VSlider_ID; ?>.push(jQuery(this).attr("src"));
							}else{
								array_content_VS<?= $Rich_Web_VSlider_ID; ?>.push(jQuery(this).attr("src"));
							}
						})
						var y_content_VS<?= $Rich_Web_VSlider_ID; ?>=0;
						<?php
						for($i=0; $i<count($Rich_Web_VSlider_Videos); $i++){
							 $video_link = $Rich_Web_VSlider_Videos[$i]->Rich_Web_VSldier_Add_Src; 
							 ?>
						for(f=0;f<array_content_VS<?= $Rich_Web_VSlider_ID; ?>.length;f++){
							<?php if(strpos($video_link, 'mp4')){ ?> 
							jQuery("#cont<?= $Rich_Web_VSlider_ID; ?>").fadeIn(1000);
							jQuery("#RW_Load_Content_Navigation_VS<?= $Rich_Web_VSlider_ID; ?>").remove();
							<?php }else{ ?>

								jQuery("img.rw_cs_img<?= $Rich_Web_VSlider_ID; ?>").attr('src', array_content_VS<?= $Rich_Web_VSlider_ID; ?>[f]).on('load',function(){
								y_content_VS<?= $Rich_Web_VSlider_ID; ?>++;

								if(y_content_VS<?= $Rich_Web_VSlider_ID; ?> == array_content_VS<?= $Rich_Web_VSlider_ID; ?>.length){
									jQuery("#cont<?= $Rich_Web_VSlider_ID; ?>").fadeIn(1000);
									jQuery("#RW_Load_Content_Navigation_VS<?= $Rich_Web_VSlider_ID; ?>").remove();
								}
							})
							<?php } ?>
						}
					<?php } ?>
					})
				</script>