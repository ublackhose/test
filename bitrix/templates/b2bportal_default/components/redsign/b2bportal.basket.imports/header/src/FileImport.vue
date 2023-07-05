<template>

	<Stepper :steps="steps" :currentStep="currentStepIndex" @onStep="handleStep">

		<template v-slot:step1="step">

			<div class="form-group">

				{{messages.HEADER_RS_B2BPORTAL_BI_FILE_IMPORT_STEP_1 }}<br><br>
				<ul class="nav nav-pills mb-3">
					<li class="nav-item">
						<a 
							class="nav-link"
							:class="{active: method === 'upload'}"  
							href="#" 
							role="tab"
							@click.prevent="method = 'upload'">
							{{ messages.HEADER_RS_B2BPORTAL_BI_FILE_IMPORT_UPLOAD }}
						</a>
					</li>
					<li class="nav-item">
						<a 
							class="nav-link" 
							:class="{active: method === 'link'}" 
							href="#" 
							@click.prevent="method = 'link'">
							{{ messages.HEADER_RS_B2BPORTAL_BI_FILE_IMPORT_LINK}}
						</a>
					</li>
				</ul>

				<transition name="fade">
					<div>
						<div v-show="method === 'upload'">
							<label>{{ messages.HEADER_RS_B2BPORTAL_BI_FILE_IMPORT_SELECT_FILE }}</label>
							<div></div>
							<div class="custom-file">
								<input type="file" class="custom-file-input" ref="fileInput" @change.prevent="validateFileInput">
								<label class="custom-file-label" for="customFile" :data-browse="messages.HEADER_RS_B2BPORTAL_BI_BROWSE">{{ filePath }}</label>
							</div>
						</div>
						<div v-show="method === 'link'">
							
							<div class="form-group">
								<label> {{ messages.HEADER_RS_B2BPORTAL_BI_FILE_IMPORT_DOCUMENT_LINK }} </label>
								<input type="text" class="form-control" placeholder="https://example.com/file.csv" v-model="filePath">
							</div>

						</div>
					</div>
				</transition>
			</div>

			<a class="btn btn-primary pull-right" @click.prevent.stop="next(step)" href="#"> {{messages.HEADER_RS_B2BPORTAL_BI_FILE_IMPORT_NEXT}} </a>
		</template>

		<template v-slot:step2="step">
			{{ messages.HEADER_RS_B2BPORTAL_BI_FILE_IMPORT_STEP_2 }}<br><br>

			<div class="form-group row">
				<label for="example-input-2" class="col-2 col-form-label">{{ messages.HEADER_RS_B2BPORTAL_BI_FILE_IMPORT_ARTICLE }}</label>
				<div class="col-10">
					<select class="form-control" id="example-input-2" v-model="settings.codeIndex">
						<option :value="undefined">-</option>
						<option v-for="i in fileData.highestColumn" :key="i" :value="i" :disabled="i === settings.quantityIndex">{{ i }} ({{ fileRows[0][i - 1] }})</option>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<label for="example-input-2" class="col-2 col-form-label">{{ messages.HEADER_RS_B2BPORTAL_BI_FILE_IMPORT_QUANTITY }}</label>
				<div class="col-10">
					<select class="form-control" id="example-input-2" v-model="settings.quantityIndex">
						<option :value="undefined">-</option>
						<option v-for="i in fileData.highestColumn" :key="i"  :value="i" :disabled="i === settings.codeIndex">{{ i }} ({{ fileRows[0][i - 1] }})</option>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-10 offset-2">
					<label class="kt-checkbox">
						<input type="checkbox" v-model="skipFirstRow"> {{ messages.HEADER_RS_B2BPORTAL_BI_FILE_IMPORT_SKIP_FIRST_ROW }}
						<span></span>
					</label>
				</div>
			</div>

			<a class="btn btn-primary pull-right" @click.prevent.stop="next(step)" href="#"> {{ messages.HEADER_RS_B2BPORTAL_BI_FILE_IMPORT_NEXT }} </a>
			<a class="btn btn-btn-outline-brand pull-right" @click.prevent.stop="back(step)" href="#">{{ messages.HEADER_RS_B2BPORTAL_BI_FILE_IMPORT_BACK }}</a>
		</template>

		<template v-slot:step3="step3">
			{{ messages.HEADER_RS_B2BPORTAL_BI_FILE_IMPORT_STEP_3 }}<br><br>

			<div v-if="!!result">
				<div v-for="(basketResult, code) in result" :key="code">
					<span :class="{'text-success': basketResult.isSuccess, 'text-danger': !basketResult.isSuccess}">{{code}}: {{ basketResult.message }} </span>
				</div>
			</div>

			<br><br>

			<a class="btn btn-primary pull-right" @click.prevent.stop="reset()" href="#"> {{messages.HEADER_RS_B2BPORTAL_BI_FILE_IMPORT_RESET}} </a>
		</template>

	</Stepper>

</template>

<script>
import { parseFile, addtobasket} from './api.js';

export default {

	components: {
		Stepper: B2BPortal.Vue.Components.Stepper
	},

	props: {
		signedParameters: {
			type: String,
			default: ''
		}
	},

	data()
	{
		return {
			currentStepIndex: 0,
			steps: Object.freeze([
				'step1',
				'step2',
				'step3'
			]),
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
		}
	},

	computed: {

		fileData()
		{
			return {
				highestColumn: this.fileRows.reduce((highest, row) => Math.max(highest, row.length), 0)
			};
		},

		messages()
		{
			return (
				Object.freeze(
					Object.keys(BX.message).filter(message => message.startsWith('RS_B2BPORTAL_BI'))
						.reduce((obj, message) => { obj[message.slice(message)] = BX.message(message); return obj; }, {})
				)
			);
		},
	},

	methods: {
		reset()
		{
			this.currentStepIndex = 0;
			this.fileRows = [];
			this.file = '';
			this.filePath = '';

			this.settings = {
				codeIndex: undefined,
				quantityIndex: undefined
			}

			this.result = {};
		},

		startLoader()
		{
			this.$emit('startLoader')
		},

		endLoader()
		{
			this.$emit('endLoader')
		},

		validateFileInput()
		{
			const fileInput = this.$refs.fileInput;
			const file = (fileInput.files || [])[0];

			this.filePath = fileInput.value;

			if (file)
			{
				fileInput.classList.remove('is-invalid');
			}
			else
			{
				fileInput.classList.add('is-invalid');
			}
		},

		handleStep(step)
		{
			this.currentStepIndex = step.index;
		},

		async next(step)
		{
			switch(step.name)
			{
				case 'step1':

					try 
					{
						this.startLoader();

						if (await this.processReadFile())
						{
							step.next();
						}
					}
					catch (e) {}
					finally
					{
						this.endLoader();
					}

					break;
				case 'step2':

					try 
					{
						this.startLoader();
						step.next();
						await this.addtobasket();
					}
					catch (e) {}
					finally
					{
						this.endLoader();
					}

					break;
			}
		},

		async back(step)
		{
			step.back();
		},

		async processReadFile()
		{
			if (this.method === 'upload')
			{
				return this.processReadFileByUpload();
			}
			else if (this.method === 'link')
			{
				return this.processReadFileByPath();
			}

			throw new Error('Wrong file upload method');
		},

		async processReadFileByUpload()
		{
			const fileInput = this.$refs.fileInput;
			const file = (fileInput.files || [])[0];

			if (file)
			{
				const formData = new FormData();
				formData.append('file', file);
				formData.append('signedParamaters', this.signedParameters);
				formData.append('sessid', BX.bitrix_sessid());

				this.fileRows = await parseFile(formData);

				return true;
			}
			else
			{
				fileInput.classList.add('is-invalid');
			}

			return false;
		},

		async processReadFileByPath()
		{
			this.fileRows = await parseFile({
				path: this.filePath,
				signedParameters: this.signedParameters
			});

			return true;
		},

		prepareData()
		{
			let data = {};
			const rows=  [...this.fileRows];

			if (this.skipFirstRow)
			{
				rows.shift();
			}

			for (const row of rows)
			{
				const codeStr = new String(row[this.settings.codeIndex - 1]);
				if (codeStr.trim() !== '')
				{
					data[codeStr] = row[this.settings.quantityIndex - 1];
				}
			}

			return data;
		},

		async addtobasket()
		{
			if (this.fileRows.length === 0)
			{
				return;
			}

			const data = this.prepareData();

			try
			{
				const result = await addtobasket({
					data: data,
					signedParameters: this.signedParameters	
				});
	
				this.result = result;
				this.$store.dispatch('cart/fetch');
			}
			catch(e)
			{
				console.error(e);
			}
		}
	},

	watch: {
		fileRows(newVal)
		{
			if (this.fileRows.length > 0)
			{
				if ( this.fileRows[0].length === 5)
				{
					// default export
					this.settings.codeIndex = 2;
					this.settings.quantityIndex = 4;
				}
				else
				{
					this.settings.codeIndex = this.fileRows[0].length > 0 ? 1 : undefined
					this.settings.quantityIndex = this.fileRows[0].length > 1 ? 2 : undefined
				}
			}
		}
	}
} 
</script>
