/**
*  鍏ㄥ眬鍑芥暟澶勭悊
*  -----------------------------
*  浣滆€咃細鍙兼€庝箞鍐欙紒- -||
*  鏃堕棿锛�2014-03-26
*  鍑嗗垯锛歓pote銆佸瓧闈㈤噺瀵硅薄
*  鑱旂郴锛歸echat--shoe11414255
*  涓€寮犵綉椤碉紝瑕佺粡鍘嗘€庢牱鐨勮繃绋嬶紝鎵嶈兘鎶佃揪鐢ㄦ埛闈㈠墠
*  涓€涓壒鏁堬紝瑕佺粡鍘嗚繖鏍风殑淇敼锛屾墠鑳借鐢ㄦ埛鐐逛釜璧�
*  涓€涓骇鍝侊紝鍒涙剰婧愪簬鐢熸椿锛屾簮浜庡唴蹇冿紝闇€瑕佹參鎱㈠搧鍛�
*********************************************************************************************/
var car2 = {
    /****************************************************************************************************/
    /*  瀵硅薄绉佹湁鍙橀噺/鍑芥暟杩斿洖鍊�/閫氱敤澶勭悊鍑芥暟
    *****************************************************************************************************/
    /*************************
    *  = 瀵硅薄鍙橀噺锛屽垽鏂嚱鏁�
    *************************/
    _events: {}, 								// 鑷畾涔変簨浠�---this._execEvent('scrollStart');
    _windowHeight: $(window).height(), 				// 璁惧灞忓箷楂樺害
    _windowWidth: $(window).width(),

    _rotateNode: $('.p-ct'), 						// 鏃嬭浆浣�

    _page: $('.m-page'), 						// 妯＄増椤甸潰鍒囨崲鐨勯〉闈㈤泦鍚�
    _pageNum: $('.m-page').size(), 				// 妯＄増椤甸潰鐨勪釜鏁�
    _pageNow: 0, 								// 椤甸潰褰撳墠鐨刬ndex鏁�
    _pageNext: null, 								// 椤甸潰涓嬩竴涓殑index鏁�

    _touchStartValY: 0, 								// 瑙︽懜寮€濮嬭幏鍙栫殑绗竴涓€�
    _touchDeltaY: 0, 								// 婊戝姩鐨勮窛绂�

    _moveStart: true, 								// 瑙︽懜绉诲姩鏄惁寮€濮�
    _movePosition: null, 								// 瑙︽懜绉诲姩鐨勬柟鍚戯紙涓娿€佷笅锛�
    _movePosition_c: null, 								// 瑙︽懜绉诲姩鐨勬柟鍚戠殑鎺у埗
    _mouseDown: false, 							// 鍒ゆ柇榧犳爣鏄惁鎸変笅
    _moveFirst: true,
    _moveInit: false,

    _firstChange: false,

    _map: $('.ylmap'), 						// 鍦板浘DOM瀵硅薄
    _mapValue: null, 								// 鍦板浘鎵撳紑鏃讹紝瀛樺偍鏈€杩戞墦寮€鐨勪竴涓湴鍥�
    _mapIndex: null, 								// 寮€鍚湴鍥剧殑鍧愭爣浣嶇疆

    _audioNode: $('.u-audio'), 					// 澹伴煶妯″潡
    _audio: null, 								// 澹伴煶瀵硅薄
    _audio_val: true, 								// 澹伴煶鏄惁寮€鍚帶鍒�

    _elementStyle: document.createElement('div').style, // css灞炴€т繚瀛樺璞�

    _UC: RegExp("Android").test(navigator.userAgent) && RegExp("UC").test(navigator.userAgent) ? true : false,
    _weixin: RegExp("MicroMessenger").test(navigator.userAgent) ? true : false,
    _iPhoen: RegExp("iPhone").test(navigator.userAgent) || RegExp("iPod").test(navigator.userAgent) || RegExp("iPad").test(navigator.userAgent) ? true : false,
    _Android: RegExp("Android").test(navigator.userAgent) ? true : false,
    _IsPC: function () {
        var userAgentInfo = navigator.userAgent;
        var Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod");
        var flag = true;
        for (var v = 0; v < Agents.length; v++) {
            if (userAgentInfo.indexOf(Agents[v]) > 0) { flag = false; break; }
        }
        return flag;
    },

    /***********************
    *  = gobal閫氱敤鍑芥暟
    ***********************/
    // 鍒ゆ柇鍑芥暟鏄惁鏄痭ull绌哄€�
    _isOwnEmpty: function (obj) {
        for (var name in obj) {
            if (obj.hasOwnProperty(name)) {
                return false;
            }
        }
        return true;
    },
    // 寰俊鍒濆鍖栧嚱鏁�
    _WXinit: function (callback) {
        if (typeof window.WeixinJSBridge == 'undefined' || typeof window.WeixinJSBridge.invoke == 'undefined') {
            setTimeout(function () {
                this.WXinit(callback);
            }, 200);
        } else {
            callback();
        }
    },
    // 鍒ゆ柇娴忚鍣ㄥ唴鏍哥被鍨�
    _vendor: function () {
        var vendors = ['t', 'webkitT', 'MozT', 'msT', 'OT'],
							transform,
							i = 0,
							l = vendors.length;

        for (; i < l; i++) {
            transform = vendors[i] + 'ransform';
            if (transform in this._elementStyle) return vendors[i].substr(0, vendors[i].length - 1);
        }
        return false;
    },
    // 鍒ゆ柇娴忚鍣ㄦ潵閫傞厤css灞炴€у€�
    _prefixStyle: function (style) {
        if (this._vendor() === false) return false;
        if (this._vendor() === '') return style;
        return this._vendor() + style.charAt(0).toUpperCase() + style.substr(1);
    },
    // 鍒ゆ柇鏄惁鏀寔css transform-3d锛堥渶瑕佹祴璇曚笅闈㈠睘鎬ф敮鎸侊級
    _hasPerspective: function () {
        var ret = this._prefixStyle('perspective') in this._elementStyle;
        if (ret && 'webkitPerspective' in this._elementStyle) {
            this._injectStyles('@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}', function (node, rule) {
                ret = node.offsetLeft === 9 && node.offsetHeight === 3;
            });
        }
        return !!ret;
    },
    _translateZ: function () {
        if (car2._hasPerspective) {
            return ' translateZ(0)';
        } else {
            return '';
        }
    },

    // 鍒ゆ柇灞炴€ф敮鎸佹槸鍚�
    _injectStyles: function (rule, callback, nodes, testnames) {
        var style, ret, node, docOverflow,
							div = document.createElement('div'),
							body = document.body,
							fakeBody = body || document.createElement('body'),
							mod = 'modernizr';

        if (parseInt(nodes, 10)) {
            while (nodes--) {
                node = document.createElement('div');
                node.id = testnames ? testnames[nodes] : mod + (nodes + 1);
                div.appendChild(node);
            }
        }

        style = ['&#173;', '<style id="s', mod, '">', rule, '</style>'].join('');
        div.id = mod;
        (body ? div : fakeBody).innerHTML += style;
        fakeBody.appendChild(div);
        if (!body) {
            fakeBody.style.background = '';
            fakeBody.style.overflow = 'hidden';
            docOverflow = docElement.style.overflow;
            docElement.style.overflow = 'hidden';
            docElement.appendChild(fakeBody);
        }

        ret = callback(div, rule);
        if (!body) {
            fakeBody.parentNode.removeChild(fakeBody);
            docElement.style.overflow = docOverflow;
        } else {
            div.parentNode.removeChild(div);
        }

        return !!ret;
    },
    // 鑷畾涔変簨浠舵搷浣�
    _handleEvent: function (type) {
        if (!this._events[type]) {
            return;
        }

        var i = 0,
							l = this._events[type].length;

        if (!l) {
            return;
        }

        for (; i < l; i++) {
            this._events[type][i].apply(this, [].slice.call(arguments, 1));
        }
    },
    // 缁欒嚜瀹氫箟浜嬩欢缁戝畾鍑芥暟
    _on: function (type, fn) {
        if (!this._events[type]) {
            this._events[type] = [];
        }

        this._events[type].push(fn);
    },
    //绂佹婊氬姩鏉�
    _scrollStop: function () {
        //绂佹婊氬姩
        $(window).on('touchmove.scroll', this._scrollControl);
        $(window).on('scroll.scroll', this._scrollControl);
    },
    //鍚姩婊氬姩鏉�
    _scrollStart: function () {
        //寮€鍚睆骞曠姝�
        $(window).off('touchmove.scroll');
        $(window).off('scroll.scroll');
    },
    //婊氬姩鏉℃帶鍒朵簨浠�
    _scrollControl: function (e) { e.preventDefault(); },

    /**************************************************************************************************************/
    /*  鍏宠仈澶勭悊鍑芥暟
    ***************************************************************************************************************/
    /**
    *  鍗曢〉闈�-m-page 鍒囨崲鐨勫嚱鏁板鐞�
    *  -->缁戝畾浜嬩欢
    *  -->浜嬩欢澶勭悊鍑芥暟
    *  -->浜嬩欢鍥炶皟鍑芥暟
    *  -->浜嬩欢鍏宠仈鍑芥暟銆�
    */
    // 椤甸潰鍒囨崲寮€濮�
    page_start: function () {
        car2._page.on('touchstart mousedown', car2.page_touch_start);
        car2._page.on('touchmove mousemove', car2.page_touch_move);
        car2._page.on('touchend mouseup', car2.page_touch_end);
    },

    // 椤甸潰鍒囨崲鍋滄
    page_stop: function () {
        car2._page.off('touchstart mousedown');
        car2._page.off('touchmove mousemove');
        car2._page.off('touchend mouseup');
    },

    // page瑙︽懜绉诲姩start
    page_touch_start: function (e) {
        if (!car2._moveStart) return;

        if (e.type == "touchstart") {
            car2._touchStartValY = window.event.touches[0].pageY;
        } else {
            car2._touchStartValY = e.pageY || e.y;
            car2._mouseDown = true;
        }

        car2._moveInit = true;

        // start浜嬩欢
        car2._handleEvent('start');
    },

    // page瑙︽懜绉诲姩move
    page_touch_move: function (e) {
        e.preventDefault();

        if (!car2._moveStart) return;
        if (!car2._moveInit) return;

        // 璁剧疆鍙橀噺鍊�
        var $self = car2._page.eq(car2._pageNow),
 			h = parseInt($self.height()),
 			moveP,
 			scrollTop,
 			node = null,
 			move = false;

        // 鑾峰彇绉诲姩鐨勫€�
        if (e.type == "touchmove") {
            moveP = window.event.touches[0].pageY;
            move = true;
        } else {
            if (car2._mouseDown) {
                moveP = e.pageY || e.y;
                move = true;
            } else return;
        }

        // 鑾峰彇涓嬫娲诲姩鐨刾age
        node = car2.page_position(e, moveP, $self);

        // page椤甸潰绉诲姩 		
        car2.page_translate(node);

        // move浜嬩欢
        car2._handleEvent('move');
    },

    // page瑙︽懜绉诲姩鍒ゆ柇鏂瑰悜
    page_position: function (e, moveP, $self) {
        var now, next;

        // 璁剧疆绉诲姩鐨勮窛绂�
        if (moveP != 'undefined') car2._touchDeltaY = moveP - car2._touchStartValY;

        // 璁剧疆绉诲姩鏂瑰悜
        car2._movePosition = moveP - car2._touchStartValY > 0 ? 'down' : 'up';
        if (car2._movePosition != car2._movePosition_c) {
            car2._moveFirst = true;
            car2._movePosition_c = car2._movePosition;
        } else {
            car2._moveFirst = false;
        }

        // 璁剧疆涓嬩竴椤甸潰鐨勬樉绀哄拰浣嶇疆        
        if (car2._touchDeltaY <= 0) {
            if ($self.next('.m-page').length == 0) {
                car2._pageNext = 0;
            } else {
                car2._pageNext = car2._pageNow + 1;
            }

            next = car2._page.eq(car2._pageNext)[0];
        } else {
            if ($self.prev('.m-page').length == 0) {
                if (car2._firstChange) {
                    car2._pageNext = car2._pageNum - 1;
                } else {
                    return;
                }
            } else {
                car2._pageNext = car2._pageNow - 1;
            }

            next = car2._page.eq(car2._pageNext)[0];
        }

        now = car2._page.eq(car2._pageNow)[0];
        node = [next, now];

        // move闃舵鏍规嵁鏂瑰悜璁剧疆椤甸潰鐨勫垵濮嬪寲浣嶇疆--鎵ц涓€娆�
        if (car2._moveFirst) init_next(node);

        function init_next(node) {
            var s, l, _translateZ = car2._translateZ();

            car2._page.removeClass('action');
            $(node[1]).addClass('action').removeClass('f-hide');
            car2._page.not('.action').addClass('f-hide');

            // 妯＄増楂樺害閫傞厤鍑芥暟澶勭悊
            car2.height_auto(car2._page.eq(car2._pageNext), 'false');

            // 鏄剧ず瀵瑰簲绉诲姩鐨刾age
            $(node[0]).removeClass('f-hide').addClass('active');

            // 璁剧疆涓嬩竴椤甸潰鐨勬樉绀哄拰浣嶇疆        
            if (car2._movePosition == 'up') {
                s = parseInt($(window).scrollTop());
                if (s > 0) l = $(window).height() + s;
                else l = $(window).height();
                node[0].style[car2._prefixStyle('transform')] = 'translate(0,' + l + 'px)' + _translateZ;
                $(node[0]).attr('data-translate', l);

                $(node[1]).attr('data-translate', 0);
            } else {
                node[0].style[car2._prefixStyle('transform')] = 'translate(0,-' + Math.max($(window).height(), $(node[0]).height()) + 'px)' + _translateZ;
                $(node[0]).attr('data-translate', -Math.max($(window).height(), $(node[0]).height()));

                $(node[1]).attr('data-translate', 0);
            }
        }

        return node;
    },

    // page瑙︽懜绉诲姩璁剧疆鍑芥暟
    page_translate: function (node) {
        // 娌℃湁浼犲€艰繑鍥�
        if (!node) return;

        var _translateZ = car2._translateZ(),
 			y_1, y_2, scale,
 			y = car2._touchDeltaY;

        // 鍒囨崲鐨勯〉闈㈢Щ鍔�
        if ($(node[0]).attr('data-translate')) y_1 = y + parseInt($(node[0]).attr('data-translate'));
        node[0].style[car2._prefixStyle('transform')] = 'translate(0,' + y_1 + 'px)' + _translateZ;

        // 褰撳墠鐨勯〉闈㈢Щ鍔�
        if ($(node[1]).attr('data-translate')) y_2 = y + parseInt($(node[1]).attr('data-translate'));
        scale = 1 - Math.abs(y * 0.2 / $(window).height());
        y_2 = y_2 / 5;
        node[1].style[car2._prefixStyle('transform')] = 'translate(0,' + y_2 + 'px)' + _translateZ + ' scale(' + scale + ')';
    },

    // page瑙︽懜绉诲姩end
    page_touch_end: function (e) {
        car2._moveInit = false;
        car2._mouseDown = false;
        if (!car2._moveStart) return;
        if (!car2._pageNext && car2._pageNext != 0) return;

        car2._moveStart = false;

        // 纭繚绉诲姩浜�
        if (Math.abs(car2._touchDeltaY) > 10) {
            car2._page.eq(car2._pageNext)[0].style[car2._prefixStyle('transition')] = 'all .3s';
            car2._page.eq(car2._pageNow)[0].style[car2._prefixStyle('transition')] = 'all .3s';
        }

        // 椤甸潰鍒囨崲
        if (Math.abs(car2._touchDeltaY) >= 100) {		// 鍒囨崲鎴愬姛
            car2.page_success();
        } else if (Math.abs(car2._touchDeltaY) > 10 && Math.abs(car2._touchDeltaY) < 100) {	// 鍒囨崲澶辫触		
            car2.page_fial();
        } else {									// 娌℃湁鍒囨崲
            car2.page_fial();
        }

        // end浜嬩欢
        car2._handleEvent('end');

        // 娉ㄩ攢鎺у埗鍊�
        car2._movePosition = null;
        car2._movePosition_c = null;
        car2._touchStartValY = 0;
    },

    // 鍒囨崲鎴愬姛
    page_success: function () {
        var _translateZ = car2._translateZ();

        // 涓嬩竴涓〉闈㈢殑绉诲姩
        car2._page.eq(car2._pageNext)[0].style[car2._prefixStyle('transform')] = 'translate(0,0)' + _translateZ;

        // 褰撳墠椤甸潰鍙樺皬鐨勭Щ鍔�
        var y = car2._touchDeltaY > 0 ? $(window).height() / 5 : -$(window).height() / 5;
        var scale = 0.8;
        car2._page.eq(car2._pageNow)[0].style[car2._prefixStyle('transform')] = 'translate(0,' + y + 'px)' + _translateZ + ' scale(' + scale + ')';

        // 鎴愬姛浜嬩欢
        car2._handleEvent('success');
    },

    // 鍒囨崲澶辫触
    page_fial: function () {
        var _translateZ = car2._translateZ();

        // 鍒ゆ柇鏄惁绉诲姩浜�
        if (!car2._pageNext && car2._pageNext != 0) {
            car2._moveStart = true;
            car2._moveFirst = true;
            return;
        }

        if (car2._movePosition == 'up') {
            car2._page.eq(car2._pageNext)[0].style[car2._prefixStyle('transform')] = 'translate(0,' + $(window).height() + 'px)' + _translateZ;
        } else {
            car2._page.eq(car2._pageNext)[0].style[car2._prefixStyle('transform')] = 'translate(0,-' + $(window).height() + 'px)' + _translateZ;
        }

        car2._page.eq(car2._pageNow)[0].style[car2._prefixStyle('transform')] = 'translate(0,0)' + _translateZ + ' scale(1)';

        // fial浜嬩欢
        car2._handleEvent('fial');
    },

    /**
    *  瀵硅薄鍑芥暟浜嬩欢缁戝畾澶勭悊
    *  -->start touch寮€濮嬩簨浠�
    *  -->mov   move绉诲姩浜嬩欢
    *  -->end   end缁撴潫浜嬩欢
    */
    haddle_envent_fn: function () {
        // 褰撳墠椤甸潰绉诲姩锛屽欢杩熷姞杞戒互鍚庣殑鍥剧墖
        car2._on('start', car2.lazy_bigP);

        // 褰撳墠椤甸潰绉诲姩
        car2._on('move', function () {

        });

        // 鍒囨崲澶辫触浜嬩欢
        car2._on('fial', function () {
            setTimeout(function () {
                car2._page.eq(car2._pageNow).attr('data-translate', '');
                car2._page.eq(car2._pageNow)[0].style[car2._prefixStyle('transform')] = '';
                car2._page.eq(car2._pageNow)[0].style[car2._prefixStyle('transition')] = '';
                car2._page.eq(car2._pageNext)[0].style[car2._prefixStyle('transform')] = '';
                car2._page.eq(car2._pageNext)[0].style[car2._prefixStyle('transition')] = '';

                car2._page.eq(car2._pageNext).removeClass('active').addClass('f-hide');
                car2._moveStart = true;
                car2._moveFirst = true;
                car2._pageNext = null;
                car2._touchDeltaY = 0;
                car2._page.eq(car2._pageNow).attr('style', '');
            }, 300)
        })

        // 鍒囨崲鎴愬姛浜嬩欢
        car2._on('success', function () {
            // 鍒ゆ柇鏈€鍚庝竴椤佃锛屽紑鍚惊鐜垏鎹�
            if (car2._pageNext == 0 && car2._pageNow == car2._pageNum - 1) {
                car2._firstChange = true;
            }

            // 鍒ゆ柇鏄惁鏄渶鍚庝竴椤碉紝璁╄交APP鍏宠仈椤甸潰闅愯棌
            if (car2._page.eq(car2._pageNext).next('.m-page').length != 0) {
                car2.lightapp_intro_hide(true);
            }
            setTimeout(function () {
                // 璁剧疆瀵屾枃鏈殑楂樺害
                car2.Txt_init(car2._page.eq(car2._pageNow));

                // 鍒ゆ柇鏄惁涓烘渶鍚庝竴椤碉紝鏄剧ず鎴栬€呴殣钘忕澶�
                if (car2._pageNext == car2._pageNum - 1) $('.u-arrow').addClass('f-hide');
                else $('.u-arrow').removeClass('f-hide');

                car2._page.eq(car2._pageNow).addClass('f-hide');

                car2._page.eq(car2._pageNow).attr('data-translate', '');
                car2._page.eq(car2._pageNow)[0].style[car2._prefixStyle('transform')] = '';
                car2._page.eq(car2._pageNow)[0].style[car2._prefixStyle('transition')] = '';
                car2._page.eq(car2._pageNext)[0].style[car2._prefixStyle('transform')] = '';
                car2._page.eq(car2._pageNext)[0].style[car2._prefixStyle('transition')] = '';

                // 鍒濆鍖栧垏鎹㈢殑鐩稿叧鎺у埗鍊�
                $('.p-ct').removeClass('fixed');
                car2._page.eq(car2._pageNext).removeClass('active');
                car2._page.eq(car2._pageNext).removeClass('fixed');
                car2._pageNow = car2._pageNext;
                car2._moveStart = true;
                car2._moveFirst = true;
                car2._pageNext = null;
                car2._page.eq(car2._pageNow).attr('style', '');
                car2._page.eq(car2._pageNow).removeClass('fixed');
                car2._page.eq(car2._pageNow).attr('data-translate', '');
                car2._touchDeltaY = 0;

                // 鍒囨崲鎴愬姛鍚庯紝鎵ц褰撳墠椤甸潰鐨勫姩鐢�---寤惰繜200ms
                setTimeout(function () {
                    if (car2._page.eq(car2._pageNow).hasClass('z-animate')) return;
                    car2._page.eq(car2._pageNow).addClass('z-animate');
                }, 20)

                // 闅愯棌鍥炬枃缁勪欢鐨勬枃鏈�
                $('.j-detail').removeClass('z-show');
                $('.txt-arrow').removeClass('z-toggle');

                // 鍒囨崲鍋滄瑙嗛鐨勬挱鏀�
                $('video').each(function () {
                    if (!this.paused) this.pause();
                })

                // 璁剧疆瀵屾枃鏈殑楂樺害
                car2.Txt_init(car2._page.eq(car2._pageNow));

                // 鍒ゆ柇鏄惁婊戝姩鏈€鍚庝竴椤碉紝骞惰杞籄PP浠嬬粛鍏宠仈椤甸潰璐ゆ窇
                if (car2._page.eq(car2._pageNow).next('.m-page').length == 0) {
                    car2.lightapp_intro_show();
                    car2.lightapp_intro();
                }
            }, 300)

            // 鍒囨崲鎴愬姛鍚庯紝鍙戦€佺粺璁�
            var laytouType = car2._page.eq(car2._pageNow).attr('data-statics');

           car2.ajaxTongji(laytouType);
        })
    },

    /**
    *  鍦板浘鍒涘缓鍑芥暟澶勭悊
    *  -->缁戝畾浜嬩欢
    *  -->浜嬩欢澶勭悊鍑芥暟
    *  -->鍒涘缓鍦板浘
    *  -->鍑芥暟浼犲€�
    *  -->鍏抽棴鍑芥暟鍥炶皟澶勭悊
    */
    // 鑷畾涔夌粦瀹氫簨浠�
    mapAddEventHandler: function (obj, eventType, fn, option) {
        var fnHandler = fn;
        if (!car2._isOwnEmpty(option)) {
            fnHandler = function (e) {
                fn.call(this, option);  //缁ф壙鐩戝惉鍑芥暟,骞朵紶鍏ュ弬鏁颁互鍒濆鍖�;
            }
        }
        obj.each(function () {
            $(this).on(eventType, fnHandler);
        })
    },

    //鐐瑰嚮鍦板浘鎸夐挳鏄剧ず鍦板浘
    mapShow: function (option) {
        // 鑾峰彇鍚勮嚜鍦板浘鐨勮祫婧愪俊鎭�
        var str_data = $(this).attr('data-detal');
        option.detal = str_data != '' ? eval('(' + str_data + ')') : '';
        option.latitude = $(this).attr('data-latitude');
        option.longitude = $(this).attr('data-longitude');

        // 鍦板浘娣诲姞
        var detal = option.detal,
			latitude = option.latitude,
			longitude = option.longitude,
		 	fnOpen = option.fnOpen,
			fnClose = option.fnClose;

        car2._scrollStop();
        car2._map.addClass('show');
        $(document.body).animate({ scrollTop: 0 }, 0);

        //鍒ゆ柇寮€鍚湴鍥剧殑浣嶇疆鏄惁鏄綋鍓嶇殑
        if ($(this).attr('data-mapIndex') != car2._mapIndex) {
            car2._map.html($('<div class="bk"><span class="css_sprite01 s-bg-map-logo"></span></div>'));
            car2._mapValue = false;
            car2._mapIndex = $(this).attr('data-mapIndex');

        } else {
            car2._mapValue = true;
        }

        setTimeout(function () {
            //灏嗗湴鍥炬樉绀哄嚭鏉�
            if (car2._map.find('div').length >= 1) {
                car2._map.addClass("mapOpen");
                car2.page_stop();
                car2._scrollStop();
                car2._audioNode.addClass('z-low');
                // 璁剧疆灞傜骇鍏崇郴-z-index
                car2._page.eq(car2._pageNow).css('z-index', 15);

                setTimeout(function () {
                    //濡傛灉寮€鍚湴鍥剧殑浣嶇疆涓嶄竴鏍峰垯锛屽垱寤烘柊鐨勫湴鍥�
                    if (!car2._mapValue) car2.addMap(detal, latitude, longitude, fnOpen, fnClose);
                }, 500)
            } else return;
        }, 100)
    },

    //鍦板浘鍏抽棴锛屽皢閲岄潰鐨勫唴瀹规竻绌猴紙浼樺寲DON缁撴瀯锛�
    mapSave: function () {
        $(window).on('webkitTransitionEnd transitionend', mapClose);
        car2.page_start();
        car2._scrollStart();
        car2._map.removeClass("mapOpen");
        car2._audioNode.removeClass('z-low');

        if (!car2._mapValue) car2._mapValue = true;

        function mapClose() {
            car2._map.removeClass('show');
            // 璁剧疆灞傜骇鍏崇郴-z-index
            car2._page.eq(car2._pageNow).css('z-index', 9);
            $(window).off('webkitTransitionEnd transitionend');
        }
    },

    //鍦板浘鍑芥暟浼犲€硷紝鍒涘缓鍦板浘
    addMap: function (detal, latitude, longitude, fnOpen, fnClose) {
        var detal = detal,
			latitude = Number(latitude),
			longitude = Number(longitude);

        var fnOpen = typeof (fnOpen) === 'function' ? fnOpen : '',
			fnClose = typeof (fnClose) === 'function' ? fnClose : '';

        //榛樿鍊艰瀹�
        var a = { sign_name: '', contact_tel: '', address: '澶╁畨闂�' };

        //妫€娴嬩紶鍊兼槸鍚︿负绌猴紝璁剧疆浼犲€�
        car2._isOwnEmpty(detal) ? detal = a : detal = detal;
        !latitude ? latitude = 39.915 : latitude = latitude;
        !longitude ? longitude = 116.404 : longitude = longitude;

        //鍒涘缓鍦板浘
        car2._map.ylmap({
            /*鍙傛暟浼犻€掞紝榛樿涓哄ぉ瀹夐棬鍧愭爣*/
            //闇€瑕佹墽琛岀殑鍑芥暟锛堝洖璋冿級
            detal: detal, 	//鍦板潃鍊�
            latitude: latitude, 	//绾害
            longitude: longitude, //缁忓害
            fnOpen: fnOpen, 	//鍥炶皟鍑芥暟锛屽湴鍥惧紑鍚墠
            fnClose: fnClose		//鍥炶皟鍑芥暟锛屽湴鍥惧叧闂悗
        });
    },

    //缁戝畾鍦板浘鍑虹幇鍑芥暟
    mapCreate: function () {
        if ('.j-map'.length <= 0) return;

        var node = $('.j-map');

        //option鍦板浘鍑芥暟鐨勫弬鏁�
        var option = {
            fnOpen: car2._scrollStop,
            fnClose: car2.mapSave
        };
        car2.mapAddEventHandler(node, 'click', car2.mapShow, option);
    },

    /**
    *  media璧勬簮绠＄悊
    *  -->缁戝畾澹伴煶鎺у埗浜嬩欢
    *  -->鍑芥暟澶勭悊澹伴煶鐨勫紑鍚拰鍏抽棴
    *  -->寮傛鍔犺浇澹伴煶鎻掍欢锛堝欢杩熷仛锛�
    *  -->澹伴煶鍒濆鍖�
    *  -->瑙嗛鍒濆鍖�
    *  -->澹伴煶鍜岃棰戝垏鎹㈢殑鎺у埗
    */
    // 澹伴煶鍒濆鍖�
    audio_init: function () {
        // media璧勬簮鐨勫姞杞�
        var options_audio = {
            loop: true,
            preload: "auto",
            src: car2._audioNode.attr('data-src')
        }

        car2._audio = new Audio();

        for (var key in options_audio) {
            if (options_audio.hasOwnProperty(key) && (key in car2._audio)) {
                car2._audio[key] = options_audio[key];
            }
        }
        car2._audio.load();
    },

    // 澹伴煶浜嬩欢缁戝畾
    audio_addEvent: function () {
        if (car2._audioNode.length <= 0) return;

        // 澹伴煶鎸夐挳鐐瑰嚮浜嬩欢
        var txt = car2._audioNode.find('.txt_audio'),
 			time_txt = null;
        car2._audioNode.find('.btn_audio').on('click', car2.audio_contorl);

        // 澹伴煶鎵撳紑浜嬩欢
        $(car2._audio).on('play', function () {
            car2._audio_val = false;

            audio_txt(txt, true, time_txt);

            // 寮€鍚煶绗﹀啋娉�
            $.fn.coffee.start();
            $('.coffee-steam-box').show(500);
        })

        // 澹伴煶鍏抽棴浜嬩欢
        $(car2._audio).on('pause', function () {
            audio_txt(txt, false, time_txt)

            // 鍏抽棴闊崇鍐掓场
            $.fn.coffee.stop();
            $('.coffee-steam-box').hide(500);
        })

        function audio_txt(txt, val, time_txt) {
            if (val) txt.text('打开');
            else txt.text('关闭');

            if (time_txt) clearTimeout(time_txt);

            txt.removeClass('z-move z-hide');
            time_txt = setTimeout(function () {
                txt.addClass('z-move').addClass('z-hide');
            }, 1000)
        }
    },

    // 澹伴煶鎺у埗鍑芥暟
    audio_contorl: function () {
        if (!car2._audio_val) {
            car2.audio_stop();
        } else {
            car2.audio_play();
        }
    },

    // 澹伴煶鎾斁
    audio_play: function () {
        car2._audio_val = false;
        if (car2._audio) car2._audio.play();
    },

    // 澹伴煶鍋滄
    audio_stop: function () {
        car2._audio_val = true;
        if (car2._audio) car2._audio.pause();
    },

    // 瑙嗛鍒濆鍖�
    video_init: function () {
        // 瑙嗛
        $('.j-video').each(function () {
            var option_video = {
                controls: 'controls',
                preload: 'none',
                // poster : $(this).attr('data-poster'),
                width: $(this).attr('data-width'),
                height: $(this).attr('data-height'),
                src: $(this).attr('data-src')
            }

            var video = $('<video class="f-hide"></video>')[0];

            for (var key in option_video) {
                if (option_video.hasOwnProperty(key) && (key in video)) {
                    video[key] = option_video[key];
                }
                this.appendChild(video);
            }

            var img = $(video).prev();

            $(video).on('play', function () {
                img.hide();
                $(video).removeClass('f-hide');
            });

            $(video).on('pause', function () {
                img.show();
                $(video).addClass('f-hide');
            });
        })

        $('.j-video .img').on('click', function () {
            var video = $(this).next()[0];

            if (video.paused) {
                $(video).removeClass('f-hide');
                video.play();
                $(this).hide();
            }
        })
    },

    //澶勭悊澹伴煶鍜屽姩鐢荤殑鍒囨崲
    media_control: function () {
        if (!car2._audio) return;
        if ($('video').length <= 0) return;

        $(car2._audio).on('play', function () {
            $('video').each(function () {
                if (!this.paused) {
                    this.pause();
                }
            });
        });

        $('video').on('play', function () {
            if (!car2._audio_val) {
                car2.audio_contorl();
            }
        });
    },

    // media绠＄悊鍒濆鍖�
    media_init: function () {
        // 澹伴煶鍒濆鍖�
        car2.audio_init();

        // 瑙嗛鍒濆鍖�
        car2.video_init();

        // 缁戝畾闊充箰鍔犺浇浜嬩欢
        car2.audio_addEvent();

        // 闊抽鍒囨崲
        car2.media_control();
    },

    /**
    *  鍥剧墖寤惰繜鍔犺浇鍔熻兘
    *  -->鏇夸唬闇€瑕佸欢杩熷姞杞界殑鍥剧墖
    *  -->浼樺寲鍔犺浇鏇夸唬鍥剧墖
    *  -->鍒囨崲鍔熻兘瑙﹀彂鍥剧墖鐨勫欢杩熷姞杞�
    *  -->鏇夸唬鍥剧墖涓�400*400鐨勯€忔槑澶у浘鐗�
    */
    /* 鍥剧墖寤惰繜鍔犺浇 */
    lazy_img: function () {
        var lazyNode = $('.lazy-img');
        lazyNode.each(function () {
            var self = $(this);
            if (self.is('img')) {
                self.attr('src', '/Application/WeddingInvitation/View/_static/imgs/loading_large.gif');
            } else {
                // 鎶婂師鏉ョ殑鍥剧墖棰勫厛淇濆瓨涓嬫潵
                var position = self.css('background-position'),
					size = self.css('background-size');

                self.attr({
                    'data-position': position,
                    'data-size': size
                });

                if (self.attr('data-bg') == 'no') {
                    self.css({
                        'background-repeat': 'no-repeat'
                    })
                }

                self.css({
                    'background-image': 'url(/Application/WeddingInvitation/View/_static/imgs/loading_large.gif)',
                    'background-size': '120px 120px',
                    'background-position': 'center'
                })

                if (self.attr('data-image') == 'no') {
                    self.css({
                        'background-image': 'none'
                    })
                }
            }
        })
    },

    // 寮€濮嬪姞杞藉墠涓変釜椤甸潰
    lazy_start: function () {
        // 鍓嶄笁涓〉闈㈢殑鍥剧墖寤惰繜鍔犺浇
        setTimeout(function () {
            for (var i = 0; i < 3; i++) {
                var node = $(".m-page").eq(i);
                if (node.length == 0) break;
                if (node.find('.lazy-img').length != 0) {
                    car2.lazy_change(node, false);
                    // 椋炲嚭绐楀彛鐨勫欢杩�
                    if (node.attr('data-page-type') == 'flyCon') {
                        car2.lazy_change($('.m-flypop'), false);
                    }
                } else continue;
            }
        }, 200)
    },

    // 鍔犺浇褰撳墠鍚庨潰绗笁涓�
    lazy_bigP: function () {
        for (var i = 3; i <= 5; i++) {
            var node = $(".m-page").eq(car2._pageNow + i);
            if (node.length == 0) break;
            if (node.find('.lazy-img').length != 0) {
                car2.lazy_change(node, true);
                // 椋炲嚭绐楀彛鐨勫欢杩�
                if (node.attr('data-page-type') == 'flyCon') {
                    car2.lazy_change($('.m-flypop'), false);
                }
            } else continue;
        }
    },

    // 鍥剧墖寤惰繜鏇挎崲鍑芥暟
    lazy_change: function (node, goon) {
        // 3d鍥剧墖鐨勫欢杩熷姞杞�
        if (node.attr('data-page-type') == '3d') car2.lazy_3d(node);

        // 椋炲嚭绐楀彛鐨勫欢杩�
        if (node.attr('data-page-type') == 'flyCon') {
            var img = $('.m-flypop').find('.lazy-img');
            img.each(function () {
                var self = $(this),
					srcImg = self.attr('data-src');

                $('<img />')
					.on('load', function () {
					    if (self.is('img')) {
					        self.attr('src', srcImg)
					    }
					})
					.attr("src", srcImg);
            })
        }

        // 鍏朵粬鍥剧墖鐨勫欢杩熷姞杞�
        var lazy = node.find('.lazy-img');
        lazy.each(function () {
            var self = $(this),
				srcImg = self.attr('data-src'),
				position = self.attr('data-position'),
				size = self.attr('data-size');

            if (self.attr('data-bg') != 'no') {
                $('<img />')
					.on('load', function () {
					    if (self.is('img')) {
					        self.attr('src', srcImg)
					    } else {
					        self.css({
					            'background-image': 'url(' + srcImg + ')',
					            'background-position': position,
					            'background-size': size
					        })
					    }

					    // 鍒ゆ柇涓嬮潰椤甸潰杩涜鍔犺浇
					    if (goon) {
					        for (var i = 0; i < $(".m-page").size(); i++) {
					            var page = $(".m-page").eq(i);
					            if ($(".m-page").find('.lazy-img').length == 0) continue
					            else {
					                car2.lazy_change(page, true);
					            }
					        }
					    }
					})
					.attr("src", srcImg);

                self.removeClass('lazy-img').addClass('lazy-finish');
            } else {
                if (self.attr('data-auto') == 'yes') self.css('background', 'none');
            }
        })
    },
    /**
    * 琛ㄥ崟楠岃瘉鍑芥暟鎺у埗
    * -->鎻愪氦鎸夐挳鐨勭偣鍑讳簨浠�
    * -->姣忎竴涓〃鍗曠殑杈撳叆鍊艰繘琛岄獙璇�
    * -->姝ｅ垯楠岃瘉鐨勫嚱鏁�
    * -->寮傛鎻愪氦鐨勫嚱鏁�
    * -->鎻愪氦鏄剧ず淇℃伅鐨勫嚱鏁�
    */
    // 鎻愪氦鎸夐挳鐐瑰嚮锛岃繘琛岄獙璇佸嚱鏁�
    signUp_submit: function () {
        $('#j-signUp-submit').on('click', function (e) {
            console.log('click')
            e.preventDefault();
            var form = $(this).parents('#j-signUp');
            var valid = car2.signUpCheck_input(form);
            if (valid) {
                car2.signUpCheck_submit(form);
            }
            else return;
        })
    },


    // 鎴戣鎶ュ悕琛ㄥ崟楠岃瘉鍑芥暟
    signUpCheck_input: function (form, type) {
        var valid = true;
        var inputs = form.find('input');

        inputs.each(function () {
            if (this.name != '' && this.name != 'undefined') {
                //鍑芥暟楠岃瘉
                var name = this.name;
                var backData = car2.regFunction(name);

                var empty_tip = backData.empty_tip,
					reg = backData.reg,
					reg_tip = backData.reg_tip;

                //鏍规嵁缁撴灉澶勭悊
                if ($.trim($(this).val()) == '') {
                    car2.showCheckMessage(empty_tip, true);
                    $(this).focus();
                    $(this).addClass('z-error');
                    valid = false;
                    return false;
                }
                if (reg != undefined && reg != '') {
                    if (!$(this).val().match(reg)) {
                        $(this).focus();
                        $(this).addClass('z-error');
                        car2.showCheckMessage(reg_tip, true);
                        valid = false;
                        return false;
                    }
                }
                $(this).removeClass('z-error');
                $('.u-note-error').html('');
            }
        });
        if (valid == false) {
            return false;
        } else {
            return true;
        }
    },

    // 姝ｅ垯鍑芥暟楠岃瘉
    regFunction: function (inputName) {
        var empty_tip = '',
			reg_tip = '',
			reg = '';

        //鍒ゆ柇
        switch (inputName) {
            case 'name':
                reg = /^[\u4e00-\u9fa5|a-z|A-Z|\s]{1,20}$/;
                empty_tip = '涓嶈兘钀戒笅濮撳悕鍝︼紒';
                reg_tip = '杩欏悕瀛楀お鎬簡锛�';
                break;
            case 'sex':
                empty_tip = '鎯虫兂锛岃鎬庝箞绉板懠鎮ㄥ憿锛�';
                reg_tip = '鎯虫兂锛岃鎬庝箞绉板懠鎮ㄥ憿锛�';
                break;
            case 'tel':
                reg = /^1[0-9][0-9]\d{8}$/;
                empty_tip = '鏈変釜鑱旂郴鏂瑰紡锛屽氨鏇村ソ浜嗭紒';
                reg_tip = '杩欏彿鐮�,鍙墦涓嶉€�... ';
                break;
            case 'email':
                reg = /(^[a-z\d]+(\.[a-z\d]+)*@([\da-z](-[\da-z])?)+(\.{1,2}[a-z]+)+$)/i;
                empty_tip = '閮�21涓栫邯浜嗭紝搴旇鏈変釜鐢靛瓙閭鍚э紒';
                reg_tip = '閭鏍煎紡鏈夐棶棰樺摝锛�';
                break;
            case 'company':
                reg = /^[\u4e00-\u9fa5|a-z|A-Z|\s|\d]{1,20}$/;
                empty_tip = '濉釜鍏徃鍚э紒';
                reg_tip = '杩欎釜鍏徃澶鎬簡锛�';
                break;
            case 'job':
                reg = /^[\u4e00-\u9fa5|a-z|A-Z|\s]{1,20}$/;
                empty_tip = '璇锋偍濉釜鑱屼綅';
                reg_tip = '杩欎釜鑱屼綅澶鎬簡锛�';
                break;
            case 'date':
                empty_tip = '缁欎釜鏃ユ湡鍚э紒';
                reg_tip = '';
                break;
            case 'time':
                empty_tip = '濉笅鍏蜂綋鏃堕棿鏇村ソ鍝︼紒';
                reg_tip = '';
                break;
            case 'age':
                reg = /^([3-9])|([1-9][0-9])|([1][0-3][0-9])$/;
                empty_tip = '鏈変釜骞撮緞灏辨洿濂戒簡锛�';
                reg_tip = '杩欏勾榫勫彲涓嶅鍝︼紒';
                break;
        }
        return {
            empty_tip: empty_tip,
            reg_tip: reg_tip,
            reg: reg
        }
    },

    // ajax寮傛鎻愪氦琛ㄥ崟鏁版嵁
    signUpCheck_submit: function (form) {
        car2.loadingPageShow();

        var url = '/auto/submit/' + $('#activity_id').val();
        // // ajax鎻愪氦鏁版嵁
        $.ajax({
            url: url,
            cache: false,
            dataType: 'json',
            async: true,
            type: 'POST',
            data: form.serialize(),
            success: function (msg) {

                car2.loadingPageHide();

                if (msg.code == 200) {
                    // 鎻愮ず鎴愬姛
                    car2.showCheckMessage('鎻愪氦鎴愬姛锛�', true)

                    // 鍏抽棴绐楀彛
                    setTimeout(function () {
                        $('.book-form').removeClass('z-show');
                        $('.book-bg').removeClass('z-show');
                        setTimeout(function () {
                            $(document.body).css('height', '100%');
                            car2.page_start();
                            car2._scrollStop();

                            $('.book-bg').addClass('f-hide');
                            $('.book-form').addClass('f-hide');
                        }, 500)
                    }, 1000)

                    // 鎸夐挳鍙樿壊
                    $('.book-bd .bd-form .btn').addClass("z-stop");
                    $('.book-bd .bd-form .btn').attr("data-submit", 'true');

                } else if (msg.code == '400') {
                    car2.showCheckMessage('鎻愪氦澶辫触', false);
                }


            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                car2.showCheckMessage(errorThrown, true);
                setTimeout(function () {
                    car2.loadingPageHide();
                }, 500)
            }
        })
    },

    // 鏄剧ず楠岃瘉淇℃伅
    showCheckMessage: function (msg, error) {
        if (error) {
            $('.u-note-error').html(msg);
            $(".u-note-error").addClass("on");
            $(".u-note-sucess").removeClass("on");

            setTimeout(function () {
                $(".u-note").removeClass("on");
            }, 2000);
        } else {
            $(".u-note-sucess").addClass("on");
            $(".u-note-error").removeClass("on");

            setTimeout(function () {
                $(".u-note").removeClass("on");
            }, 2000);
        }
    },

    /**************************************************************************************************************/
    /*  鍗曚釜澶勭悊鍑芥暟
    ***************************************************************************************************************/
    /**
    * 鍗曚釜鍑芥暟澶勭悊-unit
    * -->楂樺害鐨勮绠�
    * -->鏂囨湰鐨勫睍寮€
    * -->鏂囨湰鐨勬敹璧�
    * -->杈撳叆琛ㄥ崟鐨勬搷浣�
    * -->寰俊鐨勫垎浜彁绀�
    */
    // 鏍规嵁璁惧鐨勯珮搴︼紝鏉ラ€傞厤姣忎竴涓ā鐗堢殑楂樺害锛屽苟涓旈潤姝㈡粦鍔�
    // --鏂囨。鍒濆鍖栬绠�
    // --椤甸潰鍒囨崲瀹屾垚璁＄畻
    height_auto: function (ele, val) {
        ele.children('.page-con').css('height', 'auto');
        var height = $(window).height();

        // 闇€瑕佽В闄ゅ浐瀹氶珮搴︾殑page鍗＄墖
        var vial = true;
        if (!vial) {
            if (ele.height() <= height) {
                ele.children('.page-con').height(height + 2);
                if ((!$('.p-ct').hasClass('fixed')) && val == 'true') $('.p-ct').addClass('fixed');
            } else {
                car2._scrollStart();
                if (val == 'true') $('.p-ct').removeClass('fixed');
                ele.children('.page-con').css('height', '100%');
                return;
            }
        } else {
            ele.children('.page-con').height(height + 2);
            if ((!$('.p-ct').hasClass('fixed')) && val == 'true') $('.p-ct').addClass('fixed');
        }
    },

    // 瀵屾枃鏈殑璁剧疆
    Txt_init: function (node) {
        if (node.find('.j-txt').length <= 0) return;
        if (node.find('.j-txt').find('.j-detail p').length <= 0) return;

        node.find('.j-txt').each(function () {
            var txt = $(this).find('.j-detail'),
				title = $(this).find('.j-title'),
				arrow = title.find('.txt-arrow'),
				p = txt.find('p'),
				height_t = parseInt(title.height()),
				height_p = parseInt(p.height()),
				height_a = height_p + height_t;

            if ($(this).parents('.m-page').hasClass('m-smallTxt')) {
                if ($(this).parents('.smallTxt-bd').index() == 0) {
                    txt.css('top', height_t);
                } else {
                    txt.css('bottom', height_t);
                }
            }

            txt.attr('data-height', height_p);
            $(this).attr('data-height-init', height_t);
            $(this).attr('data-height-extand', height_a);

            p[0].style[car2._prefixStyle('transform')] = 'translate(0,-' + height_p + 'px)';
            if ($(this.parentNode).hasClass('z-left')) p[0].style[car2._prefixStyle('transform')] = 'translate(0,' + height_p + 'px)';

            txt.css('height', '0');
            arrow.removeClass('z-toggle');
            $(this).css('height', height_t);
        })
    },

    // 瀵屾枃鏈粍浠剁偣鍑诲睍寮€璇︾粏鍐呭
    bigTxt_extand: function () {
        $('body').on('click', '.j-title', function () {
            if ($('.j-detail').length <= 0) return;

            // 瀹氫綅
            var detail = $(this.parentNode).find('.j-detail');
            $('.j-detail').removeClass('action');
            detail.addClass('action');
            if ($(this).hasClass('smallTxt-arrow')) {
                $('.smallTxt-bd').removeClass('action');
                detail.parent().addClass('action');
            }

            // 璁剧疆
            if (detail.hasClass('z-show')) {
                detail.removeClass('z-show');
                detail.css('height', 0);
                $(this.parentNode).css('height', parseInt($(this.parentNode).attr('data-height-init')));
            }
            else {
                detail.addClass('z-show');
                detail.css('height', parseInt(detail.attr('data-height')));
                $(this.parentNode).css('height', parseInt($(this.parentNode).attr('data-height-extand')));
            }

            $('.j-detail').not('.action').removeClass('z-show');
            $('.txt-arrow').removeClass('z-toggle');

            detail.hasClass('z-show') ? ($(this).find('.txt-arrow').addClass('z-toggle')) : ($(this).find('.txt-arrow').removeClass('z-toggle'))
        })
    } (),

    // 鏂囨湰鐐瑰嚮鍏朵粬鍦版柟鏀惰捣
    Txt_back: function () {
        $('body').on('click', '.m-page', function (e) {
            e.stopPropagation();

            // 鍒ゆ柇
            var node = $(e.target);
            var page = node.parents('.m-page');
            var txtWrap = node.parents('.j-txtWrap').length == 0 ? node : node.parents('.j-txtWrap');
            if (page.find('.j-txt').find('.j-detail p').length <= 0) return;
            if (page.find('.j-txt').length <= 0 || node.parents('.j-txt').length >= 1 || node.hasClass('bigTxt-btn') || node.parents('.bigTxt-btn').length >= 1) return;

            // 瀹氫綅
            var detail = txtWrap.find('.j-detail');
            $('.j-detail').removeClass('action');
            detail.addClass('action');
            $('.j-detail').not('.action').removeClass('z-show');

            // 璁剧疆
            txtWrap.each(function () {
                var detail = $(this).find('.j-detail');
                var arrow = $(this).find('.txt-arrow');
                var txt = $(this).find('.j-txt');

                if (detail.hasClass('z-show')) {
                    detail.removeClass('z-show');
                    detail.css('height', 0);
                    txt.css('height', parseInt(txt.attr('data-height-init')));
                } else {
                    detail.addClass('z-show');
                    detail.css('height', parseInt(detail.attr('data-height')));
                    txt.css('height', parseInt(txt.attr('data-height-extand')));
                }

                detail.hasClass('z-show') ? (arrow.addClass('z-toggle')) : (arrow.removeClass('z-toggle'));
            })
        })
    } (),

    // 琛ㄥ崟鏄剧ず锛岃緭鍏�
    input_form: function () {
        $('body').on('click', '.book-bd .bd-form .btn', function () {
            var type_show = $(this).attr("data-submit");
            if (type_show == 'true') {
                return;
            }

            var heigt = $(window).height();

            $(document.body).css('height', heigt);
            car2.page_stop();
            car2._scrollStart();
            // 璁剧疆灞傜骇鍏崇郴-z-index
            car2._page.eq(car2._pageNow).css('z-index', 15);

            $('.book-bg').removeClass('f-hide');
            $('.book-form').removeClass('f-hide');
            setTimeout(function () {
                $('.book-form').addClass('z-show');
                $('.book-bg').addClass('z-show');
            }, 50)

            $('.book-bg').off('click');
            $('.book-bg').on('click', function (e) {
                e.stopPropagation();

                var node = $(e.target);

                if (node.parents('.book-form').length >= 1 && !node.hasClass('j-close-img') && node.parents('.j-close').length <= 0) return;

                $('.book-form').removeClass('z-show');
                $('.book-bg').removeClass('z-show');
                setTimeout(function () {
                    $(document.body).css('height', '100%');
                    car2.page_start();
                    car2._scrollStop();
                    // 璁剧疆灞傜骇鍏崇郴-z-index
                    car2._page.eq(car2._pageNow).css('z-index', 9);

                    $('.book-bg').addClass('f-hide');
                    $('.book-form').addClass('f-hide');
                }, 500)
            })
        })
    } (),

    sex_select: function () {
        var btn = $('#j-signUp').find('.sex p');
        var strongs = $('#j-signUp').find('.sex strong');
        var input = $('#j-signUp').find('.sex input');

        btn.on('click', function () {
            var strong = $(this).find('strong');
            strongs.removeClass('open');
            strong.addClass('open');

            var value = $(this).attr('data-sex');
            input.val(value);
        })
    } (),

    // 鏄剧ず杞籄PP鎸夐挳
    lightapp_intro_show: function () {
        $('.market-notice').removeClass('f-hide');
        setTimeout(function () {
            $('.market-notice').addClass('show');
        }, 100)
    },

    // 闅愯棌杞籄PP鎸夐挳
    lightapp_intro_hide: function (val) {
        if (val) {
            $('.market-notice').addClass('f-hide').removeClass('show');
            return;
        }

        $('.market-notice').removeClass('show');
        setTimeout(function () {
            $('.market-notice').addClass('f-hide')
        }, 500)
    },

    // 杞籄PP浠嬬粛寮圭獥鍏宠仈
    lightapp_intro: function () {
        // 鐐瑰嚮鎸夐挳鏄剧ず鍐呭
        $('.market-notice').off('click');
        $('.market-notice').on('click', function () {
            $('.market-page').removeClass('f-hide');
            setTimeout(function () {
                $('.market-page').addClass('show');
                setTimeout(function () {
                    $('.market-img').addClass('show');
                }, 100)
                car2.lightapp_intro_hide();
            }, 100)

            // 绂佹婊戝姩
            car2.page_stop();
            car2._scrollStop();
        });

        // 鐐瑰嚮绐楀彛璁╁唴瀹归殣钘�
        $('.market-page').off('click');
        $('.market-page').on('click', function (e) {
            if ($(e.target).hasClass('market-page')) {
                $('.market-img').removeClass('show');
                setTimeout(function () {
                    $('.market-page').removeClass('show');
                    setTimeout(function () {
                        $('.market-page').addClass('f-hide');
                    }, 200)
                }, 500)
                car2.lightapp_intro_show();

                // 绂佹婊戝姩
                car2.page_start();
                car2._scrollStart();
            }
        });
    },

    //缁熻鍑芥暟澶勭悊
    ajaxTongji: function (laytouType) {
        var channel_id = location.search.substr(location.search.indexOf("channel=") + 8);
        channel_id = channel_id.match(/^\d+/);
        if (!channel_id || isNaN(channel_id) || channel_id < 0) {
            channel_id = 1;
        }
        var activity_id = $('#activity_id').val();
        var url = "/analyseplugin/plugin?activity_id=" + activity_id + "&plugtype=" + laytouType;
        //鎶ュ悕缁熻璇锋眰
        //$.get(url, {}, function () { });
    },

    // 寰俊鐨勫垎浜彁绀�
    wxShare: function () {
        $('body').on('click', '.bigTxt-btn-wx', function () {
            var img_wx = $(this).parent().find('.bigTxt-weixin');

            img_wx.addClass('z-show');
            car2.page_stop();

            img_wx.on('click', function () {
                $(this).removeClass('z-show');
                car2.page_start();

                $(this).off('click');
            })
        })
    } (),

    // loading鏄剧ず
    loadingPageShow: function () {
        $('.u-pageLoading').show();
    },

    // loading闅愯棌
    loadingPageHide: function () {
        $('.u-pageLoading').hide();
    },

    // 瀵硅薄绉佹湁鍙橀噺鍒锋柊
    refresh: function () {
        $(window).height() = $(window).height();
        car2._windowWidth = $(window).width();
    },

    /**************************************************************************************************************/
    /*  鍑芥暟鍒濆鍖�
    ***************************************************************************************************************/
    /**
    *  鐩稿叧鎻掍欢鐨勫惎鍔�
    */
    //鎻掍欢鍚姩鍑芥暟
    plugin: function () {
        // 鍦板浘
        car2.mapCreate();

        // 闊崇椋橀€�
        $('#coffee_flow').coffee({
            steams: ["<img src='/Application/WeddingInvitation/View/_static/imgs/musicalNotes.png' />", "<img src='/Application/WeddingInvitation/View/_static/imgs/musicalNotes.png' />"],
            steamHeight: 100,
            steamWidth: 44
        });

        // 钂欐澘鎻掍欢
        var node = $('#j-mengban')[0],
			url = '/template/19/img/page_01_bg@2x.jpg',
			canvas_url = $('#r-cover').val(),
			type = 'image',
			w = 640,
			h = $(window).height(),
			callback = car2.start_callback;

        car2.cover_draw(node, url, canvas_url, type, w, h, callback);

        // 寰俊鍒嗕韩
        var option_wx = {};

        if ($('#r-wx-title').val() != '') option_wx.title = $('#r-wx-title').val();
        if ($('#r-wx-img').val() != '') option_wx.img = $('#r-wx-img').val();
        if ($('#r-wx-con').val() != '') option_wx.con = $('#r-wx-con').val();

        if (car2._weixin) $(document.body).wx(option_wx);
    },

    // 钂欐澘鎻掍欢鍒濆鍖栧嚱鏁板鐞�
    cover_draw: function (node, url, canvas_url, type, w, h, callback) {
        if (node.style.display.indexOf('none') > -1) return;

        var lottery = new Lottery(node, canvas_url, type, w, h, callback);
        lottery.init();
    },

    // 钂欐澘鎻掍欢鍥炶皟鍑芥暟澶勭悊
    start_callback: function () {
        // 闅愯棌钂欐澘
        $('#j-mengban').removeClass('z-show');
        setTimeout(function () {
            $('#j-mengban').addClass('f-hide');
        }, 1500)

        // 寮€鍚痺indow鐨勬粴鍔�
        car2._scrollStart();

        // 寮€鍚〉闈㈠垏鎹�
        car2.page_start();

        // 绠ご鏄剧ず
        $('.u-arrow').removeClass('f-hide');

        // 鎾斁澹伴煶
        if (!car2._audio) return;
        car2._audioNode.removeClass('f-hide');
        car2._audio.play();

        // 澹伴煶鍚姩
        $(document).one("touchstart", function () {
            car2._audio.play();
        });
    },

    /**
    * app鍒濆鍖�
    */
    // 鏍峰紡閫傞厤
    styleInit: function () {
        // 绂佹鏂囩増琚嫋鍔�
        document.body.style.userSelect = 'none';
        document.body.style.mozUserSelect = 'none';
        document.body.style.webkitUserSelect = 'none';

        // 鍒ゆ柇璁惧鐨勭被鍨嬪苟鍔犱笂class
        if (car2._IsPC()) $(document.body).addClass('pc');
        else $(document.body).addClass('mobile');
        if (car2._Android) $(document.body).addClass('android');
        if (car2._iPhoen) $(document.body).addClass('iphone');

        // 鍒ゆ柇鏄惁鏈�3d
        if (!car2._hasPerspective()) {
            car2._rotateNode.addClass('transformNode-2d');
            $(document.body).addClass('no-3d');
        }
        else {
            car2._rotateNode.addClass('transformNode-3d');
            $(document.body).addClass('perspective');
            $(document.body).addClass('yes-3d');
        }

        // 鍥剧墖寤惰繜鍔犺浇鐨勫鐞�
        this.lazy_img();

        // 璁剧疆瀵屾枃鏈殑楂樺害
        car2.Txt_init(car2._page.eq(car2._pageNow));

        // 妯＄増鎻愮ず鏂囧瓧鏄剧ず
        setTimeout(function () {
            $('.m-alert').find('strong').addClass('z-show');
        }, 1000)

        $('.u-arrow').on('touchmove', function (e) { e.preventDefault() })

        $('.p-ct').height($(window).height());
        $('.m-page').height($(window).height());
        $('#j-mengban').height($(window).height());
        $('.translate-back').height($(window).height());
    },

    // 瀵硅薄鍒濆鍖�
    init: function () {
        // 鏍峰紡锛屾爣绛剧殑娓叉煋
        // 瀵硅薄鎿嶄綔浜嬩欢澶勭悊
        this.styleInit();
        this.haddle_envent_fn();

        // 鎻掍欢鍔犺浇
        car2.plugin();

        // 绂佹婊戝姩
        // this._scrollStop();

        // 缁戝畾鍏ㄥ眬浜嬩欢鍑芥暟澶勭悊
        // $(window).on('resize',function(){
        // 	car2.refresh();
        // })

        $('input[type="hidden"]').appendTo($('body'));

        // 鍥剧墖棰勫厛鍔犺浇
        $('<img />').attr('src', $('#r-cover').val());
        $('<img />').attr('src', $('.m-fengye').find('.page-con').attr('data-src'));
        
        // loading鎵ц涓€娆�
        var loading_time = new Date().getTime();

        $(window).on('load', function () {
            var now = new Date().getTime();
            var loading_end = false;
            var time;
            var time_del = now - loading_time;

            if (time_del >= 2200) {
                loading_end = true;
            }

            if (loading_end) {
                time = 0;
            } else {
                time = 2200 - time_del;
            }

            // loading瀹屾垚鍚庤姹�
            setTimeout(function () {

                // 妯＄増鎻愮ず闅愯棌
                setTimeout(function () {
                    $('.m-alert').addClass('f-hide');
                }, 1000)

                // 鏄剧ず姝ｉ潰
                $('#j-mengban').addClass('z-show');

                // 鏄剧ず灏侀潰鍐呭
                setTimeout(function () {
                    $('.translate-back').removeClass('f-hide');
                    $('.m-fengye').removeClass('f-hide');
                    car2.height_auto(car2._page.eq(car2._pageNow), 'false');
                }, 1000)

                // setTimeout(function(){
                //              window.scrollTo(0, 1);
                //          }, 0);

                // media鍒濆鍖�
                car2.media_init();

                // 寤惰繜鍔犺浇鍚庨潰涓変釜椤甸潰鍥剧墖
                car2.lazy_start();

                // 鎶ュ悕鎻愪氦鎵ц
                car2.signUp_submit();

                
                /*
                var channel_id = location.search.substr(location.search.indexOf("channel=") + 8);
                channel_id = channel_id.match(/^\d+/);
                if (!channel_id || isNaN(channel_id) || channel_id < 0) {
                    channel_id = 1;
                }
                var activity_id = $('#activity_id').val();
                var url = "/auto/analyse/" + activity_id + "?channel=" + channel_id;
                //鎶ュ悕缁熻璇锋眰
                $.get(url, {}, function () { });
				*/
                
                $('.p-ct').height($(window).height());
                $('.m-page').height($(window).height());
                $('#j-mengban').height($(window).height());
                $('.translate-back').height($(window).height());
            }, time)
        })
    }
};

/*鍒濆鍖栧璞″嚱鏁�*/
//$(document).ready(function(){car2.init()});
//setTimeout(function(){car2.init()}, 1000);
car2.init();
