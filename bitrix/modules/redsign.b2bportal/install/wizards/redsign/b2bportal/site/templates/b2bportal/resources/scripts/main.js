import Select from './vue/components/select.vue';
import Dropdown from './vue/components/dropdown.vue';
import TagsSearch from './vue/components/tagssearch.vue';
import Stepper from './vue/components/stepper.vue';
import SuggestInput from './vue/components/suggestinput.vue';
import { VueGoodTable } from 'vue-good-table';
import VueTable from './vue/components/vgt/table.vue';
import Quantity from './vue/components/catalog/quantity.vue';
import StockQuantity from './vue/components/catalog/stockquantity.vue';
import QuantityInput from './vue/components/catalog/quantityinput.vue';
import Pagination from './vue/components/pagination.vue';
import VuexPagination from './vue/components/vuex-pagination.vue';

import _cloneDeep from 'lodash/cloneDeep';
import _groupBy from 'lodash/groupBy';

import Filter from './lib/filter';
import Table from './lib/table';
import TableFilter from './lib/table.filter';
import ClassTagsSearch from './lib/tagssearch';

import store from './store';
import storeModules from './vue/store/modules/index';

import './init';

global.B2BPortal = {

	Components: {
		Filter,
		Table,
		TableFilter,
		'TagsSearch': ClassTagsSearch,
	},

	store: store,

	Vue: {
		Components: {
			Select,
			Dropdown,
			SuggestInput,
			TagsSearch,
			VueTable,
			VueGoodTable,
			Stepper,
			Quantity,
			StockQuantity,
			QuantityInput,

			Pagination,
			VuexPagination
		},

		Store: storeModules,

	},

	Utils: {
		cloneDeep: _cloneDeep,
		groupBy: _groupBy
	},

};
