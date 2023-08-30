(function (exports) {
    'use strict';

    var script = {
        name: 'vue-balance-list-table',
        props: {
            isLoading: Boolean,
            mode: {
                "default": 'remote'
            },
            columns: {},
            rows: {},
            totalRows: {},
            selectOptions: {},
            paginationOptions: {},
            sortOptions: {}
        },
        data: function data() {
            return {
                sortParams: this.sortOptions
            };
        },
        computed: {
            preparedRows: function preparedRows() {
                return this.rows.map(function (item) {
                    // item.delete_page_url = item.delete_page_url.replace('&amp;', '&')
                    // item.copy_page_url = item.copy_page_url.replace('&amp;', '&')
                    return item;
                });
            },
            messages: function messages() {
                return Object.freeze({
                    'REMOVE': BX.message('RS_B2BPORTAL_SPPL_ACTIONS_REMOVE'),
                    'COPY': BX.message('RS_B2BPORTAL_SPPL_ACTIONS_COPY')
                });
            }
        },
        methods: {
            onPageChange: function onPageChange(params) {
                this.$emit('on-page-change', params);
            },
            onPerPageChange: function onPerPageChange(params) {
                this.$emit('on-per-page-change', params);
            },
            onChangeSort: function onChangeSort(params) {
                this.$emit('on-sort-change', params);
            },
            selectionChanged: function selectionChanged(params) {
                this.$emit('on-selected-rows-change', params);
            }
        },
        components: {
            'vue-table': B2BPortal.Vue.Components.VueTable
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

        console.log(_vm._u);
        return _c("div", {staticClass: "aaaaaaaaaaaaaa"}, [_c("vue-table", {
                    attrs: {
                        isLoading: _vm.isLoading,
                        mode: _vm.mode,
                        columns: _vm.columns,
                        rows: _vm.preparedRows,
                        totalRows: _vm.totalRows,
                        selectOptions: _vm.selectOptions,
                        paginationOptions: _vm.paginationOptions,
                        sortOptions: _vm.sortParams
                    },
                    on: {
                        "on-page-change": _vm.onPageChange,
                        "on-per-page-change": _vm.onPerPageChange,
                        "on-sort-change": _vm.onChangeSort,
                        "on-selected-rows-change": _vm.selectionChanged
                    },
                    scopedSlots: _vm._u([{
                        key: "table-row",
                        fn: function fn(props) {

                            console.log(props.row);


                            return [props.column.field == "NAME" ? [_c("a", {
                                        attrs: {
                                            href: props.row.detail_page_url
                                        },
                                        domProps: {
                                            innerHTML: _vm._s(props.row.NAME)
                                        }
                                    })] : props.column.field == "VALUE" ? [_c("span", {
                                        staticClass: "text-nowrap",
                                        domProps: {
                                            innerHTML: _vm._s(props.row.VALUE)
                                        }
                                    })] : props.column.field == "actions" ? [_c("div", {
                                                staticClass: "dropdown position-static"
                                            }, [_c("a", {
                                                staticClass: "btn btn-sm btn-clean btn-icon btn-icon-md",
                                                attrs: {
                                                    "data-toggle": "dropdown",
                                                    role: "button",
                                                    href: "#",
                                                    "aria-expanded": "false"
                                                }
                                            }, [_c("i", {
                                                staticClass: "la la-ellipsis-h"
                                            })]), _vm._v(" "), _c("div", {
                                                staticClass: "dropdown-mensu dropdown-menu-right"
                                            }, [_c("ul", {
                                                staticClass: "kt-nav"
                                            }, [_c("li", {
                                                staticClass: "kt-nav__item"
                                            }, [_c("a", {
                                                staticClass: "kt-nav__link",
                                                attrs: {
                                                    href: props.row.delete_page_url
                                                }
                                            }, [_c("i", {
                                                staticClass: "kt-nav__link-icon flaticon2-trash"
                                            }), _vm._v(" "), _c("span", {
                                                staticClass: "kt-nav__link-text"
                                            }, [_vm._v(_vm._s(_vm.messages.REMOVE))])])]),
                                                _vm._v(" "), _c("li", {
                                                    staticClass: "kt-nav__item"
                                                }, [_c("a", {
                                                    staticClass: "kt-nav__link",
                                                    attrs: {
                                                        href: props.row.copy_page_url
                                                    }
                                                }, [_c("i", {
                                                    staticClass: "kt-nav__link-icon flaticon2-copy"
                                                }), _vm._v(" "), _c("span", {
                                                    staticClass: "kt-nav__link-text"
                                                }, [_vm._v(_vm._s(_vm.messages.COPY))])])])])])])] :
                                            [_vm._v("\n\t\t\t" + _vm._s(props.formattedRow[props.column.field]) + "\n\t\t")]];
                        }
                    }])
                })]
        );
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

    var BalanceListTable = /*#__PURE__*/function (_B2BPortal$Components) {
        babelHelpers.inherits(BalanceListTable, _B2BPortal$Components);

        function BalanceListTable(data, params) {
            var _this;

            babelHelpers.classCallCheck(this, BalanceListTable);
            _this = babelHelpers.possibleConstructorReturn(this, babelHelpers.getPrototypeOf(BalanceListTable).call(this, data, params));

            _this.init();

            return _this;
        }

        babelHelpers.createClass(BalanceListTable, [{
            key: "attachTemplateTable",
            value: function attachTemplateTable() {
                var _data = this.data;
                var params = this.params;
                var component = this;
                this.vueTable = new Vue({
                    el: this.$table,
                    props: {
                        isLoading: {
                            type: Boolean,
                            "default": false
                        }
                    },
                    components: {
                        VueBalanceTable: __vue_component__
                    },
                    template: "\n\t\t\t\t<VueBalanceTable\n\t\t\t\t\t:" +
                            "isLoading=\"component.loading\"\n\t\t\t\t\t:" +
                            "columns=\"data.headers\"\n\t\t\t\t\t:" +
                            "rows=\"data.items\"\n\t\t\t\t\t:" +
                            "pagination-options=\"{\n\t\t\t\t\t\tenabled: true,\n\t\t\t\t\t\tsetCurrentPage:" +
                            " data.pagination.currentPage,\n\t\t\t\t\t\tperPage:" +
                            " data.pagination.perPage,\n\t\t\t\t\t\tperPageDropdown:" +
                            " params.pagination.perPageDropdown,\n\t\t\t\t\t}\"\n\t\t\t\t\t:" +
                            "totalRows=\"data.pagination.totalRecords\"\n\t\t\t\t\t:" +
                            "select-options=\"{\n\t\t\t\t\t\tenabled: false,\n\t\t\t\t\t}\"\n\t\t\t\t\t:" +
                            "sort-options=\"{\n\t\t\t\t\t\tenabled: " +
                            "true,\n\t\t\t\t\t\tinitialSortBy:" +
                            " {\n\t\t\t\t\t\t\tfield: params.sorting.initialSortBy.field,\n\t\t\t\t\t\t\ttype: " +
                            "params.sorting.initialSortBy.type,\n\t\t\t\t\t\t}\n\t\t\t\t\t}\"\n\t\t\t\t\t:" +
                            "params=\"params\"\n\t\t\t\t\t:" +
                            "component=\"component\"\n\t\t\t\t\t@on-page-change=\"onPageChange\"\n\t\t\t\t\t@on-per-page-change=\"onPerPageChange\"\n\t\t\t\t\t@on-sort-change=\"onChangeSort\"\n\t\t\t\t\t@on-selected-rows-change=\"onSelectedRowsChange\"\n\t\t\t\t/>\n\t\t\t\t",
                    data: function data() {
                        return {
                            data: _data,
                            params: params,
                            component: component
                        };
                    },
                    methods: {
                        onSelectedRowsChange: function onSelectedRowsChange(selectedParams) {
                            this.component.selectedRows = selectedParams.selectedRows;
                        },
                        onPageChange: function onPageChange(paginationParams) {
                            if (paginationParams.currentPage == this.data.pagination.setCurrentPage) return;
                            this.component.requestPageChange(paginationParams);
                        },
                        onPerPageChange: function onPerPageChange(perPageParams) {
                            if (perPageParams.currentPerPage == this.data.pagination.perPage) return;
                            this.data.pagination.perPage = null;
                            this.component.requestPerPageChange(perPageParams);
                        },
                        onChangeSort: function onChangeSort(sortParams) {
                            this.component.requestChangeSort(sortParams[0]);
                        }
                    }
                });
            }
        }]);
        return BalanceListTable;
    }(B2BPortal.Components.Table);

    exports.BalanceListTable = BalanceListTable;

}((this.window = this.window || {})));
//# sourceMappingURL=component.js.map
