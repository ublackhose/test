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
	//
	//
	//
	//
	//
	var GET_ORDERS_ACTION_NAME = 'redsign:b2bportal.api.orders.getOrders';
	var script = {
	  props: {
	    name: {
	      type: String,
	      default: ''
	    },
	    value: {
	      type: String,
	      default: ''
	    },
	    minLength: {
	      type: [Number, String],
	      default: 0
	    },
	    placeholder: {
	      type: String,
	      default: ''
	    }
	  },
	  data: function data() {
	    return {
	      cursor: 0,
	      isFocused: false,
	      loadings: [],
	      query: this.value,
	      suggestions: []
	    };
	  },
	  computed: {
	    isVisibleSuggestions: function isVisibleSuggestions() {
	      return this.isFocused && this.suggestions.length > 0;
	    },
	    dropdownStyles: function dropdownStyles() {
	      return {
	        maxHeight: '240px',
	        overflow: 'hidden'
	      };
	    },
	    isLoading: function isLoading() {
	      return Boolean(this.loadings.length);
	    },
	    loadingClasses: function loadingClasses() {
	      if (this.isLoading) {
	        return ['kt-spinner', 'kt-spinner--input', 'kt-spinner--sm', 'kt-spinner--brand', 'kt-spinner--right'];
	      }

	      return [];
	    }
	  },
	  mounted: function mounted() {
	    var _this = this;

	    var clickOutside = function clickOutside(event) {
	      if (_this.isFocused && _this.$refs.input !== document.activeElement) {
	        var target = event.target;

	        if (target != _this.$el && !_this.$el.contains(target)) {
	          _this.$refs.input.blur();

	          _this.isFocused = false;
	        }
	      }
	    };

	    document.addEventListener('mouseup', clickOutside);
	    document.addEventListener('touchstart', clickOutside);
	    document.addEventListener('keydown', function (event) {
	      var keyName = event.key;

	      if (_this.isFocused && keyName == 'Escape') {
	        _this.isFocused = false;

	        _this.$refs.input.blur();
	      }
	    });
	  },
	  methods: {
	    handleFocus: function handleFocus() {
	      this.isFocused = true;
	      this.load();
	    },
	    handleBlur: function handleBlur() {
	      var relatedTarget = event.relatedTarget || document.activeElement;

	      if (relatedTarget) {
	        if (relatedTarget != this.$refs.dropdown && !this.$refs.dropdown.contains(relatedTarget)) {
	          this.isFocused = false;
	        }
	      } else {
	        this.isFocused = false;
	      }
	    },
	    handleInput: function handleInput() {
	      this.$emit('input', this.query);

	      if (this.query.length >= this.minLength) {
	        this.load(this.query);
	      }
	    },
	    select: function select(suggestion) {
	      this.query = suggestion;
	      this.isFocused = false;
	      this.$refs.input.blur();
	    },
	    load: function load(query) {
	      var _this2 = this;

	      return babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee() {
	        var result;
	        return regeneratorRuntime.wrap(function _callee$(_context) {
	          while (1) {
	            switch (_context.prev = _context.next) {
	              case 0:
	                _this2.loadings.push(true);

	                _context.next = 3;
	                return _this2.loadSuggestions(query);

	              case 3:
	                result = _context.sent;
	                _this2.suggestions = result.data;

	                _this2.loadings.pop();

	              case 6:
	              case "end":
	                return _context.stop();
	            }
	          }
	        }, _callee);
	      }))();
	    },
	    loadSuggestions: function loadSuggestions(query) {
	      var data = {
	        accountNumber: this.query
	      };
	      return new Promise(function (resolve, reject) {
	        BX.ajax.runAction(GET_ORDERS_ACTION_NAME, {
	          data: data
	        }).then(resolve, reject);
	      });
	    }
	  },
	  watch: {
	    value: function (_value) {
	      function value() {
	        return _value.apply(this, arguments);
	      }

	      value.toString = function () {
	        return _value.toString();
	      };

	      return value;
	    }(function () {
	      this.query = value;
	    })
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
	    staticClass: "d-block position-relative"
	  }, [_c("div", {
	    class: _vm.loadingClasses
	  }, [_c("input", {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: _vm.query,
	      expression: "query"
	    }],
	    ref: "input",
	    staticClass: "form-control",
	    attrs: {
	      type: "text",
	      placeholder: this.placeholder,
	      name: _vm.name,
	      autocomplete: "off"
	    },
	    domProps: {
	      value: _vm.query
	    },
	    on: {
	      focus: _vm.handleFocus,
	      blur: _vm.handleBlur,
	      input: [function ($event) {
	        if ($event.target.composing) {
	          return;
	        }

	        _vm.query = $event.target.value;
	      }, _vm.handleInput]
	    }
	  })]), _vm._v(" "), _c("div", {
	    ref: "dropdown",
	    staticClass: "dropdown-menu dropdown-menu-anim dropdown-menu-fit dropdown-menu-right dropdown-menu-xl ps ps--active-y mw-100",
	    class: {
	      show: _vm.isVisibleSuggestions && !_vm.isLoading
	    },
	    style: _vm.dropdownStyles,
	    attrs: {
	      "data-scroll": "true"
	    }
	  }, _vm._l(_vm.suggestions, function (item, index) {
	    return _c("a", {
	      key: index,
	      staticClass: "dropdown-item flex-column",
	      attrs: {
	        href: "#"
	      },
	      on: {
	        click: function click($event) {
	          $event.preventDefault();
	          return _vm.select(item);
	        }
	      }
	    }, [_vm._v("\n\t\t\t" + _vm._s(item) + "\n\t\t")]);
	  }), 0)]);
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

	var VueOrderSuggestions = normalizeComponent_1({
	  render: __vue_render__,
	  staticRenderFns: __vue_staticRenderFns__
	}, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, undefined, undefined);

	var OrderSuggestions = /*#__PURE__*/function () {
	  function OrderSuggestions(el, options) {
	    babelHelpers.classCallCheck(this, OrderSuggestions);
	    this.$el = el;
	    this.options = options;
	    this.attachTemplate();
	  }

	  babelHelpers.createClass(OrderSuggestions, [{
	    key: "attachTemplate",
	    value: function attachTemplate() {
	      var inputName = this.options.inputName || '';
	      var value = this.options.value || '';
	      this.template = new Vue({
	        components: {
	          VueOrderSuggestions: VueOrderSuggestions
	        },
	        el: this.$el,
	        data: function data() {
	          return {
	            inputName: inputName,
	            value: value
	          };
	        },
	        template: "<VueOrderSuggestions :name=\"inputName\" :value=\"value\" />"
	      });
	    }
	  }]);
	  return OrderSuggestions;
	}();

	exports.OrderSuggestions = OrderSuggestions;

}((this.B2BPortal.Components = this.B2BPortal.Components || {})));
//# sourceMappingURL=OrderSuggestions.js.map
