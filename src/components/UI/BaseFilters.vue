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
            {{p.title}}
          </div>
          <div
              class="card-filter-item__form card-filter-item"
              :class="classObject(p.className, Array.isArray(p))"
          >
            <template v-if="Array.isArray(p)">
              <div
                  v-for="(j, i) in p"
                  :key="i"
                  class="card-filter-item__line"
              >
                <span class="m-1">
                  {{j.textLabel}}
                </span>
                <v-multiselect
                    v-model="parameters[j.vModel]"
                    :options="j.params"
                    :selectedLabel="`Выбрано`"
                    :deselectLabel="`Клик, чтобы удалить`"
                    :selectLabel="`Клик, чтобы выбрать`"
                    :placeholder="j.title"
                    class="card-filter-item__select card-filter-item__select--is-year"
                >
                  <template v-slot:noResult>
                    Пусто...
                  </template>
                </v-multiselect>
              </div>
            </template>
            <template v-else>
            <v-multiselect
                v-if="p.type == 'select'"
                v-model="parameters[p.vModel]"
                :options="p.params"
                :custom-label="(p.customLabel == 'name') ? customLabelNameReturn : customLabelReturn"
                :selectedLabel="`Выбрано`"
                :deselectLabel="`Клик, чтобы удалить`"
                :selectLabel="`Клик, чтобы выбрать`"
                :placeholder="p.title"
                class="card-filter-item__select"
            >
              <template v-slot:noResult>
                Пусто...
              </template>
            </v-multiselect>
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
export default {
  name: "BaseFilter",

  props: {
    options: Array
  },

  methods: {
    classObject(className, bool) {
      return {
        className,
        'card-filter-item--is-mobile-flex': bool
      }
    },

    customLabelNameReturn({ name }) {
      return name;
    },

    customLabelReturn(data) {
      return data;
    },

    setFilterOnAutoPartsPage() {
      this.$emit("setFilterOnAutoPartsPage", this.parameters);
    },

    resetFilters() {
      this.parameters = [];
      this.$emit("resetFilters")
    }
  },

  data() {
    return {
      parameters: []
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@/components/UI/style/v-filters.scss";
@import "../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css";
</style>
