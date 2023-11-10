<?php
class ModelCatalogAutoTires extends Model {
    /*
     * Function to get auto tires for list
     * */
    public function getProducts($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "shiny p LEFT JOIN " . DB_PREFIX . "shiny_description pd ON (p.product_id = pd.product_id) GROUP BY p.product_id";

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

    /*
     * Function to get images
     * */
    public function getProductImages($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "shiny_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");

        return $query->rows;
    }

    /*
     * Function to get totals auto tires
     * */
    public function getTotalsAutoTires() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "shiny");

        return $query->row['total'];
    }

    /*
     * Function to get tel,firstname,stock informations
     * */
    public function getAutoTiresAdditionalFields($id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "shiny_attribute WHERE product_id='".(int)$id."'");

        return $query->rows;
    }

    /*
     * Function to get auto tires names
     * */
    public function getAutoName($id) {
        $product_category_data = array();

        $query_auto = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = " . (int)$id);
        $query_model = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = " . (int)$query_auto->row['category_id']);
        $query_parent_id = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE category_id = " . (int)$query_auto->row['category_id']);
        $query_marka = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = " . (int)$query_parent_id->row['parent_id']);

        $product_category_data['marka'] = $query_marka->row['name'];
        $product_category_data['model'] = $query_model->row['name'];

        return $product_category_data;
    }

    /*
     * Function to get description for auto tires
     * */
    public function getAutoTiresDescription($id){
        $query_description = $this->db->query("SELECT * FROM " . DB_PREFIX . "shiny_description WHERE product_id = " . (int)$id);

        $description = strip_tags($query_description->row['description']);
        $description = str_replace("\n", ' ', $description);

        return $description;
    }

    /*
     * Function to change status from auto tires list
     * */
    public function autoTiresStatusChange($id, $status) {
        $this->db->query("UPDATE " . DB_PREFIX . "shiny SET status = '" . (int)$status . "', date_modified = NOW() WHERE product_id = '" . (int)$id . "'");

        $this->cache->delete('shiny');

        return $id;
    }

    /*
     * Function to get information about auto tires
     * */
    public function getAutoTiresIndex($id) {
        $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$id . "' LIMIT 1) AS keyword FROM " . DB_PREFIX . "shiny p LEFT JOIN " . DB_PREFIX . "shiny_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }

    /*
     * Function to delete auto tires
     * */
    public function deleteProduct($product_id) {
        /* Copy in arhive shiny */
        $this->db->query("INSERT INTO  " . DB_PREFIX . "arhive_shiny SELECT * FROM " . DB_PREFIX . "shiny WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "arhive_shiny_attribute SELECT * FROM " . DB_PREFIX . "shiny_attribute WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "arhive_shiny_description SELECT * FROM " . DB_PREFIX . "shiny_description WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("INSERT INTO  " . DB_PREFIX . "arhive_shiny_image SELECT * FROM " . DB_PREFIX . "shiny_image WHERE product_id = '" . (int)$product_id . "'");
        /* End copy in arhive shiny */

        /* Add date delete shiny */
        $this->db->query("UPDATE  " . DB_PREFIX . "arhive_shiny SET date_delete = NOW() WHERE product_id = '" . (int)$product_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "shiny WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "shiny_attribute WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "shiny_description WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "shiny_image WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");

        $this->cache->delete('shiny');
    }

    /*
     * Function to edit auto tires
     * */
    public function editAutoTires($id, $data, $auto_tires_images, $main_image) {
        if($main_image == "null" || $main_image == "") {
            $main_image = $auto_tires_images[0];
        }
        $this->db->query("UPDATE " . DB_PREFIX . "shiny SET status = '" . $this->db->escape($data['status']) . "', model = '" . $this->db->escape($data['model']) . "', image = '" . $this->db->escape($main_image) . "', length = '" . $this->db->escape($data['year']) . "', version = '" . $this->db->escape($data['type']) . "', isbn = '" . $this->db->escape($data['height']) . "', jan = '" . $this->db->escape($data['width']) . "', mpn = '" . $this->db->escape($data['rSize']) . "', upc = '" . $this->db->escape($data['modelS']) . "', ean = '" . $this->db->escape($data['marka']) . "', location = '" . $this->db->escape($data['condition']) . "',   sku = '" . $this->db->escape($data['season']) . "', quantity = '" . $this->db->escape($data['quantity']) . "', price = '" . $this->db->escape($data['priceUSD']) . "', date_modified = NOW() WHERE product_id = '" . (int)$id . "'");

        $this->db->query("UPDATE " . DB_PREFIX . "shiny_description SET description = '" . $data['description'] . "' WHERE product_id = '" . (int)$id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$id . "'");

        if ($data['telephone'] || $data['stock'] || $data['firstname']) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "shiny_attribute WHERE product_id = '" . (int)$id . "'");

            $this->db->query("INSERT INTO " . DB_PREFIX . "shiny_attribute SET product_id = '" . (int)$id . "', attribute_id = '12', language_id = '1', text = '" .  $this->db->escape($data['firstname']) . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "shiny_attribute SET product_id = '" . (int)$id . "', attribute_id = '13', language_id = '1', text = '" .  $this->db->escape($data['telephone']) . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "shiny_attribute SET product_id = '" . (int)$id . "', attribute_id = '17', language_id = '1', text = '" .  $this->db->escape($data['stock']) . "'");
        }

        if (!empty($auto_tires_images)) {
            foreach ($auto_tires_images as $image) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "shiny_image SET product_id = '" . (int)$id . "', image = '" . $this->db->escape($image) . "', sort_order = '1'");
            }
        }

        $this->cache->delete('product');
    }

    /*
     * Function to add images from auto tires list
     * */
    public function addAutoTiresImagesFromList($id, $images) {
        $main_image = $this->db->query("SELECT image FROM " . DB_PREFIX . "shiny WHERE product_id = " . (int)$id);

        if($main_image->row['image'] == "" && $main_image->row['image'] == null) {
            $this->db->query("UPDATE " . DB_PREFIX . "shiny SET image = '" . $images[0] . "', date_modified = NOW() WHERE product_id = '" . (int)$id . "'");
        }

        if (!empty($images)) {
            foreach ($images as $image) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "shiny_image SET product_id = '" . (int)$id . "', image = '" . $this->db->escape($image) . "', sort_order = '1'");
            }
        }

        $this->cache->delete('shiny');
    }

    /*
     * Function to update price from auto tires list
     * */
    public function autoTiresPriceChange($id, $price) {
        $this->db->query("UPDATE " . DB_PREFIX . "shiny SET price = '" . (int)$price . "', date_modified = NOW() WHERE product_id = '" . (int)$id . "'");

        $this->cache->delete('shiny');

        return $id;
    }

    /*
     * Function to get model for auto tires
     * */
    public function getModelProduct($model) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "shiny WHERE model = '" . $this->db->escape($model) . "'");

        return $query->row;
    }

    /*
     * Function to search last modal auto tires
     * */
    public function chekMaxModel(){
        $query= $this->db->query("SELECT MAX(product_id) FROM " . DB_PREFIX . "shiny");

        return $query->row;
    }

    /*
     * Function to add auto tires
     * */
    public function addAutoTires($data, $auto_tires_images) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "shiny SET status = '" . $this->db->escape($data['status']) . "', model = '" . $this->db->escape($data['model']) . "', image = '" . $this->db->escape($main_image) . "', length = '" . $this->db->escape($data['year']) . "', version = '" . $this->db->escape($data['type']) . "', isbn = '" . $this->db->escape($data['height']) . "', jan = '" . $this->db->escape($data['width']) . "', mpn = '" . $this->db->escape($data['rSize']) . "', upc = '" . $this->db->escape($data['modelS']) . "', ean = '" . $this->db->escape($data['marka']) . "', location = '" . $this->db->escape($data['condition']) . "',   sku = '" . $this->db->escape($data['season']) . "', quantity = '" . $this->db->escape($data['quantity']) . "', price = '" . $this->db->escape($data['priceUSD']) . "', date_added = NOW()");

        $product_id = $this->db->getLastId();

        if (isset($data['imagesMain'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "shiny SET image = '" . $this->db->escape($data['imagesMain']) . "' WHERE product_id = '" . (int)$product_id . "'");
        }

        if (!empty($auto_tires_images)) {
            foreach ($auto_tires_images as $image) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "shiny_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($image) . "', sort_order = '1'");
            }
        }

        $this->db->query("INSERT INTO " . DB_PREFIX . "shiny_description SET product_id = '" . (int)$product_id . "', name = '" . $this->db->escape($data['description']) . "', language_id = '1', description = '" . $this->db->escape($data['description']) . "', tag = '', meta_title = '', meta_h1 = '', meta_description = '', meta_keyword = ''");

        if ($data['telephone'] || $data['stock'] || $data['firstname']) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "shiny_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '12', language_id = '1', text = '" .  $this->db->escape($data['firstname']) . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "shiny_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '13', language_id = '1', text = '" .  $this->db->escape($data['telephone']) . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "shiny_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '17', language_id = '1', text = '" .  $this->db->escape($data['stock']) . "'");
        }

        $this->cache->delete('shiny');

        return $product_id;
    }
}
?>