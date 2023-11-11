<?php

class ModelCatalogDashboardAdmin extends Model {
    public function getAutoPartsCount() {
        $autoParstActive = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE status = 1");
        $autoParstNotActive = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE status = 0");

        return [$autoParstActive->row['total'], $autoParstNotActive->row['total']];
    }
    
    public function getTireCount() {
        $tireActive = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "shiny WHERE status = 1");
        $tireNotActive = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "shiny WHERE status = 0");

        return [$tireActive->row['total'], $tireNotActive->row['total']];
    }
    
    public function getAutoPartsPriceAll() {
        $autoPartsPriceAll = $this->db->query("SELECT SUM(price) FROM " . DB_PREFIX . "product");

        return $autoPartsPriceAll->row['SUM(price)'];
    }
    
    public function getTirePriceAll() {
        $tirePriceAll = $this->db->query("SELECT SUM(price) FROM " . DB_PREFIX . "shiny");
        
        return $tirePriceAll->row['SUM(price)'];
    }
    
    public function getUsersCount() {
        $usersCount = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "user");
        
        return $usersCount->row['total'];
    }

    public function getAutoPartsViewMouth() {
        $autoPartsViewMouth = $this->db->query("SELECT view_date FROM " . DB_PREFIX . "product_stax");

        return $autoPartsViewMouth->rows;
    }
    
    public function getNewAutoPartsMouth() {
        $newAutoPartsMouth = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE MONTH(`date_added`) = MONTH(NOW()) AND YEAR(`date_added`) = YEAR(NOW())");

        return $newAutoPartsMouth->row['total'];
    }
    
    public function getSaleAutoPartsMouth() {
        $saleAutoPartsMouth = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "arhive WHERE MONTH(`date_delete`) = MONTH(NOW()) AND YEAR(`date_delete`) = YEAR(NOW())");

        return $saleAutoPartsMouth->row['total'];
    }
    
    public function getArhiveAutoParts() {
        $arhiveAutoParts = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "arhive");
        
        return $arhiveAutoParts->row['total'];
    }
    
    public function getTotalOrders() {
        $totalOrders = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order");

        return $totalOrders->row['total'];
    }
    
    public function getCurrency() {
        $currency = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency");
        
        return $currency->rows;
    }

    public function setCurrency($currency, $value) {
        $this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '" . $value . "' WHERE code = '" . $currency . "'");

        return true;
    }
}
?>