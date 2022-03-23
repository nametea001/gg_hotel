// use style my build
require('./layout.css');
require('./style.css');
require('./animate.css');
require('./home.css');
require('./_gallery.css');
// add jquery justifiedGallery css adnd js
require('./justifiedGallery.css')
require('justifiedGallery/dist/js/jquery.justifiedGallery.js');
require('justifiedGallery/dist/js/jquery.justifiedGallery.min.js');
window.jQuery = require('jquery');
window.$ = window.jQuery;
// add bootstrap css and js
require('bootstrap');
require('bootstrap-select');
require('bootstrap-datepicker');
require('popper.js');
require('bootstrap/dist/css/bootstrap.css');
require('bootstrap/dist/js/bootstrap.js');
require('bootstrap/dist/js/bootstrap.min.js');
require('bootstrap-select/dist/css/bootstrap-select.min.css');
require('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
// add fortawesome css 
require('@fortawesome/fontawesome-free-webfonts/css/fontawesome.css');
require('@fortawesome/fontawesome-free/css/all.min.css');
window.Swal = require('sweetalert2');
// require web and css 
$(function() {
    "use strict"; // Start of use strict
  
    // Toggle the side navigation
    $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
      $("body").toggleClass("sidebar-toggled");
      $(".sidebar").toggleClass("toggled");
      if ($(".sidebar").hasClass("toggled")) {
        $('.sidebar .collapse').collapse('hide');
      };
    });
  
  
    // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
    $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
      if ($(window).width() > 768) {
        var e0 = e.originalEvent,
          delta = e0.wheelDelta || -e0.detail;
        this.scrollTop += (delta < 0 ? 1 : -1) * 30;
        e.preventDefault();
      }
    });
  
    // Scroll to top button appear
    $(document).on('scroll', function() {
      var scrollDistance = $(this).scrollTop();
      if (scrollDistance > 100) {
        $('.scroll-to-top').fadeIn();
      } else {
        $('.scroll-to-top').fadeOut();
      }
    });
  
    // Smooth scrolling using jQuery easing
    $(document).on('click', 'a.scroll-to-top', function(e) {
      var $anchor = $(this);
      $('html, body').stop().animate({
        scrollTop: ($($anchor.attr('href')).offset().top)
      }, 1000, 'easeInOutExpo');
      e.preventDefault();
    });
});
