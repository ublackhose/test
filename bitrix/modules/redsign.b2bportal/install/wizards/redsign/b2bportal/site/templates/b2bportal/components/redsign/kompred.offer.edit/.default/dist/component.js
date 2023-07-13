this.B2BPortal = this.B2BPortal || {};
(function (exports) {
	'use strict';

	var KPEdit = /*#__PURE__*/function () {
	  function KPEdit(params) {
	    babelHelpers.classCallCheck(this, KPEdit);
	    this.signedParameters = params.signedParameters;
	    this.editor = params.editor;
	    this.nameInput = params.nameInput;
	    this.linkInput = params.linkInput;
	    this.copyToClipboardButton = params.copyToClipboardButton;
	    this.deleteButton = params.deleteButton;
	    this.shortLinkToggle = params.shortLinkToggle;
	    this.download = params.download;
	    this.shortlink = params.shortlink;
	    this.isShowedShortlink = !!this.shortlink;
	    this.editor.subscribe(RSKomPred.Editor.Events.CHANGED, this.saveData.bind(this));
	    this.nameInput.addEventListener('change', this.saveData.bind(this));
	    this.copyToClipboardButton.addEventListener('click', this.copyClipboard.bind(this));
	    this.deleteButton.addEventListener('click', this.confirmDelete.bind(this));
	    this.shortLinkToggle.addEventListener('click', this.toggleShortlink.bind(this));
	  }

	  babelHelpers.createClass(KPEdit, [{
	    key: "saveData",
	    value: function () {
	      var _saveData = babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee() {
	        var data;
	        return regeneratorRuntime.wrap(function _callee$(_context) {
	          while (1) {
	            switch (_context.prev = _context.next) {
	              case 0:
	                _context.next = 2;
	                return this.editor.save();

	              case 2:
	                data = _context.sent;
	                data.offer.name = this.nameInput.value;
	                return _context.abrupt("return", new Promise(function (resolve, reject) {
	                  BX.ajax.runAction('redsign:kompred.api.offer.save', {
	                    data: data
	                  }).then(resolve, reject);
	                }));

	              case 5:
	              case "end":
	                return _context.stop();
	            }
	          }
	        }, _callee, this);
	      }));

	      function saveData() {
	        return _saveData.apply(this, arguments);
	      }

	      return saveData;
	    }()
	  }, {
	    key: "copyClipboard",
	    value: function copyClipboard() {
	      this.linkInput.focus();
	      this.linkInput.select();
	      document.execCommand('copy');

	      if (window.toastr) {
	        window.toastr.success(BX.message('RS_KP_KOE_T_COPY_TO_CLIPBOARD_SUCCESS'));
	      }
	    }
	  }, {
	    key: "confirmDelete",
	    value: function confirmDelete(event) {
	      var _this = this;

	      event.preventDefault();
	      Swal.fire({
	        title: BX.message('RS_KP_KOE_T_DELETE_CONFIRM'),
	        type: 'warning',
	        showCancelButton: true,
	        animation: false,
	        confirmButtonText: BX.message('RS_KP_KOE_T_DELETE_CONFIRM_YES'),
	        cancelButtonText: BX.message('RS_KP_KOE_T_DELETE_CONFIRM_NO')
	      }).then(function (result) {
	        if (result.value) window.location = _this.deleteButton.href;
	      });
	    }
	  }, {
	    key: "toggleShortlink",
	    value: function () {
	      var _toggleShortlink = babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee2() {
	        return regeneratorRuntime.wrap(function _callee2$(_context2) {
	          while (1) {
	            switch (_context2.prev = _context2.next) {
	              case 0:
	                if (!this.isShowedShortlink) {
	                  _context2.next = 5;
	                  break;
	                }

	                this.linkInput.value = this.download;
	                this.isShowedShortlink = false;
	                _context2.next = 10;
	                break;

	              case 5:
	                if (this.shortlink) {
	                  _context2.next = 8;
	                  break;
	                }

	                _context2.next = 8;
	                return this.makeShortLink();

	              case 8:
	                this.linkInput.value = this.shortlink;
	                this.isShowedShortlink = true;

	              case 10:
	              case "end":
	                return _context2.stop();
	            }
	          }
	        }, _callee2, this);
	      }));

	      function toggleShortlink() {
	        return _toggleShortlink.apply(this, arguments);
	      }

	      return toggleShortlink;
	    }()
	  }, {
	    key: "makeShortLink",
	    value: function () {
	      var _makeShortLink = babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee3() {
	        var _this2 = this;

	        var result;
	        return regeneratorRuntime.wrap(function _callee3$(_context3) {
	          while (1) {
	            switch (_context3.prev = _context3.next) {
	              case 0:
	                this.shortLinkToggle.disabled = true;
	                this.shortLinkToggle.classList.add('disabled');
	                _context3.prev = 2;
	                _context3.next = 5;
	                return new Promise(function (resolve, reject) {
	                  BX.ajax.runComponentAction('redsign:kompred.offer.edit', 'makeShortLink', {
	                    mode: 'class',
	                    data: {
	                      signedParameters: _this2.signedParameters
	                    }
	                  }).then(resolve, reject);
	                });

	              case 5:
	                result = _context3.sent;

	                if (result.status === 'success' && result.data) {
	                  this.shortlink = "".concat(window.location.protocol, "//").concat(window.location.host).concat(result.data);
	                }

	                _context3.next = 12;
	                break;

	              case 9:
	                _context3.prev = 9;
	                _context3.t0 = _context3["catch"](2);
	                console.error(_context3.t0);

	              case 12:
	                _context3.prev = 12;
	                this.shortLinkToggle.disabled = false;
	                this.shortLinkToggle.classList.remove('disabled');
	                return _context3.finish(12);

	              case 16:
	              case "end":
	                return _context3.stop();
	            }
	          }
	        }, _callee3, this, [[2, 9, 12, 16]]);
	      }));

	      function makeShortLink() {
	        return _makeShortLink.apply(this, arguments);
	      }

	      return makeShortLink;
	    }()
	  }]);
	  return KPEdit;
	}();

	exports.KPEdit = KPEdit;

}((this.B2BPortal.Components = this.B2BPortal.Components || {})));
//# sourceMappingURL=component.js.map
