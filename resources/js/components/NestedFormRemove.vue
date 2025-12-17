<template>
  <div
    v-if="field.children.length > field.min"
    class="cursor-pointer hover:text-red-500"
    @click="removeChild"
  >
    <Icon name="trash" />
  </div>
</template>

<script>
import {Icon} from "laravel-nova-ui";

export default {
  components: { Icon },

  props: {
    field: {
      type: Object,
      required: true,
    },

    child: {
      type: Object,
      required: true,
    },
  },

  methods: {
    /**
     * Remove a child.
     */
    removeChild() {
      this.field.children.splice(this.field.children.indexOf(this.child), 1);
    },
  },
};
</script>
