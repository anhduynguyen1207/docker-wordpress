// リンク無効
$(function () {
  $('.is-noLink a').click(function () {
    return false;
  });
});

// smooth scroll
$(document).ready(function () {
  $('a[href^="#"]').click(function () {
    let speed = 600; // ミリ秒で記述
    let href = $(this).attr('href');
    let target = $(href == '#' || href == '' ? 'html' : href);
    let position = target.offset().top;
    $('body,html').animate({ scrollTop: position }, speed, 'swing');
    return false;
  });
});

// グローバルナビ
$(function ($) {
  $(function () {
    var scrollPos;
    var $header = $('#header-contents');
    // Nav Fixed
    $(window).scroll(function () {
      if ($(window).scrollTop() > 350) {
        $header.addClass('fixed');
      } else {
        $header.removeClass('fixed');
      }
    });
    $('.nav-global-inner,.header-bg-01').css('display', 'none');

    // Nav Toggle Button
    $('.box-nav-toggle').click(function () {
      $header.toggleClass('open');
      if ($('body').hasClass('fix')) {
        $('body')
          .removeClass('fix')
          .css('top', 0 + 'px');
        window.scrollTo(0, scrollPos);
        $('.nav-global-inner,.header-bg-01').stop(true, true).fadeOut();
      } else {
        scrollPos = $(window).scrollTop(); //現在のスクロール位置
        $('body')
          .addClass('fix')
          .css('top', -scrollPos + 'px');
        $('.nav-global-inner,.header-bg-01').css('display', 'none').fadeIn();
      }
    });
    $('.header-bg-01').click(function () {
      $('.box-nav-toggle').trigger('click');
    });
  });
});

// 上に戻るボタンのフェードイン・アウト
$(function () {
  $(window).scroll(function () {
    //200pxスクロールしたら
    if ($(this).scrollTop() > 200) {
      //フェードインで表示
      $('.area-common-btn').fadeIn();
    } else {
      $('.area-common-btn').fadeOut();
    }
  });
});

// modal
function modalWindow(key, content, closeBtn) {
  let winScrollTop;
  jQuery(key).each(function () {
    jQuery(this).on('click', function () {
      winScrollTop = jQuery(window).scrollTop();
      let target = jQuery(this).data('target');
      let modal = document.getElementById(target);
      jQuery(modal).fadeIn();
      return false;
    });
  });
  jQuery(closeBtn).on('click', function () {
    jQuery(content).fadeOut();
    jQuery('body,html').stop().animate({ scrollTop: winScrollTop }, 100);
    return false;
  });
}

//header
$(function () {
  $('.headerToggle').on('click', function () {
    $('.headerToggle').toggleClass('showNav');
    $('.headerNavMain').toggleClass('showMenu');
    $('header').toggleClass('headerChangeSP');
  });

  $(window).on('resize load', function () {
    if ($(window).width() <= 768) {
      $('.headerNavChild').hide();
      $('.headerNavLinkChild').on('click resize load', function (e) {
        e.preventDefault();
        if ($(this).hasClass('show_sub_navi')) {
          $(this).removeClass('show_sub_navi');
          $(this).next('.headerNavChild').slideUp();
        } else {
          $('.headerNavLinkChild').removeClass('show_sub_navi');
          $('.headerNavChild').slideUp();
          $(this).addClass('show_sub_navi');
          $(this).next('.headerNavChild').slideDown();
        }
      });
    }
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const ev = ['load', 'scroll', 'resize'];
  const duration = 50;

  const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0,
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      const rect = entry.boundingClientRect;

      if (rect.y <= 0) {
        if (entry.isIntersecting) {
          entry.target.classList.add('topIn');
          entry.target.classList.remove('topOut');
          entry.target.classList.remove('bottomIn');
          entry.target.classList.remove('bottomOut');
        } else {
          entry.target.classList.remove('topIn');
          entry.target.classList.add('topOut');
          entry.target.classList.remove('bottomIn');
          entry.target.classList.remove('bottomOut');
        }
      } else if (rect.y <= (window.innerHeight || document.documentElement.clientHeight)) {
        entry.target.classList.remove('topIn');
        entry.target.classList.remove('topOut');
        entry.target.classList.add('bottomIn');
        entry.target.classList.remove('bottomOut');
      } else if (rect.y >= (window.innerHeight || document.documentElement.clientHeight)) {
        entry.target.classList.remove('topIn');
        entry.target.classList.remove('topOut');
        entry.target.classList.remove('bottomIn');
        entry.target.classList.add('bottomOut');
      }
    });
  }, observerOptions);

  ev.forEach((evt) => {
    window.addEventListener(evt, () => {
      const isAnim = document.querySelectorAll('.isAnimHead');
      const isAnimRun = document.querySelectorAll('.isAnimRun');
      const isAnimFadeIn = document.querySelectorAll('.isAnimFadeIn');
      isAnim.forEach((item) => {
        observer.observe(item);
      });
      isAnimRun.forEach((item) => {
        observer.observe(item);
      });
      isAnimFadeIn.forEach((item) => {
        observer.observe(item);
      });
    });
  });
});
