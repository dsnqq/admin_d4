<?php
    class ControllerApiOrderSale extends Controller {
        /*
         * Main function to handle HTTP request
         * */
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
        private function findRenderComponent($path, $postRead) {
            if($this->isOrderSale($path)) {
                $this->_getOrderSale($path[3]);
            } elseif($this->isOrderSaleTotals($path)) {
                $this->_getOrderSaleTotals($path);
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
         * Function to get order sales
         * */
        private function _getOrderSale($page){
            $json = [];

            $this->load->model('catalog/order_sale');

            if(isset($page)) {
                $page = (int)$page;
            } else {
                $page = 1;
            }

            $filter_data = array(
                'filter_order_status'  => '2,3,1,12,5',
                'sort'                 => 'o.order_id',
                'order'                => 'DESC',
                'start'                => ($page - 1) * 50,
                'limit'                => 50
            );

            $results = $this->model_catalog_order_sale->getOrders($filter_data);

            foreach ($results as $result) {
                $i = 1;
                $order_products = [];
                $order_info = $this->model_catalog_order_sale->getOrderProducts($result['order_id']);

                foreach($order_info as $item) {
                    $order_products[] = array(
                        'number' => $i,
                        'name'  => str_replace('undefined','',$item['name'])." ".$item['model'],
                        'price' => round($item['price'])
                    );
                    $i++;
                }

                $orderSale[] = array(
                    'order_id'      => $result['order_id'],
                    'customer'      => $result['customer'],
                    'email'		=> $result['email'],
                    'product_order' => $order_products,
                    'telephone'	    => $result['telephone'],
                    'name'		=> $result['firstname'] . ' ' . $result['lastname'],
                    'information'   => ($result['shipping_city']) ? $result['shipping_city'] : $result['payment_city'],
                    'shipping_adress'=> $result['shipping_address_1'],
                    'comment'		=> $result['comment'],
                    'order_status'  => $result['order_status'] ? $result['order_status'] : $this->language->get('text_missing'),
                    'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
                    'date_added'    => date("d.m.Y H:i:s", strtotime($result['date_added'])),
                    'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
                    'shipping_code' => $result['shipping_code'],
                    'view'          => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, true),
                    'edit'          => $this->url->link('sale/order/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, true)
                );
            }

            $json['orders'] = $orderSale;

            $this->response->setOutput(json_encode($json));
        }

        /*
         * Function to get order sales totals
         * */
        private function _getOrderSaleTotals() {
            $json = [];

            $this->load->model('catalog/order_sale');

            $totals = $this->model_catalog_order_sale->getTotalOrders();

            $json['totals'] = (int)$totals;

            $this->response->setOutput(json_encode($json));
        }

        /*
         * @route: api/order_sale/index/:page
         * Url settings for get orders
         * */
        private function isOrderSale($path) {
            return !isset($path[4]) && is_numeric(trim($path[3])) && $path[2] == 'index';
        }

        /*
         * @route: api/order_sale/index/totals
         * Url settings for get orders
         * */
        private function isOrderSaleTotals($path) {
            return !isset($path[4]) && $path[3] == 'totals';
        }
    }
?>