/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function ($) {
  var wind_ = $(window),
      body_ = $('body');
  feather.replace({
    'stroke-width': 1
  });
  $(".btn-check-m, .btn-check-d").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });
  $(document).on('click', '[data-toggle="fullscreen"]', function () {
    $(this).toggleClass('active-fullscreen');

    if (document.fullscreenEnabled) {
      if ($(this).hasClass("active-fullscreen")) {
        document.documentElement.requestFullscreen();
      } else {
        document.exitFullscreen();
      }
    } else {
      alert("Your browser does not support fullscreen.");
    }

    return false;
  });
  $(document).on('click', '.overlay', function () {
    $.removeOverlay();

    if (body_.hasClass('hidden-navigation')) {
      $('.navigation .navigation-menu-body').niceScroll().remove();
    }

    body_.removeClass('navigation-show');
  });
  /*------------- create/remove overlay -------------*/

  $.createOverlay = function () {
    if ($('.overlay').length < 1) {
      body_.addClass('no-scroll').append('<div class="overlay"></div>');
      $('.overlay').addClass('show');
    }
  };

  $.removeOverlay = function () {
    body_.removeClass('no-scroll');
    $('.overlay').remove();
  };
  /*------------- create/remove overlay -------------*/


  $('[data-backround-image]').each(function (e) {
    $(this).css("background", 'url(' + $(this).data('backround-image') + ')');
  });
  /*------------- side menu (sub menü arrow) -------------*/

  wind_.on('load', function () {
    setTimeout(function () {
      $('.navigation .navigation-menu-body ul li a').each(function () {
        var $this = $(this);

        if ($this.next('ul').length) {
          $this.append('<i class="sub-menu-arrow fa fa-chevron-down"></i>');
        }
      });
      $('.navigation .navigation-menu-body ul li.open>a>.sub-menu-arrow').removeClass('fa-chevron-down').addClass('fa-minus').addClass('rotate-in');
    }, 200);
  });
  /*------------- side menu (sub menü arrow) -------------*/

  $(document).on('click', '[data-nav-target]', function () {
    var $this = $(this),
        target = $this.data('nav-target');

    if (body_.hasClass('navigation-toggle-one')) {
      body_.addClass('navigation-show');
    }

    $('.navigation .navigation-menu-body .navigation-menu-group > div').removeClass('open');
    $('.navigation .navigation-menu-body .navigation-menu-group ' + target).addClass('open');
    $('[data-nav-target]').removeClass('active');
    $this.addClass('active');
    $this.tooltip('hide');
  });
  $(document).on('click', '.navigation-toggler a', function () {
    if (wind_.width() < 1200) {
      $.createOverlay();
      body_.addClass('navigation-show');
    } else {
      if (!body_.hasClass('navigation-toggle-one') && !body_.hasClass('navigation-toggle-two')) {
        body_.addClass('navigation-toggle-one');
      } else if (body_.hasClass('navigation-toggle-one') && !body_.hasClass('navigation-toggle-two')) {
        body_.addClass('navigation-toggle-two');
        body_.removeClass('navigation-toggle-one');
      } else if (!body_.hasClass('navigation-toggle-one') && body_.hasClass('navigation-toggle-two')) {
        body_.removeClass('navigation-toggle-two');
        body_.removeClass('navigation-toggle-one');
      }
    }

    return false;
  });
  $(document).on('click', '.header-toggler a', function () {
    $('.header ul.navbar-nav').toggleClass('open');
    return false;
  });
  $(document).on('click', '*', function (e) {
    if (!$(e.target).is($('.navigation, .navigation *, .navigation-toggler *')) && body_.hasClass('navigation-toggle-one')) {
      body_.removeClass('navigation-show');
    }
  });
  $(document).on('click', '*', function (e) {
    if (!$(e.target).is('.header ul.navbar-nav, .header ul.navbar-nav *, .header-toggler, .header-toggler *')) {
      $('.header ul.navbar-nav').removeClass('open');
    }
  });
  /*------------- responsive html table -------------*/

  var table_responsive_stack = $(".table-responsive");
  table_responsive_stack.find("th").each(function (i) {
    $(".table-responsive td:nth-child(" + (i + 1) + ")").prepend('<span class="table-responsive-thead">' + $(this).text() + ":</span> ");
    $(".table-responsive-thead").hide();
  });
  table_responsive_stack.each(function () {
    var thCount = $(this).find("th").length,
        rowGrow = 100 / thCount + "%";
    $(this).find("th, td").css("flex-basis", rowGrow);
  });

  function flexTable() {
    if (wind_.width() < 768) {
      $(".table-responsive").each(function (i) {
        $(this).find(".table-responsive-thead").show();
        $(this).find("thead").hide();
      }); // window is less than 768px
    } else {
      $(".table-responsive").each(function (i) {
        $(this).find(".table-responsive-thead").hide();
        $(this).find("thead").show();
      });
    }
  }

  flexTable();

  window.onresize = function (event) {
    flexTable();
  };
  /*------------- responsive html table -------------*/

  /*------------- header search -------------*/


  $(document).on('click', '[data-toggle="search"], [data-toggle="search"] *', function () {
    $('.header .header-body .header-search').show().find('.form-control').focus();
    return false;
  });
  $(document).on('click', '.close-header-search, .close-header-search svg', function () {
    $('.header .header-body .header-search').hide();
    return false;
  });
  $(document).on('click', '*', function (e) {
    if (!$(e.target).is($('.header, .header *, [data-toggle="search"], [data-toggle="search"] *'))) {
      $('.header .header-body .header-search').hide();
    }
  });
  /*------------- header search -------------*/

  /*------------- custom accordion -------------*/

  $(document).on('click', '.accordion.custom-accordion .accordion-row a.accordion-header', function () {
    var $this = $(this);
    $this.closest('.accordion.custom-accordion').find('.accordion-row').not($this.parent()).removeClass('open');
    $this.parent('.accordion-row').toggleClass('open');
    return false;
  });
  /*------------- custom accordion -------------*/

  /*------------- responsive table dropdown -------------*/

  var dropdownMenu,
      table_responsive = $('.table-responsive');
  table_responsive.on('show.bs.dropdown', function (e) {
    dropdownMenu = $(e.target).find('.dropdown-menu');
    body_.append(dropdownMenu.detach());
    var eOffset = $(e.target).offset();
    dropdownMenu.css({
      'display': 'block',
      'top': eOffset.top + $(e.target).outerHeight(),
      'left': eOffset.left,
      'width': '184px',
      'font-size': '14px'
    });
    dropdownMenu.addClass("mobPosDropdown");
  });
  table_responsive.on('hide.bs.dropdown', function (e) {
    $(e.target).append(dropdownMenu.detach());
    dropdownMenu.hide();
  });
  /*------------- responsive table dropdown -------------*/

  /*------------- chat -------------*/

  $(document).on('click', '.chat-app-wrapper .btn-chat-sidebar-open', function () {
    $('.chat-app-wrapper .chat-sidebar').addClass('chat-sidebar-opened');
    return false;
  });
  $(document).on('click', '*', function (e) {
    if (!$(e.target).is('.chat-app-wrapper .chat-sidebar, .chat-app-wrapper .chat-sidebar *, .chat-app-wrapper .btn-chat-sidebar-open, .chat-app-wrapper .btn-chat-sidebar-open *')) {
      $('.chat-app-wrapper .chat-sidebar').removeClass('chat-sidebar-opened');
    }
  });
  /*------------- chat -------------*/

  /*------------- aside menu toggle -------------*/

  $(document).on('click', '.navigation ul li a', function () {
    var $this = $(this);

    if ($this.next('ul').length) {
      var sub_menu_arrow = $this.find('.sub-menu-arrow');
      sub_menu_arrow.toggleClass('rotate-in');
      $this.next('ul').toggle(200);
      $this.parent('li').siblings().find('ul').not($this.parent('li').find('ul')).slideUp(200);
      $this.next('ul').find('li ul').slideUp(200);
      $this.next('ul').find('li>a').find('.sub-menu-arrow').removeClass('fa-minus').addClass('fa-chevron-down');
      $this.next('ul').find('li>a').find('.sub-menu-arrow').removeClass('rotate-in');
      $this.parent('li').siblings().not($this.parent('li').find('ul')).find('>a').find('.sub-menu-arrow').removeClass('fa-minus').addClass('fa-chevron-down');
      $this.parent('li').siblings().not($this.parent('li').find('ul')).find('>a').find('.sub-menu-arrow').removeClass('rotate-in');

      if (sub_menu_arrow.hasClass('rotate-in')) {
        setTimeout(function () {
          sub_menu_arrow.removeClass('fa-chevron-down').addClass('fa-minus');
        }, 200);
      } else {
        sub_menu_arrow.removeClass('fa-minus').addClass('fa-chevron-down');
      }

      if (!body_.hasClass('horizontal-side-menu') && wind_.width() >= 1200) {
        setTimeout(function (e) {
          $('.navigation .navigation-menu-body').getNiceScroll().resize();
        }, 300);
      }

      return false;
    }
  });
  $('body.small-navigation .navigation').hover(function (e) {
    if (body_.hasClass('small-navigation') && !body_.hasClass('horizontal-navigation') && !body_.hasClass('hidden-navigation') && wind_.width() >= 992) {
      $('.navigation .navigation-menu-body').niceScroll();
    }
  }, function () {
    $('.navigation .navigation-menu-body').getNiceScroll().remove();
    $('.navigation ul').attr('style', null);
  });
  /*------------- aside menu toggle -------------*/

  /*------------- other -------------*/

  $(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
  });
  $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget),
        recipient = button.data('whatever'),
        modal = $(this);
    modal.find('.modal-title').text('New message to ' + recipient);
    modal.find('.modal-body input').val(recipient);
  });
  $('[data-toggle="tooltip"]').tooltip({
    container: 'body'
  });
  $('[data-toggle="popover"]').popover();
  $('.carousel').carousel();

  if (wind_.width() >= 992) {
    $('.card-scroll').niceScroll();
    $('.table-responsive').niceScroll();
    $('.app-block .app-content .app-lists').niceScroll();
    $('.app-block .app-sidebar .app-sidebar-menu').niceScroll();
    $('.chat-block .chat-sidebar .chat-sidebar-content').niceScroll();
    var chat_messages = $('.chat-block .chat-content .messages');

    if (chat_messages.length) {
      chat_messages.niceScroll({
        horizrailenabled: false
      });
      chat_messages.getNiceScroll(0).doScrollTop(chat_messages.get(0).scrollHeight, -1);
    }
  }

  if (!body_.hasClass('small-navigation') && !body_.hasClass('horizontal-navigation') && !body_.hasClass('hidden-navigation') && wind_.width() >= 992) {
    $('.navigation .navigation-menu-body').niceScroll();
  }

  $('.dropdown-menu ul.list-group').niceScroll();
  $(document).on('click', '.chat-block .chat-content .mobile-chat-close-btn a', function () {
    $('.chat-block .chat-content').removeClass('mobile-open');
    return false;
  });
})(jQuery);

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/print.scss":
/*!***********************************!*\
  !*** ./resources/sass/print.scss ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*****************************************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ./resources/sass/print.scss ***!
  \*****************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! D:\www\bordash\www\resources\js\app.js */"./resources/js/app.js");
__webpack_require__(/*! D:\www\bordash\www\resources\sass\app.scss */"./resources/sass/app.scss");
module.exports = __webpack_require__(/*! D:\www\bordash\www\resources\sass\print.scss */"./resources/sass/print.scss");


/***/ })

/******/ });