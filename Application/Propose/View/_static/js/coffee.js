/**
*  闊崇婕傛诞鎻掍欢
*  -----------------------------
*  浣滆€咃細鍙兼€庝箞鍐欙紒- -||
*  鏃堕棿锛�2014-03-21
*  鍑嗗垯锛歾epto
*  鑱旂郴锛歸echat--shoe11414255
*  涓€寮犵綉椤碉紝瑕佺粡鍘嗘€庢牱鐨勮繃绋嬶紝鎵嶈兘鎶佃揪鐢ㄦ埛闈㈠墠
*  涓€涓壒鏁堬紝瑕佺粡鍘嗚繖鏍风殑淇敼锛屾墠鑳借鐢ㄦ埛鐐逛釜璧�
*  涓€涓骇鍝侊紝鍒涙剰婧愪簬鐢熸椿锛屾簮浜庡唴蹇冿紝闇€瑕佹參鎱㈠搧鍛�
*********************************************************************************************
*  杩欐槸鍒汉鍐欑殑涓滆タ锛屾垜鍙槸閲嶅鍒╃敤锛屽井璋冧簡涓�--鍔姏鍔姏 ^-^||
*  
* -----------淇濇寔闃熷舰------------------
*  <div id='coffee'></div>
*********************************************************************************************/
//     Zepto.js
//     (c) 2010-2014 Thomas Fuchs
//     Zepto.js may be freely distributed under the MIT license.
; (function ($, undefined) {
    var prefix = '', eventPrefix, endEventName, endAnimationName,
    vendors = { Webkit: 'webkit', Moz: '', O: 'o' },
    document = window.document, testEl = document.createElement('div'),
    supportedTransforms = /^((translate|rotate|scale)(X|Y|Z|3d)?|matrix(3d)?|perspective|skew(X|Y)?)$/i,
    transform,
    transitionProperty, transitionDuration, transitionTiming, transitionDelay,
    animationName, animationDuration, animationTiming, animationDelay,
    cssReset = {}

    function dasherize(str) { return str.replace(/([a-z])([A-Z])/, '$1-$2').toLowerCase() }
    function normalizeEvent(name) { return eventPrefix ? eventPrefix + name : name.toLowerCase() }

    $.each(vendors, function (vendor, event) {
        if (testEl.style[vendor + 'TransitionProperty'] !== undefined) {
            prefix = '-' + vendor.toLowerCase() + '-'
            eventPrefix = event
            return false
        }
    })

    transform = prefix + 'transform'
    cssReset[transitionProperty = prefix + 'transition-property'] =
  cssReset[transitionDuration = prefix + 'transition-duration'] =
  cssReset[transitionDelay = prefix + 'transition-delay'] =
  cssReset[transitionTiming = prefix + 'transition-timing-function'] =
  cssReset[animationName = prefix + 'animation-name'] =
  cssReset[animationDuration = prefix + 'animation-duration'] =
  cssReset[animationDelay = prefix + 'animation-delay'] =
  cssReset[animationTiming = prefix + 'animation-timing-function'] = ''

    $.fx = {
        off: (eventPrefix === undefined && testEl.style.transitionProperty === undefined),
        speeds: { _default: 400, fast: 200, slow: 600 },
        cssPrefix: prefix,
        transitionEnd: normalizeEvent('TransitionEnd'),
        animationEnd: normalizeEvent('AnimationEnd')
    }

    $.fn.animate = function (properties, duration, ease, callback, delay) {
        if ($.isFunction(duration))
            callback = duration, ease = undefined, duration = undefined
        if ($.isFunction(ease))
            callback = ease, ease = undefined
        if ($.isPlainObject(duration))
            ease = duration.easing, callback = duration.complete, delay = duration.delay, duration = duration.duration
        if (duration) duration = (typeof duration == 'number' ? duration :
                    ($.fx.speeds[duration] || $.fx.speeds._default)) / 1000
        if (delay) delay = parseFloat(delay) / 1000
        return this.anim(properties, duration, ease, callback, delay)
    }

    $.fn.anim = function (properties, duration, ease, callback, delay) {
        var key, cssValues = {}, cssProperties, transforms = '',
        that = this, wrappedCallback, endEvent = $.fx.transitionEnd,
        fired = false

        if (duration === undefined) duration = $.fx.speeds._default / 1000
        if (delay === undefined) delay = 0
        if ($.fx.off) duration = 0

        if (typeof properties == 'string') {
            // keyframe animation
            cssValues[animationName] = properties
            cssValues[animationDuration] = duration + 's'
            cssValues[animationDelay] = delay + 's'
            cssValues[animationTiming] = (ease || 'linear')
            endEvent = $.fx.animationEnd
        } else {
            cssProperties = []
            // CSS transitions
            for (key in properties)
                if (supportedTransforms.test(key)) transforms += key + '(' + properties[key] + ') '
                else cssValues[key] = properties[key], cssProperties.push(dasherize(key))

            if (transforms) cssValues[transform] = transforms, cssProperties.push(transform)
            if (duration > 0 && typeof properties === 'object') {
                cssValues[transitionProperty] = cssProperties.join(', ')
                cssValues[transitionDuration] = duration + 's'
                cssValues[transitionDelay] = delay + 's'
                cssValues[transitionTiming] = (ease || 'linear')
            }
        }

        wrappedCallback = function (event) {
            if (typeof event !== 'undefined') {
                if (event.target !== event.currentTarget) return // makes sure the event didn't bubble from "below"
                $(event.target).unbind(endEvent, wrappedCallback)
            } else
                $(this).unbind(endEvent, wrappedCallback) // triggered by setTimeout

            fired = true
            $(this).css(cssReset)
            callback && callback.call(this)
        }
        if (duration > 0) {
            this.bind(endEvent, wrappedCallback)
            // transitionEnd is not always firing on older Android phones
            // so make sure it gets fired
            setTimeout(function () {
                if (fired) return
                wrappedCallback.call(that)
            }, (duration * 1000) + 25)
        }

        // trigger page reflow so new elements can animate
        this.size() && this.get(0).clientLeft

        this.css(cssValues)

        if (duration <= 0) setTimeout(function () {
            that.each(function () { wrappedCallback.call(this) })
        }, 0)

        return this
    }

    testEl = null
})(Zepto)

// 闊崇鐨勬紓娴殑鎻掍欢鍒朵綔--zpeto鎵╁睍
; (function ($) {
    // 鍒╃敤zpeto鐨刟nimate鐨勫姩鐢�-css3鐨勫姩鐢�-easing涓轰簡css3鐨別asing(zpeto娌℃湁鎻愪緵easing鐨勬墿灞�)
    $.fn.coffee = function (option) {
        // 鍔ㄧ敾瀹氭椂鍣�
        var __time_val = null;
        var __time_wind = null;
        var __flyFastSlow = 'cubic-bezier(.09,.64,.16,.94)';

        // 鍒濆鍖栧嚱鏁颁綋锛岀敓鎴愬搴旂殑DOM鑺傜偣
        var $coffee = $(this);
        var opts = $.extend({}, $.fn.coffee.defaults, option);  // 缁ф壙浼犲叆鐨勫€�

        // 婕傛诞鐨凞OM
        var coffeeSteamBoxWidth = opts.steamWidth;
        var $coffeeSteamBox = $('<div class="coffee-steam-box"></div>')
      .css({
          'height': opts.steamHeight,
          'width': opts.steamWidth,
          'left': 60,
          'top': -50,
          'position': 'absolute',
          'overflow': 'hidden',
          'z-index': 0
      })
      .appendTo($coffee);

        // 鍔ㄧ敾鍋滄鍑芥暟澶勭悊
        $.fn.coffee.stop = function () {
            clearInterval(__time_val);
            clearInterval(__time_wind);
        }

        // 鍔ㄧ敾寮€濮嬪嚱鏁板鐞�
        $.fn.coffee.start = function () {
            __time_val = setInterval(function () {
                steam();
            }, rand(opts.steamInterval / 2, opts.steamInterval * 2));

            __time_wind = setInterval(function () {
                wind();
            }, rand(100, 1000) + rand(1000, 3000))
        }
        return $coffee;

        // 鐢熸垚婕傛诞鐗�
        function steam() {
            // 璁剧疆椋炶浣撶殑鏍峰紡
            var fontSize = rand(8, opts.steamMaxSize);     // 瀛椾綋澶у皬
            var steamsFontFamily = randoms(1, opts.steamsFontFamily); // 瀛椾綋绫诲瀷
            var color = '#' + randoms(6, '0123456789ABCDEF');  // 瀛椾綋棰滆壊
            var position = rand(0, 44);                       // 璧峰垵浣嶇疆
            var rotate = rand(-90, 89);                          // 鏃嬭浆瑙掑害
            var scale = rand02(0.4, 1);                          // 澶у皬缂╂斁
            var transform = $.fx.cssPrefix + 'transform';        // 璁剧疆闊崇鐨勬棆杞搴﹀拰澶у皬
            transform = transform + ':rotate(' + rotate + 'deg) scale(' + scale + ');'

            // 鐢熸垚fly椋炶浣�
            var $fly = $('<span class="coffee-steam">' + randoms(1, opts.steams) + '</span>');
            var left = rand(0, coffeeSteamBoxWidth - opts.steamWidth - fontSize);
            if (left > position) left = rand(0, position);
            $fly
        .css({
            'position': 'absolute',
            'left': position,
            'top': opts.steamHeight,
            'font-size:': fontSize + 'px',
            'color': color,
            'font-family': steamsFontFamily,
            'display': 'block',
            'opacity': 1
        })
        .attr('style', $fly.attr('style') + transform)
        .appendTo($coffeeSteamBox)
        .animate({
            top: rand(opts.steamHeight / 2, 0),
            left: left,
            opacity: 0
        }, rand(opts.steamFlyTime / 2, opts.steamFlyTime * 1.2), __flyFastSlow, function () {
            $fly.remove();
            $fly = null;
        });
        };

        // 椋庤锛屽彲浠ヨ婕傛诞浣擄紝宸﹀彸娴姩
        function wind() {
            // 宸﹀彸娴姩鐨勮寖鍥村€�
            var left = rand(-10, 10);
            left += parseInt($coffeeSteamBox.css('left'));
            if (left >= 54) left = 54;
            else if (left <= 34) left = 34;

            // 绉诲姩鐨勫嚱鏁�
            $coffeeSteamBox.animate({
                left: left
            }, rand(1000, 3000), __flyFastSlow);
        };

        // 闅忓嵆涓€涓€�
        // 鍙互浼犲叆涓€涓暟缁勫拰涓€涓瓧绗︿覆
        // 浼犲叆鏁扮粍鐨勮瘽锛岄殢鍗宠幏鍙栦竴涓暟缁勭殑鍏冪礌
        // 浼犲叆瀛楃涓茬殑璇濓紝闅忓嵆鑾峰彇鍏朵腑鐨刲ength鐨勫瓧绗�
        function randoms(length, chars) {
            length = length || 1;
            var hash = '';                  // 
            var maxNum = chars.length - 1;  // last-one
            var num = 0;                    // fisrt-one
            for (i = 0; i < length; i++) {
                num = rand(0, maxNum - 1);
                hash += chars.slice(num, num + 1);
            }
            return hash;
        };

        // 闅忓嵆涓€涓暟鍊肩殑鑼冨洿涓殑鍊�--鏁存暟
        function rand(mi, ma) {
            var range = ma - mi;
            var out = mi + Math.round(Math.random() * range);
            return parseInt(out);
        };

        // 闅忓嵆涓€涓暟鍊肩殑鑼冨洿涓殑鍊�--娴偣
        function rand02(mi, ma) {
            var range = ma - mi;
            var out = mi + Math.random() * range;
            return parseFloat(out);
        };
    };

    $.fn.coffee.defaults = {
        steams: ['jQuery', 'HTML5', 'HTML6', 'CSS2', 'CSS3', 'JS', '$.fn()', 'char', 'short', 'if', 'float', 'else', 'type', 'case', 'function', 'travel', 'return', 'array()', 'empty()', 'eval', 'C++', 'JAVA', 'PHP', 'JSP', '.NET', 'while', 'this', '$.find();', 'float', '$.ajax()', 'addClass', 'width', 'height', 'Click', 'each', 'animate', 'cookie', 'bug', 'Design', 'Julying', '$(this)', 'i++', 'Chrome', 'Firefox', 'Firebug', 'IE6', 'Guitar', 'Music', '鏀诲煄甯�', '鏃呰', '鐜嬪瓙澧�', '鍟ら厭'], /*婕傛诞鐗╃殑绫诲瀷锛岀绫�*/
        steamsFontFamily: ['Verdana', 'Geneva', 'Comic Sans MS', 'MS Serif', 'Lucida Sans Unicode', 'Times New Roman', 'Trebuchet MS', 'Arial', 'Courier New', 'Georgia'],  /*婕傛诞鐗╃殑瀛椾綋绫诲瀷*/
        steamFlyTime: 5000, /*Steam椋炶鐨勬椂闂�,鍗曚綅 ms 銆傦紙鍐冲畾steam椋炶閫熷害鐨勫揩鎱級*/
        steamInterval: 500,  /*鍒堕€燬team鏃堕棿闂撮殧,鍗曚綅 ms.*/
        steamMaxSize: 30,   /*闅忓嵆鑾峰彇婕傛诞鐗╃殑瀛椾綋澶у皬*/
        steamHeight: 200,   /*椋炶浣撶殑楂樺害*/
        steamWidth: 300    /*椋炶浣撶殑瀹藉害*/
    };
    $.fn.coffee.version = '2.0.0'; // 鏇存柊涓洪煶绗︾殑鎮诞---閲嶆瀯鐨勪唬鐮�
})(Zepto);
