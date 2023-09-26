<template>
  <div>
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
  name: "TireStatistics",

  components: {
    TireStatisticsMain: () => import("./components/TireStatisticsMain.vue"),
    TireStatisticsDay: () => import("./components/TireStatisticsDay.vue"),
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
      tabActive: 'TireStatisticsMain',
      tabComponents: [
        {component: 'TireStatisticsMain', title: 'Статистика просмотров шин'},
        {component: 'TireStatisticsDay', title: 'Статистика по датам'},
      ]
    };
  }
}
</script>

<style lang="scss" scoped>
@import "./src/components/tireStatistics/style/tire-statistics";
</style>