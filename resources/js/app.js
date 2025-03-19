import Swiper from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import { Autoplay, Navigation, Pagination } from 'swiper/modules';
import './bootstrap';

window.addEventListener('alert',(event) => {
    let data = event.detail;

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        }
      });
      Toast.fire({
        icon: data.type,
        text: data.title,
      });
})



// init Swiper:
const swiper = new Swiper('.swiper-container', {
  // configure Swiper to use modules
  modules: [Navigation, Pagination, Autoplay],

  slidesPerView: 1, // Number of slides visible
  centeredSlides: true, // Center the active slide
  spaceBetween: 30, // Space between slides
  // slidesPerGroup:3,
  loop: true, // Enable looping
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
  navigation: {
    nextEl: ".custom-next-btn",
    prevEl: ".custom-prev-btn",
  },
  breakpoints: {
    // Responsive design, changing slidesPerView based on screen width Code by Amit Niranjan
    640: {
      slidesPerView: 1.4,
    },
    768: {
      slidesPerView: 2.4,
    },
    1024: {
      slidesPerView: 3.5,
    },
    1280: {
      slidesPerView: 4.2,
    },
  },

});

const swiperSlider = new Swiper(".mySwiper", {
  modules: [Navigation, Pagination, Autoplay],
  loop: true,
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
  },
});