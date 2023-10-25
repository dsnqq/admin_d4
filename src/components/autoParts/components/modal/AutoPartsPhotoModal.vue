<template>
  <Modal
      @closeModalAdmin="closePhotoModalAdmin"
  >
    <template v-slot:header>Добавить фото</template>
    <template>
      <vue-dropzone
          v-on:vdropzone-sending="sendingEvent"
          :options="dropzoneOptions"
          ref="myVueDropzone"
          id="dropzone"
      ></vue-dropzone>
      <button
          @click.prevent="sendingDropzonePhoto"
          class="btn btn-info mt-3 d-flex justify-content-center m-auto"
      >
        Загрузить изображения
      </button>
    </template>
  </Modal>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'

export default {
  name: "AutoPartsPhotoModal",

  components: {
    Modal: () => import("@/components/UI/VModal.vue"),
    vueDropzone: vue2Dropzone,
  },

  methods: {
    closePhotoModalAdmin() {
      this.$emit('closePhotoModalAdmin');
    },

    sendingEvent(file) {
      console.log(file);
      this.$emit('closePhotoModalAdmin');
      //this.SET_CAR_IMAGE_FROM_USER(file);
    },

    sendingDropzonePhoto() {
      this.$refs.myVueDropzone.processQueue();
    },
  },

  data() {
    return {
      dropzoneOptions: {
        url: 'https://d4.by/upload.php',
        thumbnailWidth: 150,
        thumbnailHeight: 150,
        maxFilesize: 2500,
        autoProcessQueue: false,
        parallelUploads: 20,
        maxThumbnailFilesize: 200,
        resizeWidth: 800,
        timeout: 180000000,
        acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
        renameFile: function (file) {
          let newName = new Date().getTime() + '_' + file.name;
          return newName;
        }
      },
    };
  }
}
</script>

<style scoped lang="sass">
@import "vue2-dropzone/dist/vue2Dropzone.min.css"
</style>