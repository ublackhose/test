const _id = 0;

BX.Vue.component('bx-b2bportal-documents-edit-form', {

	props: {
		form: { default: 'new' },
		userId: { default: 0 },
		orderId: { default: 0 },
		siteId: { default: '' },
		filledValues: {
			type: Object,
			default: () => ({
				id: '',
				userId: '',
				orderId: '',
				name: '',
				type: '',
				gen: ''
			})
		},
		propsValues: {
			type: Object,
			default: () => ({
				TYPE: [],
				GEN: []
			})
		}
	},

	data()
	{
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
		}
	},
	computed: {
		localize()
		{
			return BX.Vue.getFilteredPhrases('RS_B2B_DE_');
		},

		names()
		{
			return Object.freeze({
				orderId: 'DOC_ORDER_ID',
				userId: 'DOC_USER_ID',
				name: 'DOC_NAME',
				type: 'DOC_TYPE',
				gen: 'DOC_GEN_TYPE',
				file: 'DOC_FILE'
			});
		},

		ids()
		{
			return Object.freeze({
				orderId: 'DOC_ORDER_ID_' + this.id,
				userId: 'DOC_USER_UD_' + this.userId,
				name: 'DOC_NAME_' + this.id,
				type: 'DOC_NAME_TYPE_' + this.id,
				gen: 'DOC_GEN_' + this.id,
				file: 'DOC_FILE_' + this.id
			});
		},

		details()
		{
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

		sites()
		{
			return this.propsValues['SITES'];
		},

		types()
		{
			return this.propsValues['TYPES'][this.iSiteId] || [];
		},

		genTypes()
		{
			return this.propsValues['GEN_TYPES'][this.iSiteId] || [];
		}
	},

	beforeCreated()
	{
		this.id = ++_id;
	},

	mounted()
	{
		// if (!this.values.type)
		// 	this.values.type = this.types[0] ? this.types[0].ID : this.values.type;
	},

	methods: {
		onSelectedFile(fileName)
		{
			this.values.fileName = fileName.split("\\").pop().split('/').pop();
			this.values.filePath = '';
		}
	},

	template: `
		<div>

			<div class="rs-doc-form-field">
				<label class="rs-doc-form-field__label" :for="ids.siteId">
					{{ localize.RS_B2B_DE_SITE_LABEL }}
				</label>

				<div class="ui-ctl ui-ctl-after-icon ui-ctl-dropdown" :class="{'ui-ctl-disabled': !!siteId }">
					<div class="ui-ctl-after ui-ctl-icon-angle"></div>
					<select class="ui-ctl-element" :name="names.siteId" :id="ids.siteId" :disabled="!!siteId" v-model="iSiteId">
						<option 
							v-for="type in sites" 
							:key="type['LID']"
							:value="type['LID']"
						>
							{{ type['NAME'] }}
						</option>
					</select>
				</div>
			</div>
			
			<div class="rs-doc-form-two-field">
				<div class="rs-doc-form-field">
					<label class="rs-doc-form-field__label" :for="ids.orderId">
						{{ localize.RS_B2B_DE_ORDER_LABEL }}
					</label>
					<div class="ui-ctl ui-ctl-textbox ui-ctl-block ui-ctl-w100" :class="{'ui-ctl-disabled': orderId || form === 'edit'}">
						<input 
							type="text"
							:id="ids.orderId"
							:name="names.orderId"
							v-model="values.orderId"
							:placeholder="localize.RS_B2B_DE_ORDER_PLACEHOLDER"
							:readonly="orderId || form === 'edit'"
							class="ui-ctl-element"
						>
					</div>
				</div>

				<div class="rs-doc-form-field">
					<label class="rs-doc-form-field__label" :for="ids.userId">
						{{ localize.RS_B2B_DE_USER_LABEL }}
					</label>
					<div class="ui-ctl ui-ctl-textbox ui-ctl-block ui-ctl-w100" :class="{'ui-ctl-disabled': userId || form === 'edit'}">
						<input 
							type="text"
							:id="ids.userId"
							:name="names.userId" 
							v-model="values.userId"
							:placeholder="localize.RS_B2B_DE_USER_PLACEHOLDER"
							:readonly="userId || form === 'edit'"
							class="ui-ctl-element"
						>
					</div>
				</div>
			</div>

			<div class="rs-doc-form-field">
				<label class="rs-doc-form-field__label" :for="ids.name">
					{{ localize.RS_B2B_DE_NAME_LABEL }}
				</label>
				<div class="ui-ctl ui-ctl-textbox ui-ctl-block">
					<input 
						type="text"
						:id="ids.name"
						:name="names.name"
						v-model="values.name"
						:placeholder="localize.RS_B2B_DE_NAME_PLACEHOLDER"
						class="ui-ctl-element" 
					>
				</div>
			</div>

			<div class="rs-doc-form-field">
				<label class="rs-doc-form-field__label" :for="ids.type">
					{{ localize.RS_B2B_DE_TYPE_LABEL }}
				</label>
				<div class="ui-ctl ui-ctl-after-icon ui-ctl-dropdown">
					<div class="ui-ctl-after ui-ctl-icon-angle"></div>
						<select class="ui-ctl-element" :name="names.type" :id="ids.type" v-model="values.type">
							<option 
								v-for="type in types" 
								:key="type['ID']"
								:value="type['ID']"
						>
							{{ type['VALUE'] }}
						</option>
					</select>
				</div>
			</div>

			<div class="rs-doc-form-field">
				<label class="ui-ctl ui-ctl-checkbox">
					<input type="checkbox" class="ui-ctl-element" v-model="useGen">
					<div class="ui-ctl-label-text">{{ localize.RS_B2B_DE_USE_GEN_LABEL }}</div>
				</label>
			</div>

			<div class="rs-doc-form-field" v-if="useGen">
				<label class="rs-doc-form-field__label" :for="ids.gen">
					{{ localize.RS_B2B_DE_GEN_LABEL }}
				</label>

				<div class="ui-ctl ui-ctl-after-icon ui-ctl-dropdown">
					<div class="ui-ctl-after ui-ctl-icon-angle"></div>
						<select class="ui-ctl-element" :name="names.gen" :id="ids.gen" v-model="values.gen">
							<option 
								v-for="type in genTypes" 
								:key="type['ID']"
								:value="type['ID']"
						>
							[{{ type['XML_ID'] }}] {{ type['VALUE'] }}
						</option>
					</select>
				</div>
			</div>
			<div class="rs-doc-form-field" v-else>
				<label class="ui-ctl ui-ctl-file-btn">
					<input type="file" class="ui-ctl-element" @change="onSelectedFile($event.target.value)" :name="names.file">
					<div class="ui-ctl-label-text">{{ localize.RS_B2B_DE_FILE_LABEL }}</div>
				</label>
				<span v-if="values.filePath">
					<a :href="values.filePath" target="_blank">{{ values.fileName }}</a>
				</span>
				<span v-else>
					{{ values.fileName }}
				</span>
			</div>
		</div>
	`

});

{/* <div class="rs-doc-form-field" v-if="orderId">
				<input name="DOC_ORDER_ID" type="hidden" :value="orderId"> 
				<label class="rs-doc-form-field__label">
					{{ localize.RS_B2B_DE_ORDER_LABEL }}
					<a :href="orderDetail.link" target="_blank">{{ orderDetail.text }}</a>
				</label>
			</div>
			<div class="rs-doc-form-field" v-else>
				<label class="rs-doc-form-field__label">
					{{ localize.RS_B2B_DE_ORDER_LABEL }}
				</label>
				<div class="ui-ctl ui-ctl-textbox ui-ctl-block">
					<input type="text" class="ui-ctl-element" :placeholder="localize.RS_B2B_DE_ORDER_PLACEHOLDER">
				</div>
			</div> */}