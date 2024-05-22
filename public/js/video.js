let swiper = new Swiper(".swiper-container", {
    freeMode: true,

    mousewheel: {
        forceToAxis: true,
        releaseOnEdges: true,
    },
    slidesPerView: 2,
    slidesPerGroup: 1,
    centeredSlides: true,
    breakpoints: {
        // when window width is >= 600px
        600: {
            slidesPerView: 2,
            slidesPerGroup: 2,
            spaceBetween: 5,
            centeredSlides: true

        },
        // when window width is >= 900px
        900: {
            slidesPerView: 3,
            slidesPerGroup: 3,
            spaceBetween: 5,
            centeredSlides: false

        },
        // when window width is >= 1200px
        1200: {
            slidesPerView: 4,
            slidesPerGroup: 4,
            spaceBetween: 5,
            centeredSlides: false
        },

        // when window width is >= 1500px
        1500: {
            slidesPerView: 5,
            slidesPerGroup: 5,
            spaceBetween: 5,
            centeredSlides: false
        },

        // when window width is >= 1800px
        1800: {
            slidesPerView: 6,
            slidesPerGroup: 6,
            spaceBetween: 5,
            centeredSlides: false
        }
    }
});


