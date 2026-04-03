/**
 * Composable для исправления URL изображений
 * Преобразует admin.d4.by URLs в d4.by
 */
export const useBaseLazyLoadImageService = () => {
  /**
   * Исправляет URL изображения, заменяя admin.d4.by на d4.by
   * @param {string} url - исходный URL изображения
   * @returns {string} - исправленный URL
   */
  function fixImageUrl(url) {
    if (!url || typeof url !== 'string') {
      return url;
    }

    return url.replace(
      /https?:\/\/admin\.d4\.by\/v1\/image\//g,
      'https://d4.by/image/',
    );
  }

  return {
    fixImageUrl,
  };
};
