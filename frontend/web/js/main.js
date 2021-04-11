$(document).ready(function () {
    'use strict';

    function deactive(item) {
        item.find('.portfolio-button').removeClass('active');
        $('.portfolio-content:eq('+item.index()+')').hide();
    }

    function active(item) {
        item.find('.portfolio-button').addClass('active');
        $('.portfolio-content:eq('+item.index()+')').show();
    }

    function deactiveAll() {
        $('.portfolio-item').each(function () {
            deactive($(this));
        });
    }

    deactiveAll();

    active($('.portfolio-item:first-child'));

    $('.portfolio-button').on('click', function () {
        if (!$(this).hasClass('active')) {
            deactiveAll();
            active($(this).closest('.portfolio-item'));
            window.scrollBy(0, 1);
        }
    });

    $('.to-down').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $("#service").offset().top
        }, 500);
    });

    new WOW(
        {
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 100,
            mobile: false,
            live: true
        }
    ).init();

    function toggleScrollUp() {
        if ($(window).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    }

    toggleScrollUp();

    $(window).scroll(function () {
        toggleScrollUp()
    });

    $('.scrollup').click(function () {
        $("html, body").animate({scrollTop: 0}, 600);
        return false;
    });
});
