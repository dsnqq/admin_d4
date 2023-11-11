<?php
    class ModelCatalogHistoryUsers extends Model {
        public function getUserList($data = array()) {
            $sql = "SELECT * FROM `" . DB_PREFIX . "user`";

            $sort_data = array(
                'username',
                'status',
                'date_added'
            );

            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql .= " ORDER BY " . $data['sort'];
            } else {
                $sql .= " ORDER BY username";
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

        public function getChangeProductData($product_id) {
            $changeProductData = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_change p LEFT JOIN " . DB_PREFIX . "user pd ON (p.user_id = pd.user_id)  WHERE product_id = '" . (int)$product_id . "'");

            return $changeProductData->rows;
        }

        public function getChangeProductHistoryData($data = array()) {
            if (!empty($data['filter_model'])) {
                $sql = "SELECT * FROM " . DB_PREFIX . "product_change p LEFT JOIN " . DB_PREFIX . "user pd ON (p.user_id = pd.user_id) LEFT JOIN " . DB_PREFIX . "product x ON (p.product_id = x.product_id) WHERE pd.user_id = '" . (int)$data['user_id']  . "' AND x.model LIKE '" . $this->db->escape($data['filter_model']) . "'";
            } else {
                $sql = "SELECT * FROM " . DB_PREFIX . "product_change p LEFT JOIN " . DB_PREFIX . "user pd ON (p.user_id = pd.user_id) WHERE pd.user_id = '" . (int)$data['user_id'] . "'";
                $sql .= " ORDER BY p.data_change DESC ";

                if (isset($data['start']) || isset($data['limit'])) {
                    if ($data['start'] < 0) {
                        $data['start'] = 0;
                    }

                    if ($data['limit'] < 1) {
                        $data['limit'] = 20;
                    }

                    $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
                }
            }

            $changeProductHisoryData = $this->db->query($sql);

            return $changeProductHisoryData->rows;
        }

        public function getArhiveHistoryData($product_id) {
            $changeProductHisoryData = $this->db->query("SELECT * FROM " . DB_PREFIX . "arhive WHERE product_id = '" . (int)$product_id . "'");

            return $changeProductHisoryData->rows;
        }

        public function getTotalChanges($user_id) {
            $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product_change` WHERE user_id = '" . (int)$user_id . "'");

            return $query->row['total'];
        }

        public function getProductCategories($product_id) {
            $product_category_data = array();

            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

            foreach ($query->rows as $result) {
                $product_category_data[] = $result['category_id'];
            }

            return $product_category_data;
        }

        public function getProductCategoriesX($product_id) {
            $product_category_data = array();

            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "arhive_to_category WHERE product_id = '" . (int)$product_id . "'");

            foreach ($query->rows as $result) {
                $product_category_data[] = $result['category_id'];
            }

            return $product_category_data;
        }
    }
?>