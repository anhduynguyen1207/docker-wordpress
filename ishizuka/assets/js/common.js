// リンク無効
$(function(){
    $('.is-noLink a').click(function(){
        return false;
    });
});

// smooth scroll
$(document).ready(function(){
    $('a[href^="#"]').click(function() {
      let speed = 600; // ミリ秒で記述
      let href = $(this).attr("href");
      let target = $(href == "#" || href == "" ? 'html' : href);
      let position = target.offset().top;
      $('body,html').animate({ scrollTop: position }, speed, 'swing');
      return false;
    });
});

// グローバルナビ
$(function($) {
    $(function() {
        var scrollPos;
        var $header = $('#header-contents');
        // Nav Fixed
        $(window).scroll(function() {
            if ($(window).scrollTop() > 350) {
                $header.addClass('fixed');
            } else {
                $header.removeClass('fixed');
            }
        });
        $('.nav-global-inner,.header-bg-01').css('display', 'none');
        
        // Nav Toggle Button
        $('.box-nav-toggle').click(function(){
            $header.toggleClass('open');
            if($('body').hasClass('fix')){
                $('body').removeClass('fix').css('top',0 + 'px');
                window.scrollTo( 0 , scrollPos );
                $('.nav-global-inner,.header-bg-01').stop(true,true).fadeOut();
            }else{
                scrollPos = $(window).scrollTop();//現在のスクロール位置
                $('body').addClass('fix').css('top',-scrollPos + 'px');
                $('.nav-global-inner,.header-bg-01').css('display', 'none').fadeIn();
            }           
        });
		$('.header-bg-01').click(function(){
			$('.box-nav-toggle').trigger("click");
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
function modalWindow (key, content, closeBtn) {
    let winScrollTop;
    jQuery(key).each(function () {
        jQuery(this).on("click", function () {
            winScrollTop = jQuery(window).scrollTop();
            let target = jQuery(this).data("target");
            let modal = document.getElementById(target);
            jQuery(modal).fadeIn();
            return false;
        });
    });
    jQuery(closeBtn).on("click", function () {
        jQuery(content).fadeOut();
        jQuery("body,html").stop().animate({ scrollTop: winScrollTop }, 100);
        return false;
    });
}
