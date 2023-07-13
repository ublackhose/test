this.B2BPortal = this.B2BPortal || {};
(function (exports) {
	'use strict';

	var CSLTree = /*#__PURE__*/function () {
	  function CSLTree(params) {
	    babelHelpers.classCallCheck(this, CSLTree);
	    this.treeNode = params.treeNode;
	    this.searchInputNode = params.searchInputNode;
	    if (!this.treeNode) throw new Error('CSLTree: tree not found');
	    this.init();
	    if (this.searchInputNode) this.initSearch();
	  }

	  babelHelpers.createClass(CSLTree, [{
	    key: "init",
	    value: function init() {
	      var _this = this;

	      $(this.treeNode).jstree({
	        'plugins': ['search', 'checkbox', 'types'],
	        'search': {
	          'show_only_matches': true
	        },
	        'types': {
	          'default': {
	            'icon': 'fa fa-folder kt-font-brand'
	          }
	        }
	      }).on('changed.jstree', function (e, _ref) {
	        var selected = _ref.selected;
	        return _this.onSelectedHandle(selected);
	      });
	    }
	  }, {
	    key: "initSearch",
	    value: function initSearch() {
	      var _this2 = this;

	      $(this.searchInputNode).on('input', function (_ref2) {
	        var target = _ref2.target;
	        $(_this2.treeNode).jstree('search', target.value);
	      });
	    }
	  }, {
	    key: "onSelectedHandle",
	    value: function onSelectedHandle(selected) {
	      var filterCategories = selected.map(function (elementId) {
	        var node = document.getElementById(elementId);
	        return node ? node.getAttribute('data-section-id') : null;
	      }).filter(function (sectionId) {
	        return sectionId;
	      });
	      this.sendRequest(filterCategories);
	    }
	  }, {
	    key: "sendRequest",
	    value: function () {
	      var _sendRequest = babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee(filterCategories) {
	        var uri;
	        return regeneratorRuntime.wrap(function _callee$(_context) {
	          while (1) {
	            switch (_context.prev = _context.next) {
	              case 0:
	                uri = new BX.Uri(window.location.pathname + window.location.search);
	                uri.setQueryParam('filter_categories', filterCategories);
	                BX.onCustomEvent("filter-arrFilter-on-submit", [{
	                  arrFilter_SUBSECTIONS: filterCategories
	                }]);

	              case 3:
	              case "end":
	                return _context.stop();
	            }
	          }
	        }, _callee);
	      }));

	      function sendRequest(_x) {
	        return _sendRequest.apply(this, arguments);
	      }

	      return sendRequest;
	    }()
	  }]);
	  return CSLTree;
	}();

	exports.CSLTree = CSLTree;

}((this.B2BPortal.Components = this.B2BPortal.Components || {})));
//# sourceMappingURL=component.js.map
