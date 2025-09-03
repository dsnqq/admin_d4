<template>
  <div class="card">
    <div v-if="isHeaderSlot" class="card-header py-3">
      <slot name="header"></slot>
    </div>
    <div class="card-body">
      <div class="row">
        <div>
          <table
            class="table align-middle table-striped table-border-1 rwd-table middle-responsive"
          >
            <thead>
              <slot name="tableThead"></slot>
            </thead>
            <tbody class="card-body__grid">
              <slot name="tableTbody"></slot>
            </tbody>
          </table>
        </div>
      </div>
      <slot name="pagination"></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: 'LayoutDefault',

  computed: {
    isHeaderSlot() {
      return this.$slots.header;
    },
  },
};
</script>

<style lang="scss">
@import '@/layouts/style/layout-default.scss';
@import '@/assets/scss/table-adaptive.scss';
</style>
