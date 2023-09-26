<template>
  <div>
    <hr>
    <ul class="nav nav-pills">
      <li
          v-for="(tab, i) in tabComponents"
          :key="i"
          class="nav-item"
      >
        <a
            class="nav-link"
            :class="setActiveClass(tab.component)"
            v-on:click.prevent="setActiveTab(tab.component)"
        >
          {{ tab.title }}
        </a>
      </li>
    </ul>
    <keep-alive>
      <component :is="tabActive"></component>
    </keep-alive>
  </div>
</template>

<script>
export default {
  name: "SparePartsStatistics",

  components: {
    SparePartsStatisticsMain: () => import("./components/SparePartsStatisticsMain.vue"),
    SparePartsStatisticsDay: () => import("./components/SparePartsStatisticsDay.vue"),
  },

  methods: {
    setActiveClass(component) {
      return this.tabActive == component ? 'active' : '';
    },

    setActiveTab(component) {
      this.tabActive = component;
    },
  },

  data() {
    return {
      tabActive: 'SparePartsStatisticsMain',
      tabComponents: [
        {component: 'SparePartsStatisticsMain', title: 'Статистика просмотров З/Ч'},
        {component: 'SparePartsStatisticsDay', title: 'Статистика по датам'},
      ]
    };
  }
}
</script>

<style lang="scss" scoped>
@import "./src/components/sparePartsStatistics/style/spare-parts-statistics";
</style>