/* eslint-disable */
this.B2BPortal = this.B2BPortal || {};
(function (exports) {
	'use strict';

	function _regeneratorRuntime() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == babelHelpers["typeof"](value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
	function action(_x, _x2) {
	  return _action.apply(this, arguments);
	}
	function _action() {
	  _action = babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(actionName, data) {
	    var resultData, result;
	    return _regeneratorRuntime().wrap(function _callee$(_context) {
	      while (1) switch (_context.prev = _context.next) {
	        case 0:
				console.log(0);
	          resultData = undefined;
	          _context.prev = 1;
	          _context.next = 4;
	          return new Promise(function (resolve, reject) {
	            BX.ajax.runComponentAction('redsign:b2bportal.basket.imports', actionName, {
	              mode: 'class',
	              data: data
	            }).then(resolve, reject);
	          });
	        case 4:
				console.log(4);
	          result = _context.sent;
	          resultData = result.data;
	          _context.next = 12;
	          break;
	        case 8:


	          _context.prev = 8;
	          _context.t0 = _context["catch"](1);
				if(_context.t0.status == "error"){
					window.toastr.error("В данном файле нет подходячих товаров для импорта");
				}
	          global.toastr.error(((_context.t0.errors || [])[0] || {}).message);
	          throw _context.t0;
	        case 12:
				console.log(12);
	          return _context.abrupt("return", resultData);
	        case 13:
			  case "end":

	          return _context.stop();
	      }
	    }, _callee, null, [[1, 8]]);
	  }));
	  return _action.apply(this, arguments);
	}
	function addtobasket(_x4) {
	  return _addtobasket.apply(this, arguments);
	}
	function _addtobasket() {
	  _addtobasket = babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3(data) {
	    return _regeneratorRuntime().wrap(function _callee3$(_context3) {
	      while (1) switch (_context3.prev = _context3.next) {
	        case 0:
	          return _context3.abrupt("return", action('addtobasket', data).then(function (result) {
	            BX.onCustomEvent('updateBasketComponent');
	            return result;
	          }));
	        case 1:
	        case "end":
	          return _context3.stop();
	      }
	    }, _callee3);
	  }));
	  return _addtobasket.apply(this, arguments);
	}
	function parseFile(_x5) {
	  return _parseFile.apply(this, arguments);
	}
	function _parseFile() {
	  _parseFile = babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4(data) {
	    return _regeneratorRuntime().wrap(function _callee4$(_context4) {
	      while (1) switch (_context4.prev = _context4.next) {
	        case 0:
	          return _context4.abrupt("return", action('parseFile', data));
	        case 1:
	        case "end":
	          return _context4.stop();
	      }
	    }, _callee4);
	  }));
	  return _parseFile.apply(this, arguments);
	}

	function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
	function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
	function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
	function _regeneratorRuntime$1() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime$1 = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == babelHelpers["typeof"](value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
	var script = {
	  components: {
	    Stepper: B2BPortal.Vue.Components.Stepper
	  },
	  props: {
	    signedParameters: {
	      type: String,
	      "default": ''
	    }
	  },
	  data: function data() {
	    return {
	      currentStepIndex: 0,
	      steps: Object.freeze(['step1', 'step2', 'step3']),
	      method: 'upload',
	      file: '',
	      filePath: '',
	      fileRows: [],
	      skipFirstRow: true,
	      settings: {
	        codeIndex: undefined,
	        quantityIndex: undefined
	      },
	      result: {}
	    };
	  },
	  computed: {
	    fileData: function fileData() {
	      return {
	        highestColumn: this.fileRows.reduce(function (highest, row) {
	          return Math.max(highest, row.length);
	        }, 0)
	      };
	    },
	    messages: function messages() {
	      return Object.freeze(Object.keys(BX.message).filter(function (message) {
	        return message.startsWith('RS_B2BPORTAL_BI');
	      }).reduce(function (obj, message) {
	        obj[message.slice(message)] = BX.message(message);
	        return obj;
	      }, {}));
	    }
	  },
	  methods: {
	    reset: function reset() {
	      this.currentStepIndex = 0;
	      this.fileRows = [];
	      this.file = '';
	      this.filePath = '';
	      this.settings = {
	        codeIndex: undefined,
	        quantityIndex: undefined
	      };
	      this.result = {};
	    },
	    startLoader: function startLoader() {
	      this.$emit('startLoader');
	    },
	    endLoader: function endLoader() {
	      this.$emit('endLoader');
	    },
	    validateFileInput: function validateFileInput() {
	      var fileInput = this.$refs.fileInput;
	      var file = (fileInput.files || [])[0];
	      this.filePath = fileInput.value;
	      if (file) {
	        fileInput.classList.remove('is-invalid');
	      } else {
	        fileInput.classList.add('is-invalid');
	      }
	    },
	    handleStep: function handleStep(step) {
	      this.currentStepIndex = step.index;
	    },
	    next: function next(step) {
	      var _this = this;
	      return babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime$1().mark(function _callee() {
	        return _regeneratorRuntime$1().wrap(function _callee$(_context) {
	          while (1) switch (_context.prev = _context.next) {
	            case 0:
	              _context.t0 = step.name;
	              _context.next = _context.t0 === 'step1' ? 3 : _context.t0 === 'step2' ? 17 : 30;
	              break;
	            case 3:
	              _context.prev = 3;
	              _this.startLoader();
	              _context.next = 7;
	              return _this.processReadFile();
	            case 7:
	              if (!_context.sent) {
	                _context.next = 9;
	                break;
	              }
	              step.next();
	            case 9:
	              _context.next = 13;
	              break;
	            case 11:
	              _context.prev = 11;
	              _context.t1 = _context["catch"](3);
	            case 13:
	              _context.prev = 13;
	              _this.endLoader();
	              return _context.finish(13);
	            case 16:
	              return _context.abrupt("break", 30);
	            case 17:
	              _context.prev = 17;
	              _this.startLoader();
	              step.next();
	              _context.next = 22;
	              return _this.addtobasket();
	            case 22:
	              _context.next = 26;
	              break;
	            case 24:
	              _context.prev = 24;
	              _context.t2 = _context["catch"](17);
	            case 26:
	              _context.prev = 26;
	              _this.endLoader();
	              return _context.finish(26);
	            case 29:
	              return _context.abrupt("break", 30);
	            case 30:
	            case "end":
	              return _context.stop();
	          }
	        }, _callee, null, [[3, 11, 13, 16], [17, 24, 26, 29]]);
	      }))();
	    },
	    back: function back(step) {
	      return babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime$1().mark(function _callee2() {
	        return _regeneratorRuntime$1().wrap(function _callee2$(_context2) {
	          while (1) switch (_context2.prev = _context2.next) {
	            case 0:
	              step.back();
	            case 1:
	            case "end":
	              return _context2.stop();
	          }
	        }, _callee2);
	      }))();
	    },
	    processReadFile: function processReadFile() {
	      var _this2 = this;
	      return babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime$1().mark(function _callee3() {
	        return _regeneratorRuntime$1().wrap(function _callee3$(_context3) {
	          while (1) switch (_context3.prev = _context3.next) {
	            case 0:
	              if (!(_this2.method === 'upload')) {
	                _context3.next = 4;
	                break;
	              }
	              return _context3.abrupt("return", _this2.processReadFileByUpload());
	            case 4:
	              if (!(_this2.method === 'link')) {
	                _context3.next = 6;
	                break;
	              }
	              return _context3.abrupt("return", _this2.processReadFileByPath());
	            case 6:
	              throw new Error('Wrong file upload method');
	            case 7:
	            case "end":
	              return _context3.stop();
	          }
	        }, _callee3);
	      }))();
	    },
	    processReadFileByUpload: function processReadFileByUpload() {
	      var _this3 = this;
	      return babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime$1().mark(function _callee4() {
	        var fileInput, file, formData;
	        return _regeneratorRuntime$1().wrap(function _callee4$(_context4) {
	          while (1) switch (_context4.prev = _context4.next) {
	            case 0:
	              fileInput = _this3.$refs.fileInput;
	              file = (fileInput.files || [])[0];
	              if (!file) {
	                _context4.next = 13;
	                break;
	              }
	              formData = new FormData();
	              formData.append('file', file);
	              formData.append('signedParamaters', _this3.signedParameters);
	              formData.append('sessid', BX.bitrix_sessid());
	              _context4.next = 9;
	              return parseFile(formData);
	            case 9:
	              _this3.fileRows = _context4.sent;
	              return _context4.abrupt("return", true);
	            case 13:
	              fileInput.classList.add('is-invalid');
	            case 14:
	              return _context4.abrupt("return", false);
	            case 15:
	            case "end":
	              return _context4.stop();
	          }
	        }, _callee4);
	      }))();
	    },
	    processReadFileByPath: function processReadFileByPath() {
	      var _this4 = this;
	      return babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime$1().mark(function _callee5() {
	        return _regeneratorRuntime$1().wrap(function _callee5$(_context5) {
	          while (1) switch (_context5.prev = _context5.next) {
	            case 0:
	              _context5.next = 2;
	              return parseFile({
	                path: _this4.filePath,
	                signedParameters: _this4.signedParameters
	              });
	            case 2:
	              _this4.fileRows = _context5.sent;
	              return _context5.abrupt("return", true);
	            case 4:
	            case "end":
	              return _context5.stop();
	          }
	        }, _callee5);
	      }))();
	    },
	    prepareData: function prepareData() {
	      var data = {};
	      var rows = babelHelpers.toConsumableArray(this.fileRows);
	      if (this.skipFirstRow) {
	        rows.shift();
	      }
	      var _iterator = _createForOfIteratorHelper(rows),
	        _step;
	      try {
	        for (_iterator.s(); !(_step = _iterator.n()).done;) {
	          var row = _step.value;
	          var codeStr = new String(row[this.settings.codeIndex - 1]);
	          if (codeStr.trim() !== '') {
	            data[codeStr] = row[this.settings.quantityIndex - 1];
	          }
	        }
	      } catch (err) {
	        _iterator.e(err);
	      } finally {
	        _iterator.f();
	      }
	      return data;
	    },
	    addtobasket: function addtobasket$$1() {
	      var _this5 = this;
	      return babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime$1().mark(function _callee6() {
	        var data, result;
	        return _regeneratorRuntime$1().wrap(function _callee6$(_context6) {
	          while (1) switch (_context6.prev = _context6.next) {
	            case 0:
	              if (!(_this5.fileRows.length === 0)) {
	                _context6.next = 2;
	                break;
	              }
	              return _context6.abrupt("return");
	            case 2:
	              data = _this5.prepareData();
	              _context6.prev = 3;
	              _context6.next = 6;
	              return addtobasket({
	                data: data,
	                signedParameters: _this5.signedParameters
	              });
	            case 6:
	              result = _context6.sent;
	              _this5.result = result;
	              _this5.$store.dispatch('cart/fetch');
	              _context6.next = 14;
	              break;
	            case 11:
	              _context6.prev = 11;
	              _context6.t0 = _context6["catch"](3);
	              console.error(_context6.t0);
	            case 14:
	            case "end":
	              return _context6.stop();
	          }
	        }, _callee6, null, [[3, 11]]);
	      }))();
	    }
	  },
	  watch: {
	    fileRows: function fileRows(newVal) {
	      if (this.fileRows.length > 0) {
	        if (this.fileRows[0].length === 5) {
	          // default export
	          this.settings.codeIndex = 2;
	          this.settings.quantityIndex = 4;
	        } else {
	          this.settings.codeIndex = this.fileRows[0].length > 0 ? 1 : undefined;
	          this.settings.quantityIndex = this.fileRows[0].length > 1 ? 2 : undefined;
	        }
	      }
	    }
	  }
	};

	function normalizeComponent(template, style, script, scopeId, isFunctionalTemplate, moduleIdentifier
	/* server only */, shadowMode, createInjector, createInjectorSSR, createInjectorShadow) {
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
	      context = context ||
	      // cached call
	      this.$vnode && this.$vnode.ssrContext ||
	      // stateful
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
	  return _c("Stepper", {
	    attrs: {
	      steps: _vm.steps,
	      currentStep: _vm.currentStepIndex
	    },
	    on: {
	      onStep: _vm.handleStep
	    },
	    scopedSlots: _vm._u([{
	      key: "step1",
	      fn: function fn(step) {
	        return [_c("div", {
	          staticClass: "form-group"
	        }, [_vm._v("\n\n\t\t\t" + _vm._s(_vm.messages.RS_B2BPORTAL_BI_FILE_IMPORT_STEP_1)), _c("br"), _c("br"), _vm._v(" "), _c("ul", {
	          staticClass: "nav nav-pills mb-3"
	        }, [_c("li", {
	          staticClass: "nav-item"
	        }, [_c("a", {
	          staticClass: "nav-link",
	          "class": {
	            active: _vm.method === "upload"
	          },
	          attrs: {
	            href: "#",
	            role: "tab"
	          },
	          on: {
	            click: function click($event) {
	              $event.preventDefault();
	              _vm.method = "upload";
	            }
	          }
	        }, [_vm._v("\n\t\t\t\t\t\t" + _vm._s(_vm.messages.RS_B2BPORTAL_BI_FILE_IMPORT_UPLOAD) + "\n\t\t\t\t\t")])]), _vm._v(" "), _c("li", {
	          staticClass: "nav-item"
	        }, [_c("a", {
	          staticClass: "nav-link",
	          "class": {
	            active: _vm.method === "link"
	          },
	          attrs: {
	            href: "#"
	          },
	          on: {
	            click: function click($event) {
	              $event.preventDefault();
	              _vm.method = "link";
	            }
	          }
	        }, [_vm._v("\n\t\t\t\t\t\t" + _vm._s(_vm.messages.RS_B2BPORTAL_BI_FILE_IMPORT_LINK) + "\n\t\t\t\t\t")])])]), _vm._v(" "), _c("transition", {
	          attrs: {
	            name: "fade"
	          }
	        }, [_c("div", [_c("div", {
	          directives: [{
	            name: "show",
	            rawName: "v-show",
	            value: _vm.method === "upload",
	            expression: "method === 'upload'"
	          }]
	        }, [_c("label", [_vm._v(_vm._s(_vm.messages.RS_B2BPORTAL_BI_FILE_IMPORT_SELECT_FILE))]), _vm._v(" "), _c("div"), _vm._v(" "), _c("div", {
	          staticClass: "custom-file"
	        }, [_c("input", {
	          ref: "fileInput",
	          staticClass: "custom-file-input",
	          attrs: {
	            type: "file"
	          },
	          on: {
	            change: function change($event) {
	              $event.preventDefault();
	              return _vm.validateFileInput($event);
	            }
	          }
	        }), _vm._v(" "), _c("label", {
	          staticClass: "custom-file-label",
	          attrs: {
	            "for": "customFile",
	            "data-browse": _vm.messages.RS_B2BPORTAL_BI_BROWSE
	          }
	        }, [_vm._v(_vm._s(_vm.filePath))])])]), _vm._v(" "), _c("div", {
	          directives: [{
	            name: "show",
	            rawName: "v-show",
	            value: _vm.method === "link",
	            expression: "method === 'link'"
	          }]
	        }, [_c("div", {
	          staticClass: "form-group"
	        }, [_c("label", [_vm._v(" " + _vm._s(_vm.messages.RS_B2BPORTAL_BI_FILE_IMPORT_DOCUMENT_LINK) + " ")]), _vm._v(" "), _c("input", {
	          directives: [{
	            name: "model",
	            rawName: "v-model",
	            value: _vm.filePath,
	            expression: "filePath"
	          }],
	          staticClass: "form-control",
	          attrs: {
	            type: "text",
	            placeholder: "https://example.com/file.csv"
	          },
	          domProps: {
	            value: _vm.filePath
	          },
	          on: {
	            input: function input($event) {
	              if ($event.target.composing) {
	                return;
	              }
	              _vm.filePath = $event.target.value;
	            }
	          }
	        })])])])])], 1), _vm._v(" "), _c("a", {
	          staticClass: "btn btn-primary pull-right",
	          attrs: {
	            href: "#"
	          },
	          on: {
	            click: function click($event) {
	              $event.preventDefault();
	              $event.stopPropagation();
	              return _vm.next(step);
	            }
	          }
	        }, [_vm._v(" " + _vm._s(_vm.messages.RS_B2BPORTAL_BI_FILE_IMPORT_NEXT) + " ")])];
	      }
	    }, {
	      key: "step2",
	      fn: function fn(step) {
	        return [_vm._v("\n\t\t" + _vm._s(_vm.messages.RS_B2BPORTAL_BI_FILE_IMPORT_STEP_2)), _c("br"), _c("br"), _vm._v(" "), _c("div", {
	          staticClass: "form-group row"
	        }, [_c("label", {
	          staticClass: "col-2 col-form-label",
	          attrs: {
	            "for": "example-input-2"
	          }
	        }, [_vm._v(_vm._s(_vm.messages.RS_B2BPORTAL_BI_FILE_IMPORT_ARTICLE))]), _vm._v(" "), _c("div", {
	          staticClass: "col-10"
	        }, [_c("select", {
	          directives: [{
	            name: "model",
	            rawName: "v-model",
	            value: _vm.settings.codeIndex,
	            expression: "settings.codeIndex"
	          }],
	          staticClass: "form-control",
	          attrs: {
	            id: "example-input-2"
	          },
	          on: {
	            change: function change($event) {
	              var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
	                return o.selected;
	              }).map(function (o) {
	                var val = "_value" in o ? o._value : o.value;
	                return val;
	              });
	              _vm.$set(_vm.settings, "codeIndex", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
	            }
	          }
	        }, [_c("option", {
	          domProps: {
	            value: undefined
	          }
	        }, [_vm._v("-")]), _vm._v(" "), _vm._l(_vm.fileData.highestColumn, function (i) {
	          return _c("option", {
	            key: i,
	            attrs: {
	              disabled: i === _vm.settings.quantityIndex
	            },
	            domProps: {
	              value: i
	            }
	          }, [_vm._v(_vm._s(i) + " (" + _vm._s(_vm.fileRows[0][i - 1]) + ")")]);
	        })], 2)])]), _vm._v(" "), _c("div", {
	          staticClass: "form-group row"
	        }, [_c("label", {
	          staticClass: "col-2 col-form-label",
	          attrs: {
	            "for": "example-input-2"
	          }
	        }, [_vm._v(_vm._s(_vm.messages.RS_B2BPORTAL_BI_FILE_IMPORT_QUANTITY))]), _vm._v(" "), _c("div", {
	          staticClass: "col-10"
	        }, [_c("select", {
	          directives: [{
	            name: "model",
	            rawName: "v-model",
	            value: _vm.settings.quantityIndex,
	            expression: "settings.quantityIndex"
	          }],
	          staticClass: "form-control",
	          attrs: {
	            id: "example-input-2"
	          },
	          on: {
	            change: function change($event) {
	              var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
	                return o.selected;
	              }).map(function (o) {
	                var val = "_value" in o ? o._value : o.value;
	                return val;
	              });
	              _vm.$set(_vm.settings, "quantityIndex", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
	            }
	          }
	        }, [_c("option", {
	          domProps: {
	            value: undefined
	          }
	        }, [_vm._v("-")]), _vm._v(" "), _vm._l(_vm.fileData.highestColumn, function (i) {
	          return _c("option", {
	            key: i,
	            attrs: {
	              disabled: i === _vm.settings.codeIndex
	            },
	            domProps: {
	              value: i
	            }
	          }, [_vm._v(_vm._s(i) + " (" + _vm._s(_vm.fileRows[0][i - 1]) + ")")]);
	        })], 2)])]), _vm._v(" "), _c("div", {
	          staticClass: "form-group row"
	        }, [_c("div", {
	          staticClass: "col-10 offset-2"
	        }, [_c("label", {
	          staticClass: "kt-checkbox"
	        }, [_c("input", {
	          directives: [{
	            name: "model",
	            rawName: "v-model",
	            value: _vm.skipFirstRow,
	            expression: "skipFirstRow"
	          }],
	          attrs: {
	            type: "checkbox"
	          },
	          domProps: {
	            checked: Array.isArray(_vm.skipFirstRow) ? _vm._i(_vm.skipFirstRow, null) > -1 : _vm.skipFirstRow
	          },
	          on: {
	            change: function change($event) {
	              var $$a = _vm.skipFirstRow,
	                $$el = $event.target,
	                $$c = $$el.checked ? true : false;
	              if (Array.isArray($$a)) {
	                var $$v = null,
	                  $$i = _vm._i($$a, $$v);
	                if ($$el.checked) {
	                  $$i < 0 && (_vm.skipFirstRow = $$a.concat([$$v]));
	                } else {
	                  $$i > -1 && (_vm.skipFirstRow = $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
	                }
	              } else {
	                _vm.skipFirstRow = $$c;
	              }
	            }
	          }
	        }), _vm._v(" " + _vm._s(_vm.messages.RS_B2BPORTAL_BI_FILE_IMPORT_SKIP_FIRST_ROW) + "\n\t\t\t\t\t"), _c("span")])])]), _vm._v(" "), _c("a", {
	          staticClass: "btn btn-primary pull-right",
	          attrs: {
	            href: "#"
	          },
	          on: {
	            click: function click($event) {
	              $event.preventDefault();
	              $event.stopPropagation();
	              return _vm.next(step);
	            }
	          }
	        }, [_vm._v(" " + _vm._s(_vm.messages.RS_B2BPORTAL_BI_FILE_IMPORT_NEXT) + " ")]), _vm._v(" "), _c("a", {
	          staticClass: "btn btn-btn-outline-brand pull-right",
	          attrs: {
	            href: "#"
	          },
	          on: {
	            click: function click($event) {
	              $event.preventDefault();
	              $event.stopPropagation();
	              return _vm.back(step);
	            }
	          }
	        }, [_vm._v(_vm._s(_vm.messages.RS_B2BPORTAL_BI_FILE_IMPORT_BACK))])];
	      }
	    }, {
	      key: "step3",
	      fn: function fn(step3) {
	        return [_vm._v("\n\t\t" + _vm._s(_vm.messages.RS_B2BPORTAL_BI_FILE_IMPORT_STEP_3)), _c("br"), _c("br"), _vm._v(" "), !!_vm.result ? _c("div",
					{staticClass: "import-items"},_vm._l(_vm.result, function (basketResult, code) {
				return _c("div", {
				staticClass: "import-item",
	            key: code
	          }, [_c("span", {
	            "class": {
	              "text-success": basketResult.isSuccess,
	              "text-danger": !basketResult.isSuccess
	            }
	          }, [_vm._v(_vm._s(code) + ": " + _vm._s(basketResult.message) + " ")])]);
	        }), 0) : _vm._e(), _vm._v(" "), _c("br"), _c("br"), _vm._v(" "), _c("a", {
	          staticClass: "btn btn-primary pull-right",
	          attrs: {
	            href: "#"
	          },
	          on: {
	            click: function click($event) {
	              $event.preventDefault();
	              $event.stopPropagation();
	              return _vm.reset();
	            }
	          }
	        }, [_vm._v(" " + _vm._s(_vm.messages.RS_B2BPORTAL_BI_FILE_IMPORT_RESET) + " ")])];
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

	/* style inject shadow dom */

	var __vue_component__ = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__,
	  staticRenderFns: __vue_staticRenderFns__
	}, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, false, undefined, undefined, undefined);

	var _B2BPortal = B2BPortal,
	  store = _B2BPortal.store;
	var BasketFileImport = /*#__PURE__*/function () {
	  function BasketFileImport(params) {
	    babelHelpers.classCallCheck(this, BasketFileImport);
	    this._params = params;
	    this.el = params.el;
	    this.modal = params.modal;
	    this.signedParameters = params.signedParameters;
	    this.init();
	  }
	  babelHelpers.createClass(BasketFileImport, [{
	    key: "init",
	    value: function init() {
	      var _this = this;
	      var signedParameters = this.signedParameters;
	      var startLoader = function startLoader() {
	        return KTApp.block(_this.modal);
	      };
	      var endLoader = function endLoader() {
	        return KTApp.unblock(_this.modal);
	      };
	      this.component = new Vue({
	        el: this.el,
	        components: {
	          FileImport: __vue_component__
	        },
	        template: "<FileImport ref=\"fileImport\" :signedParameters=\"signedParameters\"/>",
	        store: store,
	        data: function data() {
	          return {
	            signedParameters: signedParameters
	          };
	        },
	        mounted: function mounted() {
	          this.$refs.fileImport.$on('startLoader', startLoader);
	          this.$refs.fileImport.$on('endLoader', endLoader);
	        }
	      });
	    }
	  }]);
	  return BasketFileImport;
	}();

	exports.BasketFileImport = BasketFileImport;

}((this.B2BPortal.Components = this.B2BPortal.Components || {})));
//# sourceMappingURL=FileImport.js.map
