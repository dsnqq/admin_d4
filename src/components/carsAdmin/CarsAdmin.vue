<template>
  <div class="car-admin">
    <component :is="carAdmin()"></component>
  </div>
</template>

<script>
export default {
  name: "CarsAdmin",

  components: {
    CarDismantling: () => import("./components/CarDismantling.vue"),
    CarIndex: () => import("./components/CarIndex.vue"),
  },

  methods: {
    carAdmin() {
      if(this.$route.name === "carDetail" || this.$route.name === "carCreate"){
        return 'CarIndex';
      }

      return 'CarDismantling';
    }
  }
}
</script>

<style scoped lang="sass">
@import "./src/components/carsAdmin/style/app.scss"
</style>

<style lang="sass">
@import "../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css"
@import "./src/components/carsAdmin/style/main.scss"
</style>