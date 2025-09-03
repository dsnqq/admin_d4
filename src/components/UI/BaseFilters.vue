<template>
  <div class="card-filter shadow-none bg-light border py-4">
    <div class="row">
      <div class="card-filter__rows">
        <div
          v-for="(p, index) in options"
          :key="index"
          class="card-filter__item card-filter-item"
        >
          <div class="card-filter-item__label">
            {{ p.title }}
          </div>
          <div
            class="card-filter-item__form card-filter-item"
            :class="classObject(p.className, Array.isArray(p))"
          >
            <template v-if="Array.isArray(p)">
              <div v-for="(j, i) in p" :key="i" class="card-filter-item__line">
                <span class="m-1">
                  {{ j.textLabel }}
                </span>
                <BaseMultiselect
                  v-model="parameters[j.vModel]"
                  :options="j.params"
                  :id="j.vModel"
                  :placeholder="j.title"
                  class="card-filter-item__select card-filter-item__select--is-year"
                />
              </div>
            </template>
            <template v-else>
              <BaseMultiselect
                v-if="p.type == 'select'"
                :options="p.params"
                v-model="parameters[p.vModel]"
                :id="p.vModel"
                :customLabel="p.customLabel"
                :placeholder="p.title"
                class="card-filter-item__select"
              />
              <input
                v-else-if="p.type == 'input'"
                v-model="parameters[p.vModel]"
                :type="p.inputType"
                :id="p.vModel"
                :placeholder="p.title"
                class="card-filter-item__input"
                :autocomplete="p.autocomplete"
              />
            </template>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="card-filter__buttons">
        <button
          @click.prevent="setFilterOnAutoPartsPage"
          type="button"
          class="btn btn-success card-filter__search"
        >
          Поиск
        </button>
        <button
          @click="resetFilters"
          type="button"
          class="btn btn-warning card-filter__refresh"
        >
          Сброс
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import BaseMultiselect from "@/components/UI/BaseMultiselect.vue";

export default {
  name: "BaseFilter",

  props: {
    options: Array,
  },

  components: {
    BaseMultiselect,
  },

  methods: {
    classObject(className, bool) {
      return {
        className,
        "card-filter-item--is-mobile-flex": bool,
      };
    },

    setFilterOnAutoPartsPage() {
      this.$emit("setFilterOnAutoPartsPage", this.parameters);
    },

    resetFilters() {
      this.parameters = [];
      this.$emit("resetFilters");
    },
  },

  data() {
    return {
      parameters: [],
    };
  },
};
</script>

<style lang="scss" scoped>
@import "@/components/UI/style/base-filters.scss";
@import "../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css";
</style>
