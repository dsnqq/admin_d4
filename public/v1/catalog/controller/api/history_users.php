<?php
    class ControllerApiHistoryUsers extends Controller {
        /*
         * Main function to handle HTTP request
         * */
        // https://d4.by/index.php?route=api/history_users
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
            if($this->isUserList($path)) {
                $this->_getUserList();
            } elseif($this->isUser($path)) {
                $this->_getUser($path, $postRead);
            } elseif($this->isUserTotal($path)) {
                $this->_getUserTotal($path);
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
         * Function to get user information
         * */
        private function _getUser($path, $param) {
            $json = [];
            $changesUser = [];

            $this->load->model('catalog/history_users');
            $this->load->model('catalog/product');
            $this->load->model('catalog/category');
            $this->load->model('tool/image');
            $this->load->model('catalog/manufacturer');

            if(isset($param['page'])) {
                $page = (int)$param['page'];
            } else {
                $page = 1;
            }

            if (isset($this->request->get['filter_model'])) {
                $filter_model = $this->request->get['filter_model'];
            } else {
                $filter_model = null;
            }

            $filter_data_h = array(
                'user_id'  => $path[3],
                'start' => ($page - 1) * 30,
                'filter_model'	  => $filter_model,
                'limit' => 30
            );

            $changes = $this->model_catalog_history_users->getChangeProductHistoryData($filter_data_h);

            foreach ($changes as $result) {
                $product_info_history = $this->model_catalog_product->getProduct($result['product_id']);
                $arhive_info_history = $this->model_catalog_history_users->getArhiveHistoryData($result['product_id']);

                $manufacturer_product = $this->model_catalog_manufacturer->getManufacturer((int)$product_info_history['manufacturer_id']);
                $manufacturer_arhive = $this->model_catalog_manufacturer->getManufacturer((int)$arhive_info_history[0]['manufacturer_id']);

                $categories = $this->model_catalog_history_users->getProductCategories($product_info_history['product_id']);
                $category_paths = array();
                foreach($categories as $cat) {
                    $category = $this->model_catalog_category->getCategory($cat);
                    $category_paths[] = (($category['path']) ? $category['path'] . '  ' : '') . $category['name'];
                }
                $cat_qr_product = implode("<br />", $category_paths);

                $categories_x = $this->model_catalog_history_users->getProductCategoriesX($arhive_info_history[0]['product_id']);
                $category_paths_x = array();
                foreach($categories_x as $cat) {
                    $category = $this->model_catalog_category->getCategory($cat);
                    $category_paths_x[] = (($category['path']) ? $category['path'] . '  ' : '') . $category['name'];
                }
                $cat_qr_arhive = implode("<br />", $category_paths_x);

                if($result['value_name'] == "Статус") {
                    $result['value_old'] = ($result['value_old'] == 1) ? "Активно" : "Неактивно";
                    $result['value_new'] = ($result['value_new'] == 1) ? "Активно" : "Неактивно";
                }

                $date = new DateTime($result['data_change']);
                $result['data_change'] = $date->format("d.m.Y H:i:s");

                if($arhive_info_history[0]) {
                    $name = $manufacturer_arhive['name'] . ' к ' . $cat_qr_arhive . ', ' . $arhive_info_history[0]['length'];
                } elseif($manufacturer_product['name']) {
                    $name = $manufacturer_product['name'] . ' к ' . $cat_qr_product . ', ' . $product_info_history['length'];
                }

                $productBool = true;
                if($arhive_info_history[0]['price']) {
                    $priceUSD = $arhive_info_history[0]['price'] . '$';
                } elseif($product_info_history['price'] && $product_info_history['price'] != "") {
                    $priceUSD = $product_info_history['price'] . '$';
                } else {
                    $productBool = false;
                }

                if(round($this->currency->convert($arhive_info_history[0]['price'], "USD", 'BYN'), '0')){
                    $priceBYN = round($this->currency->convert($arhive_info_history[0]['price'], "USD", 'BYN'), '0')."р.";
                } elseif($productBool) {
                    $priceBYN = round($this->currency->convert($product_info_history['price'], "USD", 'BYN'), '0')."р.";
                }

                if($product_info_history['model']) {
                    $productModel = $product_info_history['model'];
                } else {
                    $productModel = $arhive_info_history[0]['model'];
                }

                if($arhive_info_history[0]) {
                    $nowSection = 'В архиве (Удалено)';
                } elseif($productBool) {
                    $nowSection = 'В списке запчастей';
                } else {
                    $nowSection = 'Запчасть удалена слишком давно';
                }
                
                if($arhive_info_history[0]) {
                    $image = $this->model_tool_image->resize($arhive_info_history[0]['image'], 100, 100);
                } elseif($product_info_history['image']) {
                    $image = $this->model_tool_image->resize($product_info_history['image'], 100, 100);
                } else {
                    $image = $this->model_tool_image->resize('no_image.png', 100, 100);
                }

                $changesUser[] = array(
                    'name' => $name,
                    'priceUSD' => $priceUSD,
                    'priceBYN' => $priceBYN,
                    'productModel' => $productModel,
                    'dataChange'   => $result['data_change'],
                    'valueOld'   => $result['value_old'],
                    'valueNew'   => $result['value_new'],
                    'valueName' => $result['value_name'],
                    'nowSection' => $nowSection,
                    'image' => $image,
                );
            }

            $json['userHistory'] = $changesUser;

            $this->response->setOutput(json_encode($json));
        }

        /*
         * Function to get total product user
         * */
        private function _getUserTotal($path) {
            $json = [];

            $this->load->model('catalog/history_users');

            $changes_total = $this->model_catalog_history_users->getTotalChanges($path[3]);

            $json['userHistoryTotal'] = (int)$changes_total;

            $this->response->setOutput(json_encode($json));
        }

        /*
         * Function to get all users
         * */
        private function _getUserList() {
            $json = [];

            $this->load->model('catalog/history_users');

            if (isset($this->request->get['sort'])) {
                $sort = $this->request->get['sort'];
            } else {
                $sort = 'username';
            }

            if (isset($this->request->get['order'])) {
                $order = $this->request->get['order'];
            } else {
                $order = 'ASC';
            }

            if (isset($this->request->get['page'])) {
                $page = $this->request->get['page'];
            } else {
                $page = 1;
            }

            $filter_data = array(
                'sort'  => $sort,
                'order' => $order,
                'start' => ($page - 1) * 30,
                'limit' => 30
            );

            $results = $this->model_catalog_history_users->getUserList($filter_data);

            foreach ($results as $result) {
                $userHistoryList[] = array(
                    'user_id' => $result['user_id'],
                    'lastname' => $result['lastname'],
                    'firstname' => $result['firstname'],
                    'username' => $result['username'],
                    'status' => $result['status'],
                    'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                    'edit' => $this->url->link('user/history/edit', 'token=' . $this->session->data['token'] . '&user_id=' . $result['user_id'] . $url, true)
                );
            }

            $json['userHistoryList'] = $userHistoryList;

            $this->response->setOutput(json_encode($json));
        }

        /*
         * @route: api/history_users/index/:user_id
         * Url to get history user
         * */
        private function isUser($path) {
            return !isset($path[4]) && is_numeric(trim($path[3])) && $path[2] == 'index';
        }

        /*
         * @route: api/history_users/index
         * Url
         * */
        private function isUserList($path) {
            return !isset($path[3]) && $path[2] == 'index';
        }

        /*
         * @route: api/history_users/index/:user_id/total
         * Url to get total product by 1 user
         * */
        private function isUserTotal($path) {
            return !isset($path[5]) && is_numeric(trim($path[3])) && $path[2] == 'index' && $path[4] == 'total';
        }
    }
?>