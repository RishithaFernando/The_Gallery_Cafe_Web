let banner = document.querySelector(".banners");

const slideImgs = [
   "url(../images/Banner/1.png)",
   "url(../images/Banner/2.png)",
   "url(../images/Banner/3.png)",
   "url(../images/Banner/4.png)",
   "url(../images/Banner/5.png)",
];

let currentSlide = 0;

function slideMove() {
   if (currentSlide === 4) {
      currentSlide = 0;
   } else {
      currentSlide++;
   }
   banner.style.backgroundImage = slideImgs[currentSlide];
}

let setInt = setInterval(slideMove, 4000);
