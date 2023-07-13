<template>
    <div class="dropdown" v-if="Object.keys(variants).length ">
        <a class="btn btn-default btn-bold btn-upper btn-font-sm dropdown-toggle" href="#" role="button" data-toggle="dropdown">
            {{ (variants[selectedIndex] || {}).text }}
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#" v-for="(variant, index) in variants" :key="index" @click.prevent="onClick(index)">
                {{ variant.text }}
            </a>
        </div>
    </div>
</template>

<script>
export default {

    props: {
        variants: {
            type: [Array, Object],
            default: () => []
        },
        selected: {
            type: [Number, String],
            default: 0
        }
    },

    data()
    {
        return {
            selectedIndex: this.selected
        }
    },

    methods: {
        
        onClick(index)
        {
            this.selectedIndex = index;
            this.$emit('select', this.variants[this.selectedIndex]);
        }

    }
}
</script>