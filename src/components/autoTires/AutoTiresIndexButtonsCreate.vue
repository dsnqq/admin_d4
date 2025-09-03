<template>
  <div
    class="auto-tires-index-wrapp__field auto-tires-index-field auto-tires-index-field--is-btn"
  >
    <button class="btn btn-primary" @click.prevent="setAutoTiresFromApi(true)">
      Добавить объявление
    </button>
    <button class="btn btn-success" @click.prevent="setAutoTiresFromApi(false)">
      Добавить и сохранить значения
    </button>
    <router-link :to="{ name: 'autoTires' }" class="btn btn-info">
      Выйти без сохранения
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'AutoTiresIndexButtonsCreate',

  methods: {
    setAutoTiresFromApi(redirect) {
      this.$emit('setAutoTiresFromApi', redirect);
    },
  },
};
</script>
