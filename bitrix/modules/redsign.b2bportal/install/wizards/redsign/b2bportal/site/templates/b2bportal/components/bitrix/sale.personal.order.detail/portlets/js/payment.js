this.B2BPortal = this.B2BPortal || {};
(function (exports) {
	'use strict';

	var Payment = /*#__PURE__*/function () {
	  function Payment(el, params) {
	    babelHelpers.classCallCheck(this, Payment);
	    this.$el = el;
	    this.data = params.paymentData;
	    this.ajaxPath = params.ajaxPath || '';
	    this.templateName = params.templateName || '.default';
	    this.initEvents();
	  }

	  babelHelpers.createClass(Payment, [{
	    key: "initEvents",
	    value: function initEvents() {
	      var changeButton = this.$el.querySelector('[data-entity="change-payment"]');

	      if (changeButton) {
	        changeButton.addEventListener('click', this.onChangePaymentHandle.bind(this), {
	          once: true
	        });
	      }
	    }
	  }, {
	    key: "onChangePaymentHandle",
	    value: function onChangePaymentHandle(event) {
	      var _this = this;

	      event.preventDefault();
	      BX.ajax({
	        method: 'POST',
	        dataType: 'html',
	        url: this.ajaxPath,
	        data: {
	          sessid: BX.bitrix_sessid(),
	          orderData: this.data,
	          templateName: this.templateName
	        },
	        onsuccess: function onsuccess(html) {
	          var dropdown = _this.$el.querySelector('[data-entity="payment-list"]');

	          dropdown.innerHTML = html;
	        }
	      });
	    }
	  }]);
	  return Payment;
	}();

	exports.Payment = Payment;

}((this.B2BPortal.SaleOrderDetail = this.B2BPortal.SaleOrderDetail || {})));
//# sourceMappingURL=payment.js.map
