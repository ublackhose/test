<template>
	<div class="kt-quick-search kt-quick-search--inline kt-quick-search--has-result">
		<form class="kt-quick-search__form" :action="action">
			<div class="input-group" :class="loadingClasses">
				<div class="input-group-prepend">
					<span class="input-group-text"><i class="flaticon2-search-1"></i></span>
				</div>
				<input 
					ref="input"
					type="text" 
					class="form-control kt-quick-search__input" 
					autocomplete="off" 
					:placeholder="messages.CT_BST_PLACEHOLDER" 
					:id="inputId" 
					:name="inputName"
					v-model="query"
					@focus="handleFocus"
					@blur="handleBlur"
					@input="handleInput"
				>
				<div class="input-group-append" v-show="showClear" @click.prevent="clearQuery">
					<span class="input-group-text">
						<i class="la la-close kt-quick-search__close" style="display: flex;"></i>
					</span>
				</div>
			</div>
		</form>
		
		<div data-toggle="dropdown" data-offset="0,15px" ref="dropdownToggle"></div>

		<div 
			ref="dropdown"
			class="dropdown-menu dropdown-menu-fit dropdown-menu-anim dropdown-menu-lg"
			tabindex="-1"
			style="width: 720px; max-width: 100%;"
		>
			<div 
				class="kt-quick-search__wrapper" 
				style="max-height: 550px; overflow: hidden;"
				data-scroll="true"
			>
				<div class="kt-quick-search__result">
					<template v-if="!result.length">{{ messages.CT_BST_NOT_FOUND }}</template>
					<template v-for="(category, index) in result">
						<div class="kt-quick-search__category" :key="index">{{ category.title }}</div>
						<div class="kt-quick-search__section">
							<div class="kt-quick-search__item" v-for="(item, index) in category.items" :key="index">
								<div class="kt-quick-search__item-img kt-quick-search__item-img--file">
									<img :src="item.picture" :alt="item.name">
								</div>
								<div class="kt-quick-search__item-wrapper">
									<a :href="item.url" class="kt-quick-search__item-title" v-html="highlight(item.name)"></a>
									<div class="kt-quick-search__item-desc" v-if="item.vendorCode">
										{{ messages.CT_BST_VENDOR_CODE }}
										<span v-html="highlight(item.vendorCode)"></span>
									</div>
								</div>
								<div class="kt-quick-search__item-price pl-3">
									<span v-if="item.price" class="font-weight-bold text-nowrap text-muted">
										<template v-if="item.type == productTypes.sku"> {{ messages.CT_BST_PRICE_FROM }} </template>
										{{ en(item.price.printDiscountValue) }}
									</span>
								</div>
								<div class="kt-quick-search__addtocart pl-3">
									<template v-if="item.type == productTypes.product || item.type == productTypes.offer">
										<a 
											href="#"
											class="btn btn-clean btn-sm btn-icon disabled" 
											@click.prevent=""
											v-if="cartItems.has(item.id)"
										>
											<i class="flaticon2-check-mark text-success"></i>
										</a>
										<a 
											href="#"
											class="btn btn-clean btn-sm btn-icon" 
											:class="{ 'disabled': !item.canBuy }"
											:disabled="!item.canBuy"
											@click.prevent="addItemToCart(item.id)"
											v-else
										>
											<i class="flaticon2-shopping-cart-1"></i>
										</a>
									</template>
								</div>
							</div>
						</div>
					</template>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

const { store } = B2BPortal;
const cache = [];

export default {

	name: 'QuickSearch',

	props: {
		minLength: {
			type: Number,
			default:  3
		},
		debounce: {
			type: Number,
			default: 500
		},
		action: {
			type: String,
			default: ''
		},
		inputId: {
			type: String,
			default: 'inheader-title-search-input'
		},
		inputName: {
			type: String,
			default: 'q'
		}
	},
	
	data()
	{
		return {
			canShow: false,
			loadingStack: [],
			isFocused: false,
			query: '',
			result: []
		};
	},

	created()
	{
		this.load = BX.debounce(this.load.bind(this), this.debounce);
	},

	mounted()
	{
		const clickOutside = ({ target }) => {
			if (this.isFocused && this.$refs.input !== document.activeElement)
			{
				if (target != this.$el && !this.$el.contains(target))
				{
					this.$refs.input.blur();
					this.isFocused = false;
				}
			}
		}

		document.addEventListener('keydown', ({ key }) => {
			if (this.isFocused && key == 'Escape')
			{
				this.$refs.input.blur();
				this.isFocused = false;
			}
		});

		document.addEventListener('mouseup', clickOutside);
		document.addEventListener('touchstart', clickOutside);

		$(this.$el).on('shown.bs.dropdown', () => {
			this.isFocused = true;
		});

		$(this.$el).on('hide.bs.dropdown', event => {
			if (this.showResult) event.preventDefault();
		});

		$(this.$el).on('hidden.bs.dropdown', event => {
			this.canShow = false;
		});
	},

	computed: {
		cartItems()
		{
			return store.state.cart.addedIds;
		},
		isLoading() 
		{
			return this.loadingStack.length;
		},
		loadingClasses()
		{
			if (this.isLoading)
			{
				return [
					'kt-spinner', 'kt-spinner--input', 'kt-spinner--sm', 
					'kt-spinner--brand', 'kt-spinner--right'
				];
			}

			return [];
		},
		showClear()
		{
			return this.query.length > 0 && !this.isLoading;
		},
		showResult()
		{
			return (
				this.isFocused &&
				this.canShow &&
				this.query.length >= this.minLength
			);
		},
		productTypes()
		{
			return Object.freeze({
				product: 1,
				sku: 3,
				offer: 4
			});
		},
		messages()
		{
			return Object.freeze({
				CT_BST_PLACEHOLDER: BX.message('CT_BST_PLACEHOLDER'),
				CT_BST_PRICE_FROM: BX.message('CT_BST_PRICE_FROM'),
				CT_BST_NOT_FOUND: BX.message('CT_BST_NOT_FOUND'),
				CT_BST_VENDOR_CODE: BX.message('CT_BST_VENDOR_CODE')
			});
		}
	},

	methods: {
		en(str)
		{
			const el = document.createElement('div');
			el.innerHTML = str;
			return el.innerText;
		},

		highlight(str)
		{
			return str.replace(new RegExp('(' + this.query + ')', 'gi'), '<b class="text-primary">$1</b>');
		},

		handleFocus()
		{
			this.isFocused = true;

			if (this.result.length)
			{
				this.canShow = true;
			}
		},

		handleBlur(event)
		{
			const relatedTarget = event.relatedTarget || document.activeElement;
			
			if (
				!relatedTarget || 
				(
					relatedTarget != this.$refs.dropdown &&
					!this.$refs.dropdown.contains(relatedTarget)
				)
			)
			{
				this.isFocused = false;
			}
		},

		handleInput()
		{
			this.$emit('input', this.query);
			this.load();
		},

		clearQuery()
		{
			this.query = '';
			this.$emit('input', this.query);
		},

		async load()
		{
			const query = this.query;

			if (query.length < this.minLength)
			{
				return;
			}

			if (cache[query])
			{
				this.result = cache[query];
				this.canShow = true;
				return;
			}

			try
			{
				this.loadingStack.push(1);
				
				const searchResult = await new Promise((resolve, reject) => {
					BX.ajax({
						url: BX.message('SITE_DIR'),
						method: 'POST',
						dataType: 'json',
						data: {
							'ajax_call': 'y',
							'INPUT_ID': 'inheader-title-search-input',
							'q': query,
							'l': this.minLength,
						},
						onsuccess: resolve,
						onfailure: reject,
					});
				});

				if (searchResult.status === 'success')
				{
					cache[query] = searchResult.data;
					this.result = searchResult.data;
				}
			}
			catch(e)
			{
				console.error(e);
			}
			finally
			{
				this.canShow = true;
				this.loadingStack.pop();
			}
		},

		async addItemToCart(productId)
		{
			await B2BPortal.store.dispatch('cart/addItemToCart', { productId });
			BX.onCustomEvent('updateBasketComponent');
		}
	},

	watch: {
		showResult(val)
		{
			if (val)
			{
				if (!this.$refs.dropdown.classList.contains('show'))
				{
					this.$nextTick(() => {
						$(this.$refs.dropdownToggle).dropdown('toggle');
						$(this.$refs.dropdownToggle).dropdown('update');
					});
				}
			}
			else
			{
				if (this.$refs.dropdown.classList.contains('show'))
				{
					this.$nextTick(() => {
						$(this.$refs.dropdownToggle).dropdown('toggle');
					});
				}
			}
		}
	}
}
</script>