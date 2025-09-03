<template>
  <div
    class="auto-parts-index-wrapp__field auto-parts-index-field auto-parts-index-field--is-btn"
  >
    <button class="btn btn-primary" @click.prevent="setAutoPartsFromApi(true)">
      Добавить объявление
    </button>
    <button class="btn btn-success" @click.prevent="setAutoPartsFromApi(false)">
      Добавить и сохранить значения
    </button>
    <router-link :to="{ name: 'autoParts' }" class="btn btn-info">
      Выйти без сохранения
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'AutoPartsIndexButtonsCreate',

  methods: {
    setAutoPartsFromApi(redirect) {
      this.$emit('setAutoPartsFromApi', redirect);
    },
  },
};
</script>
