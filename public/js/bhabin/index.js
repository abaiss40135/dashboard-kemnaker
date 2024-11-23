// for vanila js
const closeSplash = () => {
    const splash = document.querySelector(".splash");
    const penghalang = document.querySelector(".penghalang");

    penghalang.style.display = "none";
    splash.style.display = "none";
};

$(function () {
    $(".slick-3-item").slick({
        autoplay: true,
        infinite: false,
        slidesToShow: 3,
        dots: true,
        autoplaySpeed: 12000,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: false,
                    dots: true
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: false,
                    dots: true
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: false,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false
                }
            }
        ]
    });
    $(".slick-1-item").slick({
        autoplay: true,
        slidesToShow: 1,
        arrows: false,
        dots: true,
        adaptiveHeight: true
    });

    $(".slick-3-item").slick({
        autoplay: true,
        infinite: false,
        slidesToShow: 3,
        dots: true,
        autoplaySpeed: 12000,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: false,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false
                }
            }
        ]
    });
})
