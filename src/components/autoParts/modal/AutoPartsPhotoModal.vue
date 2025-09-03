<template>
  <Modal @closeModalAdmin="closePhotoModalAdmin">
    <template #header> Добавить фото </template>
    <template>
      <vue-dropzone
        id="dropzone"
        ref="myVueDropzone"
        :options="dropzoneOptions"
      ></vue-dropzone>
      <button
        class="btn btn-info mt-3 d-flex justify-content-center m-auto"
        @click.prevent="sendingDropzonePhoto"
      >
        Загрузить изображения
      </button>
    </template>
  </Modal>
</template>

<script>
import { mapActions } from 'vuex';
import vue2Dropzone from 'vue2-dropzone';

export default {
  name: 'AutoPartsPhotoModal',

  components: {
    Modal: () => import('@/components/UI/BaseModal.vue'),
    vueDropzone: vue2Dropzone,
  },

  props: ['autoPartsId'],

  methods: {
    ...mapActions('autoParts', ['SET_AUTO_PARTS_IMAGE_FROM_LIST']),

    closePhotoModalAdmin() {
      this.$emit('closePhotoModalAdmin');
    },

    sendingDropzonePhoto() {
      this.$refs.myVueDropzone.processQueue();
      let allFilesPhotoForSend = this.$refs.myVueDropzone.getUploadingFiles();

      for (let i = 0; i < allFilesPhotoForSend.length; i++) {
        this.imageServer.push(allFilesPhotoForSend[i].upload.filename);
      }

      let params = {
        images: this.imageServer,
        autoPartsId: this.$props.autoPartsId,
      };

      this.SET_AUTO_PARTS_IMAGE_FROM_LIST(params);
      this.$refs.myVueDropzone.removeAllFiles();

      this.$emit('closePhotoModalAdmin');
    },
  },

  data() {
    return {
      imageServer: [],
      dropzoneOptions: {
        url: '/v1/upload.php',
        thumbnailWidth: 150,
        thumbnailHeight: 150,
        maxFilesize: 2500,
        autoProcessQueue: false,
        parallelUploads: 20,
        dictDefaultMessage:
          'Нажмите сюда или перетащите сюда файлы для загрузки <div><span style="color: darkgrey; margin-bottom: 5px">* для выбора нескольких фото, удерживайте клавишу Ctrl</span><br/></div><br/>',
        dictRemoveFile: 'удалить',
        dictCancelUpload: 'отменить',
        maxThumbnailFilesize: 200,
        resizeWidth: 800,
        timeout: 180000000,
        acceptedFiles: '.png,.jpg,.gif,.bmp,.jpeg',
        renameFile: function (file) {
          let newName = new Date().getTime() + '_' + file.name;
          return newName;
        },
      },
    };
  },
};
</script>

<style scoped lang="sass">
@import "vue2-dropzone/dist/vue2Dropzone.min.css"
</style>
