<template>
  <div>
    <BreadcrumbAdmin>
      <template v-slot:buttons>
        <router-link
            :to="{name: 'carCreate'}"
            class="car-list__link"
        >
          <button class="car-list__btn btn btn-primary">
            Добавить авто в разборе
          </button>
        </router-link>
      </template>
    </BreadcrumbAdmin>
    <div class="app-car-dismantling">
      <div class="app-car-dismantling__car car">
        <CarContent
            class="car__list"
        />
      </div>
    </div>
  </div>
</template>

<script>
import BreadcrumbAdmin from "@/components/BreadcrumbAdmin.vue";
import CarContent from '@/components/carsAdmin/components/CarContent.vue';

export default {
  name: 'CarDismantling',

  components: {
    CarContent,
    BreadcrumbAdmin,
  }
}
</script>
