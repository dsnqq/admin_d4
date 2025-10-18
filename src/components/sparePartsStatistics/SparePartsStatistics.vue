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
import { ref, defineAsyncComponent } from 'vue';

const SparePartsStatisticsMain = defineAsyncComponent(() =>
  import(
    '@/components/sparePartsStatistics/components/SparePartsStatisticsMain'
  ),
);
const SparePartsStatisticsDay = defineAsyncComponent(() =>
  import(
    '@/components/sparePartsStatistics/components/SparePartsStatisticsDay'
  ),
);

const tabComponents = ref([
  {
    component: SparePartsStatisticsMain,
    title: 'Статистика просмотров З/Ч',
  },
  {
    component: SparePartsStatisticsDay,
    title: 'Статистика по датам',
  },
]);
const tabActive = ref(SparePartsStatisticsMain);

const setActiveClass = (component) => {
  return tabActive.value === component ? 'active' : '';
};

const setActiveTab = (component) => {
  tabActive.value = component;
};
</script>

<style lang="scss" scoped>
@import '@/components/sparePartsStatistics/style/spare-parts-statistics.scss';
</style>
