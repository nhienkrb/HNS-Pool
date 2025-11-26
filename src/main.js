import Swiper from "swiper/bundle";
import "./style.css";

new Swiper(".myTimelineSwiper", {
  slidesPerView: 3,
  spaceBetween: 24,
  loop: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    320: { slidesPerView: 1 },
    768: { slidesPerView: 2 },
    1024: { slidesPerView: 3 },
  },
});

 new Swiper(".staffSwiper", {
  slidesPerView: 4,
  spaceBetween: 20,

  loop: true,

  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },

  breakpoints: {
    320:  { slidesPerView: 2 },
    640:  { slidesPerView: 4 },
    1024: { slidesPerView: 5 },
    1280: { slidesPerView: 5 },
  }
});
