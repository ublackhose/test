<template>
    <div
		:injectHiddenInput="injectHiddenInput"
		:injectInputName="injectInputName"
		:isSearchResultLock="isSearchResultLock"
		:isShowSpinner="isShowSpinner"
        :class="getBaseClass"
    >

        <template v-if="Object.keys(items).length">
            <ul class="tags-search__selected list-unstyled">
                <li
                    class="tags-search__selected__item"
                    :class="getSelectedItemClass"
                    v-for="(item, index) in items" :key="index"
                >
                    <input
                        v-if="injectHiddenInput && injectInputName != ''"
                        type="hidden"
                        :name="injectInputName"
                        :value="item.id"
                    >
                    <span>{{ item.name }}</span>
                    <span
                        class="tags-search__selected__remove"
                        @click="onRemove(index)"
                    ><i class="la la-close"></i></span>
                </li>
            </ul>
        </template>

        <div
            class="tags-search__input-wrap"
            :class="getInputWrapClass"
        >
            <input
                class="tags-search__input form-control"
                :class="getInputClass"
                type="text"
                :placeholder="messages.placeholder"
                v-model="query"
                @input="onInput"
                @focus="onFocus"
                v-click-outside="onOutside"
            >
        </div>

        <template v-if="Object.keys(searchItems).length">
            <div data-toggle="dropdown"></div>
            <div
                class="tags-search__dd-menu dropdown-menu"
                :class="getDropdownMenuClass"
            >
                <a
                    v-for="(item, index) in searchItems" :key="index"
                    class="dropdown-item"
                    :class="getDropdownItemClass"
                    href="#"
                    @click.prevent="onSelect(index)"
                >
                    {{ item.name }}
                </a>
            </div>
        </template>

        <template v-else-if="isShowResult">
            <div data-toggle="dropdown"></div>
             <div
                class="tags-search__dd-menu dropdown-menu"
                :class="getDropdownMenuClass"
            >
                <div class="p-3"> {{ messages.notFound }} </div>
            </div>
        </template>

    </div>
</template>

<script>
import _debounce from 'lodash/debounce';

let clickOutside = {
    bind: function(el, binding, vNode)
    {
        // Provided expression must evaluate to a function.
        if (typeof binding.value !== 'function')
        {
            const compName = vNode.context.name
            let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`
            if (compName)
            {
                warn += `Found in component '${compName}'`
            }
            
            console.warn(warn)
        }
        // Define Handler and cache it on the element
        const bubble = binding.modifiers.bubble
        const handler = (e) => {
            if (bubble || (!el.contains(e.target) && el !== e.target))
            {
                binding.value(e)
            }
        }
        el.__vueClickOutside__ = handler

        // add Event Listeners
        document.addEventListener('click', handler)
    },
    
    unbind: function(el, binding)
    {
        // Remove Event Listeners
        document.removeEventListener('click', el.__vueClickOutside__)
        el.__vueClickOutside__ = null
    }
};

export default {

    props: {
        injectHiddenInput: {
            type: Boolean,
            default: false,
        },
        injectInputName: {
            type: String,
            default: '',
        },
        isSearchResultLock: {
            type: Boolean,
            default: false,
        },
        isShowSpinner: {
            type: Boolean,
            default: false,
        },
        cssClassBase: {
            type: String,
            default: 'tags-search',
        },
        cssClassSelectedItem: {
            type: String,
            default: 'badge badge-secondary',
        },
        cssClassSpinner: {
            type: String,
            default: 'kt-spinner kt-spinner--sm kt-spinner--primary kt-spinner--right kt-spinner--input',
        },
        cssClassInputWrap: {
            type: String,
            default: '',
        },
        cssClassInput: {
            type: String,
            default: '',
        },
        cssClassDropdownMenu: {
            type: String,
            default: 'dropdown-menu-fit dropdown-menu-right dropdown-menu-anim',
        },
        items: {
            type: [Array, Object],
            default: () => [],
        },
        searchItems: {
            type: [Array, Object],
            default: () => [],
        },
        messages: {
            type: Object,
            default: () => {}
        },
        inputPlaceholder: {
            type: String,
            default: '',
        },
        minQueryLength: {
            type: Number,
            default: 2,
        },
    },

    data()
    {
        return {
            query: '',
            isShowResult: false
        }
    },

    created()
    {
        this.debouncedOnChangeQuery = _debounce(this.onChangeQuery, 500)
    },

    computed: {

        getBaseClass()
        {
            return this.cssClassBase
        },

        getSelectedItemClass()
        {
            return this.cssClassSelectedItem
        },

        getInputWrapClass()
        {
            let cssClass = ''

            cssClass += this.isShowSpinner ? this.cssClassSpinner : ''
            cssClass += this.cssClassInputWrap ? this.cssClassInputWrap : ''

            return cssClass
        },

        getInputClass()
        {
            return this.cssClassInput
        },

        getDropdownMenuClass()
        {
            let cssClass = this.cssClassDropdownMenu

            cssClass += this.isShowResult ? ' show' : ''
            cssClass += this.isSearchResultLock ? ' show-locked' : ''

            return cssClass
        },

        getDropdownItemClass()
        {
            return ''
        },

    },

    methods: {

        onInput(e)
        {
            if (this.query.length < this.minQueryLength)
            {
                this.hideSearch()
            }
            else
            {
                this.debouncedOnChangeQuery(this.query)
            }
        },

        onFocus(e)
        {
            if (this.query != '' && this.query.length >= this.minQueryLength && this.searchItems.length > 0)
            {
                this.showSearch()
            }
        },

        onOutside(e)
        {
            this.hideSearch()
        },

        onChangeQuery(query)
        {
            this.showSearch()
            this.$emit('on-input', query)
        },

        onRemove(index)
        {
            this.$emit('on-remove', index)
        },

        onSelect(index)
        {
            this.afterSelect()
            this.$emit('on-select', index)
        },

        afterSelect()
        {
            this.clearInput()
            this.hideSearch()
        },

        clearInput()
        {
            this.query = ''
        },

        showSearch()
        {
            this.isShowResult = true
        },

        hideSearch()
        {
            this.isShowResult = false
        },

    },

    directives: {
        'click-outside': clickOutside
    },
}
</script>
