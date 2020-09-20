
//====================== Footer bottom ==========================
$(document).ready(function(){
    function footerAlign() {
        let footer = $("footer");
        footer.css('display', 'block');
        footer.css('height', 'auto');
        let footerHeight = footer.outerHeight();
        $('body').css('padding-bottom', footerHeight);
        footer.css('height', footerHeight);
    }
    footerAlign();
    $(window).resize(function () {
        footerAlign();
    });
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
//======================== Owl =======
$('.owl-carousel.index-slider, .owl-carousel.category-carousel').owlCarousel({
    loop:true,
    nav:true,
    rtl: true,
    margin:0,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    navText: ["<i class='fa fa-angle-right'></i>","<i class='fa fa-angle-left'></i>"] ,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
        },
    }
});
$('.owl-carousel.categories-slider').owlCarousel({
    loop:true,
    nav:false,
    rtl: true,
    margin:10,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    navText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"] ,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
        },
        768:{
            items:2,
        },
        992:{
            items:3,
        },
        1200:{
            items:4,
        },
    }
});

//=================== add-to-favourites ================================
$(document).ready(function(){
    $('.add-to-favourites').attr('title', 'Add to Favorites').click(function() {
        $(this).toggleClass('active');
        var title = 'Add to Favorites' ;
        if( $(this).hasClass('active')){
            title = 'Added to Favorites';
        }
        $(this).attr('title', title);
    });
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


// Colors and size active
$(".size-list li,.colors-list li").click(function () {
    $(".size-list li,.colors-list li").removeClass("active");
    $(this).toggleClass("active")
});
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
    }
});
// Make deal form
$(document).ready(function(){
    $(".company-data").css("display","none");
    $(".facts-numbers").css("display","none");
    $("#showCompanyData").click(function () {
        $(".company-data").css("display","block")
    })
    $("#showFactsNumbers").click(function () {
        $(".facts-numbers").css("display","block")
    })
});
// Show Select on select option
$(document).ready(function(){
    $('select#selectClassification2').css("display","none");
    $('select#selectClassification3').css("display","none");

    $('select#selectClassification1').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        $('select#selectClassification2').css("display","block");
    });
    $('select#selectClassification2').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        $('select#selectClassification3').css("display","block");
    });
});
//====================== Map
function myMap() {
    let mapCanvas = document.getElementById("map");
    let myCenter = new google.maps.LatLng(30.0470289, 31.3523761);
    let mapOptions = { center: myCenter, zoom: 12 };
    let map = new google.maps.Map(mapCanvas, mapOptions);
    let marker = new google.maps.Marker({
        position: myCenter,
        animation: google.maps.Animation.BOUNCE
    });
    marker.setMap(map);
}

// Get current year
document.getElementById("year").innerHTML = new Date().getFullYear();