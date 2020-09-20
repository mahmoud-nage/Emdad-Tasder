
$(document).ready(function () {
    var n = $(".header-menu .header-menu-wrapper.lang-menu-wrapper");
    $(document).mouseup(function (e) {
        n.is(e.target) || 0 !== n.has(e.target).length || n.removeClass("open");
        $(".header-menu .btn-menu.btn-lang").click(function (e) {
            e.preventDefault();
            n.toggleClass("open")
        })
    })
});
//=================== Side Menu ================================
$(document).ready(function () {
    $(".menu-icon").click(function () {
        $(".sidenav").toggleClass("visible")
    });
    $(".close-menu img").click(function () {
        $(".sidenav").removeClass("visible")
    });
    $(".bg-overlay table.previousServices").on("click", "tr a.remove", function (e) {
        e.preventDefault();
        $(this).closest("tr").remove()
    })
});


//=================== remove-item ================================
$(document).ready(function(){
    $('.remove-item').on('click',function(e){
        e.preventDefault();
        $(this).closest('.cart-item tr').fadeOut('slow', function(){(this).remove()});
    });
    if ($(window).width() < 768) {
        $(".panel-collapse").removeClass('in');
        $("a.collapsed").attr("aria-expanded","false");
    }
});
//====================== Footer bottom ==========================
$(document).ready(function(){
    function footerAlign() {
        $('footer').css('display', 'block');
        $('footer').css('height', 'auto');
        var footerHeight = $('footer').outerHeight();
        $('body').css('padding-bottom', footerHeight);
        $('footer').css('height', footerHeight);
    }
    footerAlign();
    $(window).resize(function () {
        footerAlign();
    });
});
//===================== JS for Price Range slider ==============

$(function() {
    $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: 99999,
        values: [ 10000, 60000 ],
        slide: function( event, ui ) {
            $( "#amount1" ).val( ui.values[ 0 ] + " L.E ");
            $( "#amount2" ).val( ui.values[ 1 ] + " L.E ");
        }
    });
    $( "#amount1" ).val( $( "#slider-range" ).slider( "values", 0 ) + " L.E " );
    $( "#amount2" ).val( $( "#slider-range" ).slider( "values", 1 ) + " L.E " );
});
//======================== Init WOW =======
$(document).ready(function(){
    wow = new WOW
    (
        {
            boxClass: 'wow',            // default
            animateClass: 'animated',   // default
            offset: 1,                  // default
            mobile: false,               // default
            live: true                  // default
        }
    );
    wow.init();
});

$(".owl-carousel.categories-slider").owlCarousel({
    loop:true,
    nav:true,
    navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"] ,
    margin:0,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    responsiveClass:true,
    responsive: {
        0: {
            items: 1
        },
        480: {
            items: 2
        },
        768: {
            items: 3
        },
        992: {
            items: 4
        },
        1200: {
            items: 5
        }
    }
});
$('.owl-carousel.index-slider').owlCarousel({
    loop:true,
    nav:false,
    rtl: true,
    margin:0,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
        },
    }
});
$(".owl-carousel.products-slider").owlCarousel({
    loop:true,
    nav:true,
    navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"] ,
    margin:20,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    responsiveClass:true,
    responsive: {
        0: {
            items: 1
        },
        768: {
            items: 2
        },
        992: {
            items: 3
        },
        1200: {
            items: 4
        }
    }
});

// Colors and size active
// Trigger next tap
jQuery('body').on('click','.next-tab', function(){
    var next = jQuery('.nav-tabs > .active').next('li');
    if(next.length){
        next.find('a').trigger('click');
    }else{
        jQuery('#myTabs a:first').tab('show');
    }
});
// Show featured products if tab home active
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    if ($('.tab-pane#home').hasClass('active')){
        $('.seller-featured-products').fadeIn();
    }
    else{
        $('.seller-featured-products').fadeOut();
    };
});

