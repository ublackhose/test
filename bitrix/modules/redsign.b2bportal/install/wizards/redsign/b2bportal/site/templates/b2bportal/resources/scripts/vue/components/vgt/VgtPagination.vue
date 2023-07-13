<template>
	<div class="vgt-wrap__footer clearfix">

		<div class="footer__row-count pull-right" v-if="!hideRowCount">
			<span class="footer__row-count__label">{{ localize.ROWS_PER_PAGE_TEXT }}</span>
			<select
				autocomplete="off"
				name="perPageSelect"
				class="footer__row-count__select js-vgt-selectpicker"
				v-model="currentPerPage"
				@change="perPageChanged">
				<option
					v-for="(option, idx) in rowsPerPageOptions"
					:key="'rows-dropdown-option-' + idx"
					:value="option">
					{{ option }}
				</option>
				<option v-if="paginateDropdownAllowAll" :value="total">{{ localize.ALL }}</option>
			</select>
		</div>

		<div class="footer__navigation pull-left">
			<a
				href="javascript:undefined"
				class="footer__navigation__page-btn btn arrow"
				:class="{ disabled: !prevIsPossible }"
				@click.prevent.stop="firstPage"
				tabindex="0">
				<i class="flaticon2-fast-back"></i>
			</a>

			<a
				href="javascript:undefined"
				class="footer__navigation__page-btn btn arrow"
				:class="{ disabled: !prevIsPossible }"
				@click.prevent.stop="previousPage"
				tabindex="0">
				<i class="flaticon2-back"></i>
			</a>

			<template v-for="(page, index) in pages">
				<a
					v-if="page.breakView"
					class="footer__navigation__page-btn btn disabled"
					tabindex="0"
					v-bind:key="index">
						{{ page.content }}
					</a>
				<a
					v-else-if="page.current"
					class="footer__navigation__page-btn btn current"
					tabindex="0"
					v-bind:key="index">
						{{ page.content }}
					</a>
				<a
					v-else-if="page.disabled"
					class="footer__navigation__page-btn btn disabled"
					tabindex="0"
					v-bind:key="index">
						{{ page.content }}
					</a>
				<a
					v-else
					class="footer__navigation__page-btn btn clickme"
					@click.prevent.stop="changePage(page.index + 1)"
					tabindex="0"
					v-bind:key="index">
						{{ page.content }}
					</a>
			</template>

			<a
				href="javascript:undefined"
				class="footer__navigation__page-btn btn arrow"
				:class="{ disabled: !nextIsPossible }"
				@click.prevent.stop="nextPage"
				tabindex="0">
				<i class="flaticon2-next"></i>
			</a>

			<a
				href="javascript:undefined"
				class="footer__navigation__page-btn btn arrow"
				:class="{ disabled: !nextIsPossible }"
				@click.prevent.stop="lastPage"
				tabindex="0">
				<i class="flaticon2-fast-next"></i>
			</a>
		</div>

	</div>
</template>

<script>
import VgtPagination from 'vue-good-table/src/components/VgtPagination.vue';

export default {

	name: 'VgtPagination',

	extends: VgtPagination,

	props: {

		hideRowCount: {
			type: Boolean,
			default: false
		},
		
		maxVisiblePages: {
			type: Number,
			required: false,
			default: 5,
		},

	},

	computed: {

		pages ()
		{
			let items = {}

			let setPageItem = index => {
				let page = {
					index: index,
					content: index + 1,
					current: index === (this.currentPage - 1),
					disabled: index === (this.currentPage - 1),
				}

				items[index] = page
			}

			if (this.pagesCount <= 1)
			{
				for (let index = 0; index < this.pagesCount; index++) {
					setPageItem(index)
				}
			}
			else
			{
				const marginPages = 1
				const pageRange = 5
				const halfPageRange = Math.floor(pageRange / 2)

				let setBreakView = index => {
					let breakView = {
						disabled: true,
						breakView: true,
						content: '...',
					}

					items[index] = breakView
				}

				// 1st - loop thru low end of margin pages
				for (let i = 0; i < marginPages; i++)
				{
					// setPageItem(i)
				}

				// 2nd - loop thru selected range
				let selectedRangeLow = 0;
				if (this.currentPage - halfPageRange > 0)
				{
					selectedRangeLow = this.currentPage - 1 - halfPageRange;
				}

				let selectedRangeHigh = selectedRangeLow + pageRange - 1;

				if (selectedRangeHigh >= this.pagesCount && selectedRangeLow >= pageRange)
				{
					selectedRangeHigh = this.pagesCount - 1;
					selectedRangeLow = selectedRangeHigh - pageRange + 1;
				}

				for (let i = selectedRangeLow; i <= selectedRangeHigh && i <= this.pagesCount - 1; i++)
				{
					setPageItem(i)
				}

				// Check if there is breakView in the left of selected range
				if (selectedRangeLow > marginPages)
				{
					// setBreakView(selectedRangeLow - 1)
				}

				// Check if there is breakView in the right of selected range
				if (selectedRangeHigh + 1 < this.pagesCount - marginPages)
				{
					// setBreakView(selectedRangeHigh + 1)
				}

				// 3rd - loop thru high end of margin pages
				for (let i = this.pagesCount - 1; i >= this.pagesCount - marginPages; i--)
				{
					// setPageItem(i)
				}
			}

			return items
		},

		localize()
		{
			return Object.freeze({
				"ROWS_PER_PAGE_TEXT": BX.message('VUE.VGT_PAGINATION.ROWS_PER_PAGE_TEXT'),
				"ALL": BX.message('VUE.VGT_PAGINATION.ALL'),
			})
		}

	},

	methods: {

		firstPage()
		{
			this.currentPage = 1
			this.pageChanged()
		},

		lastPage()
		{
			this.currentPage = this.pagesCount
			this.pageChanged()
		},

	},

	mounted ()
	{
		this.$nextTick(function ()
		{
			$('.js-vgt-selectpicker').selectpicker()
		})
	},

	components: {
		'vgt-pagination': VgtPagination,
	},

};
</script>
