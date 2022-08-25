const $jq = jQuery.noConflict();


$jq('.header__slider').slick({
  infinite: true,
  fade: true,
  prevArrow: '<img class="slider-arrows slider-arrows__left" src="images/arrow-left.svg" alt="prev">',
  nextArrow: '<img class="slider-arrows slider-arrows__right" src="images/arrow-right.svg" alt="right">',
  asNavFor: '.slider-dotshead'
});
$jq('.slider-dotshead').slick({
  slidesToShow: 4,
  slidesToScroll: 4,
  asNavFor: '.header__slider'
});

$jq('.surf-slider').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  prevArrow: '<img class="slider-arrows slider-arrows__left" src="images/arrow-left.svg" alt="prev">',
  nextArrow: '<img class="slider-arrows slider-arrows__right" src="images/arrow-right.svg" alt="right">',
  asNavFor: '.slider-map',
});
$jq('.slider-map').slick({
  slidesToShow: 8,
  slidesToScroll: 1,
  arrows: false,
  asNavFor: '.surf-slider',
  focusOnSelect: true,
});
$jq('.travel__slider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  focusOnSelect: true,
});
