const $ = require('jquery');
require('paroller.js');
require('bootstrap');
import AOS from 'aos';

$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();
    //    --parallx--
    $('.box_parallax').paroller();
    $('.apps-craft-feature-ico').paroller();
    //    < !-- === = AOS === === === -- >
    AOS.init({
        once: true
    })

//    ----
    $(".favourit").click(function() {
        $(this).children().toggleClass('far fa');
    });
//    ----
    $('.listFix').hide();
    if ($(window).width() < 768) {

        $(window).scroll(function() {
            $('.listFix').show();
            if ($(this).scrollTop() > 100) {
                $('.group-list-side').addClass("listFix");
            } else {
                $('.group-list-side').removeClass("listFix");
            }
        });

    } else {
        $('.group-list-side').removeClass("listFix");
    }

    //        ..........top to.......
    // hide #back-top first
    $("#back-top").hide();
    // fade in #back-top
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('#back-top').fadeIn();
            $('.infohead').addClass("pos_nav");
        } else {
            $('#back-top').fadeOut();
            $('.infohead').removeClass("pos_nav");
        }
    });
    // scroll body to 0px on click
    $('#back-top a').click(function() {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    /* ------------------------------------------------------------------------- *
     * BUTTON RIPPLE EFFECT
     * ------------------------------------------------------------------------- */
    var $btnRipple = $('.btn--ripple'),
            $btnRippleInk, btnRippleH, btnRippleX, btnRippleY;
    $btnRipple.on('mouseenter', function(e) {
        var $t = $(this);
        if ($t.find(".btn--ripple-ink").length === 0) {
            $t.prepend("<span class='btn--ripple-ink'></span>");
        }

        $btnRippleInk = $t.find(".btn--ripple-ink");
        $btnRippleInk.removeClass("btn--ripple-animate");
        if (!$btnRippleInk.height() && !$btnRippleInk.width()) {
            btnRippleH = Math.max($t.outerWidth(), $t.outerHeight());
            $btnRippleInk.css({height: btnRippleH, width: btnRippleH});
        }

        btnRippleX = e.pageX - $t.offset().left - $btnRippleInk.width() / 2;
        btnRippleY = e.pageY - $t.offset().top - $btnRippleInk.height() / 2;
        $btnRippleInk.css({top: btnRippleY + 'px', left: btnRippleX + 'px'}).addClass("btn--ripple-animate");
    });
    //====scroll
    $(".smooth-scroll .link_bottom").click(function() {
        $('html, body').animate({
            scrollTop: $("#section2").offset().top
        }, 2000);
    });
});
