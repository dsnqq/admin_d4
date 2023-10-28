<template>
  <div class="page-breadcrumb d-flex align-items-center mb-3">
    <router-link
        :to="{name: 'dashboardAdmin'}"
        class="breadcrumb-title"
    >
      Главная панель
    </router-link>
    <div class="ps-3 page-breadcrumb__links">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item">
            <router-link :to="{name: 'dashboardAdmin'}">
              <i class="bx bx-home-alt"></i>
            </router-link>
          </li>
          <li
              class="breadcrumb-item active"
              aria-current="page"
          >
            {{ $route.meta.title }}
          </li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">
      <div class="btn-group">
        <slot name="buttons"></slot>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "BaseBreadcrumb",
  }
</script>

<style lang="scss" scoped>
@import "@/components/style/breadcrumb-admin.scss";
</style>