<template>
  <div>
    {{ content }}
    <div v-if="theNoteRenderOnPage" class="text-danger">
      <strong>Заметка: </strong>
      {{ contentTheNote }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'AutoPartsListColumnDescription',

  props: ['content', 'contentTheNote'],

  computed: {
    theNoteRenderOnPage() {
      return (
        this.$props.contentTheNote !== null && this.$props.contentTheNote !== ''
      );
    },
  },
};
</script>
