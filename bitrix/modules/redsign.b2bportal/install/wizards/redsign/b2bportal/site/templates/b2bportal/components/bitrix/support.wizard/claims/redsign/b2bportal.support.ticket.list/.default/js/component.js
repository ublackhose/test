this.B2BPortal = this.B2BPortal || {};
(function (exports) {
	'use strict';

	function addUrlParams(url, params) {
	  return BX.util.add_url_param(url, params);
	}

	var SupportTicketList = /*#__PURE__*/function () {
	  function SupportTicketList(el, container) {
	    var data = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
	    babelHelpers.classCallCheck(this, SupportTicketList);
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

	  babelHelpers.createClass(SupportTicketList, [{
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
	            return Object.freeze({
	              'SUP_TICKET_NOT_FOUND': BX.message('SUP_TICKET_NOT_FOUND')
	            });
	          }
	        },
	        mounted: function mounted() {
	          var _this = this;

	          this.$on('setRows', function (rows) {
	            _this.rows = rows;
	          });
	          this.$on('setNav', function (pagination) {
	            _this.pagination = pagination;
	          });
	        },
	        methods: {
	          handleRowClick: function handleRowClick(params) {
	            window.location.href = params.row.url;
	          }
	        },
	        template: "\n\t\t\t\t<vue-table\n\t\t\t\t\tmode=\"remote\"\n\t\t\t\t\t:columns=\"columns\" \n\t\t\t\t\t:rows=\"rows\"\n\t\t\t\t\t:pagination-options=\"{\n\t\t\t\t\t\tenabled: true,\n\t\t\t\t\t\thideRowCount: true,\n\t\t\t\t\t\tsetCurrentPage: pagination.currentPage,\n\t\t\t\t\t\tperPage: pagination.perPage,\n\t\t\t\t\t\tperPageDropdown: false,\n\t\t\t\t\t}\"\n\t\t\t\t\t:sort-options=\"{\n\t\t\t\t\t\tenabled: true,\n\t\t\t\t\t\tinitialSortBy: sort\n\t\t\t\t\t}\"\n\t\t\t\t\t@on-row-click=\"handleRowClick\"\n\t\t\t\t\t@on-sort-change=\"$emit('onSortChange', $event[0]);\"\n\t\t\t\t\t@on-page-change=\"$emit('onPageChange', $event);\"\n\t\t\t\t\t@on-per-page-change=\"$emit('onPageChange', $event);\"\n\t\t\t\t\t:totalRows=\"pagination.totalRecords\"\n\t\t\t\t>\n\t\t\t\t\t<template slot=\"table-row\" slot-scope=\"props\">\n\n\t\t\t\t\t\t<template v-if=\"props.column.field === 's_id'\">\n\t\t\t\t\t\t\t<div><a :href=\"props.row.url\">#{{props.row[props.column.field]}}</a></div>\n\t\t\t\t\t\t\t<div class=\"text-muted\">{{props.row.created}}</div>\n\t\t\t\t\t\t</template>\n\n\t\t\t\t\t\t<template v-else-if=\"props.column.field === 's_title'\">\n\t\t\t\t\t\t\t<a :href=\"props.row.url\">{{props.row[props.column.field]}}</a>\n\t\t\t\t\t\t</template>\n\n\t\t\t\t\t\t<template v-else>\n\t\t\t\t\t\t\t<div v-html=\"props.row[props.column.field]\"></div>\n\t\t\t\t\t\t</template>\n\t\t\t\t\t</template>\n\n\t\t\t\t\t<div slot=\"emptystate\">\n\t\t\t\t\t\t<div class=\"text-center\">{{ messages.SUP_TICKET_NOT_FOUND }}</div>\n\t\t\t\t\t</div>\n\t\t\t\t</vue-table>\n\t\t\t"
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
	      var url = addUrlParams(window.location.pathname, {
	        by: params.field,
	        order: params.type
	      });
	      this.sendRequest(url);
	    }
	  }, {
	    key: "nav",
	    value: function nav(params) {
	      var navParams = {};
	      navParams[this.pagination.navName] = params.currentPage;
	      var url = addUrlParams(window.location.href, navParams);
	      this.sendRequest(url);
	    }
	  }]);
	  return SupportTicketList;
	}();

	exports.SupportTicketList = SupportTicketList;

}((this.B2BPortal.Components = this.B2BPortal.Components || {})));
//# sourceMappingURL=component.js.map
