<template>
  <div class="car-list-filter">
    <div class="car-list-filter__title">Фильтр</div>
    <div class="car-list-filter__content car-list-filter-content">
      <input
          placeholder="Год"
          class="car-list-filter-content__input car-list-filter-input"
      />
      <input
          placeholder="Цвет"
          class="car-list-filter-content__input car-list-filter-input"
      />
      <button class="car-list-filter-content__btn btn btn-success">
        Поиск авто
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "CarListFilter"
}
</script>

<style scoped lang="scss">
@import "./src/components/carsAdmin/style/car-list-filter.scss";
</style>