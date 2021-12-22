
$(document).ready(function () {

    $('.items').slick({
        // dots: true,
        infinite: true,
        speed: 800,
        autoplay: false,
        autoplaySpeed: 2000,
        slidesToShow: 10,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    infinite: true,
                    // dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            }

        ]
    });
    });
