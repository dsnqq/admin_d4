<template>
  <div>
    <div class="car-list__totals">
      Всего <strong>{{TOTALS}} шт.</strong> авто
    </div>
    <router-link
        :to="{name: 'carCreate'}"
        class="car-list__link"
    >
      <button class="car-list__btn btn btn-primary">
        Добавить авто в разборе
      </button>
    </router-link>
  </div>
</template>

<script>
import {mapGetters}  from "vuex";

export default {
  name: "CarListTotals",

  computed: {
    ...mapGetters([
        'TOTALS'
    ]),
  },

  props: {
    totals: String
  }
}
</script>