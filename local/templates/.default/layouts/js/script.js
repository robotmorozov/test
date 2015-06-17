$(function(){

    $('.grid').masonry({
        isFitWidth: true,
        itemSelector: '.grid-item',
        columnWidth: 277,
        "gutter": 10
    });

    $('.owl-carousel').owlCarousel({
        items:1,
        margin:0,
        loop: true,
        autoplay: true,
        autoplayTimeout: 10000,
        autoplaySpeed: 1000
    });

});