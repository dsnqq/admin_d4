<template>
  <v-multiselect
    :id="id"
    v-model="model"
    :options="options"
    :custom-label="
      customLabel == 'name' ? customLabelNameReturn : customLabelReturn
    "
    :selected-label="``"
    :deselect-label="`Удалить`"
    :select-label="`Выбрать`"
    :placeholder="placeholder"
    @select="select"
  >
    <template #noResult> Пусто... </template>
  </v-multiselect>
</template>

<script>
export default {
  name: 'BaseMultiselect',
  model: {
    prop: 'value',
    event: 'input',
  },
  props: {
    id: {
      type: String,
      required: true,
    },

    customLabel: {
      type: String,
    },

    options: {
      type: Array,
      required: true,
    },

    value: {
      type: [Number, Array, String, Object],
      required: false,
      default: () => null,
    },

    placeholder: {
      type: String,
    },
  },
  computed: {
    model: {
      get() {
        return this.value;
      },
      set(val) {
        this.$emit('input', val);
      },
    },
  },

  methods: {
    select(value) {
      this.$emit('select', value);
    },

    customLabelNameReturn({ name }) {
      return name;
    },

    customLabelReturn(data) {
      return data;
    },
  },
};
</script>
