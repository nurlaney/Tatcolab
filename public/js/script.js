$('.main-slinder-site').owlCarousel({
    loop: true,
    dots: false,
    margin: 10,
    nav: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 1
        }
    }


})

$(".owl-prev").css({
    "color": '#fff',
    "font-size": "120px",
    "position": "absolute",
    "top": "15%",
    "left": "0",
    "outline": "none"
});

$(".owl-next").css({
    "color": '#fff',
    "font-size": "120px",
    "position": "absolute",
    "top": "15%",
    "right": "0",
    "outline": "none"
});

$('.s').owlCarousel({
    loop: true,
    margin: 10,
    nav: false,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1200: {
            items: 4
        }
    }
})