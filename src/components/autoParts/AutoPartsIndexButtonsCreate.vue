<template>
  <div
    class="auto-parts-index-wrapp__field auto-parts-index-field auto-parts-index-field--is-btn"
  >
    <button @click.prevent="setAutoPartsFromApi(true)" class="btn btn-primary">
      Добавить объявление
    </button>
    <button @click.prevent="setAutoPartsFromApi(false)" class="btn btn-success">
      Добавить и сохранить значения
    </button>
    <router-link :to="{ name: 'autoParts' }" class="btn btn-info">
      Выйти без сохранения
    </router-link>
  </div>
</template>

<script>
export default {
  name: "AutoPartsIndexButtonsCreate",

  methods: {
    setAutoPartsFromApi(redirect) {
      this.$emit("setAutoPartsFromApi", redirect);
    },
  },
};
</script>
