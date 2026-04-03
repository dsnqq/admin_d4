<?php
class ModelToolImage extends Model {
	/**
	 * Базовый URL витрины для ссылок /image/... (картинки на d4.by, не admin.d4.by).
	 * 1) HTTP(S)_CATALOG из config.php
	 * 2) из DIR_IMAGE: .../d4.by/image/ → https://d4.by/
	 * 3) как OpenCart: config_ssl / config_url
	 */
	protected function getImagePublicBase($ssl) {
		if (defined('HTTPS_CATALOG') && defined('HTTP_CATALOG')) {
			return $ssl ? rtrim(HTTPS_CATALOG, '/') . '/' : rtrim(HTTP_CATALOG, '/') . '/';
		}
		if (defined('HTTPS_CATALOG')) {
			return rtrim(HTTPS_CATALOG, '/') . '/';
		}
		if (defined('HTTP_CATALOG')) {
			return rtrim(HTTP_CATALOG, '/') . '/';
		}

		$derived = $this->deriveCatalogBaseUrlFromDirImage();
		if ($derived !== null) {
			return $derived;
		}

		return $ssl ? $this->config->get('config_ssl') : $this->config->get('config_url');
	}

	/**
	 * @return string|null https://домен/ или null
	 */
	protected function deriveCatalogBaseUrlFromDirImage() {
		$dir = rtrim(DIR_IMAGE, '/\\');
		$parent = dirname($dir);
		$name = basename($parent);
		if ($name === '' || $name === '.' || strpos($name, '.') === false) {
			return null;
		}
		if (!preg_match('/^[a-z0-9]([a-z0-9.-]*[a-z0-9])?$/i', $name)) {
			return null;
		}
		return 'https://' . $name . '/';
	}

	public function resize($filename, $width, $height) {
		if (!is_file(DIR_IMAGE . $filename)) {
			if (is_file(DIR_IMAGE . 'no_image.jpg')) {
				$filename = 'no_image.jpg';
			} elseif (is_file(DIR_IMAGE . 'no_image.png')) {
				$filename = 'no_image.png';
			} else {
				return;
			}
		}

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$image_old = $filename;
		$image_new = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . (int)$width . 'x' . (int)$height . '.' . $extension;

		if (!is_file(DIR_IMAGE . $image_new) || (filectime(DIR_IMAGE . $image_old) > filectime(DIR_IMAGE . $image_new))) {
			list($width_orig, $height_orig, $image_type) = getimagesize(DIR_IMAGE . $image_old);

			if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF))) {
				$parts = explode('/', str_replace('\\', '/', $image_old));
				$enc = implode('/', array_map('rawurlencode', $parts));
				$ssl = isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'));
				return $this->getImagePublicBase($ssl) . 'image/' . $enc;
			}

			$path = '';

			$directories = explode('/', dirname($image_new));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_IMAGE . $image_old);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $image_new);
			} else {
				copy(DIR_IMAGE . $image_old, DIR_IMAGE . $image_new);
			}
		}

		$imagepath_parts = explode('/', $image_new);
		$new_image = implode('/', array_map('rawurlencode', $imagepath_parts));

		$ssl = isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'));

		return $this->getImagePublicBase($ssl) . 'image/' . $new_image;
	}
}
