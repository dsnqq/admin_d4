<template>
  <div class="app-car-dismantling">
    <div class="app-car-dismantling__car car">
      <CarContent
          class="car__list"
      />
    </div>
  </div>
</template>

<script>
import CarContent from './CarContent.vue'

export default {
  name: 'CarDismantling',

  components: {
    CarContent
  }
}
</script>
