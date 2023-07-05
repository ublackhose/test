this.B2BPortal = this.B2BPortal || {};
(function (exports) {
    'use strict';

    function action(_x, _x2) {
        return _action.apply(this, arguments);
    }

    function _action() {
        _action = babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee(actionName, data) {
            var resultData, result;
            return regeneratorRuntime.wrap(function _callee$(_context) {
                while (1) {
                    switch (_context.prev = _context.next) {
                        case 0:
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
                            result = _context.sent;
                            resultData = result.data;
                            _context.next = 12;
                            break;

                        case 8:
                            _context.prev = 8;
                            _context.t0 = _context["catch"](1);
                            global.toastr.error(((_context.t0.errors || [])[0] || {}).message);
                            throw _context.t0;

                        case 12:
                            return _context.abrupt("return", resultData);

                        case 13:
                        case "end":
                            return _context.stop();
                    }
                }
            }, _callee, null, [[1, 8]]);
        }));
        return _action.apply(this, arguments);
    }

    function checkExistsCodes(_x3) {
        return _checkExistsCodes.apply(this, arguments);
    }

    function _checkExistsCodes() {
        _checkExistsCodes = babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee2(data) {
            return regeneratorRuntime.wrap(function _callee2$(_context2) {
                while (1) {
                    switch (_context2.prev = _context2.next) {
                        case 0:
                            return _context2.abrupt("return", action('check', data));

                        case 1:
                        case "end":
                            return _context2.stop();
                    }
                }
            }, _callee2);
        }));
        return _checkExistsCodes.apply(this, arguments);
    }

    function addtobasket(_x4) {
        return _addtobasket.apply(this, arguments);
    }

    function _addtobasket() {
        _addtobasket = babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee3(data) {
            return regeneratorRuntime.wrap(function _callee3$(_context3) {
                while (1) {
                    switch (_context3.prev = _context3.next) {
                        case 0:
                            return _context3.abrupt("return", action('addtobasket', data).then(function (result) {
                                BX.onCustomEvent('updateBasketComponent');
                                return result;
                            }));

                        case 1:
                        case "end":
                            return _context3.stop();
                    }
                }
            }, _callee3);
        }));
        return _addtobasket.apply(this, arguments);
    }

    /**
     * The base implementation of `_.propertyOf` without support for deep paths.
     *
     * @private
     * @param {Object} object The object to query.
     * @returns {Function} Returns the new accessor function.
     */
    function basePropertyOf(object) {
        return function (key) {
            return object == null ? undefined : object[key];
        };
    }

    var _basePropertyOf = basePropertyOf;

    /** Used to map characters to HTML entities. */

    var htmlEscapes = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
    };
    /**
     * Used by `_.escape` to convert characters to HTML entities.
     *
     * @private
     * @param {string} chr The matched character to escape.
     * @returns {string} Returns the escaped character.
     */

    var escapeHtmlChar = _basePropertyOf(htmlEscapes);
    var _escapeHtmlChar = escapeHtmlChar;

    var commonjsGlobal = typeof window !== 'undefined' ? window : typeof global !== 'undefined' ? global : typeof self !== 'undefined' ? self : {};

    /** Detect free variable `global` from Node.js. */

    var freeGlobal = babelHelpers.typeof(commonjsGlobal) == 'object' && commonjsGlobal && commonjsGlobal.Object === Object && commonjsGlobal;
    var _freeGlobal = freeGlobal;

    /** Detect free variable `self`. */

    var freeSelf = (typeof self === "undefined" ? "undefined" : babelHelpers.typeof(self)) == 'object' && self && self.Object === Object && self;
    /** Used as a reference to the global object. */

    var root = _freeGlobal || freeSelf || Function('return this')();
    var _root = root;

    /** Built-in value references. */

    var _Symbol2 = _root.Symbol;
    var _Symbol = _Symbol2;

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
        } catch (e) {
        }

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
        return value != null && babelHelpers.typeof(value) == 'object';
    }

    var isObjectLike_1 = isObjectLike;

    /** `Object#toString` result references. */

    var symbolTag = '[object Symbol]';

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
        return babelHelpers.typeof(value) == 'symbol' || isObjectLike_1(value) && _baseGetTag(value) == symbolTag;
    }

    var isSymbol_1 = isSymbol;

    /** Used as references for various `Number` constants. */

    var INFINITY = 1 / 0;
    /** Used to convert symbols to primitives and strings. */

    var symbolProto = _Symbol ? _Symbol.prototype : undefined,
        symbolToString = symbolProto ? symbolProto.toString : undefined;

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

    /** Used to match HTML entities and HTML characters. */

    var reUnescapedHtml = /[&<>"']/g,
        reHasUnescapedHtml = RegExp(reUnescapedHtml.source);

    /**
     * Converts the characters "&", "<", ">", '"', and "'" in `string` to their
     * corresponding HTML entities.
     *
     * **Note:** No other characters are escaped. To escape additional
     * characters use a third-party library like [_he_](https://mths.be/he).
     *
     * Though the ">" character is escaped for symmetry, characters like
     * ">" and "/" don't need escaping in HTML and have no special meaning
     * unless they're part of a tag or unquoted attribute value. See
     * [Mathias Bynens's article](https://mathiasbynens.be/notes/ambiguous-ampersands)
     * (under "semi-related fun fact") for more details.
     *
     * When working with HTML you should always
     * [quote attribute values](http://wonko.com/post/html-escaping) to reduce
     * XSS vectors.
     *
     * @static
     * @since 0.1.0
     * @memberOf _
     * @category String
     * @param {string} [string=''] The string to escape.
     * @returns {string} Returns the escaped string.
     * @example
     *
     * _.escape('fred, barney, & pebbles');
     * // => 'fred, barney, &amp; pebbles'
     */

    function escape(string) {
        string = toString_1(string);
        return string && reHasUnescapedHtml.test(string) ? string.replace(reUnescapedHtml, _escapeHtmlChar) : string;
    }

    var _escape = escape;

    function _createForOfIteratorHelper(o, allowArrayLike) {
        var it;
        if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) {
            if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") {
                if (it) o = it;
                var i = 0;
                var F = function F() {
                };
                return {
                    s: F, n: function n() {
                        if (i >= o.length) return {done: true};
                        return {done: false, value: o[i++]};
                    }, e: function e(_e) {
                        throw _e;
                    }, f: F
                };
            }
            throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
        }
        var normalCompletion = true, didErr = false, err;
        return {
            s: function s() {
                it = o[Symbol.iterator]();
            }, n: function n() {
                var step = it.next();
                normalCompletion = step.done;
                return step;
            }, e: function e(_e2) {
                didErr = true;
                err = _e2;
            }, f: function f() {
                try {
                    if (!normalCompletion && it.return != null) it.return();
                } finally {
                    if (didErr) throw err;
                }
            }
        };
    }

    function _unsupportedIterableToArray(o, minLen) {
        if (!o) return;
        if (typeof o === "string") return _arrayLikeToArray(o, minLen);
        var n = Object.prototype.toString.call(o).slice(8, -1);
        if (n === "Object" && o.constructor) n = o.constructor.name;
        if (n === "Map" || n === "Set") return Array.from(o);
        if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
    }

    function _arrayLikeToArray(arr, len) {
        if (len == null || len > arr.length) len = arr.length;
        for (var i = 0, arr2 = new Array(len); i < len; i++) {
            arr2[i] = arr[i];
        }
        return arr2;
    }

    var DEFAULT_ADDTOBASKET_QUANTITY = 1;
    var script = {
        props: {
            signedParameters: {
                type: String,
                default: ''
            }
        },
        data: function data() {
            return {
                content: '',
                displayContent: '',
                checkedCodes: {}
            };
        },
        computed: {
            messages: function messages() {
                return Object.freeze(Object.keys(BX.message).filter(function (message) {
                    return message.startsWith('RS_B2BPORTAL_BI');
                }).reduce(function (obj, message) {
                    obj[message.slice(message)] = BX.message(message);
                    return obj;
                }, {}));
            },
            codes: function codes() {
                return this.content.split('\n').map(function (codeValue) {
                    return codeValue.trim();
                }).filter(function (codeValue) {
                    return codeValue !== '';
                });
            }
        },
        mounted: function mounted() {
            this.$refs.editor.addEventListener("paste", function (e) {
                e.preventDefault();
                var text = '';

                if (typeof (e.originalEvent || e).clipboardData === 'undefined') {
                    text = window.clipboardData.getData('Text');
                } else {
                    text = (e.originalEvent || e).clipboardData.getData('text/plain');
                }

                if (document.queryCommandSupported('insertHTML')) {
                    text = text.replace(/\r?\n/g, '<br>');
                    document.execCommand("insertHTML", false, text);
                } else {
                    document.execCommand("paste", false, text);
                }
            });
            this.$refs.editor.addEventListener('input', function (e) {
                if (e.target.textContent) {
                    e.target.dataset.divPlaceholderContent = 'true';
                } else {
                    delete e.target.dataset.divPlaceholderContent;
                }
            });
        },
        methods: {
            handleInput: function handleInput(e) {
                var selection = document.getSelection();
                var selNode = selection.anchorNode;

                if (selNode.nodeType == Node.TEXT_NODE && selNode.parentNode.tagName != 'CODE') {
                    selNode.parentNode.setAttribute('class', '');
                }

                this.content = e.target.innerText;
            },
            handleBlur: function handleBlur(e) {
                this.check();
            },
            check: function check() {
                var _this = this;

                return babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee() {
                    var newCodes, foundCodes;
                    return regeneratorRuntime.wrap(function _callee$(_context) {
                        while (1) {
                            switch (_context.prev = _context.next) {
                                case 0:
                                    newCodes = _this.codes.filter(function (code) {
                                        return !_this.checkedCodes.hasOwnProperty(code);
                                    });

                                    if (!(newCodes.length > 0)) {
                                        _context.next = 6;
                                        break;
                                    }

                                    _context.next = 4;
                                    return checkExistsCodes({
                                        codes: newCodes,
                                        signedParameters: _this.signedParameters
                                    });

                                case 4:
                                    foundCodes = _context.sent;
                                    newCodes.forEach(function (codeValue) {
                                        _this.checkedCodes[codeValue] = foundCodes.includes(codeValue);
                                    });

                                case 6:
                                    _this.updateDisplayContent();

                                case 7:
                                case "end":
                                    return _context.stop();
                            }
                        }
                    }, _callee);
                }))();
            },
            updateDisplayContent: function updateDisplayContent() {
                var html = '';

                var _iterator = _createForOfIteratorHelper(this.codes),
                    _step;

                try {
                    for (_iterator.s(); !(_step = _iterator.n()).done;) {
                        var code = _step.value;
                        var isFound = !!this.checkedCodes[code];
                        html += '<div class="' + (isFound ? 'text-success' : 'text-danger') + '">' + _escape(code) + ' ' + '</div>';
                    }
                } catch (err) {
                    _iterator.e(err);
                } finally {
                    _iterator.f();
                }

                this.displayContent = html;
            },
            removeCodeFromContent: function removeCodeFromContent(code) {
                this.content = this.content.replace(new RegExp('^.*' + code + '.*$', 'mg'), '').replace('\n\r?', '');
            },
            prepareData: function prepareData() {
                var data = {};

                var _iterator2 = _createForOfIteratorHelper(this.codes),
                    _step2;

                try {
                    for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
                        var code = _step2.value;
                        data[code] = DEFAULT_ADDTOBASKET_QUANTITY;
                    }
                } catch (err) {
                    _iterator2.e(err);
                } finally {
                    _iterator2.f();
                }

                return data;
            },
            addtobasket: function addtobasket$$1() {
                var _this2 = this;


                return babelHelpers.asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee2() {
                    var result, i;
                    return regeneratorRuntime.wrap(function _callee2$(_context2) {
                        while (1) {
                            switch (_context2.prev = _context2.next) {
                                case 0:
                                    if (_this2.codes.length) {
                                        _context2.next = 2;
                                        break;
                                    }

                                    return _context2.abrupt("return");

                                case 2:
                                    KTApp.block(document.querySelector('.modal.show'));
                                    _context2.next = 5;

                                    return addtobasket({
                                        data: _this2.prepareData(),
                                        signedParameters: _this2.signedParameters
                                    });

                                case 5:
                                    console.log(3);
                                    result = _context2.sent;
                                    _context2.t0 = regeneratorRuntime.keys(result);

                                case 7:
                                    console.log(4);
                                    if ((_context2.t1 = _context2.t0()).done) {
                                        _context2.next = 14;
                                        break;
                                    }

                                    i = _context2.t1.value;

                                    if (result.hasOwnProperty(i)) {
                                        _context2.next = 11;
                                        break;
                                    }

                                    return _context2.abrupt("continue", 7);

                                case 11:
                                    console.log(5);
                                    if (result[i].isSuccess) {
                                        toastr.success("".concat(i, ": ").concat(result[i].message));

                                        _this2.removeCodeFromContent(result[i].code);
                                    } else {
                                        window.toastr.error("".concat(i, ": ").concat(result[i].message));
                                    }

                                    _context2.next = 7;
                                    break;

                                case 14:
                                    console.log(6);
                                    KTApp.unblock(document.querySelector('.modal.show'));

                                    _this2.updateDisplayContent();

                                    _this2.$store.dispatch('cart/fetch');

                                case 17:
                                    console.log(7);
                                case "end":
                                    return _context2.stop();
                            }
                        }

                    }, _callee2);
                }))();
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
                if (nodes.length) style.element.insertBefore(textNode, nodes[index]); else style.element.appendChild(textNode);
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

        return _c("div", [_c("code", {
            ref: "editor",
            staticClass: "form-control",
            staticStyle: {
                "min-height": "200px",
                overflow: "auto"
            },
            attrs: {
                contenteditable: "true",
                "data-placeholder": _vm.messages.RS_B2BPORTAL_BI_CATALOG_PLACEHOLDER
            },
            domProps: {
                innerHTML: _vm._s(_vm.displayContent)
            },
            on: {
                input: _vm.handleInput,
                blur: _vm.handleBlur
            }
        }), _vm._v(" "), _c("div", {
            staticClass: "mt-4 pull-right"
        }, [_c("button", {
            staticClass: "btn btn-outline-brand",
            attrs: {
                type: "button",
                "data-dismiss": "modal"
            }
        }, [_vm._v(_vm._s(_vm.messages.RS_B2BPORTAL_BI_MODAL_CANCEL))]), _vm._v(" "), _c("button", {
            staticClass: "btn btn-primary",
            attrs: {
                type: "button"
            },
            on: {
                click: _vm.addtobasket
            }
        }, [_vm._v(_vm._s(_vm.messages.RS_B2BPORTAL_BI_MODAL_IMPORT) + " ")])])]);
    };

    var __vue_staticRenderFns__ = [];
    __vue_render__._withStripped = true;
    /* style */

    var __vue_inject_styles__ = function __vue_inject_styles__(inject) {
        if (!inject) return;
        inject("data-v-9315d5e8_0", {
            source: "code[data-placeholder][data-v-9315d5e8]:not(:focus):not([data-div-placeholder-content]):before {\n  content: attr(data-placeholder);\n  float: left;\n  margin-left: 2px;\n  color: #a1a8c3;\n  white-space: pre;\n}",
            map: undefined,
            media: undefined
        });
    };
    /* scoped */


    var __vue_scope_id__ = "data-v-9315d5e8";
    /* module identifier */

    var __vue_module_identifier__ = undefined;
    /* functional template */

    var __vue_is_functional_template__ = false;
    /* style inject SSR */

    var CodesImport = normalizeComponent_1({
        render: __vue_render__,
        staticRenderFns: __vue_staticRenderFns__
    }, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, browser, undefined);

    var _B2BPortal = B2BPortal,
        store = _B2BPortal.store;
    var BasketCodesImport = /*#__PURE__*/function () {
        function BasketCodesImport(params) {

            try {
                babelHelpers.classCallCheck(this, BasketCodesImport);
                this._params = params;
                this.el = params.el;
                this.signedParameters = params.signedParameters;
                this.init();
            } catch (err) {
                console.log(123);
            }

        }

        babelHelpers.createClass(BasketCodesImport, [{
            key: "init",
            value: function init() {
                var signedParameters = this.signedParameters;
                this.component = new Vue({
                    el: this.el,
                    components: {
                        CodesImport: CodesImport
                    },
                    template: "<CodesImport :signedParameters=\"signedParameters\" />",
                    store: store,
                    data: function data() {
                        return {
                            signedParameters: signedParameters
                        };
                    }
                });
            }
        }]);
        return BasketCodesImport;
    }();

    exports.BasketCodesImport = BasketCodesImport;

}((this.B2BPortal.Components = this.B2BPortal.Components || {})));
//# sourceMappingURL=CodesImport.js.map
