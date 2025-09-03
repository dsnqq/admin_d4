import { getCurrentInstance, shallowReactive, effectScope } from 'vue';
import { throwNoCurrentInstance } from '@/composables/helpers/throwNoCurrentInstance';

/**
 * @use import {useRoute} from 'vue-router/composables';
 * @deprecated
 * @return {*}
 */
export const useRoute = () => {
  throwNoCurrentInstance('vue-router', 'useRoute');

  const instance = getCurrentInstance();
  const root = instance.proxy.$root;

  if (!root._$route) {
    const route = effectScope(true).run(() =>
      shallowReactive({ ...(root.$router?.currentRoute ?? {}) }),
    );

    root._$route = route;

    if (root.$router) {
      root.$router.afterEach((to) => {
        Object.assign(route, to);
      });
    }
  }

  return root._$route;
};
