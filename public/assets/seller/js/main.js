//====================== Upload ==========================
$('#chooseFile').bind('change', function () {
    var filename = $(".chooseFile").val();
    if (/^\s*$/.test(filename)) {
        $(".noFile").text("No file chosen...");
    }
    else {
        $(".noFile").text(filename.replace("C:\\fakepath\\", ""));
    }
});
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
//========================  =======
$(document).ready(function() {
    $('.counter').counterUp({
        delay: 10,
        time: 2000
    });
});


$(document).ready(function () {
    var e = $(".header-menu .header-menu-wrapper.cart-menu-wrapper");
    $(document).mouseup(function (n) {
        e.is(n.target) || 0 !== e.has(n.target).length || e.removeClass("open");
        $(".header-menu .btn-menu.btn-cart").click(function (n) {
            n.preventDefault();
            e.toggleClass("open")
        })
    });
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
    $('.remove-item button').on('click',function(e){
        e.preventDefault();
        $(this).closest('.item-shopping-cart').fadeOut('slow', function(){(this).remove()});
    });
    $('.shipping-item-wrapper button.delete').on('click',function(e){
        e.preventDefault();
        $(this).closest('.shipping-item-wrapper').fadeOut('slow', function(){(this).remove()});
    });

    if ($(window).width() < 768) {
        $(".panel-collapse").removeClass('in');
        $("a.collapsed").attr("aria-expanded","false");
    }
});