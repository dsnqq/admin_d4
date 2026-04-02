<?php
class ModelCatalogAutoTiresArchive extends Model {
    public function getProducts($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "arhive_shiny p LEFT JOIN " . DB_PREFIX . "arhive_shiny_description pd ON (p.product_id = pd.product_id)";

        if (!empty($data['filter_category'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "arhive_shiny_to_category p2c ON (p.product_id = p2c.product_id)";
        }

        if (!empty($data['filter_name'])) {
            $sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_model'])) {
            $sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
        }

        if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
            $sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
        }

        if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
            $sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
        }

        if (isset($data['filter_image']) && !is_null($data['filter_image'])) {
            if ($data['filter_image'] == 1) {
                $sql .= " AND (p.image IS NOT NULL AND p.image <> '' AND p.image <> 'no_image.png')";
            } else {
                $sql .= " AND (p.image IS NULL OR p.image = '' OR p.image = 'no_image.png')";
            }
        }

        if (!empty($data['filter_category'])) {
            $sql .= " AND p2c.category_id = '" . (int)$data['filter_category'] . "'";
        }
        $sql .= " GROUP BY p.product_id";

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.price',
            'p.quantity',
            'p.status',
            'p.date_added',
            'p.sort_order',
            'p.date_delete'
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
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "arhive_shiny_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");

        return $query->rows;
    }

    public function getTotalsAutoTires() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "arhive_shiny");

        return $query->row['total'];
    }

    public function getAutoTiresArchiveDescription($id){
        $query_description = $this->db->query('SELECT * FROM `oc_arhive_shiny_description` WHERE product_id = ' . (int)$id);

        $description = strip_tags($query_description->row['description']);
        $description = str_replace("\n", ' ', $description);

        return $description;
    }

    public function restoreProduct($id) {
        /* Copy in product */
        $this->db->query("INSERT INTO  " . DB_PREFIX . "shiny SELECT * FROM " . DB_PREFIX . "arhive_shiny WHERE product_id = '" . (int)$id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "shiny_attribute SELECT * FROM " . DB_PREFIX . "arhive_shiny_attribute WHERE product_id = '" . (int)$id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "shiny_description SELECT * FROM " . DB_PREFIX . "arhive_shiny_description WHERE product_id = '" . (int)$id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "shiny_image SELECT * FROM " . DB_PREFIX . "arhive_shiny_image WHERE product_id = '" . (int)$id . "'");
        /* End copy in product */

        $this->db->query("DELETE FROM " . DB_PREFIX . "arhive_shiny WHERE product_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "arhive_shiny_attribute WHERE product_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "arhive_shiny_description WHERE product_id = '" . (int)$id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "arhive_shiny_image WHERE product_id = '" . (int)$id . "'");

        $this->cache->delete('shiny');

        return $id;
    }
}
?>