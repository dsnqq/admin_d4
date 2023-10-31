<template>
  <transition name="fade">
    <router-link
        v-if="buttonShow"
        class="btn-up"
        :to="{name: component}"
    >
        <i class="bi bi-plus-lg"></i>
    </router-link>
  </transition>
</template>

<script>
  export default {
    name: "BaseButtonFixedAdd",

    mounted() {
      this.checkScrollPosition();
      window.addEventListener('scroll', this.checkScrollPosition);
    },

    props: ["component"],

    methods: {
      checkScrollPosition() {
        this.buttonShow = window.pageYOffset > 200;
      },
    },

    data() {
      return {
        buttonShow: false
      }
    }
  }
</script>

<style lang="scss" scoped>
@import "@/components/UI/style/base-button-fixed-add.scss";
</style>