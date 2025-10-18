<template>
  <div>
    <Breadcrumb>
      <template #buttons>
        <router-link :to="{ name: 'historyUsers' }" class="btn btn-primary">
          {{ DICTIONARY.goBack }}
        </router-link>
      </template>
    </Breadcrumb>
    <hr />
    <LayoutDefault>
      <template #tableThead>
        <th v-for="(c, i) in COLUMNS_INDEX" :key="i" scope="col">
          {{ c.title }}
        </th>
      </template>
      <template #tableTbody>
        <tr v-for="(userItem, i) in userHistory" :key="i">
          <td
            v-for="(c, index) in COLUMNS_INDEX"
            :key="index"
            :data-th="c.title"
            v-html="renderContentOnColumn(userItem[c.name], c.type)"
          ></td>
        </tr>
      </template>
      <template #pagination>
        <Pagination
          :totals="userHistoryTotal"
          :count-chunk="isMobile ? 4 : 5"
          :class="{ 'card-body-pagination-mobile': isMobile }"
          @setPageByTotal="setPageByTotal"
        />
      </template>
    </LayoutDefault>
  </div>
</template>

<script setup>
import LayoutDefault from '@/layouts/LayoutDefault.vue';
import Pagination from '@/components/UI/BasePagination.vue';
import { COLUMNS_INDEX } from '@/components/historyUsers/constants/constants';
import { DICTIONARY } from '@/constants/constants';
import Breadcrumb from '@/components/UI/BaseBreadcrumb.vue';
import { useDevice } from '@/composables/useDevice';
import { computed, onMounted, ref } from 'vue';
import { useStore } from '@/composables/useStore';
import { useRoute } from '@/composables/useRoute';

const store = useStore();
const isMobile = useDevice();
const route = useRoute();

const pageNum = ref(1);
const id = ref(route.params.id);
const param = ref({
  user_id: route.params.id,
  page: 1,
});

onMounted(() => {
  store.dispatch('historyUsers/GET_USER_HISTORY', param.value);
  store.dispatch('historyUsers/GET_USER_HISTORY_TOTAL', id.value);
});

const userHistory = computed(() => store.getters['historyUsers/USER_HISTORY']);
const userHistoryTotal = computed(
  () => store.getters['historyUsers/USER_HISTORY_TOTAL'],
);

const renderContentOnColumn = (content, type) => {
  if (type === 'image') {
    if (content) {
      return '<img src="' + content + '" width="100" alt="no image"/>';
    }

    return '<img src="https://d4.by/image/no_image.png" width="100" alt="image"/>';
  }

  return content;
};

const setPageByTotal = (page) => {
  pageNum.value = page;
  param.value.page = page;
  store.dispatch('historyUsers/GET_USER_HISTORY', param.value);
};
</script>

<style lang="scss" scoped>
@import '@/components/historyUsers/style/history-users-index.scss';
</style>
