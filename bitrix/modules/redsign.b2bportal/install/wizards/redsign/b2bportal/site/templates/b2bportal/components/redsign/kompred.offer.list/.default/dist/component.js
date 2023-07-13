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
	var _B2BPortal = B2BPortal,
	    store = _B2BPortal.store;
	var script = {
	  name: 'VueKPTable',
	  components: {
	    'vue-table': B2BPortal.Vue.Components.VueTable
	  },
	  props: {
	    namespace: String,
	    columns: Array
	  },
	  computed: {
	    rows: function rows() {
	      return store.state[this.namespace].items;
	    },
	    pagination: function pagination() {
	      return store.state[this.namespace].pagination;
	    },
	    fetching: function fetching() {
	      return store.state[this.namespace].fetching;
	    },
	    messages: function messages() {
	      return Object.freeze({
	        RS_KP_KOL_T_TOTAL_VALUE: BX.message('RS_KP_KOL_T_TOTAL_VALUE'),
	        RS_KP_KOL_T_TOTAL_PRODUCT_ONE: BX.message('RS_KP_KOL_T_TOTAL_PRODUCT_ONE'),
	        RS_KP_KOL_T_TOTAL_PRODUCT_FOUR: BX.message('RS_KP_KOL_T_TOTAL_PRODUCT_FOUR'),
	        RS_KP_KOL_T_TOTAL_PRODUCT_FIVE: BX.message('RS_KP_KOL_T_TOTAL_PRODUCT_FIVE'),
	        RS_KP_KOL_T_DOWNLOAD: BX.message('RS_KP_KOL_T_DOWNLOAD'),
	        RS_KP_KOL_T_EDIT: BX.message('RS_KP_KOL_T_EDIT'),
	        RS_KP_KOL_T_DELETE: BX.message('RS_KP_KOL_T_DELETE'),
	        RS_KP_KOL_T_DELETE_CONFIRM: BX.message('RS_KP_KOL_T_DELETE_CONFIRM'),
	        RS_KP_KOL_T_DELETE_CONFIRM_YES: BX.message('RS_KP_KOL_T_DELETE_CONFIRM_YES'),
	        RS_KP_KOL_T_DELETE_CONFIRM_NO: BX.message('RS_KP_KOL_T_DELETE_CONFIRM_NO')
	      });
	    }
	  },
	  methods: {
	    handlePageChange: function handlePageChange(_ref) {
	      var currentPage = _ref.currentPage;
	      store.dispatch("".concat(this.namespace, "/setPage"), currentPage);
	    },
	    deleteRow: function deleteRow(row) {
	      var _this = this;

	      Swal.fire({
	        title: this.messages['RS_KP_KOL_T_DELETE_CONFIRM'],
	        type: 'warning',
	        showCancelButton: true,
	        animation: false,
	        confirmButtonText: this.messages['RS_KP_KOL_T_DELETE_CONFIRM_YES'],
	        cancelButtonText: this.messages['RS_KP_KOL_T_DELETE_CONFIRM_NO']
	      }).then(function (result) {
	        if (result.value) _this.$emit('delete', row.id);
	      });
	    },
	    totalDeclension: function totalDeclension(n) {
	      return [this.messages.RS_KP_KOL_T_TOTAL_PRODUCT_ONE, this.messages.RS_KP_KOL_T_TOTAL_PRODUCT_FOUR, this.messages.RS_KP_KOL_T_TOTAL_PRODUCT_FIVE][(n %= 100, 20 > n && n > 4) ? 2 : [2, 0, 1, 1, 1, 2][(n %= 10, n < 5) ? n : 5]];
	    }
	  },
	  watch: {
	    fetching: function fetching(val) {
	      if (val) {
	        KTApp.block(this.$el);
	      } else {
	        KTApp.unblock(this.$el);
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

	  return _c("vue-table", {
	    attrs: {
	      mode: "remote",
	      columns: _vm.columns,
	      rows: _vm.rows,
	      "pagination-options": {
	        enabled: _vm.pagination.pageCount > 1,
	        hideRowCount: true,
	        setCurrentPage: _vm.pagination.currentPage,
	        perPage: _vm.pagination.perPage,
	        perPageDropdown: false
	      },
	      "sort-options": {
	        enabled: false
	      },
	      totalRows: _vm.pagination.totalRecords
	    },
	    on: {
	      "on-page-change": _vm.handlePageChange
	    },
	    scopedSlots: _vm._u([{
	      key: "table-row",
	      fn: function fn(props) {
	        return [props.column.field === "name" ? [_c("a", {
	          attrs: {
	            href: props.row.editUrl,
	            target: "_blank"
	          }
	        }, [_vm._v(_vm._s(props.row.name))])] : props.column.field === "total" ? [_vm._v("\n\t\t\t" + _vm._s(props.row.products.length) + " " + _vm._s(_vm.totalDeclension(props.row.products.length)) + "\n\t\t\t"), _c("div", {
	          staticClass: "text-nowrap"
	        }, [_vm._v("\n\t\t\t\t" + _vm._s(_vm.messages.RS_KP_KOL_T_TOTAL_VALUE) + " "), _c("span", {
	          domProps: {
	            innerHTML: _vm._s(props.row.totalPriceFormatted)
	          }
	        })])] : props.column.field === "actions" ? [_c("div", {
	          staticClass: "text-nowrap"
	        }, [_c("a", {
	          staticClass: "p-3",
	          attrs: {
	            href: props.row.downloadUrl,
	            target: "_blank",
	            title: _vm.messages.RS_KP_KOL_T_DOWNLOAD
	          }
	        }, [_c("i", {
	          staticClass: "flaticon-download-1",
	          attrs: {
	            "aria-hidden": "true"
	          }
	        })]), _vm._v(" "), _c("a", {
	          staticClass: "p-3",
	          attrs: {
	            href: props.row.editUrl,
	            title: _vm.messages.RS_KP_KOL_T_EDIT
	          }
	        }, [_c("i", {
	          staticClass: "flaticon2-edit",
	          attrs: {
	            "aria-hidden": "true"
	          }
	        })]), _vm._v(" "), _c("a", {
	          staticClass: "p-3",
	          attrs: {
	            href: "#",
	            title: _vm.messages.RS_KP_KOL_T_DELETE
	          },
	          on: {
	            click: function click($event) {
	              $event.preventDefault();
	              return _vm.deleteRow(props.row);
	            }
	          }
	        }, [_c("i", {
	          staticClass: "flaticon2-rubbish-bin-delete-button",
	          attrs: {
	            "aria-hidden": "true"
	          }
	        })])])] : [_vm._v("\n\t\t\t" + _vm._s(props.row[props.column.field]) + " \n\t\t")]];
	      }
	    }])
	  });
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

	var VueKPTable = normalizeComponent_1({
	  render: __vue_render__,
	  staticRenderFns: __vue_staticRenderFns__
	}, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, undefined, undefined);

	var _B2BPortal$1 = B2BPortal,
	    store$1 = _B2BPortal$1.store;
	var _B2BPortal$Vue$Store$ = B2BPortal.Vue.Store.List,
	    createStore = _B2BPortal$Vue$Store$.createStore,
	    types = _B2BPortal$Vue$Store$.types;
	var KPList = /*#__PURE__*/function () {
	  function KPList(el) {
	    var params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
	    babelHelpers.classCallCheck(this, KPList);
	    this.el = el;
	    this.params = params;
	    this.initializeStore();
	    this.attachTemplate();
	  }

	  babelHelpers.createClass(KPList, [{
	    key: "initializeStore",
	    value: function initializeStore() {
	      var state = {
	        id: this.params.id,
	        items: this.params.rows,
	        pagination: this.params.pagination
	      };
	      store$1.registerModule(this.params.id, createStore(state));
	    }
	  }, {
	    key: "delete",
	    value: function () {
	      var _delete2 = babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee(id) {
	        var delResult;
	        return regeneratorRuntime.wrap(function _callee$(_context) {
	          while (1) {
	            switch (_context.prev = _context.next) {
	              case 0:
	                _context.prev = 0;
	                _context.next = 3;
	                return new Promise(function (resolve, reject) {
	                  BX.ajax.runAction('redsign:kompred.api.offer.delete', {
	                    data: {
	                      id: id
	                    }
	                  }).then(resolve, reject);
	                });

	              case 3:
	                delResult = _context.sent;

	                if (!delResult.data) {
	                  _context.next = 7;
	                  break;
	                }

	                _context.next = 7;
	                return store$1.dispatch("".concat(this.params.id, "/fetch"));

	              case 7:
	                _context.next = 12;
	                break;

	              case 9:
	                _context.prev = 9;
	                _context.t0 = _context["catch"](0);
	                console.error(_context.t0);

	              case 12:
	              case "end":
	                return _context.stop();
	            }
	          }
	        }, _callee, this, [[0, 9]]);
	      }));

	      function _delete(_x) {
	        return _delete2.apply(this, arguments);
	      }

	      return _delete;
	    }()
	  }, {
	    key: "fetch",
	    value: function fetch() {
	      var url = window.location.pathname + window.location.search;
	      var requestParams = {
	        url: url,
	        method: 'POST',
	        dataType: 'json',
	        data: babelHelpers.objectSpread({}, data, {
	          comp_id: comp_id
	        })
	      };
	      return new Promise(function (resolve, reject) {
	        BX.ajax.promise(requestParams).then(resolve).catch(reject);
	      });
	    }
	  }, {
	    key: "attachTemplate",
	    value: function attachTemplate() {
	      var columns = this.params.columns;
	      this.$template = new (Vue.extend(VueKPTable))({
	        propsData: {
	          namespace: this.params.id,
	          columns: columns
	        }
	      });
	      var templateElement = document.createElement('div');
	      this.el.appendChild(templateElement);
	      this.$template.$mount(templateElement);
	      this.$template.$on('delete', this.delete.bind(this));
	    }
	  }]);
	  return KPList;
	}();

	exports.KPList = KPList;

}((this.B2BPortal.Components = this.B2BPortal.Components || {})));
//# sourceMappingURL=component.js.map
