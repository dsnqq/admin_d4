<template>
  <div>
    {{content}}
    <div
        v-if="contentTheNote !== null"
        class="text-danger"
    >
      <strong>Заметка: </strong>
      {{contentTheNote}}
    </div>
  </div>
</template>

<script>
export default {
  name: "AutoPartsListColumnDescription",

  props: ['content', 'contentTheNote']
}
</script>