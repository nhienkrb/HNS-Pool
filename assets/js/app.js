import "../css/app.css";
import Swiper from "swiper/bundle";
// Swiper 1
new Swiper(".mySwiper", {
  loop: true,
  slidesPerView: 1,
  spaceBetween: 30,
  pagination: { el: ".swiper-pagination", clickable: true },
  navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
});

// Swiper 2
new Swiper(".mySwiper2", {
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

// Swiper 3
new Swiper(".newsSwiper", {
  slidesPerView: 4,
  spaceBetween: 24,
  loop: true,
  navigation: {
    nextEl: ".newsSwiper .news-next",
    prevEl: ".newsSwiper .news-prev",
  },
  breakpoints: {
    320: { slidesPerView: 1 },
    500: { slidesPerView: 2},
    768: { slidesPerView: 3 },
    1024: { slidesPerView: 4 },
  },
});
