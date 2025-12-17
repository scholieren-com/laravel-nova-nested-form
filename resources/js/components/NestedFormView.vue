<template>
    <div class="cursor-pointer" @click="toggleVisibility">
        <Icon :name="iconName" />
    </div>
</template>

<script>
import {Icon} from "laravel-nova-ui";

export default {
    components: { Icon },

    props: {
        field: {
            type: Object,
        },

        child: {
            type: Object,
        },
    },

    computed: {
        iconName() {
            if (this.child) {
                return this.child.opened ? 'chevron-up' : 'chevron-down';
            }
            return 'chevron-down';
        },
    },

    methods: {
        /**
         * Toggle the visibility.
         */
        toggleVisibility() {
            if (this.child) {
                this.child.opened = !this.child.opened;
            } else if (this.field) {
                this.field.children.forEach((child) => (child.opened = !child.opened));
            }
        },
    },
};
</script>
