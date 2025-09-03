import { getCurrentInstance } from "vue";

/**
 * @param {string} tag
 * @param {string} method
 * @return {void | never}
 */
export function throwNoCurrentInstance(tag, method) {
  if (process.env.NODE_ENV === "production") {
    return;
  }

  const instance = getCurrentInstance();

  if (!instance) {
    throw new Error(
      `[${tag}]: Missing current instance. ${method}() must be called inside <script setup> or setup().`
    );
  }
}
