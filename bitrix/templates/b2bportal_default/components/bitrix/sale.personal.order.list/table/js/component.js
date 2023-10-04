this.B2BPortal = this.B2BPortal || {};
(function (exports) {
    'use strict';

    var SalePersonalOrderList = /*#__PURE__*/function () {
        function SalePersonalOrderList(el, container) {


            var data = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

            babelHelpers.classCallCheck(this, SalePersonalOrderList);
            this.$el = el;
            this.$container = container;
            this.columns = data.columns || {};
            this.rows = data.rows || {};
            this.pagination = data.pagination || {};
            this.sort = data.sort || {};
            this.eventBus = new Vue();
            this.attachTemplate();
            this.handleEvents();
        }

        babelHelpers.createClass(SalePersonalOrderList, [{
            key: "sendRequest",
            value: function () {
                var _sendRequest = babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee(url, data) {
                    var result;
                    return regeneratorRuntime.wrap(function _callee$(_context) {
                        while (1) {
                            switch (_context.prev = _context.next) {
                                case 0:
                                    KTApp.block(this.$container);
                                    _context.next = 3;
                                    return this.fetch(url, data);
                                case 3:
                                    result = _context.sent;
                                    if ((result.data || {}).rows) {

                                        var params = window
                                            .location
                                            .search
                                            .replace('?', '')
                                            .split('&')
                                            .reduce(
                                                function (p, e) {
                                                    var a = e.split('=');
                                                    p[decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                                                    return p;
                                                },
                                                {}
                                            );

                                        if (params['filter_user']) {
                                            let arrId = [];
                                            let arrOrdersCheck;
                                            result.data.rows.forEach(function (row) {
                                                arrId.push(row.accountNumber);
                                            })


                                            var check = 0;
                                            $.ajax({
                                                url: '/gethint.php',
                                                type: 'GET',
                                                dataType: 'text',
                                                async: false,
                                                data: {filter_user_name: params['filter_user'], order_id: JSON.stringify(arrId)},
                                            })
                                                .done(function (data) {
                                                    arrOrdersCheck = JSON.parse(data);
                                                });
                                            let i = 0;

                                            while (result.data.rows[i]) {

                                                if (arrOrdersCheck[i] != 1) {
                                                    result.data.rows.splice(i, 1);
                                                    arrOrdersCheck.splice(i, 1);
                                                } else {
                                                    i++;
                                                }
                                            }
                                        }



                                        this.rows = result.data.rows;
                                        this.$template.$emit('setRows', result.data.rows);
                                    }

                                    if ((result.data || {}).pagination) {

                                        this.pagination = result.data.pagination;
                                        this.$template.$emit('setNav', result.data.pagination);
                                    }

                                    BX.ajax.history.put(null, url);
                                    KTApp.unblock(this.$container);
                                    return _context.abrupt("return", result);

                                case 9:
                                case "end":
                                    return _context.stop();
                            }
                        }
                    }, _callee, this);
                }));

                function sendRequest(_x, _x2) {
                    return _sendRequest.apply(this, arguments);
                }

                return sendRequest;
            }()
        }, {
            key: "fetch",
            value: function fetch(url, data) {
                return new Promise(function (resolve, reject) {
                    BX.ajax({
                        url: url,
                        data: data,
                        dataType: 'json',
                        onsuccess: resolve,
                        onfailure: reject
                    });
                }); // return fetch(url, params).then(response => response.json());
            }
        }, {
            key: "attachTemplate",
            value: function attachTemplate() {
                var columns = this.columns;
                var rows = this.rows;
                var pagination = this.pagination;
                var sort = this.sort;
                this.$template = new Vue({
                    name: 'SalePersonalOrderList',
                    el: this.$el,
                    components: {
                        'vue-table': B2BPortal.Vue.Components.VueTable
                    },
                    data: function data() {
                        return {
                            columns: columns,
                            rows: rows,
                            pagination: pagination,
                            sort: sort
                        };
                    },
                    computed: {
                        messages: function messages() {
                            return Object.freeze(Object.keys(BX.message).filter(function (message) {
                                return message.startsWith('SPOL');
                            }).reduce(function (obj, message) {
                                obj[message.slice(message)] = BX.message(message);
                                return obj;
                            }, {}));
                        },
                        enablePagenavigation: function enablePagenavigation() {
                            return Number(this.pagination.totalRecords) > Number(this.pagination.perPage);
                        },
                        expandedRows: function expandedRows() {
                            return this.rows.reduce(function (indexes, row, index) {
                                if (row._IS_EXPAND) indexes.push(index);
                                return indexes;
                            }, []);
                        }
                    },
                    created: function created() {
                        var _this = this;




                        var params = window
                            .location
                            .search
                            .replace('?', '')
                            .split('&')
                            .reduce(
                                function (p, e) {
                                    var a = e.split('=');
                                    p[decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                                    return p;
                                },
                                {}
                            );

                        if (params['filter_user']) {
                            let arrId = [];
                            let arrOrdersCheck;
                            this.rows.forEach(function (row) {
                                arrId.push(row.accountNumber);
                            })

                            var check = 0;
                            $.ajax({
                                url: '/gethint.php',
                                type: 'GET',
                                dataType: 'text',
                                async: false,
                                data: {filter_user_name: params['filter_user'], order_id: JSON.stringify(arrId)},
                            })
                                .done(function (data) {
                                    arrOrdersCheck = JSON.parse(data);
                                });
                            let i = 0;

                            while (this.rows[i]) {
                                if (arrOrdersCheck[i] != 1) {
                                    this.rows.splice(i, 1);
                                    arrOrdersCheck.splice(i, 1);
                                } else {
                                    i++;
                                }
                            }


                        }

                        if(this.rows.payed == true){
                            this.rows.urlToUpdate = null;
                        }
                        this.rows.forEach(function (row) {
                            return _this.$set(row, '_IS_EXPAND', false);
                        });
                    },
                    mounted: function mounted() {
                        var _this2 = this;

                        this.$on('setRows', function (rows) {

                            _this2.rows = rows.map(function (row) {

                                _this2.$set(row, '_IS_EXPAND', false);
                                return row;
                            });
                        });
                        this.$on('setNav', function (pagination) {
                            _this2.pagination = pagination;
                        });
                    },
                    methods: {
                        handleRowClick: function handleRowClick(params) {
                            window.location.href = params.row.url;
                        }
                    },
                    template: "\n\t\t\t\t<vue-table\n\t\t\t\t\tmode=\"remote\"\n\t\t\t\t\t:columns=\"columns\" \n\t\t\t\t\t:rows=\"rows\"\n\t\t\t\t\t:pagination-options=\"{\n\t\t\t\t\t\tenabled: enablePagenavigation,\n\t\t\t\t\t\thideRowCount: true,\n\t\t\t\t\t\tsetCurrentPage: pagination.currentPage,\n\t\t\t\t\t\tperPage: pagination.perPage,\n\t\t\t\t\t\tperPageDropdown: false,\n\t\t\t\t\t}\"\n\t\t\t\t\t:sort-options=\"{\n\t\t\t\t\t\tenabled: true,\n\t\t\t\t\t\tinitialSortBy: sort\n\t\t\t\t\t}\"\n\t\t\t\t\t@on-sort-change=\"$emit('onSortChange', $event[0]);\"\n\t\t\t\t\t@on-page-change=\"$emit('onPageChange', $event);\"\n\t\t\t\t\t@on-per-page-change=\"$emit('onPageChange', $event);\"\n\t\t\t\t\t:totalRows=\"pagination.totalRecords\"\n\t\t\t\t\t:expandedRows=\"expandedRows\"\n\t\t\t\t>\n\t\t\t\t\t<template slot=\"table-row\" slot-scope=\"props\">\n\n\t\t\t\t\t\t<template v-if=\"props.column.field === 'ID'\">\n\t\t\t\t\t\t\t<a :href=\"props.row.urlToDetail\">{{ props.row.accountNumber }}</a>\n\n\t\t\t\t\t\t\t<div class=\"d-block\">\n\t\t\t\t\t\t\t\t<a href=\"#\" class=\"small\" @click.prevent=\"rows[props.index]._IS_EXPAND = !props.row._IS_EXPAND\" v-if=\"props.row.items.length\">\n\t\t\t\t\t\t\t\t\t{{ messages.SPOL_TPL_ORDER_LIST }}\n\t\t\t\t\t\t\t\t\t<i class=\"fa fa-angle-down\" v-if=\"!props.row._IS_EXPAND\"></i>\n\t\t\t\t\t\t\t\t\t<i class=\"fa fa-angle-up\" v-else></i>\n\t\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</template>\n\n\t\t\t\t\t\t<template v-if=\"props.column.field === 'DATE_INSERT'\">\n\t\t\t\t\t\t\t<a :href=\"props.row.urlToDetail\">{{ props.row.dateInsert }}</a>\n\t\t\t\t\t\t</template>\n\n\t\t\t\t\t\t<template v-else-if=\"props.column.field === 'STATUS_ID'\">\n\t\t\t\t\t\t\t<div v-if=\"props.row.status && props.row.status != ''\">\n\t\t\t\t\t\t\t\t<span  class=\"kt-badge kt-badge--inline kt-badge--pill kt-badge--primary text-nowrap tooltip_2\" :style=\"{'background-color': props.row.status.color}\" >{{props.row.status.name}}<span class='tooltiptext'>{{props.row.status.description}}</span></span>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</template>\n\n\t\t\t\t\t\t<template v-else-if=\"props.column.field === 'PRICE'\">\n\t\t\t\t\t\t\t<div v-html=\"props.row.formatedPrice\"></div>\n\t\t\t\t\t\t</template>\n\n\t\t\t\t\t\t<template v-else-if=\"props.column.field === 'PAYED'\">\n\t\t\t\t\t\t\t<span v-if=\"props.row.payed\"> <span class=\"\">{{messages.SPOL_TPL_PAID}}</span><br>{{props.row.datePayed}} </span>\n\t\t\t\t\t\t\t<span v-else class=\"\">{{ messages.SPOL_TPL_NOTPAID }}</span>\n\t\t\t\t\t\t</template>\n\n\t\t\t\t\t\t<template v-else-if=\"props.column.field === 'shipment'\">\n\t\t\t\t\t\t\t<div v-for=\"(shipment, index) in props.row.shipments\" :key=\"index\">\n\t\t\t\t\t\t\t\t<span v-if=\"shipment.length > 1\">{{shipment.deliveryName}}: </span>\n\t\t\t\t\t\t\t\t<span v-if=\"shipment.deducted\"><span class=\"\">{{messages.SPOL_TPL_LOADED}}</span><br>{{shipment.dateDeducted}}</span>\n\t\t\t\t\t\t\t\t<span v-else class=\"\">{{messages.SPOL_TPL_NOTLOADED}}</span>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</template>\n\n\t\t\t\t\t\t<template v-else-if=\"props.column.field === 'actions'\">\n\t\t\t\t\t\t\t<div v-if=\"props.row.urlToCopy && props.row.urlToCopy != ''\">\n\t\t\t\t\t\t\t\t<a :href=\"props.row.urlToCopy\">{{ messages.SPOL_TPL_REPEAT_ORDER }}</a>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t<div v-if=\"!props.row.payed && props.row.urlToUpdate != ''\">\n\t\t\t\t\t\t\t\t<a :href=\"props.row.urlToUpdate\">{{ messages.SPOL_TPL_UPDATE_ORDER }}</a>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t<div v-if=\"props.row.canceled\">\n\t\t\t\t\t\t\t\t{{ messages.SPOL_TPL_ORDER_CANCELED }} <b>{{props.row.dateCanceled}}</b>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t<div v-else-if=\"props.row.urlToCancel && props.row.urlToCancel != ''\">\n\t\t\t\t\t\t\t\t<a :href=\"props.row.urlToCancel\">{{ messages.SPOL_TPL_CANCEL_ORDER }}</a>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</template>\n\n\t\t\t\t\t\t<template v-else>\n\t\t\t\t\t\t\t{{ props.row[props.column.field] }}\n\t\t\t\t\t\t</template>\n\t\t\t\t\t</template>\n\n\t\t\t\t\t<div slot=\"emptystate\">\n\t\t\t\t\t\t<div class=\"text-center\">{{ \"Здесь пока нет заказов\" }}</div>\n\t\t\t\t\t</div>\n\n\t\t\t\t\t<template slot=\"expanded-row\" slot-scope=\"props\">\n\t\t\t\t\t\t<table class=\"table bg-white\">\n\t\t\t\t\t\t\t<thead>\n\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t<td>{{ messages.SPOL_TPL_ORDER_ITEM_NAME }}</td>\n\t\t\t\t\t\t\t\t\t<td>{{ messages.SPOL_TPL_ORDER_ITEM_PRICE }}</td>\n\t\t\t\t\t\t\t\t\t<td>{{ messages.SPOL_TPL_ORDER_ITEM_QUANTITY }}</td>\n\t\t\t\t\t\t\t\t\t<td>{{ messages.SPOL_TPL_ORDER_ITEM_SUM }}</td>\n\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t</thead>\n\t\t\t\t\t\t\t<tbody>\n\t\t\t\t\t\t\t\t<tr v-for=\"item in props.row.items\" :key=\"item.id\">\n\t\t\t\t\t\t\t\t\t<td v-html=\"item.name\"></td>\n\t\t\t\t\t\t\t\t\t<td v-html=\"item.priceFormatted\"></td>\n\t\t\t\t\t\t\t\t\t<td>{{ item.quantity }}</td>\n\t\t\t\t\t\t\t\t\t<td v-html=\"item.sumFormatted\"></td>\n\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t</tbody>\n\t\t\t\t\t\t</table>\n\t\t\t\t\t</template>\n\t\t\t\t</vue-table>\n\t\t\t"
                });
            }
        }, {
            key: "handleEvents",
            value: function handleEvents() {
                this.$template.$on('onSortChange', this.sorting.bind(this));
                this.$template.$on('onPageChange', this.nav.bind(this));
            }
        }, {
            key: "sorting",
            value: function sorting(params) {
                var url = BX.util.add_url_param(window.location.href, {
                    by: params.field,
                    order: params.type.toUpperCase()
                });
                this.sendRequest(url);
            }
        }, {
            key: "nav",
            value: function nav(params) {
                var navParams = {};
                navParams[this.pagination.navName] = params.currentPage;
                var url = BX.util.add_url_param(window.location.href, navParams);
                this.sendRequest(url);
            }
        }]);
        return SalePersonalOrderList;
    }();

    exports.SalePersonalOrderList = SalePersonalOrderList;

}((this.B2BPortal.Components = this.B2BPortal.Components || {})));
//# sourceMappingURL=component.js.map
