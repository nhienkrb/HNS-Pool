import "./style.css";
import Swiper from "swiper/bundle";
import "swiper/css/bundle";

new Swiper(".linhvuc-swiper", {
  slidesPerView: 2,
  spaceBetween: 16,
  grabCursor: true,
  breakpoints: {
    640: {
      slidesPerView: 1.5,
      spaceBetween: 20,
    },
    1024: {
      slidesPerView: 2.5,
      spaceBetween: 24,
    },
  },
  navigation: {
    nextEl: ".linhvuc-next",
    prevEl: ".linhvuc-prev",
  },
});

new Swiper(".duan-swiper", {
  effect: "cards",
  grabCursor: true,
  loop: true,
  allowTouchMove: true,
  simulateTouch: true,
  cardsEffect: {
    perSlideOffset: 10,
    perSlideRotate: 0,
    slideShadows: false,
  },
});

new Swiper(".duan-service-swiper", {
  slidesPerView: 1,
  loop: true,
  spaceBetween: 24,
  grabCursor: true,

  navigation: {
    nextEl: ".duan-service-next",
    prevEl: ".duan-service-prev",
  },

  pagination: {
    el: ".duan-service-pagination",
    clickable: true,
  },
});

new Swiper(".project-gallery-swiper", {
  effect: "cards",
  grabCursor: true,
  loop: true,
  centeredSlides: true,

  cardsEffect: {
    perSlideOffset: 15,
    perSlideRotate: 0,
    slideShadows: false,
  },

  navigation: {
    nextEl: ".project-gallery-next",
    prevEl: ".project-gallery-prev",
  },
});

new Swiper(".related-projects-swiper", {
  slidesPerView: 1.1,
  spaceBetween: 16,
  loop: true,
  grabCursor: true,
  breakpoints: {
    768: { slidesPerView: 2, spaceBetween: 20 },
    1024:{ slidesPerView: 3, spaceBetween: 24 },
  },
  navigation: {
    nextEl: ".related-projects-next",
    prevEl: ".related-projects-prev",
  },
});

