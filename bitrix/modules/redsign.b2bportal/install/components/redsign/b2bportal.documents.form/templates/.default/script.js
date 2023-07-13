this.B2BPortal = this.B2BPortal || {};
(function (exports) {
	'use strict';

	var _id = 0;
	BX.Vue.component('bx-b2bportal-documents-edit-form', {
	  props: {
	    form: {
	      default: 'new'
	    },
	    userId: {
	      default: 0
	    },
	    orderId: {
	      default: 0
	    },
	    siteId: {
	      default: ''
	    },
	    filledValues: {
	      type: Object,
	      default: function _default() {
	        return {
	          id: '',
	          userId: '',
	          orderId: '',
	          name: '',
	          type: '',
	          gen: ''
	        };
	      }
	    },
	    propsValues: {
	      type: Object,
	      default: function _default() {
	        return {
	          TYPE: [],
	          GEN: []
	        };
	      }
	    }
	  },
	  data: function data() {
	    return {
	      id: 0,
	      iSiteId: this.siteId || this.propsValues['SITES'][0]['LID'],
	      useGen: !!this.filledValues.gen,
	      values: {
	        userId: this.userId || this.filledValues.userId,
	        orderId: this.orderId || this.filledValues.orderId,
	        name: this.filledValues.name,
	        type: this.filledValues.type,
	        gen: this.filledValues.gen,
	        fileName: this.filledValues.fileName || '',
	        filePath: this.filledValues.filePath
	      }
	    };
	  },
	  computed: {
	    localize: function localize() {
	      return BX.Vue.getFilteredPhrases('RS_B2B_DE_');
	    },
	    names: function names() {
	      return Object.freeze({
	        orderId: 'DOC_ORDER_ID',
	        userId: 'DOC_USER_ID',
	        name: 'DOC_NAME',
	        type: 'DOC_TYPE',
	        gen: 'DOC_GEN_TYPE',
	        file: 'DOC_FILE'
	      });
	    },
	    ids: function ids() {
	      return Object.freeze({
	        orderId: 'DOC_ORDER_ID_' + this.id,
	        userId: 'DOC_USER_UD_' + this.userId,
	        name: 'DOC_NAME_' + this.id,
	        type: 'DOC_NAME_TYPE_' + this.id,
	        gen: 'DOC_GEN_' + this.id,
	        file: 'DOC_FILE_' + this.id
	      });
	    },
	    details: function details() {
	      return {
	        order: {
	          link: '/bitrix/admin/sale_order_view.php?ID=' + this.values.orderId,
	          text: this.localize.RS_B2B_DE_ORDER_PATTERN.replace('#ORDER_ID#', this.values.orderId)
	        },
	        user: {
	          link: '/bitrix/admin/user_edit.php?lang=ru&ID=' + this.values.userId,
	          text: this.values.userId
	        }
	      };
	    },
	    sites: function sites() {
	      return this.propsValues['SITES'];
	    },
	    types: function types() {
	      return this.propsValues['TYPES'][this.iSiteId] || [];
	    },
	    genTypes: function genTypes() {
	      return this.propsValues['GEN_TYPES'][this.iSiteId] || [];
	    }
	  },
	  beforeCreated: function beforeCreated() {
	    this.id = (babelHelpers.readOnlyError("_id"), ++_id);
	  },
	  mounted: function mounted() {// if (!this.values.type)
	    // 	this.values.type = this.types[0] ? this.types[0].ID : this.values.type;
	  },
	  methods: {
	    onSelectedFile: function onSelectedFile(fileName) {
	      this.values.fileName = fileName.split("\\").pop().split('/').pop();
	      this.values.filePath = '';
	    }
	  },
	  template: "\n\t\t<div>\n\n\t\t\t<div class=\"rs-doc-form-field\">\n\t\t\t\t<label class=\"rs-doc-form-field__label\" :for=\"ids.siteId\">\n\t\t\t\t\t{{ localize.RS_B2B_DE_SITE_LABEL }}\n\t\t\t\t</label>\n\n\t\t\t\t<div class=\"ui-ctl ui-ctl-after-icon ui-ctl-dropdown\" :class=\"{'ui-ctl-disabled': !!siteId }\">\n\t\t\t\t\t<div class=\"ui-ctl-after ui-ctl-icon-angle\"></div>\n\t\t\t\t\t<select class=\"ui-ctl-element\" :name=\"names.siteId\" :id=\"ids.siteId\" :disabled=\"!!siteId\" v-model=\"iSiteId\">\n\t\t\t\t\t\t<option \n\t\t\t\t\t\t\tv-for=\"type in sites\" \n\t\t\t\t\t\t\t:key=\"type['LID']\"\n\t\t\t\t\t\t\t:value=\"type['LID']\"\n\t\t\t\t\t\t>\n\t\t\t\t\t\t\t{{ type['NAME'] }}\n\t\t\t\t\t\t</option>\n\t\t\t\t\t</select>\n\t\t\t\t</div>\n\t\t\t</div>\n\t\t\t\n\t\t\t<div class=\"rs-doc-form-two-field\">\n\t\t\t\t<div class=\"rs-doc-form-field\">\n\t\t\t\t\t<label class=\"rs-doc-form-field__label\" :for=\"ids.orderId\">\n\t\t\t\t\t\t{{ localize.RS_B2B_DE_ORDER_LABEL }}\n\t\t\t\t\t</label>\n\t\t\t\t\t<div class=\"ui-ctl ui-ctl-textbox ui-ctl-block ui-ctl-w100\" :class=\"{'ui-ctl-disabled': orderId || form === 'edit'}\">\n\t\t\t\t\t\t<input \n\t\t\t\t\t\t\ttype=\"text\"\n\t\t\t\t\t\t\t:id=\"ids.orderId\"\n\t\t\t\t\t\t\t:name=\"names.orderId\"\n\t\t\t\t\t\t\tv-model=\"values.orderId\"\n\t\t\t\t\t\t\t:placeholder=\"localize.RS_B2B_DE_ORDER_PLACEHOLDER\"\n\t\t\t\t\t\t\t:readonly=\"orderId || form === 'edit'\"\n\t\t\t\t\t\t\tclass=\"ui-ctl-element\"\n\t\t\t\t\t\t>\n\t\t\t\t\t</div>\n\t\t\t\t</div>\n\n\t\t\t\t<div class=\"rs-doc-form-field\">\n\t\t\t\t\t<label class=\"rs-doc-form-field__label\" :for=\"ids.userId\">\n\t\t\t\t\t\t{{ localize.RS_B2B_DE_USER_LABEL }}\n\t\t\t\t\t</label>\n\t\t\t\t\t<div class=\"ui-ctl ui-ctl-textbox ui-ctl-block ui-ctl-w100\" :class=\"{'ui-ctl-disabled': userId || form === 'edit'}\">\n\t\t\t\t\t\t<input \n\t\t\t\t\t\t\ttype=\"text\"\n\t\t\t\t\t\t\t:id=\"ids.userId\"\n\t\t\t\t\t\t\t:name=\"names.userId\" \n\t\t\t\t\t\t\tv-model=\"values.userId\"\n\t\t\t\t\t\t\t:placeholder=\"localize.RS_B2B_DE_USER_PLACEHOLDER\"\n\t\t\t\t\t\t\t:readonly=\"userId || form === 'edit'\"\n\t\t\t\t\t\t\tclass=\"ui-ctl-element\"\n\t\t\t\t\t\t>\n\t\t\t\t\t</div>\n\t\t\t\t</div>\n\t\t\t</div>\n\n\t\t\t<div class=\"rs-doc-form-field\">\n\t\t\t\t<label class=\"rs-doc-form-field__label\" :for=\"ids.name\">\n\t\t\t\t\t{{ localize.RS_B2B_DE_NAME_LABEL }}\n\t\t\t\t</label>\n\t\t\t\t<div class=\"ui-ctl ui-ctl-textbox ui-ctl-block\">\n\t\t\t\t\t<input \n\t\t\t\t\t\ttype=\"text\"\n\t\t\t\t\t\t:id=\"ids.name\"\n\t\t\t\t\t\t:name=\"names.name\"\n\t\t\t\t\t\tv-model=\"values.name\"\n\t\t\t\t\t\t:placeholder=\"localize.RS_B2B_DE_NAME_PLACEHOLDER\"\n\t\t\t\t\t\tclass=\"ui-ctl-element\" \n\t\t\t\t\t>\n\t\t\t\t</div>\n\t\t\t</div>\n\n\t\t\t<div class=\"rs-doc-form-field\">\n\t\t\t\t<label class=\"rs-doc-form-field__label\" :for=\"ids.type\">\n\t\t\t\t\t{{ localize.RS_B2B_DE_TYPE_LABEL }}\n\t\t\t\t</label>\n\t\t\t\t<div class=\"ui-ctl ui-ctl-after-icon ui-ctl-dropdown\">\n\t\t\t\t\t<div class=\"ui-ctl-after ui-ctl-icon-angle\"></div>\n\t\t\t\t\t\t<select class=\"ui-ctl-element\" :name=\"names.type\" :id=\"ids.type\" v-model=\"values.type\">\n\t\t\t\t\t\t\t<option \n\t\t\t\t\t\t\t\tv-for=\"type in types\" \n\t\t\t\t\t\t\t\t:key=\"type['ID']\"\n\t\t\t\t\t\t\t\t:value=\"type['ID']\"\n\t\t\t\t\t\t>\n\t\t\t\t\t\t\t{{ type['VALUE'] }}\n\t\t\t\t\t\t</option>\n\t\t\t\t\t</select>\n\t\t\t\t</div>\n\t\t\t</div>\n\n\t\t\t<div class=\"rs-doc-form-field\">\n\t\t\t\t<label class=\"ui-ctl ui-ctl-checkbox\">\n\t\t\t\t\t<input type=\"checkbox\" class=\"ui-ctl-element\" v-model=\"useGen\">\n\t\t\t\t\t<div class=\"ui-ctl-label-text\">{{ localize.RS_B2B_DE_USE_GEN_LABEL }}</div>\n\t\t\t\t</label>\n\t\t\t</div>\n\n\t\t\t<div class=\"rs-doc-form-field\" v-if=\"useGen\">\n\t\t\t\t<label class=\"rs-doc-form-field__label\" :for=\"ids.gen\">\n\t\t\t\t\t{{ localize.RS_B2B_DE_GEN_LABEL }}\n\t\t\t\t</label>\n\n\t\t\t\t<div class=\"ui-ctl ui-ctl-after-icon ui-ctl-dropdown\">\n\t\t\t\t\t<div class=\"ui-ctl-after ui-ctl-icon-angle\"></div>\n\t\t\t\t\t\t<select class=\"ui-ctl-element\" :name=\"names.gen\" :id=\"ids.gen\" v-model=\"values.gen\">\n\t\t\t\t\t\t\t<option \n\t\t\t\t\t\t\t\tv-for=\"type in genTypes\" \n\t\t\t\t\t\t\t\t:key=\"type['ID']\"\n\t\t\t\t\t\t\t\t:value=\"type['ID']\"\n\t\t\t\t\t\t>\n\t\t\t\t\t\t\t[{{ type['XML_ID'] }}] {{ type['VALUE'] }}\n\t\t\t\t\t\t</option>\n\t\t\t\t\t</select>\n\t\t\t\t</div>\n\t\t\t</div>\n\t\t\t<div class=\"rs-doc-form-field\" v-else>\n\t\t\t\t<label class=\"ui-ctl ui-ctl-file-btn\">\n\t\t\t\t\t<input type=\"file\" class=\"ui-ctl-element\" @change=\"onSelectedFile($event.target.value)\" :name=\"names.file\">\n\t\t\t\t\t<div class=\"ui-ctl-label-text\">{{ localize.RS_B2B_DE_FILE_LABEL }}</div>\n\t\t\t\t</label>\n\t\t\t\t<span v-if=\"values.filePath\">\n\t\t\t\t\t<a :href=\"values.filePath\" target=\"_blank\">{{ values.fileName }}</a>\n\t\t\t\t</span>\n\t\t\t\t<span v-else>\n\t\t\t\t\t{{ values.fileName }}\n\t\t\t\t</span>\n\t\t\t</div>\n\t\t</div>\n\t"
	});

	var DocumentsEditForm = /*#__PURE__*/function () {
	  function DocumentsEditForm(el, params) {
	    babelHelpers.classCallCheck(this, DocumentsEditForm);
	    this.el = el;
	    this.params = params;
	    this.useGrid();
	    this.attachTemplate();
	    console.log('init');
	  }

	  babelHelpers.createClass(DocumentsEditForm, [{
	    key: "useGrid",
	    value: function useGrid() {
	      var globalBX = (window.parent || window).BX;
	      var grid = globalBX.Main.gridManager ? globalBX.Main.gridManager.getInstanceById('document_list') : false;
	      if (grid) this.onGridReady(grid);else BX.addCustomEvent('Grid::ready', this.onGridReady.bind(this));
	    }
	  }, {
	    key: "onGridReady",
	    value: function onGridReady(grid) {
	      var _this = this;

	      if (grid.getContainerId() !== 'document_list') return;
	      this.grid = grid;
	      BX.addCustomEvent('SidePanel.Slider:onReload', function (e) {
	        _this.grid.reloadTable('POST', {});
	      });
	    }
	  }, {
	    key: "attachTemplate",
	    value: function attachTemplate() {
	      var _this$params = this.params,
	          form = _this$params.form,
	          siteId = _this$params.siteId,
	          orderId = _this$params.orderId,
	          userId = _this$params.userId,
	          filledValues = _this$params.filledValues,
	          propsValues = _this$params.propsValues;
	      this.template = BX.Vue.create({
	        el: this.el,
	        data: {
	          form: form,
	          siteId: siteId,
	          orderId: orderId,
	          userId: userId,
	          filledValues: filledValues,
	          propsValues: propsValues
	        },
	        template: "\n\t\t\t\t<bx-b2bportal-documents-edit-form \n\t\t\t\t\t:form=\"form\"\n\t\t\t\t\t:siteId=\"siteId\"\n\t\t\t\t\t:orderId=\"orderId\"\n\t\t\t\t\t:userId=\"userId\" \n\t\t\t\t\t:filledValues=\"filledValues\"\n\t\t\t\t\t:propsValues=\"propsValues\"\n\t\t\t\t/>\n\t\t\t"
	      });
	    }
	  }]);
	  return DocumentsEditForm;
	}();

	exports.DocumentsEditForm = DocumentsEditForm;

}((this.B2BPortal.Components = this.B2BPortal.Components || {})));
//# sourceMappingURL=script.js.map
