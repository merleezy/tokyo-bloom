document.addEventListener("DOMContentLoaded", function () {
  const images = [
    '../images/sushi_background.jpg',
    '../images/sushi-plate.jpg',
    '../images/kitchen-interior.jpg' 
  ];

  let currentIndex = 0;
  // Target any element with the class 'dynamic-hero'
  const heroElement = document.querySelector('.dynamic-hero');

  if (heroElement) {
    // Function to rotate images
    setInterval(() => {
      currentIndex = (currentIndex + 1) % images.length;
      heroElement.style.backgroundImage = `url('${images[currentIndex]}')`;
    }, 5000);
  }
});