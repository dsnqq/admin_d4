<?php
class ModelCatalogAutoParts extends Model {
    public function getProducts($data = array()) {
        $this->cache->delete('product');

        $sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

        if (!empty($data['filter_category'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
        }

        $sql .= " WHERE pd.language_id <> 666";

        if (!empty($data['filter_model']) && $data['filter_model'] !== '') {
            $sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
        }

        if (!empty($data['filter_sparePartNumber']) && $data['filter_sparePartNumber'] !== '') {
            $sql .= " AND p.sku LIKE '" . $this->db->escape($data['filter_sparePartNumber']) . "%'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status']) && $data['filter_status'] !== '') {
            $sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
        }

        if (isset($data['filter_fuel']) && $data['filter_fuel'] !== '') {
            $sql .= " AND p.isbn = '" . $data['filter_fuel'] . "'";
        }

        if (isset($data['filter_types']) && $data['filter_types'] !== '') {
            $sql .= " AND p.manufacturer_id = '" . $data['filter_types'] . "'";
        }

        if (isset($data['filter_value']) && $data['filter_value'] !== '') {
            $sql .= " AND p.jan = '" . $data['filter_value'] . "'";
        }

        if (isset($data['filter_value']) && $data['filter_value'] !== '') {
            $sql .= " AND p.jan = '" . $data['filter_value'] . "'";
        }

        if (!empty($data['filter_category'])) {
            //$sql .= " AND p2c.category_id = '" . (int)$data['filter_category'] . "'";
            $implode_data = array();

            $categories = $this->getCategoriesChildren($data['filter_category']);

            foreach ($categories as $category) {
                $implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
            }

            $sql .= " AND (" . implode(' OR ', $implode_data) . ")";
        }

        if (isset($data['filter_year_start']) && $data['filter_year_start'] !== '' && isset($data['filter_year_last']) && $data['filter_year_last'] !== '') {
            $sql .= " AND p.length >= '" . (int)$data['filter_year_start'] . "' AND p.length <= '" . (int)$data['filter_year_last'] . "'";
        } elseif ($data['filter_year_start'] == '' && $data['filter_year_last'] !== '') {
            $sql .= " AND p.length <= '" . (int)$data['filter_year_last'] . "'";
        } elseif ($data['filter_year_start'] !== '' && $data['filter_year_last'] == '') {
            $sql .= " AND p.length >= '" . (int)$data['filter_year_start'] . "'";
        }

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.price',
            'p.quantity',
            'p.status',
            'p.date_added',
            'p.sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY pd.name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getCategoriesChildren($parent_id = 0) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_path WHERE path_id = '" . (int)$parent_id . "'");
        return $query->rows;
    }

    public function getProductImages($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");

        return $query->rows;
    }

    public function getTotalsAutoParts($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product p";

        if (!empty($data['filter_category'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
        }

        $sql .= " WHERE sort_order <> 666";

        if (!empty($data['filter_model']) && $data['filter_model'] !== '') {
            $sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
        }

        if (!empty($data['filter_sparePartNumber']) && $data['filter_sparePartNumber'] !== '') {
            $sql .= " AND p.sku LIKE '" . $this->db->escape($data['filter_sparePartNumber']) . "%'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status']) && $data['filter_status'] !== '') {
            $sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
        }

        if (isset($data['filter_fuel']) && $data['filter_fuel'] !== '') {
            $sql .= " AND p.isbn = '" . $data['filter_fuel'] . "'";
        }

        if (isset($data['filter_types']) && $data['filter_types'] !== '') {
            $sql .= " AND p.manufacturer_id = '" . $data['filter_types'] . "'";
        }

        if (isset($data['filter_value']) && $data['filter_value'] !== '') {
            $sql .= " AND p.jan = '" . $data['filter_value'] . "'";
        }

        if (!empty($data['filter_category'])) {
            $sql .= " AND p2c.category_id = '" . (int)$data['filter_category'] . "'";
        }

        if (isset($data['filter_year_start']) && $data['filter_year_start'] !== '' && isset($data['filter_year_last']) && $data['filter_year_last'] !== '') {
            $sql .= " AND p.length >= '" . (int)$data['filter_year_start'] . "' AND p.length <= '" . (int)$data['filter_year_last'] . "'";
        } elseif ($data['filter_year_start'] == '' && $data['filter_year_last'] !== '') {
            $sql .= " AND p.length <= '" . (int)$data['filter_year_last'] . "'";
        } elseif ($data['filter_year_start'] !== '' && $data['filter_year_last'] == '') {
            $sql .= " AND p.length >= '" . (int)$data['filter_year_start'] . "'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getAutoName($id) {
        $product_category_data = array();

        $query_auto = $this->db->query('SELECT * FROM `oc_product_to_category` WHERE product_id = ' . (int)$id);
        $query_model = $this->db->query('SELECT * FROM `oc_category_description` WHERE category_id = ' . (int)$query_auto->row['category_id']);
        $query_parent_id = $this->db->query('SELECT * FROM `oc_category` WHERE category_id = ' . (int)$query_auto->row['category_id']);
        $query_marka = $this->db->query('SELECT * FROM `oc_category_description` WHERE category_id = ' . (int)$query_parent_id->row['parent_id']);

        $product_category_data['marka'] = $query_marka->row['name'];
        $product_category_data['model'] = $query_model->row['name'];

        return $product_category_data;
    }

    public function getAutoCategoryId($id) {
        $query_auto = $this->db->query('SELECT * FROM `oc_product_to_category` WHERE product_id = ' . (int)$id);
        $query_model = $this->db->query('SELECT * FROM `oc_category_description` WHERE category_id = ' . (int)$query_auto->row['category_id']);

        return $query_model->row['category_id'];
    }

    public function getAutoPartsCategoryName($id) {
        $query_auto = $this->db->query('SELECT * FROM `oc_product_to_category` WHERE product_id = ' . (int)$id);
        $query_model = $this->db->query('SELECT * FROM `oc_category_description` WHERE category_id = ' . (int)$query_auto->row['category_id']);
        $query_parent_id = $this->db->query('SELECT * FROM `oc_category` WHERE category_id = ' . (int)$query_auto->row['category_id']);
        $query_marka = $this->db->query('SELECT * FROM `oc_category_description` WHERE category_id = ' . (int)$query_parent_id->row['parent_id']);

        return $query_marka->row['name'] . ' > ' . $query_model->row['name'];
    }

    public function getAutoPartsName($id) {
        $auto_parts_name = array();
        $query_auto_parts = $this->db->query('SELECT * FROM `oc_manufacturer` WHERE manufacturer_id = ' . (int)$id);

        $auto_parts_name['code'] = $query_auto_parts->row['manufacturer_id'];
        $auto_parts_name['name'] = $query_auto_parts->row['name'];

        return $auto_parts_name;
    }

    public function getAutoPartsDescription($id){
        $query_description = $this->db->query('SELECT * FROM `oc_product_description` WHERE product_id = ' . (int)$id);

        $description = strip_tags($query_description->row['description']);
        $description = str_replace("\n", ' ', $description);

        return $description;
    }

    public function getProductCountStaxView($product_id){
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_stax WHERE product_id='".(int)$product_id."'");

        return $query->row['total'];

    }

    public function getAutoPartsIndex($id) {
        $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$id . "' LIMIT 1) AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function getAutoPartsAdditionalFields($id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id='".(int)$id."'");

        return $query->rows;
    }

    public function getAutoParstHistory($id) {
        $changeProductData = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_change p LEFT JOIN " . DB_PREFIX . "user pd ON (p.user_id = pd.user_id)  WHERE product_id = '" . (int)$id . "' ORDER BY data_change DESC");

        return $changeProductData->rows;
    }

    public function deleteProduct($product_id) {
        /* Copy in arhive */
        $this->db->query("INSERT INTO  " . DB_PREFIX . "arhive SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "arhive_attribute SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "arhive_description SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "arhive_image SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "arhive_to_category SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "arhive_to_layout SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "arhive_to_store SELECT * FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
        /* End copy in arhive */

        /* Add date delete product */
        $this->db->query("UPDATE  " . DB_PREFIX . "arhive SET date_delete = NOW() WHERE product_id = '" . (int)$product_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_recurring WHERE product_id = " . (int)$product_id);
        $this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "coupon_product WHERE product_id = '" . (int)$product_id . "'");

        return $product_id;
        $this->cache->delete('product');
    }

    public function addChangeProductData($data_old, $data_new, $data_name, $product_id, $user_id) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_change SET product_id = '" . (int)$product_id . "', value_name = '". $data_name ."', data_change = NOW(), value_old = '" . $data_old . "', value_new = '" . $data_new . "', user_id = '" . (int)$user_id . "'");

        $this->cache->delete('product');
    }

    public function getAutoPartsPrice($id) {
        $sql = "SELECT price FROM " . DB_PREFIX . "product WHERE product_id='" . (int)$id . "'";

        $query = $this->db->query($sql);

        return $query->row['price'];
    }

    public function getTypesOfAutoParst() {
        $sql = "SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (m.manufacturer_id = md.manufacturer_id)";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getBrandAndModelCarAutoParst($parent_id = 0) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

        return $query->rows;
    }

    public function getModelProduct($model) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE model = '" . $this->db->escape($model) . "'");

        return $query->row;
    }

    public function chekMaxModel(){
        $query= $this->db->query("SELECT MAX(product_id) FROM " . DB_PREFIX . "product");

        return $query->row;
    }

    public function addAutoParts($data, $auto_parts_images) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "product SET status = '" . $this->db->escape($data['status']) . "', manufacturer_id = '" . $this->db->escape($data['autoPartsManufacturerId']) . "', date_available = DATE_FORMAT(NOW(), '%Y-%m-%d'), weight_class_id = '1', length_class_id = '1', stock_status_id = '7', quantity = '1', model = '" . $this->db->escape($data['model']) . "', length = '" . $this->db->escape($data['year']) . "', diadiametr = '" . $this->db->escape($data['diameter']) . "', version = '" . $this->db->escape($data['modification']) . "', isbn = '" . $this->db->escape($data['fuel']) . "', jan = '" . $this->db->escape($data['value']) . "', mpn = '" . $this->db->escape($data['typeEngines']) . "', upc = '" . $this->db->escape($data['transmission']) . "', ean = '" . $this->db->escape($data['typeBody']) . "', location = '" . $this->db->escape($data['wheelDiameterR']) . "', width = '" . $this->db->escape($data['wheelWidthJ']) . "', height = '" . $this->db->escape($data['numberOfHoles']) . "', etvylet = '" . $this->db->escape($data['departureE']) . "', sku = '" . $this->db->escape($data['sparePartNumber']) . "', weight = '" . $this->db->escape($data['pcd']) . "', price = '" . $this->db->escape($data['priceUSD']) . "', youtube = '" . $this->db->escape($data['youtube']) . "', date_added = NOW()");

        $product_id = $this->db->getLastId();

        if (isset($data['imagesMain'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($data['imagesMain']) . "' WHERE product_id = '" . (int)$product_id . "'");
        }

        // Фиксы для опенкарт
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '0'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '0', layout_id = '2'");

        if (!empty($auto_parts_images)) {
            foreach ($auto_parts_images as $image) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($image) . "', sort_order = '1'");
            }
        }

        if ($data['autoPartsCategoryId']) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$data['autoPartsCategoryId'] . "', main_category = 1");
        }

        $this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', name = '" . $this->db->escape($data['autoPartsNameForBd']) . "', language_id = '1', description = '" . $this->db->escape($data['description']) . "', tag = '', meta_title = '" . $this->db->escape($data['autoPartsNameForBd']) . "', meta_h1 = '" . $this->db->escape($data['autoPartsNameForBd']) . "', meta_description = '".$this->db->escape($data['autoPartsNameForBd'])."', meta_keyword = ''");

        if ($data['telephone'] || $data['stock'] || $data['firstname'] || $data['theNote']) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '14', language_id = '1', text = '" .  $this->db->escape($data['firstname']) . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '13', language_id = '1', text = '" .  $this->db->escape($data['telephone']) . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '17', language_id = '1', text = '" .  $this->db->escape($data['stock']) . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '12', language_id = '1', text = '" .  $this->db->escape($data['theNote']) . "'");
        }

        $this->cache->delete('product');

        return $product_id;
    }

    public function editAutoParts($id, $data, $auto_parts_images, $main_image) {
        if($main_image == "null" || $main_image == "") {
            $main_image = $auto_parts_images[0];
        }
        $this->db->query("UPDATE " . DB_PREFIX . "product SET status = '" . $this->db->escape($data['status']) . "', model = '" . $this->db->escape($data['model']) . "', image = '" . $this->db->escape($main_image) . "', length = '" . $this->db->escape($data['year']) . "', version = '" . $this->db->escape($data['modification']) . "', isbn = '" . $this->db->escape($data['fuel']) . "', jan = '" . $this->db->escape($data['value']) . "', mpn = '" . $this->db->escape($data['typeEngines']) . "', upc = '" . $this->db->escape($data['transmission']) . "', ean = '" . $this->db->escape($data['typeBody']) . "', location = '" . $this->db->escape($data['wheelDiameterR']) . "', width = '" . $this->db->escape($data['wheelWidthJ']) . "', height = '" . $this->db->escape($data['numberOfHoles']) . "', diadiametr = '" . $this->db->escape($data['diameter']) . "', etvylet = '" . $this->db->escape($data['departureE']) . "', sku = '" . $this->db->escape($data['sparePartNumber']) . "', weight = '" . $this->db->escape($data['pcd']) . "', price = '" . $this->db->escape($data['priceUSD']) . "', manufacturer_id = '" . $this->db->escape($data['autoPartsName']) . "', youtube = '" . $this->db->escape($data['youtube']) . "', date_modified = NOW() WHERE product_id = '" . (int)$id . "'");

        $this->db->query("UPDATE " . DB_PREFIX . "product_description SET description = '" . $data['description'] . "' WHERE product_id = '" . (int)$id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$id . "'");

        if ($data['telephone'] || $data['stock'] || $data['firstname'] || $data['theNote']) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$id . "'");

            $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$id . "', attribute_id = '14', language_id = '1', text = '" .  $this->db->escape($data['firstname']) . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$id . "', attribute_id = '13', language_id = '1', text = '" .  $this->db->escape($data['telephone']) . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$id . "', attribute_id = '17', language_id = '1', text = '" .  $this->db->escape($data['stock']) . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$id . "', attribute_id = '12', language_id = '1', text = '" .  $this->db->escape($data['theNote']) . "'");
        }

        if (!empty($auto_parts_images)) {
            foreach ($auto_parts_images as $image) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$id . "', image = '" . $this->db->escape($image) . "', sort_order = '1'");
            }
        }

        $this->cache->delete('product');
    }

    public function autoPartsStatusChange($id, $status) {
        $this->db->query("UPDATE " . DB_PREFIX . "product SET status = '" . (int)$status . "', date_modified = NOW() WHERE product_id = '" . (int)$id . "'");

        $this->cache->delete('product');

        return $id;
    }

    public function addAutoPartsImagesFromList($id, $images) {
        $main_image = $this->db->query('SELECT image FROM `oc_product` WHERE product_id = ' . (int)$id);

        if($main_image->row['image'] == "" && $main_image->row['image'] == null) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $images[0] . "', date_modified = NOW() WHERE product_id = '" . (int)$id . "'");
        }

        if (!empty($images)) {
            foreach ($images as $image) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$id . "', image = '" . $this->db->escape($image) . "', sort_order = '1'");
            }
        }

        $this->cache->delete('product');
    }

    public function autoPartsPriceChange($id, $price) {
        $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . (int)$price . "', date_modified = NOW() WHERE product_id = '" . (int)$id . "'");

        $this->cache->delete('product');

        return $id;
    }
}
?>