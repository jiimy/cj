$(".gift-set .item-wrap").slick({
  dots: false,
  infinite: false,
  arrows: false,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        slideToScroll: 1,
        slidesToShow: 1,
        infinite: true,
      }
    },
  ]
});