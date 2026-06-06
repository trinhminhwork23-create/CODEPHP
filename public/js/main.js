/*  ---------------------------------------------------
    Template Name: Sona
    Description: Sona Hotel Html Template
    Author: Colorlib
    Author URI: https://colorlib.com
    Version: 1.0
    Created: Colorlib
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    //Offcanvas Menu
    $(".canvas-open").on('click', function () {
        $(".offcanvas-menu-wrapper").addClass("show-offcanvas-menu-wrapper");
        $(".offcanvas-menu-overlay").addClass("active");
    });

    $(".canvas-close, .offcanvas-menu-overlay").on('click', function () {
        $(".offcanvas-menu-wrapper").removeClass("show-offcanvas-menu-wrapper");
        $(".offcanvas-menu-overlay").removeClass("active");
    });

    // Search model
    $('.search-switch').on('click', function () {
        $('.search-model').fadeIn(400);
    });

    $('.search-close-switch').on('click', function () {
        $('.search-model').fadeOut(400, function () {
            $('#search-input').val('');
        });
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*------------------
        Hero Slider
    --------------------*/
   $(".hero-slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        mouseDrag: false
    });

    /*------------------------
		Testimonial Slider
    ----------------------- */
    $(".testimonial-slider").owlCarousel({
        items: 1,
        dots: false,
        autoplay: true,
        loop: true,
        smartSpeed: 1200,
        nav: true,
        navText: ["<i class='arrow_left'></i>", "<i class='arrow_right'></i>"]
    });

    /*------------------
        Magnific Popup
    --------------------*/
    $('.video-popup').magnificPopup({
        type: 'iframe'
    });

    /*------------------
        Date Picker — Vietnamese Locale
        Format: dd/mm/yy  →  backend parseDate handles 'd/m/Y'
    --------------------*/
    $.datepicker.regional['vi'] = {
        closeText:        'Đóng',
        prevText:         '&#x3C;Trước',
        nextText:         'Tiếp&#x3E;',
        currentText:      'Hôm nay',
        monthNames:       ['Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6',
                           'Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'],
        monthNamesShort:  ['Th1','Th2','Th3','Th4','Th5','Th6',
                           'Th7','Th8','Th9','Th10','Th11','Th12'],
        dayNames:         ['Chủ Nhật','Thứ Hai','Thứ Ba','Thứ Tư','Thứ Năm','Thứ Sáu','Thứ Bảy'],
        dayNamesShort:    ['CN','T2','T3','T4','T5','T6','T7'],
        dayNamesMin:      ['CN','T2','T3','T4','T5','T6','T7'],
        weekHeader:       'Tuần',
        dateFormat:       'dd/mm/yy',
        firstDay:         1,
        isRTL:            false,
        showMonthAfterYear: false,
        yearSuffix:       ''
    };
    $.datepicker.setDefaults($.datepicker.regional['vi']);

    $(".date-input").datepicker({
        minDate:    0,
        dateFormat: 'dd/mm/yy'
    });

    /*------------------
		Nice Select
	--------------------*/
    $("select").niceSelect();

})(jQuery);
