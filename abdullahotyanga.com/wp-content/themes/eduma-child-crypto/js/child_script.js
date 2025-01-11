(function ($) {
	"use strict";

	$(window).load(function () {
		/* Padding left for section Courses */
		var width_screen = $(window).width();
		var width_container = $('#main-home-content').width();
		var elementPaddingLeft = $('.thim-padding-left');
		var elementNavPosition = $('.thim-nav-position');

		if(elementPaddingLeft.length && width_screen > 1024){
			if( width_screen > width_container ){
				var margin_left_value = ( width_screen - width_container ) / 2 ;
				$('.thim-padding-left >.vc_column-inner').css('padding-left',margin_left_value + 'px');
				$('.thim-padding-left >.so-panel').css('padding-left',margin_left_value + 'px');
				$('.thim-padding-left >.elementor-column-wrap').css('padding-left',margin_left_value + 'px');
			}
		}

		if(elementNavPosition.length && width_screen > 1024){
			if( width_screen > width_container ){
				var margin_left_value = ( width_screen - width_container ) / 2 ;
				$('.thim-nav-position .wrapper-lists-our-team .thim-crypto-team-carousel .owl-controls .owl-buttons').css('left',margin_left_value+'px');
			}
		}

		$('.thim-crypto-team-carousel').each(function() {
			var item_visible = $(this).data('visible') ? parseInt(
				$(this).data('visible')) : 4,
				item_desktopsmall = $(this).data('desktopsmall') ? parseInt(
					$(this).data('desktopsmall')) : item_visible,
				itemsTablet = $(this).data('itemtablet') ? parseInt(
					$(this).data('itemtablet')) : 2,
				itemsMobile = $(this).data('itemmobile') ? parseInt(
					$(this).data('itemmobile')) : 1,
				pagination = !!$(this).data('pagination'),
				navigation = !!$(this).data('navigation'),
				autoplay = $(this).data('autoplay') ? parseInt(
					$(this).data('autoplay')) : false,
				navigation_text = ($(this).data('navigation-text') &&
					$(this).data('navigation-text') === '2') ? [
					'<i class=\'fa fa-long-arrow-left \'></i>',
					'<i class=\'fa fa-long-arrow-right \'></i>',
				] : [
					'<i class=\'fa fa-chevron-left \'></i>',
					'<i class=\'fa fa-chevron-right \'></i>',
				];
			$(this).owlCarousel({
				items            : item_visible,
				itemsDesktop     : [1400, item_desktopsmall],
				itemsDesktopSmall: [1024, itemsTablet],
				itemsTablet      : [768, itemsTablet],
				itemsMobile      : [480, itemsMobile],
				navigation       : navigation,
				pagination       : pagination,
				lazyLoad         : true,
				autoPlay         : autoplay,
				navigationText   : navigation_text,
				afterAction    : function () {
					var width_screen = $(window).width();
					var width_container = $('#main-home-content').width();
					var elementNavPosition = $('.thim-nav-position');

					if(elementNavPosition.length && width_screen > 1024){
						if( width_screen > width_container ){
							var margin_left_value = ( width_screen - width_container ) / 2 ;
							$('.thim-nav-position .wrapper-lists-our-team .thim-crypto-team-carousel .owl-controls .owl-buttons').css('left',margin_left_value+'px');
						}
					}
				}
			});
		});

	})

	$( window ).resize(function() {

		var width_screen = $(window).width();
		var width_container = $('#main-home-content').width();
		var elementPaddingLeft = $('.thim-padding-left');
		var elementNavPosition = $('.thim-nav-position');

		if(elementPaddingLeft.length && width_screen > 1024){
			if( width_screen > width_container ){
				var margin_left_value = ( width_screen - width_container ) / 2 ;
				$('.thim-padding-left >.vc_column-inner').css('padding-left',margin_left_value + 'px');
				$('.thim-padding-left >.so-panel').css('padding-left',margin_left_value + 'px');
				$('.thim-padding-left >.elementor-column-wrap').css('padding-left',margin_left_value + 'px');
			}
		}

		if(elementNavPosition.length && width_screen > 1024){
			if( width_screen > width_container ){
				var margin_left_value = ( width_screen - width_container ) / 2 ;
				$('.thim-nav-position .wrapper-lists-our-team .thim-crypto-team-carousel .owl-controls .owl-buttons').css('left',margin_left_value+'px');
			}
		}
	});

})(jQuery);