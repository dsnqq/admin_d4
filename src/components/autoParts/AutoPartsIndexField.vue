<template>
  <div class="auto-parts-index-field">
    <label
        class="auto-parts-index-field__label"
        :class="{'auto-parts-index-field__label--is-required' : required}"
    >
      {{title}}:
    </label>
    <div class="auto-parts-index-field__wrap">
      <input
          v-model="model"
          :type="(type) ? type : 'text'"
          :placeholder="(placeholder) ? placeholder : title"
          class="auto-parts-index-field__input"
      >
    </div>
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
      title: {
        type: String
      },

      placeholder: {
        type: String
      },

      type: {
        type: String
      },

      value: {
        type: [Number, Array, String, Object],
        required: false,
        default: () => null,
      },

      required: {
        type: Boolean,
        default: false
      }
    },

    computed: {
      model: {
        get() {
          return this.value;
        },

        set(val) {
          this.$emit(
              'input',
              val
          )
        },
      },
    },
  }
</script>

<style scoped lang="sass">
@import "@/components/autoParts/style/auto-parts-index-field.scss"
</style>
