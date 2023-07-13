<template>
	<div class="kt-pagination">
		<ul class="kt-pagination__links">
			<template v-if="pages.length > 1">

				<li 
					class="kt-pagination__link--first"
					:class="{
						'kt-pagination__link--disabled': currentPage === 1
					}"
				>
					<a :href="getPageUrl(1)" @click.prevent="changePage(1)">
						<i class="fa fa-angle-double-left"></i>
					</a>
				</li>
				<li 
					class="kt-pagination__link--prev"
					:class="{
						'kt-pagination__link--disabled': currentPage - 1 <= 0
					}"
				>
					<a :href="getPageUrl(currentPage - 1)" @click.prevent="changePage(currentPage - 1)">
						<i class="fa fa-angle-left"></i>
					</a>
				</li>

				<li 
					v-for="pageNumber in pages" 
					:key="pageNumber"
					:class="{
						'kt-pagination__link--active': pageNumber === currentPage
					}"
				>
					<a :href="getPageUrl(pageNumber)" @click.prevent="changePage(pageNumber)">
						{{ pageNumber }}
					</a>
				</li>

				<li 
					class="kt-pagination__link--next"
					:class="{
						'kt-pagination__link--disabled': currentPage == pageCount
					}"
				>
					<a :href="getPageUrl(currentPage + 1)" @click.prevent="changePage(currentPage + 1)">
						<i class="fa fa-angle-right"></i>
					</a>
				</li>
				<li 
					class="kt-pagination__link--last"
					:class="{
						'kt-pagination__link--disabled': currentPage == pageCount
					}"
				>
					<a :href="getPageUrl(pageCount)" @click.prevent="changePage(pageCount)">
						<i class="fa fa-angle-double-right"></i>
					</a>
				</li>

			</template>
		</ul>
		<div class="kt-pagination__toolbar">
			<div class="d-flex align-items-center">
				<div class="btn-group bootstrap-select">
					<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{ currentPerPage }}
					</button>
					<div class="dropdown-menu">
						<a 
							class="dropdown-item"
							href="#" 
							v-for="(option, idx) in perPageOptions"
							:key="idx"
							@click.prevent="changePerPage(option)"
						>
							{{ option }}
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		page: {
			type: Number
		},
		pageCount: {
			type: Number,
			default: 1
		},
		pageRange: {
			type: Number,
			default: 5
		},
		perPage: {
			type: Number,
			default: 10
		},
		perPageOptions: {
			type: Array,
			default: () => [10, 20, 30]
		},
		paramName: {
			type: String,
			default: 'page'
		}
	},

	data()
	{
		return {
			currentPage: this.page,
			currentPerPage: this.perPage
		}
	},

	computed: {
		pages ()
		{
			const pages = [];

			if (this.pageCount <= 1)
			{
				for (let index = 0; index < this.pageCount; index++) 
				{
					pages.push(index + 1);
				}
			}
			else
			{
				const halfPageRange = Math.floor(this.pageRange / 2);
				
				let selectedRangeLow = 0;
				if (this.currentPage - halfPageRange > 0)
				{
					selectedRangeLow = this.currentPage - halfPageRange - 1;
				}

				let selectedRangeHigh = selectedRangeLow + this.pageRange - 1;
				if (selectedRangeHigh >= this.pageCount)
				{
					selectedRangeHigh = this.pageCount - 1;
					selectedRangeLow = selectedRangeHigh - this.pageRange + 1;
					if (selectedRangeLow < 0)
					{
						selectedRangeLow = 0;
					}
				}

				for (
					let index = selectedRangeLow; 
					index <= selectedRangeHigh && index <= this.pageCount - 1;
					index++
				)
				{
					pages.push(index + 1);
				}
			}

			return pages;
		}
	},

	methods: {
		changePage(pageNumber)
		{
			if (pageNumber > 0 && pageNumber <= this.pageCount)
			{
				const prevPage = this.currentPage;
				this.currentPage = pageNumber;

				this.$emit('page-changed', {
					currentPage: this.currentPage,
					prevPage: prevPage,
				});
			}
		},
		changePerPage(perPage)
		{
			this.currentPerPage = perPage;
			this.$emit('per-page-changed', {
				perPage: this.currentPerPage,
			});
		},
		getPageUrl(pageNumber)
		{
			return BX.Uri.addParam(
				window.location.pathname + window.location.search, 
				{ [this.paramName]: pageNumber }
			);
		}
	},

	watch: {
		page(pageNumber)
		{
			this.currentPage = pageNumber;
		}
	}
}
</script>