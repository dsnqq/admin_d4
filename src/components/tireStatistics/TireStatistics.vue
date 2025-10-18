<template>
  <div>
    <hr />
    <ul class="nav nav-pills">
      <li v-for="(tab, i) in tabComponents" :key="i" class="nav-item">
        <a
          class="nav-link"
          :class="setActiveClass(tab.component)"
          @click.prevent="setActiveTab(tab.component)"
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

<script setup>
import { defineAsyncComponent, ref } from 'vue';

const TireStatisticsMain = defineAsyncComponent(() =>
  import('@/components/tireStatistics/components/TireStatisticsMain.vue'),
);
const TireStatisticsDay = defineAsyncComponent(() =>
  import('@/components/tireStatistics/components/TireStatisticsDay.vue'),
);

const tabActive = ref(TireStatisticsMain);
const tabComponents = ref([
  {
    component: TireStatisticsMain,
    title: 'Статистика просмотров шин',
  },
  {
    component: TireStatisticsDay,
    title: 'Статистика по датам',
  },
]);

const setActiveClass = (component) => {
  return tabActive.value === component ? 'active' : '';
};

const setActiveTab = (component) => {
  tabActive.value = component;
};
</script>

<style lang="scss" scoped>
@import './src/components/tireStatistics/style/tire-statistics';
</style>
