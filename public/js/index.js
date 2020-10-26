const carouselItems = document.querySelectorAll('.carousel-item');
const carouselDots = document.querySelectorAll('.dot');
const painPoints = document.querySelectorAll('.pain-point');
const contactHeader = document.querySelector('.contact');
const navBar = document.querySelector('#nav');

let isPlaying = true;
let intervalID;
let current = 0;
let relatedButtonIndex = null;


const showCarouselItem = (e) => {

  isPlaying = false;

  if (!isPlaying) {
    clearInterval(intervalID);
    restartCarousel(initCarousel, 3500, 9000);
  }

   relatedButtonIndex = e.target.dataset.id;
    e.target.classList.add('dot-active');


  if (relatedButtonIndex) {

      current = parseInt(relatedButtonIndex);
    }


  carouselDots.forEach((dot) => {

    if (e.target !== dot) {

      dot.classList.remove('dot-active');
    }
  });

  carouselItems.forEach((carouselItem) => {

    if (!carouselItem.classList.contains('hidden')) {

      carouselItem.classList.add('hidden');
    }
  });

  carouselItems[relatedButtonIndex].classList.remove('hidden');
}

const initCarousel = () => {
   const carouselItemCount = carouselItems.length-1;

    if (current < carouselItemCount) {

       carouselItems[current].classList.add('hidden');
       carouselDots[current].classList.remove('dot-active');

       current = current + 1;

       carouselItems[current].classList.remove('hidden');
       carouselDots[current].classList.add('dot-active');

    } else if (current === carouselItemCount) {

        carouselItems[current].classList.add('hidden');
        carouselDots[current].classList.remove('dot-active');

        current = 0;

        carouselItems[current].classList.remove('hidden');
        carouselDots[current].classList.add('dot-active');
      }
}


const restartCarousel = (func, interval, timeout) => {

  setTimeout(() => {
      clearInterval(intervalID);
    intervalID = setInterval(func, interval);

  }, timeout);
}


if (isPlaying) {
  clearInterval(intervalID);
  intervalID = setInterval(initCarousel, 4000);
}

carouselDots.forEach((dot) => {

  dot.addEventListener('click', showCarouselItem);
});


const isInViewPort = (el) => {

  const bounding = el.getBoundingClientRect();

    return (
        bounding.top >= 0 &&
        bounding.left >= 0 &&
        bounding.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        bounding.right <= (window.innerWidth || document.documentElement.clientWidth)
    );

}

window.addEventListener('scroll', (e) => {

  if (isInViewPort(contactHeader)) {

    painPoints.forEach((painPoint) => {
      painPoint.classList.remove('hidden');
    });
  } else if (isInViewPort(navBar)) {

       painPoints.forEach((painPoint) => {
      painPoint.classList.add('hidden');
    });
  }
});