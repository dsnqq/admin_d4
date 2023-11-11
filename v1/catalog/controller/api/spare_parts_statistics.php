<?php
    class ControllerApiSparePartsStatistics extends Controller {
        /*
         * Main function to handle HTTP request
         * */
        // https://d4.by/index.php?route=api/spare_parts_statistics
        public function index() {
            $postRead  = json_decode(file_get_contents('php://input'),true);
            $postWrite = $this->request->post;

            $route = $this->request->get['route'];
            $path = explode('/', $route);
            $login = $this->_getAuth($postRead, $this->request->server);

            $login = true; // NO AUTH

            try {
                if($login){
                    $this->findRenderComponent($path, $postRead, $postWrite);

                    if (isset($this->request->server['HTTP_ORIGIN'])) {
                        $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
                        $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
                        $this->response->addHeader('Access-Control-Max-Age: 1000');
                        $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
                    }

                    $this->response->addHeader('Content-Type: application/json');
                } else {
                    $this->response->redirect($this->url->link('error/not_found', '', true));
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }


        /*
         * Function find component BY methods
         * */
        private function findRenderComponent($path, $postRead, $postWrite) {
            if($this->isSparePartsStatistics($path, $postRead)) {
                $this->_getSparePartsStatistics($postRead);
            } elseif($this->isSparePartsStatisticsTotals($path)) {
                $this->_getSparePartsStatisticsTotals();
            } elseif($this->isSparePartsStatisticsDay($path)) {
                $this->_getSparePartsStatisticsDay();
            }
        }

        /*
         * Function to Auth
         * Add token and session['api_id']
         * */
        private function _getAuth($post, $serve) {
            if (!isset($_SESSION['api_id'])) {
                $this->load->model('account/api');

                $api_info = $this->model_account_api->getApiByKey($post['key']);

                if ($api_info) {
                    $ip_data = array();

                    $results = $this->model_account_api->getApiIps($api_info['api_id']);

                    foreach ($results as $result) {
                        $ip_data[] = trim($result['ip']);
                    }

                    if (in_array($serve['REMOTE_ADDR'], $ip_data)) {
                        session_start();
                        $_SESSION['api_id'] = $api_info['api_id'];

                        return true;
                    }
                    //throw new Exception('Неверный IP клиента');
                    return false;
                }
                //throw new Exception('Неверный ключ API');
                return false;
            } else {
                return true;
            }
        }

        /*
         * Function to get spare parts statistics first
         * */
        public function _getSparePartsStatistics($param) {
            $json = [];

            if (isset($param['page'])) {
                $page = (int)$param['page'];
            } else {
                $page = 1;
            }

            $product_view_all_json = $this->cache->get('sparePartsStatistics.' . $page);

            if (!$product_view_all_json) {
                $this->load->model('catalog/spare_parts_statistics');
                $this->load->model('catalog/product');

                $countAllArray = [];
                $countInt = 0;

                if (isset($param['limit'])) {
                    $limit = (int)$param['limit'];
                } else {
                    $limit = 100;
                }

                $filter_data = array(
                    'start' => ($page - 1) * $limit,
                    'limit' => $limit
                );

                $getProductsAll = $this->model_catalog_spare_parts_statistics->getProductsAll($filter_data); // получить все данные

                foreach ($getProductsAll as $value => $key) {
                    $dateInfo = date('d.m.Y', strtotime("+3 hours", $getProductsAll[$value]['view_date']));
                    $getProductsAll[$value]['view_date'] = $dateInfo;
                    $countAllArray[$dateInfo][$countInt] = $getProductsAll[$value]['product_id'];
                    $countInt++;
                }

                $product_view_all = $this->model_catalog_spare_parts_statistics->getProductsViews($filter_data);

                $i = 1;
                foreach ($product_view_all as $product_view_item) {
                    $number = '';
                    $pageNum = $this->request->get['page'];
                    $tokenT = $this->request->get['token'];
                    $number = ($pageNum) ? ((int)$pageNum * 100) - 100 + $i : $i;
                    $product_info = $this->model_catalog_product->getProduct($product_view_item['product_id']);

                    $product_view_all_json[] = array(
                        'num' => $number,
                        'product_id' => $product_view_item['product_id'],
                        'date' => date('d.m.Y-H:i:s', strtotime("+3 hours", $product_view_item['view_date'])),
                        'name' => $product_view_item['nameStatic'],
                        'linkSite' => "/index.php?route=catalog/product&product_id=" . $product_view_item['product_id'],
                        'linkEdit' => "/admin/index.php?route=catalog/product/edit&token=" . $tokenT . "&product_id=" . $product_view_item['product_id'],
                        'views' => $product_view_item['view_count'],
                        'article' => $product_info['model'],
                        'status' => $product_info['status']
                    );
                    $hot = "";
                    $i++;
                }


                $this->cache->set('sparePartsStatistics.' . $page, $product_view_all_json);
            }

            $json['sparePartsStatistics'] = $product_view_all_json;

            $this->response->setOutput(json_encode($json));
        }

        /*
         * Function to get spare parts statistics first
         * */
        public function _getSparePartsStatisticsDay() {
            $json = [];

            $this->load->model('catalog/spare_parts_statistics');
            $this->load->model('catalog/product');

            $countAllArray = [];
            $countInt = 0;

            if(isset($param['page'])) {
                $page = (int)$param['page'];
            } else {
                $page = 1;
            }

            if (isset($param['limit'])) {
                $limit = (int)$param['limit'];
            } else {
                $limit = 100;
            }

            $filter_data = array(
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );

            $getProductsAll = $this->model_catalog_spare_parts_statistics->getProductsAll($filter_data); // получить все данные

            $sparePartsStatisticsDay = [];

            foreach ($getProductsAll as $value => $key) {
                $dateInfo = date('d.m.Y', strtotime("+3 hours", $getProductsAll[$value]['view_date']));
                $getProductsAll[$value]['view_date'] = $dateInfo;
                $countAllArray[$dateInfo][$countInt] = $getProductsAll[$value]['product_id'];
                $countInt++;
            }

            foreach ($countAllArray as $item => $key) {
                $sparePartsStatisticsDay[] = array(
                    'date' => $item,
                    'count' => count($key)
                );
            }

            $sparePartsStatisticsDay = array_reverse($sparePartsStatisticsDay, true);

            $json['sparePartsStatisticsDay'] = $sparePartsStatisticsDay;

            $this->response->setOutput(json_encode($json));
        }

        /*
         * Function to get spare parts statistics totals
         * */
        public function _getSparePartsStatisticsTotals() {
            $json = [];

            $this->load->model('catalog/spare_parts_statistics');

            $total = $this->model_catalog_spare_parts_statistics->getTotalSparePartsStatistics();

            $json['totalsSparePartsStatistics'] = (int)$total;

            $this->response->setOutput(json_encode($json));
        }

        /*
         * @route: api/spare_parts_statistics/index/day
         * Url settings for spare parts statistics days
         * */
        private function isSparePartsStatisticsDay($path) {
            return !isset($path[4]) && $path[3] == 'day';
        }

        /*
         * @route: api/spare_parts_statistics/index
         * Url settings for spare parts statistics first
         * */
        private function isSparePartsStatistics($path) {
            return !isset($path[3]) && $path[2] == 'index';
        }

        /*
         * @route: api/spare_parts_statistics/totals
         * Url setting for spare parts statistics totals
         * */
        private function isSparePartsStatisticsTotals($path) {
            return !isset($path[4]) && $path[3] == 'totals';
        }
    }
?>