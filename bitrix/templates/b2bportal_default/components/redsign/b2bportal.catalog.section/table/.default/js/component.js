this.B2BPortal = this.B2BPortal || {};
(function (exports) {
	'use strict';

	var FieldMixin = {
	  props: {
	    row: Object,
	    product: Object
	  }
	};

	/**
	 * The base implementation of methods like `_.findKey` and `_.findLastKey`,
	 * without support for iteratee shorthands, which iterates over `collection`
	 * using `eachFunc`.
	 *
	 * @private
	 * @param {Array|Object} collection The collection to inspect.
	 * @param {Function} predicate The function invoked per iteration.
	 * @param {Function} eachFunc The function to iterate over `collection`.
	 * @returns {*} Returns the found element or its key, else `undefined`.
	 */
	function baseFindKey(collection, predicate, eachFunc) {
	  var result;
	  eachFunc(collection, function (value, key, collection) {
	    if (predicate(value, key, collection)) {
	      result = key;
	      return false;
	    }
	  });
	  return result;
	}

	var _baseFindKey = baseFindKey;

	/**
	 * Creates a base function for methods like `_.forIn` and `_.forOwn`.
	 *
	 * @private
	 * @param {boolean} [fromRight] Specify iterating from right to left.
	 * @returns {Function} Returns the new base function.
	 */
	function createBaseFor(fromRight) {
	  return function (object, iteratee, keysFunc) {
	    var index = -1,
	        iterable = Object(object),
	        props = keysFunc(object),
	        length = props.length;

	    while (length--) {
	      var key = props[fromRight ? length : ++index];

	      if (iteratee(iterable[key], key, iterable) === false) {
	        break;
	      }
	    }

	    return object;
	  };
	}

	var _createBaseFor = createBaseFor;

	/**
	 * The base implementation of `baseForOwn` which iterates over `object`
	 * properties returned by `keysFunc` and invokes `iteratee` for each property.
	 * Iteratee functions may exit iteration early by explicitly returning `false`.
	 *
	 * @private
	 * @param {Object} object The object to iterate over.
	 * @param {Function} iteratee The function invoked per iteration.
	 * @param {Function} keysFunc The function to get the keys of `object`.
	 * @returns {Object} Returns `object`.
	 */

	var baseFor = _createBaseFor();
	var _baseFor = baseFor;

	/**
	 * The base implementation of `_.times` without support for iteratee shorthands
	 * or max array length checks.
	 *
	 * @private
	 * @param {number} n The number of times to invoke `iteratee`.
	 * @param {Function} iteratee The function invoked per iteration.
	 * @returns {Array} Returns the array of results.
	 */
	function baseTimes(n, iteratee) {
	  var index = -1,
	      result = Array(n);

	  while (++index < n) {
	    result[index] = iteratee(index);
	  }

	  return result;
	}

	var _baseTimes = baseTimes;

	var commonjsGlobal = typeof window !== 'undefined' ? window : typeof global !== 'undefined' ? global : typeof self !== 'undefined' ? self : {};
	function createCommonjsModule(fn, module) {
	  return module = {
	    exports: {}
	  }, fn(module, module.exports), module.exports;
	}

	/** Detect free variable `global` from Node.js. */

	var freeGlobal = babelHelpers["typeof"](commonjsGlobal) == 'object' && commonjsGlobal && commonjsGlobal.Object === Object && commonjsGlobal;
	var _freeGlobal = freeGlobal;

	/** Detect free variable `self`. */

	var freeSelf = (typeof self === "undefined" ? "undefined" : babelHelpers["typeof"](self)) == 'object' && self && self.Object === Object && self;
	/** Used as a reference to the global object. */

	var root = _freeGlobal || freeSelf || Function('return this')();
	var _root = root;

	/** Built-in value references. */

	var _Symbol2 = _root.Symbol;
	var _Symbol = _Symbol2;

	/** Used for built-in method references. */

	var objectProto = Object.prototype;
	/** Used to check objects for own properties. */

	var hasOwnProperty = objectProto.hasOwnProperty;
	/**
	 * Used to resolve the
	 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
	 * of values.
	 */

	var nativeObjectToString = objectProto.toString;
	/** Built-in value references. */

	var symToStringTag = _Symbol ? _Symbol.toStringTag : undefined;
	/**
	 * A specialized version of `baseGetTag` which ignores `Symbol.toStringTag` values.
	 *
	 * @private
	 * @param {*} value The value to query.
	 * @returns {string} Returns the raw `toStringTag`.
	 */

	function getRawTag(value) {
	  var isOwn = hasOwnProperty.call(value, symToStringTag),
	      tag = value[symToStringTag];

	  try {
	    value[symToStringTag] = undefined;
	  } catch (e) {}

	  var result = nativeObjectToString.call(value);

	  {
	    if (isOwn) {
	      value[symToStringTag] = tag;
	    } else {
	      delete value[symToStringTag];
	    }
	  }

	  return result;
	}

	var _getRawTag = getRawTag;

	/** Used for built-in method references. */
	var objectProto$1 = Object.prototype;
	/**
	 * Used to resolve the
	 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
	 * of values.
	 */

	var nativeObjectToString$1 = objectProto$1.toString;
	/**
	 * Converts `value` to a string using `Object.prototype.toString`.
	 *
	 * @private
	 * @param {*} value The value to convert.
	 * @returns {string} Returns the converted string.
	 */

	function objectToString(value) {
	  return nativeObjectToString$1.call(value);
	}

	var _objectToString = objectToString;

	/** `Object#toString` result references. */

	var nullTag = '[object Null]',
	    undefinedTag = '[object Undefined]';
	/** Built-in value references. */

	var symToStringTag$1 = _Symbol ? _Symbol.toStringTag : undefined;
	/**
	 * The base implementation of `getTag` without fallbacks for buggy environments.
	 *
	 * @private
	 * @param {*} value The value to query.
	 * @returns {string} Returns the `toStringTag`.
	 */

	function baseGetTag(value) {
	  if (value == null) {
	    return value === undefined ? undefinedTag : nullTag;
	  }

	  return symToStringTag$1 && symToStringTag$1 in Object(value) ? _getRawTag(value) : _objectToString(value);
	}

	var _baseGetTag = baseGetTag;

	/**
	 * Checks if `value` is object-like. A value is object-like if it's not `null`
	 * and has a `typeof` result of "object".
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is object-like, else `false`.
	 * @example
	 *
	 * _.isObjectLike({});
	 * // => true
	 *
	 * _.isObjectLike([1, 2, 3]);
	 * // => true
	 *
	 * _.isObjectLike(_.noop);
	 * // => false
	 *
	 * _.isObjectLike(null);
	 * // => false
	 */
	function isObjectLike(value) {
	  return value != null && babelHelpers["typeof"](value) == 'object';
	}

	var isObjectLike_1 = isObjectLike;

	/** `Object#toString` result references. */

	var argsTag = '[object Arguments]';
	/**
	 * The base implementation of `_.isArguments`.
	 *
	 * @private
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is an `arguments` object,
	 */

	function baseIsArguments(value) {
	  return isObjectLike_1(value) && _baseGetTag(value) == argsTag;
	}

	var _baseIsArguments = baseIsArguments;

	/** Used for built-in method references. */

	var objectProto$2 = Object.prototype;
	/** Used to check objects for own properties. */

	var hasOwnProperty$1 = objectProto$2.hasOwnProperty;
	/** Built-in value references. */

	var propertyIsEnumerable = objectProto$2.propertyIsEnumerable;
	/**
	 * Checks if `value` is likely an `arguments` object.
	 *
	 * @static
	 * @memberOf _
	 * @since 0.1.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is an `arguments` object,
	 *  else `false`.
	 * @example
	 *
	 * _.isArguments(function() { return arguments; }());
	 * // => true
	 *
	 * _.isArguments([1, 2, 3]);
	 * // => false
	 */

	var isArguments = _baseIsArguments(function () {
	  return arguments;
	}()) ? _baseIsArguments : function (value) {
	  return isObjectLike_1(value) && hasOwnProperty$1.call(value, 'callee') && !propertyIsEnumerable.call(value, 'callee');
	};
	var isArguments_1 = isArguments;

	/**
	 * Checks if `value` is classified as an `Array` object.
	 *
	 * @static
	 * @memberOf _
	 * @since 0.1.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is an array, else `false`.
	 * @example
	 *
	 * _.isArray([1, 2, 3]);
	 * // => true
	 *
	 * _.isArray(document.body.children);
	 * // => false
	 *
	 * _.isArray('abc');
	 * // => false
	 *
	 * _.isArray(_.noop);
	 * // => false
	 */
	var isArray = Array.isArray;
	var isArray_1 = isArray;

	/**	
	 * This method returns `false`.
	 *
	 * @static
	 * @memberOf _
	 * @since 4.13.0
	 * @category Util
	 * @returns {boolean} Returns `false`.
	 * @example
	 *
	 * _.times(2, _.stubFalse);
	 * // => [false, false]
	 */
	function stubFalse() {
	  return false;
	}

	var stubFalse_1 = stubFalse;

	var isBuffer_1 = createCommonjsModule(function (module, exports) {
	  /** Detect free variable `exports`. */
	  var freeExports = exports && !exports.nodeType && exports;
	  /** Detect free variable `module`. */

	  var freeModule = freeExports && 'object' == 'object' && module && !module.nodeType && module;
	  /** Detect the popular CommonJS extension `module.exports`. */

	  var moduleExports = freeModule && freeModule.exports === freeExports;
	  /** Built-in value references. */

	  var Buffer = moduleExports ? _root.Buffer : undefined;
	  /* Built-in method references for those with the same name as other `lodash` methods. */

	  var nativeIsBuffer = Buffer ? Buffer.isBuffer : undefined;
	  /**
	   * Checks if `value` is a buffer.
	   *
	   * @static
	   * @memberOf _
	   * @since 4.3.0
	   * @category Lang
	   * @param {*} value The value to check.
	   * @returns {boolean} Returns `true` if `value` is a buffer, else `false`.
	   * @example
	   *
	   * _.isBuffer(new Buffer(2));
	   * // => true
	   *
	   * _.isBuffer(new Uint8Array(2));
	   * // => false
	   */

	  var isBuffer = nativeIsBuffer || stubFalse_1;
	  module.exports = isBuffer;
	});

	/** Used as references for various `Number` constants. */
	var MAX_SAFE_INTEGER = 9007199254740991;
	/** Used to detect unsigned integer values. */

	var reIsUint = /^(?:0|[1-9]\d*)$/;
	/**
	 * Checks if `value` is a valid array-like index.
	 *
	 * @private
	 * @param {*} value The value to check.
	 * @param {number} [length=MAX_SAFE_INTEGER] The upper bounds of a valid index.
	 * @returns {boolean} Returns `true` if `value` is a valid index, else `false`.
	 */

	function isIndex(value, length) {
	  var type = babelHelpers["typeof"](value);
	  length = length == null ? MAX_SAFE_INTEGER : length;
	  return !!length && (type == 'number' || type != 'symbol' && reIsUint.test(value)) && value > -1 && value % 1 == 0 && value < length;
	}

	var _isIndex = isIndex;

	/** Used as references for various `Number` constants. */
	var MAX_SAFE_INTEGER$1 = 9007199254740991;
	/**
	 * Checks if `value` is a valid array-like length.
	 *
	 * **Note:** This method is loosely based on
	 * [`ToLength`](http://ecma-international.org/ecma-262/7.0/#sec-tolength).
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is a valid length, else `false`.
	 * @example
	 *
	 * _.isLength(3);
	 * // => true
	 *
	 * _.isLength(Number.MIN_VALUE);
	 * // => false
	 *
	 * _.isLength(Infinity);
	 * // => false
	 *
	 * _.isLength('3');
	 * // => false
	 */

	function isLength(value) {
	  return typeof value == 'number' && value > -1 && value % 1 == 0 && value <= MAX_SAFE_INTEGER$1;
	}

	var isLength_1 = isLength;

	/** `Object#toString` result references. */

	var argsTag$1 = '[object Arguments]',
	    arrayTag = '[object Array]',
	    boolTag = '[object Boolean]',
	    dateTag = '[object Date]',
	    errorTag = '[object Error]',
	    funcTag = '[object Function]',
	    mapTag = '[object Map]',
	    numberTag = '[object Number]',
	    objectTag = '[object Object]',
	    regexpTag = '[object RegExp]',
	    setTag = '[object Set]',
	    stringTag = '[object String]',
	    weakMapTag = '[object WeakMap]';
	var arrayBufferTag = '[object ArrayBuffer]',
	    dataViewTag = '[object DataView]',
	    float32Tag = '[object Float32Array]',
	    float64Tag = '[object Float64Array]',
	    int8Tag = '[object Int8Array]',
	    int16Tag = '[object Int16Array]',
	    int32Tag = '[object Int32Array]',
	    uint8Tag = '[object Uint8Array]',
	    uint8ClampedTag = '[object Uint8ClampedArray]',
	    uint16Tag = '[object Uint16Array]',
	    uint32Tag = '[object Uint32Array]';
	/** Used to identify `toStringTag` values of typed arrays. */

	var typedArrayTags = {};
	typedArrayTags[float32Tag] = typedArrayTags[float64Tag] = typedArrayTags[int8Tag] = typedArrayTags[int16Tag] = typedArrayTags[int32Tag] = typedArrayTags[uint8Tag] = typedArrayTags[uint8ClampedTag] = typedArrayTags[uint16Tag] = typedArrayTags[uint32Tag] = true;
	typedArrayTags[argsTag$1] = typedArrayTags[arrayTag] = typedArrayTags[arrayBufferTag] = typedArrayTags[boolTag] = typedArrayTags[dataViewTag] = typedArrayTags[dateTag] = typedArrayTags[errorTag] = typedArrayTags[funcTag] = typedArrayTags[mapTag] = typedArrayTags[numberTag] = typedArrayTags[objectTag] = typedArrayTags[regexpTag] = typedArrayTags[setTag] = typedArrayTags[stringTag] = typedArrayTags[weakMapTag] = false;
	/**
	 * The base implementation of `_.isTypedArray` without Node.js optimizations.
	 *
	 * @private
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is a typed array, else `false`.
	 */

	function baseIsTypedArray(value) {
	  return isObjectLike_1(value) && isLength_1(value.length) && !!typedArrayTags[_baseGetTag(value)];
	}

	var _baseIsTypedArray = baseIsTypedArray;

	/**
	 * The base implementation of `_.unary` without support for storing metadata.
	 *
	 * @private
	 * @param {Function} func The function to cap arguments for.
	 * @returns {Function} Returns the new capped function.
	 */
	function baseUnary(func) {
	  return function (value) {
	    return func(value);
	  };
	}

	var _baseUnary = baseUnary;

	var _nodeUtil = createCommonjsModule(function (module, exports) {
	  /** Detect free variable `exports`. */
	  var freeExports = exports && !exports.nodeType && exports;
	  /** Detect free variable `module`. */

	  var freeModule = freeExports && 'object' == 'object' && module && !module.nodeType && module;
	  /** Detect the popular CommonJS extension `module.exports`. */

	  var moduleExports = freeModule && freeModule.exports === freeExports;
	  /** Detect free variable `process` from Node.js. */

	  var freeProcess = moduleExports && _freeGlobal.process;
	  /** Used to access faster Node.js helpers. */

	  var nodeUtil = function () {
	    try {
	      // Use `util.types` for Node.js 10+.
	      var types = freeModule && freeModule.require && freeModule.require('util').types;

	      if (types) {
	        return types;
	      } // Legacy `process.binding('util')` for Node.js < 10.


	      return freeProcess && freeProcess.binding && freeProcess.binding('util');
	    } catch (e) {}
	  }();

	  module.exports = nodeUtil;
	});

	/* Node.js helper references. */

	var nodeIsTypedArray = _nodeUtil && _nodeUtil.isTypedArray;
	/**
	 * Checks if `value` is classified as a typed array.
	 *
	 * @static
	 * @memberOf _
	 * @since 3.0.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is a typed array, else `false`.
	 * @example
	 *
	 * _.isTypedArray(new Uint8Array);
	 * // => true
	 *
	 * _.isTypedArray([]);
	 * // => false
	 */

	var isTypedArray = nodeIsTypedArray ? _baseUnary(nodeIsTypedArray) : _baseIsTypedArray;
	var isTypedArray_1 = isTypedArray;

	/** Used for built-in method references. */

	var objectProto$3 = Object.prototype;
	/** Used to check objects for own properties. */

	var hasOwnProperty$2 = objectProto$3.hasOwnProperty;
	/**
	 * Creates an array of the enumerable property names of the array-like `value`.
	 *
	 * @private
	 * @param {*} value The value to query.
	 * @param {boolean} inherited Specify returning inherited property names.
	 * @returns {Array} Returns the array of property names.
	 */

	function arrayLikeKeys(value, inherited) {
	  var isArr = isArray_1(value),
	      isArg = !isArr && isArguments_1(value),
	      isBuff = !isArr && !isArg && isBuffer_1(value),
	      isType = !isArr && !isArg && !isBuff && isTypedArray_1(value),
	      skipIndexes = isArr || isArg || isBuff || isType,
	      result = skipIndexes ? _baseTimes(value.length, String) : [],
	      length = result.length;

	  for (var key in value) {
	    if ((inherited || hasOwnProperty$2.call(value, key)) && !(skipIndexes && ( // Safari 9 has enumerable `arguments.length` in strict mode.
	    key == 'length' || // Node.js 0.10 has enumerable non-index properties on buffers.
	    isBuff && (key == 'offset' || key == 'parent') || // PhantomJS 2 has enumerable non-index properties on typed arrays.
	    isType && (key == 'buffer' || key == 'byteLength' || key == 'byteOffset') || // Skip index properties.
	    _isIndex(key, length)))) {
	      result.push(key);
	    }
	  }

	  return result;
	}

	var _arrayLikeKeys = arrayLikeKeys;

	/** Used for built-in method references. */
	var objectProto$4 = Object.prototype;
	/**
	 * Checks if `value` is likely a prototype object.
	 *
	 * @private
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is a prototype, else `false`.
	 */

	function isPrototype(value) {
	  var Ctor = value && value.constructor,
	      proto = typeof Ctor == 'function' && Ctor.prototype || objectProto$4;
	  return value === proto;
	}

	var _isPrototype = isPrototype;

	/**
	 * Creates a unary function that invokes `func` with its argument transformed.
	 *
	 * @private
	 * @param {Function} func The function to wrap.
	 * @param {Function} transform The argument transform.
	 * @returns {Function} Returns the new function.
	 */
	function overArg(func, transform) {
	  return function (arg) {
	    return func(transform(arg));
	  };
	}

	var _overArg = overArg;

	/* Built-in method references for those with the same name as other `lodash` methods. */

	var nativeKeys = _overArg(Object.keys, Object);
	var _nativeKeys = nativeKeys;

	/** Used for built-in method references. */

	var objectProto$5 = Object.prototype;
	/** Used to check objects for own properties. */

	var hasOwnProperty$3 = objectProto$5.hasOwnProperty;
	/**
	 * The base implementation of `_.keys` which doesn't treat sparse arrays as dense.
	 *
	 * @private
	 * @param {Object} object The object to query.
	 * @returns {Array} Returns the array of property names.
	 */

	function baseKeys(object) {
	  if (!_isPrototype(object)) {
	    return _nativeKeys(object);
	  }

	  var result = [];

	  for (var key in Object(object)) {
	    if (hasOwnProperty$3.call(object, key) && key != 'constructor') {
	      result.push(key);
	    }
	  }

	  return result;
	}

	var _baseKeys = baseKeys;

	/**
	 * Checks if `value` is the
	 * [language type](http://www.ecma-international.org/ecma-262/7.0/#sec-ecmascript-language-types)
	 * of `Object`. (e.g. arrays, functions, objects, regexes, `new Number(0)`, and `new String('')`)
	 *
	 * @static
	 * @memberOf _
	 * @since 0.1.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is an object, else `false`.
	 * @example
	 *
	 * _.isObject({});
	 * // => true
	 *
	 * _.isObject([1, 2, 3]);
	 * // => true
	 *
	 * _.isObject(_.noop);
	 * // => true
	 *
	 * _.isObject(null);
	 * // => false
	 */
	function isObject(value) {
	  var type = babelHelpers["typeof"](value);
	  return value != null && (type == 'object' || type == 'function');
	}

	var isObject_1 = isObject;

	/** `Object#toString` result references. */

	var asyncTag = '[object AsyncFunction]',
	    funcTag$1 = '[object Function]',
	    genTag = '[object GeneratorFunction]',
	    proxyTag = '[object Proxy]';
	/**
	 * Checks if `value` is classified as a `Function` object.
	 *
	 * @static
	 * @memberOf _
	 * @since 0.1.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is a function, else `false`.
	 * @example
	 *
	 * _.isFunction(_);
	 * // => true
	 *
	 * _.isFunction(/abc/);
	 * // => false
	 */

	function isFunction(value) {
	  if (!isObject_1(value)) {
	    return false;
	  } // The use of `Object#toString` avoids issues with the `typeof` operator
	  // in Safari 9 which returns 'object' for typed arrays and other constructors.


	  var tag = _baseGetTag(value);
	  return tag == funcTag$1 || tag == genTag || tag == asyncTag || tag == proxyTag;
	}

	var isFunction_1 = isFunction;

	/**
	 * Checks if `value` is array-like. A value is considered array-like if it's
	 * not a function and has a `value.length` that's an integer greater than or
	 * equal to `0` and less than or equal to `Number.MAX_SAFE_INTEGER`.
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is array-like, else `false`.
	 * @example
	 *
	 * _.isArrayLike([1, 2, 3]);
	 * // => true
	 *
	 * _.isArrayLike(document.body.children);
	 * // => true
	 *
	 * _.isArrayLike('abc');
	 * // => true
	 *
	 * _.isArrayLike(_.noop);
	 * // => false
	 */

	function isArrayLike(value) {
	  return value != null && isLength_1(value.length) && !isFunction_1(value);
	}

	var isArrayLike_1 = isArrayLike;

	/**
	 * Creates an array of the own enumerable property names of `object`.
	 *
	 * **Note:** Non-object values are coerced to objects. See the
	 * [ES spec](http://ecma-international.org/ecma-262/7.0/#sec-object.keys)
	 * for more details.
	 *
	 * @static
	 * @since 0.1.0
	 * @memberOf _
	 * @category Object
	 * @param {Object} object The object to query.
	 * @returns {Array} Returns the array of property names.
	 * @example
	 *
	 * function Foo() {
	 *   this.a = 1;
	 *   this.b = 2;
	 * }
	 *
	 * Foo.prototype.c = 3;
	 *
	 * _.keys(new Foo);
	 * // => ['a', 'b'] (iteration order is not guaranteed)
	 *
	 * _.keys('hi');
	 * // => ['0', '1']
	 */

	function keys(object) {
	  return isArrayLike_1(object) ? _arrayLikeKeys(object) : _baseKeys(object);
	}

	var keys_1 = keys;

	/**
	 * The base implementation of `_.forOwn` without support for iteratee shorthands.
	 *
	 * @private
	 * @param {Object} object The object to iterate over.
	 * @param {Function} iteratee The function invoked per iteration.
	 * @returns {Object} Returns `object`.
	 */

	function baseForOwn(object, iteratee) {
	  return object && _baseFor(object, iteratee, keys_1);
	}

	var _baseForOwn = baseForOwn;

	/**
	 * Removes all key-value entries from the list cache.
	 *
	 * @private
	 * @name clear
	 * @memberOf ListCache
	 */
	function listCacheClear() {
	  this.__data__ = [];
	  this.size = 0;
	}

	var _listCacheClear = listCacheClear;

	/**
	 * Performs a
	 * [`SameValueZero`](http://ecma-international.org/ecma-262/7.0/#sec-samevaluezero)
	 * comparison between two values to determine if they are equivalent.
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to compare.
	 * @param {*} other The other value to compare.
	 * @returns {boolean} Returns `true` if the values are equivalent, else `false`.
	 * @example
	 *
	 * var object = { 'a': 1 };
	 * var other = { 'a': 1 };
	 *
	 * _.eq(object, object);
	 * // => true
	 *
	 * _.eq(object, other);
	 * // => false
	 *
	 * _.eq('a', 'a');
	 * // => true
	 *
	 * _.eq('a', Object('a'));
	 * // => false
	 *
	 * _.eq(NaN, NaN);
	 * // => true
	 */
	function eq(value, other) {
	  return value === other || value !== value && other !== other;
	}

	var eq_1 = eq;

	/**
	 * Gets the index at which the `key` is found in `array` of key-value pairs.
	 *
	 * @private
	 * @param {Array} array The array to inspect.
	 * @param {*} key The key to search for.
	 * @returns {number} Returns the index of the matched value, else `-1`.
	 */

	function assocIndexOf(array, key) {
	  var length = array.length;

	  while (length--) {
	    if (eq_1(array[length][0], key)) {
	      return length;
	    }
	  }

	  return -1;
	}

	var _assocIndexOf = assocIndexOf;

	/** Used for built-in method references. */

	var arrayProto = Array.prototype;
	/** Built-in value references. */

	var splice = arrayProto.splice;
	/**
	 * Removes `key` and its value from the list cache.
	 *
	 * @private
	 * @name delete
	 * @memberOf ListCache
	 * @param {string} key The key of the value to remove.
	 * @returns {boolean} Returns `true` if the entry was removed, else `false`.
	 */

	function listCacheDelete(key) {
	  var data = this.__data__,
	      index = _assocIndexOf(data, key);

	  if (index < 0) {
	    return false;
	  }

	  var lastIndex = data.length - 1;

	  if (index == lastIndex) {
	    data.pop();
	  } else {
	    splice.call(data, index, 1);
	  }

	  --this.size;
	  return true;
	}

	var _listCacheDelete = listCacheDelete;

	/**
	 * Gets the list cache value for `key`.
	 *
	 * @private
	 * @name get
	 * @memberOf ListCache
	 * @param {string} key The key of the value to get.
	 * @returns {*} Returns the entry value.
	 */

	function listCacheGet(key) {
	  var data = this.__data__,
	      index = _assocIndexOf(data, key);
	  return index < 0 ? undefined : data[index][1];
	}

	var _listCacheGet = listCacheGet;

	/**
	 * Checks if a list cache value for `key` exists.
	 *
	 * @private
	 * @name has
	 * @memberOf ListCache
	 * @param {string} key The key of the entry to check.
	 * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
	 */

	function listCacheHas(key) {
	  return _assocIndexOf(this.__data__, key) > -1;
	}

	var _listCacheHas = listCacheHas;

	/**
	 * Sets the list cache `key` to `value`.
	 *
	 * @private
	 * @name set
	 * @memberOf ListCache
	 * @param {string} key The key of the value to set.
	 * @param {*} value The value to set.
	 * @returns {Object} Returns the list cache instance.
	 */

	function listCacheSet(key, value) {
	  var data = this.__data__,
	      index = _assocIndexOf(data, key);

	  if (index < 0) {
	    ++this.size;
	    data.push([key, value]);
	  } else {
	    data[index][1] = value;
	  }

	  return this;
	}

	var _listCacheSet = listCacheSet;

	/**
	 * Creates an list cache object.
	 *
	 * @private
	 * @constructor
	 * @param {Array} [entries] The key-value pairs to cache.
	 */

	function ListCache(entries) {
	  var index = -1,
	      length = entries == null ? 0 : entries.length;
	  this.clear();

	  while (++index < length) {
	    var entry = entries[index];
	    this.set(entry[0], entry[1]);
	  }
	} // Add methods to `ListCache`.


	ListCache.prototype.clear = _listCacheClear;
	ListCache.prototype['delete'] = _listCacheDelete;
	ListCache.prototype.get = _listCacheGet;
	ListCache.prototype.has = _listCacheHas;
	ListCache.prototype.set = _listCacheSet;
	var _ListCache = ListCache;

	/**
	 * Removes all key-value entries from the stack.
	 *
	 * @private
	 * @name clear
	 * @memberOf Stack
	 */

	function stackClear() {
	  this.__data__ = new _ListCache();
	  this.size = 0;
	}

	var _stackClear = stackClear;

	/**
	 * Removes `key` and its value from the stack.
	 *
	 * @private
	 * @name delete
	 * @memberOf Stack
	 * @param {string} key The key of the value to remove.
	 * @returns {boolean} Returns `true` if the entry was removed, else `false`.
	 */
	function stackDelete(key) {
	  var data = this.__data__,
	      result = data['delete'](key);
	  this.size = data.size;
	  return result;
	}

	var _stackDelete = stackDelete;

	/**
	 * Gets the stack value for `key`.
	 *
	 * @private
	 * @name get
	 * @memberOf Stack
	 * @param {string} key The key of the value to get.
	 * @returns {*} Returns the entry value.
	 */
	function stackGet(key) {
	  return this.__data__.get(key);
	}

	var _stackGet = stackGet;

	/**
	 * Checks if a stack value for `key` exists.
	 *
	 * @private
	 * @name has
	 * @memberOf Stack
	 * @param {string} key The key of the entry to check.
	 * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
	 */
	function stackHas(key) {
	  return this.__data__.has(key);
	}

	var _stackHas = stackHas;

	/** Used to detect overreaching core-js shims. */

	var coreJsData = _root['__core-js_shared__'];
	var _coreJsData = coreJsData;

	/** Used to detect methods masquerading as native. */

	var maskSrcKey = function () {
	  var uid = /[^.]+$/.exec(_coreJsData && _coreJsData.keys && _coreJsData.keys.IE_PROTO || '');
	  return uid ? 'Symbol(src)_1.' + uid : '';
	}();
	/**
	 * Checks if `func` has its source masked.
	 *
	 * @private
	 * @param {Function} func The function to check.
	 * @returns {boolean} Returns `true` if `func` is masked, else `false`.
	 */


	function isMasked(func) {
	  return !!maskSrcKey && maskSrcKey in func;
	}

	var _isMasked = isMasked;

	/** Used for built-in method references. */
	var funcProto = Function.prototype;
	/** Used to resolve the decompiled source of functions. */

	var funcToString = funcProto.toString;
	/**
	 * Converts `func` to its source code.
	 *
	 * @private
	 * @param {Function} func The function to convert.
	 * @returns {string} Returns the source code.
	 */

	function toSource(func) {
	  if (func != null) {
	    try {
	      return funcToString.call(func);
	    } catch (e) {}

	    try {
	      return func + '';
	    } catch (e) {}
	  }

	  return '';
	}

	var _toSource = toSource;

	/**
	 * Used to match `RegExp`
	 * [syntax characters](http://ecma-international.org/ecma-262/7.0/#sec-patterns).
	 */

	var reRegExpChar = /[\\^$.*+?()[\]{}|]/g;
	/** Used to detect host constructors (Safari). */

	var reIsHostCtor = /^\[object .+?Constructor\]$/;
	/** Used for built-in method references. */

	var funcProto$1 = Function.prototype,
	    objectProto$6 = Object.prototype;
	/** Used to resolve the decompiled source of functions. */

	var funcToString$1 = funcProto$1.toString;
	/** Used to check objects for own properties. */

	var hasOwnProperty$4 = objectProto$6.hasOwnProperty;
	/** Used to detect if a method is native. */

	var reIsNative = RegExp('^' + funcToString$1.call(hasOwnProperty$4).replace(reRegExpChar, '\\$&').replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g, '$1.*?') + '$');
	/**
	 * The base implementation of `_.isNative` without bad shim checks.
	 *
	 * @private
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is a native function,
	 *  else `false`.
	 */

	function baseIsNative(value) {
	  if (!isObject_1(value) || _isMasked(value)) {
	    return false;
	  }

	  var pattern = isFunction_1(value) ? reIsNative : reIsHostCtor;
	  return pattern.test(_toSource(value));
	}

	var _baseIsNative = baseIsNative;

	/**
	 * Gets the value at `key` of `object`.
	 *
	 * @private
	 * @param {Object} [object] The object to query.
	 * @param {string} key The key of the property to get.
	 * @returns {*} Returns the property value.
	 */
	function getValue(object, key) {
	  return object == null ? undefined : object[key];
	}

	var _getValue = getValue;

	/**
	 * Gets the native function at `key` of `object`.
	 *
	 * @private
	 * @param {Object} object The object to query.
	 * @param {string} key The key of the method to get.
	 * @returns {*} Returns the function if it's native, else `undefined`.
	 */

	function getNative(object, key) {
	  var value = _getValue(object, key);
	  return _baseIsNative(value) ? value : undefined;
	}

	var _getNative = getNative;

	/* Built-in method references that are verified to be native. */

	var Map = _getNative(_root, 'Map');
	var _Map = Map;

	/* Built-in method references that are verified to be native. */

	var nativeCreate = _getNative(Object, 'create');
	var _nativeCreate = nativeCreate;

	/**
	 * Removes all key-value entries from the hash.
	 *
	 * @private
	 * @name clear
	 * @memberOf Hash
	 */

	function hashClear() {
	  this.__data__ = _nativeCreate ? _nativeCreate(null) : {};
	  this.size = 0;
	}

	var _hashClear = hashClear;

	/**
	 * Removes `key` and its value from the hash.
	 *
	 * @private
	 * @name delete
	 * @memberOf Hash
	 * @param {Object} hash The hash to modify.
	 * @param {string} key The key of the value to remove.
	 * @returns {boolean} Returns `true` if the entry was removed, else `false`.
	 */
	function hashDelete(key) {
	  var result = this.has(key) && delete this.__data__[key];
	  this.size -= result ? 1 : 0;
	  return result;
	}

	var _hashDelete = hashDelete;

	/** Used to stand-in for `undefined` hash values. */

	var HASH_UNDEFINED = '__lodash_hash_undefined__';
	/** Used for built-in method references. */

	var objectProto$7 = Object.prototype;
	/** Used to check objects for own properties. */

	var hasOwnProperty$5 = objectProto$7.hasOwnProperty;
	/**
	 * Gets the hash value for `key`.
	 *
	 * @private
	 * @name get
	 * @memberOf Hash
	 * @param {string} key The key of the value to get.
	 * @returns {*} Returns the entry value.
	 */

	function hashGet(key) {
	  var data = this.__data__;

	  if (_nativeCreate) {
	    var result = data[key];
	    return result === HASH_UNDEFINED ? undefined : result;
	  }

	  return hasOwnProperty$5.call(data, key) ? data[key] : undefined;
	}

	var _hashGet = hashGet;

	/** Used for built-in method references. */

	var objectProto$8 = Object.prototype;
	/** Used to check objects for own properties. */

	var hasOwnProperty$6 = objectProto$8.hasOwnProperty;
	/**
	 * Checks if a hash value for `key` exists.
	 *
	 * @private
	 * @name has
	 * @memberOf Hash
	 * @param {string} key The key of the entry to check.
	 * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
	 */

	function hashHas(key) {
	  var data = this.__data__;
	  return _nativeCreate ? data[key] !== undefined : hasOwnProperty$6.call(data, key);
	}

	var _hashHas = hashHas;

	/** Used to stand-in for `undefined` hash values. */

	var HASH_UNDEFINED$1 = '__lodash_hash_undefined__';
	/**
	 * Sets the hash `key` to `value`.
	 *
	 * @private
	 * @name set
	 * @memberOf Hash
	 * @param {string} key The key of the value to set.
	 * @param {*} value The value to set.
	 * @returns {Object} Returns the hash instance.
	 */

	function hashSet(key, value) {
	  var data = this.__data__;
	  this.size += this.has(key) ? 0 : 1;
	  data[key] = _nativeCreate && value === undefined ? HASH_UNDEFINED$1 : value;
	  return this;
	}

	var _hashSet = hashSet;

	/**
	 * Creates a hash object.
	 *
	 * @private
	 * @constructor
	 * @param {Array} [entries] The key-value pairs to cache.
	 */

	function Hash(entries) {
	  var index = -1,
	      length = entries == null ? 0 : entries.length;
	  this.clear();

	  while (++index < length) {
	    var entry = entries[index];
	    this.set(entry[0], entry[1]);
	  }
	} // Add methods to `Hash`.


	Hash.prototype.clear = _hashClear;
	Hash.prototype['delete'] = _hashDelete;
	Hash.prototype.get = _hashGet;
	Hash.prototype.has = _hashHas;
	Hash.prototype.set = _hashSet;
	var _Hash = Hash;

	/**
	 * Removes all key-value entries from the map.
	 *
	 * @private
	 * @name clear
	 * @memberOf MapCache
	 */

	function mapCacheClear() {
	  this.size = 0;
	  this.__data__ = {
	    'hash': new _Hash(),
	    'map': new (_Map || _ListCache)(),
	    'string': new _Hash()
	  };
	}

	var _mapCacheClear = mapCacheClear;

	/**
	 * Checks if `value` is suitable for use as unique object key.
	 *
	 * @private
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is suitable, else `false`.
	 */
	function isKeyable(value) {
	  var type = babelHelpers["typeof"](value);
	  return type == 'string' || type == 'number' || type == 'symbol' || type == 'boolean' ? value !== '__proto__' : value === null;
	}

	var _isKeyable = isKeyable;

	/**
	 * Gets the data for `map`.
	 *
	 * @private
	 * @param {Object} map The map to query.
	 * @param {string} key The reference key.
	 * @returns {*} Returns the map data.
	 */

	function getMapData(map, key) {
	  var data = map.__data__;
	  return _isKeyable(key) ? data[typeof key == 'string' ? 'string' : 'hash'] : data.map;
	}

	var _getMapData = getMapData;

	/**
	 * Removes `key` and its value from the map.
	 *
	 * @private
	 * @name delete
	 * @memberOf MapCache
	 * @param {string} key The key of the value to remove.
	 * @returns {boolean} Returns `true` if the entry was removed, else `false`.
	 */

	function mapCacheDelete(key) {
	  var result = _getMapData(this, key)['delete'](key);
	  this.size -= result ? 1 : 0;
	  return result;
	}

	var _mapCacheDelete = mapCacheDelete;

	/**
	 * Gets the map value for `key`.
	 *
	 * @private
	 * @name get
	 * @memberOf MapCache
	 * @param {string} key The key of the value to get.
	 * @returns {*} Returns the entry value.
	 */

	function mapCacheGet(key) {
	  return _getMapData(this, key).get(key);
	}

	var _mapCacheGet = mapCacheGet;

	/**
	 * Checks if a map value for `key` exists.
	 *
	 * @private
	 * @name has
	 * @memberOf MapCache
	 * @param {string} key The key of the entry to check.
	 * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
	 */

	function mapCacheHas(key) {
	  return _getMapData(this, key).has(key);
	}

	var _mapCacheHas = mapCacheHas;

	/**
	 * Sets the map `key` to `value`.
	 *
	 * @private
	 * @name set
	 * @memberOf MapCache
	 * @param {string} key The key of the value to set.
	 * @param {*} value The value to set.
	 * @returns {Object} Returns the map cache instance.
	 */

	function mapCacheSet(key, value) {
	  var data = _getMapData(this, key),
	      size = data.size;
	  data.set(key, value);
	  this.size += data.size == size ? 0 : 1;
	  return this;
	}

	var _mapCacheSet = mapCacheSet;

	/**
	 * Creates a map cache object to store key-value pairs.
	 *
	 * @private
	 * @constructor
	 * @param {Array} [entries] The key-value pairs to cache.
	 */

	function MapCache(entries) {
	  var index = -1,
	      length = entries == null ? 0 : entries.length;
	  this.clear();

	  while (++index < length) {
	    var entry = entries[index];
	    this.set(entry[0], entry[1]);
	  }
	} // Add methods to `MapCache`.


	MapCache.prototype.clear = _mapCacheClear;
	MapCache.prototype['delete'] = _mapCacheDelete;
	MapCache.prototype.get = _mapCacheGet;
	MapCache.prototype.has = _mapCacheHas;
	MapCache.prototype.set = _mapCacheSet;
	var _MapCache = MapCache;

	/** Used as the size to enable large array optimizations. */

	var LARGE_ARRAY_SIZE = 200;
	/**
	 * Sets the stack `key` to `value`.
	 *
	 * @private
	 * @name set
	 * @memberOf Stack
	 * @param {string} key The key of the value to set.
	 * @param {*} value The value to set.
	 * @returns {Object} Returns the stack cache instance.
	 */

	function stackSet(key, value) {
	  var data = this.__data__;

	  if (data instanceof _ListCache) {
	    var pairs = data.__data__;

	    if (!_Map || pairs.length < LARGE_ARRAY_SIZE - 1) {
	      pairs.push([key, value]);
	      this.size = ++data.size;
	      return this;
	    }

	    data = this.__data__ = new _MapCache(pairs);
	  }

	  data.set(key, value);
	  this.size = data.size;
	  return this;
	}

	var _stackSet = stackSet;

	/**
	 * Creates a stack cache object to store key-value pairs.
	 *
	 * @private
	 * @constructor
	 * @param {Array} [entries] The key-value pairs to cache.
	 */

	function Stack(entries) {
	  var data = this.__data__ = new _ListCache(entries);
	  this.size = data.size;
	} // Add methods to `Stack`.


	Stack.prototype.clear = _stackClear;
	Stack.prototype['delete'] = _stackDelete;
	Stack.prototype.get = _stackGet;
	Stack.prototype.has = _stackHas;
	Stack.prototype.set = _stackSet;
	var _Stack = Stack;

	/** Used to stand-in for `undefined` hash values. */
	var HASH_UNDEFINED$2 = '__lodash_hash_undefined__';
	/**
	 * Adds `value` to the array cache.
	 *
	 * @private
	 * @name add
	 * @memberOf SetCache
	 * @alias push
	 * @param {*} value The value to cache.
	 * @returns {Object} Returns the cache instance.
	 */

	function setCacheAdd(value) {
	  this.__data__.set(value, HASH_UNDEFINED$2);

	  return this;
	}

	var _setCacheAdd = setCacheAdd;

	/**
	 * Checks if `value` is in the array cache.
	 *
	 * @private
	 * @name has
	 * @memberOf SetCache
	 * @param {*} value The value to search for.
	 * @returns {number} Returns `true` if `value` is found, else `false`.
	 */
	function setCacheHas(value) {
	  return this.__data__.has(value);
	}

	var _setCacheHas = setCacheHas;

	/**
	 *
	 * Creates an array cache object to store unique values.
	 *
	 * @private
	 * @constructor
	 * @param {Array} [values] The values to cache.
	 */

	function SetCache(values) {
	  var index = -1,
	      length = values == null ? 0 : values.length;
	  this.__data__ = new _MapCache();

	  while (++index < length) {
	    this.add(values[index]);
	  }
	} // Add methods to `SetCache`.


	SetCache.prototype.add = SetCache.prototype.push = _setCacheAdd;
	SetCache.prototype.has = _setCacheHas;
	var _SetCache = SetCache;

	/**
	 * A specialized version of `_.some` for arrays without support for iteratee
	 * shorthands.
	 *
	 * @private
	 * @param {Array} [array] The array to iterate over.
	 * @param {Function} predicate The function invoked per iteration.
	 * @returns {boolean} Returns `true` if any element passes the predicate check,
	 *  else `false`.
	 */
	function arraySome(array, predicate) {
	  var index = -1,
	      length = array == null ? 0 : array.length;

	  while (++index < length) {
	    if (predicate(array[index], index, array)) {
	      return true;
	    }
	  }

	  return false;
	}

	var _arraySome = arraySome;

	/**
	 * Checks if a `cache` value for `key` exists.
	 *
	 * @private
	 * @param {Object} cache The cache to query.
	 * @param {string} key The key of the entry to check.
	 * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
	 */
	function cacheHas(cache, key) {
	  return cache.has(key);
	}

	var _cacheHas = cacheHas;

	/** Used to compose bitmasks for value comparisons. */

	var COMPARE_PARTIAL_FLAG = 1,
	    COMPARE_UNORDERED_FLAG = 2;
	/**
	 * A specialized version of `baseIsEqualDeep` for arrays with support for
	 * partial deep comparisons.
	 *
	 * @private
	 * @param {Array} array The array to compare.
	 * @param {Array} other The other array to compare.
	 * @param {number} bitmask The bitmask flags. See `baseIsEqual` for more details.
	 * @param {Function} customizer The function to customize comparisons.
	 * @param {Function} equalFunc The function to determine equivalents of values.
	 * @param {Object} stack Tracks traversed `array` and `other` objects.
	 * @returns {boolean} Returns `true` if the arrays are equivalent, else `false`.
	 */

	function equalArrays(array, other, bitmask, customizer, equalFunc, stack) {
	  var isPartial = bitmask & COMPARE_PARTIAL_FLAG,
	      arrLength = array.length,
	      othLength = other.length;

	  if (arrLength != othLength && !(isPartial && othLength > arrLength)) {
	    return false;
	  } // Check that cyclic values are equal.


	  var arrStacked = stack.get(array);
	  var othStacked = stack.get(other);

	  if (arrStacked && othStacked) {
	    return arrStacked == other && othStacked == array;
	  }

	  var index = -1,
	      result = true,
	      seen = bitmask & COMPARE_UNORDERED_FLAG ? new _SetCache() : undefined;
	  stack.set(array, other);
	  stack.set(other, array); // Ignore non-index properties.

	  while (++index < arrLength) {
	    var arrValue = array[index],
	        othValue = other[index];

	    if (customizer) {
	      var compared = isPartial ? customizer(othValue, arrValue, index, other, array, stack) : customizer(arrValue, othValue, index, array, other, stack);
	    }

	    if (compared !== undefined) {
	      if (compared) {
	        continue;
	      }

	      result = false;
	      break;
	    } // Recursively compare arrays (susceptible to call stack limits).


	    if (seen) {
	      if (!_arraySome(other, function (othValue, othIndex) {
	        if (!_cacheHas(seen, othIndex) && (arrValue === othValue || equalFunc(arrValue, othValue, bitmask, customizer, stack))) {
	          return seen.push(othIndex);
	        }
	      })) {
	        result = false;
	        break;
	      }
	    } else if (!(arrValue === othValue || equalFunc(arrValue, othValue, bitmask, customizer, stack))) {
	      result = false;
	      break;
	    }
	  }

	  stack['delete'](array);
	  stack['delete'](other);
	  return result;
	}

	var _equalArrays = equalArrays;

	/** Built-in value references. */

	var Uint8Array = _root.Uint8Array;
	var _Uint8Array = Uint8Array;

	/**
	 * Converts `map` to its key-value pairs.
	 *
	 * @private
	 * @param {Object} map The map to convert.
	 * @returns {Array} Returns the key-value pairs.
	 */
	function mapToArray(map) {
	  var index = -1,
	      result = Array(map.size);
	  map.forEach(function (value, key) {
	    result[++index] = [key, value];
	  });
	  return result;
	}

	var _mapToArray = mapToArray;

	/**
	 * Converts `set` to an array of its values.
	 *
	 * @private
	 * @param {Object} set The set to convert.
	 * @returns {Array} Returns the values.
	 */
	function setToArray(set) {
	  var index = -1,
	      result = Array(set.size);
	  set.forEach(function (value) {
	    result[++index] = value;
	  });
	  return result;
	}

	var _setToArray = setToArray;

	/** Used to compose bitmasks for value comparisons. */

	var COMPARE_PARTIAL_FLAG$1 = 1,
	    COMPARE_UNORDERED_FLAG$1 = 2;
	/** `Object#toString` result references. */

	var boolTag$1 = '[object Boolean]',
	    dateTag$1 = '[object Date]',
	    errorTag$1 = '[object Error]',
	    mapTag$1 = '[object Map]',
	    numberTag$1 = '[object Number]',
	    regexpTag$1 = '[object RegExp]',
	    setTag$1 = '[object Set]',
	    stringTag$1 = '[object String]',
	    symbolTag = '[object Symbol]';
	var arrayBufferTag$1 = '[object ArrayBuffer]',
	    dataViewTag$1 = '[object DataView]';
	/** Used to convert symbols to primitives and strings. */

	var symbolProto = _Symbol ? _Symbol.prototype : undefined,
	    symbolValueOf = symbolProto ? symbolProto.valueOf : undefined;
	/**
	 * A specialized version of `baseIsEqualDeep` for comparing objects of
	 * the same `toStringTag`.
	 *
	 * **Note:** This function only supports comparing values with tags of
	 * `Boolean`, `Date`, `Error`, `Number`, `RegExp`, or `String`.
	 *
	 * @private
	 * @param {Object} object The object to compare.
	 * @param {Object} other The other object to compare.
	 * @param {string} tag The `toStringTag` of the objects to compare.
	 * @param {number} bitmask The bitmask flags. See `baseIsEqual` for more details.
	 * @param {Function} customizer The function to customize comparisons.
	 * @param {Function} equalFunc The function to determine equivalents of values.
	 * @param {Object} stack Tracks traversed `object` and `other` objects.
	 * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
	 */

	function equalByTag(object, other, tag, bitmask, customizer, equalFunc, stack) {
	  switch (tag) {
	    case dataViewTag$1:
	      if (object.byteLength != other.byteLength || object.byteOffset != other.byteOffset) {
	        return false;
	      }

	      object = object.buffer;
	      other = other.buffer;

	    case arrayBufferTag$1:
	      if (object.byteLength != other.byteLength || !equalFunc(new _Uint8Array(object), new _Uint8Array(other))) {
	        return false;
	      }

	      return true;

	    case boolTag$1:
	    case dateTag$1:
	    case numberTag$1:
	      // Coerce booleans to `1` or `0` and dates to milliseconds.
	      // Invalid dates are coerced to `NaN`.
	      return eq_1(+object, +other);

	    case errorTag$1:
	      return object.name == other.name && object.message == other.message;

	    case regexpTag$1:
	    case stringTag$1:
	      // Coerce regexes to strings and treat strings, primitives and objects,
	      // as equal. See http://www.ecma-international.org/ecma-262/7.0/#sec-regexp.prototype.tostring
	      // for more details.
	      return object == other + '';

	    case mapTag$1:
	      var convert = _mapToArray;

	    case setTag$1:
	      var isPartial = bitmask & COMPARE_PARTIAL_FLAG$1;
	      convert || (convert = _setToArray);

	      if (object.size != other.size && !isPartial) {
	        return false;
	      } // Assume cyclic values are equal.


	      var stacked = stack.get(object);

	      if (stacked) {
	        return stacked == other;
	      }

	      bitmask |= COMPARE_UNORDERED_FLAG$1; // Recursively compare objects (susceptible to call stack limits).

	      stack.set(object, other);
	      var result = _equalArrays(convert(object), convert(other), bitmask, customizer, equalFunc, stack);
	      stack['delete'](object);
	      return result;

	    case symbolTag:
	      if (symbolValueOf) {
	        return symbolValueOf.call(object) == symbolValueOf.call(other);
	      }

	  }

	  return false;
	}

	var _equalByTag = equalByTag;

	/**
	 * Appends the elements of `values` to `array`.
	 *
	 * @private
	 * @param {Array} array The array to modify.
	 * @param {Array} values The values to append.
	 * @returns {Array} Returns `array`.
	 */
	function arrayPush(array, values) {
	  var index = -1,
	      length = values.length,
	      offset = array.length;

	  while (++index < length) {
	    array[offset + index] = values[index];
	  }

	  return array;
	}

	var _arrayPush = arrayPush;

	/**
	 * The base implementation of `getAllKeys` and `getAllKeysIn` which uses
	 * `keysFunc` and `symbolsFunc` to get the enumerable property names and
	 * symbols of `object`.
	 *
	 * @private
	 * @param {Object} object The object to query.
	 * @param {Function} keysFunc The function to get the keys of `object`.
	 * @param {Function} symbolsFunc The function to get the symbols of `object`.
	 * @returns {Array} Returns the array of property names and symbols.
	 */

	function baseGetAllKeys(object, keysFunc, symbolsFunc) {
	  var result = keysFunc(object);
	  return isArray_1(object) ? result : _arrayPush(result, symbolsFunc(object));
	}

	var _baseGetAllKeys = baseGetAllKeys;

	/**
	 * A specialized version of `_.filter` for arrays without support for
	 * iteratee shorthands.
	 *
	 * @private
	 * @param {Array} [array] The array to iterate over.
	 * @param {Function} predicate The function invoked per iteration.
	 * @returns {Array} Returns the new filtered array.
	 */
	function arrayFilter(array, predicate) {
	  var index = -1,
	      length = array == null ? 0 : array.length,
	      resIndex = 0,
	      result = [];

	  while (++index < length) {
	    var value = array[index];

	    if (predicate(value, index, array)) {
	      result[resIndex++] = value;
	    }
	  }

	  return result;
	}

	var _arrayFilter = arrayFilter;

	/**
	 * This method returns a new empty array.
	 *
	 * @static
	 * @memberOf _
	 * @since 4.13.0
	 * @category Util
	 * @returns {Array} Returns the new empty array.
	 * @example
	 *
	 * var arrays = _.times(2, _.stubArray);
	 *
	 * console.log(arrays);
	 * // => [[], []]
	 *
	 * console.log(arrays[0] === arrays[1]);
	 * // => false
	 */
	function stubArray() {
	  return [];
	}

	var stubArray_1 = stubArray;

	/** Used for built-in method references. */

	var objectProto$9 = Object.prototype;
	/** Built-in value references. */

	var propertyIsEnumerable$1 = objectProto$9.propertyIsEnumerable;
	/* Built-in method references for those with the same name as other `lodash` methods. */

	var nativeGetSymbols = Object.getOwnPropertySymbols;
	/**
	 * Creates an array of the own enumerable symbols of `object`.
	 *
	 * @private
	 * @param {Object} object The object to query.
	 * @returns {Array} Returns the array of symbols.
	 */

	var getSymbols = !nativeGetSymbols ? stubArray_1 : function (object) {
	  if (object == null) {
	    return [];
	  }

	  object = Object(object);
	  return _arrayFilter(nativeGetSymbols(object), function (symbol) {
	    return propertyIsEnumerable$1.call(object, symbol);
	  });
	};
	var _getSymbols = getSymbols;

	/**
	 * Creates an array of own enumerable property names and symbols of `object`.
	 *
	 * @private
	 * @param {Object} object The object to query.
	 * @returns {Array} Returns the array of property names and symbols.
	 */

	function getAllKeys(object) {
	  return _baseGetAllKeys(object, keys_1, _getSymbols);
	}

	var _getAllKeys = getAllKeys;

	/** Used to compose bitmasks for value comparisons. */

	var COMPARE_PARTIAL_FLAG$2 = 1;
	/** Used for built-in method references. */

	var objectProto$a = Object.prototype;
	/** Used to check objects for own properties. */

	var hasOwnProperty$7 = objectProto$a.hasOwnProperty;
	/**
	 * A specialized version of `baseIsEqualDeep` for objects with support for
	 * partial deep comparisons.
	 *
	 * @private
	 * @param {Object} object The object to compare.
	 * @param {Object} other The other object to compare.
	 * @param {number} bitmask The bitmask flags. See `baseIsEqual` for more details.
	 * @param {Function} customizer The function to customize comparisons.
	 * @param {Function} equalFunc The function to determine equivalents of values.
	 * @param {Object} stack Tracks traversed `object` and `other` objects.
	 * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
	 */

	function equalObjects(object, other, bitmask, customizer, equalFunc, stack) {
	  var isPartial = bitmask & COMPARE_PARTIAL_FLAG$2,
	      objProps = _getAllKeys(object),
	      objLength = objProps.length,
	      othProps = _getAllKeys(other),
	      othLength = othProps.length;

	  if (objLength != othLength && !isPartial) {
	    return false;
	  }

	  var index = objLength;

	  while (index--) {
	    var key = objProps[index];

	    if (!(isPartial ? key in other : hasOwnProperty$7.call(other, key))) {
	      return false;
	    }
	  } // Check that cyclic values are equal.


	  var objStacked = stack.get(object);
	  var othStacked = stack.get(other);

	  if (objStacked && othStacked) {
	    return objStacked == other && othStacked == object;
	  }

	  var result = true;
	  stack.set(object, other);
	  stack.set(other, object);
	  var skipCtor = isPartial;

	  while (++index < objLength) {
	    key = objProps[index];
	    var objValue = object[key],
	        othValue = other[key];

	    if (customizer) {
	      var compared = isPartial ? customizer(othValue, objValue, key, other, object, stack) : customizer(objValue, othValue, key, object, other, stack);
	    } // Recursively compare objects (susceptible to call stack limits).


	    if (!(compared === undefined ? objValue === othValue || equalFunc(objValue, othValue, bitmask, customizer, stack) : compared)) {
	      result = false;
	      break;
	    }

	    skipCtor || (skipCtor = key == 'constructor');
	  }

	  if (result && !skipCtor) {
	    var objCtor = object.constructor,
	        othCtor = other.constructor; // Non `Object` object instances with different constructors are not equal.

	    if (objCtor != othCtor && 'constructor' in object && 'constructor' in other && !(typeof objCtor == 'function' && objCtor instanceof objCtor && typeof othCtor == 'function' && othCtor instanceof othCtor)) {
	      result = false;
	    }
	  }

	  stack['delete'](object);
	  stack['delete'](other);
	  return result;
	}

	var _equalObjects = equalObjects;

	/* Built-in method references that are verified to be native. */

	var DataView = _getNative(_root, 'DataView');
	var _DataView = DataView;

	/* Built-in method references that are verified to be native. */

	var Promise$1 = _getNative(_root, 'Promise');
	var _Promise = Promise$1;

	/* Built-in method references that are verified to be native. */

	var Set$1 = _getNative(_root, 'Set');
	var _Set = Set$1;

	/* Built-in method references that are verified to be native. */

	var WeakMap = _getNative(_root, 'WeakMap');
	var _WeakMap = WeakMap;

	/** `Object#toString` result references. */

	var mapTag$2 = '[object Map]',
	    objectTag$1 = '[object Object]',
	    promiseTag = '[object Promise]',
	    setTag$2 = '[object Set]',
	    weakMapTag$1 = '[object WeakMap]';
	var dataViewTag$2 = '[object DataView]';
	/** Used to detect maps, sets, and weakmaps. */

	var dataViewCtorString = _toSource(_DataView),
	    mapCtorString = _toSource(_Map),
	    promiseCtorString = _toSource(_Promise),
	    setCtorString = _toSource(_Set),
	    weakMapCtorString = _toSource(_WeakMap);
	/**
	 * Gets the `toStringTag` of `value`.
	 *
	 * @private
	 * @param {*} value The value to query.
	 * @returns {string} Returns the `toStringTag`.
	 */

	var getTag = _baseGetTag; // Fallback for data views, maps, sets, and weak maps in IE 11 and promises in Node.js < 6.

	if (_DataView && getTag(new _DataView(new ArrayBuffer(1))) != dataViewTag$2 || _Map && getTag(new _Map()) != mapTag$2 || _Promise && getTag(_Promise.resolve()) != promiseTag || _Set && getTag(new _Set()) != setTag$2 || _WeakMap && getTag(new _WeakMap()) != weakMapTag$1) {
	  getTag = function getTag(value) {
	    var result = _baseGetTag(value),
	        Ctor = result == objectTag$1 ? value.constructor : undefined,
	        ctorString = Ctor ? _toSource(Ctor) : '';

	    if (ctorString) {
	      switch (ctorString) {
	        case dataViewCtorString:
	          return dataViewTag$2;

	        case mapCtorString:
	          return mapTag$2;

	        case promiseCtorString:
	          return promiseTag;

	        case setCtorString:
	          return setTag$2;

	        case weakMapCtorString:
	          return weakMapTag$1;
	      }
	    }

	    return result;
	  };
	}

	var _getTag = getTag;

	/** Used to compose bitmasks for value comparisons. */

	var COMPARE_PARTIAL_FLAG$3 = 1;
	/** `Object#toString` result references. */

	var argsTag$2 = '[object Arguments]',
	    arrayTag$1 = '[object Array]',
	    objectTag$2 = '[object Object]';
	/** Used for built-in method references. */

	var objectProto$b = Object.prototype;
	/** Used to check objects for own properties. */

	var hasOwnProperty$8 = objectProto$b.hasOwnProperty;
	/**
	 * A specialized version of `baseIsEqual` for arrays and objects which performs
	 * deep comparisons and tracks traversed objects enabling objects with circular
	 * references to be compared.
	 *
	 * @private
	 * @param {Object} object The object to compare.
	 * @param {Object} other The other object to compare.
	 * @param {number} bitmask The bitmask flags. See `baseIsEqual` for more details.
	 * @param {Function} customizer The function to customize comparisons.
	 * @param {Function} equalFunc The function to determine equivalents of values.
	 * @param {Object} [stack] Tracks traversed `object` and `other` objects.
	 * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
	 */

	function baseIsEqualDeep(object, other, bitmask, customizer, equalFunc, stack) {
	  var objIsArr = isArray_1(object),
	      othIsArr = isArray_1(other),
	      objTag = objIsArr ? arrayTag$1 : _getTag(object),
	      othTag = othIsArr ? arrayTag$1 : _getTag(other);
	  objTag = objTag == argsTag$2 ? objectTag$2 : objTag;
	  othTag = othTag == argsTag$2 ? objectTag$2 : othTag;
	  var objIsObj = objTag == objectTag$2,
	      othIsObj = othTag == objectTag$2,
	      isSameTag = objTag == othTag;

	  if (isSameTag && isBuffer_1(object)) {
	    if (!isBuffer_1(other)) {
	      return false;
	    }

	    objIsArr = true;
	    objIsObj = false;
	  }

	  if (isSameTag && !objIsObj) {
	    stack || (stack = new _Stack());
	    return objIsArr || isTypedArray_1(object) ? _equalArrays(object, other, bitmask, customizer, equalFunc, stack) : _equalByTag(object, other, objTag, bitmask, customizer, equalFunc, stack);
	  }

	  if (!(bitmask & COMPARE_PARTIAL_FLAG$3)) {
	    var objIsWrapped = objIsObj && hasOwnProperty$8.call(object, '__wrapped__'),
	        othIsWrapped = othIsObj && hasOwnProperty$8.call(other, '__wrapped__');

	    if (objIsWrapped || othIsWrapped) {
	      var objUnwrapped = objIsWrapped ? object.value() : object,
	          othUnwrapped = othIsWrapped ? other.value() : other;
	      stack || (stack = new _Stack());
	      return equalFunc(objUnwrapped, othUnwrapped, bitmask, customizer, stack);
	    }
	  }

	  if (!isSameTag) {
	    return false;
	  }

	  stack || (stack = new _Stack());
	  return _equalObjects(object, other, bitmask, customizer, equalFunc, stack);
	}

	var _baseIsEqualDeep = baseIsEqualDeep;

	/**
	 * The base implementation of `_.isEqual` which supports partial comparisons
	 * and tracks traversed objects.
	 *
	 * @private
	 * @param {*} value The value to compare.
	 * @param {*} other The other value to compare.
	 * @param {boolean} bitmask The bitmask flags.
	 *  1 - Unordered comparison
	 *  2 - Partial comparison
	 * @param {Function} [customizer] The function to customize comparisons.
	 * @param {Object} [stack] Tracks traversed `value` and `other` objects.
	 * @returns {boolean} Returns `true` if the values are equivalent, else `false`.
	 */

	function baseIsEqual(value, other, bitmask, customizer, stack) {
	  if (value === other) {
	    return true;
	  }

	  if (value == null || other == null || !isObjectLike_1(value) && !isObjectLike_1(other)) {
	    return value !== value && other !== other;
	  }

	  return _baseIsEqualDeep(value, other, bitmask, customizer, baseIsEqual, stack);
	}

	var _baseIsEqual = baseIsEqual;

	/** Used to compose bitmasks for value comparisons. */

	var COMPARE_PARTIAL_FLAG$4 = 1,
	    COMPARE_UNORDERED_FLAG$2 = 2;
	/**
	 * The base implementation of `_.isMatch` without support for iteratee shorthands.
	 *
	 * @private
	 * @param {Object} object The object to inspect.
	 * @param {Object} source The object of property values to match.
	 * @param {Array} matchData The property names, values, and compare flags to match.
	 * @param {Function} [customizer] The function to customize comparisons.
	 * @returns {boolean} Returns `true` if `object` is a match, else `false`.
	 */

	function baseIsMatch(object, source, matchData, customizer) {
	  var index = matchData.length,
	      length = index,
	      noCustomizer = !customizer;

	  if (object == null) {
	    return !length;
	  }

	  object = Object(object);

	  while (index--) {
	    var data = matchData[index];

	    if (noCustomizer && data[2] ? data[1] !== object[data[0]] : !(data[0] in object)) {
	      return false;
	    }
	  }

	  while (++index < length) {
	    data = matchData[index];
	    var key = data[0],
	        objValue = object[key],
	        srcValue = data[1];

	    if (noCustomizer && data[2]) {
	      if (objValue === undefined && !(key in object)) {
	        return false;
	      }
	    } else {
	      var stack = new _Stack();

	      if (customizer) {
	        var result = customizer(objValue, srcValue, key, object, source, stack);
	      }

	      if (!(result === undefined ? _baseIsEqual(srcValue, objValue, COMPARE_PARTIAL_FLAG$4 | COMPARE_UNORDERED_FLAG$2, customizer, stack) : result)) {
	        return false;
	      }
	    }
	  }

	  return true;
	}

	var _baseIsMatch = baseIsMatch;

	/**
	 * Checks if `value` is suitable for strict equality comparisons, i.e. `===`.
	 *
	 * @private
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` if suitable for strict
	 *  equality comparisons, else `false`.
	 */

	function isStrictComparable(value) {
	  return value === value && !isObject_1(value);
	}

	var _isStrictComparable = isStrictComparable;

	/**
	 * Gets the property names, values, and compare flags of `object`.
	 *
	 * @private
	 * @param {Object} object The object to query.
	 * @returns {Array} Returns the match data of `object`.
	 */

	function getMatchData(object) {
	  var result = keys_1(object),
	      length = result.length;

	  while (length--) {
	    var key = result[length],
	        value = object[key];
	    result[length] = [key, value, _isStrictComparable(value)];
	  }

	  return result;
	}

	var _getMatchData = getMatchData;

	/**
	 * A specialized version of `matchesProperty` for source values suitable
	 * for strict equality comparisons, i.e. `===`.
	 *
	 * @private
	 * @param {string} key The key of the property to get.
	 * @param {*} srcValue The value to match.
	 * @returns {Function} Returns the new spec function.
	 */
	function matchesStrictComparable(key, srcValue) {
	  return function (object) {
	    if (object == null) {
	      return false;
	    }

	    return object[key] === srcValue && (srcValue !== undefined || key in Object(object));
	  };
	}

	var _matchesStrictComparable = matchesStrictComparable;

	/**
	 * The base implementation of `_.matches` which doesn't clone `source`.
	 *
	 * @private
	 * @param {Object} source The object of property values to match.
	 * @returns {Function} Returns the new spec function.
	 */

	function baseMatches(source) {
	  var matchData = _getMatchData(source);

	  if (matchData.length == 1 && matchData[0][2]) {
	    return _matchesStrictComparable(matchData[0][0], matchData[0][1]);
	  }

	  return function (object) {
	    return object === source || _baseIsMatch(object, source, matchData);
	  };
	}

	var _baseMatches = baseMatches;

	/** `Object#toString` result references. */

	var symbolTag$1 = '[object Symbol]';
	/**
	 * Checks if `value` is classified as a `Symbol` primitive or object.
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is a symbol, else `false`.
	 * @example
	 *
	 * _.isSymbol(Symbol.iterator);
	 * // => true
	 *
	 * _.isSymbol('abc');
	 * // => false
	 */

	function isSymbol(value) {
	  return babelHelpers["typeof"](value) == 'symbol' || isObjectLike_1(value) && _baseGetTag(value) == symbolTag$1;
	}

	var isSymbol_1 = isSymbol;

	/** Used to match property names within property paths. */

	var reIsDeepProp = /\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,
	    reIsPlainProp = /^\w*$/;
	/**
	 * Checks if `value` is a property name and not a property path.
	 *
	 * @private
	 * @param {*} value The value to check.
	 * @param {Object} [object] The object to query keys on.
	 * @returns {boolean} Returns `true` if `value` is a property name, else `false`.
	 */

	function isKey(value, object) {
	  if (isArray_1(value)) {
	    return false;
	  }

	  var type = babelHelpers["typeof"](value);

	  if (type == 'number' || type == 'symbol' || type == 'boolean' || value == null || isSymbol_1(value)) {
	    return true;
	  }

	  return reIsPlainProp.test(value) || !reIsDeepProp.test(value) || object != null && value in Object(object);
	}

	var _isKey = isKey;

	/** Error message constants. */

	var FUNC_ERROR_TEXT = 'Expected a function';
	/**
	 * Creates a function that memoizes the result of `func`. If `resolver` is
	 * provided, it determines the cache key for storing the result based on the
	 * arguments provided to the memoized function. By default, the first argument
	 * provided to the memoized function is used as the map cache key. The `func`
	 * is invoked with the `this` binding of the memoized function.
	 *
	 * **Note:** The cache is exposed as the `cache` property on the memoized
	 * function. Its creation may be customized by replacing the `_.memoize.Cache`
	 * constructor with one whose instances implement the
	 * [`Map`](http://ecma-international.org/ecma-262/7.0/#sec-properties-of-the-map-prototype-object)
	 * method interface of `clear`, `delete`, `get`, `has`, and `set`.
	 *
	 * @static
	 * @memberOf _
	 * @since 0.1.0
	 * @category Function
	 * @param {Function} func The function to have its output memoized.
	 * @param {Function} [resolver] The function to resolve the cache key.
	 * @returns {Function} Returns the new memoized function.
	 * @example
	 *
	 * var object = { 'a': 1, 'b': 2 };
	 * var other = { 'c': 3, 'd': 4 };
	 *
	 * var values = _.memoize(_.values);
	 * values(object);
	 * // => [1, 2]
	 *
	 * values(other);
	 * // => [3, 4]
	 *
	 * object.a = 2;
	 * values(object);
	 * // => [1, 2]
	 *
	 * // Modify the result cache.
	 * values.cache.set(object, ['a', 'b']);
	 * values(object);
	 * // => ['a', 'b']
	 *
	 * // Replace `_.memoize.Cache`.
	 * _.memoize.Cache = WeakMap;
	 */

	function memoize(func, resolver) {
	  if (typeof func != 'function' || resolver != null && typeof resolver != 'function') {
	    throw new TypeError(FUNC_ERROR_TEXT);
	  }

	  var memoized = function memoized() {
	    var args = arguments,
	        key = resolver ? resolver.apply(this, args) : args[0],
	        cache = memoized.cache;

	    if (cache.has(key)) {
	      return cache.get(key);
	    }

	    var result = func.apply(this, args);
	    memoized.cache = cache.set(key, result) || cache;
	    return result;
	  };

	  memoized.cache = new (memoize.Cache || _MapCache)();
	  return memoized;
	} // Expose `MapCache`.


	memoize.Cache = _MapCache;
	var memoize_1 = memoize;

	/** Used as the maximum memoize cache size. */

	var MAX_MEMOIZE_SIZE = 500;
	/**
	 * A specialized version of `_.memoize` which clears the memoized function's
	 * cache when it exceeds `MAX_MEMOIZE_SIZE`.
	 *
	 * @private
	 * @param {Function} func The function to have its output memoized.
	 * @returns {Function} Returns the new memoized function.
	 */

	function memoizeCapped(func) {
	  var result = memoize_1(func, function (key) {
	    if (cache.size === MAX_MEMOIZE_SIZE) {
	      cache.clear();
	    }

	    return key;
	  });
	  var cache = result.cache;
	  return result;
	}

	var _memoizeCapped = memoizeCapped;

	/** Used to match property names within property paths. */

	var rePropName = /[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g;
	/** Used to match backslashes in property paths. */

	var reEscapeChar = /\\(\\)?/g;
	/**
	 * Converts `string` to a property path array.
	 *
	 * @private
	 * @param {string} string The string to convert.
	 * @returns {Array} Returns the property path array.
	 */

	var stringToPath = _memoizeCapped(function (string) {
	  var result = [];

	  if (string.charCodeAt(0) === 46
	  /* . */
	  ) {
	    result.push('');
	  }

	  string.replace(rePropName, function (match, number, quote, subString) {
	    result.push(quote ? subString.replace(reEscapeChar, '$1') : number || match);
	  });
	  return result;
	});
	var _stringToPath = stringToPath;

	/**
	 * A specialized version of `_.map` for arrays without support for iteratee
	 * shorthands.
	 *
	 * @private
	 * @param {Array} [array] The array to iterate over.
	 * @param {Function} iteratee The function invoked per iteration.
	 * @returns {Array} Returns the new mapped array.
	 */
	function arrayMap(array, iteratee) {
	  var index = -1,
	      length = array == null ? 0 : array.length,
	      result = Array(length);

	  while (++index < length) {
	    result[index] = iteratee(array[index], index, array);
	  }

	  return result;
	}

	var _arrayMap = arrayMap;

	/** Used as references for various `Number` constants. */

	var INFINITY = 1 / 0;
	/** Used to convert symbols to primitives and strings. */

	var symbolProto$1 = _Symbol ? _Symbol.prototype : undefined,
	    symbolToString = symbolProto$1 ? symbolProto$1.toString : undefined;
	/**
	 * The base implementation of `_.toString` which doesn't convert nullish
	 * values to empty strings.
	 *
	 * @private
	 * @param {*} value The value to process.
	 * @returns {string} Returns the string.
	 */

	function baseToString(value) {
	  // Exit early for strings to avoid a performance hit in some environments.
	  if (typeof value == 'string') {
	    return value;
	  }

	  if (isArray_1(value)) {
	    // Recursively convert values (susceptible to call stack limits).
	    return _arrayMap(value, baseToString) + '';
	  }

	  if (isSymbol_1(value)) {
	    return symbolToString ? symbolToString.call(value) : '';
	  }

	  var result = value + '';
	  return result == '0' && 1 / value == -INFINITY ? '-0' : result;
	}

	var _baseToString = baseToString;

	/**
	 * Converts `value` to a string. An empty string is returned for `null`
	 * and `undefined` values. The sign of `-0` is preserved.
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to convert.
	 * @returns {string} Returns the converted string.
	 * @example
	 *
	 * _.toString(null);
	 * // => ''
	 *
	 * _.toString(-0);
	 * // => '-0'
	 *
	 * _.toString([1, 2, 3]);
	 * // => '1,2,3'
	 */

	function toString(value) {
	  return value == null ? '' : _baseToString(value);
	}

	var toString_1 = toString;

	/**
	 * Casts `value` to a path array if it's not one.
	 *
	 * @private
	 * @param {*} value The value to inspect.
	 * @param {Object} [object] The object to query keys on.
	 * @returns {Array} Returns the cast property path array.
	 */

	function castPath(value, object) {
	  if (isArray_1(value)) {
	    return value;
	  }

	  return _isKey(value, object) ? [value] : _stringToPath(toString_1(value));
	}

	var _castPath = castPath;

	/** Used as references for various `Number` constants. */

	var INFINITY$1 = 1 / 0;
	/**
	 * Converts `value` to a string key if it's not a string or symbol.
	 *
	 * @private
	 * @param {*} value The value to inspect.
	 * @returns {string|symbol} Returns the key.
	 */

	function toKey(value) {
	  if (typeof value == 'string' || isSymbol_1(value)) {
	    return value;
	  }

	  var result = value + '';
	  return result == '0' && 1 / value == -INFINITY$1 ? '-0' : result;
	}

	var _toKey = toKey;

	/**
	 * The base implementation of `_.get` without support for default values.
	 *
	 * @private
	 * @param {Object} object The object to query.
	 * @param {Array|string} path The path of the property to get.
	 * @returns {*} Returns the resolved value.
	 */

	function baseGet(object, path) {
	  path = _castPath(path, object);
	  var index = 0,
	      length = path.length;

	  while (object != null && index < length) {
	    object = object[_toKey(path[index++])];
	  }

	  return index && index == length ? object : undefined;
	}

	var _baseGet = baseGet;

	/**
	 * Gets the value at `path` of `object`. If the resolved value is
	 * `undefined`, the `defaultValue` is returned in its place.
	 *
	 * @static
	 * @memberOf _
	 * @since 3.7.0
	 * @category Object
	 * @param {Object} object The object to query.
	 * @param {Array|string} path The path of the property to get.
	 * @param {*} [defaultValue] The value returned for `undefined` resolved values.
	 * @returns {*} Returns the resolved value.
	 * @example
	 *
	 * var object = { 'a': [{ 'b': { 'c': 3 } }] };
	 *
	 * _.get(object, 'a[0].b.c');
	 * // => 3
	 *
	 * _.get(object, ['a', '0', 'b', 'c']);
	 * // => 3
	 *
	 * _.get(object, 'a.b.c', 'default');
	 * // => 'default'
	 */

	function get(object, path, defaultValue) {
	  var result = object == null ? undefined : _baseGet(object, path);
	  return result === undefined ? defaultValue : result;
	}

	var get_1 = get;

	/**
	 * The base implementation of `_.hasIn` without support for deep paths.
	 *
	 * @private
	 * @param {Object} [object] The object to query.
	 * @param {Array|string} key The key to check.
	 * @returns {boolean} Returns `true` if `key` exists, else `false`.
	 */
	function baseHasIn(object, key) {
	  return object != null && key in Object(object);
	}

	var _baseHasIn = baseHasIn;

	/**
	 * Checks if `path` exists on `object`.
	 *
	 * @private
	 * @param {Object} object The object to query.
	 * @param {Array|string} path The path to check.
	 * @param {Function} hasFunc The function to check properties.
	 * @returns {boolean} Returns `true` if `path` exists, else `false`.
	 */

	function hasPath(object, path, hasFunc) {
	  path = _castPath(path, object);
	  var index = -1,
	      length = path.length,
	      result = false;

	  while (++index < length) {
	    var key = _toKey(path[index]);

	    if (!(result = object != null && hasFunc(object, key))) {
	      break;
	    }

	    object = object[key];
	  }

	  if (result || ++index != length) {
	    return result;
	  }

	  length = object == null ? 0 : object.length;
	  return !!length && isLength_1(length) && _isIndex(key, length) && (isArray_1(object) || isArguments_1(object));
	}

	var _hasPath = hasPath;

	/**
	 * Checks if `path` is a direct or inherited property of `object`.
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Object
	 * @param {Object} object The object to query.
	 * @param {Array|string} path The path to check.
	 * @returns {boolean} Returns `true` if `path` exists, else `false`.
	 * @example
	 *
	 * var object = _.create({ 'a': _.create({ 'b': 2 }) });
	 *
	 * _.hasIn(object, 'a');
	 * // => true
	 *
	 * _.hasIn(object, 'a.b');
	 * // => true
	 *
	 * _.hasIn(object, ['a', 'b']);
	 * // => true
	 *
	 * _.hasIn(object, 'b');
	 * // => false
	 */

	function hasIn(object, path) {
	  return object != null && _hasPath(object, path, _baseHasIn);
	}

	var hasIn_1 = hasIn;

	/** Used to compose bitmasks for value comparisons. */

	var COMPARE_PARTIAL_FLAG$5 = 1,
	    COMPARE_UNORDERED_FLAG$3 = 2;
	/**
	 * The base implementation of `_.matchesProperty` which doesn't clone `srcValue`.
	 *
	 * @private
	 * @param {string} path The path of the property to get.
	 * @param {*} srcValue The value to match.
	 * @returns {Function} Returns the new spec function.
	 */

	function baseMatchesProperty(path, srcValue) {
	  if (_isKey(path) && _isStrictComparable(srcValue)) {
	    return _matchesStrictComparable(_toKey(path), srcValue);
	  }

	  return function (object) {
	    var objValue = get_1(object, path);
	    return objValue === undefined && objValue === srcValue ? hasIn_1(object, path) : _baseIsEqual(srcValue, objValue, COMPARE_PARTIAL_FLAG$5 | COMPARE_UNORDERED_FLAG$3);
	  };
	}

	var _baseMatchesProperty = baseMatchesProperty;

	/**
	 * This method returns the first argument it receives.
	 *
	 * @static
	 * @since 0.1.0
	 * @memberOf _
	 * @category Util
	 * @param {*} value Any value.
	 * @returns {*} Returns `value`.
	 * @example
	 *
	 * var object = { 'a': 1 };
	 *
	 * console.log(_.identity(object) === object);
	 * // => true
	 */
	function identity(value) {
	  return value;
	}

	var identity_1 = identity;

	/**
	 * The base implementation of `_.property` without support for deep paths.
	 *
	 * @private
	 * @param {string} key The key of the property to get.
	 * @returns {Function} Returns the new accessor function.
	 */
	function baseProperty(key) {
	  return function (object) {
	    return object == null ? undefined : object[key];
	  };
	}

	var _baseProperty = baseProperty;

	/**
	 * A specialized version of `baseProperty` which supports deep paths.
	 *
	 * @private
	 * @param {Array|string} path The path of the property to get.
	 * @returns {Function} Returns the new accessor function.
	 */

	function basePropertyDeep(path) {
	  return function (object) {
	    return _baseGet(object, path);
	  };
	}

	var _basePropertyDeep = basePropertyDeep;

	/**
	 * Creates a function that returns the value at `path` of a given object.
	 *
	 * @static
	 * @memberOf _
	 * @since 2.4.0
	 * @category Util
	 * @param {Array|string} path The path of the property to get.
	 * @returns {Function} Returns the new accessor function.
	 * @example
	 *
	 * var objects = [
	 *   { 'a': { 'b': 2 } },
	 *   { 'a': { 'b': 1 } }
	 * ];
	 *
	 * _.map(objects, _.property('a.b'));
	 * // => [2, 1]
	 *
	 * _.map(_.sortBy(objects, _.property(['a', 'b'])), 'a.b');
	 * // => [1, 2]
	 */

	function property(path) {
	  return _isKey(path) ? _baseProperty(_toKey(path)) : _basePropertyDeep(path);
	}

	var property_1 = property;

	/**
	 * The base implementation of `_.iteratee`.
	 *
	 * @private
	 * @param {*} [value=_.identity] The value to convert to an iteratee.
	 * @returns {Function} Returns the iteratee.
	 */

	function baseIteratee(value) {
	  // Don't store the `typeof` result in a variable to avoid a JIT bug in Safari 9.
	  // See https://bugs.webkit.org/show_bug.cgi?id=156034 for more details.
	  if (typeof value == 'function') {
	    return value;
	  }

	  if (value == null) {
	    return identity_1;
	  }

	  if (babelHelpers["typeof"](value) == 'object') {
	    return isArray_1(value) ? _baseMatchesProperty(value[0], value[1]) : _baseMatches(value);
	  }

	  return property_1(value);
	}

	var _baseIteratee = baseIteratee;

	/**
	 * This method is like `_.find` except that it returns the key of the first
	 * element `predicate` returns truthy for instead of the element itself.
	 *
	 * @static
	 * @memberOf _
	 * @since 1.1.0
	 * @category Object
	 * @param {Object} object The object to inspect.
	 * @param {Function} [predicate=_.identity] The function invoked per iteration.
	 * @returns {string|undefined} Returns the key of the matched element,
	 *  else `undefined`.
	 * @example
	 *
	 * var users = {
	 *   'barney':  { 'age': 36, 'active': true },
	 *   'fred':    { 'age': 40, 'active': false },
	 *   'pebbles': { 'age': 1,  'active': true }
	 * };
	 *
	 * _.findKey(users, function(o) { return o.age < 40; });
	 * // => 'barney' (iteration order is not guaranteed)
	 *
	 * // The `_.matches` iteratee shorthand.
	 * _.findKey(users, { 'age': 1, 'active': true });
	 * // => 'pebbles'
	 *
	 * // The `_.matchesProperty` iteratee shorthand.
	 * _.findKey(users, ['active', false]);
	 * // => 'fred'
	 *
	 * // The `_.property` iteratee shorthand.
	 * _.findKey(users, 'active');
	 * // => 'barney'
	 */

	function findKey(object, predicate) {
	  return _baseFindKey(object, _baseIteratee(predicate, 3), _baseForOwn);
	}

	var findKey_1 = findKey;

	/**
	 * The base implementation of `_.findIndex` and `_.findLastIndex` without
	 * support for iteratee shorthands.
	 *
	 * @private
	 * @param {Array} array The array to inspect.
	 * @param {Function} predicate The function invoked per iteration.
	 * @param {number} fromIndex The index to search from.
	 * @param {boolean} [fromRight] Specify iterating from right to left.
	 * @returns {number} Returns the index of the matched value, else `-1`.
	 */
	function baseFindIndex(array, predicate, fromIndex, fromRight) {
	  var length = array.length,
	      index = fromIndex + (fromRight ? 1 : -1);

	  while (fromRight ? index-- : ++index < length) {
	    if (predicate(array[index], index, array)) {
	      return index;
	    }
	  }

	  return -1;
	}

	var _baseFindIndex = baseFindIndex;

	/** Used to match a single whitespace character. */
	var reWhitespace = /\s/;
	/**
	 * Used by `_.trim` and `_.trimEnd` to get the index of the last non-whitespace
	 * character of `string`.
	 *
	 * @private
	 * @param {string} string The string to inspect.
	 * @returns {number} Returns the index of the last non-whitespace character.
	 */

	function trimmedEndIndex(string) {
	  var index = string.length;

	  while (index-- && reWhitespace.test(string.charAt(index))) {}

	  return index;
	}

	var _trimmedEndIndex = trimmedEndIndex;

	/** Used to match leading whitespace. */

	var reTrimStart = /^\s+/;
	/**
	 * The base implementation of `_.trim`.
	 *
	 * @private
	 * @param {string} string The string to trim.
	 * @returns {string} Returns the trimmed string.
	 */

	function baseTrim(string) {
	  return string ? string.slice(0, _trimmedEndIndex(string) + 1).replace(reTrimStart, '') : string;
	}

	var _baseTrim = baseTrim;

	/** Used as references for various `Number` constants. */

	var NAN = 0 / 0;
	/** Used to detect bad signed hexadecimal string values. */

	var reIsBadHex = /^[-+]0x[0-9a-f]+$/i;
	/** Used to detect binary string values. */

	var reIsBinary = /^0b[01]+$/i;
	/** Used to detect octal string values. */

	var reIsOctal = /^0o[0-7]+$/i;
	/** Built-in method references without a dependency on `root`. */

	var freeParseInt = parseInt;
	/**
	 * Converts `value` to a number.
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to process.
	 * @returns {number} Returns the number.
	 * @example
	 *
	 * _.toNumber(3.2);
	 * // => 3.2
	 *
	 * _.toNumber(Number.MIN_VALUE);
	 * // => 5e-324
	 *
	 * _.toNumber(Infinity);
	 * // => Infinity
	 *
	 * _.toNumber('3.2');
	 * // => 3.2
	 */

	function toNumber(value) {
	  if (typeof value == 'number') {
	    return value;
	  }

	  if (isSymbol_1(value)) {
	    return NAN;
	  }

	  if (isObject_1(value)) {
	    var other = typeof value.valueOf == 'function' ? value.valueOf() : value;
	    value = isObject_1(other) ? other + '' : other;
	  }

	  if (typeof value != 'string') {
	    return value === 0 ? value : +value;
	  }

	  value = _baseTrim(value);
	  var isBinary = reIsBinary.test(value);
	  return isBinary || reIsOctal.test(value) ? freeParseInt(value.slice(2), isBinary ? 2 : 8) : reIsBadHex.test(value) ? NAN : +value;
	}

	var toNumber_1 = toNumber;

	/** Used as references for various `Number` constants. */

	var INFINITY$2 = 1 / 0,
	    MAX_INTEGER = 1.7976931348623157e+308;
	/**
	 * Converts `value` to a finite number.
	 *
	 * @static
	 * @memberOf _
	 * @since 4.12.0
	 * @category Lang
	 * @param {*} value The value to convert.
	 * @returns {number} Returns the converted number.
	 * @example
	 *
	 * _.toFinite(3.2);
	 * // => 3.2
	 *
	 * _.toFinite(Number.MIN_VALUE);
	 * // => 5e-324
	 *
	 * _.toFinite(Infinity);
	 * // => 1.7976931348623157e+308
	 *
	 * _.toFinite('3.2');
	 * // => 3.2
	 */

	function toFinite(value) {
	  if (!value) {
	    return value === 0 ? value : 0;
	  }

	  value = toNumber_1(value);

	  if (value === INFINITY$2 || value === -INFINITY$2) {
	    var sign = value < 0 ? -1 : 1;
	    return sign * MAX_INTEGER;
	  }

	  return value === value ? value : 0;
	}

	var toFinite_1 = toFinite;

	/**
	 * Converts `value` to an integer.
	 *
	 * **Note:** This method is loosely based on
	 * [`ToInteger`](http://www.ecma-international.org/ecma-262/7.0/#sec-tointeger).
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to convert.
	 * @returns {number} Returns the converted integer.
	 * @example
	 *
	 * _.toInteger(3.2);
	 * // => 3
	 *
	 * _.toInteger(Number.MIN_VALUE);
	 * // => 0
	 *
	 * _.toInteger(Infinity);
	 * // => 1.7976931348623157e+308
	 *
	 * _.toInteger('3.2');
	 * // => 3
	 */

	function toInteger(value) {
	  var result = toFinite_1(value),
	      remainder = result % 1;
	  return result === result ? remainder ? result - remainder : result : 0;
	}

	var toInteger_1 = toInteger;

	/* Built-in method references for those with the same name as other `lodash` methods. */

	var nativeMax = Math.max;
	/**
	 * This method is like `_.find` except that it returns the index of the first
	 * element `predicate` returns truthy for instead of the element itself.
	 *
	 * @static
	 * @memberOf _
	 * @since 1.1.0
	 * @category Array
	 * @param {Array} array The array to inspect.
	 * @param {Function} [predicate=_.identity] The function invoked per iteration.
	 * @param {number} [fromIndex=0] The index to search from.
	 * @returns {number} Returns the index of the found element, else `-1`.
	 * @example
	 *
	 * var users = [
	 *   { 'user': 'barney',  'active': false },
	 *   { 'user': 'fred',    'active': false },
	 *   { 'user': 'pebbles', 'active': true }
	 * ];
	 *
	 * _.findIndex(users, function(o) { return o.user == 'barney'; });
	 * // => 0
	 *
	 * // The `_.matches` iteratee shorthand.
	 * _.findIndex(users, { 'user': 'fred', 'active': false });
	 * // => 1
	 *
	 * // The `_.matchesProperty` iteratee shorthand.
	 * _.findIndex(users, ['active', false]);
	 * // => 0
	 *
	 * // The `_.property` iteratee shorthand.
	 * _.findIndex(users, 'active');
	 * // => 2
	 */

	function findIndex(array, predicate, fromIndex) {
	  var length = array == null ? 0 : array.length;

	  if (!length) {
	    return -1;
	  }

	  var index = fromIndex == null ? 0 : toInteger_1(fromIndex);

	  if (index < 0) {
	    index = nativeMax(length + index, 0);
	  }

	  return _baseFindIndex(array, _baseIteratee(predicate, 3), index);
	}

	var findIndex_1 = findIndex;

	/**
	 * Performs a partial deep comparison between `object` and `source` to
	 * determine if `object` contains equivalent property values.
	 *
	 * **Note:** This method is equivalent to `_.matches` when `source` is
	 * partially applied.
	 *
	 * Partial comparisons will match empty array and empty object `source`
	 * values against any array or object value, respectively. See `_.isEqual`
	 * for a list of supported value comparisons.
	 *
	 * @static
	 * @memberOf _
	 * @since 3.0.0
	 * @category Lang
	 * @param {Object} object The object to inspect.
	 * @param {Object} source The object of property values to match.
	 * @returns {boolean} Returns `true` if `object` is a match, else `false`.
	 * @example
	 *
	 * var object = { 'a': 1, 'b': 2 };
	 *
	 * _.isMatch(object, { 'b': 2 });
	 * // => true
	 *
	 * _.isMatch(object, { 'b': 1 });
	 * // => false
	 */

	function isMatch(object, source) {
	  return object === source || _baseIsMatch(object, source, _getMatchData(source));
	}

	var isMatch_1 = isMatch;

	/**
	 * A specialized version of `_.reduce` for arrays without support for
	 * iteratee shorthands.
	 *
	 * @private
	 * @param {Array} [array] The array to iterate over.
	 * @param {Function} iteratee The function invoked per iteration.
	 * @param {*} [accumulator] The initial value.
	 * @param {boolean} [initAccum] Specify using the first element of `array` as
	 *  the initial value.
	 * @returns {*} Returns the accumulated value.
	 */
	function arrayReduce(array, iteratee, accumulator, initAccum) {
	  var index = -1,
	      length = array == null ? 0 : array.length;

	  if (initAccum && length) {
	    accumulator = array[++index];
	  }

	  while (++index < length) {
	    accumulator = iteratee(accumulator, array[index], index, array);
	  }

	  return accumulator;
	}

	var _arrayReduce = arrayReduce;

	/**
	 * Creates a `baseEach` or `baseEachRight` function.
	 *
	 * @private
	 * @param {Function} eachFunc The function to iterate over a collection.
	 * @param {boolean} [fromRight] Specify iterating from right to left.
	 * @returns {Function} Returns the new base function.
	 */

	function createBaseEach(eachFunc, fromRight) {
	  return function (collection, iteratee) {
	    if (collection == null) {
	      return collection;
	    }

	    if (!isArrayLike_1(collection)) {
	      return eachFunc(collection, iteratee);
	    }

	    var length = collection.length,
	        index = fromRight ? length : -1,
	        iterable = Object(collection);

	    while (fromRight ? index-- : ++index < length) {
	      if (iteratee(iterable[index], index, iterable) === false) {
	        break;
	      }
	    }

	    return collection;
	  };
	}

	var _createBaseEach = createBaseEach;

	/**
	 * The base implementation of `_.forEach` without support for iteratee shorthands.
	 *
	 * @private
	 * @param {Array|Object} collection The collection to iterate over.
	 * @param {Function} iteratee The function invoked per iteration.
	 * @returns {Array|Object} Returns `collection`.
	 */

	var baseEach = _createBaseEach(_baseForOwn);
	var _baseEach = baseEach;

	/**
	 * The base implementation of `_.reduce` and `_.reduceRight`, without support
	 * for iteratee shorthands, which iterates over `collection` using `eachFunc`.
	 *
	 * @private
	 * @param {Array|Object} collection The collection to iterate over.
	 * @param {Function} iteratee The function invoked per iteration.
	 * @param {*} accumulator The initial value.
	 * @param {boolean} initAccum Specify using the first or last element of
	 *  `collection` as the initial value.
	 * @param {Function} eachFunc The function to iterate over `collection`.
	 * @returns {*} Returns the accumulated value.
	 */
	function baseReduce(collection, iteratee, accumulator, initAccum, eachFunc) {
	  eachFunc(collection, function (value, index, collection) {
	    accumulator = initAccum ? (initAccum = false, value) : iteratee(accumulator, value, index, collection);
	  });
	  return accumulator;
	}

	var _baseReduce = baseReduce;

	/**
	 * Reduces `collection` to a value which is the accumulated result of running
	 * each element in `collection` thru `iteratee`, where each successive
	 * invocation is supplied the return value of the previous. If `accumulator`
	 * is not given, the first element of `collection` is used as the initial
	 * value. The iteratee is invoked with four arguments:
	 * (accumulator, value, index|key, collection).
	 *
	 * Many lodash methods are guarded to work as iteratees for methods like
	 * `_.reduce`, `_.reduceRight`, and `_.transform`.
	 *
	 * The guarded methods are:
	 * `assign`, `defaults`, `defaultsDeep`, `includes`, `merge`, `orderBy`,
	 * and `sortBy`
	 *
	 * @static
	 * @memberOf _
	 * @since 0.1.0
	 * @category Collection
	 * @param {Array|Object} collection The collection to iterate over.
	 * @param {Function} [iteratee=_.identity] The function invoked per iteration.
	 * @param {*} [accumulator] The initial value.
	 * @returns {*} Returns the accumulated value.
	 * @see _.reduceRight
	 * @example
	 *
	 * _.reduce([1, 2], function(sum, n) {
	 *   return sum + n;
	 * }, 0);
	 * // => 3
	 *
	 * _.reduce({ 'a': 1, 'b': 2, 'c': 1 }, function(result, value, key) {
	 *   (result[value] || (result[value] = [])).push(key);
	 *   return result;
	 * }, {});
	 * // => { '1': ['a', 'c'], '2': ['b'] } (iteration order is not guaranteed)
	 */

	function reduce(collection, iteratee, accumulator) {
	  var func = isArray_1(collection) ? _arrayReduce : _baseReduce,
	      initAccum = arguments.length < 3;
	  return func(collection, _baseIteratee(iteratee, 4), accumulator, initAccum, _baseEach);
	}

	var reduce_1 = reduce;

	/**
	 * The base implementation of `_.map` without support for iteratee shorthands.
	 *
	 * @private
	 * @param {Array|Object} collection The collection to iterate over.
	 * @param {Function} iteratee The function invoked per iteration.
	 * @returns {Array} Returns the new mapped array.
	 */

	function baseMap(collection, iteratee) {
	  var index = -1,
	      result = isArrayLike_1(collection) ? Array(collection.length) : [];
	  _baseEach(collection, function (value, key, collection) {
	    result[++index] = iteratee(value, key, collection);
	  });
	  return result;
	}

	var _baseMap = baseMap;

	/**
	 * Creates an array of values by running each element in `collection` thru
	 * `iteratee`. The iteratee is invoked with three arguments:
	 * (value, index|key, collection).
	 *
	 * Many lodash methods are guarded to work as iteratees for methods like
	 * `_.every`, `_.filter`, `_.map`, `_.mapValues`, `_.reject`, and `_.some`.
	 *
	 * The guarded methods are:
	 * `ary`, `chunk`, `curry`, `curryRight`, `drop`, `dropRight`, `every`,
	 * `fill`, `invert`, `parseInt`, `random`, `range`, `rangeRight`, `repeat`,
	 * `sampleSize`, `slice`, `some`, `sortBy`, `split`, `take`, `takeRight`,
	 * `template`, `trim`, `trimEnd`, `trimStart`, and `words`
	 *
	 * @static
	 * @memberOf _
	 * @since 0.1.0
	 * @category Collection
	 * @param {Array|Object} collection The collection to iterate over.
	 * @param {Function} [iteratee=_.identity] The function invoked per iteration.
	 * @returns {Array} Returns the new mapped array.
	 * @example
	 *
	 * function square(n) {
	 *   return n * n;
	 * }
	 *
	 * _.map([4, 8], square);
	 * // => [16, 64]
	 *
	 * _.map({ 'a': 4, 'b': 8 }, square);
	 * // => [16, 64] (iteration order is not guaranteed)
	 *
	 * var users = [
	 *   { 'user': 'barney' },
	 *   { 'user': 'fred' }
	 * ];
	 *
	 * // The `_.property` iteratee shorthand.
	 * _.map(users, 'user');
	 * // => ['barney', 'fred']
	 */

	function map(collection, iteratee) {
	  var func = isArray_1(collection) ? _arrayMap : _baseMap;
	  return func(collection, _baseIteratee(iteratee, 3));
	}

	var map_1 = map;

	/** Built-in value references. */

	var spreadableSymbol = _Symbol ? _Symbol.isConcatSpreadable : undefined;
	/**
	 * Checks if `value` is a flattenable `arguments` object or array.
	 *
	 * @private
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is flattenable, else `false`.
	 */

	function isFlattenable(value) {
	  return isArray_1(value) || isArguments_1(value) || !!(spreadableSymbol && value && value[spreadableSymbol]);
	}

	var _isFlattenable = isFlattenable;

	/**
	 * The base implementation of `_.flatten` with support for restricting flattening.
	 *
	 * @private
	 * @param {Array} array The array to flatten.
	 * @param {number} depth The maximum recursion depth.
	 * @param {boolean} [predicate=isFlattenable] The function invoked per iteration.
	 * @param {boolean} [isStrict] Restrict to values that pass `predicate` checks.
	 * @param {Array} [result=[]] The initial result value.
	 * @returns {Array} Returns the new flattened array.
	 */

	function baseFlatten(array, depth, predicate, isStrict, result) {
	  var index = -1,
	      length = array.length;
	  predicate || (predicate = _isFlattenable);
	  result || (result = []);

	  while (++index < length) {
	    var value = array[index];

	    if (depth > 0 && predicate(value)) {
	      if (depth > 1) {
	        // Recursively flatten arrays (susceptible to call stack limits).
	        baseFlatten(value, depth - 1, predicate, isStrict, result);
	      } else {
	        _arrayPush(result, value);
	      }
	    } else if (!isStrict) {
	      result[result.length] = value;
	    }
	  }

	  return result;
	}

	var _baseFlatten = baseFlatten;

	/**
	 * Creates a flattened array of values by running each element in `collection`
	 * thru `iteratee` and flattening the mapped results. The iteratee is invoked
	 * with three arguments: (value, index|key, collection).
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Collection
	 * @param {Array|Object} collection The collection to iterate over.
	 * @param {Function} [iteratee=_.identity] The function invoked per iteration.
	 * @returns {Array} Returns the new flattened array.
	 * @example
	 *
	 * function duplicate(n) {
	 *   return [n, n];
	 * }
	 *
	 * _.flatMap([1, 2], duplicate);
	 * // => [1, 1, 2, 2]
	 */

	function flatMap(collection, iteratee) {
	  return _baseFlatten(map_1(collection, iteratee), 1);
	}

	var flatMap_1 = flatMap;

	//
	var script = {
	  mixins: [FieldMixin],
	  props: {
	    showModifications: {
	      type: Boolean,
	      "default": true
	    }
	  },
	  computed: {
	    skuProps: function skuProps() {
	      return this.$store.getters["".concat(this.$root.$namespace, "/getSkuPropsByIblockId")](this.row.iblockId);
	    },
	    treeProps: function treeProps() {
	      var _this = this;

	      return this.skuProps.filter(function (prop) {
	        return _this.propsValues[prop.ID];
	      });
	    },
	    propsValues: function propsValues() {
	      return this.row.sku;
	    },
	    disabledValues: function disabledValues() {
	      var _this2 = this;

	      return flatMap_1(this.propsValues, function (values, propId) {
	        return reduce_1(values, function (result, value, valueId) {
	          if (!!!_this2.findProduct(propId, parseInt(valueId))) result.push(propId + '_' + valueId);
	          return result;
	        }, []);
	      });
	    },
	    cantBuyValues: function cantBuyValues() {
	      var _this3 = this;

	      return flatMap_1(this.treeProps, function (prop) {
	        return Object.keys(_this3.propsValues[prop.ID]).filter(function (valueId) {
	          return !_this3.isDisabled(prop.ID, valueId);
	        }).reduce(function (result, strValueId) {
	          var valueId = parseInt(strValueId);
	          if (!_this3.findProduct(prop.ID, valueId, true)) result.push(valueId);
	          return result;
	        }, []);
	      });
	    },
	    formattedPropsValues: function formattedPropsValues() {
	      var _this4 = this;

	      return this.skuProps.filter(function (prop) {
	        return _this4.propsValues[prop.ID];
	      }).map(function (prop) {
	        return {
	          ID: prop.ID,
	          NAME: prop.NAME,
	          SHOW_MODE: prop.SHOW_MODE,
	          values: Object.values(prop.VALUES).filter(function (value) {
	            return _this4.propsValues[prop.ID][value.ID] && !_this4.isDisabled(prop.ID, value.ID);
	          }).sort(function (v1, v2) {
	            return v1.SORT - v2.SORT;
	          })
	        };
	      });
	    },
	    images: function images() {
	      return (this.$root.params || {}).imagesPath || {};
	    },
	    messages: function messages() {
	      return Object.freeze({
	        'RS_B2B_CS_SHOW_MODIFICATIONS': BX.message('RS_B2B_CS_SHOW_MODIFICATIONS'),
	        'RS_B2B_CS_HIDE_MODIFICATIONS': BX.message('RS_B2B_CS_HIDE_MODIFICATIONS')
	      });
	    }
	  },
	  methods: {
	    isDisabled: function isDisabled(propId, valueId) {
	      return this.disabledValues.includes(propId + '_' + valueId);
	    },
	    cantBuy: function cantBuy(valueId) {
	      return this.cantBuyValues.includes(valueId);
	    },
	    select: function select(propId, valueId) {
	      if (!this.isDisabled(propId, valueId)) {
	        this.row.selected = this.findNearestProduct(propId, valueId, !this.cantBuy(valueId)) || this.row.selected;
	      }
	    },
	    getFilter: function getFilter(propId, valueId) {
	      var index = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;
	      var filter = {};

	      if (index > this.treeProps.length) {
	        index = this.treeProps.length;
	      }

	      for (var i = 0, strPropName = ''; i < index; i++) {
	        strPropName = 'PROP_' + this.treeProps[i].ID;
	        filter[strPropName] = this.product.tree[strPropName];
	      }

	      filter['PROP_' + propId] = valueId;
	      return filter;
	    },
	    findProductByFilter: function findProductByFilter(filter) {
	      var canBuy = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

	      if (canBuy) {
	        return findKey_1(this.row.products, function (product) {
	          return isMatch_1(product.tree, filter) && product.canBuy;
	        });
	      } else {
	        return findKey_1(this.row.products, function (product) {
	          return isMatch_1(product.tree, filter);
	        });
	      }
	    },
	    findNearestProduct: function findNearestProduct(propId, valueId) {
	      var canBuy = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
	      var productId = false;

	      for (var i = this.treeProps.length; i >= 0; i--) {
	        productId = this.findProductByFilter(this.getFilter(propId, valueId, i), canBuy);

	        if (productId) {
	          break;
	        }
	      }

	      return productId;
	    },
	    findProduct: function findProduct(propId, valueId) {
	      var canBuy = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
	      var index = findIndex_1(this.skuProps, function (prop) {
	        return prop.ID == propId;
	      });
	      return -1 < index ? this.findProductByFilter(this.getFilter(propId, valueId, index), canBuy) : false;
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

	var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\\b/.test(navigator.userAgent.toLowerCase());

	function createInjector(context) {
	  return function (id, style) {
	    return addStyle(id, style);
	  };
	}

	var HEAD;
	var styles = {};

	function addStyle(id, css) {
	  var group = isOldIE ? css.media || 'default' : id;
	  var style = styles[group] || (styles[group] = {
	    ids: new Set(),
	    styles: []
	  });

	  if (!style.ids.has(id)) {
	    style.ids.add(id);
	    var code = css.source;

	    if (css.map) {
	      // https://developer.chrome.com/devtools/docs/javascript-debugging
	      // this makes source maps inside style tags work properly in Chrome
	      code += '\n/*# sourceURL=' + css.map.sources[0] + ' */'; // http://stackoverflow.com/a/26603875

	      code += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(css.map)))) + ' */';
	    }

	    if (!style.element) {
	      style.element = document.createElement('style');
	      style.element.type = 'text/css';
	      if (css.media) style.element.setAttribute('media', css.media);

	      if (HEAD === undefined) {
	        HEAD = document.head || document.getElementsByTagName('head')[0];
	      }

	      HEAD.appendChild(style.element);
	    }

	    if ('styleSheet' in style.element) {
	      style.styles.push(code);
	      style.element.styleSheet.cssText = style.styles.filter(Boolean).join('\n');
	    } else {
	      var index = style.ids.size - 1;
	      var textNode = document.createTextNode(code);
	      var nodes = style.element.childNodes;
	      if (nodes[index]) style.element.removeChild(nodes[index]);
	      if (nodes.length) style.element.insertBefore(textNode, nodes[index]);else style.element.appendChild(textNode);
	    }
	  }
	}

	var browser = createInjector;

	/* script */
	var __vue_script__ = script;
	/* template */

	var __vue_render__ = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [_vm._l(_vm.formattedPropsValues, function (prop) {
	    return _c("div", {
	      key: prop.ID
	    }, [_vm._v("\n\t\t" + _vm._s(prop.NAME) + "\n\n\t\t"), _c("ul", {
	      staticClass: "sku-list"
	    }, _vm._l(prop.values, function (value) {
	      return _c("li", {
	        key: value.ID,
	        staticClass: "sku-list__item",
	        "class": {
	          "sku-list__item--selected": _vm.product.tree["PROP_" + prop.ID] == value.ID,
	          "sku-list__item--disabled": _vm.cantBuy(value.ID)
	        }
	      }, [prop.SHOW_MODE == "PICT" ? _c("div", {
	        staticClass: "sku-list__value sku-list__value--image",
	        attrs: {
	          title: value.NAME
	        },
	        on: {
	          click: function click($event) {
	            $event.preventDefault();
	            return _vm.select(prop.ID, value.ID);
	          }
	        }
	      }, [_c("div", {
	        staticClass: "sku-list__image",
	        style: {
	          backgroundImage: "url(" + (value.PICT.SRC || _vm.images.noPropValue) + ")"
	        }
	      })]) : _c("div", {
	        staticClass: "sku-list__value sku-list__value--text",
	        on: {
	          click: function click($event) {
	            $event.preventDefault();
	            return _vm.select(prop.ID, value.ID);
	          }
	        }
	      }, [_vm._v("\n\t\t\t\t\t" + _vm._s(value.NAME) + "\n\t\t\t\t")])]);
	    }), 0)]);
	  }), _vm._v(" "), _vm.showModifications && _vm.formattedPropsValues.length ? _c("div", {
	    staticClass: "mt-2"
	  }, [_c("a", {
	    staticClass: "text-nowrap small",
	    attrs: {
	      href: "#"
	    },
	    on: {
	      click: function click($event) {
	        $event.preventDefault();
	        _vm.row._IS_EXPAND = !_vm.row._IS_EXPAND;
	      }
	    }
	  }, [!_vm.row._IS_EXPAND ? [_vm._v(_vm._s(_vm.messages.RS_B2B_CS_SHOW_MODIFICATIONS) + " "), _c("i", {
	    staticClass: "fa fa-angle-down"
	  })] : [_vm._v(_vm._s(_vm.messages.RS_B2B_CS_HIDE_MODIFICATIONS) + " "), _c("i", {
	    staticClass: "fa fa-angle-up"
	  })]], 2)]) : _vm._e()], 2);
	};

	var __vue_staticRenderFns__ = [];
	__vue_render__._withStripped = true;
	/* style */

	var __vue_inject_styles__ = function __vue_inject_styles__(inject) {
	  if (!inject) return;
	  inject("data-v-7173fa4a_0", {
	    source: ".sku-list[data-v-7173fa4a] {\n  display: flex;\n  align-items: center;\n  flex-wrap: wrap;\n  margin: 0;\n  padding: 0;\n}\n.sku-list__item[data-v-7173fa4a] {\n  display: block;\n  padding: 0;\n  margin: 0;\n}\n.sku-list__value[data-v-7173fa4a] {\n  display: block;\n  margin: 2px;\n  cursor: pointer;\n  padding: 1px;\n  border: 1px solid #efeff5;\n}\n.sku-list__value--image[data-v-7173fa4a] {\n  position: relative;\n}\n.sku-list__image[data-v-7173fa4a] {\n  width: 20px;\n  height: 20px;\n  background-size: cover;\n  background-position: center;\n}\n.sku-list__value--text[data-v-7173fa4a] {\n  padding: 1px;\n  border: 1px solid #efeff5;\n  display: block;\n  margin: 2px;\n  font-size: 12px;\n  min-width: 19px;\n  height: 20px;\n  color: #646c9a;\n  text-align: center;\n  cursor: pointer;\n}\n.sku-list__item--disabled > .sku-list__value[data-v-7173fa4a] {\n  opacity: 0.65;\n}\n.sku-list__item--selected > .sku-list__value--text[data-v-7173fa4a] {\n  background-color: #646c9a;\n  border-color: #646c9a;\n  color: #fff;\n}\n.sku-list__item--selected > .sku-list__value--image[data-v-7173fa4a] {\n  border-color: #646c9a;\n}",
	    map: undefined,
	    media: undefined
	  });
	};
	/* scoped */


	var __vue_scope_id__ = "data-v-7173fa4a";
	/* module identifier */

	var __vue_module_identifier__ = undefined;
	/* functional template */

	var __vue_is_functional_template__ = false;
	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__ = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__,
	  staticRenderFns: __vue_staticRenderFns__
	}, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, false, browser, undefined, undefined);

	function getProductName(row, product) {
	  return typeof product.name == 'string' && product.name.length > 0 ? product.name : row.name;
	}
	function getVendorCode(row, product) {
	  return [product.vendorCode, row.vendorCode].find(function (code) {
	    return code && code !== '';
	  });
	}
	function checkQuantityRange(range, quantity) {
	  return parseFloat(quantity) >= parseFloat(range.sort_from) && (range.sort_to === 'INF' || parseFloat(quantity) <= parseFloat(range.sort_to));
	}

	//
	var script$1 = {
	  mixins: [FieldMixin],
	  components: {
	    SkuField: __vue_component__
	  },
	  props: {
	    view: {
	      type: String,
	      "default": 'default'
	    }
	  },
	  computed: babelHelpers.defineProperty({
	    name: function name() {
	      return getProductName(this.row, this.product);
	    },
	    vendorCode: function vendorCode() {
	      var vendorCode = getVendorCode(this.row, this.product);
	      return vendorCode ? BX.message('RS.B2BPORTAL.TABLE.COLS.ARTICLE').replace('#NUMBER#', vendorCode) : false;
	    },
	    brand: function brand() {
	      return this.row.brand !== '' ? BX.message('RS.B2BPORTAL.TABLE.COLS.BRAND').replace('#BRAND#', this.row.brand) : false;
	    },
	    hasSku: function hasSku() {
	      return Object.keys(this.row.sku).length > 0;
	    },
	    preview: function preview() {
	      return (this.product.preview || {}).SRC || (this.row.preview || {}).SRC;
	    },
	    previewThumbnail: function previewThumbnail() {
	      return (this.product.previewThumbnail || this.row.previewThumbnail || {}).src || this.preview;
	    },
	    usePreviewPicture: function usePreviewPicture() {
	      return this.$store.getters["".concat(this.$root.$namespace, "/isShowPreview")];
	    },
	    labels: function labels() {
	      return this.row.labels;
	    }
	  }, "hasSku", function hasSku() {
	    return Object.keys(this.row.sku).length > 0;
	  }),
	  mounted: function mounted() {
	    this.initPreviewPopovers();
	  },
	  methods: {
	    initPreviewPopovers: function initPreviewPopovers() {
	      var _this = this;

	      if (this.usePreviewPicture) {
	        $(this.$refs.preview).popover({
	          trigger: 'hover',
	          placement: 'right',
	          boundary: 'window',
	          html: true,
	          content: function content() {
	            return "<img class=\"img-fluid\" src=\"".concat(_this.preview, "\" />");
	          },
	          title: ''
	        });
	      }
	    }
	  },
	  watch: {
	    preview: function preview() {
	      var _this2 = this;

	      this.$nextTick(function () {
	        _this2.initPreviewPopovers();
	      });
	    }
	  }
	};

	/* script */
	var __vue_script__$1 = script$1;
	/* template */

	var __vue_render__$1 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [_c("div", {
	    staticClass: "d-flex"
	  }, [_vm.usePreviewPicture ? _c("div", {
	    staticClass: "mr-3 mt-2 product-preview-picture-60"
	  }, [_vm.preview ? _c("div", {
	    ref: "preview",
	    attrs: {
	      "data-html": "true",
	      "data-toggle": "popover"
	    }
	  }, [_c("img", {
	    staticClass: "img-fluid",
	    attrs: {
	      src: _vm.previewThumbnail
	    }
	  })]) : _vm._e()]) : _vm._e(), _vm._v(" "), _c("div", {
	    staticClass: "d-block"
	  }, [_c("div", {
	    staticClass: "mb-2"
	  }, [_c("span", {
	    staticClass: "mr-2"
	  }, [_vm.row.url ? _c("a", {
	    attrs: {
	      href: _vm.row.url
	    },
	    domProps: {
	      innerHTML: _vm._s(_vm.name)
	    }
	  }) : _c("span", {
	    domProps: {
	      innerHTML: _vm._s(_vm.name)
	    }
	  })])]), _vm._v(" "), _vm.vendorCode ? _c("div", [_c("span", {
	    staticClass: "mr-2"
	  }, [_vm._v(_vm._s(_vm.vendorCode))])]) : _vm._e(), _vm._v(" "), _vm.view !== "sku" && _vm.brand ? _c("div", [_c("span", {
	    staticClass: "mr-2",
	    domProps: {
	      innerHTML: _vm._s(_vm.brand)
	    }
	  })]) : _vm._e(), _vm._v(" "), _vm.view !== "sku" && _vm.labels.length ? _c("div", {
	    staticClass: "mt-2"
	  }, _vm._l(_vm.labels, function (label) {
	    return _c("span", {
	      key: label.code,
	      staticClass: "badge mr-2 mb-2",
	      "class": "label-" + (label.code || "").toLowerCase() + " badge-" + label.modifier,
	      domProps: {
	        innerHTML: _vm._s(label.name)
	      }
	    });
	  }), 0) : _vm._e(), _vm._v(" "), _vm.hasSku ? _c("div", {
	    staticClass: "mt-2"
	  }, [_c("SkuField", {
	    attrs: {
	      row: _vm.row,
	      product: _vm.product,
	      showModifications: false
	    }
	  })], 1) : _vm._e()])])]);
	};

	var __vue_staticRenderFns__$1 = [];
	__vue_render__$1._withStripped = true;
	/* style */

	var __vue_inject_styles__$1 = function __vue_inject_styles__(inject) {
	  if (!inject) return;
	  inject("data-v-17524bf4_0", {
	    source: "\n.product-preview-picture-60[data-v-17524bf4] { text-align: center;\n}\n.product-preview-picture-60[data-v-17524bf4] { width: 3.75rem;\n}\n.product-preview-picture-60 .img-fluid[data-v-17524bf4] { max-height: 3.75rem;\n}\n",
	    map: undefined,
	    media: undefined
	  });
	};
	/* scoped */


	var __vue_scope_id__$1 = "data-v-17524bf4";
	/* module identifier */

	var __vue_module_identifier__$1 = undefined;
	/* functional template */

	var __vue_is_functional_template__$1 = false;
	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__$1 = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$1,
	  staticRenderFns: __vue_staticRenderFns__$1
	}, __vue_inject_styles__$1, __vue_script__$1, __vue_scope_id__$1, __vue_is_functional_template__$1, __vue_module_identifier__$1, false, browser, undefined, undefined);

	//
	var script$2 = {
	  mixins: [FieldMixin],
	  props: {
	    view: {
	      type: String,
	      "default": 'default'
	    },
	    useImageFromGroupingItem: {
	      type: Boolean,
	      "default": true
	    }
	  },
	  computed: {
	    name: function name() {
	      return getProductName(this.row, this.product);
	    },
	    vendorCode: function vendorCode() {
	      var vendorCode = getVendorCode(this.row, this.product);
	      return vendorCode ? BX.message('RS.B2BPORTAL.TABLE.COLS.ARTICLE').replace('#NUMBER#', vendorCode) : false;
	    },
	    brand: function brand() {
	      return this.row.brand !== '' ? BX.message('RS.B2BPORTAL.TABLE.COLS.BRAND').replace('#BRAND#', this.row.brand) : false;
	    },
	    hasSku: function hasSku() {
	      return Object.keys(this.row.sku).length > 0;
	    },
	    preview: function preview() {
	      return (this.product.preview || {}).SRC || (this.useImageFromGroupingItem ? (this.row.preview || {}).SRC : '');
	    },
	    previewThumbnail: function previewThumbnail() {
	      return this.useImageFromGroupingItem ? (this.product.previewThumbnail || this.row.previewThumbnail || {}).src || this.preview : this.product.previewThumbnail || this.preview;
	    },
	    usePreviewPicture: function usePreviewPicture() {
	      return this.$store.getters["".concat(this.$root.$namespace, "/isShowPreview")];
	    },
	    labels: function labels() {
	      return this.row.labels;
	    },
	    images: function images() {
	      return (this.$root.params || {}).imagesPath || {};
	    }
	  },
	  mounted: function mounted() {
	    this.initPreviewPopovers();
	  },
	  methods: {
	    initPreviewPopovers: function initPreviewPopovers() {
	      var _this = this;

	      if (this.usePreviewPicture) {
	        $(this.$refs.preview).popover({
	          trigger: 'hover',
	          placement: 'right',
	          boundary: 'window',
	          html: true,
	          content: function content() {
	            return "<img class=\"img-fluid\" src=\"".concat(_this.preview, "\" />");
	          },
	          title: ''
	        });
	      }
	    }
	  },
	  watch: {
	    preview: function preview() {
	      var _this2 = this;

	      this.$nextTick(function () {
	        _this2.initPreviewPopovers();
	      });
	    }
	  }
	};

	/* script */
	var __vue_script__$2 = script$2;
	/* template */

	var __vue_render__$2 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [_c("div", {
	    staticClass: "d-flex"
	  }, [_vm.usePreviewPicture ? _c("div", {
	    staticClass: "mr-3 mt-2",
	    "class": {
	      "product-preview-picture-40": _vm.view === "sku",
	      "product-preview-picture-60": _vm.view !== "sku"
	    }
	  }, [_vm.preview ? _c("div", {
	    ref: "preview",
	    attrs: {
	      "data-html": "true",
	      "data-toggle": "popover"
	    }
	  }, [_c("img", {
	    staticClass: "img-fluid",
	    attrs: {
	      src: _vm.previewThumbnail
	    }
	  })]) : _c("div", [_c("img", {
	    staticClass: "img-fluid",
	    attrs: {
	      src: _vm.images.noimage
	    }
	  })])]) : _vm._e(), _vm._v(" "), _c("div", {
	    staticClass: "d-block"
	  }, [_c("div", {
	    staticClass: "mb-2"
	  }, [_c("span", {
	    staticClass: "mr-2"
	  }, [_vm.row.url ? _c("a", {
	    attrs: {
	      href: _vm.row.url
	    },
	    domProps: {
	      innerHTML: _vm._s(_vm.name)
	    }
	  }) : _c("span", {
	    domProps: {
	      innerHTML: _vm._s(_vm.name)
	    }
	  })])]), _vm._v(" "), _vm.vendorCode ? _c("div", [_c("span", {
	    staticClass: "mr-2"
	  }, [_vm._v(_vm._s(_vm.vendorCode))])]) : _vm._e(), _vm._v(" "), _vm.view !== "sku" && _vm.brand ? _c("div", [_c("span", {
	    staticClass: "mr-2",
	    domProps: {
	      innerHTML: _vm._s(_vm.brand)
	    }
	  })]) : _vm._e(), _vm._v(" "), _vm.view !== "sku" && _vm.labels.length ? _c("div", {
	    staticClass: "mt-2"
	  }, _vm._l(_vm.labels, function (label) {
	    return _c("span", {
	      key: label.code,
	      staticClass: "badge mr-2 mb-2",
	      "class": "label-" + (label.code || "").toLowerCase() + " badge-" + label.modifier,
	      domProps: {
	        innerHTML: _vm._s(label.name)
	      }
	    });
	  }), 0) : _vm._e()])])]);
	};

	var __vue_staticRenderFns__$2 = [];
	__vue_render__$2._withStripped = true;
	/* style */

	var __vue_inject_styles__$2 = function __vue_inject_styles__(inject) {
	  if (!inject) return;
	  inject("data-v-80907c56_0", {
	    source: "\n.product-preview-picture-40[data-v-80907c56],\n.product-preview-picture-60[data-v-80907c56] {\n\ttext-align: center;\n}\n.product-preview-picture-60[data-v-80907c56] { width: 3.75rem;\n}\n.product-preview-picture-60 .img-fluid[data-v-80907c56] { max-height: 3.75rem;\n}\n.product-preview-picture-40[data-v-80907c56] { width: 2.5rem;\n}\n.product-preview-picture-40 .img-fluid[data-v-80907c56] { max-height: 2.5rem;\n}\n",
	    map: undefined,
	    media: undefined
	  });
	};
	/* scoped */


	var __vue_scope_id__$2 = "data-v-80907c56";
	/* module identifier */

	var __vue_module_identifier__$2 = undefined;
	/* functional template */

	var __vue_is_functional_template__$2 = false;
	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__$2 = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$2,
	  staticRenderFns: __vue_staticRenderFns__$2
	}, __vue_inject_styles__$2, __vue_script__$2, __vue_scope_id__$2, __vue_is_functional_template__$2, __vue_module_identifier__$2, false, browser, undefined, undefined);

	//
	var script$3 = {
	  mixins: [FieldMixin]
	};

	/* script */
	var __vue_script__$3 = script$3;
	/* template */

	var __vue_render__$3 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", _vm._l(_vm.row.props, function (prop) {
	    return _c("div", [_c("span", {
	      staticClass: "mr-2"
	    }, [_c("b", [_vm._v(_vm._s(prop.name))]), _vm._v(": "), _c("span", {
	      domProps: {
	        innerHTML: _vm._s(prop.value)
	      }
	    })])]);
	  }), 0);
	};

	var __vue_staticRenderFns__$3 = [];
	__vue_render__$3._withStripped = true;
	/* style */

	var __vue_inject_styles__$3 = undefined;
	/* scoped */

	var __vue_scope_id__$3 = undefined;
	/* module identifier */

	var __vue_module_identifier__$3 = undefined;
	/* functional template */

	var __vue_is_functional_template__$3 = false;
	/* style inject */

	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__$3 = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$3,
	  staticRenderFns: __vue_staticRenderFns__$3
	}, __vue_inject_styles__$3, __vue_script__$3, __vue_scope_id__$3, __vue_is_functional_template__$3, __vue_module_identifier__$3, false, undefined, undefined, undefined);

	//
	var script$4 = {
	  components: {
	    'vue-stock-quantity': B2BPortal.Vue.Components.StockQuantity
	  },
	  mixins: [FieldMixin],
	  computed: {
	    quantity: function quantity() {
	      return Number(this.product.inStock);
	    },
	    measure: function measure() {
	      return this.product.measure;
	    },
	    displayMode: function displayMode() {
	      return this.$root.params.arParams['QUANTITY_DISPLAY_MODE'];
	    },
	    useStocks: function useStocks() {
	      return this.$root.params.arParams['USE_STORE'];
	    },
	    displayStocks: function displayStocks() {
	      return this.$root.params.arParams['STORES'];
	    },
	    relativeQuantityFactor: function relativeQuantityFactor() {
	      return this.$root.params.arParams['RELATIVE_QUANTITY_FACTOR'];
	    },
	    maxQuantity: function maxQuantity() {
	      return this.$root.params.arParams['MAX_QUANTITY'];
	    },
	    mess: function mess() {
	      return {
	        'RELATIVE_QUANTITY_MANY': this.$root.params.arParams['MESS_RELATIVE_QUANTITY_MANY'],
	        'RELATIVE_QUANTITY_FEW': this.$root.params.arParams['MESS_RELATIVE_QUANTITY_FEW'],
	        'RELATIVE_QUANTITY_NO': this.$root.params.arParams['MESS_RELATIVE_QUANTITY_NO']
	      };
	    }
	  }
	};

	/* script */
	var __vue_script__$4 = script$4;
	/* template */

	var __vue_render__$4 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("vue-stock-quantity", {
	    attrs: {
	      displayMode: _vm.displayMode,
	      quantity: _vm.quantity,
	      measure: _vm.measure,
	      productId: _vm.product.id,
	      useStocks: _vm.useStocks,
	      displayStocks: _vm.displayStocks,
	      relativeQuantityFactor: _vm.relativeQuantityFactor,
	      maxQuantity: _vm.maxQuantity,
	      mess: _vm.mess
	    }
	  });
	};

	var __vue_staticRenderFns__$4 = [];
	__vue_render__$4._withStripped = true;
	/* style */

	var __vue_inject_styles__$4 = undefined;
	/* scoped */

	var __vue_scope_id__$4 = undefined;
	/* module identifier */

	var __vue_module_identifier__$4 = undefined;
	/* functional template */

	var __vue_is_functional_template__$4 = false;
	/* style inject */

	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__$4 = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$4,
	  staticRenderFns: __vue_staticRenderFns__$4
	}, __vue_inject_styles__$4, __vue_script__$4, __vue_scope_id__$4, __vue_is_functional_template__$4, __vue_module_identifier__$4, false, undefined, undefined, undefined);

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
	var script$5 = {
	  props: {
	    ranges: Object,
	    prices: Object,
	    type: String,
	    measureTitle: String
	  },
	  computed: {
	    messages: function messages() {
	      return Object.freeze({
	        CT_BCE_CATALOG_RANGE_FROM: BX.message('CT_BCE_CATALOG_RANGE_FROM'),
	        CT_BCE_CATALOG_RANGE_TO: BX.message('CT_BCE_CATALOG_RANGE_TO')
	      });
	    }
	  },
	  mounted: function mounted() {
	    $(this.$refs.link).popover({
	      html: true,
	      placement: 'bottom',
	      content: this.$refs.popup,
	      trigger: 'hover',
	      boundary: 'window'
	    });
	  }
	};

	/* script */
	var __vue_script__$5 = script$5;
	/* template */

	var __vue_render__$5 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", {
	    staticClass: "price-range"
	  }, [_c("a", {
	    ref: "link",
	    staticClass: "price-range__link",
	    attrs: {
	      href: "#"
	    },
	    on: {
	      click: function click($event) {
	        $event.preventDefault();
	      }
	    }
	  }, [_vm._v("  ? ")]), _vm._v(" "), _c("div", {
	    staticClass: "d-none"
	  }, [_c("div", {
	    ref: "popup",
	    staticClass: "price-range-popup"
	  }, _vm._l(_vm.ranges, function (range, name, index) {
	    return _c("div", {
	      staticClass: "d-block"
	    }, [_vm.prices[range.hash] && _vm.prices[range.hash][_vm.type] ? [range.sort_from > 0 ? _c("span", [_c("b", [_vm._v(_vm._s(range.quantity_from)), range.sort_to == "INF" ? [_vm._v("+")] : _vm._e()], 2)]) : _vm._e(), _vm._v(" "), range.sort_to !== "INF" ? _c("span", [range.sort_from > 0 ? [_vm._v("-")] : _vm._e(), _vm._v(" "), _c("b", [_vm._v(_vm._s(range.quantity_to))])], 2) : _vm._e(), _vm._v(" "), _c("span", [_vm._v(" " + _vm._s(_vm.measureTitle))]), _c("span", [_vm._v(": "), _c("b", {
	      domProps: {
	        innerHTML: _vm._s(_vm.prices[range.hash][_vm.type])
	      }
	    })])] : _vm._e()], 2);
	  }), 0)])]);
	};

	var __vue_staticRenderFns__$5 = [];
	__vue_render__$5._withStripped = true;
	/* style */

	var __vue_inject_styles__$5 = function __vue_inject_styles__(inject) {
	  if (!inject) return;
	  inject("data-v-778e9c34_0", {
	    source: ".price-range[data-v-778e9c34] {\n  display: inline-block;\n  vertical-align: middle;\n}\n.price-range__link[data-v-778e9c34] {\n  font-size: 10px;\n  line-height: 0;\n  display: inline-block;\n  vertical-align: text-bottom;\n  padding: 8px 5.5px;\n  border: 1px solid currentColor;\n  border-radius: 50%;\n  transition: 0.3s;\n}\n.price-range__link[data-v-778e9c34]:hover, .price-range__link[data-v-778e9c34]:focus, .price-range__link[data-v-778e9c34]:active {\n  background-color: #5867dd;\n  border-color: #5867dd;\n  color: #fff;\n}",
	    map: undefined,
	    media: undefined
	  });
	};
	/* scoped */


	var __vue_scope_id__$5 = "data-v-778e9c34";
	/* module identifier */

	var __vue_module_identifier__$5 = undefined;
	/* functional template */

	var __vue_is_functional_template__$5 = false;
	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__$5 = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$5,
	  staticRenderFns: __vue_staticRenderFns__$5
	}, __vue_inject_styles__$5, __vue_script__$5, __vue_scope_id__$5, __vue_is_functional_template__$5, __vue_module_identifier__$5, false, browser, undefined, undefined);

	//
	var script$6 = {
	  mixins: [FieldMixin],
	  components: {
	    PriceRange: __vue_component__$5
	  },
	  props: {
	    type: String,
	    quantity: [Number, String]
	  },
	  computed: {
	    range: function range() {
	      var quantity = !this.quantity ? this.product.ratio : this.quantity;
	      return Object.values(this.product.quantityRanges).find(function (range) {
	        return checkQuantityRange(range, quantity);
	      });
	    },
	    value: function value() {
	      return this.range ? this.product.prices[this.range.hash][this.type] : '';
	    }
	  },
	  methods: {
	    hasRanges: function hasRanges() {
	      return Object.keys(this.product.quantityRanges).length > 1;
	    }
	  }
	};

	/* script */
	var __vue_script__$6 = script$6;
	/* template */

	var __vue_render__$6 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", [_c("span", {
	    staticClass: "text-nowrap",
	    domProps: {
	      innerHTML: _vm._s(_vm.value)
	    }
	  }), _vm._v(" "), _vm.hasRanges() ? [_c("PriceRange", {
	    attrs: {
	      ranges: _vm.product.quantityRanges,
	      prices: _vm.product.prices,
	      type: _vm.type,
	      measureTitle: _vm.product.measure
	    }
	  })] : _vm._e()], 2);
	};

	var __vue_staticRenderFns__$6 = [];
	__vue_render__$6._withStripped = true;
	/* style */

	var __vue_inject_styles__$6 = undefined;
	/* scoped */

	var __vue_scope_id__$6 = undefined;
	/* module identifier */

	var __vue_module_identifier__$6 = undefined;
	/* functional template */

	var __vue_is_functional_template__$6 = false;
	/* style inject */

	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__$6 = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$6,
	  staticRenderFns: __vue_staticRenderFns__$6
	}, __vue_inject_styles__$6, __vue_script__$6, __vue_scope_id__$6, __vue_is_functional_template__$6, __vue_module_identifier__$6, false, undefined, undefined, undefined);

	//
	var script$7 = {
	  mixins: [FieldMixin],
	  components: {
	    'VueQuantityInput': B2BPortal.Vue.Components.QuantityInput
	  },
	  props: {
	    value: {
	      type: Number | String,
	      "default": 1
	    }
	  },
	  data: function data() {
	    return {
	      quantity: parseFloat(this.product.ratio, 10)
	    };
	  },
	  mounted: function mounted() {
	    var _this = this;

	    this.eventBus.$on('clearQuantity', function (itemId) {
	      if (itemId == _this.product.id) _this.quantity = _this.product.ratio;
	    });
	  },
	  methods: {
	    checkQuantity: function checkQuantity() {
	      if (!Number.isFinite(this.quantity)) {
	        this.quantity = this.product.ratio;
	      } else {
	        var newQuantity = this.quantity >= this.product.inStock ? Number(this.product.inStock) : this.quantity;
	        var intCount = Math.floor(Math.round(newQuantity * 10000000 / this.ratio) / 10000000) || 1;
	        newQuantity = intCount <= 1 ? this.ratio : intCount * this.ratio;
	        newQuantity = Math.round((newQuantity + Number.EPSILON) * 100) / 100;
	        if (newQuantity <= this.ratio) this.quantity = this.ratio;else this.quantity = newQuantity;
	      }
	    }
	  },
	  computed: {
	    eventBus: function eventBus() {
	      return this.$root.$eventBus || this;
	    },
	    inStock: function inStock() {
	      return parseFloat(this.product.inStock, 10);
	    },
	    isEnoughInstock: function isEnoughInstock() {
	      return !this.product.checkQuantity || !(this.product.checkQuantity && this.quantity > this.inStock);
	    },
	    ratio: function ratio() {
	      return Number(this.product.ratio);
	    }
	  },
	  watch: {
	    product: function product() {
	      this.checkQuantity();
	    },
	    quantity: function quantity() {
	      this.$emit('input', this.quantity);
	    }
	  }
	};

	/* script */
	var __vue_script__$7 = script$7;
	/* template */

	var __vue_render__$7 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", {
	    staticClass: "product-amount form-inline d-inline-block mw-100",
	    attrs: {
	      "data-entity": "quantity-block"
	    }
	  }, [_c("div", {
	    staticClass: "form-group form-group-last justify-content-center"
	  }, [_c("VueQuantityInput", {
	    attrs: {
	      min: _vm.ratio,
	      max: _vm.product.checkQuantity ? Number(_vm.product.inStock) : 999999,
	      step: _vm.ratio,
	      "is-invalid": !_vm.isEnoughInstock
	    },
	    on: {
	      change: _vm.checkQuantity
	    },
	    model: {
	      value: _vm.quantity,
	      callback: function callback($$v) {
	        _vm.quantity = $$v;
	      },
	      expression: "quantity"
	    }
	  })], 1)]);
	};

	var __vue_staticRenderFns__$7 = [];
	__vue_render__$7._withStripped = true;
	/* style */

	var __vue_inject_styles__$7 = undefined;
	/* scoped */

	var __vue_scope_id__$7 = undefined;
	/* module identifier */

	var __vue_module_identifier__$7 = undefined;
	/* functional template */

	var __vue_is_functional_template__$7 = false;
	/* style inject */

	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__$7 = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$7,
	  staticRenderFns: __vue_staticRenderFns__$7
	}, __vue_inject_styles__$7, __vue_script__$7, __vue_scope_id__$7, __vue_is_functional_template__$7, __vue_module_identifier__$7, false, undefined, undefined, undefined);

	//
	var script$8 = {
	  mixins: [FieldMixin],
	  props: {
	    quantity: {
	      type: [Number, String],
	      "default": 1
	    }
	  },
	  computed: {
	    eventBus: function eventBus() {
	      return this.$root.$eventBus || this;
	    },
	    inStock: function inStock() {
	      return parseFloat(this.product.inStock, 10);
	    },
	    isEnoughInstock: function isEnoughInstock() {
	      return !this.product.checkQuantity || !(this.product.checkQuantity && this.quantity > this.inStock);
	    },
	    canBuy: function canBuy() {
	      return this.product.canBuy && this.isEnoughInstock;
	    },
	    quantityInCart: function quantityInCart() {
	      return this.$store.state.cart.quantityByIds[this.product.id] || 0;
	    },
	    quantityInCartMess: function quantityInCartMess() {
	      return BX.message('RS_B2B_CS_QUANTITY_IN_CART').replace('#QUANTITY#', this.quantityInCart).replace('#MEASURE#', this.product.measure);
	    }
	  },
	  methods: {
	    buy: function buy() {
	      if (this.canBuy) {
	        this.eventBus.$emit('buy', {
	          product: this.product.id,
	          quantity: this.quantity
	        });
	      }
	    }
	  }
	};

	/* script */
	var __vue_script__$8 = script$8;
	/* template */

	var __vue_render__$8 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", {
	    staticClass: "product-item-button-container",
	    "class": {
	      "pt-4": _vm.quantityInCart
	    }
	  }, [_c("button", {
	    ref: "buttonAdd2basket",
	    staticClass: "btn btn-primary btn-sm",
	    "class": {
	      disabled: !_vm.canBuy
	    },
	    on: {
	      click: _vm.buy
	    }
	  }, [_c("i", {
	    staticClass: "flaticon2-shopping-cart-1 pr-0"
	  })]), _vm._v(" "), _vm.quantityInCart ? _c("div", {
	    staticClass: "m-1 small text-nowrap"
	  }, [_vm._v(_vm._s(_vm.quantityInCartMess))]) : _vm._e()]);
	};

	var __vue_staticRenderFns__$8 = [];
	__vue_render__$8._withStripped = true;
	/* style */

	var __vue_inject_styles__$8 = undefined;
	/* scoped */

	var __vue_scope_id__$8 = undefined;
	/* module identifier */

	var __vue_module_identifier__$8 = undefined;
	/* functional template */

	var __vue_is_functional_template__$8 = false;
	/* style inject */

	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__$8 = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$8,
	  staticRenderFns: __vue_staticRenderFns__$8
	}, __vue_inject_styles__$8, __vue_script__$8, __vue_scope_id__$8, __vue_is_functional_template__$8, __vue_module_identifier__$8, false, undefined, undefined, undefined);

	//
	var script$9 = {
	  mixins: [FieldMixin],
	  computed: {
	    skuProps: function skuProps() {
	      return this.$store.getters["".concat(this.$root.$namespace, "/getSkuPropsByIblockId")](this.row.iblockId);
	    },
	    tree: function tree() {
	      return this.product.tree;
	    },
	    formattedProps: function formattedProps() {
	      var _this = this;

	      return Object.keys(this.tree).map(function (key) {
	        var prop = _this.skuProps.find(function (prop) {
	          return prop.ID == key.substring('PROP_'.length);
	        });

	        var name = prop.NAME;
	        var value = (prop.VALUES[_this.tree[key]] || {}).NAME;
	        return {
	          name: name,
	          value: value
	        };
	      });
	    }
	  }
	};

	/* script */
	var __vue_script__$9 = script$9;
	/* template */

	var __vue_render__$9 = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", _vm._l(_vm.formattedProps, function (prop) {
	    return _c("div", [_c("span", {
	      staticClass: "mr-2"
	    }, [_c("b", [_vm._v(_vm._s(prop.name))]), _vm._v(": "), _c("span", {
	      domProps: {
	        innerHTML: _vm._s(prop.value)
	      }
	    })])]);
	  }), 0);
	};

	var __vue_staticRenderFns__$9 = [];
	__vue_render__$9._withStripped = true;
	/* style */

	var __vue_inject_styles__$9 = undefined;
	/* scoped */

	var __vue_scope_id__$9 = undefined;
	/* module identifier */

	var __vue_module_identifier__$9 = undefined;
	/* functional template */

	var __vue_is_functional_template__$9 = false;
	/* style inject */

	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__$9 = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$9,
	  staticRenderFns: __vue_staticRenderFns__$9
	}, __vue_inject_styles__$9, __vue_script__$9, __vue_scope_id__$9, __vue_is_functional_template__$9, __vue_module_identifier__$9, false, undefined, undefined, undefined);

	//
	var script$a = {
	  components: {
	    'vue-table': B2BPortal.Vue.Components.VueTable,
	    'vue-dropdown': B2BPortal.Vue.Components.Dropdown,
	    NameField: __vue_component__$2,
	    InStockField: __vue_component__$4,
	    SkuAsPropsField: __vue_component__$9,
	    PriceField: __vue_component__$6,
	    QuantityField: __vue_component__$7,
	    ActionsField: __vue_component__$8
	  },
	  props: {
	    row: {
	      type: Object,
	      "default": function _default() {}
	    }
	  },
	  data: function data() {
	    var _this = this;

	    return {
	      quantities: Object.keys(this.row.products).reduce(function (obj, key) {
	        obj[key] = _this.row.products[key].ratio || 1;
	        return obj;
	      }, {}),
	      columns: [],
	      priceIndex: 0,
	      searchQuery: ''
	    };
	  },
	  created: function created() {
	    var _this2 = this;

	    this.columns = [];
	    this.columns.push({
	      field: 'name',
	      html: true,
	      label: BX.message('RS.B2BPORTAL.TABLE.HEADERS.NAME'),
	      sortable: false
	    });
	    this.columns.push({
	      field: 'props',
	      html: true,
	      label: BX.message('RS.B2BPORTAL.TABLE.HEADERS.PROPS'),
	      sortable: false
	    });
	    this.columns.push({
	      field: 'instock',
	      html: true,
	      label: BX.message('RS.B2BPORTAL.TABLE.HEADERS.AVAILABLE'),
	      sortable: true,
	      sortFn: function sortFn(x, y, col, rowX, rowY) {
	        var instockX = parseFloat(rowX.inStock);
	        var instockY = parseFloat(rowY.inStock);
	        return instockX < instockY ? -1 : instockX > instockY ? 1 : 0;
	      }
	    });
	    this.prices.forEach(function (price) {
	      _this2.columns.push({
	        field: 'catalog_price_scale_' + price.id,
	        html: true,
	        label: price.title,
	        sortable: true,
	        sortFn: function sortFn(x, y, col, rowX, rowY) {
	          var quantityX = _this2.quantities[rowX.id] || rowX.ratio;
	          var rangeX = Object.values(rowX.quantityRanges).find(function (range) {
	            return checkQuantityRange(range, quantityX);
	          });
	          var priceX = rangeX ? rowX.prices[rangeX.hash][col.field + '_num'] : 0;
	          var quantityY = _this2.quantities[rowY.id] || rowY.ratio;
	          var rangeY = Object.values(rowY.quantityRanges).find(function (range) {
	            return checkQuantityRange(range, quantityY);
	          });
	          var priceY = rangeX ? rowY.prices[rangeY.hash][col.field + '_num'] : 0;
	          return priceX < priceY ? -1 : priceX > priceY ? 1 : 0;
	        }
	      });
	    });
	    this.columns.push({
	      field: 'quantity',
	      html: true,
	      label: BX.message('RS.B2BPORTAL.TABLE.HEADERS.QUANTITY'),
	      sortable: false
	    });
	    this.columns.push({
	      field: 'actions',
	      label: '',
	      sortable: false,
	      tdClass: 'text-center',
	      thClass: 'text-center'
	    });
	  },
	  computed: {
	    rows: function rows() {
	      return Object.values(this.row.products);
	    },
	    skuProps: function skuProps() {
	      return this.$store.getters["".concat(this.$root.$namespace, "/getSkuPropsByIblockId")](this.row.iblockId);
	    },
	    prices: function prices() {
	      return this.$store.getters["".concat(this.$root.$namespace, "/getPrices")] || [];
	    },
	    selectedPrice: function selectedPrice() {
	      return this.prices[this.priceIndex] || {};
	    },
	    priceType: function priceType() {
	      return 'catalog_price_scale_' + this.selectedPrice.id;
	    },
	    pricesVariants: function pricesVariants() {
	      return this.prices.map(function (price) {
	        return {
	          text: price.title
	        };
	      });
	    },
	    messages: function messages() {
	      return Object.freeze({
	        'RS_B2B_CS_SEARCH_MODIFICATION': BX.message('RS_B2B_CS_SEARCH_MODIFICATION')
	      });
	    }
	  },
	  methods: {
	    changePrice: function changePrice(selectPrice) {
	      this.priceIndex = this.prices.findIndex(function (price) {
	        return price.id == selectPrice.id;
	      });
	    },
	    changedQuantity: function changedQuantity(productId, newQuantity) {
	      quantities[productId] = newQuantity;
	    },
	    searchFn: function searchFn(value, searchTerm) {
	      return String(value).toLowerCase().indexOf(String(searchTerm).toLowerCase()) > -1;
	    },
	    handleSearch: function handleSearch(row, col, cellValue, searchTerm) {
	      var _this3 = this;

	      var isFind = false;

	      if (col.field === 'name') {
	        var name = getProductName(this.row, row);
	        isFind = this.searchFn(name, searchTerm);

	        if (!isFind) {
	          var vendorCode = getVendorCode(this.row, row);

	          if (vendorCode) {
	            isFind = this.searchFn(vendorCode, searchTerm);
	          }
	        }
	      } else if (col.field === 'props') {
	        var tree = row.tree || {};

	        var _loop = function _loop(key) {
	          var prop = _this3.skuProps.find(function (prop) {
	            return prop.ID == key.substring('PROP_'.length);
	          });

	          var value = (prop.VALUES[tree[key]] || {}).NAME;
	          isFind = _this3.searchFn(value, searchTerm);
	          if (isFind) return "break";
	        };

	        for (var key in tree) {
	          var _ret = _loop(key);

	          if (_ret === "break") break;
	        }
	      }

	      return isFind;
	    },
	  }
	};

	/* script */
	var __vue_script__$a = script$a;
	/* template */

	var __vue_render__$a = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", {
	    staticClass: "mb-4"
	  }, [_c("div", {
	    staticClass: "row justify-content-start mb-4"
	  }, [_c("div", {
	    staticClass: "col-3"
	  }, [_c("div", {
	    staticClass: "kt-input-icon kt-input-icon--left"
	  }, [_c("input", {
	    directives: [{
	      name: "model",
	      rawName: "v-model",
	      value: _vm.searchQuery,
	      expression: "searchQuery"
	    }],
	    staticClass: "form-control",
	    attrs: {
	      type: "text",
	      placeholder: _vm.messages.RS_B2B_CS_SEARCH_MODIFICATION
	    },
	    domProps: {
	      value: _vm.searchQuery
	    },
	    on: {
	      input: function input($event) {
	        if ($event.target.composing) {
	          return;
	        }

	        _vm.searchQuery = $event.target.value;
	      }
	    }
	  }), _vm._v(" "), _vm._m(0)])])]), _vm._v(" "), _c("vue-table", {
	    ref: "table",
	    attrs: {
	      columns: _vm.columns,
	      rows: _vm.rows,
	      "pagination-options": {
	        enabled: true,
	        mode: "records",
	        perPage: 10,
	        position: "bottom",
	        perPageDropdown: [5, 10, 15, 20],
	        dropdownAllowAll: false
	      },
	      "search-options": {
	        enabled: true,
	        externalQuery: _vm.searchQuery,
	        searchFn: _vm.handleSearch
	      }
	    },
	    scopedSlots: _vm._u([{
	      key: "table-row",
	      fn: function fn(props) {
	        return [props.column.field == "name" ? [_c("NameField", {
	          attrs: {
	            row: _vm.row,
	            product: _vm.row.products[props.row.id],
	            view: "sku",
	            useImageFromGroupingItem: false
	          }
	        })] : _vm._e(), _vm._v(" "), props.column.field == "props" ? [_c("SkuAsPropsField", {
	          attrs: {
	            row: _vm.row,
	            product: _vm.row.products[props.row.id]
	          }
	        })] : _vm._e(), _vm._v(" "), props.column.field === "instock" ? [_c("InStockField", {
	          attrs: {
	            row: _vm.row,
	            product: _vm.row.products[props.row.id]
	          }
	        })] : _vm._e(), _vm._v(" "), props.column.field === "quantity" ? [_c("QuantityField", {
	          attrs: {
	            product: props.row
	          },
	          model: {
	            value: _vm.quantities[props.row.id],
	            callback: function callback($$v) {
	              _vm.$set(_vm.quantities, props.row.id, $$v);
	            },
	            expression: "quantities[props.row.id]"
	          }
	        })] : _vm._e(), _vm._v(" "), props.column.field === "actions" ? [_c("ActionsField", {
	          attrs: {
	            row: _vm.row,
	            product: _vm.row.products[props.row.id],
	            quantity: _vm.quantities[props.row.id]
	          }
	        })] : _vm._e(), _vm._v(" "), props.column.field.startsWith("catalog_price_scale_") ? [_c("PriceField", {
	          attrs: {
	            row: _vm.row,
	            product: _vm.row.products[props.row.id],
	            type: props.column.field,
	            quantity: _vm.quantities[props.row.id]
	          }
	        })] : _vm._e()];
	      }
	    }])
	  })], 1);
	};

	var __vue_staticRenderFns__$a = [function () {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("span", {
	    staticClass: "kt-input-icon__icon kt-input-icon__icon--left"
	  }, [_c("span", [_c("i", {
	    staticClass: "la la-search"
	  })])]);
	}];
	__vue_render__$a._withStripped = true;
	/* style */

	var __vue_inject_styles__$a = undefined;
	/* scoped */

	var __vue_scope_id__$a = undefined;
	/* module identifier */

	var __vue_module_identifier__$a = undefined;
	/* functional template */

	var __vue_is_functional_template__$a = false;
	/* style inject */

	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__$a = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$a,
	  staticRenderFns: __vue_staticRenderFns__$a
	}, __vue_inject_styles__$a, __vue_script__$a, __vue_scope_id__$a, __vue_is_functional_template__$a, __vue_module_identifier__$a, false, undefined, undefined, undefined);

	//
	var script$b = {
	  name: 'vue-product-table',
	  components: {
	    CompactNameField: __vue_component__$1,
	    NameField: __vue_component__$2,
	    SkuField: __vue_component__,
	    InStockField: __vue_component__$4,
	    PriceField: __vue_component__$6,
	    QuantityField: __vue_component__$7,
	    ActionsField: __vue_component__$8,
	    PropertiesField: __vue_component__$3,
	    SkuTable: __vue_component__$a,
	    'vue-table': B2BPortal.Vue.Components.VueTable
	  },
	  props: {
	    isLoading: Boolean,
	    mode: {
	      "default": 'remote'
	    },
	    view: {
	      type: String,
	      "default": 'base'
	    },
	    columns: {
	      type: Array,
	      "default": function _default() {
	        return [];
	      }
	    },
	    rows: {
	      type: Array,
	      "default": function _default() {
	        return [];
	      }
	    },
	    totalRows: {
	      type: [String, Number],
	      "default": ''
	    },
	    selectOptions: {
	      type: Object,
	      "default": function _default() {}
	    },
	    paginationOptions: {
	      type: Object,
	      "default": function _default() {}
	    },
	    sortOptions: {
	      type: Object,
	      "default": function _default() {}
	    }
	  },
	  data: function data() {
	    return {
	      sortParams: this.sortOptions,
	      rowsAreas: []
	    };
	  },
	  computed: {
	    fields: function fields() {
	      return Object.freeze(['name', 'sku', 'properties', 'instock', 'quantity', 'actions']);
	    },
	    expandedRows: function expandedRows() {
	      var rows = this.rows;
	      return rows.reduce(function (indexes, row, index) {
	        if (row._IS_EXPAND) indexes.push(index);
	        return indexes;
	      }, []);
	    },
	    visibleColumns: function visibleColumns() {
	      var _this = this;

	      return this.columns.map(function (column) {
	        switch (column.field) {
	          case 'sku':
	            column.hidden = !!!_this.rows.find(function (row) {
	              return Object.prototype.toString.call(row.sku) === '[object Object]';
	            });
	            break;

	          case 'properties':
	            column.hidden = !!!_this.rows.find(function (row) {
	              return row.props.length;
	            });
	            break;
	        }

	        return column;
	      });
	    },
	    rowsMask: function rowsMask() {
	      return this.rows.map(function (row) {
	        return {};
	      });
	    },
	    eventBus: function eventBus() {
	      return this.$root.$eventBus || this;
	    },
	    editAreas: function editAreas() {
	      return this.$store.getters["".concat(this.$root.$namespace, "/getEditAreas")];
	    },
	    editAreaIds: function editAreaIds() {
	      var _this2 = this;

	      return Object.keys(this.editAreas).filter(function (areaId) {
	        return _this2.rows.find(function (row) {
	          return row.editAreaId == areaId;
	        });
	      });
	    }
	  },
	  created: function created() {
	    var _this3 = this;

	    this.rows.forEach(function (row) {
	      return _this3.$set(row, '_IS_EXPAND', false);
	    });
	  },
	  mounted: function mounted() {
	    var _this4 = this;

	    this.setRowsIds();
	    this.setEditAreas();
	    this.eventBus.$on('unselectRows', function () {
	      _this4.$refs.table.unselectAllInternal();
	    });
	  },
	  methods: {
	    getProduct: function getProduct(row) {
	      return row.products[row.selected] || null;
	    },
	    handleSortChange: function handleSortChange(params) {
	      this.eventBus.$emit('onSortChange', params[0]);
	    },
	    handlePageChange: function handlePageChange(params) {
	      this.eventBus.$emit('onPageChange', params);
	    },
	    handlePerPageChange: function handlePerPageChange(params) {
	      this.eventBus.$emit('onPerPageChange', params);
	    },
	    handleSelectedRowsChanged: function handleSelectedRowsChanged(params) {
	      var selectedRows = this.rows.filter(function (row, index) {
	        return params.selectedRows.find(function (selectedRow) {
	          return selectedRow.originalIndex === index;
	        });
	      });
	      this.eventBus.$emit('onSelectedRowsChanged', selectedRows);
	    },
	    setRowsIds: function setRowsIds() {
	      var _this5 = this;

	      var table = this.$refs.table;
	      var tableRows = table.$refs.rows;
	      tableRows.forEach(function (row, index) {
	        row.setAttribute('id', _this5.rows[index].editAreaId);
	      });
	    },
	    setEditAreas: function setEditAreas() {
	      var _this6 = this;

	      this.editAreaIds.forEach(function (areaId) {
	        if (BX(areaId)) {
	          new BX.CMenuOpener({
	            'parent': areaId,
	            'menu': [{
	              'ICONCLASS': 'bx-context-toolbar-edit-icon',
	              'TITLE': '',
	              'TEXT': _this6.editAreas[areaId].edit.text,
	              'ONCLICK': "(new BX.CAdminDialog({'content_url': '" + _this6.editAreas[areaId].edit.link + "' })).Show()"
	            }, {
	              'ICONCLASS': 'bx-context-toolbar-delete-icon',
	              'TITLE': '',
	              'TEXT': _this6.editAreas[areaId]["delete"].text,
	              'ONCLICK': 'if(confirm(\'Are you sure?\')) jsUtils.Redirect([], ' + _this6.editAreas[areaId]["delete"].link + ');'
	            }]
	          }).Show();
	          BX.admin.setComponentBorder(areaId);
	        }
	      });
	    }
	  },
	  watch: {
	    rows: function rows() {
	      var _this7 = this;

	      this.rows.forEach(function (row) {
	        return _this7.$set(row, '_IS_EXPAND', false);
	      });
	      this.$nextTick(function () {
	        _this7.setRowsIds();
	      });
	    },
	    editAreaIds: function editAreaIds() {
	      var _this8 = this;

	      this.$nextTick(function () {
	        _this8.setEditAreas();
	      });
	    }
	  }
	};

	/* script */
	var __vue_script__$b = script$b;
	/* template */

	var __vue_render__$b = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("vue-table", {
	    ref: "table",
	    attrs: {
	      isLoading: _vm.isLoading,
	      mode: _vm.mode,
	      columns: _vm.visibleColumns,
	      rows: _vm.rowsMask,
	      totalRows: _vm.totalRows,
	      selectOptions: _vm.selectOptions,
	      paginationOptions: _vm.paginationOptions,
	      sortOptions: _vm.sortParams,
	      expandedRows: _vm.expandedRows
	    },
	    on: {
	      "on-sort-change": _vm.handleSortChange,
	      "on-page-change": _vm.handlePageChange,
	      "on-per-page-change": _vm.handlePerPageChange,
	      "on-selected-rows-change": _vm.handleSelectedRowsChanged
	    },
	    scopedSlots: _vm._u([{
	      key: "table-row",
	      fn: function fn(props) {
	        return [props.column.field == "name" ? [_vm.view !== "compact" ? _c("NameField", {
	          attrs: {
	            row: _vm.rows[props.index],
	            product: _vm.getProduct(_vm.rows[props.index])
	          }
	        }) : _c("CompactNameField", {
	          attrs: {
	            row: _vm.rows[props.index],
	            product: _vm.getProduct(_vm.rows[props.index])
	          }
	        })] : _vm._e(), _vm._v(" "), props.column.field == "sku" ? [_c("SkuField", {
	          attrs: {
	            row: _vm.rows[props.index],
	            product: _vm.getProduct(_vm.rows[props.index])
	          }
	        })] : _vm._e(), _vm._v(" "), props.column.field == "properties" ? [_c("PropertiesField", {
	          attrs: {
	            row: _vm.rows[props.index],
	            product: _vm.getProduct(_vm.rows[props.index])
	          }
	        })] : _vm._e(), _vm._v(" "), props.column.field == "instock" ? [_c("InStockField", {
	          attrs: {
	            row: _vm.rows[props.index],
	            product: _vm.getProduct(_vm.rows[props.index])
	          }
	        })] : _vm._e(), _vm._v(" "), props.column.field.startsWith("catalog_price_scale_") ? [_c("PriceField", {
	          attrs: {
	            row: _vm.rows[props.index],
	            product: _vm.getProduct(_vm.rows[props.index]),
	            type: props.column.field,
	            quantity: _vm.rows[props.index].quantity
	          }
	        })] : _vm._e(), _vm._v(" "), props.column.field == "quantity" ? [_c("QuantityField", {
	          attrs: {
	            row: _vm.rows[props.index],
	            product: _vm.getProduct(_vm.rows[props.index])
	          },
	          model: {
	            value: _vm.rows[props.index].quantity,
	            callback: function callback($$v) {
	              _vm.$set(_vm.rows[props.index], "quantity", $$v);
	            },
	            expression: "rows[props.index].quantity"
	          }
	        })] : _vm._e(), _vm._v(" "), props.column.field == "actions" ? [_c("ActionsField", {
	          attrs: {
	            row: _vm.rows[props.index],
	            product: _vm.getProduct(_vm.rows[props.index]),
	            quantity: _vm.rows[props.index].quantity
	          }
	        })] : _vm._e()];
	      }
	    }, {
	      key: "expanded-row",
	      fn: function fn(props) {
	        return [_c("SkuTable", {
	          attrs: {
	            row: _vm.rows[props.index]
	          }
	        })];
	      }
	    }])
	  });
	};

	var __vue_staticRenderFns__$b = [];
	__vue_render__$b._withStripped = true;
	/* style */

	var __vue_inject_styles__$b = undefined;
	/* scoped */

	var __vue_scope_id__$b = undefined;
	/* module identifier */

	var __vue_module_identifier__$b = undefined;
	/* functional template */

	var __vue_is_functional_template__$b = false;
	/* style inject */

	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__$b = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$b,
	  staticRenderFns: __vue_staticRenderFns__$b
	}, __vue_inject_styles__$b, __vue_script__$b, __vue_scope_id__$b, __vue_is_functional_template__$b, __vue_module_identifier__$b, false, undefined, undefined, undefined);

	var getters = {
	  getSkuPropsByIblockId: function getSkuPropsByIblockId(state) {
	    return function (iblockId) {
	      return state.skuProps[iblockId] || [];
	    };
	  },
	  getEditAreas: function getEditAreas(state) {
	    return state.editAreas;
	  },
	  isShowPreview: function isShowPreview(state) {
	    return state.settings.preview;
	  },
	  isShowViewTemplates: function isShowViewTemplates(state) {
	    return state.settings.views;
	  },
	  getToolbarOptions: function getToolbarOptions(state) {
	    return state.toolbar;
	  },
	  getPrices: function getPrices(state) {
	    return state.prices;
	  }
	};
	var mutations = {
	  SET_SHOW_PREVIEW: function SET_SHOW_PREVIEW(state, status) {
	    state.settings.preview = status;
	  },
	  ADD_SKU_PROPS: function ADD_SKU_PROPS(state, _ref) {
	    var iblockId = _ref.iblockId,
	        props = _ref.props;
	    Vue.set(state.skuProps, iblockId, props);
	  },
	  ADD_EDIT_AREA: function ADD_EDIT_AREA(state, _ref2) {
	    var id = _ref2.id,
	        actions = _ref2.actions;
	    Vue.set(state.editAreas, id, actions);
	  }
	};
	var actions = {
	  togglePreview: function togglePreview(_ref3) {
	    var state = _ref3.state,
	        commit = _ref3.commit;
	    commit('SET_SHOW_PREVIEW', !state.settings.preview);
	    localStorage.setItem(state.prefix + '_preview_switcher', state.settings.preview);
	  },
	  setSkuProps: function setSkuProps(_ref4, payload) {
	    var commit = _ref4.commit;

	    for (var iblockId in payload) {
	      commit('ADD_SKU_PROPS', {
	        iblockId: iblockId,
	        props: payload[iblockId]
	      });
	    }
	  },
	  setEditAreas: function setEditAreas(_ref5, payload) {
	    var commit = _ref5.commit;

	    for (var id in payload) {
	      commit("ADD_EDIT_AREA", {
	        id: id,
	        actions: payload[id]
	      });
	    }
	  },
	  initial: function initial(_ref6) {
	    var commit = _ref6.commit,
	        state = _ref6.state;

	    if (state.settings.preview) {
	      if (state.toolbar.previewSwitcher) {
	        if (localStorage.getItem(state.prefix + '_preview_switcher')) {
	          commit('SET_SHOW_PREVIEW', localStorage.getItem(state.prefix + '_preview_switcher') === 'true');
	        } else {
	          localStorage.setItem(state.prefix + '_preview_switcher', state.settings.preview);
	        }
	      }
	    }
	  }
	};
	var INITIAL_STATE = {
	  settings: {
	    preview: false
	  },
	  prefix: '',
	  toolbar: {},
	  skuProps: {},
	  editAreas: {},
	  prices: {}
	};
	function createStore(initialState) {
	  return {
	    namespaced: true,
	    state: initialState || INITIAL_STATE,
	    getters: getters,
	    mutations: mutations,
	    actions: actions
	  };
	}

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
	var EXPORT_TYPES = ['csv', 'ods', 'xlsx'];
	var script$c = {
	  data: function data() {
	    return {
	      selectedRows: [],
	      page: window.location.pathname
	    };
	  },
	  mounted: function mounted() {
	    var _this = this;

	    this.eventBus.$on('onSelectedRowsChanged', function (selectedRows) {
	      return _this.selectedRows = selectedRows;
	    });
	    this.eventBus.$on('afterRequest', function () {
	      _this.page = window.location.pathname + window.location.search;
	    });
	    $(this.$refs.actions).on('click', function (event) {
	      event.stopPropagation();
	    });
	  },
	  computed: {
	    options: function options() {
	      return this.$store.getters["".concat(this.$root.$namespace, "/getToolbarOptions")];
	    },
	    eventBus: function eventBus() {
	      return this.$root.$eventBus || this;
	    },
	    canBuySelectedRows: function canBuySelectedRows() {
	      return this.selectedRows.filter(function (row) {
	        return (row.products[row.selected] || {}).canBuy;
	      });
	    },
	    localize: function localize() {
	      return Object.freeze({
	        'addtobasket': BX.message('RS.B2BPORTAL.ADD_TO_BASKET_LABEL'),
	        'actions': BX.message('RS.B2BPORTAL.ACTIONS_LABEL'),
	        'settings': BX.message('RS.B2BPORTAL.SETTINGS_LABEL'),
	        'views': BX.message('RS.B2BPORTAL.VIEWS_LABEL'),
	        'switcher': BX.message('RS.B2BPORTAL.IMAGE_SWITCHER_LABEL'),
	        'export': BX.message('RS.B2BPORTAL.EXPORT_LABEL')
	      });
	    },
	    labelAddtobasket: function labelAddtobasket() {
	      return this.localize.addtobasket.replace('#COUNT#', this.canBuySelectedRows.length);
	    },
	    previewSwitcher: function previewSwitcher() {
	      return this.$store.getters["".concat(this.$root.$namespace, "/isShowPreview")];
	    },
	    exports: function exports() {
	      var _this2 = this;

	      if (!this.options["export"]) return [];
	      return this.options.exportTypes.filter(function (type) {
	        return EXPORT_TYPES.includes(type);
	      }).map(function (type) {
	        var uri = new BX.Uri(_this2.page || '');
	        uri.setQueryParam('export', type);
	        return {
	          name: type,
	          url: uri.toString()
	        };
	      });
	    },
	    isShowActions: function isShowActions() {
	      return this.options.previewSwitcher || this.exports.length > 0;
	    },
			isShowViewTemplates: function isShowViewTemplates() {
				return this.$store.getters["".concat(this.$root.$namespace, "/isShowViewTemplates")];
			}
	  },
	  methods: {
	    addtobasket: function addtobasket() {
	      this.$emit('addtobasket', this.selectedRows);
	    },
	    togglePreviewSwitcher: function togglePreviewSwitcher() {
	      this.$store.dispatch("".concat(this.$root.$namespace, "/togglePreview"));
	    }
	  }
	};

	/* script */
	var __vue_script__$c = script$c;
	/* template */

	var __vue_render__$c = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

		console.log('isShowViewTemplates', _vm.isShowViewTemplates);

	  return _c("div", {
	    staticClass: "d-flex"
	  },[_c("div", {
		staticClass: "view-buttons-wrapper",
		on: {
			click: function (e) {
				var elem = e.target;
				var viewTemplate;

				if (elem.hasAttribute('data-view-template')) {
					viewTemplate = elem.getAttribute('data-view-template');
				}else{
					if (!elem.classList.contains('view-buttons-wrapper')) {
						viewTemplate = elem.closest('button[data-view-template]').getAttribute('data-view-template');
					}
				}

				if (viewTemplate) {
					var key = 'viewTemplate';
					var value = viewTemplate;
					  
					var params = new URLSearchParams(window.location.search);
					   
					if (params.get(key) !== value) {
						params.set(key, value);
						window.location.search = params.toString();
					}
				}
			}
		}
	  }, [
		_c("button", {
			staticClass: "btn btn-default mr-2",
			attrs: {
				'data-view-template': 'table',
			}
		}, [
			_c("i", {
				staticClass: "flaticon2-indent-dots"
			})
		]),
		_c("button", {
			staticClass: "btn btn-default mr-2",
			attrs: {
				'data-view-template': 'tile',
			}
		  }, [
			_c("i", {
				staticClass: "flaticon2-menu-2"
			})
		  ]),
	  ]),
	   _vm.isShowActions ? _c("div", {
	    staticClass: "dropdown position-static mr-2"
	  }, [_c("a", {
	    staticClass: "btn btn-default",
	    attrs: {
	      "data-toggle": "dropdown",
	      "data-boundary": "viewport",
	      role: "button",
	      href: "#",
	      "aria-expanded": "false"
	    }
	  }, [_c("i", {
	    staticClass: "flaticon2-soft-icons"
	  }), _vm._v(" " + _vm._s(_vm.localize.actions) + "\n\t\t")]), _vm._v(" "), _c("div", {
	    ref: "actions",
	    staticClass: "dropdown-menu dropdown-menu-right"
	  }, [_c("ul", {
	    staticClass: "kt-nav kt-nav--fit-ver"
	  }, [_vm.options.previewSwitcher ? _c("li", {
	    staticClass: "kt-nav__section"
	  }, [_c("span", {
	    staticClass: "kt-nav__section-text"
	  }, [_vm._v(_vm._s(_vm.localize.settings))])]) : _vm._e(), _vm._v(" "), _vm.options.previewSwitcher ? _c("li", {
	    staticClass: "kt-nav__section"
	  }, [_c("div", {
	    staticClass: "mb-0 d-flex align-items-center justify-content-between"
	  }, [_c("label", {
	    staticClass: "mb-0 py-0"
	  }, [_vm._v(_vm._s(_vm.localize.switcher))]), _vm._v(" "), _c("div", {
	    staticClass: "d-block"
	  }, [_c("span", {
	    staticClass: "kt-switch kt-switch--sm kt-switch--outline kt-switch--icon kt-switch--primary"
	  }, [_c("label", {
	    staticClass: "mb-0"
	  }, [_c("input", {
	    attrs: {
	      type: "checkbox"
	    },
	    domProps: {
	      checked: _vm.previewSwitcher
	    },
	    on: {
	      change: _vm.togglePreviewSwitcher
	    }
	  }), _vm._v(" "), _c("span")])])])])]) : _vm._e(), _vm._v(" "), _vm.exports.length > 0 ? _c("li", {
	    staticClass: "kt-nav__section"
	  }, [_c("span", {
	    staticClass: "kt-nav__section-text"
	  }, [_vm._v(_vm._s(_vm.localize["export"]))])]) : _vm._e(), _vm._v(" "), _vm._l(_vm.exports, function (ref, index) {
	    var name = ref.name;
	    var url = ref.url;
	    return _c("li", {
	      key: index,
	      staticClass: "kt-nav__item"
	    }, [_c("a", {
	      staticClass: "kt-nav__link",
	      attrs: {
	        href: url,
	        target: "_blank"
	      }
	    }, [_c("i", {
	      staticClass: "kt-nav__link-icon la la-file-text-o"
	    }), _vm._v(" "), _c("span", {
	      staticClass: "kt-nav__link-text text-uppercase"
	    }, [_vm._v(_vm._s(name))])])]);
	  })], 2)])]) : _vm._e(), _vm._v(" "), _c("button", {
	    staticClass: "btn btn-primary",
	    "class": {
	      disabled: !_vm.canBuySelectedRows.length
	    },
	    on: {
	      click: _vm.addtobasket
	    }
	  }, [_c("i", {
	    staticClass: "flaticon2-shopping-cart-1"
	  }), _vm._v(" " + _vm._s(_vm.labelAddtobasket) + "\n\t")])]);
	};

	var __vue_staticRenderFns__$c = [];
	__vue_render__$c._withStripped = true;
	/* style */

	var __vue_inject_styles__$c = undefined;
	/* scoped */

	var __vue_scope_id__$c = undefined;
	/* module identifier */

	var __vue_module_identifier__$c = undefined;
	/* functional template */

	var __vue_is_functional_template__$c = false;
	/* style inject */

	/* style inject SSR */

	/* style inject shadow dom */

	var __vue_component__$c = /*#__PURE__*/normalizeComponent_1({
	  render: __vue_render__$c,
	  staticRenderFns: __vue_staticRenderFns__$c
	}, __vue_inject_styles__$c, __vue_script__$c, __vue_scope_id__$c, __vue_is_functional_template__$c, __vue_module_identifier__$c, false, undefined, undefined, undefined);

	function _regeneratorRuntime$1() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime$1 = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return generator._invoke = function (innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; }(innerFn, self, context), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == babelHelpers["typeof"](value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; this._invoke = function (method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); }; } function maybeInvokeDelegate(delegate, context) { var method = delegate.iterator[context.method]; if (undefined === method) { if (context.delegate = null, "throw" === context.method) { if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel; context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method"); } return ContinueSentinel; } var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) { if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; } return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, "constructor", GeneratorFunctionPrototype), define(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (object) { var keys = []; for (var key in object) { keys.push(key); } return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) { "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); } }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }

	function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

	function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { babelHelpers.defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
	var _B2BPortal = B2BPortal,
	    store = _B2BPortal.store;
	var CatalogSection = /*#__PURE__*/function (_B2BPortal$Components) {
	  babelHelpers.inherits(CatalogSection, _B2BPortal$Components);

	  function CatalogSection(data, params) {
	    var _this;

	    babelHelpers.classCallCheck(this, CatalogSection);
	    _this = babelHelpers.possibleConstructorReturn(this, babelHelpers.getPrototypeOf(CatalogSection).call(this, data, params));

	    _this.init();

	    _this.attachTemplateToolbar();

	    BX.addCustomEvent("filter-".concat(_this.params.filter.filterName, "-on-submit"), function (data, url) {
	      _this.params.arParams.AJAX_URL = url || _this.params.arParams.AJAX_URL;
	    });
	    return _this;
	  }

	  babelHelpers.createClass(CatalogSection, [{
	    key: "init",
	    value: function init() {
	      this.namespace = "component_".concat(this.params.id);

	      var settings = _objectSpread(_objectSpread({}, INITIAL_STATE.settings), {}, {
	        preview: this.params.arParams['ENABLE_PREVIEW_PICTURE'],
	        views: this.params.arParams['SHOW_VIEWS_TEMPLATES'],
	      });

	      var initialState = _objectSpread(_objectSpread({}, INITIAL_STATE), {}, {
	        prefix: this.params.arParams['STORAGE_PREFIX'],
	        settings: _objectSpread({}, settings),
	        toolbar: _objectSpread({}, this.params.toolbar),
	        skuProps: _objectSpread({}, this.params.skuProps),
	        prices: babelHelpers.toConsumableArray(this.data.prices)
	      });

	      store.registerModule(this.namespace, createStore(initialState));
	      store.dispatch("".concat(this.namespace, "/initial"));
	      babelHelpers.get(babelHelpers.getPrototypeOf(CatalogSection.prototype), "init", this).call(this);
	    }
	  }, {
	    key: "setEditAreas",
	    value: function setEditAreas(editAreas) {
	      store.dispatch("".concat(this.namespace, "/setEditAreas"), editAreas);
	    }
	  }, {
	    key: "handleEvents",
	    value: function handleEvents() {
	      var _this2 = this;

	      this.eventBus.$on('afterRequest', function (result) {
	        return _this2.afterRequest(result);
	      });
	      this.eventBus.$on('buy', function (params) {
	        return _this2.add2basket(params.product, params.quantity);
	      });
	      this.eventBus.$on('onSortChange', function (params) {
	        return _this2.requestChangeSort(params);
	      });
	      this.eventBus.$on('onPageChange', function (params) {
	        return _this2.handlePageChange(params);
	      });
	      this.eventBus.$on('onPerPageChange', function (params) {
	        return _this2.handlePerPageChange(params);
	      });
	      this.eventBus.$on('onSelectedRowsChanged', function (selectedRows) {
	        return _this2.selectedRows = selectedRows;
	      });
	    }
	  }, {
	    key: "afterRequest",
	    value: function afterRequest(_ref) {
	      var data = _ref.data;
	      if (!data) return;
	      if (data.skuProps) store.dispatch("".concat(this.namespace, "/setSkuProps"), data.skuProps);
	      if (data.editAreas) store.dispatch("".concat(this.namespace, "/setEditAreas"), data.editAreas);
	    }
	  }, {
	    key: "handlePageChange",
	    value: function handlePageChange(params) {
	      if (params.currentPage == this.data.pagination.setCurrentPage) {
	        return;
	      }

	      this.requestPageChange(params);
	    }
	  }, {
	    key: "handlePerPageChange",
	    value: function handlePerPageChange(params) {
	      if (params.currentPerPage == this.data.pagination.perPage) {
	        return;
	      }

	      this.data.pagination.perPage = null;
	      this.requestPerPageChange(params);
	    }
	  }, {
	    key: "attachTemplates",
	    value: function attachTemplates() {
	      this.attachTemplateProductTable();
	    }
	  }, {
	    key: "attachTemplateProductTable",
	    value: function attachTemplateProductTable() {
	      var _data = this.data;
	      var params = this.params;
	      var eventBus = this.eventBus;
	      var namespace = this.namespace;
	      this.vueTable = new Vue({
	        el: this.$table,
	        components: {
	          ProductTable: __vue_component__$b
	        },
	        store: store,
	        props: {
	          isLoading: {
	            type: Boolean,
	            "default": false
	          }
	        },
	        data: function data() {
	          return {
	            data: _data,
	            params: params
	          };
	        },
	        beforeCreate: function beforeCreate() {
	          this.$namespace = namespace;
	          this.$eventBus = eventBus;
	        },
	        computed: {
	          enablePagination: function enablePagination() {
	            if (this.data.pagination.hide == 'Y') {
	              var minPerPage = Math.min.apply(Math, babelHelpers.toConsumableArray(this.params.pagination.perPageDropdown));

	              if (this.data.pagination.totalRecords <= minPerPage) {
	                return false;
	              }
	            }

	            return true;
	          },
	          enableSelect: function enableSelect() {
	            if (this.data.pagination.hide == 'Y' && this.data.items.length < 2) {
	              return false;
	            }

	            return true;
	          },
	          view: function view() {
	            return this.params.arParams.RS_VIEW_MODE === 'compact' ? 'compact' : 'base';
	          }
	        },
	        template: "\n\t\t\t\t<ProductTable\n\t\t\t\t\t:isLoading=\"isLoading\"\n\t\t\t\t\t:view=\"view\"\n\t\t\t\t\t:columns=\"data.headers\"\n\t\t\t\t\t:rows=\"data.items\"\n\t\t\t\t\t:pagination-options=\"{\n\t\t\t\t\t\tenabled: enablePagination,\n\t\t\t\t\t\tsetCurrentPage: data.pagination.currentPage,\n\t\t\t\t\t\tperPage: data.pagination.perPage,\n\t\t\t\t\t\tperPageDropdown: params.pagination.perPageDropdown,\n\t\t\t\t\t}\"\n\t\t\t\t\t:totalRows=\"data.pagination.totalRecords\"\n\t\t\t\t\t:select-options=\"{\n\t\t\t\t\t\tenabled: enableSelect,\n\t\t\t\t\t}\"\n\t\t\t\t\t:sort-options=\"{\n\t\t\t\t\t\tenabled: true,\n\t\t\t\t\t\tinitialSortBy: {\n\t\t\t\t\t\t\tfield: params.sorting.initialSortBy.field,\n\t\t\t\t\t\t\ttype: params.sorting.initialSortBy.type,\n\t\t\t\t\t\t}\n\t\t\t\t\t}\"\n\t\t\t\t/>\n\t\t\t"
	      });
	    }
	  }, {
	    key: "attachTemplateToolbar",
	    value: function attachTemplateToolbar() {
	      var self = this;
	      var eventBus = this.eventBus;
	      var namespace = this.namespace;
	      var el = document.createElement('div');
	      var $parent = document.querySelector("#".concat(this.params.block, " .kt-portlet__head-toolbar"));

	      if ($parent) {
	        $parent.appendChild(el);
	        var components = {
	          VueToolbar: __vue_component__$c
	        };
	        this.toolbar = new Vue({
	          el: el,
	          store: store,
	          components: components,
	          beforeCreate: function beforeCreate() {
	            this.$namespace = namespace;
	            this.$eventBus = eventBus;
	          },
	          methods: {
	            addtobasket: self.add2basketRows.bind(self)
	          },
	          template: "<VueToolbar @addtobasket=\"addtobasket\"/>"
	        });
	      }
	    }
	  }, {
	    key: "add2basket",
	    value: function () {
	      var _add2basket = babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime$1().mark(function _callee(itemId, quantity) {
	        var _this3 = this;

	        var url, data, result;
	        return _regeneratorRuntime$1().wrap(function _callee$(_context) {
	          while (1) {
	            switch (_context.prev = _context.next) {
	              case 0:
	                url = this.params.arParams.BASKET.ADD_URL_TEMPLATE;
	                url = url.replace('#ID#', itemId);
	                data = babelHelpers.defineProperty({
	                  'ajax_basket': 'Y'
	                }, this.params.arParams.PRODUCT_QUANTITY_VARIABLE, quantity);
	                _context.prev = 3;
	                _context.next = 6;
	                return this.requestPost(url, data);

	              case 6:
	                result = _context.sent;

	                if (result.STATUS == 'OK' && result.MESSAGE) {
	                  store.commit('cart/ADD_ITEM_TO_CART', {
	                    itemId: itemId,
	                    quantity: Number(quantity)
	                  });
	                  this.showSuccess(result.MESSAGE);
	                  this.eventBus.$emit('clearQuantity', itemId);
	                  BX.onCustomEvent('updateBasketComponent');
	                  store.dispatch('cart/fetch');
	                } else {
	                  this.showError(result.MESSAGE ? result.MESSAGE : 'Unknown error');
	                }

	                _context.next = 13;
	                break;

	              case 10:
	                _context.prev = 10;
	                _context.t0 = _context["catch"](3);

	                if (_context.t0.errors) {
	                  _context.t0.errors.forEach(function (error) {
	                    return _this3.showError(error.message);
	                  });
	                } else {
	                  console.error(_context.t0);
	                  this.showError('Undefined error');
	                }

	              case 13:
	              case "end":
	                return _context.stop();
	            }
	          }
	        }, _callee, this, [[3, 10]]);
	      }));

	      function add2basket(_x, _x2) {
	        return _add2basket.apply(this, arguments);
	      }

	      return add2basket;
	    }()
	  }, {
	    key: "add2basketRows",
	    value: function () {
	      var _add2basketRows = babelHelpers.asyncToGenerator( /*#__PURE__*/_regeneratorRuntime$1().mark(function _callee2(rows) {
	        var _this4 = this;

	        var items;
	        return _regeneratorRuntime$1().wrap(function _callee2$(_context2) {
	          while (1) {
	            switch (_context2.prev = _context2.next) {
	              case 0:
	                items = rows.filter(function (row) {
	                  return (row.products[row.selected] || {}).canBuy;
	                }).map(function (row) {
	                  return {
	                    productId: row.selected,
	                    quantity: row.quantity
	                  };
	                });

	                try {
	                  store.dispatch('cart/addFewItemsToCart', items);
	                  window.toastr.success(BX.message('RS.B2BPORTAL.ADD2BASKET_SUCCESS'));
	                  this.eventBus.$emit('unselectRows');
	                  BX.onCustomEvent('updateBasketComponent');
	                  items.forEach(function (_ref2) {
	                    var productId = _ref2.productId;

	                    _this4.eventBus.$emit('clearQuantity', productId);
	                  });
	                } catch (e) {
	                  console.error(e);
	                  window.toastr.error(BX.message('RS.B2BPORTAL.ADD2BASKET_ERROR'));
	                }

	              case 2:
	              case "end":
	                return _context2.stop();
	            }
	          }
	        }, _callee2, this);
	      }));

	      function add2basketRows(_x3) {
	        return _add2basketRows.apply(this, arguments);
	      }

	      return add2basketRows;
	    }()
	  }]);
	  return CatalogSection;
	}(B2BPortal.Components.TableFilter);

	exports.CatalogSection = CatalogSection;

}((this.B2BPortal.Components = this.B2BPortal.Components || {})));
//# sourceMappingURL=component.js.map
