// Dynamic Hero Image Slider
document.addEventListener('DOMContentLoaded', function () {
  // --- Hours checker (reads schedule from #hours-json on the page) ---
  (function () {
    function parseTimeToDate(timeStr, refDate) {
      const [hh, mm] = timeStr.split(':').map(Number);
      const d = new Date(refDate);
      d.setHours(hh, mm, 0, 0);
      return d;
    }

    function readSchedule() {
      const el = document.querySelector('#hours-json');
      if (!el) return null;
      try {
        return JSON.parse(el.textContent);
      } catch (e) {
        console.warn('Failed to parse hours JSON', e);
        return null;
      }
    }

    function checkOpen(schedule) {
      const statusEl = document.querySelector('#hours-status');
      if (!statusEl) return;
      if (!schedule) {
        statusEl.textContent = 'Hours not available';
        statusEl.classList.remove('open');
        statusEl.classList.add('closed');
        return;
      }
      const now = new Date();
      const day = now.getDay();
      const intervals = schedule[String(day)] || [];
      let isOpen = false;
      for (const iv of intervals) {
        if (!iv || !iv.open || !iv.close) continue;
        const openDate = parseTimeToDate(iv.open, now);
        let closeDate = parseTimeToDate(iv.close, now);
        if (closeDate <= openDate) closeDate.setDate(closeDate.getDate() + 1);
        if (now >= openDate && now < closeDate) {
          isOpen = true;
          break;
        }
      }
      statusEl.textContent = isOpen ? 'Open Now' : 'Closed Now';
      statusEl.classList.toggle('open', isOpen);
      statusEl.classList.toggle('closed', !isOpen);
    }

    const schedule = readSchedule();
    // Initialize and refresh every minute
    checkOpen(schedule);
    setInterval(() => checkOpen(schedule), 60000);
  })();

  // Get base path from current script location or window location
  const basePath = window.location.pathname.includes('/public') 
    ? window.location.pathname.split('/public')[0] 
    : '';
  
  const images = [
    basePath + '/images/sushi_background.jpg',
    basePath + '/images/sushi-plate.jpg',
    basePath + '/images/kitchen-interior.jpg'
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