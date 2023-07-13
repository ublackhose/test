<template>
    <div>
        <div class="kt-scroll ps ps--active-y" data-scroll="true" style="max-height: 535px; overflow: hidden;">
            <template v-if="changes.length">
                <div v-for="(change, index) in sortedChanges" :key="index">
                    {{ change.row.NAME }} {{ change.oldValue }}% -> {{ change.newValue }}% ({{change.price.NAME}})
                </div>
            </template>
            <template v-else>
                {{ messages['EMPTY'] }}
            </template>
        </div>

        <div class="mt-5">
            <a class="btn btn-secondary" href="#" @click.prevent="onReset" :class="{disabled: !changes.length}"> {{ messages['RESET'] }} </a>
            <a class="btn btn-primary" href="#" @click.prevent="onSave" :class="{disabled: !changes.length}"> {{ messages['SAVE'] }} </a>
        </div>
    </div>
</template>

<script>
    export default {

        props: {
            changes: Array,
            messages: Object
        },

        computed: {
            sortedChanges()
            {
                return this.changes.sort((a, b) => a.row.LEFT_MARGIN >= b.row.LEFT_MARGIN ? 1 : -1);
            }
        },

        methods: {
            onReset()
            {
                if (confirm(this.messages['ARE_YOU_SURE']))
                {
                    this.$emit('reset');
                }
            },

            onSave()
            {
                this.$emit('save');
            }
		}
    }
</script>