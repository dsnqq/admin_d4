<template>
  <LayoutDefault>
    <template #tableThead>
      <th
        v-for="(c, i) in COLUMNS_LIST"
        :key="i"
        scope="col"
        :class="c.className"
      >
        {{ c.title }}
      </th>
    </template>
    <template #tableTbody>
      <tr v-for="(userItem, i) in userHistoryList" :key="i">
        <td
          v-for="(c, index) in COLUMNS_LIST"
          :key="index"
          :class="c.className"
          :data-th="c.title"
        >
          <template v-if="c.type == 'name'">
            {{ userItem[c.name] + ` ` + userItem[c.name2] }}
          </template>
          <template v-else-if="c.type == 'default'">
            {{ userItem[c.name] }}
          </template>
          <template v-else-if="c.type == 'status'">
            {{ getStatusUser(userItem[c.name]) }}
          </template>
          <template v-else-if="c.type == 'action'">
            <router-link
              v-for="(l, j) in c.links"
              :key="j"
              :to="l.url + userItem[l.url2]"
              :class="l.className"
            >
              <i :class="l.iconClass"></i>
            </router-link>
          </template>
        </td>
      </tr>
    </template>
  </LayoutDefault>
</template>

<script setup>
import LayoutDefault from '@/layouts/LayoutDefault.vue';
import { COLUMNS_LIST } from '@/components/historyUsers/constants/constants';
import { computed } from 'vue';
import { useStore } from '@/composables/useStore';

const store = useStore();
store.dispatch('historyUsers/GET_USER_HISTORY_LIST');

const userHistoryList = computed(
  () => store.getters['historyUsers/USER_HISTORY_LIST'],
);
const getStatusUser = (status) => (status == 1 ? 'Активно' : 'Неактивно');
</script>
