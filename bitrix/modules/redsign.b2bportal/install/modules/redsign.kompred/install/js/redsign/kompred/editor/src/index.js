import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import { Event } from 'main.core';
import TemplateHeader from './template-header/template-header.js';
import ProductTable from './product-table/product-table.js';

import 'redsign.kompred.fonts.dejavu-sans';
import './editor.css';

export class Editor extends Event.EventEmitter
{
	static get Events()
	{
		return {
			READY: 'ready',
			CHANGED: 'changed'
		};
	}

	constructor(element, params)
	{
		super();

		this.setEventNamespace('redsign.kompred.editor');

		this.element = element;
		this.offer = params.offer;
		this.structure = params.structure;
		this.editorParams = Object.assign({}, params.editorParams || {});
		this.config = params.config;

		this.render();
	}

	getTools()
	{
		return {
			header: {
				class: Header,
				inlineToolbar: true,
			},
			templateHeader: {
				class: TemplateHeader,
				inlineToolbar: true,
				config: {
					defaultLogo: this.config.defaultLogo
				}
			},
			productTable: {
				class: ProductTable,
				config: {
					offer: this.offer
				}
			},
		};
	}

	render()
	{
		this.$editorJS = new EditorJS({
			inlineToolbar: ['bold', 'italic', 'link'],
			holder: this.element,
			tools: this.getTools(),
			data: this.structure,
			minHeight: 100,
			onReady: this.onReadyHandle.bind(this),
			onChange: this.onChangeHandle.bind(this),
			logLevel: 'VERBOSE',
			i18n: {
				messages: {
					ui: {
						"blockTunes": {
							"toggler": {
								"Click to tune": BX.message('RS_KP_EDITOR_UI_BLOCKTUNES_TOGGLER_CLICK_TO_TUNE'),
								"or drag to move": BX.message('RS_KP_EDITOR_UI_BLOCKTUNES_TOGGLER_OR_DRAG_TO_MOVE')
							},
						},
						"inlineToolbar": {
							"converter": {
								"Convert to": BX.message('RS_KP_EDITOR_INLINETOOLBAR_CONVERTER_CONVERT_TO')
							}
						},
						"toolbar": {
							"toolbox": {
								"Add": BX.message('RS_KP_EDITOR_TOOLBAR_TOOLBOX_ADD')
							}
						}
					},

					toolNames: {
						"Text": BX.message('RS_KP_EDITOR_TOOLNAMES_TEXT'),
						"Heading": BX.message('RS_KP_EDITOR_TOOLNAMES_HEADING'),
						"Link": BX.message('RS_KP_EDITOR_TOOLNAMES_LINK'),
						"Bold": BX.message('RS_KP_EDITOR_TOOLNAMES_BOLD'),
						"Italic": BX.message('RS_KP_EDITOR_TOOLNAMES_ITALIC'),
					},

					blockTunes: {
						"delete": {
							"Delete": BX.message('RS_KP_EDITOR_BLOCKTUNES_DELETE')
						},
						"moveUp": {
							"Move up": BX.message('RS_KP_EDITOR_BLOCKTUNES_MOVEUP')
						},
						"moveDown": {
							"Move down": BX.message('RS_KP_EDITOR_BLOCKTUNES_MOVEDOWN')
						}
					}
				}
			},
			...this.editorParams
		});

	}

	async save()
	{
		if (!this.$editorJS)
			return this.structure;

		this.structure = await this.$editorJS.save();

		return {
			offer: this.offer,
			structure: this.structure,
		};
	}

	hide(re)
	{
		console.log(block);
	}

	onReadyHandle()
	{
		this.emit(Editor.Events.READY);
	}

	onChangeHandle()
	{
		this.emit(Editor.Events.CHANGED);
	}
}