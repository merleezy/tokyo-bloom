// Dynamic Hero Image Slider
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

// Show open now or closed now in hours section
document.addEventListener('DOMContentLoaded', function () {
  const hoursElement = document.getElementById('hours-status');
  if (!hoursElement) return;

  const now = new Date();
  const day = now.getDay(); // 0 (Sun) to 6 (Sat)
  const hour = now.getHours(); // 0 to 23
  const minutes = now.getMinutes(); // 0 to 59
  const currentTime = hour + (minutes / 60); // Convert to fractional hours

  /* 
  Open hours: 
  Mon-Fri 11:00 AM - 2:30 PM
  Mon-Thurs 5:00 PM - 10:00 PM
  Fri-Sat 5:00 PM - 11:00 PM 
  */
  const isOpen =
    (day >= 1 && day <= 4 && ((currentTime >= 11 && currentTime < 14.5) || (currentTime >= 17 && currentTime < 22))) || // Mon-Thurs
    (day === 5 && ((currentTime >= 11 && currentTime < 14.5) || (currentTime >= 17 && currentTime < 23))) || // Fri
    (day === 6 && currentTime >= 17 && currentTime < 23);   // Sat

  // Show Open Now in green or Closed Now in red based on isOpen
  hoursElement.innerHTML = isOpen ? '<strong style="color: green; font-size: 1.5em;">Open Now</strong>' 
  : '<strong style="color: red; font-size: 1.5em;">Closed Now</strong>';
});