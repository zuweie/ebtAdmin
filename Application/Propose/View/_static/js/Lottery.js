/**
*  canvas钂欐澘鍥剧墖澶勭悊鎻掍欢
*  -----------------------------
*  浣滆€咃細鍙兼€庝箞鍐欙紒- -||
*  鏃堕棿锛�2014-03-21
*  鍑嗗垯锛欽S鍘熷瀷
*  鑱旂郴锛歸echat--shoe11414255
*  涓€寮犵綉椤碉紝瑕佺粡鍘嗘€庢牱鐨勮繃绋嬶紝鎵嶈兘鎶佃揪鐢ㄦ埛闈㈠墠
*  涓€涓壒鏁堬紝瑕佺粡鍘嗚繖鏍风殑淇敼锛屾墠鑳借鐢ㄦ埛鐐逛釜璧�
*  涓€涓骇鍝侊紝鍒涙剰婧愪簬鐢熸椿锛屾簮浜庡唴蹇冿紝闇€瑕佹參鎱㈠搧鍛�
*********************************************************************************************
*  杩欐槸鍒汉鍐欑殑涓滆タ锛屾垜鍙槸閲嶅鍒╃敤锛屽井璋冧簡涓�--鍔姏鍔姏 ^-^||
*  
* -----------淇濇寔闃熷舰------------------
*  <div id='Lottery'></div>
*********************************************************************************************/
/**
* [Lottery description]钂欐澘鎻掍欢
* @param  {DOM}      node       canvas瀵硅薄鐖惰緢
* @param  {鍦板潃鍊紏    url        鑳屾櫙鍥剧墖鎴栬€呮枃瀛�
* @param  {鍦板潃鍊紏    canvas_url 钂欐澘鐨勫浘鐗�
* @param  {DOM绫诲瀷}   type       钂欐澘鐨勭被鍨�
* @param  {px}       w          鐢诲竷鐨勫搴�
* @param  {px}       h          鐢诲竷鐨勯珮搴�
* @param  {fn}       callback   鍥炶皟鍑芥暟
*/
function Lottery(node, cover, coverType, width, height, drawPercentCallback) {
    //canvas
    this.conNode = node;

    // 鑳屾櫙canvas
    this.background = null;
    this.backCtx = null;

    // 钂欐澘canvas
    this.mask = null;
    this.maskCtx = null;

    // 鑳屾櫙鍥�
    this.lottery = null;
    this.lotteryType = 'image';

    // 钂欐澘鍥�
    this.cover = cover || "#000";
    this.coverType = coverType;
    this.pixlesData = null;

    // canvas瀹介珮
    this.width = width;
    this.height = height;

    this.lastPosition = null;
    // 鍥炶皟鍑芥暟
    this.drawPercentCallback = drawPercentCallback;

    this.vail = false;
}

Lottery.prototype = {
    // 鍒涘缓鍏冪礌
    createElement: function (tagName, attributes) {
        var ele = document.createElement(tagName);
        for (var key in attributes) {
            ele.setAttribute(key, attributes[key]);
        }
        return ele;
    },

    // 鑾峰彇褰撳墠canvas閫忔槑鍍忕礌鐨勭櫨鍒嗘瘮
    getTransparentPercent: function (ctx, width, height) {
        // 鑾峰彇鐢诲竷鐨勫儚绱犵偣
        var imgData = ctx.getImageData(0, 0, width, height),
            pixles = imgData.data,
            transPixs = [];

        // 璁＄畻鐢诲竷涓紝閫忔槑绋嬪害锛堢鍥涗釜鍊间负閫忔槑搴�0-255锛�
        for (var i = 0, j = pixles.length; i < j; i += 4) {
            var a = pixles[i + 3];
            if (a < 128) {
                transPixs.push(i);
            }
        }
        return (transPixs.length / (pixles.length / 4) * 100).toFixed(2);
    },

    // 閲嶇疆鐢诲竷
    resizeCanvas: function (canvas, width, height) {
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').clearRect(0, 0, width, height);
    },

    resizeCanvas_w: function (canvas, width, height) {
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').clearRect(0, 0, width, height);

        // canvas鐢诲竷锛岀敓鎴愬搴旂殑DOM寮€濮�--(鍓嶈€呭垽鏂槸鍚︾敓鎴愯儗鏅浘)
        if (this.vail) this.drawLottery();
        else this.drawMask();
    },

    // 鐢诲竷涓婄敾鐐�
    drawPoint: function (x, y, fresh) {
        this.maskCtx.beginPath();
        this.maskCtx.arc(x, y, 30, 0, Math.PI * 2);
        this.maskCtx.fill();

        // 钂欐澘-璺緞杩樻槸璁板綍
        this.maskCtx.beginPath();

        // 鐢荤瑪澶у皬
        this.maskCtx.lineWidth = 60;
        // 鍓嶈€呮槸绾跨殑鏈鏍峰紡锛屽悗鑰呮槸绾胯繛鎺ュ鐨勬牱寮�---鍦�
        this.maskCtx.lineCap = this.maskCtx.lineJoin = 'round';

        // 鐢荤偣
        if (this.lastPosition) {
            this.maskCtx.moveTo(this.lastPosition[0], this.lastPosition[1]);
        }
        this.maskCtx.lineTo(x, y);
        this.maskCtx.stroke();

        this.lastPosition = [x, y];

        this.mask.style.zIndex = (this.mask.style.zIndex == 20) ? 21 : 20;
    },

    // 浜嬩欢澶勭悊
    bindEvent: function () {
        var _this = this;
        // 鍒ゆ柇鏄惁涓虹Щ鍔ㄧ
        var device = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
        var clickEvtName = device ? 'touchstart' : 'mousedown';
        var moveEvtName = device ? 'touchmove' : 'mousemove';
        if (!device) {
            var isMouseDown = false;
            _this.conNode.addEventListener('mouseup', function (e) {
                e.preventDefault();

                isMouseDown = false;
                var per = _this.getTransparentPercent(_this.maskCtx, _this.width, _this.height);

                if (per >= 50) {
                    // 鎵ц鍥炶皟鍑芥暟
                    if (typeof (_this.drawPercentCallback) == 'function') _this.drawPercentCallback();
                }
            }, false);
        } else {
            _this.conNode.addEventListener("touchmove", function (e) {
                if (isMouseDown) {
                    e.preventDefault();
                }
                if (e.cancelable) { e.preventDefault(); } else { window.event.returnValue = false; }
            }, false);
            _this.conNode.addEventListener('touchend', function (e) {
                isMouseDown = false;
                var per = _this.getTransparentPercent(_this.maskCtx, _this.width, _this.height);
                if (per >= 50) {
                    // 鎵ц鍥炶皟鍑芥暟
                    if (typeof (_this.drawPercentCallback) == 'function') _this.drawPercentCallback();
                }
            }, false);
        }

        // move浜嬩欢鏉ョ敾鐐�
       this.mask.addEventListener(clickEvtName, function (e) {
       
            e.preventDefault();

            // 璁板綍寮€濮媘ove
            isMouseDown = true;

            var x = (device ? e.touches[0].pageX : e.pageX || e.x);
            var y = (device ? e.touches[0].pageY : e.pageY || e.y);

            // 鐢荤偣
            _this.drawPoint(x, y, isMouseDown);
        }, false);

        this.mask.addEventListener(moveEvtName, function (e) {
            e.preventDefault();

            // 璁板綍鏄惁寮€濮媘ove
            if (!isMouseDown) return false;
            e.preventDefault();

            var x = (device ? e.touches[0].pageX : e.pageX || e.x);
            var y = (device ? e.touches[0].pageY : e.pageY || e.y);

            // 鐢荤偣
            _this.drawPoint(x, y, isMouseDown);
        }, false);
    },

    // 鐢昏儗鏅浘
    drawLottery: function () {
        if (this.lotteryType == 'image') {
            var image = new Image(),
                _this = this;
            image.onload = function () {
                this.width = _this.width;
                this.height = _this.height;
                _this.resizeCanvas(_this.background, _this.width, _this.height);
                _this.backCtx.drawImage(this, 0, 0, _this.width, _this.height);
                _this.drawMask();
            }
            image.src = this.lottery;
        } else if (this.lotteryType == 'text') {
            this.width = this.width;
            this.height = this.height;
            this.resizeCanvas(this.background, this.width, this.height);
            this.backCtx.save();
            this.backCtx.fillStyle = '#FFF';
            this.backCtx.fillRect(0, 0, this.width, this.height);
            this.backCtx.restore();
            this.backCtx.save();
            var fontSize = 30;
            this.backCtx.font = 'Bold ' + fontSize + 'px Arial';
            this.backCtx.textAlign = 'center';
            this.backCtx.fillStyle = '#F60';
            this.backCtx.fillText(this.lottery, this.width / 2, this.height / 2 + fontSize / 2);
            this.backCtx.restore();
            this.drawMask();
        }
    },

    // 鐢昏挋鏉�
    drawMask: function () {
        if (this.coverType == 'color') {
            this.maskCtx.fillStyle = this.cover;
            this.maskCtx.fillRect(0, 0, this.width, this.height);
            this.maskCtx.globalCompositeOperation = 'destination-out';
        } else if (this.coverType == 'image') {
            var image = new Image(),
                _this = this;
            image.onload = function () {
                _this.resizeCanvas(_this.mask, _this.width, _this.height);

                var android = (/android/i.test(navigator.userAgent.toLowerCase()));

                _this.maskCtx.globalAlpha = 0.98;
                // _this.maskCtx.drawImage(this, 0, 0,_this.width, _this.height);
                _this.maskCtx.drawImage(this, 0, 0, this.width, this.height, 0, 0, _this.width, _this.height);

                var fontSize = 50;
                var txt = $('#ca-tips').val();
                var gradient = _this.maskCtx.createLinearGradient(0, 0, _this.width, 0);
                gradient.addColorStop("0", "#fff");
                gradient.addColorStop("1.0", "#000");

                _this.maskCtx.font = 'Bold ' + fontSize + 'px Arial';
                _this.maskCtx.textAlign = 'left';
                _this.maskCtx.fillStyle = gradient;
                _this.maskCtx.fillText(txt, _this.width / 2 - _this.maskCtx.measureText(txt).width / 2, 100);

                _this.maskCtx.globalAlpha = 1;

                _this.maskCtx.globalCompositeOperation = 'destination-out';
            }
            image.src = this.cover;
        }
    },

    // 鍑芥暟鍒濆鍖�
    init: function (lottery, lotteryType) {
        // 鍒ゆ柇鏄惁浼犲叆鑳屾櫙鍥惧弬鏁帮紝骞跺偍瀛樺€�
        // 鐢熸垚鑳屾櫙鍥剧殑DOM
        if (lottery) {
            this.lottery = lottery;
            this.lottery.width = this.width;
            this.lottery.height = this.height;
            this.lotteryType = lotteryType || 'image';

            this.vail = true;
        }
        if (this.vail) {
            this.background = this.background || this.createElement('canvas', {
                style: 'position:fixed;left:50%;top:0;width:640px;margin-left:-320px;height:100%;background-color:transparent;'
            });
        }

        // 鐢熸垚钂欐澘DOM
        this.mask = this.mask || this.createElement('canvas', {
            style: 'position:fixed;left:50%;top:0;width:640px;margin-left:-320px;height:100%;background-color:transparent;'
        });
        this.mask.style.zIndex = 20;

        // 灏嗙洰鏍噖rapDOM鐨凥TML鍐呭鍏ㄩ儴娓呯┖--(canvas-clear锛�
        if (!this.conNode.innerHTML.replace(/[\w\W]| /g, '')) {
            if (this.vail) this.conNode.appendChild(this.background);
            this.conNode.appendChild(this.mask);
            this.bindEvent();
        }
        if (this.vail) this.backCtx = this.backCtx || this.background.getContext('2d');
        this.maskCtx = this.maskCtx || this.mask.getContext('2d');

        // canvas鐢诲竷锛岀敓鎴愬搴旂殑DOM寮€濮�--(鍓嶈€呭垽鏂槸鍚︾敓鎴愯儗鏅浘)
        if (this.vail) this.drawLottery();
        else this.drawMask();

        var _this = this;
        window.addEventListener('resize', function () {
            // canvas瀹介珮
            _this.width = document.documentElement.clientWidth;
            _this.height = document.documentElement.clientHeight;

            _this.resizeCanvas_w(_this.mask, _this.width, _this.height);
        }, false);
    }
}