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


const featureContent = {
  1: {
    title: "Tiêu đề cho icon 1",
    desc: "Nội dung mô tả tương ứng icon 1."
  },
  2: {
    title: "Tiêu đề cho icon 2",
    desc: "Nội dung mô tả tương ứng icon 2."
  },
  3: {
    title: "Tiêu đề cho icon 3",
    desc: "Cam kết sản phẩm an toàn, ổn định, đáp ứng các tiêu chuẩn kiểm định nghiêm ngặt và không ngừng cải tiến để phù hợp với thị hiếu và nhu cầu của người tiêu dùng Việt."
  },
   4: {
    title: "Tiêu đề cho icon 4",
    desc: "Cam kết sản phẩm an toàn, ổn định, đáp ứng các tiêu chuẩn kiểm định nghiêm ngặt và không ngừng cải tiến để phù hợp với thị hiếu và nhu cầu của người tiêu dùng Việt."
  },
  5: {
    title: "Sản phẩm chất lượng, đáp ứng nhu cầu khách hàng",
    desc: "Cam kết sản phẩm an toàn, ổn định, đáp ứng các tiêu chuẩn kiểm định nghiêm ngặt và không ngừng cải tiến để phù hợp với thị hiếu và nhu cầu của người tiêu dùng Việt."
  }
};


$(document).ready(function () {

    $(".feature-icon").on("click", function () {

        $(".feature-icon").removeClass("active bg-xanh text-white").addClass("bg-white");

        $(this).addClass("active bg-xanh text-white").removeClass("bg-white");

        const id = $(this).data("id");

        $(".content-title").text(featureContent[id].title);
        $(".content-desc").text(featureContent[id].desc);
    });

});
