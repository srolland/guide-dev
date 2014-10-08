/*
 * A JavaScript implementation of the Secure Hash Algorithm, SHA-1, as defined
 * in FIPS PUB 180-1
 * Version 2.1 Copyright Paul Johnston 2000 - 2002.
 * Other contributors: Greg Holt, Andrew Kepert, Ydnar, Lostinet
 * Distributed under the BSD License
 * See http://pajhome.org.uk/crypt/md5 for details.
 */

var hexcase = 0; 
var b64pad  = ""; 
var chrsz   = 8; 

function hex_sha1(s){return binb2hex(core_sha1(str2binb(s),s.length * chrsz));}
function b64_sha1(s){return binb2b64(core_sha1(str2binb(s),s.length * chrsz));}
function str_sha1(s){return binb2str(core_sha1(str2binb(s),s.length * chrsz));}
function hex_hmac_sha1(key, data){ return binb2hex(core_hmac_sha1(key, data));}
function b64_hmac_sha1(key, data){ return binb2b64(core_hmac_sha1(key, data));}
function str_hmac_sha1(key, data){ return binb2str(core_hmac_sha1(key, data));}

function sha1_vm_test()
{
  return hex_sha1("abc") == "a9993e364706816aba3e25717850c26c9cd0d89d";
}

function core_sha1(x, len)
{
  x[len >> 5] |= 0x80 << (24 - len % 32);
  x[((len + 64 >> 9) << 4) + 15] = len;

  var w = Array(80);
  var a =  1732584193;
  var b = -271733879;
  var c = -1732584194;
  var d =  271733878;
  var e = -1009589776;

  for(var i = 0; i < x.length; i += 16)
  {
    var olda = a;
    var oldb = b;
    var oldc = c;
    var oldd = d;
    var olde = e;

    for(var j = 0; j < 80; j++)
    {
      if(j < 16) w[j] = x[i + j];
      else w[j] = rol(w[j-3] ^ w[j-8] ^ w[j-14] ^ w[j-16], 1);
      var t = safe_add(safe_add(rol(a, 5), sha1_ft(j, b, c, d)), 
                       safe_add(safe_add(e, w[j]), sha1_kt(j)));
      e = d;
      d = c;
      c = rol(b, 30);
      b = a;
      a = t;
    }

    a = safe_add(a, olda);
    b = safe_add(b, oldb);
    c = safe_add(c, oldc);
    d = safe_add(d, oldd);
    e = safe_add(e, olde);
  }
  return Array(a, b, c, d, e);
  
}

function sha1_ft(t, b, c, d)
{
  if(t < 20) return (b & c) | ((~b) & d);
  if(t < 40) return b ^ c ^ d;
  if(t < 60) return (b & c) | (b & d) | (c & d);
  return b ^ c ^ d;
}

function sha1_kt(t)
{
  return (t < 20) ?  1518500249 : (t < 40) ?  1859775393 :
         (t < 60) ? -1894007588 : -899497514;
}  

function core_hmac_sha1(key, data)
{
  var bkey = str2binb(key);
  if(bkey.length > 16) bkey = core_sha1(bkey, key.length * chrsz);

  var ipad = Array(16), opad = Array(16);
  for(var i = 0; i < 16; i++) 
  {
    ipad[i] = bkey[i] ^ 0x36363636;
    opad[i] = bkey[i] ^ 0x5C5C5C5C;
  }

  var hash = core_sha1(ipad.concat(str2binb(data)), 512 + data.length * chrsz);
  return core_sha1(opad.concat(hash), 512 + 160);
}

function safe_add(x, y)
{
  var lsw = (x & 0xFFFF) + (y & 0xFFFF);
  var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
  return (msw << 16) | (lsw & 0xFFFF);
}

function rol(num, cnt)
{
  return (num << cnt) | (num >>> (32 - cnt));
}

function str2binb(str)
{
  var bin = Array();
  var mask = (1 << chrsz) - 1;
  for(var i = 0; i < str.length * chrsz; i += chrsz)
    bin[i>>5] |= (str.charCodeAt(i / chrsz) & mask) << (24 - i%32);
  return bin;
}

function binb2str(bin)
{
  var str = "";
  var mask = (1 << chrsz) - 1;
  for(var i = 0; i < bin.length * 32; i += chrsz)
    str += String.fromCharCode((bin[i>>5] >>> (24 - i%32)) & mask);
  return str;
}

function binb2hex(binarray)
{
  var hex_tab = hexcase ? "0123456789ABCDEF" : "0123456789abcdef";
  var str = "";
  for(var i = 0; i < binarray.length * 4; i++)
  {
    str += hex_tab.charAt((binarray[i>>2] >> ((3 - i%4)*8+4)) & 0xF) +
           hex_tab.charAt((binarray[i>>2] >> ((3 - i%4)*8  )) & 0xF);
  }
  return str;
}

function binb2b64(binarray)
{
  var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
  var str = "";
  for(var i = 0; i < binarray.length * 4; i += 3)
  {
    var triplet = (((binarray[i   >> 2] >> 8 * (3 -  i   %4)) & 0xFF) << 16)
                | (((binarray[i+1 >> 2] >> 8 * (3 - (i+1)%4)) & 0xFF) << 8 )
                |  ((binarray[i+2 >> 2] >> 8 * (3 - (i+2)%4)) & 0xFF);
    for(var j = 0; j < 4; j++)
    {
      if(i * 8 + j * 6 > binarray.length * 32) str += b64pad;
      else str += tab.charAt((triplet >> 6*(3-j)) & 0x3F);
    }
  }
  return str;
}
/*
 * jQuery FlexSlider v2.2.0
 * Copyright 2012 WooThemes
 * Contributing Author: Tyler Smith
 */
;
(function ($) {

  //FlexSlider: Object Instance
  $.flexslider = function(el, options) {
    var slider = $(el);

    // making variables public
    slider.vars = $.extend({}, $.flexslider.defaults, options);

    var namespace = slider.vars.namespace,
        msGesture = window.navigator && window.navigator.msPointerEnabled && window.MSGesture,
        touch = (( "ontouchstart" in window ) || msGesture || window.DocumentTouch && document instanceof DocumentTouch) && slider.vars.touch,
        // depricating this idea, as devices are being released with both of these events
        //eventType = (touch) ? "touchend" : "click",
        eventType = "click touchend MSPointerUp",
        watchedEvent = "",
        watchedEventClearTimer,
        vertical = slider.vars.direction === "vertical",
        reverse = slider.vars.reverse,
        carousel = (slider.vars.itemWidth > 0),
        fade = slider.vars.animation === "fade",
        asNav = slider.vars.asNavFor !== "",
        methods = {},
        focused = true;

    // Store a reference to the slider object
    $.data(el, "flexslider", slider);

    // Private slider methods
    methods = {
      init: function() {
        slider.animating = false;
        // Get current slide and make sure it is a number
        slider.currentSlide = parseInt( ( slider.vars.startAt ? slider.vars.startAt : 0) );
        if ( isNaN( slider.currentSlide ) ) slider.currentSlide = 0;
        slider.animatingTo = slider.currentSlide;
        slider.atEnd = (slider.currentSlide === 0 || slider.currentSlide === slider.last);
        slider.containerSelector = slider.vars.selector.substr(0,slider.vars.selector.search(' '));
        slider.slides = $(slider.vars.selector, slider);
        slider.container = $(slider.containerSelector, slider);
        slider.count = slider.slides.length;
        // SYNC:
        slider.syncExists = $(slider.vars.sync).length > 0;
        // SLIDE:
        if (slider.vars.animation === "slide") slider.vars.animation = "swing";
        slider.prop = (vertical) ? "top" : "marginLeft";
        slider.args = {};
        // SLIDESHOW:
        slider.manualPause = false;
        slider.stopped = false;
        //PAUSE WHEN INVISIBLE
        slider.started = false;
        slider.startTimeout = null;
        // TOUCH/USECSS:
        slider.transitions = !slider.vars.video && !fade && slider.vars.useCSS && (function() {
          var obj = document.createElement('div'),
              props = ['perspectiveProperty', 'WebkitPerspective', 'MozPerspective', 'OPerspective', 'msPerspective'];
          for (var i in props) {
            if ( obj.style[ props[i] ] !== undefined ) {
              slider.pfx = props[i].replace('Perspective','').toLowerCase();
              slider.prop = "-" + slider.pfx + "-transform";
              return true;
            }
          }
          return false;
        }());
        // CONTROLSCONTAINER:
        if (slider.vars.controlsContainer !== "") slider.controlsContainer = $(slider.vars.controlsContainer).length > 0 && $(slider.vars.controlsContainer);
        // MANUAL:
        if (slider.vars.manualControls !== "") slider.manualControls = $(slider.vars.manualControls).length > 0 && $(slider.vars.manualControls);

        // RANDOMIZE:
        if (slider.vars.randomize) {
          slider.slides.sort(function() { return (Math.round(Math.random())-0.5); });
          slider.container.empty().append(slider.slides);
        }

        slider.doMath();

        // INIT
        slider.setup("init");

        // CONTROLNAV:
        if (slider.vars.controlNav) methods.controlNav.setup();

        // DIRECTIONNAV:
        if (slider.vars.directionNav) methods.directionNav.setup();

        // KEYBOARD:
        if (slider.vars.keyboard && ($(slider.containerSelector).length === 1 || slider.vars.multipleKeyboard)) {
          $(document).bind('keyup', function(event) {
            var keycode = event.keyCode;
            if (!slider.animating && (keycode === 39 || keycode === 37)) {
              var target = (keycode === 39) ? slider.getTarget('next') :
                           (keycode === 37) ? slider.getTarget('prev') : false;
              slider.flexAnimate(target, slider.vars.pauseOnAction);
            }
          });
        }
        // MOUSEWHEEL:
        if (slider.vars.mousewheel) {
          slider.bind('mousewheel', function(event, delta, deltaX, deltaY) {
            event.preventDefault();
            var target = (delta < 0) ? slider.getTarget('next') : slider.getTarget('prev');
            slider.flexAnimate(target, slider.vars.pauseOnAction);
          });
        }

        // PAUSEPLAY
        if (slider.vars.pausePlay) methods.pausePlay.setup();

        //PAUSE WHEN INVISIBLE
        if (slider.vars.slideshow && slider.vars.pauseInvisible) methods.pauseInvisible.init();

        // SLIDSESHOW
        if (slider.vars.slideshow) {
          if (slider.vars.pauseOnHover) {
            slider.hover(function() {
              if (!slider.manualPlay && !slider.manualPause) slider.pause();
            }, function() {
              if (!slider.manualPause && !slider.manualPlay && !slider.stopped) slider.play();
            });
          }
          // initialize animation
          //If we're visible, or we don't use PageVisibility API
          if(!slider.vars.pauseInvisible || !methods.pauseInvisible.isHidden()) {
            (slider.vars.initDelay > 0) ? slider.startTimeout = setTimeout(slider.play, slider.vars.initDelay) : slider.play();
          }
        }

        // ASNAV:
        if (asNav) methods.asNav.setup();

        // TOUCH
        if (touch && slider.vars.touch) methods.touch();

        // FADE&&SMOOTHHEIGHT || SLIDE:
        if (!fade || (fade && slider.vars.smoothHeight)) $(window).bind("resize orientationchange focus", methods.resize);

        slider.find("img").attr("draggable", "false");

        // API: start() Callback
        setTimeout(function(){
          slider.vars.start(slider);
        }, 200);
      },
      asNav: {
        setup: function() {
          slider.asNav = true;
          slider.animatingTo = Math.floor(slider.currentSlide/slider.move);
          slider.currentItem = slider.currentSlide;
          slider.slides.removeClass(namespace + "active-slide").eq(slider.currentItem).addClass(namespace + "active-slide");
          if(!msGesture){
              slider.slides.click(function(e){
                e.preventDefault();
                var $slide = $(this),
                    target = $slide.index();
                var posFromLeft = $slide.offset().left - $(slider).scrollLeft(); // Find position of slide relative to left of slider container
                if( posFromLeft <= 0 && $slide.hasClass( namespace + 'active-slide' ) ) {
                  slider.flexAnimate(slider.getTarget("prev"), true);
                } else if (!$(slider.vars.asNavFor).data('flexslider').animating && !$slide.hasClass(namespace + "active-slide")) {
                  slider.direction = (slider.currentItem < target) ? "next" : "prev";
                  slider.flexAnimate(target, slider.vars.pauseOnAction, false, true, true);
                }
              });
          }else{
              el._slider = slider;
              slider.slides.each(function (){
                  var that = this;
                  that._gesture = new MSGesture();
                  that._gesture.target = that;
                  that.addEventListener("MSPointerDown", function (e){
                      e.preventDefault();
                      if(e.currentTarget._gesture)
                          e.currentTarget._gesture.addPointer(e.pointerId);
                  }, false);
                  that.addEventListener("MSGestureTap", function (e){
                      e.preventDefault();
                      var $slide = $(this),
                          target = $slide.index();
                      if (!$(slider.vars.asNavFor).data('flexslider').animating && !$slide.hasClass('active')) {
                          slider.direction = (slider.currentItem < target) ? "next" : "prev";
                          slider.flexAnimate(target, slider.vars.pauseOnAction, false, true, true);
                      }
                  });
              });
          }
        }
      },
      controlNav: {
        setup: function() {
          if (!slider.manualControls) {
            methods.controlNav.setupPaging();
          } else { // MANUALCONTROLS:
            methods.controlNav.setupManual();
          }
        },
        setupPaging: function() {
          var type = (slider.vars.controlNav === "thumbnails") ? 'control-thumbs' : 'control-paging',
              j = 1,
              item,
              slide;

          slider.controlNavScaffold = $('<ol class="'+ namespace + 'control-nav ' + namespace + type + '"></ol>');

          if (slider.pagingCount > 1) {
            for (var i = 0; i < slider.pagingCount; i++) {
              slide = slider.slides.eq(i);
              //item = (slider.vars.controlNav === "thumbnails") ? '<img src="' + slide.attr( 'data-thumb' ) + '"/>' : '<a>' + j + '</a>';
              item = (slider.vars.controlNav === "thumbnails") ? '<img src="' + slide.attr( 'data-thumb' ) + '"/>' : '<a><i class="icon-circle"><span>' + j + '</span></i></a>';

              if ( 'thumbnails' === slider.vars.controlNav && true === slider.vars.thumbCaptions ) {
                var captn = slide.attr( 'data-thumbcaption' );
                if ( '' != captn && undefined != captn ) item += '<span class="' + namespace + 'caption">' + captn + '</span>';
              }
              slider.controlNavScaffold.append('<li>' + item + '</li>');
              j++;
            }
          }

          // CONTROLSCONTAINER:
          (slider.controlsContainer) ? $(slider.controlsContainer).append(slider.controlNavScaffold) : slider.append(slider.controlNavScaffold);
          methods.controlNav.set();

          methods.controlNav.active();

          slider.controlNavScaffold.delegate('a, img', eventType, function(event) {
            event.preventDefault();

            if (watchedEvent === "" || watchedEvent === event.type) {
              var $this = $(this),
                  target = slider.controlNav.index($this);

              if (!$this.hasClass(namespace + 'active')) {
                slider.direction = (target > slider.currentSlide) ? "next" : "prev";
                slider.flexAnimate(target, slider.vars.pauseOnAction);
              }
            }

            // setup flags to prevent event duplication
            if (watchedEvent === "") {
              watchedEvent = event.type;
            }
            methods.setToClearWatchedEvent();

          });
        },
        setupManual: function() {
          slider.controlNav = slider.manualControls;
          methods.controlNav.active();

          slider.controlNav.bind(eventType, function(event) {
            event.preventDefault();

            if (watchedEvent === "" || watchedEvent === event.type) {
              var $this = $(this),
                  target = slider.controlNav.index($this);

              if (!$this.hasClass(namespace + 'active')) {
                (target > slider.currentSlide) ? slider.direction = "next" : slider.direction = "prev";
                slider.flexAnimate(target, slider.vars.pauseOnAction);
              }
            }

            // setup flags to prevent event duplication
            if (watchedEvent === "") {
              watchedEvent = event.type;
            }
            methods.setToClearWatchedEvent();
          });
        },
        set: function() {
          var selector = (slider.vars.controlNav === "thumbnails") ? 'img' : 'a';
          slider.controlNav = $('.' + namespace + 'control-nav li ' + selector, (slider.controlsContainer) ? slider.controlsContainer : slider);
        },
        active: function() {
          slider.controlNav.removeClass(namespace + "active").eq(slider.animatingTo).addClass(namespace + "active");
        },
        update: function(action, pos) {
          if (slider.pagingCount > 1 && action === "add") {
            slider.controlNavScaffold.append($('<li><a>' + slider.count + '</a></li>'));
          } else if (slider.pagingCount === 1) {
            slider.controlNavScaffold.find('li').remove();
          } else {
            slider.controlNav.eq(pos).closest('li').remove();
          }
          methods.controlNav.set();
          (slider.pagingCount > 1 && slider.pagingCount !== slider.controlNav.length) ? slider.update(pos, action) : methods.controlNav.active();
        }
      },
      directionNav: {
        setup: function() {
          var directionNavScaffold = $('<ul class="' + namespace + 'direction-nav"><li><a class="' + namespace + 'prev" href="#"><i class="icon-angle-left icon-2x"><span>' + slider.vars.prevText + '</span></i></a></li><li><a class="' + namespace + 'next" href="#"><i class="icon-angle-right icon-2x"><span>' + slider.vars.nextText + '</span></i></a></li></ul>');

          // CONTROLSCONTAINER:
          if (slider.controlsContainer) {
            $(slider.controlsContainer).append(directionNavScaffold);
            slider.directionNav = $('.' + namespace + 'direction-nav li a', slider.controlsContainer);
          } else {
            slider.append(directionNavScaffold);
            slider.directionNav = $('.' + namespace + 'direction-nav li a', slider);
          }

          methods.directionNav.update();

          slider.directionNav.bind(eventType, function(event) {
            event.preventDefault();
            var target;

            if (watchedEvent === "" || watchedEvent === event.type) {
              target = ($(this).hasClass(namespace + 'next')) ? slider.getTarget('next') : slider.getTarget('prev');
              slider.flexAnimate(target, slider.vars.pauseOnAction);
            }

            // setup flags to prevent event duplication
            if (watchedEvent === "") {
              watchedEvent = event.type;
            }
            methods.setToClearWatchedEvent();
          });
        },
        update: function() {
          var disabledClass = namespace + 'disabled';
          if (slider.pagingCount === 1) {
            slider.directionNav.addClass(disabledClass).attr('tabindex', '-1');
          } else if (!slider.vars.animationLoop) {
            if (slider.animatingTo === 0) {
              slider.directionNav.removeClass(disabledClass).filter('.' + namespace + "prev").addClass(disabledClass).attr('tabindex', '-1');
            } else if (slider.animatingTo === slider.last) {
              slider.directionNav.removeClass(disabledClass).filter('.' + namespace + "next").addClass(disabledClass).attr('tabindex', '-1');
            } else {
              slider.directionNav.removeClass(disabledClass).removeAttr('tabindex');
            }
          } else {
            slider.directionNav.removeClass(disabledClass).removeAttr('tabindex');
          }
        }
      },
      pausePlay: {
        setup: function() {
          var pausePlayScaffold = $('<div class="' + namespace + 'pauseplay"><a></a></div>');

          // CONTROLSCONTAINER:
          if (slider.controlsContainer) {
            slider.controlsContainer.append(pausePlayScaffold);
            slider.pausePlay = $('.' + namespace + 'pauseplay a', slider.controlsContainer);
          } else {
            slider.append(pausePlayScaffold);
            slider.pausePlay = $('.' + namespace + 'pauseplay a', slider);
          }

          methods.pausePlay.update((slider.vars.slideshow) ? namespace + 'pause' : namespace + 'play');

          slider.pausePlay.bind(eventType, function(event) {
            event.preventDefault();

            if (watchedEvent === "" || watchedEvent === event.type) {
              if ($(this).hasClass(namespace + 'pause')) {
                slider.manualPause = true;
                slider.manualPlay = false;
                slider.pause();
              } else {
                slider.manualPause = false;
                slider.manualPlay = true;
                slider.play();
              }
            }

            // setup flags to prevent event duplication
            if (watchedEvent === "") {
              watchedEvent = event.type;
            }
            methods.setToClearWatchedEvent();
          });
        },
        update: function(state) {
          (state === "play") ? slider.pausePlay.removeClass(namespace + 'pause').addClass(namespace + 'play').html(slider.vars.playText) : slider.pausePlay.removeClass(namespace + 'play').addClass(namespace + 'pause').html(slider.vars.pauseText);
        }
      },
      touch: function() {
        var startX,
          startY,
          offset,
          cwidth,
          dx,
          startT,
          scrolling = false,
          localX = 0,
          localY = 0,
          accDx = 0;

        if(!msGesture){
            el.addEventListener('touchstart', onTouchStart, false);

            function onTouchStart(e) {
              if (slider.animating) {
                e.preventDefault();
              } else if ( ( window.navigator.msPointerEnabled ) || e.touches.length === 1 ) {
               //Seb: tweak to stop the pause;
               // slider.pause();
                // CAROUSEL:
                cwidth = (vertical) ? slider.h : slider. w;
                startT = Number(new Date());
                // CAROUSEL:

                // Local vars for X and Y points.
                localX = e.touches[0].pageX;
                localY = e.touches[0].pageY;

                offset = (carousel && reverse && slider.animatingTo === slider.last) ? 0 :
                         (carousel && reverse) ? slider.limit - (((slider.itemW + slider.vars.itemMargin) * slider.move) * slider.animatingTo) :
                         (carousel && slider.currentSlide === slider.last) ? slider.limit :
                         (carousel) ? ((slider.itemW + slider.vars.itemMargin) * slider.move) * slider.currentSlide :
                         (reverse) ? (slider.last - slider.currentSlide + slider.cloneOffset) * cwidth : (slider.currentSlide + slider.cloneOffset) * cwidth;
                startX = (vertical) ? localY : localX;
                startY = (vertical) ? localX : localY;

                el.addEventListener('touchmove', onTouchMove, false);
                el.addEventListener('touchend', onTouchEnd, false);
              }
            }

            function onTouchMove(e) {
              // Local vars for X and Y points.

              localX = e.touches[0].pageX;
              localY = e.touches[0].pageY;

              dx = (vertical) ? startX - localY : startX - localX;
              scrolling = (vertical) ? (Math.abs(dx) < Math.abs(localX - startY)) : (Math.abs(dx) < Math.abs(localY - startY));

              var fxms = 500;

              if ( ! scrolling || Number( new Date() ) - startT > fxms ) {
                e.preventDefault();
                if (!fade && slider.transitions) {
                  if (!slider.vars.animationLoop) {
                    dx = dx/((slider.currentSlide === 0 && dx < 0 || slider.currentSlide === slider.last && dx > 0) ? (Math.abs(dx)/cwidth+2) : 1);
                  }
                  slider.setProps(offset + dx, "setTouch");
                }
              }
            }

            function onTouchEnd(e) {
              // finish the touch by undoing the touch session
              el.removeEventListener('touchmove', onTouchMove, false);

              if (slider.animatingTo === slider.currentSlide && !scrolling && !(dx === null)) {
                var updateDx = (reverse) ? -dx : dx,
                    target = (updateDx > 0) ? slider.getTarget('next') : slider.getTarget('prev');

                if (slider.canAdvance(target) && (Number(new Date()) - startT < 550 && Math.abs(updateDx) > 50 || Math.abs(updateDx) > cwidth/2)) {
                  slider.flexAnimate(target, slider.vars.pauseOnAction);
                } else {
                  if (!fade) slider.flexAnimate(slider.currentSlide, slider.vars.pauseOnAction, true);
                }
              }
              el.removeEventListener('touchend', onTouchEnd, false);

              startX = null;
              startY = null;
              dx = null;
              offset = null;
            }
        }else{
            el.style.msTouchAction = "none";
            el._gesture = new MSGesture();
            el._gesture.target = el;
            el.addEventListener("MSPointerDown", onMSPointerDown, false);
            el._slider = slider;
            el.addEventListener("MSGestureChange", onMSGestureChange, false);
            el.addEventListener("MSGestureEnd", onMSGestureEnd, false);

            function onMSPointerDown(e){
                e.stopPropagation();
                if (slider.animating) {
                    e.preventDefault();
                }else{
                    slider.pause();
                    el._gesture.addPointer(e.pointerId);
                    accDx = 0;
                    cwidth = (vertical) ? slider.h : slider. w;
                    startT = Number(new Date());
                    // CAROUSEL:

                    offset = (carousel && reverse && slider.animatingTo === slider.last) ? 0 :
                        (carousel && reverse) ? slider.limit - (((slider.itemW + slider.vars.itemMargin) * slider.move) * slider.animatingTo) :
                            (carousel && slider.currentSlide === slider.last) ? slider.limit :
                                (carousel) ? ((slider.itemW + slider.vars.itemMargin) * slider.move) * slider.currentSlide :
                                    (reverse) ? (slider.last - slider.currentSlide + slider.cloneOffset) * cwidth : (slider.currentSlide + slider.cloneOffset) * cwidth;
                }
            }

            function onMSGestureChange(e) {
                e.stopPropagation();
                var slider = e.target._slider;
                if(!slider){
                    return;
                }
                var transX = -e.translationX,
                    transY = -e.translationY;

                //Accumulate translations.
                accDx = accDx + ((vertical) ? transY : transX);
                dx = accDx;
                scrolling = (vertical) ? (Math.abs(accDx) < Math.abs(-transX)) : (Math.abs(accDx) < Math.abs(-transY));

                if(e.detail === e.MSGESTURE_FLAG_INERTIA){
                    setImmediate(function (){
                        el._gesture.stop();
                    });

                    return;
                }

                if (!scrolling || Number(new Date()) - startT > 500) {
                    e.preventDefault();
                    if (!fade && slider.transitions) {
                        if (!slider.vars.animationLoop) {
                            dx = accDx / ((slider.currentSlide === 0 && accDx < 0 || slider.currentSlide === slider.last && accDx > 0) ? (Math.abs(accDx) / cwidth + 2) : 1);
                        }
                        slider.setProps(offset + dx, "setTouch");
                    }
                }
            }

            function onMSGestureEnd(e) {
                e.stopPropagation();
                var slider = e.target._slider;
                if(!slider){
                    return;
                }
                if (slider.animatingTo === slider.currentSlide && !scrolling && !(dx === null)) {
                    var updateDx = (reverse) ? -dx : dx,
                        target = (updateDx > 0) ? slider.getTarget('next') : slider.getTarget('prev');

                    if (slider.canAdvance(target) && (Number(new Date()) - startT < 550 && Math.abs(updateDx) > 50 || Math.abs(updateDx) > cwidth/2)) {
                        slider.flexAnimate(target, slider.vars.pauseOnAction);
                    } else {
                        if (!fade) slider.flexAnimate(slider.currentSlide, slider.vars.pauseOnAction, true);
                    }
                }

                startX = null;
                startY = null;
                dx = null;
                offset = null;
                accDx = 0;
            }
        }
      },
      resize: function() {
        if (!slider.animating && slider.is(':visible')) {
          if (!carousel) slider.doMath();

          if (fade) {
            // SMOOTH HEIGHT:
            methods.smoothHeight();
          } else if (carousel) { //CAROUSEL:
            slider.slides.width(slider.computedW);
            slider.update(slider.pagingCount);
            slider.setProps();
          }
          else if (vertical) { //VERTICAL:
            slider.viewport.height(slider.h);
            slider.setProps(slider.h, "setTotal");
          } else {
            // SMOOTH HEIGHT:
            if (slider.vars.smoothHeight) methods.smoothHeight();
            slider.newSlides.width(slider.computedW);
            slider.setProps(slider.computedW, "setTotal");
          }
        }
      },
      smoothHeight: function(dur) {
        if (!vertical || fade) {
          var $obj = (fade) ? slider : slider.viewport;
          (dur) ? $obj.animate({"height": slider.slides.eq(slider.animatingTo).height()}, dur) : $obj.height(slider.slides.eq(slider.animatingTo).height());
        }
      },
      sync: function(action) {
        var $obj = $(slider.vars.sync).data("flexslider"),
            target = slider.animatingTo;

        switch (action) {
          case "animate": $obj.flexAnimate(target, slider.vars.pauseOnAction, false, true); break;
          case "play": if (!$obj.playing && !$obj.asNav) { $obj.play(); } break;
          case "pause": $obj.pause(); break;
        }
      },
      pauseInvisible: {
        visProp: null,
        init: function() {
          var prefixes = ['webkit','moz','ms','o'];

          if ('hidden' in document) return 'hidden';
          for (var i = 0; i < prefixes.length; i++) {
            if ((prefixes[i] + 'Hidden') in document) 
            methods.pauseInvisible.visProp = prefixes[i] + 'Hidden';
          }
          if (methods.pauseInvisible.visProp) {
            var evtname = methods.pauseInvisible.visProp.replace(/[H|h]idden/,'') + 'visibilitychange';
            document.addEventListener(evtname, function() {
              if (methods.pauseInvisible.isHidden()) {
                if(slider.startTimeout) clearTimeout(slider.startTimeout); //If clock is ticking, stop timer and prevent from starting while invisible
                else slider.pause(); //Or just pause
              }
              else {
                if(slider.started) slider.play(); //Initiated before, just play
                else (slider.vars.initDelay > 0) ? setTimeout(slider.play, slider.vars.initDelay) : slider.play(); //Didn't init before: simply init or wait for it
              }
            });
          }       
        },
        isHidden: function() {
          return document[methods.pauseInvisible.visProp] || false;
        }
      },
      setToClearWatchedEvent: function() {
        clearTimeout(watchedEventClearTimer);
        watchedEventClearTimer = setTimeout(function() {
          watchedEvent = "";
        }, 3000);
      }
    }

    // public methods
    slider.flexAnimate = function(target, pause, override, withSync, fromNav) {
      if (!slider.vars.animationLoop && target !== slider.currentSlide) {
        slider.direction = (target > slider.currentSlide) ? "next" : "prev";
      }

      if (asNav && slider.pagingCount === 1) slider.direction = (slider.currentItem < target) ? "next" : "prev";

      if (!slider.animating && (slider.canAdvance(target, fromNav) || override) && slider.is(":visible")) {
        if (asNav && withSync) {
          var master = $(slider.vars.asNavFor).data('flexslider');
          slider.atEnd = target === 0 || target === slider.count - 1;
          master.flexAnimate(target, true, false, true, fromNav);
          slider.direction = (slider.currentItem < target) ? "next" : "prev";
          master.direction = slider.direction;

          if (Math.ceil((target + 1)/slider.visible) - 1 !== slider.currentSlide && target !== 0) {
            slider.currentItem = target;
            slider.slides.removeClass(namespace + "active-slide").eq(target).addClass(namespace + "active-slide");
            target = Math.floor(target/slider.visible);
          } else {
            slider.currentItem = target;
            slider.slides.removeClass(namespace + "active-slide").eq(target).addClass(namespace + "active-slide");
            return false;
          }
        }

        slider.animating = true;
        slider.animatingTo = target;

        // SLIDESHOW:
        if (pause) slider.pause();

        // API: before() animation Callback
        slider.vars.before(slider);

        // SYNC:
        if (slider.syncExists && !fromNav) methods.sync("animate");

        // CONTROLNAV
        if (slider.vars.controlNav) methods.controlNav.active();

        // !CAROUSEL:
        // CANDIDATE: slide active class (for add/remove slide)
        if (!carousel) slider.slides.removeClass(namespace + 'active-slide').eq(target).addClass(namespace + 'active-slide');

        // INFINITE LOOP:
        // CANDIDATE: atEnd
        slider.atEnd = target === 0 || target === slider.last;

        // DIRECTIONNAV:
        if (slider.vars.directionNav) methods.directionNav.update();

        if (target === slider.last) {
          // API: end() of cycle Callback
          slider.vars.end(slider);
          // SLIDESHOW && !INFINITE LOOP:
          if (!slider.vars.animationLoop) slider.pause();
        }

        // SLIDE:
        if (!fade) {
          var dimension = (vertical) ? slider.slides.filter(':first').height() : slider.computedW,
              margin, slideString, calcNext;

          // INFINITE LOOP / REVERSE:
          if (carousel) {
            //margin = (slider.vars.itemWidth > slider.w) ? slider.vars.itemMargin * 2 : slider.vars.itemMargin;
            margin = slider.vars.itemMargin;
            calcNext = ((slider.itemW + margin) * slider.move) * slider.animatingTo;
            slideString = (calcNext > slider.limit && slider.visible !== 1) ? slider.limit : calcNext;
          } else if (slider.currentSlide === 0 && target === slider.count - 1 && slider.vars.animationLoop && slider.direction !== "next") {
            slideString = (reverse) ? (slider.count + slider.cloneOffset) * dimension : 0;
          } else if (slider.currentSlide === slider.last && target === 0 && slider.vars.animationLoop && slider.direction !== "prev") {
            slideString = (reverse) ? 0 : (slider.count + 1) * dimension;
          } else {
            slideString = (reverse) ? ((slider.count - 1) - target + slider.cloneOffset) * dimension : (target + slider.cloneOffset) * dimension;
          }
          slider.setProps(slideString, "", slider.vars.animationSpeed);
          if (slider.transitions) {
            if (!slider.vars.animationLoop || !slider.atEnd) {
              slider.animating = false;
              slider.currentSlide = slider.animatingTo;
            }
            slider.container.unbind("webkitTransitionEnd transitionend");
            slider.container.bind("webkitTransitionEnd transitionend", function() {
              slider.wrapup(dimension);
            });
          } else {
            slider.container.animate(slider.args, slider.vars.animationSpeed, slider.vars.easing, function(){
              slider.wrapup(dimension);
            });
          }
        } else { // FADE:
          if (!touch) {
            //slider.slides.eq(slider.currentSlide).fadeOut(slider.vars.animationSpeed, slider.vars.easing);
            //slider.slides.eq(target).fadeIn(slider.vars.animationSpeed, slider.vars.easing, slider.wrapup);

            slider.slides.eq(slider.currentSlide).css({"zIndex": 1}).animate({"opacity": 0}, slider.vars.animationSpeed, slider.vars.easing);
            slider.slides.eq(target).css({"zIndex": 2}).animate({"opacity": 1}, slider.vars.animationSpeed, slider.vars.easing, slider.wrapup);

          } else {
            slider.slides.eq(slider.currentSlide).css({ "opacity": 0, "zIndex": 1 });
            slider.slides.eq(target).css({ "opacity": 1, "zIndex": 2 });
            slider.wrapup(dimension);
          }
        }
        // SMOOTH HEIGHT:
        if (slider.vars.smoothHeight) methods.smoothHeight(slider.vars.animationSpeed);
      }
    }
    slider.wrapup = function(dimension) {
      // SLIDE:
      if (!fade && !carousel) {
        if (slider.currentSlide === 0 && slider.animatingTo === slider.last && slider.vars.animationLoop) {
          slider.setProps(dimension, "jumpEnd");
        } else if (slider.currentSlide === slider.last && slider.animatingTo === 0 && slider.vars.animationLoop) {
          slider.setProps(dimension, "jumpStart");
        }
      }
      slider.animating = false;
      slider.currentSlide = slider.animatingTo;
      // API: after() animation Callback
      slider.vars.after(slider);
    }

    // SLIDESHOW:
    slider.animateSlides = function() {
      if (!slider.animating && focused ) slider.flexAnimate(slider.getTarget("next"));
    }
    // SLIDESHOW:
    slider.pause = function() {
      clearInterval(slider.animatedSlides);
      slider.animatedSlides = null;
      slider.playing = false;
      // PAUSEPLAY:
      if (slider.vars.pausePlay) methods.pausePlay.update("play");
      // SYNC:
      if (slider.syncExists) methods.sync("pause");
    }
    // SLIDESHOW:
    slider.play = function() {
      if (slider.playing) clearInterval(slider.animatedSlides);
      slider.animatedSlides = slider.animatedSlides || setInterval(slider.animateSlides, slider.vars.slideshowSpeed);
      slider.started = slider.playing = true;
      // PAUSEPLAY:
      if (slider.vars.pausePlay) methods.pausePlay.update("pause");
      // SYNC:
      if (slider.syncExists) methods.sync("play");
    }
    // STOP:
    slider.stop = function () {
      slider.pause();
      slider.stopped = true;
    }
    slider.canAdvance = function(target, fromNav) {
      // ASNAV:
      var last = (asNav) ? slider.pagingCount - 1 : slider.last;
      return (fromNav) ? true :
             (asNav && slider.currentItem === slider.count - 1 && target === 0 && slider.direction === "prev") ? true :
             (asNav && slider.currentItem === 0 && target === slider.pagingCount - 1 && slider.direction !== "next") ? false :
             (target === slider.currentSlide && !asNav) ? false :
             (slider.vars.animationLoop) ? true :
             (slider.atEnd && slider.currentSlide === 0 && target === last && slider.direction !== "next") ? false :
             (slider.atEnd && slider.currentSlide === last && target === 0 && slider.direction === "next") ? false :
             true;
    }
    slider.getTarget = function(dir) {
      slider.direction = dir;
      if (dir === "next") {
        return (slider.currentSlide === slider.last) ? 0 : slider.currentSlide + 1;
      } else {
        return (slider.currentSlide === 0) ? slider.last : slider.currentSlide - 1;
      }
    }

    // SLIDE:
    slider.setProps = function(pos, special, dur) {
      var target = (function() {
        var posCheck = (pos) ? pos : ((slider.itemW + slider.vars.itemMargin) * slider.move) * slider.animatingTo,
            posCalc = (function() {
              if (carousel) {
                return (special === "setTouch") ? pos :
                       (reverse && slider.animatingTo === slider.last) ? 0 :
                       (reverse) ? slider.limit - (((slider.itemW + slider.vars.itemMargin) * slider.move) * slider.animatingTo) :
                       (slider.animatingTo === slider.last) ? slider.limit : posCheck;
              } else {
                switch (special) {
                  case "setTotal": return (reverse) ? ((slider.count - 1) - slider.currentSlide + slider.cloneOffset) * pos : (slider.currentSlide + slider.cloneOffset) * pos;
                  case "setTouch": return (reverse) ? pos : pos;
                  case "jumpEnd": return (reverse) ? pos : slider.count * pos;
                  case "jumpStart": return (reverse) ? slider.count * pos : pos;
                  default: return pos;
                }
              }
            }());

            return (posCalc * -1) + "px";
          }());

      if (slider.transitions) {
        target = (vertical) ? "translate3d(0," + target + ",0)" : "translate3d(" + target + ",0,0)";
        dur = (dur !== undefined) ? (dur/1000) + "s" : "0s";
        slider.container.css("-" + slider.pfx + "-transition-duration", dur);
      }

      slider.args[slider.prop] = target;
      if (slider.transitions || dur === undefined) slider.container.css(slider.args);
    }

    slider.setup = function(type) {
      // SLIDE:
      if (!fade) {
        var sliderOffset, arr;

        if (type === "init") {
          slider.viewport = $('<div class="' + namespace + 'viewport"></div>').css({"overflow": "hidden", "position": "relative"}).appendTo(slider).append(slider.container);
          // INFINITE LOOP:
          slider.cloneCount = 0;
          slider.cloneOffset = 0;
          // REVERSE:
          if (reverse) {
            arr = $.makeArray(slider.slides).reverse();
            slider.slides = $(arr);
            slider.container.empty().append(slider.slides);
          }
        }
        // INFINITE LOOP && !CAROUSEL:
        if (slider.vars.animationLoop && !carousel) {
          slider.cloneCount = 2;
          slider.cloneOffset = 1;
          // clear out old clones
          if (type !== "init") slider.container.find('.clone').remove();
          slider.container.append(slider.slides.first().clone().addClass('clone').attr('aria-hidden', 'true')).prepend(slider.slides.last().clone().addClass('clone').attr('aria-hidden', 'true'));
        }
        slider.newSlides = $(slider.vars.selector, slider);

        sliderOffset = (reverse) ? slider.count - 1 - slider.currentSlide + slider.cloneOffset : slider.currentSlide + slider.cloneOffset;
        // VERTICAL:
        if (vertical && !carousel) {
          slider.container.height((slider.count + slider.cloneCount) * 200 + "%").css("position", "absolute").width("100%");
          setTimeout(function(){
            slider.newSlides.css({"display": "block"});
            slider.doMath();
            slider.viewport.height(slider.h);
            slider.setProps(sliderOffset * slider.h, "init");
          }, (type === "init") ? 100 : 0);
        } else {
          slider.container.width((slider.count + slider.cloneCount) * 200 + "%");
          slider.setProps(sliderOffset * slider.computedW, "init");
          setTimeout(function(){
            slider.doMath();
            slider.newSlides.css({"width": slider.computedW, "float": "left", "display": "block"});
            // SMOOTH HEIGHT:
            if (slider.vars.smoothHeight) methods.smoothHeight();
          }, (type === "init") ? 100 : 0);
        }
      } else { // FADE:
        slider.slides.css({"width": "100%", "float": "left", "marginRight": "-100%", "position": "relative"});
        if (type === "init") {
          if (!touch) {
            //slider.slides.eq(slider.currentSlide).fadeIn(slider.vars.animationSpeed, slider.vars.easing);
            slider.slides.css({ "opacity": 0, "display": "block", "zIndex": 1 }).eq(slider.currentSlide).css({"zIndex": 2}).animate({"opacity": 1},slider.vars.animationSpeed,slider.vars.easing);
          } else {
            slider.slides.css({ "opacity": 0, "display": "block", "webkitTransition": "opacity " + slider.vars.animationSpeed / 1000 + "s ease", "zIndex": 1 }).eq(slider.currentSlide).css({ "opacity": 1, "zIndex": 2});
          }
        }
        // SMOOTH HEIGHT:
        if (slider.vars.smoothHeight) methods.smoothHeight();
      }
      // !CAROUSEL:
      // CANDIDATE: active slide
      if (!carousel) slider.slides.removeClass(namespace + "active-slide").eq(slider.currentSlide).addClass(namespace + "active-slide");
    }


    slider.doMath = function() {
      var slide = slider.slides.first(),
          slideMargin = slider.vars.itemMargin,
          minItems = slider.vars.minItems,
          maxItems = slider.vars.maxItems;

      slider.w = (slider.viewport===undefined) ? slider.width() : slider.viewport.width();
      slider.h = slide.height();
      slider.boxPadding = slide.outerWidth() - slide.width();

      // CAROUSEL:
      if (carousel) {
        slider.itemT = slider.vars.itemWidth + slideMargin;
        slider.minW = (minItems) ? minItems * slider.itemT : slider.w;
        slider.maxW = (maxItems) ? (maxItems * slider.itemT) - slideMargin : slider.w;
        slider.itemW = (slider.minW > slider.w) ? (slider.w - (slideMargin * (minItems - 1)))/minItems :
                       (slider.maxW < slider.w) ? (slider.w - (slideMargin * (maxItems - 1)))/maxItems :
                       (slider.vars.itemWidth > slider.w) ? slider.w : slider.vars.itemWidth;

        slider.visible = Math.floor(slider.w/(slider.itemW));
        slider.move = (slider.vars.move > 0 && slider.vars.move < slider.visible ) ? slider.vars.move : slider.visible;
        slider.pagingCount = Math.ceil(((slider.count - slider.visible)/slider.move) + 1);
        slider.last =  slider.pagingCount - 1;
        slider.limit = (slider.pagingCount === 1) ? 0 :
                       (slider.vars.itemWidth > slider.w) ? (slider.itemW * (slider.count - 1)) + (slideMargin * (slider.count - 1)) : ((slider.itemW + slideMargin) * slider.count) - slider.w - slideMargin;
      } else {
        slider.itemW = slider.w;
        slider.pagingCount = slider.count;
        slider.last = slider.count - 1;
      }
      slider.computedW = slider.itemW - slider.boxPadding;
    }


    slider.update = function(pos, action) {
      slider.doMath();

      // update currentSlide and slider.animatingTo if necessary
      if (!carousel) {
        if (pos < slider.currentSlide) {
          slider.currentSlide += 1;
        } else if (pos <= slider.currentSlide && pos !== 0) {
          slider.currentSlide -= 1;
        }
        slider.animatingTo = slider.currentSlide;
      }

      // update controlNav
      if (slider.vars.controlNav && !slider.manualControls) {
        if ((action === "add" && !carousel) || slider.pagingCount > slider.controlNav.length) {
          methods.controlNav.update("add");
        } else if ((action === "remove" && !carousel) || slider.pagingCount < slider.controlNav.length) {
          if (carousel && slider.currentSlide > slider.last) {
            slider.currentSlide -= 1;
            slider.animatingTo -= 1;
          }
          methods.controlNav.update("remove", slider.last);
        }
      }
      // update directionNav
      if (slider.vars.directionNav) methods.directionNav.update();

    }

    slider.addSlide = function(obj, pos) {
      var $obj = $(obj);

      slider.count += 1;
      slider.last = slider.count - 1;

      // append new slide
      if (vertical && reverse) {
        (pos !== undefined) ? slider.slides.eq(slider.count - pos).after($obj) : slider.container.prepend($obj);
      } else {
        (pos !== undefined) ? slider.slides.eq(pos).before($obj) : slider.container.append($obj);
      }

      // update currentSlide, animatingTo, controlNav, and directionNav
      slider.update(pos, "add");

      // update slider.slides
      slider.slides = $(slider.vars.selector + ':not(.clone)', slider);
      // re-setup the slider to accomdate new slide
      slider.setup();

      //FlexSlider: added() Callback
      slider.vars.added(slider);
    }
    slider.removeSlide = function(obj) {
      var pos = (isNaN(obj)) ? slider.slides.index($(obj)) : obj;

      // update count
      slider.count -= 1;
      slider.last = slider.count - 1;

      // remove slide
      if (isNaN(obj)) {
        $(obj, slider.slides).remove();
      } else {
        (vertical && reverse) ? slider.slides.eq(slider.last).remove() : slider.slides.eq(obj).remove();
      }

      // update currentSlide, animatingTo, controlNav, and directionNav
      slider.doMath();
      slider.update(pos, "remove");

      // update slider.slides
      slider.slides = $(slider.vars.selector + ':not(.clone)', slider);
      // re-setup the slider to accomdate new slide
      slider.setup();

      // FlexSlider: removed() Callback
      slider.vars.removed(slider);
    }

    //FlexSlider: Initialize
    methods.init();
  }

  // Ensure the slider isn't focussed if the window loses focus.
  $( window ).blur( function ( e ) {
    focused = false;
  }).focus( function ( e ) {
    focused = true;
  });

  //FlexSlider: Default Settings
  $.flexslider.defaults = {
    namespace: "flex-",             //{NEW} String: Prefix string attached to the class of every element generated by the plugin
    selector: ".slides > li",       //{NEW} Selector: Must match a simple pattern. '{container} > {slide}' -- Ignore pattern at your own peril
    animation: "fade",              //String: Select your animation type, "fade" or "slide"
    easing: "swing",                //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
    direction: "horizontal",        //String: Select the sliding direction, "horizontal" or "vertical"
    reverse: false,                 //{NEW} Boolean: Reverse the animation direction
    animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
    smoothHeight: false,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
    startAt: 0,                     //Integer: The slide that the slider should start on. Array notation (0 = first slide)
    slideshow: true,                //Boolean: Animate slider automatically
    slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
    animationSpeed: 600,            //Integer: Set the speed of animations, in milliseconds
    initDelay: 0,                   //{NEW} Integer: Set an initialization delay, in milliseconds
    randomize: false,               //Boolean: Randomize slide order
    thumbCaptions: false,           //Boolean: Whether or not to put captions on thumbnails when using the "thumbnails" controlNav.

    // Usability features
    pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
    pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
    pauseInvisible: true,   		//{NEW} Boolean: Pause the slideshow when tab is invisible, resume when visible. Provides better UX, lower CPU usage.
    useCSS: true,                   //{NEW} Boolean: Slider will use CSS3 transitions if available
    touch: true,                    //{NEW} Boolean: Allow touch swipe navigation of the slider on touch-enabled devices
    video: false,                   //{NEW} Boolean: If using video in the slider, will prevent CSS3 3D Transforms to avoid graphical glitches

    // Primary Controls
    controlNav: true,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
    directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
    prevText: "Previous",           //String: Set the text for the "previous" directionNav item
    nextText: "Next",               //String: Set the text for the "next" directionNav item

    // Secondary Navigation
    keyboard: true,                 //Boolean: Allow slider navigating via keyboard left/right keys
    multipleKeyboard: false,        //{NEW} Boolean: Allow keyboard navigation to affect multiple sliders. Default behavior cuts out keyboard navigation with more than one slider present.
    mousewheel: false,              //{UPDATED} Boolean: Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider navigating via mousewheel
    pausePlay: false,               //Boolean: Create pause/play dynamic element
    pauseText: "Pause",             //String: Set the text for the "pause" pausePlay item
    playText: "Play",               //String: Set the text for the "play" pausePlay item

    // Special properties
    controlsContainer: "",          //{UPDATED} jQuery Object/Selector: Declare which container the navigation elements should be appended too. Default container is the FlexSlider element. Example use would be $(".flexslider-container"). Property is ignored if given element is not found.
    manualControls: "",             //{UPDATED} jQuery Object/Selector: Declare custom control navigation. Examples would be $(".flex-control-nav li") or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
    sync: "",                       //{NEW} Selector: Mirror the actions performed on this slider with another slider. Use with care.
    asNavFor: "",                   //{NEW} Selector: Internal property exposed for turning the slider into a thumbnail navigation for another slider

    // Carousel Options
    itemWidth: 0,                   //{NEW} Integer: Box-model width of individual carousel items, including horizontal borders and padding.
    itemMargin: 0,                  //{NEW} Integer: Margin between carousel items.
    minItems: 1,                    //{NEW} Integer: Minimum number of carousel items that should be visible. Items will resize fluidly when below this.
    maxItems: 0,                    //{NEW} Integer: Maxmimum number of carousel items that should be visible. Items will resize fluidly when above this limit.
    move: 0,                        //{NEW} Integer: Number of carousel items that should move on animation. If 0, slider will move all visible items.
    allowOneSlide: true,           //{NEW} Boolean: Whether or not to allow a slider comprised of a single slide

    // Callback API
    start: function(){},            //Callback: function(slider) - Fires when the slider loads the first slide
    before: function(){},           //Callback: function(slider) - Fires asynchronously with each slider animation
    after: function(){},            //Callback: function(slider) - Fires after each slider animation completes
    end: function(){},              //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
    added: function(){},            //{NEW} Callback: function(slider) - Fires after a slide is added
    removed: function(){}           //{NEW} Callback: function(slider) - Fires after a slide is removed
  }


  //FlexSlider: Plugin Function
  $.fn.flexslider = function(options) {
    if (options === undefined) options = {};

    if (typeof options === "object") {
      return this.each(function() {
        var $this = $(this),
            selector = (options.selector) ? options.selector : ".slides > li",
            $slides = $this.find(selector);

      if ( ( $slides.length === 1 && options.allowOneSlide === true ) || $slides.length === 0 ) {
          $slides.fadeIn(400);
          if (options.start) options.start($this);
        } else if ($this.data('flexslider') === undefined) {
          new $.flexslider(this, options);
        }
      });
    } else {
      // Helper strings to quickly perform functions on the slider
      var $slider = $(this).data('flexslider');
      switch (options) {
        case "play": $slider.play(); break;
        case "pause": $slider.pause(); break;
        case "stop": $slider.stop(); break;
        case "next": $slider.flexAnimate($slider.getTarget("next"), true); break;
        case "prev":
        case "previous": $slider.flexAnimate($slider.getTarget("prev"), true); break;
        default: if (typeof options === "number") $slider.flexAnimate(options, true);
      }
    }
  }
})(jQuery);

/*!
	Colorbox v1.5.9 - 2014-04-25
	jQuery lightbox and modal window plugin
	(c) 2014 Jack Moore - http://www.jacklmoore.com/colorbox
	license: http://www.opensource.org/licenses/mit-license.php
*/
(function(t,e,i){function n(i,n,o){var r=e.createElement(i);return n&&(r.id=Z+n),o&&(r.style.cssText=o),t(r)}function o(){return i.innerHeight?i.innerHeight:t(i).height()}function r(e,i){i!==Object(i)&&(i={}),this.cache={},this.el=e,this.value=function(e){var n;return void 0===this.cache[e]&&(n=t(this.el).attr("data-cbox-"+e),void 0!==n?this.cache[e]=n:void 0!==i[e]?this.cache[e]=i[e]:void 0!==X[e]&&(this.cache[e]=X[e])),this.cache[e]},this.get=function(e){var i=this.value(e);return t.isFunction(i)?i.call(this.el,this):i}}function h(t){var e=W.length,i=(z+t)%e;return 0>i?e+i:i}function a(t,e){return Math.round((/%/.test(t)?("x"===e?E.width():o())/100:1)*parseInt(t,10))}function s(t,e){return t.get("photo")||t.get("photoRegex").test(e)}function l(t,e){return t.get("retinaUrl")&&i.devicePixelRatio>1?e.replace(t.get("photoRegex"),t.get("retinaSuffix")):e}function d(t){"contains"in x[0]&&!x[0].contains(t.target)&&t.target!==v[0]&&(t.stopPropagation(),x.focus())}function c(t){c.str!==t&&(x.add(v).removeClass(c.str).addClass(t),c.str=t)}function g(e){z=0,e&&e!==!1?(W=t("."+te).filter(function(){var i=t.data(this,Y),n=new r(this,i);return n.get("rel")===e}),z=W.index(_.el),-1===z&&(W=W.add(_.el),z=W.length-1)):W=t(_.el)}function u(i){t(e).trigger(i),ae.triggerHandler(i)}function f(i){var o;if(!G){if(o=t(i).data("colorbox"),_=new r(i,o),g(_.get("rel")),!$){$=q=!0,c(_.get("className")),x.css({visibility:"hidden",display:"block",opacity:""}),L=n(se,"LoadedContent","width:0; height:0; overflow:hidden; visibility:hidden"),b.css({width:"",height:""}).append(L),D=T.height()+k.height()+b.outerHeight(!0)-b.height(),j=C.width()+H.width()+b.outerWidth(!0)-b.width(),A=L.outerHeight(!0),N=L.outerWidth(!0);var h=a(_.get("initialWidth"),"x"),s=a(_.get("initialHeight"),"y"),l=_.get("maxWidth"),f=_.get("maxHeight");_.w=(l!==!1?Math.min(h,a(l,"x")):h)-N-j,_.h=(f!==!1?Math.min(s,a(f,"y")):s)-A-D,L.css({width:"",height:_.h}),J.position(),u(ee),_.get("onOpen"),O.add(I).hide(),x.focus(),_.get("trapFocus")&&e.addEventListener&&(e.addEventListener("focus",d,!0),ae.one(re,function(){e.removeEventListener("focus",d,!0)})),_.get("returnFocus")&&ae.one(re,function(){t(_.el).focus()})}v.css({opacity:parseFloat(_.get("opacity"))||"",cursor:_.get("overlayClose")?"pointer":"",visibility:"visible"}).show(),_.get("closeButton")?B.html(_.get("close")).appendTo(b):B.appendTo("<div/>"),w()}}function p(){!x&&e.body&&(V=!1,E=t(i),x=n(se).attr({id:Y,"class":t.support.opacity===!1?Z+"IE":"",role:"dialog",tabindex:"-1"}).hide(),v=n(se,"Overlay").hide(),S=t([n(se,"LoadingOverlay")[0],n(se,"LoadingGraphic")[0]]),y=n(se,"Wrapper"),b=n(se,"Content").append(I=n(se,"Title"),R=n(se,"Current"),P=t('<button type="button"/>').attr({id:Z+"Previous"}),K=t('<button type="button"/>').attr({id:Z+"Next"}),F=n("button","Slideshow"),S),B=t('<button type="button"/>').attr({id:Z+"Close"}),y.append(n(se).append(n(se,"TopLeft"),T=n(se,"TopCenter"),n(se,"TopRight")),n(se,!1,"clear:left").append(C=n(se,"MiddleLeft"),b,H=n(se,"MiddleRight")),n(se,!1,"clear:left").append(n(se,"BottomLeft"),k=n(se,"BottomCenter"),n(se,"BottomRight"))).find("div div").css({"float":"left"}),M=n(se,!1,"position:absolute; width:9999px; visibility:hidden; display:none; max-width:none;"),O=K.add(P).add(R).add(F),t(e.body).append(v,x.append(y,M)))}function m(){function i(t){t.which>1||t.shiftKey||t.altKey||t.metaKey||t.ctrlKey||(t.preventDefault(),f(this))}return x?(V||(V=!0,K.click(function(){J.next()}),P.click(function(){J.prev()}),B.click(function(){J.close()}),v.click(function(){_.get("overlayClose")&&J.close()}),t(e).bind("keydown."+Z,function(t){var e=t.keyCode;$&&_.get("escKey")&&27===e&&(t.preventDefault(),J.close()),$&&_.get("arrowKey")&&W[1]&&!t.altKey&&(37===e?(t.preventDefault(),P.click()):39===e&&(t.preventDefault(),K.click()))}),t.isFunction(t.fn.on)?t(e).on("click."+Z,"."+te,i):t("."+te).live("click."+Z,i)),!0):!1}function w(){var e,o,r,h=J.prep,d=++le;if(q=!0,U=!1,u(he),u(ie),_.get("onLoad"),_.h=_.get("height")?a(_.get("height"),"y")-A-D:_.get("innerHeight")&&a(_.get("innerHeight"),"y"),_.w=_.get("width")?a(_.get("width"),"x")-N-j:_.get("innerWidth")&&a(_.get("innerWidth"),"x"),_.mw=_.w,_.mh=_.h,_.get("maxWidth")&&(_.mw=a(_.get("maxWidth"),"x")-N-j,_.mw=_.w&&_.w<_.mw?_.w:_.mw),_.get("maxHeight")&&(_.mh=a(_.get("maxHeight"),"y")-A-D,_.mh=_.h&&_.h<_.mh?_.h:_.mh),e=_.get("href"),Q=setTimeout(function(){S.show()},100),_.get("inline")){var c=t(e);r=t("<div>").hide().insertBefore(c),ae.one(he,function(){r.replaceWith(c)}),h(c)}else _.get("iframe")?h(" "):_.get("html")?h(_.get("html")):s(_,e)?(e=l(_,e),U=new Image,t(U).addClass(Z+"Photo").bind("error",function(){h(n(se,"Error").html(_.get("imgError")))}).one("load",function(){d===le&&setTimeout(function(){var e;t.each(["alt","longdesc","aria-describedby"],function(e,i){var n=t(_.el).attr(i)||t(_.el).attr("data-"+i);n&&U.setAttribute(i,n)}),_.get("retinaImage")&&i.devicePixelRatio>1&&(U.height=U.height/i.devicePixelRatio,U.width=U.width/i.devicePixelRatio),_.get("scalePhotos")&&(o=function(){U.height-=U.height*e,U.width-=U.width*e},_.mw&&U.width>_.mw&&(e=(U.width-_.mw)/U.width,o()),_.mh&&U.height>_.mh&&(e=(U.height-_.mh)/U.height,o())),_.h&&(U.style.marginTop=Math.max(_.mh-U.height,0)/2+"px"),W[1]&&(_.get("loop")||W[z+1])&&(U.style.cursor="pointer",U.onclick=function(){J.next()}),U.style.width=U.width+"px",U.style.height=U.height+"px",h(U)},1)}),U.src=e):e&&M.load(e,_.get("data"),function(e,i){d===le&&h("error"===i?n(se,"Error").html(_.get("xhrError")):t(this).contents())})}var v,x,y,b,T,C,H,k,W,E,L,M,S,I,R,F,K,P,B,O,_,D,j,A,N,z,U,$,q,G,Q,J,V,X={html:!1,photo:!1,iframe:!1,inline:!1,transition:"elastic",speed:300,fadeOut:300,width:!1,initialWidth:"600",innerWidth:!1,maxWidth:!1,height:!1,initialHeight:"450",innerHeight:!1,maxHeight:!1,scalePhotos:!0,scrolling:!0,opacity:.9,preloading:!0,className:!1,overlayClose:!0,escKey:!0,arrowKey:!0,top:!1,bottom:!1,left:!1,right:!1,fixed:!1,data:void 0,closeButton:!0,fastIframe:!0,open:!1,reposition:!0,loop:!0,slideshow:!1,slideshowAuto:!0,slideshowSpeed:2500,slideshowStart:"start slideshow",slideshowStop:"stop slideshow",photoRegex:/\.(gif|png|jp(e|g|eg)|bmp|ico|webp|jxr|svg)((#|\?).*)?$/i,retinaImage:!1,retinaUrl:!1,retinaSuffix:"@2x.$1",current:"image {current} of {total}",previous:"previous",next:"next",close:"close",xhrError:"This content failed to load.",imgError:"This image failed to load.",returnFocus:!0,trapFocus:!0,onOpen:!1,onLoad:!1,onComplete:!1,onCleanup:!1,onClosed:!1,rel:function(){return this.rel},href:function(){return t(this).attr("href")},title:function(){return this.title}},Y="colorbox",Z="cbox",te=Z+"Element",ee=Z+"_open",ie=Z+"_load",ne=Z+"_complete",oe=Z+"_cleanup",re=Z+"_closed",he=Z+"_purge",ae=t("<a/>"),se="div",le=0,de={},ce=function(){function t(){clearTimeout(h)}function e(){(_.get("loop")||W[z+1])&&(t(),h=setTimeout(J.next,_.get("slideshowSpeed")))}function i(){F.html(_.get("slideshowStop")).unbind(s).one(s,n),ae.bind(ne,e).bind(ie,t),x.removeClass(a+"off").addClass(a+"on")}function n(){t(),ae.unbind(ne,e).unbind(ie,t),F.html(_.get("slideshowStart")).unbind(s).one(s,function(){J.next(),i()}),x.removeClass(a+"on").addClass(a+"off")}function o(){r=!1,F.hide(),t(),ae.unbind(ne,e).unbind(ie,t),x.removeClass(a+"off "+a+"on")}var r,h,a=Z+"Slideshow_",s="click."+Z;return function(){r?_.get("slideshow")||(ae.unbind(oe,o),o()):_.get("slideshow")&&W[1]&&(r=!0,ae.one(oe,o),_.get("slideshowAuto")?i():n(),F.show())}}();t.colorbox||(t(p),J=t.fn[Y]=t[Y]=function(e,i){var n,o=this;if(e=e||{},t.isFunction(o))o=t("<a/>"),e.open=!0;else if(!o[0])return o;return o[0]?(p(),m()&&(i&&(e.onComplete=i),o.each(function(){var i=t.data(this,Y)||{};t.data(this,Y,t.extend(i,e))}).addClass(te),n=new r(o[0],e),n.get("open")&&f(o[0])),o):o},J.position=function(e,i){function n(){T[0].style.width=k[0].style.width=b[0].style.width=parseInt(x[0].style.width,10)-j+"px",b[0].style.height=C[0].style.height=H[0].style.height=parseInt(x[0].style.height,10)-D+"px"}var r,h,s,l=0,d=0,c=x.offset();if(E.unbind("resize."+Z),x.css({top:-9e4,left:-9e4}),h=E.scrollTop(),s=E.scrollLeft(),_.get("fixed")?(c.top-=h,c.left-=s,x.css({position:"fixed"})):(l=h,d=s,x.css({position:"absolute"})),d+=_.get("right")!==!1?Math.max(E.width()-_.w-N-j-a(_.get("right"),"x"),0):_.get("left")!==!1?a(_.get("left"),"x"):Math.round(Math.max(E.width()-_.w-N-j,0)/2),l+=_.get("bottom")!==!1?Math.max(o()-_.h-A-D-a(_.get("bottom"),"y"),0):_.get("top")!==!1?a(_.get("top"),"y"):Math.round(Math.max(o()-_.h-A-D,0)/2),x.css({top:c.top,left:c.left,visibility:"visible"}),y[0].style.width=y[0].style.height="9999px",r={width:_.w+N+j,height:_.h+A+D,top:l,left:d},e){var g=0;t.each(r,function(t){return r[t]!==de[t]?(g=e,void 0):void 0}),e=g}de=r,e||x.css(r),x.dequeue().animate(r,{duration:e||0,complete:function(){n(),q=!1,y[0].style.width=_.w+N+j+"px",y[0].style.height=_.h+A+D+"px",_.get("reposition")&&setTimeout(function(){E.bind("resize."+Z,J.position)},1),i&&i()},step:n})},J.resize=function(t){var e;$&&(t=t||{},t.width&&(_.w=a(t.width,"x")-N-j),t.innerWidth&&(_.w=a(t.innerWidth,"x")),L.css({width:_.w}),t.height&&(_.h=a(t.height,"y")-A-D),t.innerHeight&&(_.h=a(t.innerHeight,"y")),t.innerHeight||t.height||(e=L.scrollTop(),L.css({height:"auto"}),_.h=L.height()),L.css({height:_.h}),e&&L.scrollTop(e),J.position("none"===_.get("transition")?0:_.get("speed")))},J.prep=function(i){function o(){return _.w=_.w||L.width(),_.w=_.mw&&_.mw<_.w?_.mw:_.w,_.w}function a(){return _.h=_.h||L.height(),_.h=_.mh&&_.mh<_.h?_.mh:_.h,_.h}if($){var d,g="none"===_.get("transition")?0:_.get("speed");L.remove(),L=n(se,"LoadedContent").append(i),L.hide().appendTo(M.show()).css({width:o(),overflow:_.get("scrolling")?"auto":"hidden"}).css({height:a()}).prependTo(b),M.hide(),t(U).css({"float":"none"}),c(_.get("className")),d=function(){function i(){t.support.opacity===!1&&x[0].style.removeAttribute("filter")}var n,o,a=W.length;$&&(o=function(){clearTimeout(Q),S.hide(),u(ne),_.get("onComplete")},I.html(_.get("title")).show(),L.show(),a>1?("string"==typeof _.get("current")&&R.html(_.get("current").replace("{current}",z+1).replace("{total}",a)).show(),K[_.get("loop")||a-1>z?"show":"hide"]().html(_.get("next")),P[_.get("loop")||z?"show":"hide"]().html(_.get("previous")),ce(),_.get("preloading")&&t.each([h(-1),h(1)],function(){var i,n=W[this],o=new r(n,t.data(n,Y)),h=o.get("href");h&&s(o,h)&&(h=l(o,h),i=e.createElement("img"),i.src=h)})):O.hide(),_.get("iframe")?(n=e.createElement("iframe"),"frameBorder"in n&&(n.frameBorder=0),"allowTransparency"in n&&(n.allowTransparency="true"),_.get("scrolling")||(n.scrolling="no"),t(n).attr({src:_.get("href"),name:(new Date).getTime(),"class":Z+"Iframe",allowFullScreen:!0}).one("load",o).appendTo(L),ae.one(he,function(){n.src="//about:blank"}),_.get("fastIframe")&&t(n).trigger("load")):o(),"fade"===_.get("transition")?x.fadeTo(g,1,i):i())},"fade"===_.get("transition")?x.fadeTo(g,0,function(){J.position(0,d)}):J.position(g,d)}},J.next=function(){!q&&W[1]&&(_.get("loop")||W[z+1])&&(z=h(1),f(W[z]))},J.prev=function(){!q&&W[1]&&(_.get("loop")||z)&&(z=h(-1),f(W[z]))},J.close=function(){$&&!G&&(G=!0,$=!1,u(oe),_.get("onCleanup"),E.unbind("."+Z),v.fadeTo(_.get("fadeOut")||0,0),x.stop().fadeTo(_.get("fadeOut")||0,0,function(){x.hide(),v.hide(),u(he),L.remove(),setTimeout(function(){G=!1,u(re),_.get("onClosed")},1)}))},J.remove=function(){x&&(x.stop(),t.colorbox.close(),x.stop().remove(),v.remove(),G=!1,x=null,t("."+te).removeData(Y).removeClass(te),t(e).unbind("click."+Z))},J.element=function(){return t(_.el)},J.settings=X)})(jQuery,document,window);
/*
 *
 * Utility functions
 *
 * @author rclarkson
 *
 */
Postmedia.Utils = (function ($) {

    var isProduction = IsProduction(),
        userAgent = GetUserAgent();

    function Init() {
        //Add Constructor Code
    }

    function Log(a) {

        if(userAgent !== "msie" && isProduction == false){
            console.log(a);
        }
    }

    /**
    * Capitalizes first letter of string.
    * Should Refactor into Utils.
    * @return {String} - 'String' from 'string'
    * @param {String} string
    * @method capitaliseFirstLetter
    */
    function CapitaliseFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function GetScreenSize(){

        var screenSize = "small";

        if( $( window ).width() > 1200 ){

		    screenSize = "large";

	    }else if( $( window ).width() > 768 ){

		    screenSize = "medium";

	    }

        return screenSize;
    }

    function GetImageSize(){

        var imageSize = "320";

        switch(GetScreenSize()){

            case "large":
                imageSize = "1200"
                break;
            case "medium":
                imageSize = "768"
                break;
        }

        if(Postmedia.Properties.isModal){
            imageSize = "modal";
        }

        return imageSize;
    }

    function PreventKeyScroll() {

        document.onkeydown = function (evt) {

            evt = evt || window.event;
            var keyCode = evt.keyCode;

            if (keyCode >= 37 && keyCode <= 40) {
                return false;
            }

        };
    }

    function GetQueryString(name) {

        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        
        var regexS = "[\\?&]" + name + "=([^&#]*)",
        	regex = new RegExp(regexS),
        	results = regex.exec(window.location.href);
        
        if (results == null)
            return "";
        else
            return decodeURIComponent(results[1].replace(/\+/g, " "));
    }

	function GetHashTagString(name) {

        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        
        var regexS = "[\\#&]" + name + "=([^&#]*)",
        	regex = new RegExp(regexS),
        	results = regex.exec(window.location.href);
        
        if (results == null)
            return "";
        else
            return decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    function GetUserAgent() {

        var retAgent,
	        userAgents = [];

        userAgents = userAgents.concat(Postmedia.Properties.userAgents, Postmedia.Properties.mobileAgents);

        for (var i = 0; i < userAgents.length; i++) {

            if (navigator.userAgent.toLowerCase().indexOf(userAgents[i]) > -1) {
                retAgent = userAgents[i];
            }

        }

        return retAgent;
    }

    function IsMobile() {

        var retVal = false;

        for (var i = 0; i < Postmedia.Properties.mobileAgents.length; i++) {

            if (navigator.userAgent.toLowerCase().indexOf(Postmedia.Properties.mobileAgents[i]) > -1) {
                retVal = true;
                break;
            }
        }

        return retVal;
    }

    function GetDeviceWidth() {
        var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        return width;
    }

    function IsProduction() {

        if (window.location.href.search("o.canada.com") != -1) {
            return true;
        } else {
            return false;
        }
    }

	function GetRelativeTimeMessage(time, isApiFeed) {

        var dateTime, temp;

        // This is a bit of a hack because we have two different feeds with two different UTC dateTime formats
        // API.twitter - Wed Jul 04 18:50:00 +0000 2012
        // Search.twitter - Wed, 04 Jul 2012 18:51:59 +0000
        // Needs to be done properly
        if((isApiFeed || !userAgent === "msie")){

	        dateTime = Date.parse(time);
	        temp = new Date(time);

        } else {

	        dateTime = parseDate(time);
	        temp = parseDate(time);

        }

        dateTime = Date.UTC(temp.getUTCFullYear(), temp.getUTCMonth(), temp.getUTCDate(), temp.getUTCHours(), temp.getUTCMinutes(), temp.getUTCSeconds()) / 60000;

        var local = new Date(),
	        local = Date.UTC(local.getUTCFullYear(), local.getUTCMonth(), local.getUTCDate(), local.getUTCHours(), local.getUTCMinutes(), local.getUTCSeconds()) / 60000,
	        minutes = Math.floor(local - dateTime);

        // Format the response message
        if (minutes < 1) {
            return 'less than a minute ago';
        }
        else if (minutes < 2) {
            return '1 minute ago';
        }
        else if (minutes < 59) {
            return (minutes + ' minutes ago');
        }

        var hours = Math.floor(minutes / 60);
        if (hours < 2) {
            return '1 hour ago';
        }
        else if (hours < 24) {
            return (hours + ' hours ago');
        }

        var days = Math.floor(hours / 24);
        if (days < 2) {
            return '1 day ago';
        }
        return (days + ' days ago');
    }

    function parseDate(str) {
        var v = str.split(' ');
        return new Date(Date.parse(v[1]+" "+v[2]+", "+v[5]+" "+v[3]+" UTC"));
    }

    function CleanForJS(s){

        s = s.replace(/'/g, "\\\'");
        s = s.replace(/\"/g, "\\\'");

        return s;
    }

    function PopupCenter(pageUrl, title,w,h) {

        var left = (screen.width/2)-(w/2),
        	top = (screen.height/2)-(h/2),
        	targetWin = window.open( pageUrl, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left );

        Log(pageUrl);

    }

    return {
        Init: Init,
        Log: Log,
        CapitaliseFirstLetter: CapitaliseFirstLetter,
        CleanForJS : CleanForJS,
        GetQueryString: GetQueryString,
		GetHashTagString:GetHashTagString,
        GetDeviceWidth: GetDeviceWidth,
        PreventKeyScroll: PreventKeyScroll,
        IsMobile: IsMobile,
        GetScreenSize : GetScreenSize,
        GetImageSize : GetImageSize,
		GetRelativeTimeMessage : GetRelativeTimeMessage,
        isProduction: isProduction,
        PopupCenter: PopupCenter,
        userAgent : userAgent
    }

} (jQuery));
/*
 *
 * Handles Ajax Requests
 *
 * @author rclarkson
 * @todo code the damn thing!
 *
 */
Postmedia.Data = (function ($) {

    function Init() {
        //Add Constructor Code
    }

    /*
    *
    * Makes AJAX call using jQuery getScript.
    * @param {String} - API being called
    * @param {Object} - callback function called on ajaxSuccess
    * @method GetScript
    *
    */
    function GetScript(service, callback) {

        $.getScript(service, function () {
            callback();
        });
    }

    function Ajax(service, callbackFunction, dataType, callType, jsonData, context) {

        //Should make some defaults here
        //Log(decodeURI(service));

        $.ajax({
            url: service,
            data: jsonData,
            type: callType,
            dataType: dataType,
            async: true,
            contentType: 'application/json; charset=utf-8',
            success: function (data, textStatus, XMLHttpRequest) {

                if (data !== null) {
                    callbackFunction(data, context);
                } else {
                    data = {};
                    callbackFunction(data, context);
                }

                Log("Postmedia.Data.AjaxCall : success():  " + decodeURI(service));
            },

            error: function (data, textStatus, errorThrown) {

                data.PMerror = true;
                data.PMlength = 0;
                data.PMmsg = data.Message;

                callbackFunction(data, context);
                Log("Postmedia.Data.AjaxCall : error():<br><br>Details:<br>" + "XHR: " + decodeURI(service) + " XHRStatus: " + textStatus + "XHRError: " + errorThrown);
            },
            statusCode: {
                400: function() {
                    data.PMerror = true;
                    data.error = "400";
                    callbackFunction(data, context);
                }
            },
            complete: function (XMLHttpRequest, textStatus) {
                Log("Postmedia.Data.AjaxCall : complete():  " + decodeURI(service));
            }

        });

    }

    function GetCachedScript(url, options) {

        options = $.extend(options || {}, {
            dataType: "script",
            cache: true,
            url: url
        });

        return $.ajax(options);

    }

    function AppendScript(src, node) {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = src;
        $(node).append(script);
    }

    function WriteScript(src, isInline) {

        //REFACTOR
        if (isInline) {
            document.write('<scr' + 'ipt type="text/javascript">' + src + '<\/sc' + 'ript>');
        } else {
            document.write('<scr' + 'ipt type="text/javascript" src="' + src + '"></scr' + 'ipt>');
        }
    }

    /*
    *
    * Checks the returned JSON object for errors. Removes the ajax throbber gif.
    * @param {Object} response - returned JSON object
    * @return {Boolean}
    * @method dataOk
    *
    */
    function DataOk(response) {
        //$m.utils.hideAjaxLoader();
        //return response.ResponseBatch.Messages[0].Message == "ok" ? true : false;
    }

    function Log(a) {

        //Postmedia.Utils.Log(a);

    }

    return {
        Init: Init,
        AppendScript: AppendScript,
        GetScript: GetScript,
        GetCachedScript: GetCachedScript,
        WriteScript: WriteScript,
        Ajax : Ajax
    }

} (jQuery));
/**
 *
 * Drives all Ads
 *
 * @author Postmedia Digital mghali@postmedia.com
 * @version 0.1
 *
 *@example
 * DART : http: //ad.ca.doubleclick.net/N3081/adj/calgaryherald.com/index;loc=theTop;loc=top;sz=468x60,728x90;dcopt=ist;kw=ron;nk=print;pr=ch;ck=index;imp=index;kw=ch;tile="+dartad_tile+";"+adcookieTag+surroundTag+"ord=34747567?"; // script ad code with adcookie, used for debug
 *
 *@example
 * DFP :
 * googletag.cmd.push(function() {
 * 		googletag.defineSlot("/3081/ch.m/index", [[300,50],[320,50]], "div-gpt-ad-1").addService(googletag.pubads()).
 * 		.setTargeting("loc", "top")
 * 		.setTargeting("tile", "1")
 * 		.setTargeting("nk","print")
 * 		.setTargeting("pr","ch");
 * 		googletag.enableServices();
 * 	});
 *
 *@example
 *<div id="div-dart-ad-1" class="ad" data-mobile="false"><script type="text/javascript">Postmedia.AdServer.Write({id:"div-dart-ad-1",size:"banner", keys:{ "loc": "top"}, mobile: false })</script></div>
 *
 */

Postmedia.AdServer = (function ($) {

	/**
	 * @type object ad object holds all global ad vriables loccally
	 */
	var ad = {
		provider: '',
		widthLimit: 728,
		ord: '',
		size: {
			banner: {
				desktop: "728x90,960x86",
				mobile: [[300, 50], [320, 50]]
			},
			bbox: {
				desktop: "300x250,300x251",
				mobile: [300, 250]
			},
			boxbanner: {
				desktop: "300x250,300x251",
				mobile: [[300, 50], [320, 50]]
			}
		},
		deviceWidth: $( window ).width()
	};

	ad.networkCode = (Postmedia.adConfig.networkCode) ? Postmedia.adConfig.networkCode : "3081";
	ad.adSite = (Postmedia.adConfig.site) ? Postmedia.adConfig.site : "ccn.com";
	ad.mSite = (Postmedia.adConfig.msite) ? Postmedia.adConfig.msite : "ccn.m";
	ad.zone = (Postmedia.adConfig.zone) ? Postmedia.adConfig.zone : "index";
	ad.keys = Postmedia.adConfig.keys;
	ad.provider = (ad.deviceWidth > ad.widthLimit) ? "DART" : "DFP";

	/**
	 * Load google tags and set DFP+ to Async if not loaded
	 */
	if( typeof(window.googletag) == "undefined" ){

		Log("Did not find googletags: Loading googletags in Async mode");

		window.googletag = {};
		window.googletag.cmd = [];

		var useSSL = "https:" == document.location.protocol;
		var src = (useSSL ? "https:" : "http:") + "//www.googletagservices.com/tag/js/gpt_mobile.js";
		$.getScript(src);

		googletag.cmd.push(function() {
			googletag.pubads().enableAsyncRendering();
		});

	}

	/**
	 * Set initial order number
	 */
	SetOrd();

    function Init() {
        /**
		 * This class is self initiating not sure if there is a need to use an initializer.
		 * moved init functionality above, shoul look into this later if needed.
		 */
    }

	/**
	 * Generate ordinal for adcode
	 *
	 * @returns {number} ord Number for DART
	 */
	function GenOrd() {
        return Math.floor((Math.random() * 100000000) + 1);
    }
	/**
	 * Sets ad.ord with nre ordinal
	 */
    function SetOrd() {
        ad.ord = GenOrd();
    }

    DFP = {

		index:0,
		slots:[],
		GetSize:function(s){

			/**
			 * if the size passed is an array then it is a custom size,
			 * return size
			 */
			if($.isArray(s)){

			  return s;

			/**
			 * Else if it is a string then it is one of the preset sizes in the library:
			 * banner , bbox , boxbanner
			 */
			}else if ((typeof s === 'string') && (ad.size[s])){

				s = s.toLowerCase();
				return ad.size[s].mobile;

			/**
			 * Let's just return any size for now.
			 */
			}else{

				/**
				 * alert developer that size is not correct format
				 */
				Log("DFP size : " + s + " is not the right format");
				return [[300, 50], [320, 50]];

			}

		}
    };

	DART = {
		index:0,
		slots:[],
		GetSize:function(s){

			/**
			 * if the size passed is an array then it is a custom size,
			 * so transform the size to be DART freindly. i.e: 250x250,300x250
			 */
			if($.isArray(s)){

				var sizeArr = [];
				$.each(s, function(index, value) {
					sizeArr.push(value[0]+"x"+value[1])
				});

			  return sizeArr.toString();

			/**
			 * Else if it is a string then it is one of the preset sizes in the library:
			 * banner , bbox , boxbanner
			 */
			}else if ((typeof s === 'string') && (ad.size[s])){

				s = s.toLowerCase();
				return ad.size[s].desktop;

			/**
			 * Let's just return any size for now.
			 */
			}else{

				/**
				 * alert developer that size is not correct format
				 */
				Log("size : " + s + " is not the right format");
				return "300x250";

			}

		}
	};

	function DfpWrite (obj){

			var slotIndex = DFP.index;
			googletag.cmd.push(function() {

				/**
				 * @todo: move DFP.slots[slotIndex] into a local gt function then push into array.
				 */
				DFP.slots[slotIndex] = googletag.defineSlot("/3081/"+ad.mSite+"/"+ad.zone, DFP.GetSize(obj.size), obj.id ).addService(googletag.pubads());
				DFP.slots[slotIndex].setTargeting("tile",slotIndex+1);
				/**
				 * Add page level targeting from the ad object if not available in page level
				 * @todo: test if we can move this to a service level rather than adding it to the adslot
				 */
				for (var prop in ad.keys) {

					/**
					 * if local keys are not available or that parameter is not overwritten locally
					 */
					if ( ad.keys.hasOwnProperty(prop) && (!obj.keys || !obj.keys.hasOwnProperty(prop)) ) {
						DFP.slots[slotIndex].setTargeting( prop , ad.keys[prop] );
					}

				}
				/**
				 * Add ad unit-level targeting
				 */
				if(obj.keys){

					for (var prop in obj.keys){
						if(obj.keys.hasOwnProperty(prop)){
								DFP.slots[slotIndex].setTargeting( prop , obj.keys[prop] );
						}

					}

					/**
					* Add Fall back for loc in the case it is not available in ad unit-level targeting
					* @todo: this fallback is useless with out tracking the ad size and tracking against it --- maybe we should just ignore and depend on unit level keys. just a thought!
					*/
				   if(!obj.keys.hasOwnProperty("loc")){

					   switch (slotIndex + 1) {
						   case 2:
							   DFP.slots[slotIndex].setTargeting("loc", "mid");
							   break;
						   case 3:
							   DFP.slots[slotIndex].setTargeting("loc", "bot");
							   break;
						   default:
							   DFP.slots[slotIndex].setTargeting("loc", "top");
							   break;
					   }

				   }

				}


				/**
				 * @todo: bench mark with sync loading enabled: googletag.pubads().enableSyncRendering()
				 */
				googletag.enableServices();
				googletag.display( obj.id );
			});
			/**
			 * increment ad slot
			 */
			DFP.index++;

	}

	function DartWrite (obj){

		    var adBlock = 'http://ad.ca.doubleclick.net/N3081/adj/' + ad.adSite + '/' + ad.zone ;
			adBlock += ';sz=' + DART.GetSize(obj.size);

			/**
			 * Add page level targeting from the ad object if not available in page level
			 */
			for (var prop in ad.keys) {

				if ( ad.keys.hasOwnProperty(prop) && (!obj.keys || !obj.keys.hasOwnProperty(prop)) &&  $.isArray(ad.keys[prop]) ) {

					Log("Write - Dart - key value is Array : "+prop+" = "+ad.keys[prop]);
					/**
					* if the key is an Array then we need to transform it to multiple keyvalues
					*/
					$.each(ad.keys[prop], function(index, value) {
						adBlock += ( ";" + prop + "=" +value);
					});

				}else if ( ad.keys.hasOwnProperty(prop) && (!obj.keys || !obj.keys.hasOwnProperty(prop)) ) {

					adBlock += ( ";" + prop + "=" +ad.keys[prop] );

				}

			}

			if(obj.keys){

				/**
				 * Add ad unit-level targeting
				 */
				for (var prop in obj.keys){

					if( obj.keys.hasOwnProperty(prop)  &&  $.isArray(obj.keys[prop]) ){

						Log("Write - Dart - key value is Array : "+prop+" = "+obj.keys[prop]);
						/**
						* if the key is an Array then we need to transform it to multiple keyvalues
						*/
						$.each(obj.keys[prop], function(index, value) {
							adBlock += ( ";" + prop + "=" +value);
						});

					}else if( obj.keys.hasOwnProperty(prop) ) {

						adBlock += ( ";" + prop + "=" +obj.keys[prop] );

					}

				}

				/**
				 * if this is the first 728x90 on the page and dcopt is not set on the page the add it in there
				 * @todo: this would set top level ads across the board maybe we should not have a fallback for this.
				 */
				if( DART.index == 0 && !obj.keys.hasOwnProperty("dcopt") && adBlock.indexOf("728x90") != -1){
					adBlock += ";dcopt=ist";
				}

				/**
				 * Add Fallback for loc in the case it is not available in ad unit-level targeting
				 * @todo: this fallback is useless with out tracking the ad size and tracking against it --- maybe we should just ignore and kill from code. just a thought!
				 */
				if(!obj.keys.hasOwnProperty("loc")){

					switch (DART.index + 1) {
						case 2:
							adBlock += ';loc=mid';
							break;
						case 3:
							adBlock += ';loc=bot';
							break;
						default:
							adBlock += ';loc=top';
							break;
					}

				}

			}

            adBlock += ';tile=' + (DART.index + 1) + ';ord=' + ad.ord;
			DART.index = DART.slots.push({ src : adBlock , id : obj.id });
			Postmedia.Data.WriteScript(adBlock, false);

			Log(adBlock);

	}

  function Write(obj) {
		var deviceWidth = $( window ).width();
		ad.provider = (deviceWidth > ad.widthLimit) ? "DART" : "DFP";

		if( ( typeof obj.mobile === "boolean" ) && obj.mobile ){

			/**
			* Write DFP+ adcode.
			* if there is an adunit level breakpoint and this is a mobile only adspot
			* else if the global provider is DFP
			*/
			if( obj.hasOwnProperty("breakpoint") && parseInt(obj.breakpoint) >= deviceWidth ){
				DfpWrite(obj);
			}else if( ad.provider === "DFP" ){
				DfpWrite(obj);
			}

		}else if ( ( typeof obj.mobile === "boolean" ) && !obj.mobile ) {

			/**
			* Write DART adcode
			* if there is an adunit level breakpoint and this is a desktop only adunit
			* else if the global provider is DART
			*/
			if( obj.hasOwnProperty("breakpoint") ) {
				if ( parseInt(obj.breakpoint) <= deviceWidth ) {
					DartWrite(obj);
				}
				/**
				 * If deviceWidth is less than the breakpoint, do not make the ad call
				 */
			}else if( ad.provider === "DART" ){
				DartWrite(obj);
			}

		}else{

			/**
			 * if adunit is mobile and desktop then check for local break and
			 * fallback on to the global adprovider and render appropriate adunit.
			 */
			if( obj.hasOwnProperty("breakpoint") ){

				if (parseInt(obj.breakpoint) <= deviceWidth){
					DartWrite(obj);
				}else {
					DfpWrite(obj);
				}

			}else if( ad.provider === "DART" ){
				DartWrite(obj);
			}else{
				DfpWrite(obj);
			}

		}

  }

	/**
	 * Get Video Ad URL
	 *
	 * @param   {null} function Description
	 *
	 * @returns {String} video ad url with page level targeting.
	 */
	function GetVideoAd() {

		var adUrl = 'http://ad.ca.doubleclick.net/N3081/pfadx/' + ad.adSite + '/' + ad.zone + ';sz=320x240,480x360' ;

		/**
		* Add page level targeting.
		*/
		for (var prop in ad.keys) {

			if ( ad.keys.hasOwnProperty(prop) &&  $.isArray(ad.keys[prop]) ) {
				/**
				* if the key is an Array then we need to transform it to multiple keyvalues
				*/
				$.each(ad.keys[prop], function(index, value) {
					adUrl += ( ";" + prop + "=" +value);
				});

			}else if ( ad.keys.hasOwnProperty(prop) ) {

				adUrl += ( ";" + prop + "=" +ad.keys[prop] );

			}

		}
        adUrl += ";tile=1;pos=pre1;ord=" + GenOrd();

		return adUrl;

    }


	/**
	 * Log
	 */
    function Log(a) {
		if ( document.location.search.indexOf("dart_debug=1") != -1 ||
			 document.location.search.indexOf("google_console=1") != -1 ) {
			console.log(a);
		}
    }

	/**
	 * DEBUG console for DART adcode for adops
	 */
	//var debug = (document.location.search.indexOf("dart_debug=1") != -1);
	if(document.location.search.indexOf("dart_debug=1") != -1){
		$(function() {

			$(document).keydown(function(e) {

				//Log('Handler for .keydown() called. keyCode: ' + e.keyCode);
				if( e.keyCode === 68 ){

					//Log(DART.slots);
					$.each( DART.slots, function(index, element) {
						var w = ad.deviceWidth;
						var h = $("#"+element.id).height();
						var offset = $("#"+element.id).offset();
						var html = '<div style="position:absolute; top:'+offset.top+'px; left:'+offset.left+'px; width:'+w+'px; height:'+h+'px;z-index:9999998; background-color:white; padding:20px;" >';
						html += (' ' + element.src + ' </div>');
						$("body").append(html)
					});

				}
			});

		});
	}


    return {
        Init: Init,
        GenOrd: GenOrd,
        GetVideoAd: GetVideoAd,
        Write: Write
    }

}(jQuery));

( function($) {
	// Responsive videos
	var all_videos = $( '.post-content' ).find( 'iframe[src^="http://player.vimeo.com"], iframe[src^="http://www.youtube.com"], iframe[src^="http://www.dailymotion.com"], object, embed' ),
		stickyHeaderTop,
     	top_offset = ( $( 'body' ).hasClass( 'admin-bar' ) ) ? 213 : 185,
    	input = document.createElement( 'input' ),
    	is_sticky = false,
    	in_use = false,
    	timer,
    	i,
    	boxWidth = 300,
		boxHeight = 250,
		adSlots = [];
		
		
    	/*Seb: CDC footer function vars */
    	breaking_point_tablet = 768;
    	
    $('#top-nav-search').toggle(200);	
    $('a.memory_pic').colorbox({scalePhotos:true, maxWidth:"90%", maxheight:"150%", title:function(){
  var txt = jQuery(this).children("span").html();//var txt = $(this).attr('alt');
  var title = $(this).attr('title');
  return '<p>'+txt+'</p>';}, onComplete:function(){ 
  	            jQuery("#colorbox").append( "<ul id=\"cboxSocials\"><li><div class=\"fb-like\" data-href=\"" + jQuery(this).attr('data-href') + "\" data-layout=\"button\" data-action=\"like\" data-show-faces=\"false\" data-share=\"false\"></div></li>  <li><iframe allowtransparency=\"true\" frameborder=\"0\" scrolling=\"no\" src=\"http://platform.twitter.com/widgets/tweet_button.html?url="+jQuery(this).attr('data-href')+"&count=none&via=canadadotcom&text=Explore this and other submissions on Postmedia's Great War Memory Project\" style=\"width:55px; height:21px;\"></iframe></li>    <li><div class=\"g-plusone\" data-annotation=\"none\" data-size=\"medium\" data-href=\"" + jQuery(this).attr('data-href') + "\"></div></li>     <li class=\"last\"><a href=\"//www.pinterest.com/pin/create/button/?url=" + escape(jQuery(this).attr('data-href')) + "&media=" + escape(jQuery(this).attr('href')) + "&description=Explore%20this%20and%20other%20submissions%20on%20Postmedia%27s%20Great%20War%20Memory%20Project\" data-pin-do=\"buttonPin\" data-pin-config=\"beside\" target=\"\_BLANK\"><img src=\"//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png\" /></a></li> " );
	            
	             FB.XFBML.parse();
	             var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				 po.src = 'https://apis.google.com/js/platform.js';
	             var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	           
            },
            
            onClosed:function(){
	            
	            jQuery("#cboxSocials").remove();
	            
            }
            
            
  
  });
  
  
  
  
    $('a.memory_text').colorbox({html:function(){
  var txt = jQuery(this).children("span").html();//var txt = $(this).attr('rel');
  return '<p>'+txt+'</p>';}, width:"60%", onComplete:function(){ 
	            jQuery("#colorbox").append( "<ul id=\"cboxSocials\"><li><div class=\"fb-like\" data-href=\"" + jQuery(this).attr('data-href') + "\" data-layout=\"button\" data-action=\"like\" data-show-faces=\"false\" data-share=\"false\"></div></li>  <li><iframe allowtransparency=\"true\" frameborder=\"0\" scrolling=\"no\" src=\"http://platform.twitter.com/widgets/tweet_button.html?url="+jQuery(this).attr('data-href')+"&count=none&via=canadadotcom&text=Explore this and other submissions on Postmedia's Great War Memory Project\" style=\"width:55px; height:21px;\"></iframe></li>    <li><div class=\"g-plusone\" data-annotation=\"none\" data-size=\"medium\" data-href=\"" + jQuery(this).attr('data-href') + "\"></div></li>     <li class=\"last\"><a href=\"//www.pinterest.com/pin/create/button/?url=" + escape(jQuery(this).attr('data-href')) + "&media=http%3A%2F%2Fww1.canada.com%2Fwp-content%2Fuploads%2F2014%2F06%2FPlaceholder-memoryproject-textbaseditems-930x600.jpg&description=Explore%20this%20and%20other%20submissions%20on%20Postmedia%27s%20Great%20War%20Memory%20Project\" data-pin-do=\"buttonPin\" data-pin-config=\"beside\" target=\"\_BLANK\"><img src=\"//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png\" /></a></li>" );
	            
	             FB.XFBML.parse();
	             var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				 po.src = 'https://apis.google.com/js/platform.js';
	             var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	           
            },
            
            onClosed:function(){
	            
	            jQuery("#cboxSocials").remove();
	            
            }
            
  
  
  
  });
    //$('a.memory').hover(function(event) { alert( "Handler for .click() called." );event.preventDefault();  });
    
     $(document).bind('cbox_complete', function(){
		$('#cboxTitle').hide();
		$('#cboxLoadedContent').bind('mouseover', function(){
		$('#cboxTitle').slideDown();
	});
	$('#cboxOverlay').bind('mouseover', function(){
   		$('#cboxTitle').slideUp();
   	});
  });

  //Hide Share button in iOs 6
  	if(navigator.userAgent.toLowerCase().indexOf("os 6") >  - 1 ){
  		$("li.share").remove();
	}
    
    function GetUserAgent() {			
			var userAgents = ['mozilla','msie','webkit','iphone','ipad','ipod','android','blackberry'];
			var retAgent = '';
			for(var i = 0;i<userAgents.length;i++) {
				if(navigator.userAgent.toLowerCase().indexOf(userAgents[i]) >  - 1){
					retAgent = userAgents[i];
				}
			}			
			return retAgent;
		}
    
    jQuery('.events-footer')
    			.toggleClass( 'opened' )
				.find( 'ul.sub-menu' ).slideToggle();
		
		jQuery('.events-footer > a').click(function( event ) {
		  event.preventDefault();
		});
				
		var userAgent = GetUserAgent();
		
		if( userAgent == 'iphone' || userAgent == 'ipod' || userAgent == 'android' || userAgent == 'blackberry'){
			
			//jQuery('#mainSlider').removeClass('flexslider');
			
			jQuery('#mainSlider').flexslider({
				animation: "fade",
				pauseOnAction: true, 
				after: function(slider) { if (!slider.playing) { slider.play(); } }
			});
			
			jQuery('.flexCarrousel').flexslider({
				animation: "slide",
				animationLoop: true,
				itemWidth: 171,
				minItems: 2,
				maxItems: 2
			});
			
		} else {
		
			jQuery('#mainSlider').flexslider({
				animation: "fade",
				pauseOnAction: true, 
				after: function(slider) { if (!slider.playing) { slider.play(); } }
			});
			
			jQuery('.flexCarrousel').flexslider({
				animation: "slide",
				animationLoop: true,
				itemWidth: 171,
				minItems: 4,
				maxItems: 4,
				controlNav: false
			});
		}
		
		jQuery('#videoSlider').flexslider({
			animation: "fade",
			pauseOnAction: true, 
			after: function(slider) { if (!slider.playing) { slider.play(); } }
		});
		
		jQuery('#photoSlider').flexslider({
			animation: "fade",
			pauseOnAction: true, 
			after: function(slider) { if (!slider.playing) { slider.play(); } }
		});
		
		
		jQuery('.flexSidebarCarrousel').flexslider({
				animation: "slide",
				animationLoop: true,
				itemWidth: 171,
				minItems: 2,
				maxItems: 2
			});
			
			

    function stickyHeader() {
		return ( $( 'body' ).hasClass( 'admin-bar' ) ) ? $( '#page' ).offset().top + 150 : $( '#page' ).offset().top +220;
    } 
    
    /* Seb - hover subnav reveal */ 
    $('li.events > a').click(function (event){ event.preventDefault();});
    
	$('li.events').hover(function(){ $("li.events > .sub-menu").slideDown('fast'); $('li.events > a').addClass('menu_hover'); },
	function(){ $("li.events > .sub-menu").stop().slideUp('fast'); $('li.events > a').removeClass('menu_hover'); });
	
	
	$('#top-search-btn ').click( 
		function() { 
			if( $(this).hasClass('active') ) {  
		
				$('#top-nav-search').stop().slideUp('fast');
			 	$('#top-search-btn').removeClass('active');
			 	 
			 	$('#top-search-icon').removeClass('icon-angle-up'); 
			 	$('#top-search-icon').addClass('icon-search'); 
			 		 
			
			 } else {
		
				$(this).addClass('active'); 
				$('#top-nav-search').stop().slideDown('fast'); 		
				
				$('#top-search-icon').removeClass('icon-search'); 
			 	$('#top-search-icon').addClass('icon-angle-up');
		 
			}
		}        
	);
		

	all_videos.each(function() {
		var el = $(this);
		el
			.attr( 'data-aspectRatio', el.height() / el.width() )
			.attr( 'data-oldWidth', el.attr( 'width' ) );
	} );

	$(window)
		.resize( function() {
			all_videos.each( function() {
				var el = $(this),
					newWidth = el.parents( '.post-content' ).width(),
					oldWidth = el.attr( 'data-oldWidth' );

				if ( oldWidth > newWidth ) {
					el
						.removeAttr( 'height' )
						.removeAttr( 'width' )
					    .width( newWidth )
				    	.height( newWidth * el.attr( 'data-aspectRatio' ) );
				}
			} );

			if ( $(window).width() <= 768 ) {
				$( '#footer-menus' )
					.find( 'nav ul' ).hide()
					.end()
					.find( 'h3' ).addClass( 'mobile' );
				stickyHeaderTop = stickyHeader();
				top_offset = ( $( 'body' ).hasClass( 'admin-bar' ) ) ? 100 : 72;
			} else {
				$( '#footer-menus' )
					.find( 'nav ul' ).show()
					.end()
					.find( 'h3' ).removeClass( 'mobile' );
				$( '#mobile-header-menu' ).hide();
				$( 'body' ).removeClass( 'opened' );
				stickyHeaderTop = stickyHeader();
			}
			if ( $(window).width() <= 600 ) {
				stickyHeaderTop = stickyHeader();
			}
			
			/*Seb: added CDC footer menu nav funtion */
			if ( breaking_point_tablet > $(window).width() ) {
				$( '.footer-widget-title' ).addClass( 'mobile' );
			} else {
				$( '.footer-widget-title' ).removeClass( 'mobile' );
				$( '.footer-widget ul' ).show();
			}

		} )
		.scroll(function(){
			if ( $(window).scrollTop() > stickyHeaderTop ){
				$( 'body' ).addClass( 'sticky-header' );
				is_sticky = true;
			}else{
				$( 'body' ).removeClass( 'sticky-header' );
				is_sticky = false;
			}
		} )
		.resize()

	// Placeholder fix for older browsers
    if ( ( 'placeholder' in input ) == false ) {
		$( '[placeholder]' ).focus( function() {
			i = $( this );
			if ( i.val() == i.attr( 'placeholder' ) ) {
				i.val( '' ).removeClass( 'placeholder' );
				if ( i.hasClass( 'password' ) ) {
					i.removeClass( 'password' );
					this.type = 'password';
				}
			}
		} ).blur( function() {
			i = $( this );
			if ( i.val() == '' || i.val() == i.attr( 'placeholder' ) ) {
				if ( this.type == 'password' ) {
					i.addClass( 'password' );
					this.type = 'text';
				}
				i.addClass( 'placeholder' ).val( i.attr( 'placeholder' ) );
			}
		} ).blur().parents( 'form' ).submit( function() {
			$( this ).find( '[placeholder]' ).each( function() {
				i = $( this );
				if ( i.val() == i.attr( 'placeholder' ) )
					i.val( '' );
			} )
		} );
	}

	// Comments button
	$( '#primary' ).find( '.comments-button' ).click( function(e) {
		e.preventDefault();
		$( 'html, body' ).animate( { scrollTop: $( '#facebook-comments' ).offset().top - top_offset } );
	} );

	// Mobile menu
	$( '#mobile' ).find( '.mobile-nav .button.mobile-events, .mobile-nav .button.mobile-menu, .mobile-nav .button.mobile-search' ).click( function(e) {
		e.preventDefault();
		var h = $( '#mobile-footer-menu' ).height() + 100
			hMenu = 672
			hMobile = $( '#mobile' ).height();
				
		//Seb: refined mobile nav scroll offsets for specific nav buttons
		//$( 'html, body' ).animate( { scrollTop: $( '#footer-menus' ).offset().top - h } );
		
		if ( $( this ).is( ".button.mobile-search" ) ) {
			
			if ( GetUserAgent() == "ipad"){
				$( 'html, body' ).animate( { scrollTop: $( '#footer-menus' ).offset().top - 735 }, function () {$( "#mobile-footer-menu input[name='s']" ).focus();} );
				return
			} else if ( GetUserAgent() == "iphone" && is_sticky == true ){
				$( 'html, body' ).animate( { scrollTop: $( '#footer-menus' ).offset().top - 640 }, function () {$( "#mobile-footer-menu input[name='s']" ).focus();} );
				return
			}else {
				$( 'html, body' ).animate( { scrollTop: $( '#footer-menus' ).offset().top - h }, function () {$( "#mobile-footer-menu input[name='s']" ).focus();} );
				return
			}
		}
		
		if ( $( this ).is( ".button.mobile-events" ) ) {
			$( 'html, body' ).animate( { scrollTop: $( '#mobile-footer-menu li.events-footer' ).offset().top - hMobile } );
			return
		}
		
		if ( $( this ).is( ".button.mobile-menu" ) ) {		
			//$( 'html, body' ).animate( { scrollTop: $( '#mobile-footer-menu li.news-footer' ).offset().top  } );
			$( 'html, body' ).animate( { scrollTop: $( '#mobile-footer-menu li.footer-nav-first' ).offset().top - hMobile } );
			return
		}
		
		$( 'html, body' ).animate( { scrollTop: $( '#footer-menus' ).offset().top - h } );
		
		
	} );
		

	// Share button
	$( '#social-bar' ).find( '.share-button' ).click( function(e) {
		e.preventDefault();
		$(this).toggleClass( 'selected' );
		$( '#social-share' ).toggle();
	} );

	// Mobile footer
	$( '#footer-menus' ).on( 'click', 'h3.mobile', function() {
		$(this).parent().find( 'ul' ).stop().slideToggle();
		$(this).toggleClass('open');
	} );

	// External link script
	$( 'a[href^="http://"], a[href^="https://"]' ).not( 'a[href^="http://www.windsorstar.com"]' )
		.filter( function() {
			if ( 0 == $(this).parents( '.target-self' ).length )
				return $(this);
		} )
		.each( function() {
			var a = new RegExp( '/' + window.location.host + '/' );
			if ( ! a.test( this.href ) )
				$(this).attr( 'target', '_blank' );
		} );
	
} )(jQuery);