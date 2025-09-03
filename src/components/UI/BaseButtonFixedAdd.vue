<template>
  <transition name="fade">
    <router-link v-if="buttonShow" class="btn-up" :to="{ name: component }">
      <i class="bi bi-plus-lg"></i>
    </router-link>
  </transition>
</template>

<script>
export default {
  name: 'BaseButtonFixedAdd',

  props: ['component'],

  data() {
    return {
      buttonShow: false,
    };
  },

  mounted() {
    this.checkScrollPosition();
    window.addEventListener('scroll', this.checkScrollPosition);
  },

  methods: {
    checkScrollPosition() {
      this.buttonShow = window.pageYOffset > 200;
    },
  },
};
</script>

<style lang="scss" scoped>
@import '@/components/UI/style/base-button-fixed-add.scss';
</style>
