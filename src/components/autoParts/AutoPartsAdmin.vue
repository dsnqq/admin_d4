<template>
  <div class="card">
    <div class="card-header py-3">
      <!-- Тут фильтра и прочая история -->
    </div>
    <div class="card-body">
      <AutoPartsList />
    </div>
  </div>
</template>

<script>
  import AutoPartsList from "@/components/autoParts/components/AutoPartsList.vue";

  export default {
    name: "AutoPartsAdmin",

    components: {
      AutoPartsList
    }
  }
</script>