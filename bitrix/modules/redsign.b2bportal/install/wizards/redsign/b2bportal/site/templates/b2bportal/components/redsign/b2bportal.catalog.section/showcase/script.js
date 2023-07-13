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
	var script = {
	  name: "CatalogItem",
	  props: {
	    item: {
	      type: Object
	    }
	  },
	  computed: _objectSpread(_objectSpread({}, Vuex.mapState({
	    iblock: function iblock(state) {
	      return state[this.$root.namespace].iblock;
	    }
	  })), {}, {
	    mess: function mess() {
	      return Object.freeze({
	        'RS_B2B_CS_SHOWCASE_PRICE_FROM': BX.message('RS_B2B_CS_SHOWCASE_PRICE_FROM')
	      });
	    },
	    product: function product() {
	      return this.item.products[this.item.selected];
	    },
	    printPrice: function printPrice() {
	      if (this.item.priceStart) return this.item.priceStart.printPrice;
	      if (this.product.prices[this.product.priceSelected]) return this.product.prices[this.product.priceSelected].printPrice;
	      return '';
	    }
	  }),
	  mounted: function mounted() {
	    this.setAdminBorder();
	  },
	  methods: {
	    setAdminBorder: function setAdminBorder() {
	      if (BX.admin && BX.admin.dynamic_mode_show_borders) {
	        var menu = new BX.CMenuOpener({
	          'parent': this.item.areaId,
	          'menu': [{
	            'ICONCLASS': 'bx-context-toolbar-edit-icon',
	            'TITLE': '',
	            'TEXT': this.iblock.messages.element_edit,
	            'ONCLICK': "(new BX.CAdminDialog({'content_url': '" + this.item.menu.edit + "' })).Show()"
	          }, {
	            'ICONCLASS': 'bx-context-toolbar-delete-icon',
	            'TITLE': '',
	            'TEXT': this.iblock.messages.element_delete,
	            'ONCLICK': 'if(confirm(\'Are you sure?\')) jsUtils.Redirect([], ' + this.item.menu.edit + ');'
	          }]
	        });
	        menu.Show();
	        BX.admin.setComponentBorder(this.item.areaId);
	      }
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
	    staticClass: "catalog-showcase-item",
	    attrs: {
	      id: _vm.item.areaId
	    }
	  }, [_c("a", {
	    staticClass: "catalog-showcase-item__picture",
	    attrs: {
	      href: _vm.item.url
	    }
	  }, [_c("img", {
	    attrs: {
	      src: _vm.item.preview,
	      alt: _vm.item.previewAlt,
	      title: _vm.item.previewTitle
	    }
	  })]), _vm._v(" "), _c("div", {
	    staticClass: "catalog-showcase-item__data"
	  }, [_c("a", {
	    staticClass: "catalog-showcase-item__name",
	    attrs: {
	      href: _vm.item.url
	    }
	  }, [_vm._v(_vm._s(_vm.item.name))]), _vm._v(" "), _c("div", {
	    staticClass: "catalog-showcase-item__price"
	  }, [_vm.item.priceStart ? _c("span", {
	    staticClass: "small"
	  }, [_vm._v(_vm._s(_vm.mess.RS_B2B_CS_SHOWCASE_PRICE_FROM) + " ")]) : _vm._e(), _vm._v(" "), _c("span", {
	    domProps: {
	      innerHTML: _vm._s(_vm.printPrice)
	    }
	  })])])]);
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

	var CatalogItem = normalizeComponent_1({
	  render: __vue_render__,
	  staticRenderFns: __vue_staticRenderFns__
	}, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, undefined, undefined);

	function ownKeys$1(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

	function _objectSpread$1(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys$1(Object(source), !0).forEach(function (key) { babelHelpers.defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys$1(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
	var script$1 = {
	  name: 'CatalogSection',
	  components: {
	    CatalogItem: CatalogItem,
	    VuexPagination: B2BPortal.Vue.Components.VuexPagination
	  },
	  props: {
	    namespace: {
	      type: String
	    }
	  },
	  computed: _objectSpread$1({}, Vuex.mapState({
	    items: function items(state) {
	      return state[this.namespace].items;
	    },
	    fetching: function fetching(state) {
	      return state[this.namespace].fetching;
	    }
	  })),
	  watch: {
	    fetching: function fetching() {
	      var _this = this;

	      if (this.fetching) {
	        KTApp.block(this.$el);
	      } else {
	        KTApp.unblock(this.$el);
	        this.$nextTick(function () {
	          _this.$el.scrollIntoView({
	            behavior: 'smooth'
	          });
	        });
	      }
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
	    staticClass: "catalog-section"
	  }, [_c("div", {
	    staticClass: "catalog-showcase"
	  }, _vm._l(_vm.items, function (item, index) {
	    return _c("CatalogItem", {
	      key: index,
	      attrs: {
	        item: item
	      }
	    });
	  }), 1), _vm._v(" "), _c("div", {
	    staticClass: "catalog-pagination"
	  }, [_c("VuexPagination", {
	    attrs: {
	      namespace: _vm.namespace
	    }
	  })], 1)]);
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

	var CatalogSection = normalizeComponent_1({
	  render: __vue_render__$1,
	  staticRenderFns: __vue_staticRenderFns__$1
	}, __vue_inject_styles__$1, __vue_script__$1, __vue_scope_id__$1, __vue_is_functional_template__$1, __vue_module_identifier__$1, undefined, undefined);

	function ownKeys$2(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

	function _objectSpread$2(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys$2(Object(source), !0).forEach(function (key) { babelHelpers.defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys$2(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
	var _B2BPortal = B2BPortal,
	    store = _B2BPortal.store;
	var _B2BPortal$Vue$Store$ = B2BPortal.Vue.Store.List,
	    createStore = _B2BPortal$Vue$Store$.createStore,
	    types = _B2BPortal$Vue$Store$.types;
	var CatalogSectionShowcase = /*#__PURE__*/function () {
	  function CatalogSectionShowcase(element, params) {
	    babelHelpers.classCallCheck(this, CatalogSectionShowcase);
	    this.params = params;
	    this.namespace = params.namespace;
	    this.element = element;
	    this.initializeStore();
	    this.bindEvents();
	    this.attachTemplate();
	  }

	  babelHelpers.createClass(CatalogSectionShowcase, [{
	    key: "initializeStore",
	    value: function initializeStore() {
	      var state = {
	        id: this.params.id,
	        items: this.params.items,
	        pagination: this.params.pagination,
	        iblock: this.params.iblock
	      };
	      store.registerModule(this.namespace, createStore(state));
	    }
	  }, {
	    key: "bindEvents",
	    value: function bindEvents() {
	      BX.addCustomEvent("filter-".concat(this.params.filterName, "-on-submit"), this.onFilterSubmit.bind(this));
	      BX.addCustomEvent("filter-".concat(this.params.filterName, "-on-reset"), this.onFilterReset.bind(this));
	    }
	  }, {
	    key: "onFilterSubmit",
	    value: function onFilterSubmit(params, url) {
	      var _this = this;

	      if (url) {
	        this.params.ajaxUrl = url;
	      }

	      store.dispatch("".concat(this.namespace, "/fetch"), {
	        url: url || this.params.ajaxUrl,
	        params: params
	      }).then(function (res) {
	        if (res.status === 'success' && params) {
	          store.commit("".concat(_this.namespace, "/").concat(types.SAVE_PARAMS), params);
	        }
	      });
	    }
	  }, {
	    key: "onFilterReset",
	    value: function onFilterReset(params, url) {
	      this.onFilterSubmit(params, url);
	    }
	  }, {
	    key: "attachTemplate",
	    value: function attachTemplate() {
	      var Component = Vue.extend(_objectSpread$2(_objectSpread$2({}, CatalogSection), {}, {
	        store: store
	      }));
	      this.vm = new Component({
	        propsData: {
	          namespace: this.namespace
	        }
	      });
	      this.vm.$mount(this.element, true);
	    }
	  }]);
	  return CatalogSectionShowcase;
	}();

	exports.CatalogSectionShowcase = CatalogSectionShowcase;

}((this.window = this.window || {})));
//# sourceMappingURL=script.js.map
