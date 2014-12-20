/**
*  寰俊鐩稿叧鍔熻兘鎻掍欢
*  -----------------------------
*  浣滆€咃細鍙兼€庝箞鍐欙紒- -||
*  鏃堕棿锛�2014-03-21
*  鍑嗗垯锛歓epto
*  鑱旂郴锛歸echat--shoe11414255
*  涓€寮犵綉椤碉紝瑕佺粡鍘嗘€庢牱鐨勮繃绋嬶紝鎵嶈兘鎶佃揪鐢ㄦ埛闈㈠墠
*  涓€涓壒鏁堬紝瑕佺粡鍘嗚繖鏍风殑淇敼锛屾墠鑳借鐢ㄦ埛鐐逛釜璧�
*  涓€涓骇鍝侊紝鍒涙剰婧愪簬鐢熸椿锛屾簮浜庡唴蹇冿紝闇€瑕佹參鎱㈠搧鍛�
*********************************************************************************************
*  杩欐槸鍒汉鍐欑殑涓滆タ锛屾垜鍙槸閲嶅鍒╃敤锛屽井璋冧簡涓�--鍔姏鍔姏 ^-^||
*********************************************************************************************/
// 寰俊鐩稿叧鍔熻兘鎻掍欢--zpeto鎵╁睍
; (function ($) {
    $.fn.wx = function (option) {
        // 鍒濆鍖栧嚱鏁颁綋
        var $wx = $(this);
        var opts = $.extend({}, $.fn.wx.defaults, option);  // 缁ф壙浼犲叆鐨勫€�

        // 纭畾寰俊鏄惁鍑嗗濂�
        document.addEventListener("WeixinJSBridgeReady", function () {
            window.G_WEIXIN_READY = true;
        }, false);

        // 鍥炲埌鍑芥暟寰幆鎵ц
        function CallWeiXinAPI(fn, count) {
            var total = 2000;   //30s     
            count = count || 0;

            if (true === window.G_WEIXIN_READY || ("WeixinJSBridge" in window)) {
                fn.apply(null, []);
            } else {
                if (count <= total) {
                    setTimeout(function () {
                        CallWeiXinAPI(fn, count++);
                    }, 15);
                }
            }
        }

        var _unit = {
            /**
            * 鎵ц鍥炶皟
            * @param Object handler {Function callback, Array args, Object context, int delay}
            */
            execHandler: function (handler) {
                if (handler && handler instanceof Object) {
                    var callback = handler.callback || null;
                    var args = handler.args || [];
                    var context = handler.context || null;
                    var delay = handler.delay || -1;

                    if (callback && callback instanceof Function) {
                        if (typeof (delay) == "number" && delay >= 0) {
                            setTimeout(function () {
                                callback.apply(context, args);
                            }, delay);
                        } else {
                            callback.apply(context, args);
                        }
                    }
                }
            },

            /**
            * 鍚堝苟鍙傛暟鍚庢墽琛屽洖璋�
            * @param Object handler {Function callback, Array args, Object context, int delay}
            * @param Array args 鍙傛暟
            */
            execAfterMergerHandler: function (handler, _args) {
                if (handler && handler instanceof Object) {
                    var args = handler.args || [];

                    handler.args = _args.concat(args);
                }

                this.execHandler(handler);
            }
        }

        // 寰俊鐨勬帴鍙�
        var _api = {
            Share: {
                /**
                * 鍒嗕韩鍒板井鍗�
                * @param Object options {String content, String url}
                * @param Object handler
                */
                "weibo": function (options, handler) {
                    CallWeiXinAPI(function () {
                        WeixinJSBridge.on("menu:share:weibo", function (argv) {
                            WeixinJSBridge.invoke('shareWeibo', options, function (res) {
                                _unit.execAfterMergerHandler(handler, [res]);
                            });
                        });
                    });
                },
                /**
                * 鍒嗕韩鍒板井鍗�
                * @param Object options {
                *                  String img_url, 
                *                  Number img_width, 
                *                  Number img_height, 
                *                  String link, 
                *                  String desc, 
                *                  String title
                * }
                * @param Object handler
                */
                "timeline": function (options, handler) {
                    CallWeiXinAPI(function () {
                        WeixinJSBridge.on("menu:share:timeline", function (argv) {
                            WeixinJSBridge.invoke('shareTimeline', options, function (res) {
                                _unit.execAfterMergerHandler(handler, [res]);
                            });
                        });
                    });
                },
                /**
                * 鍒嗕韩鍒板井鍗�
                * @param Object options {
                *                  String appid, 
                *                  String img_url, 
                *                  Number img_width, 
                *                  Number img_height, 
                *                  String link, 
                *                  String desc, 
                *                  String title
                * }
                * @param Object handler
                */
                "message": function (options, handler) {
                    CallWeiXinAPI(function () {
                        WeixinJSBridge.on("menu:share:appmessage", function (argv) {
                            WeixinJSBridge.invoke('sendAppMessage', options, function (res) {
                                _unit.execAfterMergerHandler(handler, [res]);
                            });
                        });
                    });
                }
            },
            /**
            * 璁剧疆搴曟爮
            * @param boolean visible 鏄惁鏄剧ず
            * @param Object handler
            */
            "setToolbar": function (visible, handler) {
                CallWeiXinAPI(function () {
                    if (true === visible) {
                        WeixinJSBridge.call('showToolbar');
                    } else {
                        WeixinJSBridge.call('hideToolbar');
                    }
                    _unit.execAfterMergerHandler(handler, [visible]);
                });
            },
            /**
            * 璁剧疆鍙充笂瑙掗€夐」鑿滃崟
            * @param boolean visible 鏄惁鏄剧ず
            * @param Object handler
            */
            "setOptionMenu": function (visible, handler) {
                CallWeiXinAPI(function () {
                    if (true === visible) {
                        WeixinJSBridge.call('showOptionMenu');
                    } else {
                        WeixinJSBridge.call('hideOptionMenu');
                    }
                    _unit.execAfterMergerHandler(handler, [visible]);
                });
            },
            /**
            * 璋冪敤寰俊鏀粯
            * @param Object data 寰俊鏀粯鍙傛暟
            * @param Object handlerMap 鍥炶皟鍙ユ焺 {Handler success, Handler fail, Handler cancel, Handler error}
            */
            "pay": function (data, handlerMap) {
                CallWeiXinAPI(function () {
                    var requireData = { "appId": "", "timeStamp": "", "nonceStr": "", "package": "", "signType": "", "paySign": "" };
                    var map = handlerMap || {};
                    var handler = null;
                    var args = [data];

                    for (var key in requireData) {
                        if (requireData.hasOwnProperty(key)) {
                            requireData[key] = data[key] || "";
                            console.info(key + " = " + requireData[key]);
                        }
                    }

                    WeixinJSBridge.invoke('getBrandWCPayRequest', requireData, function (response) {
                        var key = "get_brand_wcpay_request:";
                        switch (response.err_msg) {
                            case key + "ok":
                                handler = map.success;
                                break;
                            case key + "fail":
                                handler = map.fail || map.error;
                                break;
                            case key + "cancel":
                                handler = map.cancel || map.error;
                                break;
                            default:
                                handler = map.error;
                                break;
                        }

                        _unit.execAfterMergerHandler(handler, args);
                    });
                });
            }
        };

        var opt1 = {
            "content": opts.con
        };

        var opt2 = {
            "img_url": opts.img,
            "img_width": 180,
            "img_height": 180,
            "link": opts.link,
            "desc": opts.con,
            "title": opts.title
        };

        // var opt3 = $.extend({"appid":"wx21f7e6a981efd178"}, opt2);

        handler = {
            callback: function () {

            }
        }

        // 鎵ц鍑芥暟
        _api.Share.timeline(opt2, handler);
        _api.Share.message(opt2, handler);
        _api.Share.weibo(opt1, handler);

        return $wx;
    }
    $.fn.wx.defaults = {
        title: '浜戞潵杞籄PP-鍒涙柊浣滃搧1鍙凤紝浠呴檺鍐呮祴浣撻獙',
        con: '鍒涙柊1鍙蜂粎闄愬唴閮ㄥ皬浼欎即浠敖鎯呬綋楠岋紒锛�',
        link: document.URL,
        img: location.protocol + "//" + location.hostname + ':' + location.port + '/template/19/img/wx_img_01@2x.jpg?time=1'
    };

    $.fn.wx.version = '1.0.0';

})(Zepto);

