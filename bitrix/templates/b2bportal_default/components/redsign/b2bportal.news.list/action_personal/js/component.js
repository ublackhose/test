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
    var script = {
        name: 'vue-docs-table',
        props: {
            isLoading: Boolean,
            mode: {
                default: 'remote'
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
        mounted: function mounted() {
            this.setRowsIds();
            this.setEditAreas();
        },
        computed: {
            editAreas: function editAreas() {
                return this.$store.getters["NewsList/editAreas"];
            },
            editAreaIds: function editAreaIds() {
                var _this = this;

                return Object.keys(this.editAreas).filter(function (areaId) {
                    return _this.rows.find(function (row) {
                        return row.editAreaId == areaId;
                    });
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
            },
            setRowsIds: function setRowsIds() {
                var _this2 = this;

                var table = this.$refs.table;
                var tableRows = table.$refs.rows;
                tableRows.forEach(function (row, index) {
                    row.setAttribute('id', _this2.rows[index].editAreaId);
                });
            },
            setEditAreas: function setEditAreas() {
                var _this3 = this;

                this.editAreaIds.forEach(function (areaId) {
                    if (BX(areaId)) {
                        new BX.CMenuOpener({
                            'parent': areaId,
                            'menu': [{
                                'ICONCLASS': 'bx-context-toolbar-edit-icon',
                                'TITLE': '',
                                'TEXT': _this3.editAreas[areaId].edit.text,
                                'ONCLICK': "(new BX.CAdminDialog({'content_url': '" + _this3.editAreas[areaId].edit.link + "' })).Show()"
                            }, {
                                'ICONCLASS': 'bx-context-toolbar-delete-icon',
                                'TITLE': '',
                                'TEXT': _this3.editAreas[areaId].delete.text,
                                'ONCLICK': 'if(confirm(\'Are you sure?\')) jsUtils.Redirect([], ' + _this3.editAreas[areaId].delete.link + ');'
                            }]
                        }).Show();
                        BX.admin.setComponentBorder(areaId);
                    }
                });
            }
        },
        components: {
            'vue-table': B2BPortal.Vue.Components.VueTable
        },
        watch: {
            rows: function rows() {
                var _this4 = this;

                this.$nextTick(function () {
                    _this4.setRowsIds();
                });
            },
            editAreaIds: function editAreaIds() {
                var _this5 = this;

                this.$nextTick(function () {
                    _this5.setEditAreas();
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

        return _c("vue-table", {
            ref: "table",
            attrs: {
                isLoading: _vm.isLoading,
                mode: _vm.mode,
                columns: _vm.columns,
                rows: _vm.rows,
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
                    return [props.column.field == "PROPERTY_" + _vm.$attrs.params.arParams.PROPERTY_CODE_ID.TYPE ? [props.row["PROPERTY_" + _vm.$attrs.params.arParams.PROPERTY_CODE_ID.TYPE] ? _c("span", {
                        staticClass: "kt-badge kt-badge--inline kt-badge--pill",
                        class: props.row.property_type_badge
                    }, [_vm._v("\n\t\t\t\t" + _vm._s(props.row["PROPERTY_" + _vm.$attrs.params.arParams.PROPERTY_CODE_ID.TYPE]) + "\n\t\t\t")]) : _vm._e()] : props.column.field == "PROPERTY_" + _vm.$attrs.params.arParams.PROPERTY_CODE_ID.OWNER_ID ? [props.row["PROPERTY_" + _vm.$attrs.params.arParams.PROPERTY_CODE_ID.OWNER_ID + "_url"] ? _c("a", {
                        attrs: {
                            href: props.row["PROPERTY_" + _vm.$attrs.params.arParams.PROPERTY_CODE_ID.OWNER_ID + "_url"],
                            target: "_blank"
                        }
                    }, [_vm._v("\n\t\t\t\t" + _vm._s(props.row["PROPERTY_" + _vm.$attrs.params.arParams.PROPERTY_CODE_ID.OWNER_ID + "_display"]) + "\n\t\t\t")]) : _c("span", [_vm._v(_vm._s(props.row["PROPERTY_" + _vm.$attrs.params.arParams.PROPERTY_CODE_ID.OWNER_ID + "_display"]))])] : props.column.field == "PROPERTY_" + _vm.$attrs.params.arParams.PROPERTY_CODE_ID.ORDER_ID ? [props.row["PROPERTY_" + _vm.$attrs.params.arParams.PROPERTY_CODE_ID.ORDER_ID + "_url"] ? _c("a", {
                        attrs: {
                            href: props.row["PROPERTY_" + _vm.$attrs.params.arParams.PROPERTY_CODE_ID.ORDER_ID + "_url"],
                            target: "_blank"
                        }
                    }, [_vm._v("\n\t\t\t\t#" + _vm._s(props.row["PROPERTY_" + _vm.$attrs.params.arParams.PROPERTY_CODE_ID.ORDER_ID + "_display"]) + "\n\t\t\t")]) : _vm._e()] : props.column.field == "actions" ? [props.row.download_link ? _c("a", {
                        staticClass: "btn btn-primary btn-sm",
                        attrs: {
                            href: props.row.download_link,
                            target: "_blank"
                        }
                    }, [_c("i", {
                        staticClass: "flaticon2-download-2 pr-0"
                    })]) : _vm._e()] : [_vm._v("\n\t\t\t" + _vm._s(props.formattedRow[props.column.field]) + "\n\t\t")]];
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

    var VueDocsTable = normalizeComponent_1({
        render: __vue_render__,
        staticRenderFns: __vue_staticRenderFns__
    }, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, undefined, undefined);

    var store = {
        namespaced: true,
        state: {
            editAreas: {}
        },
        getters: {
            editAreas: function editAreas(state) {
                return state.editAreas;
            }
        },
        mutations: {
            ADD_EDIT_AREA: function ADD_EDIT_AREA(state, data) {
                Vue.set(state.editAreas, data.id, data.actions);
            }
        }
    };

    B2BPortal.store.registerModule('NewsList', store);
    var DocsTable = /*#__PURE__*/function (_B2BPortal$Components) {
        babelHelpers.inherits(DocsTable, _B2BPortal$Components);

        function DocsTable(data, params) {
            var _this;

            babelHelpers.classCallCheck(this, DocsTable);
            _this = babelHelpers.possibleConstructorReturn(this, babelHelpers.getPrototypeOf(DocsTable).call(this, data, params));

            _this.init();

            return _this;
        }

        babelHelpers.createClass(DocsTable, [{
            key: "handleEvents",
            value: function handleEvents() {
                var _this2 = this;

                this.eventBus.$on('afterRequest', function (result) {
                    return _this2.afterRequest(result);
                });
            }
        }, {
            key: "afterRequest",
            value: function afterRequest(result) {
                if (result.data) {
                    if (result.data.editAreas) {
                        for (var id in result.data.editAreas) {
                            B2BPortal.store.commit('NewsList/ADD_EDIT_AREA', {
                                id: id,
                                actions: result.data.editAreas[id]
                            });
                        }
                    }
                }
            }
        }, {
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
                            default: false
                        }
                    },
                    components: {
                        VueDocsTable: VueDocsTable
                    },
                    store: B2BPortal.store,
                    template: "\n\t\t\t\t<VueDocsTable\n\t\t\t\t\t:isLoading=\"component.loading\"\n\t\t\t\t\t:columns=\"data.headers\"\n\t\t\t\t\t:rows=\"data.items\"\n\t\t\t\t\t:pagination-options=\"{\n\t\t\t\t\t\tenabled: true,\n\t\t\t\t\t\tsetCurrentPage: data.pagination.currentPage,\n\t\t\t\t\t\tperPage: data.pagination.perPage,\n\t\t\t\t\t\tperPageDropdown: params.pagination.perPageDropdown,\n\t\t\t\t\t}\"\n\t\t\t\t\t:totalRows=\"data.pagination.totalRecords\"\n\t\t\t\t\t:select-options=\"{\n\t\t\t\t\t\tenabled: false,\n\t\t\t\t\t}\"\n\t\t\t\t\t:sort-options=\"{\n\t\t\t\t\t\tenabled: true,\n\t\t\t\t\t\tinitialSortBy: {\n\t\t\t\t\t\t\tfield: params.sorting.initialSortBy.field,\n\t\t\t\t\t\t\ttype: params.sorting.initialSortBy.type,\n\t\t\t\t\t\t}\n\t\t\t\t\t}\"\n\t\t\t\t\t:params=\"params\"\n\t\t\t\t\t:component=\"component\"\n\t\t\t\t\t@on-page-change=\"onPageChange\"\n\t\t\t\t\t@on-per-page-change=\"onPerPageChange\"\n\t\t\t\t\t@on-sort-change=\"onChangeSort\"\n\t\t\t\t\t@on-selected-rows-change=\"onSelectedRowsChange\"\n\t\t\t\t/>\n\t\t\t\t",
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
        return DocsTable;
    }(B2BPortal.Components.TableFilter);

    exports.DocsTable = DocsTable;

}((this.window = this.window || {})));
//# sourceMappingURL=component.js.map
