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
	    pathToOrder: {
	      type: String,
	      "default": ''
	    },
	    summary: {
	      type: Object,
	      "default": function _default() {}
	    },
	    exportTypes: {
	      type: Array,
	      "default": function _default() {
	        return [];
	      }
	    }
	  },
	  computed: {
	    localize: function localize() {
	      return Object.freeze({
	        "SBB_ITEMS_COUNT": BX.message('SBB_ITEMS_COUNT'),
	        "SBB_WEIGHT": BX.message('SBB_WEIGHT'),
	        "SBB_VAT": BX.message('SBB_VAT'),
	        "SBB_EXPORT": BX.message('SBB_EXPORT'),
	        "SBB_TOTAL": BX.message('SBB_TOTAL'),
	        "SBB_ORDER": BX.message('SBB_ORDER')
	      });
	    }
	  },
	  methods: {
	    exportPath: function exportPath(type) {
	      var uri = new BX.Uri(window.location.pathname || '');
	      uri.setQueryParam('export', type);
	      return uri.toString();
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
	    staticClass: "row align-items-center",
	    attrs: {
	      summary: _vm.summary
	    }
	  }, [_c("div", {
	    staticClass: "col-12 text-right"
	  }, [_c("div", {
	    staticClass: "form-group"
	  }, [_vm.summary.count > 0 ? _c("div", [_vm._v("\n\t\t\t\t" + _vm._s(_vm.localize.SBB_ITEMS_COUNT) + ": " + _vm._s(_vm.summary.count) + "\n\t\t\t")]) : _vm._e(), _vm._v(" "), _vm.summary.allWeight > 0 ? _c("div", [_vm._v("\n\t\t\t\t" + _vm._s(_vm.localize.SBB_WEIGHT) + ": " + _vm._s(_vm.summary.allWeight_FORMATED) + "\n\t\t\t")]) : _vm._e(), _vm._v(" "), _vm.summary.allVATSum > 0 ? _c("div", [_vm._v("\n\t\t\t\t" + _vm._s(_vm.localize.SBB_VAT) + ": "), _c("span", {
	    domProps: {
	      innerHTML: _vm._s(_vm.summary.allVATSum_FORMATED)
	    }
	  })]) : _vm._e(), _vm._v(" "), _vm.summary.allSum > 0 ? _c("div", [_c("strong", [_vm._v(_vm._s(_vm.localize.SBB_TOTAL))]), _vm._v(": "), _c("span", {
	    domProps: {
	      innerHTML: _vm._s(_vm.summary.allSum_FORMATED)
	    }
	  })]) : _vm._e()]), _vm._v(" "), _vm.exportTypes.length ? _c("div", {
	    staticClass: "dropdown dropdown-inline"
	  }, [_c("a", {
	    staticClass: "btn btn-outline-primary dropdown-toggle",
	    attrs: {
	      href: "#",
	      role: "button",
	      "data-toggle": "dropdown",
	      "aria-expanded": "true"
	    }
	  }, [_vm._v("\n\t\t\t\t" + _vm._s(_vm.localize.SBB_EXPORT) + "\n\t\t\t")]), _vm._v(" "), _c("div", {
	    staticClass: "dropdown-menu dropdown-menu-right"
	  }, [_c("ul", {
	    staticClass: "kt-nav"
	  }, _vm._l(_vm.exportTypes, function (type, index) {
	    return _c("li", {
	      key: index,
	      staticClass: "kt-nav__item"
	    }, [_c("a", {
	      staticClass: "kt-nav__link",
	      attrs: {
	        href: _vm.exportPath(type),
	        target: "_blank"
	      }
	    }, [_c("i", {
	      staticClass: "kt-nav__link-icon la la-file-text-o"
	    }), _vm._v(" "), _c("span", {
	      staticClass: "kt-nav__link-text text-uppercase"
	    }, [_vm._v(_vm._s(type))])])]);
	  }), 0)])]) : _vm._e(), _vm._v(" "), _vm.pathToOrder ? [_c("a", {
	    staticClass: "btn btn-primary",
	    attrs: {
	      href: _vm.pathToOrder
	    }
	  }, [_vm._v(_vm._s(_vm.localize.SBB_ORDER))])] : _vm._e()], 2)]);
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

	/* style inject shadow dom */

	var __vue_component__ = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__,
	  staticRenderFns: __vue_staticRenderFns__
	}, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, false, undefined, undefined, undefined);

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
	var script$1 = {
	  store: B2BPortal.store,
	  computed: {
	    baskets: function baskets() {
	      return this.$store.getters.notSelectedBaskets;
	    },
	    messages: function messages() {
	      return Object.freeze(Object.keys(BX.message).filter(function (message) {
	        return message.startsWith('SBB');
	      }).reduce(function (obj, message) {
	        obj[message.slice(message)] = BX.message(message);
	        return obj;
	      }, {}));
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

	  return _c("ul", {
	    staticClass: "kt-nav"
	  }, [_c("li", {
	    staticClass: "kt-nav__item"
	  }, [_c("a", {
	    staticClass: "kt-nav__link",
	    attrs: {
	      "data-target": "#modalImportFile",
	      "data-toggle": "modal",
	      href: "#"
	    },
	    on: {
	      click: function click($event) {
	        $event.preventDefault();
	        return _vm.$emit("remove");
	      }
	    }
	  }, [_c("i", {
	    staticClass: "kt-nav__link-icon flaticon2-trash"
	  }), _vm._v(" "), _c("span", {
	    staticClass: "kt-nav__link-text"
	  }, [_vm._v(_vm._s(_vm.messages.SBB_DELETE))])])]), _vm._v(" "), _vm._l(_vm.baskets, function (basket) {
	    return _c("li", {
	      key: basket.ID,
	      staticClass: "kt-nav__item"
	    }, [_c("a", {
	      staticClass: "kt-nav__link",
	      attrs: {
	        "data-target": "#modalImportFile",
	        "data-toggle": "modal",
	        href: "#"
	      },
	      on: {
	        click: function click($event) {
	          $event.preventDefault();
	          return _vm.$emit("move", basket);
	        }
	      }
	    }, [_c("i", {
	      staticClass: "kt-nav__link-icon flaticon2-shopping-cart-1"
	    }), _vm._v(" "), _c("span", {
	      staticClass: "kt-nav__link-text"
	    }, [_vm._v(_vm._s(_vm.messages.SBB_MOVE) + " "), _c("span", {
	      staticClass: "text-decoration-underline"
	    }, [_vm._v(_vm._s(basket.NAME))])])])]);
	  })], 2);
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

	/* style inject shadow dom */

	var __vue_component__$1 = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$1,
	  staticRenderFns: __vue_staticRenderFns__$1
	}, __vue_inject_styles__$1, __vue_script__$1, __vue_scope_id__$1, __vue_is_functional_template__$1, __vue_module_identifier__$1, false, undefined, undefined, undefined);

	//
	//
	//
	var script$2 = {
	  props: {
	    src: String,
	    title: String
	  },
	  mounted: function mounted() {
	    var _this = this;

	    this.$nextTick(function () {
	      $(_this.$refs.image).popover({
	        trigger: 'hover',
	        placement: 'right',
	        boundary: 'window',
	        html: true,
	        title: '',
	        content: function content() {
	          return "<img class=\"img-fluid\" src=\"".concat(this.src, "\" />");
	        }
	      });
	    });
	  }
	};

	/* script */
	var __vue_script__$2 = script$2;
	/* template */

	var __vue_render__$2 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("img", {
	    ref: "image",
	    staticClass: "img-fluid",
	    attrs: {
	      src: _vm.src,
	      alt: _vm.title
	    }
	  });
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

	/* style inject shadow dom */

	var __vue_component__$2 = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$2,
	  staticRenderFns: __vue_staticRenderFns__$2
	}, __vue_inject_styles__$2, __vue_script__$2, __vue_scope_id__$2, __vue_is_functional_template__$2, __vue_module_identifier__$2, false, undefined, undefined, undefined);

	//
	var script$3 = {
	  components: {
	    BasketTableActions: __vue_component__$1,
	    VueTable: B2BPortal.Vue.Components.VueTable,
	    VueStockQuantity: B2BPortal.Vue.Components.StockQuantity,
	    VueQuantityInput: B2BPortal.Vue.Components.QuantityInput,
	    ImageField: __vue_component__$2
	  },
	  props: {
	    columns: {
	      type: Array,
	      "default": function _default() {
	        return [];
	      }
	    },
	    rows: {
	      type: Array,
	      "default": function _default() {
	        return [];
	      }
	    },
	    params: {
	      type: Object,
	      "default": function _default() {}
	    }
	  },
	  data: function data() {
	    return {
	      searchQuery: ''
	    };
	  },
	  computed: {
	    messages: function messages() {
	      return Object.freeze(Object.keys(BX.message).filter(function (message) {
	        return message.startsWith('SBB');
	      }).reduce(function (obj, message) {
	        obj[message.slice(message)] = BX.message(message);
	        return obj;
	      }, {}));
	    }
	  },
	  mounted: function mounted() {
	    var _this = this;

	    (this.$root.eventBus || this).$on('inputSearchQuery', function (value) {
	      _this.searchQuery = value;
	    });
	  },
	  methods: {
	    handleQuantityAction: function handleQuantityAction(row) {
	      if (!row.CHECK_MAX_QUANTITY || row.CHECK_MAX_QUANTITY && row.QUANTITY <= row.AVAILABLE_QUANTITY) {
	        (this.$root.eventBus || this).$emit('updateItemQuantity', {
	          itemId: row.ID,
	          productId: row.PRODUCT_ID,
	          quantity: row.QUANTITY
	        });
	      }
	    },
	    handleRemoveAction: function handleRemoveAction(row) {
	      (this.$root.eventBus || this).$emit('removeItem', row.ID);
	    },
	    handleMoveAction: function handleMoveAction(row, toBasket) {
	      (this.$root.eventBus || this).$emit('moveItem', row.PRODUCT_ID, toBasket.CODE);
	    },
	    handleSelectedRowsChange: function handleSelectedRowsChange(params) {
	      (this.$root.eventBus || this).$emit('selectedRowsChange', params.selectedRows);
	    },
	    searchFn: function searchFn(value, searchTerm) {
	      return String(value).toLowerCase().indexOf(String(searchTerm).toLowerCase()) > -1;
	    },
	    handleSearch: function handleSearch(row, col, cellValue, searchTerm) {
	      var isFind = false;
	      isFind = this.searchFn(cellValue, searchTerm);

	      if (!isFind && col.field == 'NAME') {
	        isFind = this.searchFn(row.ARTICLE, searchTerm);
	      }

	      return isFind;
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
	var __vue_script__$3 = script$3;
	/* template */

	var __vue_render__$3 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("VueTable", {
	    staticClass: "vgt-responsive-static",
	    attrs: {
	      columns: _vm.columns,
	      rows: _vm.rows,
	      selectOptions: {
	        enabled: true
	      },
	      "search-options": {
	        enabled: true,
	        externalQuery: _vm.searchQuery,
	        searchFn: _vm.handleSearch
	      },
	      "max-height": "700px",
	      "fixed-header": true
	    },
	    on: {
	      "on-selected-rows-change": _vm.handleSelectedRowsChange
	    },
	    scopedSlots: _vm._u([{
	      key: "table-row",
	      fn: function fn(props) {
	        return [props.column.field == "NAME" ? [_c("div", {
	          staticStyle: {
	            "max-width": "275px"
	          }
	        }, [_c("div", {
	          staticClass: "d-flex align-items-center"
	        }, [props.row.PICTURE ? _c("div", {
	          staticClass: "mr-3 mt-2 cart-preview-picture"
	        }, [_c("ImageField", {
	          attrs: {
	            src: props.row.PICTURE,
	            title: props.row.NAME
	          }
	        })], 1) : _vm._e(), _vm._v(" "), _c("div", {
	          staticClass: "d-block"
	        }, [_c("div", {
	          staticClass: "mb-2"
	        }, [_c("span", {
	          staticClass: "mr-2"
	        }, [props.row.URL ? _c("a", {
	          attrs: {
	            href: props.row.URL,
	            target: "_blank"
	          }
	        }, [_vm._v(_vm._s(props.row.NAME))]) : _c("span", [_vm._v(_vm._s(props.row.NAME))])]), _vm._v(" "), props.row.NOT_AVAILABLE ? _c("div", {
	          staticClass: "text-danger"
	        }, [_vm._v("\n\t\t\t\t\t\t\t\t" + _vm._s(_vm.messages.SBB_BASKET_ITEM_NOT_AVAILABLE) + "\n\t\t\t\t\t\t\t")]) : _vm._e()]), _vm._v(" "), _c("div", [props.row.ARTICLE ? _c("span", {
	          staticClass: "mr-3"
	        }, [_vm._v(_vm._s(_vm.messages.SBB_ARTICLE) + " " + _vm._s(props.row.ARTICLE))]) : _vm._e(), _vm._v(" "), _vm.params.showQuantity ? _c("span", {
	          staticClass: "mr-2"
	        }, [_c("VueStockQuantity", {
	          attrs: {
	            displayMode: _vm.params.quantityDisplayMode,
	            mess: _vm.params.quantityMessages,
	            relativeQuantityFactor: Number(_vm.params.quantityRelativeFactor),
	            quantity: Number(props.row.AVAILABLE_QUANTITY),
	            measure: props.row.MEASURE_TEXT,
	            useStocks: _vm.params.useStocks,
	            displayStocks: _vm.params.displayStocks,
	            productId: props.row.PRODUCT_ID,
	            maxQuantity: _vm.params.maxQuantity
	          }
	        })], 1) : _vm._e()])])])])] : _vm._e(), _vm._v(" "), props.column.field == "QUANTITY" ? [_c("div", {
	          staticClass: "product-amount form-inline d-inline-block mw-100",
	          attrs: {
	            "data-entity": "quantity-block"
	          }
	        }, [_c("div", {
	          staticClass: "form-group"
	        }, [_c("VueQuantityInput", {
	          attrs: {
	            min: Number(props.row.MEASURE_RATIO),
	            max: props.row.CHECK_MAX_QUANTITY ? props.row.AVAILABLE_QUANTITY : 999999,
	            step: Number(props.row.MEASURE_RATIO),
	            "is-invalid": props.row.CHECK_MAX_QUANTITY && props.row.QUANTITY > props.row.AVAILABLE_QUANTITY,
	            "is-disabled": props.row.NOT_AVAILABLE
	          },
	          on: {
	            change: function change($event) {
	              return _vm.handleQuantityAction(props.row);
	            }
	          },
	          model: {
	            value: props.row.QUANTITY,
	            callback: function callback($$v) {
	              _vm.$set(props.row, "QUANTITY", $$v);
	            },
	            expression: "props.row.QUANTITY"
	          }
	        })], 1)])] : _vm._e(), _vm._v(" "), props.column.field == "PRICE" ? [_c("div", {
	          staticClass: "text-nowrap",
	          domProps: {
	            innerHTML: _vm._s(props.row.PRICE_FORMATTED)
	          }
	        })] : _vm._e(), _vm._v(" "), props.column.field == "SUM_PRICE" ? [_c("div", {
	          staticClass: "font-weight-bold text-nowrap",
	          domProps: {
	            innerHTML: _vm._s(props.row.SUM_PRICE_FORMATTED)
	          }
	        })] : _vm._e(), _vm._v(" "), props.column.field == "ACTIONS" ? [_c("div", {
	          staticClass: "dropdown"
	        }, [_c("a", {
	          staticClass: "btn btn-sm btn-clean btn-icon btn-icon-md",
	          attrs: {
	            "data-toggle": "dropdown",
	            "data-boundary": "viewport",
	            role: "button",
	            href: "#"
	          }
	        }, [_c("i", {
	          staticClass: "la la-ellipsis-h"
	        })]), _vm._v(" "), _c("div", {
	          staticClass: "dropdown-menu dropdown-menu-right"
	        }, [_c("BasketTableActions", {
	          on: {
	            remove: function remove($event) {
	              return _vm.handleRemoveAction(props.row);
	            },
	            move: function move($event) {
	              return _vm.handleMoveAction(props.row, arguments[0]);
	            }
	          }
	        })], 1)])] : _vm._e()];
	      }
	    }])
	  }, [_vm._v(" "), _c("div", {
	    attrs: {
	      slot: "emptystate"
	    },
	    slot: "emptystate"
	  }, [_c("div", {
	    staticClass: "text-center py-5 my-5"
	  }, [_vm._v(_vm._s(_vm.messages.SBB_EMPTY_BASKET_TITLE))])])]);
	};

	var __vue_staticRenderFns__$3 = [];
	__vue_render__$3._withStripped = true;
	/* style */

	var __vue_inject_styles__$3 = function __vue_inject_styles__(inject) {
	  if (!inject) return;
	  inject("data-v-62b00543_0", {
	    source: "\n.cart-preview-picture[data-v-62b00543] {\n\twidth: 3.75rem;\n    text-align: center;\n}\n.cart-preview-picture img[data-v-62b00543] {\n\tmax-height: 3.75rem;\n}\n\n",
	    map: undefined,
	    media: undefined
	  });
	};
	/* scoped */


	var __vue_scope_id__$3 = "data-v-62b00543";
	/* module identifier */

	var __vue_module_identifier__$3 = undefined;
	/* functional template */

	var __vue_is_functional_template__$3 = false;
	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__$3 = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$3,
	  staticRenderFns: __vue_staticRenderFns__$3
	}, __vue_inject_styles__$3, __vue_script__$3, __vue_scope_id__$3, __vue_is_functional_template__$3, __vue_module_identifier__$3, false, browser, undefined, undefined);

	function _regeneratorRuntime() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return generator._invoke = function (innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; }(innerFn, self, context), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == babelHelpers["typeof"](value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; this._invoke = function (method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); }; } function maybeInvokeDelegate(delegate, context) { var method = delegate.iterator[context.method]; if (undefined === method) { if (context.delegate = null, "throw" === context.method) { if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel; context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method"); } return ContinueSentinel; } var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) { if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; } return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, "constructor", GeneratorFunctionPrototype), define(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (object) { var keys = []; for (var key in object) { keys.push(key); } return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) { "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); } }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
	var _B2BPortal = B2BPortal,
	    store = _B2BPortal.store;
	var NOTIFY_DEFAULT_OPTIONS = {
	  extendedTimeOut: 5000,
	  progressBar: true,
	  tapToDismiss: false
	};

	var sendNotify = function sendNotify(status, message, options) {
	  return window.toastr[status](message, '', Object.assign(NOTIFY_DEFAULT_OPTIONS, options));
	};

	var getRemoveRequestData = function getRemoveRequestData(ids) {
	  return ids.reduce(function (data, id) {
	    data['DELETE_' + id] = 'Y';
	    return data;
	  }, {});
	};

	var getRestoreRequestData = function getRestoreRequestData(ids, rows) {
	  return ids.reduce(function (data, id) {
	    if (rows[id]) {
	      data['RESTORE_' + id] = {
	        'PRODUCT_ID': rows[id].PRODUCT_ID,
	        'QUANTITY': rows[id].QUANTITY,
	        'PROPS': rows[id].PROPS_ALL,
	        'SORT': rows[id].SORT,
	        'MODULE': rows[id].MODULE,
	        'PRODUCT_PROVIDER_CLASS': rows[id].PRODUCT_PROVIDER_CLASS
	      };
	    }

	    return data;
	  }, {});
	};

	var Basket = /*#__PURE__*/function () {
	  function Basket(params) {
	    var _this = this;

	    babelHelpers.classCallCheck(this, Basket);
	    this.elementId = params.elementId;
	    this.$el = params.elementId ? document.getElementById(params.elementId) : document.createElement('div');
	    this.$searchInput = params.searchInput;
	    this.columns = params.columns || [];
	    this.rows = params.rows || [];
	    this.summary = params.summary || [];
	    this.showQuantity = params.showQuantity;

	    if (this.showQuantity) {
	      this.quantityDisplayMode = params.quantityDisplayMode;
	      this.quantityRelativeFactor = params.quantityRelativeFactor;
	      this.quantityMessages = params.quantityMessages;
	      this.useStocks = params.useStocks;
	      this.displayStocks = params.displayStocks;
	      this.maxQuantity = params.maxQuantity;
	    }

	    this.groupedRows = {};
	    this.rows.forEach(function (row) {
	      _this.groupedRows[row.ID] = row;
	    });
	    this.selectedRows = [];
	    this.pathToOrder = params.pathToOrder || '';
	    this.signedParameters = params.signedParameters || '';
	    this.signedTemplate = params.template || '';
	    this.siteId = params.siteId || '';
	    this.siteTemplateId = params.siteTemplateId || '';
	    this.actionVariable = params.actionVariable || basketAction;
	    this.ajaxUrl = params.ajaxUrl || '/bitrix/components/bitrix/sale.basket.basket/ajax.php';
	    this.exportTypes = params.exportTypes;
	    this.discountList = params.discountList || [];
	    this.eventBus = new Vue();
	    this.handleEvents();
	    this.attachTemplate();
	    this.attachActions();
	    this.attachSummary();
	    this.checkTools();
	  }

	  babelHelpers.createClass(Basket, [{
	    key: "handleEvents",
	    value: function handleEvents() {
	      var _this2 = this;

	      this.$searchInput.addEventListener('input', function (e) {
	        _this2.eventBus.$emit('inputSearchQuery', e.target.value);
	      });
	      this.eventBus.$on('updateItemQuantity', this.updateItemQuantity.bind(this));
	      this.eventBus.$on('removeItem', this.removeItem.bind(this));
	      this.eventBus.$on('removeSelectedItems', this.removeSelectedItems.bind(this));
	      this.eventBus.$on('moveItem', this.moveItem.bind(this));
	      this.eventBus.$on('moveSelectedItems', this.moveSelectedItems.bind(this));
	      this.eventBus.$on('selectedRowsChange', this.selectedRowsChange.bind(this));
	      BX.addCustomEvent('updateBasketComponent', this.recalculate.bind(this));
	    }
	  }, {
	    key: "updateItemQuantity",
	    value: function () {
	      var _updateItemQuantity = babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(_ref) {
	        var itemId, productId, quantity, requestData, result;
	        return _regeneratorRuntime().wrap(function _callee$(_context) {
	          while (1) {
	            switch (_context.prev = _context.next) {
	              case 0:
	                itemId = _ref.itemId, productId = _ref.productId, quantity = _ref.quantity;
	                requestData = {
	                  basket: {}
	                };
	                requestData.basket['QUANTITY_' + itemId] = quantity;
	                _context.next = 5;
	                return this.sendRequest(requestData);

	              case 5:
	                result = _context.sent;
	                this.applyBasketData(result.BASKET_DATA);
	                store.commit('cart/SET_QUANTITY', {
	                  itemId: Number(productId),
	                  quantity: Number(quantity)
	                });
	                store.dispatch('cart/fetch');

	              case 9:
	              case "end":
	                return _context.stop();
	            }
	          }
	        }, _callee, this);
	      }));

	      function updateItemQuantity(_x) {
	        return _updateItemQuantity.apply(this, arguments);
	      }

	      return updateItemQuantity;
	    }()
	  }, {
	    key: "selectedRowsChange",
	    value: function selectedRowsChange(rows) {
	      this.selectedRows = rows;
	    }
	  }, {
	    key: "removeItem",
	    value: function () {
	      var _removeItem = babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2(itemId) {
	        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
	          while (1) {
	            switch (_context2.prev = _context2.next) {
	              case 0:
	                this.showLoading();
	                this.removeItems([itemId]);
	                this.hideLoading();

	              case 3:
	              case "end":
	                return _context2.stop();
	            }
	          }
	        }, _callee2, this);
	      }));

	      function removeItem(_x2) {
	        return _removeItem.apply(this, arguments);
	      }

	      return removeItem;
	    }()
	  }, {
	    key: "removeSelectedItems",
	    value: function () {
	      var _removeSelectedItems = babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
	        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
	          while (1) {
	            switch (_context3.prev = _context3.next) {
	              case 0:
	                this.showLoading();

	                if (this.selectedRows.length > 0) {
	                  this.removeItems(this.selectedRows.map(function (row) {
	                    return row.ID;
	                  }));
	                }

	                this.hideLoading();

	              case 3:
	              case "end":
	                return _context3.stop();
	            }
	          }
	        }, _callee3, this);
	      }));

	      function removeSelectedItems() {
	        return _removeSelectedItems.apply(this, arguments);
	      }

	      return removeSelectedItems;
	    }()
	  }, {
	    key: "moveItem",
	    value: function () {
	      var _moveItem = babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4(productId, toBasketCode) {
	        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
	          while (1) {
	            switch (_context4.prev = _context4.next) {
	              case 0:
	                this.showLoading();
	                this.moveItems([productId], toBasketCode);
	                this.hideLoading();

	              case 3:
	              case "end":
	                return _context4.stop();
	            }
	          }
	        }, _callee4, this);
	      }));

	      function moveItem(_x3, _x4) {
	        return _moveItem.apply(this, arguments);
	      }

	      return moveItem;
	    }()
	  }, {
	    key: "moveSelectedItems",
	    value: function () {
	      var _moveSelectedItems = babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee5(toBasketId) {
	        return _regeneratorRuntime().wrap(function _callee5$(_context5) {
	          while (1) {
	            switch (_context5.prev = _context5.next) {
	              case 0:
	                this.showLoading();

	                if (this.selectedRows.length > 0) {
	                  this.moveItems(this.selectedRows.map(function (row) {
	                    return row.PRODUCT_ID;
	                  }), toBasketId);
	                }

	                this.hideLoading();

	              case 3:
	              case "end":
	                return _context5.stop();
	            }
	          }
	        }, _callee5, this);
	      }));

	      function moveSelectedItems(_x5) {
	        return _moveSelectedItems.apply(this, arguments);
	      }

	      return moveSelectedItems;
	    }()
	  }, {
	    key: "moveItems",
	    value: function () {
	      var _moveItems = babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee6(productIds, toBasketCode) {
	        var result, resultData, successItems, successIds, failedItems, failedIds;
	        return _regeneratorRuntime().wrap(function _callee6$(_context6) {
	          while (1) {
	            switch (_context6.prev = _context6.next) {
	              case 0:
	                _context6.prev = 0;
	                _context6.next = 3;
	                return new Promise(function (resolve, reject) {
	                  BX.ajax.runAction('redsign:vbasket.api.userbasket.moveMultiple', {
	                    data: {
	                      productIds: productIds,
	                      toBasketCode: toBasketCode
	                    }
	                  }).then(resolve, reject);
	                });

	              case 3:
	                result = _context6.sent;
	                resultData = result.data;
	                successItems = resultData.filter(function (item) {
	                  return item.isSuccess;
	                });
	                successIds = successItems.map(function (item) {
	                  return item.productId;
	                });
	                failedItems = resultData.filter(function (itemStatus) {
	                  return !itemStatus.isSuccess;
	                });
	                failedIds = failedItems.map(function (item) {
	                  return item.productId;
	                });
	                this.deleteRowsByFieldValues('PRODUCT_ID', successIds);
	                this.checkTools();

	                if (successIds.length) {
	                  sendNotify('success', successIds.length === 1 ? BX.message('SBB_GOOD_SUCCESS_MOVED') : BX.message('SBB_GOODS_SUCCESS_MOVED'));
	                }

	                if (failedIds.length) {
	                  sendNotify('success', BX.message('SBB_GOODS_FAIL_MOVED'));
	                }

	                if (B2BPortal.store) {
	                  B2BPortal.store.dispatch('fetchBasket');
	                  store.dispatch('cart/fetch');
	                }

	                _context6.next = 20;
	                break;

	              case 16:
	                _context6.prev = 16;
	                _context6.t0 = _context6["catch"](0);
	                console.error(_context6.t0);
	                window.toastr.error((_context6.t0.errors || [{}])[0].message);

	              case 20:
	              case "end":
	                return _context6.stop();
	            }
	          }
	        }, _callee6, this, [[0, 16]]);
	      }));

	      function moveItems(_x6, _x7) {
	        return _moveItems.apply(this, arguments);
	      }

	      return moveItems;
	    }()
	  }, {
	    key: "removeItems",
	    value: function () {
	      var _removeItems = babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee7(ids) {
	        var _this3 = this;

	        var basketData, result, deletedIds;
	        return _regeneratorRuntime().wrap(function _callee7$(_context7) {
	          while (1) {
	            switch (_context7.prev = _context7.next) {
	              case 0:
	                basketData = getRemoveRequestData(ids);
	                _context7.prev = 1;
	                _context7.next = 4;
	                return this.sendRequest({
	                  basket: basketData
	                });

	              case 4:
	                result = _context7.sent;
	                deletedIds = result.DELETED_BASKET_ITEMS;

	                if (deletedIds.length === 0) ;

	                this.rows.filter(function (row) {
	                  return deletedIds.includes(Number(row.ID));
	                }).forEach(function (row) {
	                  store.commit('cart/REMOVE_ITEM_FROM_CART', {
	                    itemId: Number(row.PRODUCT_ID)
	                  });
	                });
	                this.applyBasketData(result.BASKET_DATA);
	                this.deleteRowsByIds(deletedIds);
	                this.checkTools();
	                sendNotify('success', deletedIds.length === 1 ? BX.message('SBB_BASKET_ITEM_DELETED').replace('#NAME#', this.groupedRows[deletedIds[0]].NAME) : BX.message('SBB_BASKET_ITEMS_DELETED'), {
	                  onclick: function onclick(e) {
	                    if (e.target.tagName == 'A') {
	                      e.preventDefault();

	                      _this3.restoreItems(deletedIds);
	                    }

	                    window.toastr.clear($(e.target).closest('.toast'), {
	                      force: true
	                    });
	                  }
	                });
	                store.dispatch('fetchBasket');
	                store.dispatch('cart/fetch');
	                _context7.next = 20;
	                break;

	              case 16:
	                _context7.prev = 16;
	                _context7.t0 = _context7["catch"](1);
	                console.warn(_context7.t0);
	                window.toastr.error(_context7.t0);

	              case 20:
	              case "end":
	                return _context7.stop();
	            }
	          }
	        }, _callee7, this, [[1, 16]]);
	      }));

	      function removeItems(_x8) {
	        return _removeItems.apply(this, arguments);
	      }

	      return removeItems;
	    }()
	  }, {
	    key: "restoreItems",
	    value: function () {
	      var _restoreItems = babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee9(ids) {
	        var _this4 = this;

	        var basketData;
	        return _regeneratorRuntime().wrap(function _callee9$(_context9) {
	          while (1) {
	            switch (_context9.prev = _context9.next) {
	              case 0:
	                basketData = getRestoreRequestData(ids, this.groupedRows);
	                _context9.prev = 1;
	                return _context9.delegateYield( /*#__PURE__*/_regeneratorRuntime().mark(function _callee8() {
	                  var result, _loop, restoredItemId;

	                  return _regeneratorRuntime().wrap(function _callee8$(_context8) {
	                    while (1) {
	                      switch (_context8.prev = _context8.next) {
	                        case 0:
	                          _context8.next = 2;
	                          return _this4.sendRequest({
	                            basket: basketData
	                          });

	                        case 2:
	                          result = _context8.sent;

	                          _loop = function _loop(restoredItemId) {
	                            if (result.RESTORED_BASKET_ITEMS.hasOwnProperty(restoredItemId)) {
	                              _this4.addRow(result.BASKET_DATA.ROWS.find(function (row) {
	                                return row.ID == result.RESTORED_BASKET_ITEMS[restoredItemId];
	                              }));
	                            }
	                          };

	                          for (restoredItemId in result.RESTORED_BASKET_ITEMS) {
	                            _loop(restoredItemId);
	                          }

	                          sendNotify('info', BX.message('SBB_BASKET_ITEM_RESTORED'));

	                          if (B2BPortal.store) {
	                            B2BPortal.store.dispatch('fetchBasket');
	                            store.dispatch('cart/fetch');
	                          }

	                        case 7:
	                        case "end":
	                          return _context8.stop();
	                      }
	                    }
	                  }, _callee8);
	                })(), "t0", 3);

	              case 3:
	                _context9.next = 9;
	                break;

	              case 5:
	                _context9.prev = 5;
	                _context9.t1 = _context9["catch"](1);
	                console.warn(_context9.t1);
	                sendNotify('error', BX.message('SBB_BASKET_RESTORE_FAIL'));

	              case 9:
	              case "end":
	                return _context9.stop();
	            }
	          }
	        }, _callee9, this, [[1, 5]]);
	      }));

	      function restoreItems(_x9) {
	        return _restoreItems.apply(this, arguments);
	      }

	      return restoreItems;
	    }()
	  }, {
	    key: "applyBasketData",
	    value: function applyBasketData(data) {
	      var _this5 = this;

	      if (data.ROWS && data.ROWS.length > 0) {
	        data.ROWS.forEach(function (row) {
	          if (_this5.groupedRows[row.ID]) {
	            _this5.assignRow(_this5.groupedRows[row.ID], row);
	          } else {
	            _this5.addRow(row);
	          }
	        });
	      }

	      if (data.SUMMARY) {
	        this.assignRow(this.summary, data.SUMMARY);
	      }

	      if (data.FULL_DISCOUNT_LIST) this.discountList = data.FULL_DISCOUNT_LIST;
	    }
	  }, {
	    key: "assignRow",
	    value: function assignRow(targetRow, sourceRow) {
	      Object.assign(targetRow, sourceRow);
	    }
	  }, {
	    key: "addRow",
	    value: function addRow(row) {
	      this.rows.push(row);
	      this.groupedRows[row.ID] = row;
	    }
	  }, {
	    key: "deleteRowsByFieldValues",
	    value: function deleteRowsByFieldValues(fieldName, values) {
	      var _this6 = this;

	      values.forEach(function (value) {
	        return _this6.deleteRowByIndex(_this6.rows.findIndex(function (row) {
	          return row[fieldName] == value;
	        }));
	      });
	    }
	  }, {
	    key: "deleteRowsByIds",
	    value: function deleteRowsByIds(ids) {
	      var _this7 = this;

	      ids.forEach(function (id) {
	        return _this7.deleteRowByIndex(_this7.rows.findIndex(function (row) {
	          return row.ID == id;
	        }));
	      });
	    }
	  }, {
	    key: "deleteRowByIndex",
	    value: function deleteRowByIndex(index) {
	      this.rows.splice(index, 1);
	    }
	  }, {
	    key: "checkTools",
	    value: function checkTools() {
	      var pdfLink = document.querySelector("#pdflink_".concat(this.elementId));

	      if (pdfLink) {
	        if (this.rows.length > 0) {
	          pdfLink.classList.remove('disabled');
	        } else {
	          pdfLink.classList.add('disabled');
	        }
	      }
	    }
	  }, {
	    key: "recalculate",
	    value: function () {
	      var _recalculate = babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee10() {
	        var result;
	        return _regeneratorRuntime().wrap(function _callee10$(_context10) {
	          while (1) {
	            switch (_context10.prev = _context10.next) {
	              case 0:
	                this.showLoading();
	                _context10.next = 3;
	                return this.sendRequest();

	              case 3:
	                result = _context10.sent;
	                this.applyBasketData(result.BASKET_DATA);
	                this.checkTools();
	                this.hideLoading();

	              case 7:
	              case "end":
	                return _context10.stop();
	            }
	          }
	        }, _callee10, this);
	      }));

	      function recalculate() {
	        return _recalculate.apply(this, arguments);
	      }

	      return recalculate;
	    }()
	  }, {
	    key: "sendRequest",
	    value: function sendRequest(data) {
	      var _this8 = this;

	      var requestData = Object.assign({}, data);
	      requestData[this.actionVariable] = 'recalculateAjax';
	      requestData.signedParamsString = this.signedParameters;
	      requestData.template = this.signedTemplate;
	      requestData.via_ajax = 'Y';
	      requestData.sessid = BX.bitrix_sessid();
	      requestData.site_id = this.siteId;
	      requestData.site_template_id = this.siteTemplateId;
	      requestData.lastAppliedDiscounts = BX.util.array_keys(this.discountList).join(',');
	      return new Promise(function (resolve, reject) {
	        BX.ajax({
	          method: 'POST',
	          dataType: 'json',
	          url: _this8.ajaxUrl,
	          data: requestData,
	          onsuccess: resolve,
	          onfailure: reject
	        });
	      });
	    }
	  }, {
	    key: "attachActions",
	    value: function attachActions() {
	      var eventBus = this.eventBus;

	      var template = function template(element) {
	        return new Vue({
	          el: element,
	          components: {
	            BasketTableActions: __vue_component__$1
	          },
	          data: function data() {
	            return {
	              disabled: true,
	              messages: Object.freeze({
	                ACTIONS: BX.message('SBB_ACTIONS')
	              })
	            };
	          },
	          mounted: function mounted() {
	            var _this9 = this;

	            eventBus.$on('selectedRowsChange', function (selectedRows) {
	              _this9.disabled = selectedRows.length === 0;
	            });
	          },
	          methods: {
	            remove: function remove() {
	              eventBus.$emit('removeSelectedItems');
	            },
	            move: function move(toBasket) {
	              eventBus.$emit('moveSelectedItems', toBasket.CODE);
	            }
	          },
	          template: "\n\t\t\t<div class=\"dropdown\">\n\t\t\t\t<a data-toggle=\"dropdown\" data-boundary=\"viewport\" role=\"button\" href=\"#\" class=\"btn btn-default\" :class=\"{disabled: disabled}\">\n\t\t\t\t\t<i class=\"flaticon2-soft-icons\"></i> {{ messages.ACTIONS }}\n\t\t\t\t</a>\n\t\t\t\t<div class=\"dropdown-menu dropdown-menu-right\">\n\t\t\t\t\t<BasketTableActions :disabled=\"disabled\" @remove=\"remove\" @move=\"move\" />\n\t\t\t\t</div>\n\t\t\t</div>\n\t\t\t"
	        });
	      };

	      this.actionsHead = template(document.getElementById(this.elementId + '_actionsHead'));
	      this.actionsFoot = template(document.getElementById(this.elementId + '_actionsFoot'));
	    }
	  }, {
	    key: "attachTemplate",
	    value: function attachTemplate() {
	      var eventBus = this.eventBus;
	      var columns = this.columns;
	      var rows = this.rows;
	      var params = {
	        showQuantity: this.showQuantity
	      };

	      if (this.showQuantity) {
	        params.quantityDisplayMode = this.quantityDisplayMode;
	        params.quantityRelativeFactor = this.quantityRelativeFactor;
	        params.quantityMessages = this.quantityMessages;
	        params.useStocks = this.useStocks;
	        params.displayStocks = this.displayStocks;
	        params.maxQuantity = this.maxQuantity;
	      }

	      this.template = new Vue({
	        el: this.$el,
	        components: {
	          BasketTable: __vue_component__$3
	        },
	        store: B2BPortal.store,
	        data: function data() {
	          return {
	            columns: columns,
	            rows: rows,
	            params: params,
	            eventBus: eventBus
	          };
	        },
	        template: "<BasketTable :columns=\"columns\" :rows=\"rows\" :params=\"params\" />"
	      });
	    }
	  }, {
	    key: "attachSummary",
	    value: function attachSummary() {
	      var $element = document.getElementById(this.elementId + '_summary');
	      var summary = this.summary;
	      var pathToOrder = this.pathToOrder;
	      var exportTypes = this.exportTypes;
	      new Vue({
	        el: $element,
	        components: {
	          BasketSummary: __vue_component__
	        },
	        data: function data() {
	          return {
	            summary: summary,
	            pathToOrder: pathToOrder,
	            exportTypes: exportTypes
	          };
	        },
	        template: "<BasketSummary :summary=\"summary\" :pathToOrder=\"pathToOrder\" :exportTypes=\"exportTypes\" />"
	      });
	    }
	  }, {
	    key: "showLoading",
	    value: function showLoading() {
	      KTApp.block("#".concat(this.elementId, "_block"));
	    }
	  }, {
	    key: "hideLoading",
	    value: function hideLoading() {
	      KTApp.unblock("#".concat(this.elementId, "_block"));
	    }
	  }]);
	  return Basket;
	}();

	exports.Basket = Basket;

}((this.B2BPortal.Components = this.B2BPortal.Components || {})));
//# sourceMappingURL=component.js.map
