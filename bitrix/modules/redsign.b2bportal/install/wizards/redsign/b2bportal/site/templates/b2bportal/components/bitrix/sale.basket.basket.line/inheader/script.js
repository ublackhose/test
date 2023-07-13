(function (exports) {
	'use strict';

	function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

	function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { babelHelpers.defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

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
	  computed: _objectSpread(_objectSpread({}, Vuex.mapGetters({
	    selected: 'multicart/selected',
	    items: 'multicart/notSelected'
	  })), {}, {
	    canToggle: function canToggle() {
	      return !!this.items.length;
	    }
	  }),
	  methods: {
	    select: function select(_ref) {
	      var _this = this;

	      var CODE = _ref.CODE;
	      this.$store.dispatch('multicart/select', CODE).then(function () {
	        return _this.$store.dispatch('cart/fetch');
	      });
	    }
	  }
	};

	function normalizeComponent(template, style, script, scopeId, isFunctionalTemplate, moduleIdentifier
	/* server only */
	, shadowMode, createInjector, createInjectorSSR, createInjectorShadow) {
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
	      context = context || // cached call
	      this.$vnode && this.$vnode.ssrContext || // stateful
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

	/* script */
	var __vue_script__ = script;
	/* template */

	var __vue_render__ = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", {
	    staticClass: "dropdown"
	  }, [_c("button", {
	    staticClass: "btn btn-clean",
	    "class": {
	      "dropdown-toggle": _vm.canToggle
	    },
	    style: {
	      color: _vm.selected.COLOR
	    },
	    attrs: {
	      type: "button",
	      "data-toggle": "dropdown",
	      "data-offset": "0,2px"
	    }
	  }, [_vm._v("\n\t\t" + _vm._s(_vm.selected.NAME) + "\n\t")]), _vm._v(" "), _vm.canToggle ? _c("div", {
	    staticClass: "dropdown-menu",
	    attrs: {
	      "x-placement": "bottom-end"
	    }
	  }, _vm._l(_vm.items, function (item) {
	    return _c("a", {
	      key: item.ID,
	      staticClass: "dropdown-item",
	      attrs: {
	        href: "#"
	      },
	      on: {
	        click: function click($event) {
	          $event.preventDefault();
	          return _vm.select(item);
	        }
	      }
	    }, [_vm._v("\n\t\t\t" + _vm._s(item.NAME) + " \n\t\t\t"), item.CNT ? _c("span", {
	      staticClass: "kt-badge kt-badge--primary ml-2",
	      style: {
	        background: item.COLOR
	      }
	    }, [_vm._v("\n\t\t\t\t" + _vm._s(item.CNT) + "\n\t\t\t")]) : _vm._e()]);
	  }), 0) : _vm._e()]);
	};

	var __vue_staticRenderFns__ = [];
	__vue_render__._withStripped = true;
	/* style */

	var __vue_inject_styles__ = undefined;
	/* scoped */

	var __vue_scope_id__ = undefined;
	/* module identifier */

	var __vue_module_identifier__ = undefined;
	/* functional template */

	var __vue_is_functional_template__ = false;
	/* style inject */

	/* style inject SSR */

	var QuickBasketSelect = normalizeComponent_1({
	  render: __vue_render__,
	  staticRenderFns: __vue_staticRenderFns__
	}, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, undefined, undefined);

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
	var script$1 = {
	  computed: {
	    messages: function messages() {
	      return Object.freeze({
	        RS_B2B_SBBL_EMPTY_BASKET_TITLE: BX.message('RS_B2B_SBBL_EMPTY_BASKET_TITLE')
	      });
	    }
	  }
	};

	/* script */
	var __vue_script__$1 = script$1;
	/* template */

	var __vue_render__$1 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", {
	    staticClass: "text-center py-5 text-black-50"
	  }, [_c("div", {
	    staticClass: "mb-4"
	  }, [_c("svg", {
	    attrs: {
	      xmlns: "http://www.w3.org/2000/svg",
	      width: "129.188",
	      height: "114.562",
	      viewBox: "0 0 129.188 114.562"
	    }
	  }, [_c("path", {
	    attrs: {
	      fill: "currentColor",
	      "fill-rule": "evenodd",
	      d: "M710.628,516.914a12.689,12.689,0,0,0,0,25.378A12.689,12.689,0,1,0,710.628,516.914Zm67.374,0a12.689,12.689,0,1,0,0,25.378A12.689,12.689,0,0,0,778,516.914Zm19.942-70.42a5.206,5.206,0,0,0-4.068-1.949H698.271L693.3,431.107a5.206,5.206,0,0,0-4.88-3.4H675.11a5.206,5.206,0,0,0,0,10.411h9.683L709.557,505a5.2,5.2,0,0,0,4.88,3.389c0.207,0,.417-0.013.624-0.027l69.421-8.331a5.218,5.218,0,0,0,4.473-4.046l10.019-45.108A5.215,5.215,0,0,0,797.944,446.494Zm-14.018,24.079h-20.8V454.956H787.4Zm-46.826,0V454.956h20.825v15.617H737.1Zm20.825,5.205v16.953L737.1,495.225V475.771h20.825v0.007Zm-26.031-20.822v15.617H707.906l-5.781-15.617h29.769Zm-22.059,20.822h22.059v20.084l-14,1.681Zm53.3,16.329V475.778h19.643l-3.186,14.35Z",
	      transform: "translate(-669.906 -427.719)"
	    }
	  })])]), _vm._v(" "), _c("div", {
	    staticClass: "h2"
	  }, [_vm._v("\n\t\t" + _vm._s(_vm.messages.RS_B2B_SBBL_EMPTY_BASKET_TITLE) + "\n\t")])]);
	};

	var __vue_staticRenderFns__$1 = [];
	__vue_render__$1._withStripped = true;
	/* style */

	var __vue_inject_styles__$1 = undefined;
	/* scoped */

	var __vue_scope_id__$1 = undefined;
	/* module identifier */

	var __vue_module_identifier__$1 = undefined;
	/* functional template */

	var __vue_is_functional_template__$1 = false;
	/* style inject */

	/* style inject SSR */

	var QuickBasketEmpty = normalizeComponent_1({
	  render: __vue_render__$1,
	  staticRenderFns: __vue_staticRenderFns__$1
	}, __vue_inject_styles__$1, __vue_script__$1, __vue_scope_id__$1, __vue_is_functional_template__$1, __vue_module_identifier__$1, undefined, undefined);

	//
	var script$2 = {
	  components: {
	    QuickBasketEmpty: QuickBasketEmpty
	  },
	  props: {
	    isShowed: {
	      type: Boolean,
	      "default": false
	    },
	    pathToBasket: {
	      type: String,
	      "default": ''
	    },
	    pathToOrder: {
	      type: String,
	      "default": ''
	    },
	    signedParameters: {
	      type: String,
	      "default": ''
	    }
	  },
	  data: function data() {
	    return {
	      loaded: false,
	      needRefresh: false,
	      categories: {}
	    };
	  },
	  created: function created() {
	    var _this = this;

	    this.load();
	    this.unsubscribe = this.$store.subscribeAction(function (action, state) {
	      if (action.type !== 'cart/fetch') return;

	      if (_this.isShowed) {
	        _this.refresh();
	      } else {
	        _this.needRefresh = true;
	      }
	    });
	  },
	  beforeDestroy: function beforeDestroy() {
	    this.unsubscribe();
	  },
	  computed: {
	    messages: function messages() {
	      return Object.freeze({
	        'RS_B2B_SBBL_TO_ORDER': BX.message('RS_B2B_SBBL_TO_ORDER'),
	        'RS_B2B_SBBL_TO_BASKET': BX.message('RS_B2B_SBBL_TO_BASKET')
	      });
	    },
	    readyProducts: function readyProducts() {
	      return this.categories.ready || [];
	    }
	  },
	  methods: {
	    load: function load() {
	      var _this2 = this;

	      return babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee() {
	        var result;
	        return regeneratorRuntime.wrap(function _callee$(_context) {
	          while (1) {
	            switch (_context.prev = _context.next) {
	              case 0:
	                _context.prev = 0;
	                _context.next = 3;
	                return new Promise(function (resolve, reject) {
	                  var signedParameters = _this2.signedParameters;
	                  var data = {
	                    c: 'sale.basket.basket.line'
	                  };
	                  BX.ajax.runAction('redsign:b2bportal.api.cart.getItems', {
	                    signedParameters: signedParameters,
	                    data: data
	                  }).then(resolve, reject);
	                });

	              case 3:
	                result = _context.sent;
	                _this2.loaded = true;
	                _this2.categories = result.data;
	                return _context.abrupt("return", result);

	              case 9:
	                _context.prev = 9;
	                _context.t0 = _context["catch"](0);
	                console.error(_context.t0);

	              case 12:
	                return _context.abrupt("return", false);

	              case 13:
	              case "end":
	                return _context.stop();
	            }
	          }
	        }, _callee, null, [[0, 9]]);
	      }))();
	    },
	    refresh: function refresh() {
	      var _this3 = this;

	      return this.load().then(function (res) {
	        _this3.$emit('refreshed');

	        return res;
	      });
	    }
	  },
	  watch: {
	    isShowed: function isShowed(val) {
	      if (val && this.needRefresh) this.refresh();
	    }
	  }
	};

	/* script */
	var __vue_script__$2 = script$2;
	/* template */

	var __vue_render__$2 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [!_vm.loaded ? _c("div", {
	    staticClass: "p-5 d-flex align-items-center justify-content-center"
	  }, [_c("div", {
	    staticClass: "kt-spinner kt-spinner--lg kt-spinner--primary"
	  })]) : _vm._e(), _vm._v(" "), _vm.loaded ? [_vm.readyProducts.length ? [_c("div", {
	    staticClass: "kt-widget-17"
	  }, _vm._l(_vm.readyProducts, function (item) {
	    return _c("div", {
	      key: item.id,
	      staticClass: "kt-widget-17__item"
	    }, [_c("div", {
	      staticClass: "kt-widget-17__product"
	    }, [_c("div", {
	      staticClass: "kt-widget-17__thumb"
	    }, [item.pictureSrc ? [item.detailPageUrl ? _c("a", {
	      attrs: {
	        href: item.detailPageUrl
	      }
	    }, [_c("img", {
	      staticClass: "kt-widget-17__image",
	      attrs: {
	        src: item.pictureSrc,
	        alt: "",
	        title: ""
	      }
	    })]) : _c("img", {
	      staticClass: "kt-widget-17__image",
	      attrs: {
	        src: item.pictureSrc,
	        alt: "",
	        title: ""
	      }
	    })] : _vm._e()], 2), _vm._v(" "), _c("div", {
	      staticClass: "kt-widget-17__product-desc"
	    }, [item.detailPageUrl ? _c("a", {
	      attrs: {
	        href: item.detailPageUrl
	      }
	    }, [_c("div", {
	      staticClass: "kt-widget-17__title",
	      domProps: {
	        innerHTML: _vm._s(item.name)
	      }
	    })]) : _c("div", {
	      staticClass: "kt-widget-17__title",
	      domProps: {
	        innerHTML: _vm._s(item.name)
	      }
	    }), _vm._v(" "), _c("div", {
	      staticClass: "kt-widget-17__sku",
	      domProps: {
	        innerHTML: _vm._s(item.vendorCode)
	      }
	    })])]), _vm._v(" "), _c("div", {
	      staticClass: "kt-widget-17__prices"
	    }, [_c("div", {
	      staticClass: "kt-widget-17__unit text-nowrap",
	      domProps: {
	        innerHTML: _vm._s(item.priceFmt + " <span>x</span> " + item.quantity + " " + (item.measure || ""))
	      }
	    }), _vm._v(" "), _c("div", {
	      staticClass: "kt-widget-17__total",
	      domProps: {
	        innerHTML: _vm._s(item.sumFmt)
	      }
	    })])]);
	  }), 0), _vm._v(" "), _c("div", {
	    staticClass: "mt-5 d-flex justify-content-between"
	  }, [_c("a", {
	    staticClass: "btn btn-default",
	    attrs: {
	      href: _vm.pathToBasket
	    }
	  }, [_vm._v(_vm._s(_vm.messages.RS_B2B_SBBL_TO_BASKET))]), _vm._v(" "), _c("a", {
	    staticClass: "btn btn-primary",
	    attrs: {
	      href: _vm.pathToOrder
	    }
	  }, [_vm._v(_vm._s(_vm.messages.RS_B2B_SBBL_TO_ORDER))])])] : [_c("QuickBasketEmpty")]] : _vm._e()], 2);
	};

	var __vue_staticRenderFns__$2 = [];
	__vue_render__$2._withStripped = true;
	/* style */

	var __vue_inject_styles__$2 = undefined;
	/* scoped */

	var __vue_scope_id__$2 = undefined;
	/* module identifier */

	var __vue_module_identifier__$2 = undefined;
	/* functional template */

	var __vue_is_functional_template__$2 = false;
	/* style inject */

	/* style inject SSR */

	var QuickBasketItems = normalizeComponent_1({
	  render: __vue_render__$2,
	  staticRenderFns: __vue_staticRenderFns__$2
	}, __vue_inject_styles__$2, __vue_script__$2, __vue_scope_id__$2, __vue_is_functional_template__$2, __vue_module_identifier__$2, undefined, undefined);

	//
	var _B2BPortal = B2BPortal,
	    store = _B2BPortal.store;
	var script$3 = {
	  name: 'QuickBasketPanel',
	  store: store,
	  components: {
	    QuickBasketSelect: QuickBasketSelect,
	    QuickBasketItems: QuickBasketItems
	  },
	  props: {
	    pathToBasket: {
	      type: String,
	      "default": ''
	    },
	    pathToOrder: {
	      type: String,
	      "default": ''
	    },
	    signedParameters: {
	      type: String,
	      "default": ''
	    }
	  },
	  data: function data() {
	    return {
	      isShowed: false,
	      needRefresh: false,
	      isBlocked: false
	    };
	  },
	  mounted: function mounted() {
	    var _this = this;

	    this.overlay = KTUtil.insertAfter(document.createElement('div'), this.$el);
	    this.overlay.classList.add('d-none');
	    this.overlay.classList.add('kt-offcanvas-panel-overlay');
	    this.overlay.addEventListener('click', function () {
	      return _this.hide();
	    });
	    this.unsubscribe = this.$store.subscribeAction(function (action, state) {
	      if (action.type === 'multicart/select' || action.type === 'cart/fetch') _this.isBlocked = true;
	    });

	    this.keyDownHandler = function (_ref) {
	      var key = _ref.key;
	      if (_this.isShowed && key === 'Escape') _this.isShowed = false;
	    };

	    document.addEventListener('keydown', this.keyDownHandler);
	  },
	  beforeDestroy: function beforeDestroy() {
	    document.removeEventListener('keydown', this.keyDownHandler);
	    this.overlay.remove();
	    this.unsubscribe();
	  },
	  methods: {
	    show: function show() {
	      this.isShowed = true;
	    },
	    hide: function hide() {
	      this.isShowed = false;
	    },
	    refresh: function refresh() {
	      this.isBlocked = true;
	      this.needRefresh = false; // this.$refs.items.refresh()
	      // 	.finally(() => this.isBlocked = false);
	    }
	  },
	  watch: {
	    isShowed: function isShowed(val) {
	      if (val) {
	        this.overlay.classList.remove('d-none');
	        this.overlay.classList.add('d-block'); // if (this.needRefresh)
	        // {
	        // 	this.refresh();
	        // }
	      } else {
	        this.overlay.classList.remove('d-block');
	        this.overlay.classList.add('d-none');
	      }
	    },
	    isBlocked: function isBlocked(val) {
	      if (val) {
	        KTApp.block(this.$el);
	      } else {
	        KTApp.unblock(this.$el);
	      }
	    }
	  }
	};

	/* script */
	var __vue_script__$3 = script$3;
	/* template */

	var __vue_render__$3 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", {
	    staticClass: "kt-offcanvas-panel kt-offcanvas-panel--cart",
	    "class": {
	      "kt-offcanvas-panel--on": _vm.isShowed
	    }
	  }, [_c("div", {
	    staticClass: "kt-offcanvas-panel__nav"
	  }, [_c("quick-basket-select"), _vm._v(" "), _c("button", {
	    staticClass: "kt-offcanvas-panel__close",
	    on: {
	      click: _vm.hide
	    }
	  }, [_c("i", {
	    staticClass: "flaticon2-delete"
	  })])], 1), _vm._v(" "), _c("div", {
	    staticClass: "kt-offcanvas-panel__body"
	  }, [_c("quick-basket-items", {
	    ref: "items",
	    attrs: {
	      isShowed: _vm.isShowed,
	      pathToBasket: _vm.pathToBasket,
	      pathToOrder: _vm.pathToOrder,
	      signedParameters: _vm.signedParameters
	    },
	    on: {
	      refreshed: function refreshed($event) {
	        _vm.isBlocked = false;
	      }
	    }
	  })], 1)]);
	};

	var __vue_staticRenderFns__$3 = [];
	__vue_render__$3._withStripped = true;
	/* style */

	var __vue_inject_styles__$3 = undefined;
	/* scoped */

	var __vue_scope_id__$3 = undefined;
	/* module identifier */

	var __vue_module_identifier__$3 = undefined;
	/* functional template */

	var __vue_is_functional_template__$3 = false;
	/* style inject */

	/* style inject SSR */

	var VueQuickBasketPanel = normalizeComponent_1({
	  render: __vue_render__$3,
	  staticRenderFns: __vue_staticRenderFns__$3
	}, __vue_inject_styles__$3, __vue_script__$3, __vue_scope_id__$3, __vue_is_functional_template__$3, __vue_module_identifier__$3, undefined, undefined);

	function ownKeys$1(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

	function _objectSpread$1(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys$1(Object(source), !0).forEach(function (key) { babelHelpers.defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys$1(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
	var _B2BPortal$1 = B2BPortal,
	    store$1 = _B2BPortal$1.store;
	var script$4 = {
	  name: 'QuickBasket',
	  store: store$1,
	  props: {
	    signedParameters: {
	      type: String,
	      "default": ''
	    },
	    pathToBasket: {
	      type: String,
	      "default": ''
	    },
	    pathToOrder: {
	      type: String,
	      "default": ''
	    },
	    panel: {
	      type: Boolean,
	      "default": true
	    }
	  },
	  computed: _objectSpread$1(_objectSpread$1({}, Vuex.mapState({
	    status: function status(state) {
	      return state.cart.status;
	    },
	    totalPrice: function totalPrice(state) {
	      return state.cart.totalPrice;
	    },
	    totalPriceRaw: function totalPriceRaw(state) {
	      return state.cart.totalPriceRaw;
	    },
	    numProducts: function numProducts(state) {
	      return state.cart.numProducts;
	    }
	  })), {}, {
	    messages: function messages() {
	      return Object.freeze({
	        RS_B2B_SBBL_BASKET_EMPTY: BX.message('RS_B2B_SBBL_BASKET_EMPTY')
	      });
	    }
	  }),
	  destroyed: function destroyed() {
	    if (this.$panel) this.$panel.remove();
	  },
	  methods: {
	    showPanel: function showPanel() {
	      var _this = this;

	      if (!this.$panel) {
	        this.$panel = new (Vue.extend(VueQuickBasketPanel))({
	          propsData: {
	            pathToBasket: this.pathToBasket,
	            pathToOrder: this.pathToOrder,
	            signedParameters: this.signedParameters
	          }
	        });
	        var container = document.createElement('div');
	        document.body.appendChild(container);
	        this.$panel.$mount(container);
	      }

	      setTimeout(function () {
	        _this.$panel.show();
	      });
	    }
	  }
	};

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
	var __vue_script__$4 = script$4;
	/* template */

	var __vue_render__$4 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", {
	    staticClass: "quickbasket"
	  }, [_c("div", {
	    staticClass: "btn-group flex-nowrap"
	  }, [_c("a", {
	    staticClass: "btn btn-primary d-flex",
	    attrs: {
	      href: _vm.pathToBasket
	    }
	  }, [_c("span", [_c("i", {
	    staticClass: "flaticon2-shopping-cart-1",
	    "class": {
	      invisible: _vm.status == "fetching"
	    }
	  }), _vm._v(" "), _vm.status == "fetching" ? _c("span", {
	    staticClass: "kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light",
	    staticStyle: {
	      position: "absolute",
	      top: "50%",
	      "margin-left": "-5px"
	    }
	  }) : _vm._e()]), _vm._v(" "), _vm.totalPriceRaw > 0 ? _c("span", {
	    staticClass: "text-nowrap",
	    domProps: {
	      innerHTML: _vm._s(_vm.totalPrice)
	    }
	  }) : _c("span", {
	    staticClass: "text-nowrap"
	  }, [_vm._v(_vm._s(_vm.messages.RS_B2B_SBBL_BASKET_EMPTY))])]), _vm._v(" "), _vm.panel ? _c("button", {
	    staticClass: "btn btn-primary btn-icon",
	    attrs: {
	      type: "button",
	      href: "#"
	    },
	    on: {
	      click: function click($event) {
	        $event.preventDefault();
	        return _vm.showPanel($event);
	      }
	    }
	  }, [_c("i", {
	    staticClass: "flaticon2-left-arrow"
	  })]) : _vm._e()])]);
	};

	var __vue_staticRenderFns__$4 = [];
	__vue_render__$4._withStripped = true;
	/* style */

	var __vue_inject_styles__$4 = function __vue_inject_styles__(inject) {
	  if (!inject) return;
	  inject("data-v-45787ed2_0", {
	    source: ".quickbasket .btn-icon > i[data-v-45787ed2] {\n  font-size: 12px;\n}",
	    map: undefined,
	    media: undefined
	  });
	};
	/* scoped */


	var __vue_scope_id__$4 = "data-v-45787ed2";
	/* module identifier */

	var __vue_module_identifier__$4 = undefined;
	/* functional template */

	var __vue_is_functional_template__$4 = false;
	/* style inject SSR */

	var VueQuickBasket = normalizeComponent_1({
	  render: __vue_render__$4,
	  staticRenderFns: __vue_staticRenderFns__$4
	}, __vue_inject_styles__$4, __vue_script__$4, __vue_scope_id__$4, __vue_is_functional_template__$4, __vue_module_identifier__$4, browser, undefined);

	var QuickBasket = /*#__PURE__*/function () {
	  function QuickBasket(el, params) {
	    babelHelpers.classCallCheck(this, QuickBasket);
	    this.el = el;
	    this.params = params;
	    this.initQuickBasket();
	  }

	  babelHelpers.createClass(QuickBasket, [{
	    key: "initQuickBasket",
	    value: function initQuickBasket() {
	      var options = {
	        propsData: {
	          signedParameters: this.params.signedParameters,
	          pathToBasket: this.params.pathToBasket,
	          pathToOrder: this.params.pathToOrder,
	          panel: this.params.panel
	        }
	      };
	      this.$quickBasket = new (Vue.extend(VueQuickBasket))(options);
	      var element = this.el.appendChild(document.createElement('div'));
	      this.$quickBasket.$mount(element, true);
	    }
	  }]);
	  return QuickBasket;
	}();

	exports.QuickBasket = QuickBasket;

}((this.window = this.window || {})));
//# sourceMappingURL=script.js.map
