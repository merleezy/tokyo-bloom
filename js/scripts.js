document.addEventListener('DOMContentLoaded', function () {
  const images = [
    '../images/sushi_background.jpg',
    '../images/sushi-plate.jpg',
    '../images/kitchen-interior.jpg'
  ];

  let currentIndex = 0;
  const heroElement = document.querySelector('.dynamic-hero');
  if (!heroElement || !images.length) return;

  // Create the initial visible image
  let currentImg = document.createElement('img');
  currentImg.src = images[currentIndex];
  currentImg.className = 'hero-img current';
  heroElement.appendChild(currentImg);

  // Helper to slide to the next image
  function slideTo(nextIndex) {
    const nextImg = document.createElement('img');
    nextImg.src = images[nextIndex];
    nextImg.className = 'hero-img next';
    // Ensure next image starts off to the right
    nextImg.style.transform = 'translateX(100%)';
    heroElement.appendChild(nextImg);

    // Force a reflow so the browser registers the start position
    // before we change transforms — this enables the CSS transition.
    nextImg.offsetHeight;

    // Start the sliding animation
    currentImg.classList.add('leaving');
    currentImg.style.transform = 'translateX(-100%)';
    nextImg.style.transform = 'translateX(0)';

    // When the incoming image finishes transitioning, remove the old one
    function onTransitionEnd() {
      if (currentImg && currentImg.parentNode) currentImg.parentNode.removeChild(currentImg);
      nextImg.removeEventListener('transitionend', onTransitionEnd);
      currentImg = nextImg;
    }

    nextImg.addEventListener('transitionend', onTransitionEnd);
  }

  // Rotate images every 5 seconds
  setInterval(() => {
    const nextIndex = (currentIndex + 1) % images.length;
    slideTo(nextIndex);
    currentIndex = nextIndex;
  }, 5000);
});