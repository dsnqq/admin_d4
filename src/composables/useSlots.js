import { getCurrentInstance } from 'vue';
import { throwNoCurrentInstance } from '@/composables/helpers/throwNoCurrentInstance';

/**
 * Используется для получения Slots
 */
export function useSlots() {
  throwNoCurrentInstance('slots', 'useSlots');

  const instance = getCurrentInstance();

  return instance.proxy.$slots;
}
