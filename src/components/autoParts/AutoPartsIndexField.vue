<template>
  <div class="auto-parts-index-field">
    <label
        class="auto-parts-index-field__label"
        :class="{'auto-parts-index-field__label--is-required' : required}"
    >
      {{label}}:
    </label>
    <div
        class="auto-parts-index-field__wrap"
        :class="className"
    >
      <slot></slot>
    </div>
    <slot name="additional"></slot>
  </div>
</template>

<script>
  export default {
    name: "AutoPartsIndexField",

    model: {
      prop: 'value',
      event: 'input',
    },

    props: {
      className: {
        type: String
      },

      label: {
        type: String
      },

      required: {
        type: Boolean,
        default: false
      }
    }
  }
</script>

<style scoped lang="sass">
@import "@/components/autoParts/style/auto-parts-index-field.scss"
</style>
