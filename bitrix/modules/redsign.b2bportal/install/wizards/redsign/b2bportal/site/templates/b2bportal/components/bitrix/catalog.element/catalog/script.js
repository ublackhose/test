(function (exports) {
	'use strict';

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
	//
	//
	//
	//
	//
	var script = {
	  name: 'VuePhotoSwipe',
	  props: {
	    galleryUID: {
	      type: Number,
	      default: 1
	    },
	    index: {
	      type: Number,
	      default: 0
	    },
	    items: {
	      type: Array,
	      default: function _default() {
	        return [];
	      }
	    }
	  },
	  mounted: function mounted() {
	    var _this = this;

	    var options = {
	      index: this.index,
	      galleryUID: this.galleryUID
	    };
	    this.instance = new PhotoSwipe(this.$refs.template, PhotoSwipeUI_Default, this.items, options);
	    this.instance.init();
	    this.instance.listen('close', function () {
	      _this.$emit('close');
	    });
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

	/* script */
	var __vue_script__ = script;
	/* template */

	var __vue_render__ = function __vue_render__() {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", {
	    ref: "template",
	    staticClass: "pswp",
	    attrs: {
	      tabindex: "-1",
	      role: "dialog",
	      "aria-hidden": "true"
	    }
	  }, [_c("div", {
	    staticClass: "pswp__bg"
	  }), _vm._v(" "), _vm._m(0)]);
	};

	var __vue_staticRenderFns__ = [function () {
	  var _vm = this;

	  var _h = _vm.$createElement;

	  var _c = _vm._self._c || _h;

	  return _c("div", {
	    staticClass: "pswp__scroll-wrap"
	  }, [_c("div", {
	    staticClass: "pswp__container"
	  }, [_c("div", {
	    staticClass: "pswp__item"
	  }), _vm._v(" "), _c("div", {
	    staticClass: "pswp__item"
	  }), _vm._v(" "), _c("div", {
	    staticClass: "pswp__item"
	  })]), _vm._v(" "), _c("div", {
	    staticClass: "pswp__ui pswp__ui--hidden"
	  }, [_c("div", {
	    staticClass: "pswp__top-bar"
	  }, [_c("div", {
	    staticClass: "pswp__counter"
	  }), _vm._v(" "), _c("button", {
	    staticClass: "pswp__button pswp__button--close",
	    attrs: {
	      title: "Close (Esc)"
	    }
	  }), _vm._v(" "), _c("button", {
	    staticClass: "pswp__button pswp__button--share",
	    attrs: {
	      title: "Share"
	    }
	  }), _vm._v(" "), _c("button", {
	    staticClass: "pswp__button pswp__button--fs",
	    attrs: {
	      title: "Toggle fullscreen"
	    }
	  }), _vm._v(" "), _c("button", {
	    staticClass: "pswp__button pswp__button--zoom",
	    attrs: {
	      title: "Zoom in/out"
	    }
	  }), _vm._v(" "), _c("div", {
	    staticClass: "pswp__preloader"
	  }, [_c("div", {
	    staticClass: "pswp__preloader__icn"
	  }, [_c("div", {
	    staticClass: "pswp__preloader__cut"
	  }, [_c("div", {
	    staticClass: "pswp__preloader__donut"
	  })])])])]), _vm._v(" "), _c("div", {
	    staticClass: "pswp__share-modal pswp__share-modal--hidden pswp__single-tap"
	  }, [_c("div", {
	    staticClass: "pswp__share-tooltip"
	  })]), _vm._v(" "), _c("button", {
	    staticClass: "pswp__button pswp__button--arrow--left",
	    attrs: {
	      title: "Previous (arrow left)"
	    }
	  }), _vm._v(" "), _c("button", {
	    staticClass: "pswp__button pswp__button--arrow--right",
	    attrs: {
	      title: "Next (arrow right)"
	    }
	  }), _vm._v(" "), _c("div", {
	    staticClass: "pswp__caption"
	  }, [_c("div", {
	    staticClass: "pswp__caption__center"
	  })])])]);
	}];
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

	var VuePhotoSwipe = normalizeComponent_1({
	  render: __vue_render__,
	  staticRenderFns: __vue_staticRenderFns__
	}, __vue_inject_styles__, __vue_script__, __vue_scope_id__, __vue_is_functional_template__, __vue_module_identifier__, undefined, undefined);

	function parseHashVars() {
	  var hash = window.location.hash.substring(1);
	  var vars = hash.split('&');
	  return vars.reduce(function (params, s) {
	    var pair = s.split('=');
	    if (pair.length >= 2) params[pair[0]] = pair[1];
	    return params;
	  }, {});
	}

	//
	var script$1 = {
	  props: {
	    startIndex: {
	      type: Number,
	      default: 0
	    },
	    items: {
	      type: Array,
	      default: function _default() {
	        return [];
	      }
	    }
	  },
	  data: function data() {
	    return {
	      activeIndex: this.startIndex
	    };
	  },
	  computed: {
	    activeItem: function activeItem() {
	      return this.items[this.activeIndex] || this.items[0];
	    },
	    photoSwipeItems: function photoSwipeItems() {
	      return this.items.map(function (item) {
	        switch (item.type) {
	          case 'iframe_video':
	            return {
	              html: "\n\t\t\t\t\t\t\t\t\t<div class=\"pswp-video-wrapper\">\n\t\t\t\t\t\t\t\t\t\t<div class=\"embed-responsive embed-responsive-4by3\">\n\t\t\t\t\t\t\t\t\t\t\t<iframe src=\"".concat(item.src, "\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>\n\t\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t")
	            };

	          case 'video':
	            return {
	              html: "\n\t\t\t\t\t\t\t\t\t<div class=\"pswp-video-wrapper\">\n\t\t\t\t\t\t\t\t\t\t<div class=\"embed-responsive embed-responsive-4by3\">\n\t\t\t\t\t\t\t\t\t\t\t<video autoplay=\"true\" muted=\"false\" controls>\n\t\t\t\t\t\t\t\t\t\t\t\t<source src=\"".concat(item.src, "\">\n\t\t\t\t\t\t\t\t\t\t\t</video>\n\t\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t")
	            };

	          case 'image':
	            return babelHelpers.objectSpread({}, item);
	        }

	        return false;
	      }).filter(function (item) {
	        return !!item;
	      });
	    }
	  },
	  mounted: function mounted() {
	    var _this = this;

	    var hashParams = parseHashVars();

	    if (hashParams.gid && hashParams.gid == this._uid) {
	      var pid = parseInt(hashParams.pid, 10) - 1;
	      this.$nextTick(function () {
	        _this.openPhotoSwipe(pid);
	      });
	    }
	  },
	  methods: {
	    activate: function activate(index) {
	      if (index === this.activeIndex) this.openPhotoSwipe(index);
	      this.activeIndex = index;
	    },
	    openPhotoSwipe: function openPhotoSwipe(index) {
	      var container = document.createElement('div');
	      document.body.appendChild(container);
	      var vuePhotoSwipe = new (Vue.extend(VuePhotoSwipe))({
	        propsData: {
	          index: index,
	          galleryUID: this._uid,
	          items: this.photoSwipeItems
	        }
	      });
	      vuePhotoSwipe.$mount(container);
	      vuePhotoSwipe.$on('close', function () {
	        vuePhotoSwipe.$destroy();
	        vuePhotoSwipe.$el.remove();
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

	  return _c("div", {
	    staticClass: "product-images"
	  }, [_vm.items.length ? [_vm.activeItem.type === "image" ? _c("div", {
	    staticClass: "product-images-canvas mb-4"
	  }, [_c("img", {
	    staticClass: "img-fluid product-images-main",
	    attrs: {
	      src: _vm.activeItem.src
	    },
	    on: {
	      click: function click($event) {
	        return _vm.openPhotoSwipe(_vm.activeIndex);
	      }
	    }
	  })]) : _vm._e(), _vm._v(" "), _vm.activeItem.type === "iframe_video" ? _c("div", {
	    staticClass: "embed-responsive embed-responsive-4by3 mb-4"
	  }, [_c("iframe", {
	    attrs: {
	      src: _vm.activeItem.src,
	      frameborder: "0",
	      allow: "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture",
	      allowfullscreen: ""
	    }
	  })]) : _vm._e(), _vm._v(" "), _vm.activeItem.type === "video" ? _c("div", {
	    staticClass: "embed-responsive embed-responsive-4by3 mb-4"
	  }, [_c("video", {
	    attrs: {
	      autoplay: "true",
	      muted: "false",
	      controls: ""
	    },
	    domProps: {
	      muted: true
	    }
	  }, [_c("source", {
	    attrs: {
	      src: _vm.activeItem.src
	    }
	  })])]) : _vm._e(), _vm._v(" "), _vm.items.length > 1 ? _c("div", {
	    staticClass: "product-images-thumbs"
	  }, _vm._l(_vm.items, function (item, index) {
	    return _c("button", {
	      key: index,
	      staticClass: "product-images-thumb",
	      class: {
	        active: _vm.activeIndex === index
	      },
	      style: {
	        "background-image": "url( " + item.thumbnail + ")"
	      },
	      on: {
	        click: function click($event) {
	          return _vm.activate(index);
	        }
	      }
	    }, [item.type === "video" || item.type === "iframe_video" ? _c("span", {
	      staticClass: "product-images-thumb-video"
	    }, [_c("span", {
	      staticClass: "product-images-thumb-video-icon"
	    }, [_c("svg", {
	      attrs: {
	        xmlns: "http://www.w3.org/2000/svg",
	        height: "24",
	        viewBox: "0 0 24 24",
	        width: "24"
	      }
	    }, [_c("path", {
	      attrs: {
	        d: "M0 0h24v24H0z",
	        fill: "none"
	      }
	    }), _c("path", {
	      attrs: {
	        d: "M8 5v14l11-7z"
	      }
	    })])])]) : _vm._e()]);
	  }), 0) : _vm._e()] : _vm._e()], 2);
	};

	var __vue_staticRenderFns__$1 = [];
	__vue_render__$1._withStripped = true;
	/* style */

	var __vue_inject_styles__$1 = undefined;
	/* scoped */

	var __vue_scope_id__$1 = undefined;
	/* module identifier */

	var __vue_module_identifier__$1 = undefined;
	/* functional template */

	var __vue_is_functional_template__$1 = false;
	/* style inject */

	/* style inject SSR */

	var VueGallery = normalizeComponent_1({
	  render: __vue_render__$1,
	  staticRenderFns: __vue_staticRenderFns__$1
	}, __vue_inject_styles__$1, __vue_script__$1, __vue_scope_id__$1, __vue_is_functional_template__$1, __vue_module_identifier__$1, undefined, undefined);

	var CatalogElement = /*#__PURE__*/function () {
	  function CatalogElement() {
	    var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    babelHelpers.classCallCheck(this, CatalogElement);
	    this.blockIds = data.blockIds;
	    this.gallery = data.gallery;
	    this.attachGallery();
	  }

	  babelHelpers.createClass(CatalogElement, [{
	    key: "attachGallery",
	    value: function attachGallery() {
	      var el = document.getElementById(this.blockIds.gallery);
	      var items = (this.gallery || {}).items;
	      this.$gallery = new Vue({
	        el: el,
	        components: {
	          VueGallery: VueGallery
	        },
	        data: function data() {
	          return {
	            items: items
	          };
	        },
	        template: "<VueGallery :items=\"items\" />"
	      });
	    }
	  }]);
	  return CatalogElement;
	}();

	exports.CatalogElement = CatalogElement;

}((this.window = this.window || {})));
//# sourceMappingURL=script.js.map
