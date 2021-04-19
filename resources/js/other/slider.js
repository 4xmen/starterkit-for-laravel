require('owl.carousel/dist/owl.carousel.min');
require('wowjs/dist/wow.min');

jQuery(function () {
    var singleSlide = $('#single-slider').owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        autoplay: true,
        autoplayTimeout: 9000,
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
        },
        pause_on_hover: true
    });
    $('.multi-slide').owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        autoplayTimeout: 9000,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    $('.single-slider').owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        autoplayTimeout: 9000,
        autoplay: true,
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
    });
    singleSlide.on('changed.owl.carousel', function (event) {
        // Trigger method goes here
        $("#single-slider .item div").removeClass('wow backInUp animated').attr("style", "");
        setTimeout(function () {
            $("#single-slider .item div").addClass("wow backInUp animated");
            $("#single-slider .item div").attr("style", "visibility: visible; animation-name: backInUp;");
        }, 100);

    });
});
