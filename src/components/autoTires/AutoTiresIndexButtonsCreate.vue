<template>
  <div
    class="auto-tires-index-wrapp__field auto-tires-index-field auto-tires-index-field--is-btn"
  >
    <button @click.prevent="setAutoTiresFromApi(true)" class="btn btn-primary">
      Добавить объявление
    </button>
    <button @click.prevent="setAutoTiresFromApi(false)" class="btn btn-success">
      Добавить и сохранить значения
    </button>
    <router-link :to="{ name: 'autoTires' }" class="btn btn-info">
      Выйти без сохранения
    </router-link>
  </div>
</template>

<script>
export default {
  name: "AutoTiresIndexButtonsCreate",

  methods: {
    setAutoTiresFromApi(redirect) {
      this.$emit("setAutoTiresFromApi", redirect);
    },
  },
};
</script>
