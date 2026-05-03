document.addEventListener('DOMContentLoaded', function () {

  const items = document.querySelectorAll('.tm-reveal');

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
      }
    });
  }, {
    threshold: 0.15
  });

  items.forEach(item => observer.observe(item));

});
