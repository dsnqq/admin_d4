<?php
class ModelCatalogAutoPartsArchive extends Model {
    public function getProducts($data = array()) {
        $this->cache->delete('product');

        $sql = "SELECT * FROM " . DB_PREFIX . "arhive p LEFT JOIN " . DB_PREFIX . "arhive_description pd ON (p.product_id = pd.product_id)";

        if (!empty($data['filter_category'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "arhive_to_category p2c ON (p.product_id = p2c.product_id)";
        }

        $sql .= " WHERE pd.language_id <> 666";

        if (!empty($data['filter_model']) && $data['filter_model'] !== '') {
            $sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
        }

        if (!empty($data['filter_sparePartNumber']) && $data['filter_sparePartNumber'] !== '') {
            $sql .= " AND p.sku LIKE '" . $this->db->escape($data['filter_sparePartNumber']) . "%'";
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
            $sql .= " AND p2c.category_id = '" . (int)$data['filter_category'] . "'";
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

    public function getProductImages($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "arhive_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");

        return $query->rows;
    }

    public function getTotalsAutoParts($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "arhive p";

        if (!empty($data['filter_category'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "arhive_to_category p2c ON (p.product_id = p2c.product_id)";
        }

        $sql .= " WHERE sort_order <> 666";

        if (!empty($data['filter_model']) && $data['filter_model'] !== '') {
            $sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
        }

        if (!empty($data['filter_sparePartNumber']) && $data['filter_sparePartNumber'] !== '') {
            $sql .= " AND p.sku LIKE '" . $this->db->escape($data['filter_sparePartNumber']) . "%'";
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

        $query_auto = $this->db->query('SELECT * FROM `oc_arhive_to_category` WHERE product_id = ' . (int)$id);
        $query_model = $this->db->query('SELECT * FROM `oc_category_description` WHERE category_id = ' . (int)$query_auto->row['category_id']);
        $query_parent_id = $this->db->query('SELECT * FROM `oc_category` WHERE category_id = ' . (int)$query_auto->row['category_id']);
        $query_marka = $this->db->query('SELECT * FROM `oc_category_description` WHERE category_id = ' . (int)$query_parent_id->row['parent_id']);

        $product_category_data['marka'] = $query_marka->row['name'];
        $product_category_data['model'] = $query_model->row['name'];

        return $product_category_data;
    }

    public function getAutoPartsName($id) {
        $auto_parts_name = array();
        $query_auto_parts = $this->db->query('SELECT * FROM `oc_manufacturer` WHERE manufacturer_id = ' . (int)$id);

        $auto_parts_name['id'] = $query_auto_parts->row['manufacturer_id'];
        $auto_parts_name['name'] = $query_auto_parts->row['name'];

        return $auto_parts_name;
    }

    public function getAutoPartsDescription($id){
        $query_description = $this->db->query('SELECT * FROM `oc_arhive_description` WHERE product_id = ' . (int)$id);

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

    public function getAutoParstHistory($id) {
        $changeProductData = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_change p LEFT JOIN " . DB_PREFIX . "user pd ON (p.user_id = pd.user_id)  WHERE product_id = '" . (int)$id . "' ORDER BY data_change DESC");

        return $changeProductData->rows;
    }

    public function restoreProduct($id) {
        $this->db->query("INSERT INTO  " . DB_PREFIX . "product SELECT * FROM " . DB_PREFIX . "arhive WHERE product_id = '" . (int)$id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "product_attribute SELECT * FROM " . DB_PREFIX . "arhive_attribute WHERE product_id = '" . (int)$id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "product_description SELECT * FROM " . DB_PREFIX . "arhive_description WHERE product_id = '" . (int)$id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "product_image SELECT * FROM " . DB_PREFIX . "arhive_image WHERE product_id = '" . (int)$id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "product_to_category SELECT * FROM " . DB_PREFIX . "arhive_to_category WHERE product_id = '" . (int)$id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "product_to_layout SELECT * FROM " . DB_PREFIX . "arhive_to_layout WHERE product_id = '" . (int)$id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "product_to_store SELECT * FROM " . DB_PREFIX . "arhive_to_store WHERE product_id = '" . (int)$id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "arhive WHERE product_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "arhive_to_layout WHERE product_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "arhive_to_store WHERE product_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "arhive_attribute WHERE product_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "arhive_description WHERE product_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "arhive_image WHERE product_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "arhive_to_category WHERE product_id = '" . (int)$id . "'");

        return $id;
        $this->cache->delete('product');
    }

    public function addChangeProductData($data_old, $data_new, $data_name, $product_id, $user_id) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_change SET product_id = '" . (int)$product_id . "', value_name = '". $data_name ."', data_change = NOW(), value_old = '" . $data_old . "', value_new = '" . $data_new . "', user_id = '" . $user_id . "'");

        $this->cache->delete('product');
    }
}
?>