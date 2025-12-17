<template>
  <div
    class="
      bg-50
      p-4
      items-center
      text-90
      flex
      justify-between
      nova-nested-form-header
    "
  >
    <div v-if="heading" v-html="heading" />
    <div class="flex items-center gap-2">
      <nested-form-remove :child="child" :field="field" />
      <nested-form-view :child="child" />
    </div>
  </div>
</template>

<script>
import NestedFormRemove from "./NestedFormRemove";
import NestedFormView from "./NestedFormView";

export default {
  components: {
    NestedFormRemove,
    NestedFormView,
  },
  props: {
    child: {
      type: Object,
    },
    field: {
      type: Object,
    },
  },
  computed: {
    /**
     * Get the heading.
     */
    heading() {
      // Field max is set to 0 when it is unlimited!
      // we only want field that has max and min on it, and check if the limit is 1 or less!
      let string = null;
      if (this.child.heading.includes(",,")) {
        let array = this.child.heading.split(",,");
        string = this.parseHeading(array);
      }
      if (
        typeof this.field.max !== "undefined" &&
        this.field.min !== "undefined" &&
        this.field.max !== 0
      ) {
        if (this.field.max - this.field.min <= 1) {
          return string ?? this.child.heading.replace(/\d+\. /, "");
        }
      }

      return (
        string ??
        (this.child.heading
          ? this.child.heading.replace(
              new RegExp(
                `${this.field.wrapLeft}(.*?)(?:\\|(.*?))?${this.field.wrapRight}`,
                "g"
              ),
              (match, attribute, defaultValue = "") => {
                const field = this.child.fields.find(
                  (field) => field.originalAttribute === attribute
                );
                return field ? field.value : defaultValue;
              }
            )
          : null)
      );
    },
  },
  methods: {
    parseHeading(array) {
      array = array.map((el) => (el.includes(".") ? el.split(".") : ""));

      // Get fallback if exists important if is on create
      const fallback = array[array.length - 1].includes("fallback")
        ? array[array.length - 1][1]
        : null;

      let string = null;
      if (this.child.fields.length > 0) {
        string = this.child.fields.reduce((acc, field) => {
          for (let el of array) {
            if (
              field?.belongsToId !== null &&
              el.includes(field.belongsToRelationship)
            ) {
              acc =
                acc !== null
                  ? acc + ", " + String(field[el[1]])
                  : String(field[el[1]]);
            }
          }
          return acc;
        }, null);
      }
      return string ?? fallback;
    },
  },
};
</script>
