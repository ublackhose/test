(function (exports) {
	'use strict';

	var SaleOrderPaymentChange = /*#__PURE__*/function () {
	  function SaleOrderPaymentChange($el, params) {
	    babelHelpers.classCallCheck(this, SaleOrderPaymentChange);
	    this.$el = $el;
	    this.ajaxPath = params.ajaxPath;
	    this.accountNumber = params.accountNumber || {};
	    this.paymentNumber = params.paymentNumber || {};
	    this.onlyInnerFull = params.onlyInnerFull || "";
	    this.templateName = params.templateName || "";
	    this.pathToPayment = params.pathToPayment || "";
	    this.refreshPrices = params.refreshPrices || "N";
	    this.inner = params.inner || "";
	    this.templateFolder = params.templateFolder;
	    this.initEvents();
	  }

	  babelHelpers.createClass(SaleOrderPaymentChange, [{
	    key: "initEvents",
	    value: function initEvents() {
	      var pyamentNodes = this.$el.querySelectorAll('[data-entity="paysystem"]');

	      if (pyamentNodes.length) {
	        for (var i in pyamentNodes) {
	          if (pyamentNodes.hasOwnProperty(i)) {
	            pyamentNodes[i].addEventListener('click', this.onSelectPaymentHandle.bind(this));
	          }
	        }
	      }
	    }
	  }, {
	    key: "onSelectPaymentHandle",
	    value: function () {
	      var _onSelectPaymentHandle = babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee(event) {
	        var node, paysystemId, result, messages;
	        return regeneratorRuntime.wrap(function _callee$(_context) {
	          while (1) {
	            switch (_context.prev = _context.next) {
	              case 0:
	                event.preventDefault();
	                node = event.currentTarget || event.target.closest('[data-entity="paysystem"]');
	                paysystemId = node.getAttribute('data-paysystem-id');
	                _context.prev = 3;
	                _context.next = 6;
	                return this.changePaysystem(paysystemId);

	              case 6:
	                result = _context.sent;
	                messages = result.messages;

	                if (messages.length > 0) {
	                  this.showMessages(messages);
	                }

	                if (!result.isInnerPayment) {
	                  _context.next = 12;
	                  break;
	                }

	                _context.next = 12;
	                return this.innerPay(result.innerPaymentData, result.isOnlyInnerFull);

	              case 12:
	                BX.onCustomEvent('SaleOrderDetailPaysystemChanged');
	                _context.next = 18;
	                break;

	              case 15:
	                _context.prev = 15;
	                _context.t0 = _context["catch"](3);
	                console.warn(_context.t0);

	              case 18:
	              case "end":
	                return _context.stop();
	            }
	          }
	        }, _callee, this, [[3, 15]]);
	      }));

	      function onSelectPaymentHandle(_x) {
	        return _onSelectPaymentHandle.apply(this, arguments);
	      }

	      return onSelectPaymentHandle;
	    }()
	  }, {
	    key: "showMessages",
	    value: function showMessages() {
	      var messages = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
	      messages.forEach(function (message) {
	        if (message.type === 'error') {
	          Swal.fire({
	            type: 'error',
	            text: message.text
	          });
	        } else {
	          window.toastr[message.type](message.text);
	        }
	      });
	    }
	  }, {
	    key: "innerPay",
	    value: function () {
	      var _innerPay = babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee2(data, isOnlyFull) {
	        var confirmInnerPay, sum;
	        return regeneratorRuntime.wrap(function _callee2$(_context2) {
	          while (1) {
	            switch (_context2.prev = _context2.next) {
	              case 0:
	                if (!isOnlyFull) {
	                  _context2.next = 9;
	                  break;
	                }

	                _context2.next = 3;
	                return this.confirmInnerPay(data);

	              case 3:
	                confirmInnerPay = _context2.sent;

	                if (!confirmInnerPay) {
	                  _context2.next = 7;
	                  break;
	                }

	                _context2.next = 7;
	                return this.sendInnerPay(data.sum);

	              case 7:
	                _context2.next = 14;
	                break;

	              case 9:
	                _context2.next = 11;
	                return this.promptInnerPay(data);

	              case 11:
	                sum = _context2.sent;
	                _context2.next = 14;
	                return this.sendInnerPay(sum);

	              case 14:
	              case "end":
	                return _context2.stop();
	            }
	          }
	        }, _callee2, this);
	      }));

	      function innerPay(_x2, _x3) {
	        return _innerPay.apply(this, arguments);
	      }

	      return innerPay;
	    }()
	  }, {
	    key: "confirmInnerPay",
	    value: function confirmInnerPay(data) {
	      return Swal.fire({
	        title: BX.message('SOPC_TPL_SUM_TO_PAID') + ': ' + data.sumFormatted,
	        type: 'warning',
	        showCancelButton: true,
	        confirmButtonText: BX.message('SOPC_TPL_PAY_BUTTON'),
	        cancelButtonText: BX.message('SOPC_TPL_PAY_CANCEL')
	      }).then(function (result) {
	        return result.value;
	      });
	    }
	  }, {
	    key: "promptInnerPay",
	    value: function promptInnerPay(data) {
	      var sum = Number(data.sum);
	      var budget = Number(data.budget);
	      return Swal.fire({
	        title: BX.message('SOPC_TPL_SUM_TO_PAID') + ': ' + data.sumFormatted,
	        input: 'number',
	        inputAttributes: {
	          min: 0,
	          max: budget >= sum ? sum : budget
	        },
	        inputValue: budget >= sum ? sum : budget,
	        showCancelButton: true,
	        confirmButtonText: BX.message('SOPC_TPL_PAY_BUTTON'),
	        cancelButtonText: BX.message('SOPC_TPL_PAY_CANCEL')
	      }).then(function (result) {
	        return result.value;
	      });
	    }
	  }, {
	    key: "changePaysystem",
	    value: function changePaysystem(paysystemId) {
	      var _this = this;

	      return new Promise(function (resolve, reject) {
	        BX.ajax({
	          method: 'POST',
	          dataType: 'json',
	          url: _this.ajaxPath,
	          data: {
	            sessid: BX.bitrix_sessid(),
	            paySystemId: paysystemId,
	            accountNumber: _this.accountNumber,
	            paymentNumber: _this.paymentNumber,
	            templateName: _this.templateName,
	            inner: _this.inner,
	            refreshPrices: _this.refreshPrices,
	            onlyInnerFull: _this.onlyInnerFull,
	            pathToPayment: _this.pathToPayment
	          },
	          onsuccess: resolve,
	          onfailure: reject
	        });
	      });
	    }
	  }, {
	    key: "sendInnerPay",
	    value: function sendInnerPay(sum) {
	      var _this2 = this;

	      return new Promise(function (resolve, reject) {
	        BX.ajax({
	          method: 'POST',
	          dataType: 'json',
	          url: _this2.ajaxPath,
	          data: {
	            sessid: BX.bitrix_sessid(),
	            accountNumber: _this2.accountNumber,
	            paymentNumber: _this2.paymentNumber,
	            inner: "Y",
	            onlyInnerFull: _this2.onlyInnerFull,
	            paymentSum: sum
	          },
	          onsuccess: resolve,
	          onfailure: reject
	        });
	      });
	    }
	  }]);
	  return SaleOrderPaymentChange;
	}();

	exports.SaleOrderPaymentChange = SaleOrderPaymentChange;

}((this.B2BPortal = this.B2BPortal || {})));
//# sourceMappingURL=component.js.map
