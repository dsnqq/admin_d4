<template>
  <div class="auto-tires-index-field">
    <label
      class="auto-tires-index-field__label"
      :class="{ 'auto-tires-index-field__label--is-required': required }"
    >
      {{ label }}:
    </label>
    <div class="auto-tires-index-field__wrap" :class="className">
      <slot></slot>
    </div>
    <slot name="additional"></slot>
  </div>
</template>

<script>
export default {
  name: 'AutoTiresIndexField',

  model: {
    prop: 'value',
    event: 'input',
  },

  props: {
    className: {
      type: String,
    },

    label: {
      type: String,
    },

    required: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/components/autoTires/style/auto-tires-index-field.scss"
</style>
