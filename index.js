const headerLi = document.querySelectorAll('.headerUl a');
const checkbox = document.querySelector('.checkbox');
headerLi.forEach((item) => {
  item.addEventListener('click', () => {
    checkbox.checked = false;
  });
});

function scrollTrigger(selector, options = {}) {
  let els = document.querySelectorAll(selector);
  els = Array.from(els);
  els.forEach((el) => {
    addObserver(el, options);
  });
}

function addObserver(el, options) {
  let observer = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        if (options.cb) {
          options.cb(el);
        } else {
          entry.target.classList.add('is-animated');
        }
        observer.unobserve(entry.target);
      }
    });
  }, options);
  observer.observe(el);
}
scrollTrigger('.animation');

$(function () {
  $('.accordion-button-1').click(function () {
    $(this).next('.accordion-content').stop().slideToggle();
    $(this).toggleClass('activate');
  });
});

// Cache selectors
var lastId,
  topMenu = $('#headerUl'),
  topMenuHeight = topMenu.outerHeight() + 15,
  // All list items
  menuItems = topMenu.find('a'),
  // Anchors corresponding to menu items
  scrollItems = menuItems.map(function () {
    var item = $($(this).attr('href'));
    if (item.length) {
      return item;
    }
  });

// Bind click handler to menu items
// so we can get a fancy scroll animation
menuItems.click(function (e) {
  var href = $(this).attr('href'),
    offsetTop = href === '#' ? 0 : $(href).offset().top - topMenuHeight + 1;
  $('html, body').stop().animate(
    {
      scrollTop: offsetTop,
    },
    300
  );
  e.preventDefault();
});

// Hàm sẽ có underline đánh dấu cho menu
$(window).scroll(function () {
  // Get container scroll position
  var fromTop = $(this).scrollTop() + topMenuHeight;

  // Get id of current scroll item
  var cur = scrollItems.map(function () {
    if ($(this).offset().top < fromTop) return this;
  });
  // Get the id of the current element
  cur = cur[cur.length - 1];
  var id = cur && cur.length ? cur[0].id : '';

  if (lastId !== id) {
    lastId = id;
    // Set/remove active class
    menuItems
      .children()
      .removeClass('headerActive')
      .end()
      .filter("[href='#" + id + "']")
      .children()
      .addClass('headerActive');
  }
});
