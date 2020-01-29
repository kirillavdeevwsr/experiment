$('.slider-items').slick({
    autoplay: true,
    prevArrow: '<span class="sliderArrow sliderMain prev"><img class="sliderPrev" src="/img/check1.png"></span>',
    nextArrow: '<span class="sliderArrow sliderMain next"><img class="sliderNext" src="/img/check2.png"></span>',
});


$('.slider-gallery').slick({
    autoplay: true,
    slidesToShow: 3,
    prevArrow: '<span class="sliderArrow partnersTop prev"><img class="sliderPrev" src="/img/check1.png"></span>',
    nextArrow: '<span class="sliderArrow partnersTop next"><img class="sliderNext" src="/img/check2.png"></span>',
    dots: false,
    dotsClass: "my-dots",
    responsive: [{
        breakpoint: 980,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true
        }
    },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true
            }
        }
    ]
});


// $('.partners-slider').slick({
//     autoplay: true,
//     slidesToShow: 4,
//     prevArrow: '<span class="sliderArrow partnersTop prev"><img class="sliderPrev" src="/img/check1.png"></span>',
//     nextArrow: '<span class="sliderArrow partnersTop next"><img class="sliderNext" src="/img/check2.png"></span>',
//     responsive: [{
//         breakpoint: 980,
//         settings: {
//             slidesToShow: 2,
//             slidesToScroll: 1,
//             dots: false
//         }
//     },
//         {
//             breakpoint: 480,
//             settings: {
//                 slidesToShow: 1,
//                 slidesToScroll: 1,
//                 dots: false,
//                 arrows: false
//             }
//         }
//     ]
// });

$(document).ready(function () {
    $('.news-slider').slick({
        autoplay: true,
        slidesToShow: 3,
        arrows: false,
        dots: true,
        dotsClass: "my-dots",
        responsive: [{
            breakpoint: 1100,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                dots: true,
                infinite: true
            }
        },
            {
                breakpoint: 550,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    infinite: false
                }
            }
        ]
    });
});


$('.events-slider').slick({
    vertical: true,
    slidesToShow: 2,
    verticalSwiping: true,
    dots: true,
    dotsClass: "my-dots",
    arrows: false,
    responsive: [{
        breakpoint: 780,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            dots: false,
            infinite: false
        }
    },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                infinite: false
            }
        }
    ]
});

$('.cources-slider').slick({
    autoplay: true,
    slidesToShow: 4,
    arrows: false,
    dots: true,
    dotsClass: "my-dots",
    responsive: [
        {
            breakpoint: 1120,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                dots: true,
                infinite: false
            }
        },
        {
            breakpoint: 960,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: true,
                infinite: false
            }
        },
        {
            breakpoint: 560,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                infinite: false
            }
        }
    ]
});
