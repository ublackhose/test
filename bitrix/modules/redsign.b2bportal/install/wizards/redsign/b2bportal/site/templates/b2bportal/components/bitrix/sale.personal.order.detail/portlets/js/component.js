this.B2BPortal = this.B2BPortal || {};
(function (exports) {
	'use strict';

	var Blocks = /*#__PURE__*/function () {
	  function Blocks($el) {
	    var columns = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];
	    babelHelpers.classCallCheck(this, Blocks);
	    this.$el = $el;
	    this.columns = columns;
	    this.init();
	  }

	  babelHelpers.createClass(Blocks, [{
	    key: "init",
	    value: function init() {
	      var _this = this;

	      if (window.dragula) {
	        this.drake = dragula(this.columns, {
	          moves: function moves(el, container, handle) {
	            return handle.classList.contains('kt-portlet__head') || handle.closest('.kt-portlet__head') && !handle.classList.contains('btn') && !handle.closest('.btn');
	          }
	        });
	        this.drake.on('dragend', this.saveSorting.bind(this));
	      }

	      BX.addCustomEvent('SaleOrderDetailPaysystemChanged', function () {
	        return _this.reload('payment');
	      });
	      $(this.$el).find('.kt-portlet > .collapse').on('hidden.bs.collapse shown.bs.collapse', this.saveCollapsed.bind(this));
	    }
	  }, {
	    key: "reload",
	    value: function () {
	      var _reload = babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee(blockName) {
	        var blockNode, url, result, processed, contentNode;
	        return regeneratorRuntime.wrap(function _callee$(_context) {
	          while (1) {
	            switch (_context.prev = _context.next) {
	              case 0:
	                blockNode = this.$el.querySelector('[data-block="' + blockName + '"]');

	                if (!blockNode) {
	                  _context.next = 19;
	                  break;
	                }

	                url = window.location.href;
	                KTApp.block(blockNode);
	                _context.prev = 4;
	                _context.next = 7;
	                return this.sendRequest(url, {
	                  'reload_block': blockName
	                });

	              case 7:
	                result = _context.sent;
	                processed = BX.processHTML(result);
	                contentNode = blockNode.querySelector('.kt-portlet__body');

	                if (contentNode) {
	                  contentNode.innerHTML = processed.HTML;
	                  BX.ajax.processScripts(processed.SCRIPT);
	                }

	                _context.next = 16;
	                break;

	              case 13:
	                _context.prev = 13;
	                _context.t0 = _context["catch"](4);
	                console.warn(_context.t0);

	              case 16:
	                _context.prev = 16;
	                KTApp.unblock(blockNode);
	                return _context.finish(16);

	              case 19:
	              case "end":
	                return _context.stop();
	            }
	          }
	        }, _callee, this, [[4, 13, 16, 19]]);
	      }));

	      function reload(_x) {
	        return _reload.apply(this, arguments);
	      }

	      return reload;
	    }()
	  }, {
	    key: "sendRequest",
	    value: function sendRequest(url) {
	      var data = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
	      var params = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
	      return new Promise(function (resolve, reject) {
	        BX.ajax({
	          method: params.method || 'POST',
	          dataType: params.dataType || 'html',
	          url: url,
	          data: data,
	          processData: false,
	          onsuccess: resolve,
	          onfailure: reject
	        });
	      });
	    }
	  }, {
	    key: "getPositions",
	    value: function getPositions() {
	      return this.columns.map(function (column) {
	        return Object.values(column.children).map(function (el) {
	          return el.getAttribute('data-block');
	        });
	      });
	    }
	  }, {
	    key: "getCollapsed",
	    value: function getCollapsed() {
	      return Object.values(this.$el.querySelectorAll('.kt-portlet > .collapse')).filter(function (el) {
	        return !el.classList.contains('show');
	      }).map(function (el) {
	        return el.closest('[data-block]').getAttribute('data-block');
	      });
	    }
	  }, {
	    key: "saveSorting",
	    value: function () {
	      var _saveSorting = babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee2() {
	        var sorting;
	        return regeneratorRuntime.wrap(function _callee2$(_context2) {
	          while (1) {
	            switch (_context2.prev = _context2.next) {
	              case 0:
	                sorting = this.getPositions();
	                _context2.prev = 1;
	                _context2.next = 4;
	                return BX.ajax.runAction('redsign:b2bportal.api.userSettings.set', {
	                  data: {
	                    key: 'sod_sorted_blocks',
	                    value: sorting
	                  }
	                });

	              case 4:
	                _context2.next = 9;
	                break;

	              case 6:
	                _context2.prev = 6;
	                _context2.t0 = _context2["catch"](1);
	                console.warn(_context2.t0);

	              case 9:
	              case "end":
	                return _context2.stop();
	            }
	          }
	        }, _callee2, this, [[1, 6]]);
	      }));

	      function saveSorting() {
	        return _saveSorting.apply(this, arguments);
	      }

	      return saveSorting;
	    }()
	  }, {
	    key: "saveCollapsed",
	    value: function () {
	      var _saveCollapsed = babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee3() {
	        var collapsed;
	        return regeneratorRuntime.wrap(function _callee3$(_context3) {
	          while (1) {
	            switch (_context3.prev = _context3.next) {
	              case 0:
	                collapsed = this.getCollapsed();
	                _context3.prev = 1;
	                _context3.next = 4;
	                return BX.ajax.runAction('redsign:b2bportal.api.userSettings.set', {
	                  data: {
	                    key: 'sod_collapsed_blocks',
	                    value: collapsed
	                  }
	                });

	              case 4:
	                _context3.next = 9;
	                break;

	              case 6:
	                _context3.prev = 6;
	                _context3.t0 = _context3["catch"](1);
	                console.warn(_context3.t0);

	              case 9:
	              case "end":
	                return _context3.stop();
	            }
	          }
	        }, _callee3, this, [[1, 6]]);
	      }));

	      function saveCollapsed() {
	        return _saveCollapsed.apply(this, arguments);
	      }

	      return saveCollapsed;
	    }()
	  }]);
	  return Blocks;
	}();

	exports.Blocks = Blocks;

}((this.B2BPortal.SaleOrderDetail = this.B2BPortal.SaleOrderDetail || {})));
//# sourceMappingURL=component.js.map
