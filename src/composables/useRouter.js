import { getCurrentInstance } from "vue";
import { throwNoCurrentInstance } from "@/composables/helpers/throwNoCurrentInstance";

/**
 * @use import {useRouter} from 'vue-router/composables';
 * @deprecated
 * @return {VueRouter}
 */
export const useRouter = () => {
  throwNoCurrentInstance("vue-router", "useRouter");

  const instance = getCurrentInstance();

  return instance.proxy.$root.$router;
};
