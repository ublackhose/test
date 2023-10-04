/* eslint-disable */
this.B2BPortal = this.B2BPortal || {};
(function (exports) {
	'use strict';

	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//

	var script = {
	  props: {
	    basketUrl: String
	  },
	  computed: {
	    selectedBasket: function selectedBasket() {
	      return this.$store.getters.selectedBasket;
	    },
	    baskets: function baskets() {
	      return this.$store.getters.notSelectedBaskets;
	    },
	    selectedColorClass: function selectedColorClass() {
	      return this.getColorClass(this.selectedBasket);
	    }
	  },
	  methods: {
	    getColorClass: function getColorClass(basket) {
	      return basket.COLOR ? 'btn-colored--' + basket.COLOR.toLowerCase().replace('#', '') : '';
	    },
	    onClick: function onClick(code) {
	      KTApp.blockPage();
	      this.$store.dispatch('selectBasket', code);
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
	    staticClass: "btn-group"
	  }, [_c("a", {
	    staticClass: "btn btn-primary btn-vbasket text-nowrap",
	    "class": _vm.selectedColorClass,
	    attrs: {
	      href: _vm.basketUrl,
	      title: _vm.selectedBasket.NAME
	    }
	  }, [_c("i", {
	    staticClass: "flaticon2-shopping-cart-1 btn-vbasket__icon"
	  }), _vm._v(" "), _c("span", {
	    staticClass: "btn-vbasket__name"
	  }, [_vm._v(_vm._s(_vm.selectedBasket.NAME) + " ")]), _vm._v(" "), _vm.selectedBasket.CNT ? _c("span", {
	    staticClass: "kt-badge kt-badge--primary ml-2 btn-vbasket__badge"
	  }, [_vm._v(_vm._s(_vm.selectedBasket.CNT))]) : _vm._e()]), _vm._v(" "), _vm.baskets.length > 0 ? [_c("button", {
	    staticClass: "btn btn-primary dropdown-toggle dropdown-toggle-split",
	    "class": _vm.selectedColorClass,
	    attrs: {
	      type: "button",
	      "data-toggle": "dropdown",
	      "aria-haspopup": "true",
	      "aria-expanded": "true"
	    }
	  }), _vm._v(" "), _c("div", {
	    staticClass: "dropdown-menu dropdown-menu-right",
	    attrs: {
	      "x-placement": "bottom-end"
	    }
	  }, _vm._l(_vm.baskets, function (basket) {
	    return _c("a", {
	      key: basket.ID,
	      staticClass: "dropdown-item",
	      on: {
	        click: function click($event) {
	          return _vm.onClick(basket.CODE);
	        }
	      }
	    }, [_vm._v("\n\t\t\t\t" + _vm._s(basket.NAME) + " \n\t\t\t\t"), basket.CNT ? _c("span", {
	      staticClass: "kt-badge kt-badge--primary ml-2",
	      style: {
	        background: basket.COLOR
	      }
	    }, [_vm._v(_vm._s(basket.CNT))]) : _vm._e()]);
	  }), 0)] : _vm._e()], 2);
	};
	var __vue_staticRenderFns__ = [];
	__vue_render__._withStripped = true;

	/* style */
	var __vue_inject_styles__ = function __vue_inject_styles__(inject) {
	  if (!inject) return;
	  inject("data-v-50f09dba_0", {
	    source: "\n.btn-vbasket[data-v-50f09dba] {}\n.btn-vbasket__name[data-v-50f09dba] {\n\tdisplay: inline-block;\n\tvertical-align: middle;\n\tmax-width: 88px;\n\toverflow: hidden;\n\ttext-overflow: ellipsis;\n}\n.kt-badge.btn-vbasket__badge[data-v-50f09dba] {\n\tbackground-color: #fff; \n\tcolor: #000;\n}\n",
	    map: undefined,
	    media: undefined
	  });
	};
	/* scoped */
	var __vue_scope_id__ = "data-v-50f09dba";
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

	var BasketsGlobal = /*#__PURE__*/function () {
	  function BasketsGlobal(params) {
	    babelHelpers.classCallCheck(this, BasketsGlobal);
	    this.el = params.el;
	    this.baskets = params.baskets;
	    this.basketUrl = params.basketUrl;
	    this.initBaskets();
	    this.onEvents();
	    this.attachTemplate();
	  }
	  babelHelpers.createClass(BasketsGlobal, [{
	    key: "initBaskets",
	    value: function initBaskets() {
	      B2BPortal.store.commit('SET_BASKETS', this.baskets);
	    }
	  }, {
	    key: "onEvents",
	    value: function onEvents() {
	      BX.addCustomEvent('updateBasketComponent', function () {
	        B2BPortal.store.dispatch('fetchBasket');
	      });
	    }
	  }, {
	    key: "attachTemplate",
	    value: function attachTemplate() {
	      var basketUrl = this.basketUrl;
	      this.template = new Vue({
	        el: this.el,
	        components: {
	          BasketSelectDropdown: __vue_component__
	        },
	        store: B2BPortal.store,
	        data: function data() {
	          return {
	            basketUrl: basketUrl
	          };
	        },
	        template: "<BasketSelectDropdown :basketUrl=\"basketUrl\" />"
	      });
	    }
	  }]);
	  return BasketsGlobal;
	}();

	exports.BasketsGlobal = BasketsGlobal;

}((this.B2BPortal.Components = this.B2BPortal.Components || {})));
//# sourceMappingURL=component.js.map
