import { getCurrentInstance } from "vue";
import { throwNoCurrentInstance } from "@/composables/helpers/throwNoCurrentInstance";

/**
 * Используется для получения Vuex инстанса
 */
export function useStore() {
  throwNoCurrentInstance("vuex", "useStore");

  const instance = getCurrentInstance();

  return instance.proxy.$store;
}
