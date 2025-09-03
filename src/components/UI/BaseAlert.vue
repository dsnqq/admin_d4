<template>
  <div class="alert border-0 bg-light-danger alert-dismissible fade show py-2">
    <div class="d-flex align-items-center">
      <div class="fs-3 text-danger">
        <i class="bi bi-x-circle-fill"></i>
      </div>
      <div class="ms-3">
        <div class="text-danger">
          {{ errorValidate }}
        </div>
      </div>
    </div>
    <button
      @click.prevent="closeAlertMessage"
      type="button"
      class="btn-close"
      data-bs-dismiss="alert"
      aria-label="Close"
    ></button>
  </div>
</template>

<script>
export default {
  name: "BaseAlert",

  props: {
    errorValidate: {
      type: String,
    },
  },

  methods: {
    closeAlertMessage() {
      this.$emit("closeAlertMessage");
    },
  },

  data() {
    return {
      modal: false,
    };
  },
};
</script>
