this.B2BPortal = this.B2BPortal || {};
(function (exports) {
	'use strict';

	var FieldMixin = {
	  props: {
	    prop: Object,
	    fieldName: String,
	    fieldId: String,
	    value: String,
	    required: {
	      type: Boolean,
	      default: false
	    }
	  },
	  methods: {
	    decodeVal: function decodeVal(html) {
	      var decoder = document.createElement('div');
	      decoder.innerHTML = html;
	      return decoder.textContent;
	    }
	  }
	};

	var InputValueMixin = {
	  props: {
	    value: String
	  },
	  data: function data() {
	    return {
	      inputValue: this.decodeVal(this.value)
	    };
	  },
	  methods: {
	    decodeVal: function decodeVal(html) {
	      var decoder = document.createElement('div');
	      decoder.innerHTML = html;
	      return decoder.textContent;
	    }
	  }
	};

	var getSuggestValue = function getSuggestValue(suggestion, fieldType) {
	  switch (fieldType) {
	    case 'INN':
	      return (suggestion.data || {}).inn || '';

	    case 'OGRN':
	      return (suggestion.data || {}).ogrn || '';

	    case 'ADDRESS':
	      return ((suggestion.data || {}).address || {}).value || '';

	    case 'KPP':
	      return (suggestion.data || {}).kpp || '';

	    default:
	      return suggestion.value;
	  }
	};

	//
	var script = {
	  mixins: [FieldMixin, InputValueMixin],
	  mounted: function mounted() {
	    var _this = this;

	    if (this.prop.FIELD_TYPE) {
	      this.$root.$on('selectSuggest', function (suggestion) {
	        _this.inputValue = getSuggestValue(suggestion, _this.prop.FIELD_TYPE);
	      });
	    }

	    if (this.isPhoneNumber) {
	      new BX.PhoneNumber.Input({
	        node: this.$refs.input,
	        forceLeadingPlus: false,
	        flagNode: this.$refs.flag,
	        flagSize: 16,
	        defaultCountry: 'ru'
	      });
	    }
	  },
	  computed: {
	    inputType: function inputType() {
	      return this.prop.IS_EMAIL === 'Y' ? 'email' : 'text';
	    },
	    isPhoneNumber: function isPhoneNumber() {
	      return this.prop.IS_PHONE === 'Y';
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

	  return _c("div", [_vm.isPhoneNumber ? _c("div", [_c("div", {
	    staticClass: "kt-input-icon kt-input-icon--left"
	  }, [_c("input", {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: _vm.inputValue,
	      expression: "inputValue"
	    }],
	    ref: "input",
	    staticClass: "form-control",
	    attrs: {
	      type: "text",
	      name: _vm.fieldName,
	      id: _vm.fieldId,
	      required: _vm.required
	    },
	    domProps: {
	      value: _vm.inputValue
	    },
	    on: {
	      input: function input($event) {
	        if ($event.target.composing) {
	          return;
	        }

	        _vm.inputValue = $event.target.value;
	      }
	    }
	  }), _vm._v(" "), _c("span", {
	    staticClass: "kt-input-icon__icon kt-input-icon__icon--left"
	  }, [_c("span", [_c("span", {
	    ref: "flag"
	  })])])])]) : _vm.inputType === "checkbox" ? _c("input", {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: _vm.inputValue,
	      expression: "inputValue"
	    }],
	    ref: "input",
	    staticClass: "form-control",
	    attrs: {
	      name: _vm.fieldName,
	      id: _vm.fieldId,
	      required: _vm.required,
	      type: "checkbox"
	    },
	    domProps: {
	      checked: Array.isArray(_vm.inputValue) ? _vm._i(_vm.inputValue, null) > -1 : _vm.inputValue
	    },
	    on: {
	      change: function change($event) {
	        var $$a = _vm.inputValue,
	            $$el = $event.target,
	            $$c = $$el.checked ? true : false;

	        if (Array.isArray($$a)) {
	          var $$v = null,
	              $$i = _vm._i($$a, $$v);

	          if ($$el.checked) {
	            $$i < 0 && (_vm.inputValue = $$a.concat([$$v]));
	          } else {
	            $$i > -1 && (_vm.inputValue = $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
	          }
	        } else {
	          _vm.inputValue = $$c;
	        }
	      }
	    }
	  }) : _vm.inputType === "radio" ? _c("input", {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: _vm.inputValue,
	      expression: "inputValue"
	    }],
	    ref: "input",
	    staticClass: "form-control",
	    attrs: {
	      name: _vm.fieldName,
	      id: _vm.fieldId,
	      required: _vm.required,
	      type: "radio"
	    },
	    domProps: {
	      checked: _vm._q(_vm.inputValue, null)
	    },
	    on: {
	      change: function change($event) {
	        _vm.inputValue = null;
	      }
	    }
	  }) : _c("input", {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: _vm.inputValue,
	      expression: "inputValue"
	    }],
	    ref: "input",
	    staticClass: "form-control",
	    attrs: {
	      name: _vm.fieldName,
	      id: _vm.fieldId,
	      required: _vm.required,
	      type: _vm.inputType
	    },
	    domProps: {
	      value: _vm.inputValue
	    },
	    on: {
	      input: function input($event) {
	        if ($event.target.composing) {
	          return;
	        }

	        _vm.inputValue = $event.target.value;
	      }
	    }
	  })]);
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

	var StringField = normalizeComponent_1({
	  render: __vue_render__,
	  staticRenderFns: __vue_staticRenderFns__
	}, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, undefined, undefined);

	//
	var script$1 = {
	  mixins: [FieldMixin]
	};

	/* script */
	var __vue_script__$1 = script$1;
	/* template */

	var __vue_render__$1 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [_c("input", {
	    staticClass: "form-control",
	    attrs: {
	      type: "number",
	      name: _vm.fieldName,
	      id: _vm.fieldId,
	      required: _vm.required
	    },
	    domProps: {
	      value: _vm.value
	    }
	  })]);
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

	var NumberField = normalizeComponent_1({
	  render: __vue_render__$1,
	  staticRenderFns: __vue_staticRenderFns__$1
	}, __vue_inject_styles__$1, __vue_script__$1, __vue_scope_id__$1, __vue_is_functional_template__$1, __vue_module_identifier__$1, undefined, undefined);

	//
	var script$2 = {
	  mixins: [FieldMixin]
	};

	/* script */
	var __vue_script__$2 = script$2;
	/* template */

	var __vue_render__$2 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [_c("label", {
	    staticClass: "kt-checkbox"
	  }, [_c("input", {
	    attrs: {
	      type: "checkbox",
	      name: _vm.fieldName,
	      id: _vm.fieldId,
	      required: _vm.required,
	      value: "Y"
	    },
	    domProps: {
	      checked: _vm.value == "Y"
	    }
	  }), _vm._v(" "), _c("span")])]);
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

	var CheckboxField = normalizeComponent_1({
	  render: __vue_render__$2,
	  staticRenderFns: __vue_staticRenderFns__$2
	}, __vue_inject_styles__$2, __vue_script__$2, __vue_scope_id__$2, __vue_is_functional_template__$2, __vue_module_identifier__$2, undefined, undefined);

	var _this = undefined;

	var processLocation = function processLocation(html) {
	  var processedHTML = BX.processHTML(html);
	  var processedScripts = processedHTML.SCRIPT;

	  if (processedScripts && processedScripts.length) {
	    processedScripts.forEach(function (SCRIPT) {
	      BX.evalGlobal(SCRIPT.JS);
	    });
	  }
	};

	var initDeferredLocations = function initDeferredLocations() {
	  if (typeof window.BX.locationsDeferred != 'undefined') {
	    for (var k in window.BX.locationsDeferred) {
	      window.BX.locationsDeferred[k].call(_this);
	      window.BX.locationsDeferred[k] = null;
	      delete window.BX.locationsDeferred[k];
	    }
	  }
	};

	var script$3 = {
	  mixins: [FieldMixin],
	  computed: {
	    html: function html() {
	      return this.value;
	    }
	  },
	  mounted: function mounted() {
	    var _this2 = this;

	    this.$nextTick(function () {
	      processLocation(_this2.html);
	      initDeferredLocations();
	    });
	  }
	};

	/* script */
	var __vue_script__$3 = script$3;
	/* template */

	var __vue_render__$3 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [_c("div", {
	    domProps: {
	      innerHTML: _vm._s(_vm.html)
	    }
	  })]);
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

	var LocationField = normalizeComponent_1({
	  render: __vue_render__$3,
	  staticRenderFns: __vue_staticRenderFns__$3
	}, __vue_inject_styles__$3, __vue_script__$3, __vue_scope_id__$3, __vue_is_functional_template__$3, __vue_module_identifier__$3, undefined, undefined);

	//
	var script$4 = {
	  mixins: [FieldMixin],
	  data: function data() {
	    return {
	      inputValue: false
	    };
	  },
	  computed: {
	    messages: function messages() {
	      return Object.freeze({
	        'FILE_CHOOSE': BX.message('RS_B2B_REGISTRATION_FILE_CHOOSE'),
	        'FILE_BROWSE': BX.message('RS_B2B_REGISTRATION_FILE_BROWSE')
	      });
	    }
	  }
	};

	/* script */
	var __vue_script__$4 = script$4;
	/* template */

	var __vue_render__$4 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [_c("div", {
	    staticClass: "custom-file"
	  }, [_c("input", {
	    staticClass: "custom-file-input",
	    attrs: {
	      type: "file",
	      name: _vm.fieldName,
	      id: _vm.fieldId,
	      required: _vm.required
	    },
	    on: {
	      change: function change($event) {
	        _vm.inputValue = _vm.event.targe.value;
	      }
	    }
	  }), _vm._v(" "), _c("label", {
	    ref: "label",
	    staticClass: "custom-file-label",
	    attrs: {
	      for: _vm.fieldId,
	      "data-browse": _vm.messages.FILE_BROWSE
	    }
	  }, [_vm._v(_vm._s(_vm.inputValue || _vm.messages.FILE_CHOOSE))])])]);
	};

	var __vue_staticRenderFns__$4 = [];
	__vue_render__$4._withStripped = true;
	/* style */

	var __vue_inject_styles__$4 = undefined;
	/* scoped */

	var __vue_scope_id__$4 = undefined;
	/* module identifier */

	var __vue_module_identifier__$4 = undefined;
	/* functional template */

	var __vue_is_functional_template__$4 = false;
	/* style inject */

	/* style inject SSR */

	var FileField = normalizeComponent_1({
	  render: __vue_render__$4,
	  staticRenderFns: __vue_staticRenderFns__$4
	}, __vue_inject_styles__$4, __vue_script__$4, __vue_scope_id__$4, __vue_is_functional_template__$4, __vue_module_identifier__$4, undefined, undefined);

	//
	var script$5 = {
	  mixins: [FieldMixin],
	  props: {
	    value: String | Array,
	    multiple: {
	      type: Boolean,
	      default: false
	    }
	  },
	  data: function data() {
	    return {
	      valueM: this.value
	    };
	  },
	  computed: {
	    isRadio: function isRadio() {
	      return !this.multiple && this.prop.SETTINGS.MULTIELEMENT == 'Y';
	    }
	  }
	};

	/* script */
	var __vue_script__$5 = script$5;
	/* template */

	var __vue_render__$5 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [_vm.isRadio ? _c("div", {
	    staticClass: "kt-radio-list"
	  }, _vm._l(_vm.prop.VALUES, function (v) {
	    return _c("label", {
	      key: v.ID,
	      staticClass: "kt-radio"
	    }, [_c("input", {
	      directives: [{
	        name: "model",
	        rawName: "v-model",
	        value: _vm.valueM,
	        expression: "valueM"
	      }],
	      attrs: {
	        type: "radio",
	        name: _vm.fieldName
	      },
	      domProps: {
	        value: v.VALUE,
	        checked: _vm._q(_vm.valueM, v.VALUE)
	      },
	      on: {
	        change: function change($event) {
	          _vm.valueM = v.VALUE;
	        }
	      }
	    }), _vm._v(" " + _vm._s(v.NAME) + " \n\t\t\t"), _c("span")]);
	  }), 0) : _c("select", {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: _vm.valueM,
	      expression: "valueM"
	    }],
	    staticClass: "form-control",
	    attrs: {
	      name: _vm.fieldName,
	      id: _vm.fieldId,
	      multiple: _vm.multiple,
	      required: _vm.required
	    },
	    on: {
	      change: function change($event) {
	        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
	          return o.selected;
	        }).map(function (o) {
	          var val = "_value" in o ? o._value : o.value;
	          return val;
	        });
	        _vm.valueM = $event.target.multiple ? $$selectedVal : $$selectedVal[0];
	      }
	    }
	  }, _vm._l(_vm.prop.VALUES, function (v) {
	    return _c("option", {
	      key: v.ID,
	      domProps: {
	        value: v.VALUE
	      }
	    }, [_vm._v(_vm._s(v.NAME))]);
	  }), 0)]);
	};

	var __vue_staticRenderFns__$5 = [];
	__vue_render__$5._withStripped = true;
	/* style */

	var __vue_inject_styles__$5 = undefined;
	/* scoped */

	var __vue_scope_id__$5 = undefined;
	/* module identifier */

	var __vue_module_identifier__$5 = undefined;
	/* functional template */

	var __vue_is_functional_template__$5 = false;
	/* style inject */

	/* style inject SSR */

	var EnumField = normalizeComponent_1({
	  render: __vue_render__$5,
	  staticRenderFns: __vue_staticRenderFns__$5
	}, __vue_inject_styles__$5, __vue_script__$5, __vue_scope_id__$5, __vue_is_functional_template__$5, __vue_module_identifier__$5, undefined, undefined);

	//
	var script$6 = {
	  mixins: [FieldMixin, InputValueMixin],
	  components: {
	    SuggestInput: B2BPortal.Vue.Components.SuggestInput
	  },
	  computed: {
	    suggestType: function suggestType() {
	      return this.prop.FIELD_TYPE;
	    }
	  },
	  mounted: function mounted() {
	    var _this = this;

	    this.$root.$on('selectSuggest', function (suggestion) {
	      _this.inputValue = getSuggestValue(suggestion, _this.suggestType);
	    });
	  },
	  methods: {
	    getSuggestData: function getSuggestData(suggestion) {
	      var fieldType = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
	      return this.inputValue.trim().split(/[\s,]+/).reduce(function (value, query) {
	        return value.replace(new RegExp('(' + query + ')', 'gi'), '<b class="text-primary">$1</b>');
	      }, getSuggestValue(suggestion, fieldType));
	    },
	    isLiquid: function isLiquid(suggestion) {
	      var status = ((suggestion.data || {}).state || {}).status;
	      return status !== 'ACTIVE' && status !== 'REORGANIZING ';
	    },
	    getSuggestions: function getSuggestions() {
	      var _this2 = this;

	      return babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee() {
	        var result, isSuccess;
	        return regeneratorRuntime.wrap(function _callee$(_context) {
	          while (1) {
	            switch (_context.prev = _context.next) {
	              case 0:
	                _context.next = 2;
	                return BX.ajax.runAction('redsign:b2bportal.api.dadata.suggest', {
	                  data: {
	                    actionName: 'party',
	                    data: {
	                      query: _this2.inputValue,
	                      count: 7
	                    }
	                  }
	                });

	              case 2:
	                result = _context.sent;
	                isSuccess = result.status === 'success';
	                return _context.abrupt("return", isSuccess && result.data.suggestions ? result.data.suggestions : []);

	              case 5:
	              case "end":
	                return _context.stop();
	            }
	          }
	        }, _callee);
	      }))();
	    },
	    select: function select(suggestion) {
	      this.$root.$emit('selectSuggest', suggestion);
	    }
	  }
	};

	/* script */
	var __vue_script__$6 = script$6;
	/* template */

	var __vue_render__$6 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [_c("SuggestInput", {
	    attrs: {
	      name: _vm.fieldName,
	      id: _vm.fieldId,
	      loadSuggestions: _vm.getSuggestions
	    },
	    on: {
	      select: _vm.select
	    },
	    scopedSlots: _vm._u([{
	      key: "default",
	      fn: function fn(slotProps) {
	        return [_c("div", {
	          class: {
	            "text-line-through": _vm.isLiquid(slotProps.suggestion)
	          },
	          domProps: {
	            innerHTML: _vm._s(_vm.getSuggestData(slotProps.suggestion))
	          }
	        }), _vm._v(" "), _c("div", [_c("span", {
	          domProps: {
	            innerHTML: _vm._s(_vm.getSuggestData(slotProps.suggestion, "INN"))
	          }
	        }), _vm._v(" "), _c("span", {
	          domProps: {
	            innerHTML: _vm._s(_vm.getSuggestData(slotProps.suggestion, "ADDRESS"))
	          }
	        })])];
	      }
	    }]),
	    model: {
	      value: _vm.inputValue,
	      callback: function callback($$v) {
	        _vm.inputValue = $$v;
	      },
	      expression: "inputValue"
	    }
	  })], 1);
	};

	var __vue_staticRenderFns__$6 = [];
	__vue_render__$6._withStripped = true;
	/* style */

	var __vue_inject_styles__$6 = undefined;
	/* scoped */

	var __vue_scope_id__$6 = undefined;
	/* module identifier */

	var __vue_module_identifier__$6 = undefined;
	/* functional template */

	var __vue_is_functional_template__$6 = false;
	/* style inject */

	/* style inject SSR */

	var SuggestField = normalizeComponent_1({
	  render: __vue_render__$6,
	  staticRenderFns: __vue_staticRenderFns__$6
	}, __vue_inject_styles__$6, __vue_script__$6, __vue_scope_id__$6, __vue_is_functional_template__$6, __vue_module_identifier__$6, undefined, undefined);

	//
	var script$7 = {
	  mixins: [FieldMixin, InputValueMixin],
	  mounted: function mounted() {
	    var _this = this;

	    if (this.prop.FIELD_TYPE) {
	      this.$root.$on('selectSuggest', function (suggestion) {
	        _this.inputValue = getSuggestValue(suggestion, _this.prop.FIELD_TYPE);
	      });
	    }
	  }
	};

	/* script */
	var __vue_script__$7 = script$7;
	/* template */

	var __vue_render__$7 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [_c("textarea", {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: _vm.inputValue,
	      expression: "inputValue"
	    }],
	    staticClass: "form-control",
	    attrs: {
	      name: _vm.fieldName,
	      id: _vm.fieldId,
	      required: _vm.required
	    },
	    domProps: {
	      value: _vm.inputValue
	    },
	    on: {
	      input: function input($event) {
	        if ($event.target.composing) {
	          return;
	        }

	        _vm.inputValue = $event.target.value;
	      }
	    }
	  })]);
	};

	var __vue_staticRenderFns__$7 = [];
	__vue_render__$7._withStripped = true;
	/* style */

	var __vue_inject_styles__$7 = undefined;
	/* scoped */

	var __vue_scope_id__$7 = undefined;
	/* module identifier */

	var __vue_module_identifier__$7 = undefined;
	/* functional template */

	var __vue_is_functional_template__$7 = false;
	/* style inject */

	/* style inject SSR */

	var TextareaField = normalizeComponent_1({
	  render: __vue_render__$7,
	  staticRenderFns: __vue_staticRenderFns__$7
	}, __vue_inject_styles__$7, __vue_script__$7, __vue_scope_id__$7, __vue_is_functional_template__$7, __vue_module_identifier__$7, undefined, undefined);

	//
	var script$8 = {
	  mixins: [FieldMixin],
	  computed: {
	    showTime: function showTime() {
	      return this.prop.SETTINGS.TIME === 'Y';
	    }
	  },
	  mounted: function mounted() {
	    var _this = this;

	    this.$nextTick(function () {
	      if (_this.showTime) {
	        $(_this.$refs.input).datetimepicker({
	          format: 'dd.mm.yyyy hh:ii:ss',
	          autoclose: true
	        });
	      } else {
	        $(_this.$refs.input).datepicker({
	          format: 'dd.mm.yyyy',
	          autoclose: true
	        });
	      }
	    });
	  }
	};

	/* script */
	var __vue_script__$8 = script$8;
	/* template */

	var __vue_render__$8 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [_c("input", {
	    ref: "input",
	    staticClass: "form-control",
	    attrs: {
	      type: "text",
	      name: _vm.fieldName,
	      id: _vm.fieldId,
	      required: _vm.required
	    }
	  })]);
	};

	var __vue_staticRenderFns__$8 = [];
	__vue_render__$8._withStripped = true;
	/* style */

	var __vue_inject_styles__$8 = undefined;
	/* scoped */

	var __vue_scope_id__$8 = undefined;
	/* module identifier */

	var __vue_module_identifier__$8 = undefined;
	/* functional template */

	var __vue_is_functional_template__$8 = false;
	/* style inject */

	/* style inject SSR */

	var DateField = normalizeComponent_1({
	  render: __vue_render__$8,
	  staticRenderFns: __vue_staticRenderFns__$8
	}, __vue_inject_styles__$8, __vue_script__$8, __vue_scope_id__$8, __vue_is_functional_template__$8, __vue_module_identifier__$8, undefined, undefined);

	//
	var components = {
	  StringField: StringField,
	  NumberField: NumberField,
	  CheckboxField: CheckboxField,
	  LocationField: LocationField,
	  FileField: FileField,
	  EnumField: EnumField,
	  SuggestField: SuggestField,
	  TextareaField: TextareaField,
	  DateField: DateField
	};
	var script$9 = {
	  components: components,
	  props: {
	    prop: Object,
	    index: {
	      type: Number,
	      default: 0
	    }
	  },
	  data: function data() {
	    var value = this.$root.values['COMPANY_PROP_' + this.prop.ID];

	    if (this.prop.MULTIPLE == 'Y') {
	      if (!BX.type.isArray(value) || !value.length) {
	        value = [''];
	      }
	    }

	    return {
	      value: value
	    };
	  },
	  computed: {
	    messages: function messages() {
	      return Object.freeze({
	        'ADD_FIELD': BX.message('RS_B2B_REGISTRATION_ADD_FIELD')
	      });
	    },
	    component: function component() {
	      if (this.prop.FIELD_TYPE && (this.prop.FIELD_TYPE == 'INN' || this.prop.FIELD_TYPE === 'ORGANIZATION_NAME')) {
	        return SuggestField;
	      }

	      switch (this.prop.TYPE) {
	        case 'ENUM':
	        case 'SELECT':
	          return EnumField;

	        case 'FILE':
	          return FileField;

	        case 'LOCATION':
	          return LocationField;

	        case 'Y/N':
	          return CheckboxField;

	        case 'NUMBER':
	          return NumberField;

	        case 'DATE':
	          return DateField;

	        case 'STRING':
	        default:
	          if (this.prop.SETTINGS.MULTILINE === 'Y') return TextareaField;
	          return StringField;
	      }
	    },
	    fieldName: function fieldName() {
	      return 'COMPANY_PROP_' + this.prop.ID;
	    },
	    fieldId: function fieldId() {
	      return 'COMPANY_PROP_' + this.prop.ID;
	    },
	    isMultiple: function isMultiple() {
	      return this.prop.MULTIPLE == 'Y';
	    },
	    isRequired: function isRequired() {
	      return this.prop.REQUIRED === 'Y';
	    }
	  },
	  methods: {
	    addValue: function addValue() {
	      if (BX.type.isArray(this.value)) {
	        if (this.prop.TYPE == 'LOCATION') {
	          this.value.push(this.prop.OUTPUT_HTML.replace(/indexkey/g, this.value.length).replace(/(sls-\d+)/g, '$1_' + this.value.length));
	        } else {
	          this.value.push('');
	        }
	      }
	    }
	  }
	};

	/* script */
	var __vue_script__$9 = script$9;
	/* template */

	var __vue_render__$9 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [_vm.isMultiple ? _c("div", [_c("label", {
	    attrs: {
	      for: _vm.fieldId + "_0"
	    }
	  }, [_vm._v(_vm._s(_vm.prop.NAME) + " "), _vm.isRequired ? _c("span", {
	    staticClass: "text-danger"
	  }, [_vm._v("*")]) : _vm._e()]), _vm._v(" "), _vm.prop.TYPE == "ENUM" ? _c("div", [_c("EnumField", {
	    attrs: {
	      fieldName: _vm.fieldName + "[]",
	      fieldId: _vm.fieldId,
	      prop: _vm.prop,
	      value: _vm.value,
	      required: _vm.isRequired,
	      multiple: true
	    }
	  })], 1) : _c("div", [_vm._l(_vm.value, function (v, i) {
	    return _c("div", {
	      staticClass: "mb-3"
	    }, [_c(_vm.component, {
	      tag: "component",
	      attrs: {
	        fieldName: _vm.fieldName + "[]",
	        fieldId: _vm.fieldId + "_" + i,
	        value: _vm.value[i],
	        prop: _vm.prop
	      }
	    })], 1);
	  }), _vm._v(" "), _c("a", {
	    staticClass: "btn btn-primary",
	    attrs: {
	      href: "#"
	    },
	    on: {
	      click: function click($event) {
	        $event.preventDefault();
	        return _vm.addValue($event);
	      }
	    }
	  }, [_vm._v(_vm._s(_vm.messages.ADD_FIELD))])], 2)]) : _c("div", [_c("label", {
	    attrs: {
	      for: _vm.fieldId
	    }
	  }, [_vm._v(_vm._s(_vm.prop.NAME) + " "), _vm.isRequired ? _c("span", {
	    staticClass: "text-danger"
	  }, [_vm._v("*")]) : _vm._e()]), _vm._v(" "), _vm.prop.TYPE == "FILE" ? _c("FileField", {
	    attrs: {
	      fieldName: _vm.fieldName + "[]",
	      fieldId: _vm.fieldId,
	      prop: _vm.prop,
	      value: _vm.value,
	      required: _vm.isRequired
	    }
	  }) : _c(_vm.component, {
	    tag: "component",
	    attrs: {
	      fieldName: _vm.fieldName,
	      fieldId: _vm.fieldId,
	      prop: _vm.prop,
	      value: _vm.value,
	      required: _vm.isRequired
	    }
	  })], 1)]);
	};

	var __vue_staticRenderFns__$9 = [];
	__vue_render__$9._withStripped = true;
	/* style */

	var __vue_inject_styles__$9 = undefined;
	/* scoped */

	var __vue_scope_id__$9 = undefined;
	/* module identifier */

	var __vue_module_identifier__$9 = undefined;
	/* functional template */

	var __vue_is_functional_template__$9 = false;
	/* style inject */

	/* style inject SSR */

	var FormField = normalizeComponent_1({
	  render: __vue_render__$9,
	  staticRenderFns: __vue_staticRenderFns__$9
	}, __vue_inject_styles__$9, __vue_script__$9, __vue_scope_id__$9, __vue_is_functional_template__$9, __vue_module_identifier__$9, undefined, undefined);

	//
	var props = {
	  personTypes: Array,
	  orderProps: Array,
	  orderPropsGroups: Array
	};
	var components$1 = {
	  FormField: FormField
	};
	var script$a = {
	  components: components$1,
	  props: props,
	  data: function data() {
	    var _this = this;

	    var personType = 0;
	    var companyName = this.$root.values.COMPANY_NAME;

	    if (this.personTypes.length) {
	      if (this.personTypes.find(function (p) {
	        return p.ID == _this.$root.values.COMPANY_PERSON_TYPE;
	      })) {
	        personType = this.$root.values.COMPANY_PERSON_TYPE;
	      } else {
	        personType = this.personTypes[0].ID;
	      }
	    }

	    return {
	      personType: personType,
	      companyName: companyName
	    };
	  },
	  computed: {
	    messages: function messages() {
	      return Object.freeze({
	        'FIELD_PROFILE_NAME': BX.message('RS_B2B_REGISTRATION_FIELD_PROFILE_NAME')
	      });
	    },
	    groups: function groups() {
	      var _this2 = this;

	      return this.orderPropsGroups.filter(function (group) {
	        return group.PERSON_TYPE_ID == _this2.personType && _this2.filterPropsByGroup(group.ID).length;
	      });
	    },
	    skipProps: function skipProps() {
	      return this.orderProps.filter(function (prop) {
	        return prop.IS_LOCATION == 'Y';
	      }).map(function (prop) {
	        return prop.INPUT_FIELD_LOCATION;
	      });
	    },
	    props: function props() {
	      var _this3 = this;

	      return this.orderProps.filter(function (prop) {
	        return prop.PERSON_TYPE_ID == _this3.personType && !_this3.skipProps.includes(prop.ID);
	      });
	    },
	    locationProps: function locationProps() {
	      return this.props.filter(function (prop) {
	        return prop.TYPE == 'LOCATION';
	      });
	    }
	  },
	  methods: {
	    filterPropsByGroup: function filterPropsByGroup(groupId) {
	      return this.props.filter(function (prop) {
	        return prop.PROPS_GROUP_ID == groupId;
	      });
	    }
	  }
	};

	/* script */
	var __vue_script__$a = script$a;
	/* template */

	var __vue_render__$a = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [_c("div", {
	    staticClass: "row"
	  }, [_c("div", {
	    staticClass: "col-12 form-group"
	  }, [_c("select", {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: _vm.personType,
	      expression: "personType"
	    }],
	    staticClass: "form-control",
	    attrs: {
	      name: "COMPANY_PERSON_TYPE",
	      id: "COMPANY_PERSON_TYPE"
	    },
	    on: {
	      change: function change($event) {
	        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
	          return o.selected;
	        }).map(function (o) {
	          var val = "_value" in o ? o._value : o.value;
	          return val;
	        });
	        _vm.personType = $event.target.multiple ? $$selectedVal : $$selectedVal[0];
	      }
	    }
	  }, _vm._l(_vm.personTypes, function (personType) {
	    return _c("option", {
	      key: personType.ID,
	      domProps: {
	        value: personType.ID
	      }
	    }, [_vm._v(_vm._s(personType.NAME))]);
	  }), 0)])]), _vm._v(" "), _c("div", {
	    staticClass: "row"
	  }, [_c("div", {
	    staticClass: "col-12 form-group"
	  }, [_c("label", {
	    attrs: {
	      for: "COMPANY_NAME"
	    }
	  }, [_vm._v(_vm._s(_vm.messages.FIELD_PROFILE_NAME) + " "), _c("span", {
	    staticClass: "text-danger"
	  }, [_vm._v("*")])]), _vm._v(" "), _c("input", {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: _vm.companyName,
	      expression: "companyName"
	    }],
	    staticClass: "form-control",
	    attrs: {
	      type: "text",
	      name: "COMPANY_NAME",
	      id: "COMPANY_NAME",
	      required: ""
	    },
	    domProps: {
	      value: _vm.companyName
	    },
	    on: {
	      input: function input($event) {
	        if ($event.target.composing) {
	          return;
	        }

	        _vm.companyName = $event.target.value;
	      }
	    }
	  })])]), _vm._v(" "), _vm._l(_vm.groups, function (group) {
	    return _c("div", {
	      key: group.ID
	    }, [_c("div", {
	      staticClass: "kt-heading kt-heading--md"
	    }, [_vm._v(_vm._s(group.NAME))]), _vm._v(" "), _c("div", {
	      staticClass: "row"
	    }, _vm._l(_vm.filterPropsByGroup(group.ID), function (prop) {
	      return _c("div", {
	        key: prop.ID,
	        staticClass: "col-12 col-md-6 form-group"
	      }, [_c("FormField", {
	        attrs: {
	          prop: prop
	        }
	      })], 1);
	    }), 0)]);
	  })], 2);
	};

	var __vue_staticRenderFns__$a = [];
	__vue_render__$a._withStripped = true;
	/* style */

	var __vue_inject_styles__$a = undefined;
	/* scoped */

	var __vue_scope_id__$a = undefined;
	/* module identifier */

	var __vue_module_identifier__$a = undefined;
	/* functional template */

	var __vue_is_functional_template__$a = false;
	/* style inject */

	/* style inject SSR */

	var VueCreateCompanyForm = normalizeComponent_1({
	  render: __vue_render__$a,
	  staticRenderFns: __vue_staticRenderFns__$a
	}, __vue_inject_styles__$a, __vue_script__$a, __vue_scope_id__$a, __vue_is_functional_template__$a, __vue_module_identifier__$a, undefined, undefined);

	var valGetParentContainer = function valGetParentContainer(element) {
	  var element = $(element);

	  if ($(element).closest('.form-group-sub').length > 0) {
	    return $(element).closest('.form-group-sub');
	  } else if ($(element).closest('.bootstrap-select').length > 0) {
	    return $(element).closest('.bootstrap-select');
	  } else {
	    return $(element).closest('.form-group');
	  }
	};

	var createValidator = function createValidator($form) {
	  return $form.validate({
	    ignore: ":hidden",
	    errorPlacement: function errorPlacement(error, element) {
	      var element = $(element);
	      var element = $(element);
	      var group = valGetParentContainer(element);
	      var help = group.find('.form-text');

	      if (group.find('.valid-feedback, .invalid-feedback').length !== 0) {
	        return;
	      }

	      element.addClass('is-invalid');
	      error.addClass('invalid-feedback');

	      if (help.length > 0) {
	        help.before(error);
	      } else {
	        if (element.closest('.bootstrap-select').length > 0) {
	          element.closest('.bootstrap-select').find('.bs-placeholder').after(error);
	        } else if (element.closest('.input-group').length > 0 || element.closest('.kt-input-icon').length > 0) {
	          element.parent().after(error);
	        } else {
	          if (element.is(':checkbox')) {
	            element.closest('.kt-checkbox').find('> span').after(error);
	          } else {
	            element.after(error);
	          }
	        }
	      }
	    },
	    rules: {
	      USER_CONFIRM_PASSWORD: {
	        equalTo: "input[name=\"USER_PASSWORD\"]"
	      }
	    }
	  });
	};

	var RegistrationForm = /*#__PURE__*/function () {
	  function RegistrationForm(el, data) {
	    var _this = this;

	    babelHelpers.classCallCheck(this, RegistrationForm);
	    this.el = el;
	    this.data = data;
	    this.form = this.el.querySelector('form');
	    this.wizard = new KTWizard(this.el);
	    this.validator = createValidator($(this.form));
	    this.wizard.on('beforeNext', function (wizardObj) {
	      if (!_this.validator.form()) wizardObj.stop();
	    });
	    this.attachCreateCompanyForm();
	  }

	  babelHelpers.createClass(RegistrationForm, [{
	    key: "attachCreateCompanyForm",
	    value: function attachCreateCompanyForm() {
	      var el = this.el.querySelector('[data-form="create_company"]');
	      var components = {
	        VueCreateCompanyForm: VueCreateCompanyForm
	      };
	      var _this$data = this.data,
	          personTypes = _this$data.personTypes,
	          orderProps = _this$data.orderProps,
	          orderPropsGroups = _this$data.orderPropsGroups,
	          values = _this$data.values;
	      this.createCompanyForm = new Vue({
	        el: el,
	        components: components,
	        data: function data() {
	          return {
	            personTypes: personTypes,
	            orderProps: orderProps,
	            orderPropsGroups: orderPropsGroups,
	            values: values
	          };
	        },
	        template: "\n\t\t\t\t<VueCreateCompanyForm \n\t\t\t\t\t:personTypes=\"personTypes\"\n\t\t\t\t\t:orderProps=\"orderProps\"\n\t\t\t\t\t:orderPropsGroups=\"orderPropsGroups\"\n\t\t\t\t/>\n\t\t\t"
	      });
	    }
	  }]);
	  return RegistrationForm;
	}();

	exports.RegistrationForm = RegistrationForm;

}((this.B2BPortal.Components = this.B2BPortal.Components || {})));
//# sourceMappingURL=RegistrationForm.js.map
