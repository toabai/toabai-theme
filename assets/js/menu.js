document.addEventListener('DOMContentLoaded', function() {
  const btn = document.querySelector('.tm-menu-toggle');
  const menu = document.querySelector('.tm-mobile-menu');
  const closeBtn = document.querySelector('.tm-menu-close');

  if (btn && menu) {
    function closeMenu() {
      menu.classList.remove('active');
      btn.classList.remove('active');
      document.body.classList.remove('tm-menu-open');
      btn.setAttribute('aria-expanded', 'false');
      menu.setAttribute('aria-hidden', 'true');
    }

    function openMenu() {
      menu.classList.add('active');
      btn.classList.add('active');
      document.body.classList.add('tm-menu-open');
      btn.setAttribute('aria-expanded', 'true');
      menu.setAttribute('aria-hidden', 'false');
    }

    btn.addEventListener('click', function() {
      if (menu.classList.contains('active')) {
        closeMenu();
      } else {
        openMenu();
      }
    });

    if (closeBtn) {
      closeBtn.addEventListener('click', closeMenu);
    }

    const links = menu.querySelectorAll('a');

    links.forEach(function(link) {
      link.addEventListener('click', closeMenu);
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeMenu();
      }
    });
  }
});
