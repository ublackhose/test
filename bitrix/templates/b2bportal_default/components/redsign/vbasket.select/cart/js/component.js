/* eslint-disable */
this.B2BPortal = this.B2BPortal || {};
(function (exports) {
	'use strict';

	function unwrapExports(x) {
	  return x && x.__esModule && Object.prototype.hasOwnProperty.call(x, 'default') ? x["default"] : x;
	}
	function createCommonjsModule(fn, module) {
	  return module = {
	    exports: {}
	  }, fn(module, module.exports), module.exports;
	}

	var vueSwatches_min = createCommonjsModule(function (module, exports) {
	  !function (e, t) {
	    module.exports = t();
	  }(window, function () {
	    return function (e) {
	      var t = {};
	      function n(r) {
	        if (t[r]) return t[r].exports;
	        var i = t[r] = {
	          i: r,
	          l: !1,
	          exports: {}
	        };
	        return e[r].call(i.exports, i, i.exports, n), i.l = !0, i.exports;
	      }
	      return n.m = e, n.c = t, n.d = function (e, t, r) {
	        n.o(e, t) || Object.defineProperty(e, t, {
	          configurable: !1,
	          enumerable: !0,
	          get: r
	        });
	      }, n.r = function (e) {
	        Object.defineProperty(e, "__esModule", {
	          value: !0
	        });
	      }, n.n = function (e) {
	        var t = e && e.__esModule ? function () {
	          return e["default"];
	        } : function () {
	          return e;
	        };
	        return n.d(t, "a", t), t;
	      }, n.o = function (e, t) {
	        return Object.prototype.hasOwnProperty.call(e, t);
	      }, n.p = "/", n(n.s = 11);
	    }([function (e, t, n) {

	      t.__esModule = !0;
	      var r,
	        i = n(43),
	        o = (r = i) && r.__esModule ? r : {
	          "default": r
	        };
	      t["default"] = o["default"] || function (e) {
	        for (var t = 1; t < arguments.length; t++) {
	          var n = arguments[t];
	          for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r]);
	        }
	        return e;
	      };
	    }, function (e, t) {
	      e.exports = function (e) {
	        try {
	          return !!e();
	        } catch (e) {
	          return !0;
	        }
	      };
	    }, function (e, t, n) {
	      e.exports = !n(1)(function () {
	        return 7 != Object.defineProperty({}, "a", {
	          get: function get() {
	            return 7;
	          }
	        }).a;
	      });
	    }, function (e, t) {
	      e.exports = function (e) {
	        return "object" == babelHelpers["typeof"](e) ? null !== e : "function" == typeof e;
	      };
	    }, function (e, t) {
	      var n = e.exports = {
	        version: "2.5.6"
	      };
	      "number" == typeof __e && (__e = n);
	    }, function (e, t) {
	      var n = e.exports = "undefined" != typeof window && window.Math == Math ? window : "undefined" != typeof self && self.Math == Math ? self : Function("return this")();
	      "number" == typeof __g && (__g = n);
	    }, function (e, t) {
	      var n = Math.ceil,
	        r = Math.floor;
	      e.exports = function (e) {
	        return isNaN(e = +e) ? 0 : (e > 0 ? r : n)(e);
	      };
	    }, function (e, t) {
	      e.exports = function (e) {
	        if (void 0 == e) throw TypeError("Can't call method on  " + e);
	        return e;
	      };
	    }, function (e, t, n) {
	      var r = n(27);
	      e.exports = Object("z").propertyIsEnumerable(0) ? Object : function (e) {
	        return "String" == r(e) ? e.split("") : Object(e);
	      };
	    }, function (e, t, n) {
	      var r = n(8),
	        i = n(7);
	      e.exports = function (e) {
	        return r(i(e));
	      };
	    }, function (e, t) {
	      var n = {}.hasOwnProperty;
	      e.exports = function (e, t) {
	        return n.call(e, t);
	      };
	    }, function (e, t, n) {

	      n.r(t);
	      var r = n(0),
	        i = n.n(r),
	        o = {
	          basic: {
	            swatches: ["#1FBC9C", "#1CA085", "#2ECC70", "#27AF60", "#3398DB", "#2980B9", "#A463BF", "#8E43AD", "#3D556E", "#222F3D", "#F2C511", "#F39C19", "#E84B3C", "#C0382B", "#DDE6E8", "#BDC3C8"],
	            rowLength: 4
	          },
	          "text-basic": {
	            swatches: ["#CC0001", "#E36101", "#FFCC00", "#009900", "#0066CB", "#000000", "#FFFFFF"],
	            showBorder: !0
	          },
	          "text-advanced": {
	            swatches: [["#000000", "#434343", "#666666", "#999999", "#b7b7b7", "#cccccc", "#d9d9d9", "#efefef", "#f3f3f3", "#ffffff"], ["#980000", "#ff0000", "#ff9900", "#ffff00", "#00ff00", "#00ffff", "#4a86e8", "#0000ff", "#9900ff", "#ff00ff"], ["#e6b8af", "#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#c9daf8", "#cfe2f3", "#d9d2e9", "#ead1dc"], ["#dd7e6b", "#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#a4c2f4", "#9fc5e8", "#b4a7d6", "#d5a6bd"], ["#cc4125", "#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6d9eeb", "#6fa8dc", "#8e7cc3", "#c27ba0"], ["#a61c00", "#cc0000", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3c78d8", "#3d85c6", "#674ea7", "#a64d79"], ["#85200c", "#990000", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#1155cc", "#0b5394", "#351c75", "#741b47"], ["#5b0f00", "#660000", "#783f04", "#7f6000", "#274e13", "#0c343d", "#1c4587", "#073763", "#20124d", "#4c1130"]],
	            borderRadius: "0",
	            rowLength: 10,
	            swatchSize: 24,
	            spacingSize: 0
	          },
	          "material-basic": {
	            swatches: ["#F44336", "#E91E63", "#9C27B0", "#673AB7", "#3F51B5", "#2196F3", "#03A9F4", "#00BCD4", "#009688", "#4CAF50", "#8BC34A", "#CDDC39", "#FFEB3B", "#FFC107", "#FF9800", "#FF5722", "#795548", "#9E9E9E", "#607D8B"]
	          },
	          "material-light": {
	            swatches: ["#EF9A9A", "#F48FB1", "#CE93D8", "#B39DDB", "#9FA8DA", "#90CAF9", "#81D4FA", "#80DEEA", "#80CBC4", "#A5D6A7", "#C5E1A5", "#E6EE9C", "#FFF59D", "#FFE082", "#FFCC80", "#FFAB91", "#BCAAA4", "#EEEEEE", "#B0BEC5"]
	          },
	          "material-dark": {
	            swatches: ["#D32F2F", "#C2185B", "#7B1FA2", "#512DA8", "#303F9F", "#1976D2", "#0288D1", "#0097A7", "#00796B", "#388E3C", "#689F38", "#AFB42B", "#FBC02D", "#FFA000", "#F57C00", "#E64A19", "#5D4037", "#616161", "#455A64"]
	          }
	        };
	      function s(e, t, n, r, i, o, s, c) {
	        var a = babelHelpers["typeof"]((e = e || {})["default"]);
	        "object" !== a && "function" !== a || (e = e["default"]);
	        var u,
	          l = "function" == typeof e ? e.options : e;
	        if (t && (l.render = t, l.staticRenderFns = n, l._compiled = !0), r && (l.functional = !0), o && (l._scopeId = o), s ? (u = function u(e) {
	          (e = e || this.$vnode && this.$vnode.ssrContext || this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) || "undefined" == typeof __VUE_SSR_CONTEXT__ || (e = __VUE_SSR_CONTEXT__), i && i.call(this, e), e && e._registeredComponents && e._registeredComponents.add(s);
	        }, l._ssrRegister = u) : i && (u = c ? function () {
	          i.call(this, this.$root.$options.shadowRoot);
	        } : i), u) if (l.functional) {
	          l._injectStyles = u;
	          var p = l.render;
	          l.render = function (e, t) {
	            return u.call(t), p(e, t);
	          };
	        } else {
	          var h = l.beforeCreate;
	          l.beforeCreate = h ? [].concat(h, u) : [u];
	        }
	        return {
	          exports: e,
	          options: l
	        };
	      }
	      var c = s({
	        name: "swatches",
	        components: {
	          Swatch: s({
	            name: "swatch",
	            components: {
	              Check: s({
	                name: "check",
	                data: function data() {
	                  return {};
	                }
	              }, function () {
	                var e = this.$createElement,
	                  t = this._self._c || e;
	                return t("div", {
	                  staticClass: "vue-swatches__check__wrapper vue-swatches--has-children-centered"
	                }, [t("div", {
	                  staticClass: "vue-swatches__check__circle vue-swatches--has-children-centered"
	                }, [t("svg", {
	                  staticClass: "check",
	                  attrs: {
	                    version: "1.1",
	                    role: "presentation",
	                    width: "12",
	                    height: "12",
	                    viewBox: "0 0 1792 1792"
	                  }
	                }, [t("path", {
	                  staticClass: "vue-swatches__check__path",
	                  attrs: {
	                    d: "M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"
	                  }
	                })])])]);
	              }, [], !1, function (e) {
	                n(13);
	              }, null, null).exports
	            },
	            props: {
	              borderRadius: {
	                type: String
	              },
	              disabled: {
	                type: Boolean
	              },
	              exceptionMode: {
	                type: String
	              },
	              isException: {
	                type: Boolean,
	                "default": !1
	              },
	              selected: {
	                type: Boolean,
	                "default": !1
	              },
	              showCheckbox: {
	                type: Boolean
	              },
	              showBorder: {
	                type: Boolean
	              },
	              size: {
	                type: Number
	              },
	              spacingSize: {
	                type: Number
	              },
	              swatchColor: {
	                type: String,
	                "default": ""
	              },
	              swatchStyle: {
	                type: Object
	              }
	            },
	            data: function data() {
	              return {};
	            },
	            computed: {
	              computedSwatchStyle: function computedSwatchStyle() {
	                return {
	                  display: this.isException && "hidden" === this.exceptionMode ? "none" : "inline-block",
	                  width: this.size + "px",
	                  height: this.size + "px",
	                  marginBottom: this.spacingSize + "px",
	                  marginRight: this.spacingSize + "px",
	                  borderRadius: this.borderRadius,
	                  backgroundColor: "" !== this.swatchColor ? this.swatchColor : "#FFFFFF",
	                  cursor: this.cursorStyle
	                };
	              },
	              cursorStyle: function cursorStyle() {
	                return this.disabled ? "not-allowed" : this.isException && "disabled" === this.exceptionMode ? "not-allowed" : "pointer";
	              },
	              swatchStyles: function swatchStyles() {
	                return [this.computedSwatchStyle, this.swatchStyle];
	              }
	            }
	          }, function () {
	            var e = this,
	              t = e.$createElement,
	              n = e._self._c || t;
	            return n("div", {
	              staticClass: "vue-swatches__swatch",
	              "class": {
	                "vue-swatches__swatch--border": e.showBorder,
	                "vue-swatches__swatch--selected": e.selected,
	                "vue-swatches__swatch--is-exception": e.isException || e.disabled
	              },
	              style: e.swatchStyles
	            }, ["" === e.swatchColor ? n("div", {
	              staticClass: "vue-swatches__diagonal--wrapper vue-swatches--has-children-centered"
	            }, [n("div", {
	              staticClass: "vue-swatches__diagonal"
	            })]) : e._e(), e._v(" "), n("check", {
	              directives: [{
	                name: "show",
	                rawName: "v-show",
	                value: e.showCheckbox && e.selected,
	                expression: "showCheckbox && selected"
	              }]
	            })], 1);
	          }, [], !1, function (e) {
	            n(15);
	          }, null, null).exports
	        },
	        props: {
	          backgroundColor: {
	            type: String,
	            "default": "#ffffff"
	          },
	          closeOnSelect: {
	            type: Boolean,
	            "default": !0
	          },
	          colors: {
	            type: [Array, Object, String],
	            "default": "basic"
	          },
	          exceptions: {
	            type: Array,
	            "default": function _default() {
	              return [];
	            }
	          },
	          exceptionMode: {
	            type: String,
	            "default": "disabled"
	          },
	          disabled: {
	            type: Boolean,
	            "default": !1
	          },
	          fallbackInputClass: {
	            type: [Array, Object, String],
	            "default": null
	          },
	          fallbackOkClass: {
	            type: [Array, Object, String],
	            "default": null
	          },
	          fallbackOkText: {
	            type: String,
	            "default": "Ok"
	          },
	          inline: {
	            type: Boolean,
	            "default": !1
	          },
	          maxHeight: {
	            type: [Number, String],
	            "default": null
	          },
	          shapes: {
	            type: String,
	            "default": "squares"
	          },
	          popoverTo: {
	            type: String,
	            "default": "right"
	          },
	          rowLength: {
	            type: [Number, String],
	            "default": null
	          },
	          showBorder: {
	            type: Boolean,
	            "default": null
	          },
	          showFallback: {
	            type: Boolean,
	            "default": !1
	          },
	          showCheckbox: {
	            type: Boolean,
	            "default": !0
	          },
	          swatchSize: {
	            type: [Number, String],
	            "default": null
	          },
	          swatchStyle: {
	            type: [Object, Array],
	            "default": function _default() {}
	          },
	          triggerStyle: {
	            type: [Object, Array],
	            "default": function _default() {}
	          },
	          wrapperStyle: {
	            type: [Object, Array],
	            "default": function _default() {}
	          },
	          value: {
	            type: String,
	            "default": null
	          }
	        },
	        data: function data() {
	          return {
	            presetBorderRadius: null,
	            presetMaxHeight: null,
	            presetRowLength: null,
	            presetShowBorder: null,
	            presetSwatchSize: null,
	            presetSpacingSize: null,
	            internalValue: this.value,
	            internalIsOpen: !1
	          };
	        },
	        computed: {
	          isNested: function isNested() {
	            return !!(this.computedColors && this.computedColors.length > 0 && this.computedColors[0] instanceof Array);
	          },
	          isOpen: function isOpen() {
	            return !this.inline && this.internalIsOpen;
	          },
	          isNoColor: function isNoColor() {
	            return this.checkEquality("", this.value);
	          },
	          computedColors: function computedColors() {
	            return this.colors instanceof Array ? this.colors : this.extractSwatchesFromPreset(this.colors);
	          },
	          computedBorderRadius: function computedBorderRadius() {
	            return null !== this.presetBorderRadius ? this.presetBorderRadius : this.borderRadius;
	          },
	          computedExceptionMode: function computedExceptionMode() {
	            return "hidden" === this.exceptionMode ? this.exceptionMode : "disabled" === this.exceptionMode ? this.exceptionMode : void 0;
	          },
	          computedMaxHeight: function computedMaxHeight() {
	            return null !== this.maxHeight ? Number(this.maxHeight) : null !== this.presetMaxHeight ? this.presetMaxHeight : 300;
	          },
	          computedRowLength: function computedRowLength() {
	            return null !== this.rowLength ? Number(this.rowLength) : null !== this.presetRowLength ? this.presetRowLength : 4;
	          },
	          computedSwatchSize: function computedSwatchSize() {
	            return null !== this.swatchSize ? Number(this.swatchSize) : null !== this.presetSwatchSize ? this.presetSwatchSize : 42;
	          },
	          computedSpacingSize: function computedSpacingSize() {
	            return null !== this.presetSpacingSize ? this.presetSpacingSize : this.spacingSize;
	          },
	          computedShowBorder: function computedShowBorder() {
	            return null !== this.showBorder ? this.showBorder : null !== this.presetShowBorder && this.presetShowBorder;
	          },
	          borderRadius: function borderRadius() {
	            return "squares" === this.shapes ? Math.round(.25 * this.computedSwatchSize) + "px" : "circles" === this.shapes ? "50%" : void 0;
	          },
	          spacingSize: function spacingSize() {
	            return Math.round(.25 * this.computedSwatchSize);
	          },
	          wrapperWidth: function wrapperWidth() {
	            return this.computedRowLength * (this.computedSwatchSize + this.computedSpacingSize);
	          },
	          computedtriggerStyle: function computedtriggerStyle() {
	            return {
	              width: "42px",
	              height: "42px",
	              backgroundColor: this.value ? this.value : "#ffffff",
	              borderRadius: "circles" === this.shapes ? "50%" : "10px"
	            };
	          },
	          triggerStyles: function triggerStyles() {
	            return [this.computedtriggerStyle, this.triggerStyle];
	          },
	          containerStyle: function containerStyle() {
	            var e = {
	                backgroundColor: this.backgroundColor
	              },
	              t = {};
	            return this.inline ? e : ("right" === this.popoverTo ? t = {
	              left: 0
	            } : "left" === this.popoverTo && (t = {
	              right: 0
	            }), i()({}, t, e, {
	              maxHeight: this.computedMaxHeight + "px"
	            }));
	          },
	          containerStyles: function containerStyles() {
	            return [this.containerStyle];
	          },
	          computedWrapperStyle: function computedWrapperStyle() {
	            var e = {
	              paddingTop: this.computedSpacingSize + "px",
	              paddingLeft: this.computedSpacingSize + "px"
	            };
	            return this.inline ? e : i()({}, e, {
	              width: this.wrapperWidth + "px"
	            });
	          },
	          wrapperStyles: function wrapperStyles() {
	            return [this.computedWrapperStyle, this.wrapperStyle];
	          },
	          computedFallbackWrapperStyle: function computedFallbackWrapperStyle() {
	            var e = {
	              marginLeft: this.computedSpacingSize + "px",
	              paddingBottom: this.computedSpacingSize + "px"
	            };
	            return this.inline ? e : i()({}, e, {
	              width: this.wrapperWidth - this.computedSpacingSize + "px"
	            });
	          },
	          computedFallbackWrapperStyles: function computedFallbackWrapperStyles() {
	            return [this.computedFallbackWrapperStyle];
	          }
	        },
	        watch: {
	          value: function value(e) {
	            this.internalValue = e;
	          }
	        },
	        methods: {
	          checkEquality: function checkEquality(e, t) {
	            return !(!e && "" !== e || !t && "" !== t) && e.toUpperCase() === t.toUpperCase();
	          },
	          checkException: function checkException(e) {
	            return -1 !== this.exceptions.map(function (e) {
	              return e.toUpperCase();
	            }).indexOf(e.toUpperCase());
	          },
	          hidePopover: function hidePopover() {
	            this.internalIsOpen = !1, this.$el.blur(), this.$emit("close", this.internalValue);
	          },
	          onBlur: function onBlur(e) {
	            this.isOpen && (null !== e && this.$el.contains(e) || (this.internalIsOpen = !1, this.$emit("close", this.internalValue)));
	          },
	          onFallbackButtonClick: function onFallbackButtonClick() {
	            this.hidePopover();
	          },
	          showPopover: function showPopover() {
	            this.isOpen || this.inline || this.disabled || (this.internalIsOpen = !0, this.$el.focus(), this.$emit("open"));
	          },
	          togglePopover: function togglePopover() {
	            this.isOpen ? this.hidePopover() : this.showPopover();
	          },
	          updateSwatch: function updateSwatch(e) {
	            var t = (arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {}).fromFallbackInput;
	            this.checkException(e) || this.disabled || (this.internalValue = e, this.$emit("input", e), !this.closeOnSelect || this.inline || t || this.hidePopover());
	          },
	          extractSwatchesFromPreset: function extractSwatchesFromPreset(e) {
	            var t = null;
	            return (t = e instanceof Object ? e : o[e]).borderRadius && (this.presetBorderRadius = t.borderRadius), t.maxHeight && (this.presetMaxHeight = t.maxHeight), t.rowLength && (this.presetRowLength = t.rowLength), t.showBorder && (this.presetShowBorder = t.showBorder), t.swatchSize && (this.presetSwatchSize = t.swatchSize), (0 === t.spacingSize || t.spacingSize) && (this.presetSpacingSize = t.spacingSize), t.swatches;
	          }
	        }
	      }, function () {
	        var e = this,
	          t = e.$createElement,
	          n = e._self._c || t;
	        return n("div", {
	          staticClass: "vue-swatches",
	          attrs: {
	            tabindex: "0"
	          },
	          on: {
	            blur: function blur(t) {
	              return t.target !== t.currentTarget ? null : (n = t, e.onBlur(n.relatedTarget));
	              var n;
	            }
	          }
	        }, [e.inline ? e._e() : n("div", {
	          ref: "trigger-wrapper",
	          on: {
	            click: e.togglePopover
	          }
	        }, [e._t("trigger", [n("div", {
	          staticClass: "vue-swatches__trigger",
	          "class": {
	            "vue-swatches--is-empty": !e.value,
	            "vue-swatches--is-disabled": e.disabled
	          },
	          style: e.triggerStyles
	        }, [n("div", {
	          directives: [{
	            name: "show",
	            rawName: "v-show",
	            value: e.isNoColor,
	            expression: "isNoColor"
	          }],
	          staticClass: "vue-swatches__diagonal--wrapper vue-swatches--has-children-centered"
	        }, [n("div", {
	          staticClass: "vue-swatches__diagonal"
	        })])])])], 2), e._v(" "), n("transition", {
	          attrs: {
	            name: "vue-swatches-show-hide"
	          }
	        }, [n("div", {
	          directives: [{
	            name: "show",
	            rawName: "v-show",
	            value: e.inline || e.isOpen,
	            expression: "inline || isOpen"
	          }],
	          staticClass: "vue-swatches__container",
	          "class": {
	            "vue-swatches--inline": e.inline
	          },
	          style: e.containerStyles
	        }, [n("div", {
	          staticClass: "vue-swatches__wrapper",
	          style: e.wrapperStyles
	        }, [e.isNested ? e._l(e.computedColors, function (t, r) {
	          return n("div", {
	            key: r,
	            staticClass: "vue-swatches__row"
	          }, e._l(t, function (t) {
	            return n("swatch", {
	              key: t,
	              attrs: {
	                "border-radius": e.computedBorderRadius,
	                disabled: e.disabled,
	                "exception-mode": e.computedExceptionMode,
	                "is-exception": e.checkException(t),
	                selected: e.checkEquality(t, e.value),
	                size: e.computedSwatchSize,
	                "spacing-size": e.computedSpacingSize,
	                "show-border": e.computedShowBorder,
	                "show-checkbox": e.showCheckbox,
	                "swatch-color": t,
	                "swatch-style": e.swatchStyle
	              },
	              nativeOn: {
	                click: function click(n) {
	                  e.updateSwatch(t);
	                }
	              }
	            });
	          }));
	        }) : e._l(e.computedColors, function (t) {
	          return n("swatch", {
	            key: t,
	            attrs: {
	              "border-radius": e.computedBorderRadius,
	              disabled: e.disabled,
	              "exception-mode": e.computedExceptionMode,
	              "is-exception": e.checkException(t),
	              selected: e.checkEquality(t, e.value),
	              size: e.computedSwatchSize,
	              "spacing-size": e.computedSpacingSize,
	              "show-border": e.computedShowBorder,
	              "show-checkbox": e.showCheckbox,
	              "swatch-color": t,
	              "swatch-style": e.swatchStyle
	            },
	            nativeOn: {
	              click: function click(n) {
	                e.updateSwatch(t);
	              }
	            }
	          });
	        })], 2), e._v(" "), e.showFallback ? n("div", {
	          staticClass: "vue-swatches__fallback__wrapper",
	          style: e.computedFallbackWrapperStyles
	        }, [n("span", {
	          staticClass: "vue-swatches__fallback__input--wrapper"
	        }, [n("input", {
	          ref: "fallbackInput",
	          staticClass: "vue-swatches__fallback__input",
	          "class": e.fallbackInputClass,
	          attrs: {
	            type: "text"
	          },
	          domProps: {
	            value: e.internalValue
	          },
	          on: {
	            input: function input(t) {
	              return e.updateSwatch(t.target.value, {
	                fromFallbackInput: !0
	              });
	            }
	          }
	        })]), e._v(" "), n("button", {
	          staticClass: "vue-swatches__fallback__button",
	          "class": e.fallbackOkClass,
	          on: {
	            click: function click(t) {
	              return t.preventDefault(), e.onFallbackButtonClick(t);
	            }
	          }
	        }, [e._v("\n          " + e._s(e.fallbackOkText) + "\n        ")])]) : e._e()])])], 1);
	      }, [], !1, function (e) {
	        n(45);
	      }, null, null).exports;
	      n.d(t, "Swatches", function () {
	        return c;
	      });
	      t["default"] = c;
	    },, function (e, t, n) {},, function (e, t, n) {}, function (e, t, n) {
	      var r = n(7);
	      e.exports = function (e) {
	        return Object(r(e));
	      };
	    }, function (e, t) {
	      t.f = {}.propertyIsEnumerable;
	    }, function (e, t) {
	      t.f = Object.getOwnPropertySymbols;
	    }, function (e, t) {
	      e.exports = "constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf".split(",");
	    }, function (e, t) {
	      var n = 0,
	        r = Math.random();
	      e.exports = function (e) {
	        return "Symbol(".concat(void 0 === e ? "" : e, ")_", (++n + r).toString(36));
	      };
	    }, function (e, t) {
	      e.exports = !0;
	    }, function (e, t, n) {
	      var r = n(4),
	        i = n(5),
	        o = i["__core-js_shared__"] || (i["__core-js_shared__"] = {});
	      (e.exports = function (e, t) {
	        return o[e] || (o[e] = void 0 !== t ? t : {});
	      })("versions", []).push({
	        version: r.version,
	        mode: n(21) ? "pure" : "global",
	        copyright: "В© 2018 Denis Pushkarev (zloirock.ru)"
	      });
	    }, function (e, t, n) {
	      var r = n(22)("keys"),
	        i = n(20);
	      e.exports = function (e) {
	        return r[e] || (r[e] = i(e));
	      };
	    }, function (e, t, n) {
	      var r = n(6),
	        i = Math.max,
	        o = Math.min;
	      e.exports = function (e, t) {
	        return (e = r(e)) < 0 ? i(e + t, 0) : o(e, t);
	      };
	    }, function (e, t, n) {
	      var r = n(6),
	        i = Math.min;
	      e.exports = function (e) {
	        return e > 0 ? i(r(e), 9007199254740991) : 0;
	      };
	    }, function (e, t, n) {
	      var r = n(9),
	        i = n(25),
	        o = n(24);
	      e.exports = function (e) {
	        return function (t, n, s) {
	          var c,
	            a = r(t),
	            u = i(a.length),
	            l = o(s, u);
	          if (e && n != n) {
	            for (; u > l;) if ((c = a[l++]) != c) return !0;
	          } else for (; u > l; l++) if ((e || l in a) && a[l] === n) return e || l || 0;
	          return !e && -1;
	        };
	      };
	    }, function (e, t) {
	      var n = {}.toString;
	      e.exports = function (e) {
	        return n.call(e).slice(8, -1);
	      };
	    }, function (e, t, n) {
	      var r = n(10),
	        i = n(9),
	        o = n(26)(!1),
	        s = n(23)("IE_PROTO");
	      e.exports = function (e, t) {
	        var n,
	          c = i(e),
	          a = 0,
	          u = [];
	        for (n in c) n != s && r(c, n) && u.push(n);
	        for (; t.length > a;) r(c, n = t[a++]) && (~o(u, n) || u.push(n));
	        return u;
	      };
	    }, function (e, t, n) {
	      var r = n(28),
	        i = n(19);
	      e.exports = Object.keys || function (e) {
	        return r(e, i);
	      };
	    }, function (e, t, n) {

	      var r = n(29),
	        i = n(18),
	        o = n(17),
	        s = n(16),
	        c = n(8),
	        a = Object.assign;
	      e.exports = !a || n(1)(function () {
	        var e = {},
	          t = {},
	          n = Symbol(),
	          r = "abcdefghijklmnopqrst";
	        return e[n] = 7, r.split("").forEach(function (e) {
	          t[e] = e;
	        }), 7 != a({}, e)[n] || Object.keys(a({}, t)).join("") != r;
	      }) ? function (e, t) {
	        for (var n = s(e), a = arguments.length, u = 1, l = i.f, p = o.f; a > u;) for (var h, f = c(arguments[u++]), d = l ? r(f).concat(l(f)) : r(f), w = d.length, v = 0; w > v;) p.call(f, h = d[v++]) && (n[h] = f[h]);
	        return n;
	      } : a;
	    }, function (e, t) {
	      e.exports = function (e, t) {
	        return {
	          enumerable: !(1 & e),
	          configurable: !(2 & e),
	          writable: !(4 & e),
	          value: t
	        };
	      };
	    }, function (e, t, n) {
	      var r = n(3);
	      e.exports = function (e, t) {
	        if (!r(e)) return e;
	        var n, i;
	        if (t && "function" == typeof (n = e.toString) && !r(i = n.call(e))) return i;
	        if ("function" == typeof (n = e.valueOf) && !r(i = n.call(e))) return i;
	        if (!t && "function" == typeof (n = e.toString) && !r(i = n.call(e))) return i;
	        throw TypeError("Can't convert object to primitive value");
	      };
	    }, function (e, t, n) {
	      var r = n(3),
	        i = n(5).document,
	        o = r(i) && r(i.createElement);
	      e.exports = function (e) {
	        return o ? i.createElement(e) : {};
	      };
	    }, function (e, t, n) {
	      e.exports = !n(2) && !n(1)(function () {
	        return 7 != Object.defineProperty(n(33)("div"), "a", {
	          get: function get() {
	            return 7;
	          }
	        }).a;
	      });
	    }, function (e, t, n) {
	      var r = n(3);
	      e.exports = function (e) {
	        if (!r(e)) throw TypeError(e + " is not an object!");
	        return e;
	      };
	    }, function (e, t, n) {
	      var r = n(35),
	        i = n(34),
	        o = n(32),
	        s = Object.defineProperty;
	      t.f = n(2) ? Object.defineProperty : function (e, t, n) {
	        if (r(e), t = o(t, !0), r(n), i) try {
	          return s(e, t, n);
	        } catch (e) {}
	        if ("get" in n || "set" in n) throw TypeError("Accessors not supported!");
	        return "value" in n && (e[t] = n.value), e;
	      };
	    }, function (e, t, n) {
	      var r = n(36),
	        i = n(31);
	      e.exports = n(2) ? function (e, t, n) {
	        return r.f(e, t, i(1, n));
	      } : function (e, t, n) {
	        return e[t] = n, e;
	      };
	    }, function (e, t) {
	      e.exports = function (e) {
	        if ("function" != typeof e) throw TypeError(e + " is not a function!");
	        return e;
	      };
	    }, function (e, t, n) {
	      var r = n(38);
	      e.exports = function (e, t, n) {
	        if (r(e), void 0 === t) return e;
	        switch (n) {
	          case 1:
	            return function (n) {
	              return e.call(t, n);
	            };
	          case 2:
	            return function (n, r) {
	              return e.call(t, n, r);
	            };
	          case 3:
	            return function (n, r, i) {
	              return e.call(t, n, r, i);
	            };
	        }
	        return function () {
	          return e.apply(t, arguments);
	        };
	      };
	    }, function (e, t, n) {
	      var r = n(5),
	        i = n(4),
	        o = n(39),
	        s = n(37),
	        c = n(10),
	        a = function a(e, t, n) {
	          var u,
	            l,
	            p,
	            h = e & a.F,
	            f = e & a.G,
	            d = e & a.S,
	            w = e & a.P,
	            v = e & a.B,
	            b = e & a.W,
	            g = f ? i : i[t] || (i[t] = {}),
	            y = g.prototype,
	            S = f ? r : d ? r[t] : (r[t] || {}).prototype;
	          for (u in f && (n = t), n) (l = !h && S && void 0 !== S[u]) && c(g, u) || (p = l ? S[u] : n[u], g[u] = f && "function" != typeof S[u] ? n[u] : v && l ? o(p, r) : b && S[u] == p ? function (e) {
	            var t = function t(_t, n, r) {
	              if (this instanceof e) {
	                switch (arguments.length) {
	                  case 0:
	                    return new e();
	                  case 1:
	                    return new e(_t);
	                  case 2:
	                    return new e(_t, n);
	                }
	                return new e(_t, n, r);
	              }
	              return e.apply(this, arguments);
	            };
	            return t.prototype = e.prototype, t;
	          }(p) : w && "function" == typeof p ? o(Function.call, p) : p, w && ((g.virtual || (g.virtual = {}))[u] = p, e & a.R && y && !y[u] && s(y, u, p)));
	        };
	      a.F = 1, a.G = 2, a.S = 4, a.P = 8, a.B = 16, a.W = 32, a.U = 64, a.R = 128, e.exports = a;
	    }, function (e, t, n) {
	      var r = n(40);
	      r(r.S + r.F, "Object", {
	        assign: n(30)
	      });
	    }, function (e, t, n) {
	      n(41), e.exports = n(4).Object.assign;
	    }, function (e, t, n) {
	      e.exports = {
	        "default": n(42),
	        __esModule: !0
	      };
	    },, function (e, t, n) {}]);
	  });
	});
	var Swatches = unwrapExports(vueSwatches_min);
	var vueSwatches_min_1 = vueSwatches_min.VueSwatches;

	function _regeneratorRuntime() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == babelHelpers["typeof"](value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
	var defaultColor = '#5867dd';
	var script = {
	  components: {
	    Swatches: Swatches
	  },
	  props: {
	    items: Array,
	    useSharing: {
	      type: Boolean,
	      "default": false
	    }
	  },
	  data: function data() {
	    return {
	      colors: ["#5867DD", "#D32F2F", "#C2185B", "#7B1FA2", "#512DA8", "#303F9F", "#1976D2", "#0288D1", "#0097A7", "#00796B", "#388E3C", "#689F38", "#AFB42B", "#FBC02D", "#FFA000", "#F57C00", "#E64A19", "#5D4037", "#616161", "#455A64"],
	      modal: {
	        title: ''
	      },
	      editable: {
	        id: null,
	        name: '',
	        color: defaultColor
	      },
	      shareLink: ''
	    };
	  },
	  computed: {
	    selected: function selected() {
	      return this.data.find(function (item) {
	        return item.SELECTED;
	      });
	    },
	    data: function data() {
	      var _this = this;
	      return this.items.map(function (item) {
	        item.STYLES = _this.btnStyles(item);
	        return item;
	      });
	    },
	    messages: function messages() {
	      return Object.freeze(Object.keys(BX.message).filter(function (message) {
	        return message.startsWith('RS_B2BPORTAL_BS_');
	      }).reduce(function (obj, message) {
	        obj[message.slice(message)] = BX.message(message);
	        return obj;
	      }, {}));
	    }
	  },
	  mounted: function mounted() {
	    var _this2 = this;
	    $(this.$refs.modal).on('shown.bs.modal', function () {
	      _this2.$refs.nameInput.focus();
	    });
	    $(this.$refs.modal).on('hidden.bs.modal', function () {
	      _this2.editable = {
	        id: null,
	        name: '',
	        color: defaultColor
	      };
	    });
	  },
	  methods: {
	    btnStyles: function btnStyles(item) {
	      var classes = {};
	      classes['btn-basket'] = true;
	      return classes;
	    },
	    add: function add() {
	      this.modal.title = this.messages.RS_B2BPORTAL_BS_CREATE;
	      this.editable.name = this.messages.RS_B2BPORTAL_BS_BASKET + ' #' + (this.data.length + 1);
	      $(this.$refs.modal).modal();
	    },
	    edit: function edit(item) {
	      this.modal.title = this.messages.RS_B2BPORTAL_BS_UPDATE;
	      this.editable.id = item.CODE;
	      this.editable.name = item.NAME;
	      this.editable.color = item.COLOR != '' ? item.COLOR : defaultColor;
	      $(this.$refs.modal).modal();
	    },
	    share: function share(item) {
	      var _this3 = this;
	      return babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
	        var result;
	        return _regeneratorRuntime().wrap(function _callee$(_context) {
	          while (1) switch (_context.prev = _context.next) {
	            case 0:
	              _context.next = 2;
	              return BX.ajax.runAction('redsign:vbasket.controller.sharecontroller.getLink', {
	                data: {
	                  code: item.CODE
	                }
	              });
	            case 2:
	              result = _context.sent;
	              if ((result.data || {}).isSuccess) {
	                _this3.shareLink = result.data.link;
	                $(_this3.$refs.shareModal).modal();
	              }
	            case 4:
	            case "end":
	              return _context.stop();
	          }
	        }, _callee);
	      }))();
	    },
	    copyShareLink: function copyShareLink() {
	      this.$refs.shareLinkInput.select();
	      this.$refs.shareLinkInput.focus();
	      document.execCommand('copy');
	    },
	    save: function save() {
	      var _this4 = this;
	      return babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
	        var data, result;
	        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
	          while (1) switch (_context2.prev = _context2.next) {
	            case 0:
	              data = {
	                code: _this4.editable.id,
	                name: _this4.editable.name,
	                color: _this4.editable.color
	              };
	              KTApp.block(_this4.$refs.modal);
	              _context2.next = 4;
	              return B2BPortal.store.dispatch('saveBasket', data);
	            case 4:
	              result = _context2.sent;
	              if (result && result.isSuccess) {
	                $(_this4.$refs.modal).modal('hide');
	                if (_this4.editable.id === null) {
	                  B2BPortal.store.dispatch('selectBasket', result.code);
	                }
	              }
	              KTApp.unblock(_this4.$refs.modal);
	            case 7:
	            case "end":
	              return _context2.stop();
	          }
	        }, _callee2);
	      }))();
	    },
	    remove: function remove(code) {
	      var _this5 = this;
	      return babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
	        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
	          while (1) switch (_context3.prev = _context3.next) {
	            case 0:
	              if (!confirm(_this5.messages.RS_B2BPORTAL_BS_REMOVE_CONFIRM)) {
	                _context3.next = 3;
	                break;
	              }
	              _context3.next = 3;
	              return B2BPortal.store.dispatch('removeBasket', code);
	            case 3:
	            case "end":
	              return _context3.stop();
	          }
	        }, _callee3);
	      }))();
	    },
	    select: function select(code) {
	      return babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
	        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
	          while (1) switch (_context4.prev = _context4.next) {
	            case 0:
	              _context4.next = 2;
	              return B2BPortal.store.dispatch('selectBasket', code);
	            case 2:
	            case "end":
	              return _context4.stop();
	          }
	        }, _callee4);
	      }))();
	    }
	  }
	};

	function normalizeComponent(template, style, script, scopeId, isFunctionalTemplate, moduleIdentifier
	/* server only */, shadowMode, createInjector, createInjectorSSR, createInjectorShadow) {
	  if (typeof shadowMode !== 'boolean') {
	    createInjectorSSR = createInjector;
	    createInjector = shadowMode;
	    shadowMode = false;
	  } // Vue.extend constructor export interop.

	  var options = typeof script === 'function' ? script.options : script; // render functions

	  if (template && template.render) {
	    options.render = template.render;
	    options.staticRenderFns = template.staticRenderFns;
	    options._compiled = true; // functional template

	    if (isFunctionalTemplate) {
	      options.functional = true;
	    }
	  } // scopedId

	  if (scopeId) {
	    options._scopeId = scopeId;
	  }
	  var hook;
	  if (moduleIdentifier) {
	    // server build
	    hook = function hook(context) {
	      // 2.3 injection
	      context = context ||
	      // cached call
	      this.$vnode && this.$vnode.ssrContext ||
	      // stateful
	      this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext; // functional
	      // 2.2 with runInNewContext: true

	      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
	        context = __VUE_SSR_CONTEXT__;
	      } // inject component styles

	      if (style) {
	        style.call(this, createInjectorSSR(context));
	      } // register component module identifier for async chunk inference

	      if (context && context._registeredComponents) {
	        context._registeredComponents.add(moduleIdentifier);
	      }
	    }; // used by ssr in case component is cached and beforeCreate
	    // never gets called

	    options._ssrRegister = hook;
	  } else if (style) {
	    hook = shadowMode ? function () {
	      style.call(this, createInjectorShadow(this.$root.$options.shadowRoot));
	    } : function (context) {
	      style.call(this, createInjector(context));
	    };
	  }
	  if (hook) {
	    if (options.functional) {
	      // register for functional component in vue file
	      var originalRender = options.render;
	      options.render = function renderWithStyleInjection(h, context) {
	        hook.call(context);
	        return originalRender(h, context);
	      };
	    } else {
	      // inject component registration as beforeCreate hook
	      var existing = options.beforeCreate;
	      options.beforeCreate = existing ? [].concat(existing, hook) : [hook];
	    }
	  }
	  return script;
	}
	var normalizeComponent_1 = normalizeComponent;

	var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\\b/.test(navigator.userAgent.toLowerCase());
	function createInjector(context) {
	  return function (id, style) {
	    return addStyle(id, style);
	  };
	}
	var HEAD;
	var styles = {};
	function addStyle(id, css) {
	  var group = isOldIE ? css.media || 'default' : id;
	  var style = styles[group] || (styles[group] = {
	    ids: new Set(),
	    styles: []
	  });
	  if (!style.ids.has(id)) {
	    style.ids.add(id);
	    var code = css.source;
	    if (css.map) {
	      // https://developer.chrome.com/devtools/docs/javascript-debugging
	      // this makes source maps inside style tags work properly in Chrome
	      code += '\n/*# sourceURL=' + css.map.sources[0] + ' */'; // http://stackoverflow.com/a/26603875

	      code += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(css.map)))) + ' */';
	    }
	    if (!style.element) {
	      style.element = document.createElement('style');
	      style.element.type = 'text/css';
	      if (css.media) style.element.setAttribute('media', css.media);
	      if (HEAD === undefined) {
	        HEAD = document.head || document.getElementsByTagName('head')[0];
	      }
	      HEAD.appendChild(style.element);
	    }
	    if ('styleSheet' in style.element) {
	      style.styles.push(code);
	      style.element.styleSheet.cssText = style.styles.filter(Boolean).join('\n');
	    } else {
	      var index = style.ids.size - 1;
	      var textNode = document.createTextNode(code);
	      var nodes = style.element.childNodes;
	      if (nodes[index]) style.element.removeChild(nodes[index]);
	      if (nodes.length) style.element.insertBefore(textNode, nodes[index]);else style.element.appendChild(textNode);
	    }
	  }
	}
	var browser = createInjector;

	/* script */
	var __vue_script__ = script;

	/* template */
	var __vue_render__ = function __vue_render__() {
	  var _vm = this;
	  var _h = _vm.$createElement;
	  var _c = _vm._self._c || _h;
	  return _c("div", {
	    staticClass: "kt-section d-flex flex-wrap"
	  }, [_vm._l(_vm.data, function (item, index) {
	    return _c("div", {
	      key: index,
	      staticClass: "d-inline-block my-2 mr-2"
	    }, [_c("div", {
	      staticClass: "btn-group btn-basket-group",
	      "class": {
	        "btn-basket-group--active": item.SELECTED
	      },
	      style: {
	        color: item.COLOR
	      }
	    }, [_c("a", {
	      staticClass: "btn",
	      attrs: {
	        href: "#"
	      },
	      on: {
	        click: function click($event) {
	          $event.preventDefault();
	          return _vm.select(item.CODE);
	        }
	      }
	    }, [_c("span", {
	      staticClass: "btn-basket-text"
	    }, [_vm._v("\n\t\t\t\t\t" + _vm._s(item.NAME) + " \n\t\t\t\t\t"), item.CNT ? _c("span", {
	      staticClass: "kt-badge kt-badge--primary ml-2",
	      style: {
	        background: item.COLOR
	      }
	    }, [_vm._v(_vm._s(item.CNT))]) : _vm._e()])]), _vm._v(" "), _vm.useSharing && item.SELECTED && item.CNT ? _c("a", {
	      staticClass: "btn btn-basket-icon",
	      attrs: {
	        href: "#"
	      },
	      on: {
	        click: function click($event) {
	          $event.preventDefault();
	          return _vm.share(item);
	        }
	      }
	    }, [_c("i", {
	      staticClass: "la la-link pr-0"
	    })]) : _vm._e(), _vm._v(" "), item.SELECTED ? _c("a", {
	      staticClass: "btn btn-basket-icon",
	      attrs: {
	        href: "#"
	      },
	      on: {
	        click: function click($event) {
	          $event.preventDefault();
	          return _vm.edit(item);
	        }
	      }
	    }, [_c("i", {
	      staticClass: "la la-pencil pr-0"
	    })]) : _vm._e(), _vm._v(" "), item.SELECTED && _vm.data.length > 1 ? _c("a", {
	      staticClass: "btn btn-basket-icon",
	      attrs: {
	        href: "#"
	      },
	      on: {
	        click: function click($event) {
	          $event.preventDefault();
	          return _vm.remove(item.CODE);
	        }
	      }
	    }, [_c("i", {
	      staticClass: "la la-remove pr-0"
	    })]) : _vm._e()])]);
	  }), _vm._v(" "), _c("div", {
	    staticClass: "d-inline-block my-2 ml-2"
	  }, [_c("a", {
	    staticClass: "btn text-secondary",
	    attrs: {
	      href: "#"
	    },
	    on: {
	      click: function click($event) {
	        $event.preventDefault();
	        return _vm.add();
	      }
	    }
	  }, [_c("i", {
	    staticClass: "flaticon2-plus pr-0"
	  })])]), _vm._v(" "), _c("div", {
	    ref: "modal",
	    staticClass: "modal fade",
	    staticStyle: {
	      display: "none"
	    },
	    attrs: {
	      "aria-hidden": "true"
	    }
	  }, [_c("div", {
	    staticClass: "modal-dialog modal-dialog-centered",
	    attrs: {
	      role: "document"
	    }
	  }, [_c("div", {
	    staticClass: "modal-content"
	  }, [_c("div", {
	    staticClass: "modal-header"
	  }, [_c("h5", {
	    staticClass: "modal-title"
	  }, [_vm._v(_vm._s(_vm.modal.title))]), _vm._v(" "), _c("button", {
	    staticClass: "close",
	    attrs: {
	      type: "button",
	      "data-dismiss": "modal",
	      "aria-label": "Close"
	    }
	  })]), _vm._v(" "), _c("div", {
	    staticClass: "modal-body"
	  }, [_c("div", {
	    staticClass: "form-group"
	  }, [_c("input", {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: _vm.editable.name,
	      expression: "editable.name"
	    }],
	    ref: "nameInput",
	    staticClass: "form-control",
	    attrs: {
	      type: "new_cart_name",
	      placeholder: _vm.messages.RS_B2BPORTAL_BS_BASKET
	    },
	    domProps: {
	      value: _vm.editable.name
	    },
	    on: {
	      keyup: function keyup($event) {
	        if (!$event.type.indexOf("key") && _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")) {
	          return null;
	        }
	        return _vm.save($event);
	      },
	      input: function input($event) {
	        if ($event.target.composing) {
	          return;
	        }
	        _vm.$set(_vm.editable, "name", $event.target.value);
	      }
	    }
	  })]), _vm._v(" "), _c("div", {
	    staticClass: "form-group mb-0"
	  }, [_c("swatches", {
	    attrs: {
	      "popover-to": "left",
	      colors: _vm.colors,
	      "swatch-size": "35",
	      "wrapper-style": {
	        paddingRight: "0px",
	        paddingTop: "0px",
	        textAlign: "center"
	      },
	      inline: ""
	    },
	    model: {
	      value: _vm.editable.color,
	      callback: function callback($$v) {
	        _vm.$set(_vm.editable, "color", $$v);
	      },
	      expression: "editable.color"
	    }
	  })], 1)]), _vm._v(" "), _c("div", {
	    staticClass: "modal-footer"
	  }, [_c("button", {
	    staticClass: "btn btn-outline-brand",
	    attrs: {
	      type: "button",
	      "data-dismiss": "modal"
	    }
	  }, [_vm._v(_vm._s(_vm.messages.RS_B2BPORTAL_BS_CANCEL))]), _vm._v(" "), _c("button", {
	    staticClass: "btn btn-primary",
	    attrs: {
	      type: "button"
	    },
	    on: {
	      click: function click($event) {
	        $event.preventDefault();
	        return _vm.save($event);
	      }
	    }
	  }, [_vm._v(_vm._s(_vm.messages.RS_B2BPORTAL_BS_SAVE))])])])])]), _vm._v(" "), _vm.useSharing ? _c("div", {
	    ref: "shareModal",
	    staticClass: "modal fade",
	    staticStyle: {
	      display: "none"
	    },
	    attrs: {
	      "aria-hidden": "true"
	    }
	  }, [_c("div", {
	    staticClass: "modal-dialog modal-dialog-centered",
	    attrs: {
	      role: "document"
	    }
	  }, [_c("div", {
	    staticClass: "modal-content"
	  }, [_c("div", {
	    staticClass: "modal-header"
	  }, [_c("h5", {
	    staticClass: "modal-title"
	  }, [_vm._v(_vm._s(_vm.messages.RS_B2BPORTAL_BS_SHARE_MODAL_TITLE))]), _vm._v(" "), _c("button", {
	    staticClass: "close",
	    attrs: {
	      type: "button",
	      "data-dismiss": "modal",
	      "aria-label": "Close"
	    }
	  })]), _vm._v(" "), _c("div", {
	    staticClass: "modal-body"
	  }, [_c("div", {
	    staticClass: "form-group mb-0"
	  }, [_c("label", [_vm._v(_vm._s(_vm.messages.RS_B2BPORTAL_BS_SHARE_MODAL_LABEL))]), _vm._v(" "), _c("div", {
	    staticClass: "d-flex"
	  }, [_c("input", {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: _vm.shareLink,
	      expression: "shareLink"
	    }],
	    ref: "shareLinkInput",
	    staticClass: "form-control",
	    attrs: {
	      type: "text"
	    },
	    domProps: {
	      value: _vm.shareLink
	    },
	    on: {
	      input: function input($event) {
	        if ($event.target.composing) {
	          return;
	        }
	        _vm.shareLink = $event.target.value;
	      }
	    }
	  }), _vm._v(" "), _c("button", {
	    staticClass: "btn btn-primary ml-2",
	    on: {
	      click: function click($event) {
	        return _vm.copyShareLink();
	      }
	    }
	  }, [_vm._v(" " + _vm._s(_vm.messages.RS_B2BPORTAL_BS_SHARE_MODAL_COPY_LINK) + " ")])])])])])])]) : _vm._e()], 2);
	};
	var __vue_staticRenderFns__ = [];
	__vue_render__._withStripped = true;

	/* style */
	var __vue_inject_styles__ = function __vue_inject_styles__(inject) {
	  if (!inject) return;
	  inject("data-v-44831888_0", {
	    source: ".btn-basket-group[data-v-44831888] {\n  border-bottom: 1px solid #e1e1ef;\n  color: #e1e1ef;\n}\n.btn-basket-group--active[data-v-44831888] {\n  border-bottom-color: currentColor;\n  font-weight: bold;\n}\n.btn-basket-text[data-v-44831888] {\n  color: #586272;\n}\n.btn:hover > .btn-basket-text[data-v-44831888] {\n  color: #212529;\n}\n.btn-basket-icon[data-v-44831888] {\n  color: #e1e1ef;\n  padding-left: 7px;\n  padding-right: 7px;\n}\n.btn-basket-icon [class^=flaticon2-][data-v-44831888] {\n  font-size: 1rem;\n}\n.btn-basket-icon[data-v-44831888]:hover, .btn-basket-icon[data-v-44831888]:focus, .btn-basket-icon[data-v-44831888]:active {\n  color: currentColor;\n}",
	    map: undefined,
	    media: undefined
	  });
	};
	/* scoped */
	var __vue_scope_id__ = "data-v-44831888";
	/* module identifier */
	var __vue_module_identifier__ = undefined;
	/* functional template */
	var __vue_is_functional_template__ = false;
	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__ = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__,
	  staticRenderFns: __vue_staticRenderFns__
	}, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, false, browser, undefined, undefined);

	var BasketSelect = /*#__PURE__*/function () {
	  function BasketSelect(element, params) {
	    babelHelpers.classCallCheck(this, BasketSelect);
	    this.element = element;
	    this.params = params;
	    this.attachTemplate();
	  }
	  babelHelpers.createClass(BasketSelect, [{
	    key: "attachTemplate",
	    value: function attachTemplate() {
	      var params = this.params;
	      this.template = new Vue({
	        el: this.element,
	        store: B2BPortal.store,
	        components: {
	          VueBasketSelect: __vue_component__
	        },
	        data: function data() {
	          return {
	            params: params
	          };
	        },
	        computed: {
	          baskets: function baskets() {
	            return this.$store.state.baskets;
	          }
	        },
	        template: "<vue-basket-select :items=\"baskets\" :useSharing=\"params.useSharing\"/>\t"
	      });
	    }
	  }]);
	  return BasketSelect;
	}();

	exports.BasketSelect = BasketSelect;

}((this.B2BPortal.Components = this.B2BPortal.Components || {})));
//# sourceMappingURL=component.js.map
