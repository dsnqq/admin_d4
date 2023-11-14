<?php
class ControllerApiDashboardAdmin extends Controller {

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

                /* Deleted cache all statistics every day on 9.00 Minsk */
                if(date('h') == "06") {
                    $this->cache->delete('dashboardInformations');
                    $this->cache->delete('sparePartsStatistics');
                    $this->cache->delete('brandAndModelCar');
                    $this->cache->delete('typesOfAutoParts');
                }
                /* End */

                $this->findRenderComponent($path, $postRead);

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
        if($this->isDashboardAdmin($path)) {
            $this->_getDashboardInformation();
        } elseif($this->isSetDashboardCurrency($path)) {
            $this->_setDashboardCurrency($postRead);
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
     * Function to get information on dashboard
     * */
    private function _getDashboardInformation() {
        $json = [];
        $dateInThisMounth = 0;

        $dashboardInformations = $this->cache->get('dashboardInformations');

        if (!$dashboardInformations) {
            $this->load->model('catalog/dashboard_admin');

            $autoPartsCount = $this->model_catalog_dashboard_admin->getAutoPartsCount();
            $tireCount = $this->model_catalog_dashboard_admin->getTireCount();
            $autoPartsPriceAll = $this->model_catalog_dashboard_admin->getAutoPartsPriceAll();
            $tirePriceAll = $this->model_catalog_dashboard_admin->getTirePriceAll();
            $usersCount = $this->model_catalog_dashboard_admin->getUsersCount();
            $newAutoPartsMouth = $this->model_catalog_dashboard_admin->getNewAutoPartsMouth();
            $saleAutoPartsMouth = $this->model_catalog_dashboard_admin->getSaleAutoPartsMouth();
            $arhiveAutoParts = $this->model_catalog_dashboard_admin->getArhiveAutoParts();
            $totalOrders = $this->model_catalog_dashboard_admin->getTotalOrders();
            $currencyAll = $this->model_catalog_dashboard_admin->getCurrency();
            $autoPartsViewMouth = $this->model_catalog_dashboard_admin->getAutoPartsViewMouth();

            foreach ($currencyAll as $item) {
                $item['value'] = round($item['value'], 2);

                if ($item['code'] == 'BYN') {
                    $currency['USD'] = $item['value'];
                }
                if ($item['code'] == 'RUB') {
                    $currency['RUB'] = $item['value'];
                }
                if ($item['code'] == 'EUR') {
                    $currency['EUR'] = $item['value'];
                }
            }


            foreach ($autoPartsViewMouth as $item) {
                $dateInfo = date('m', strtotime("+3 hours", $item['view_date']));
                if ($dateInfo == date('m')) {
                    $dateInThisMounth++;
                }
            }

            $sectionS = [
                [
                    "title" => 'Запчасти (Активные/Неактив)',
                    "text" => $autoPartsCount[0] . '/' . $autoPartsCount[1] . ' шт.',
                    "iconClass" => 'bi bi-wrench',
                    "iconColorClass" => 'text-success'
                ],
                [
                    "title" => 'Шины (Активные/Неактив)',
                    "text" => $tireCount[0] . '/' . $tireCount[1] . ' шт.',
                    "iconClass" => 'bi bi-vinyl',
                    "iconColorClass" => 'text-success'
                ],
                /*[
                    "title" => 'Сумма всех запчастей',
                    "text" => $autoPartsPriceAll . '$',
                    "iconClass" => 'bi bi-wrench',
                    "iconColorClass" => 'text-success'
                ],
                [
                    "title" => 'Сумма всех шин',
                    "text" => $tirePriceAll . '$',
                    "iconClass" => 'bi bi-vinyl',
                    "iconColorClass" => 'text-success'
                ],*/
                [
                    "title" => 'Просмотры З/Ч за этот месяц',
                    "text" => $dateInThisMounth . ' шт.',
                    "iconClass" => 'bx bx-show',
                    "iconColorClass" => 'text-success'
                ],
                [
                    "title" => 'Кол-во пользователей',
                    "text" => $usersCount . ' чел.',
                    "iconClass" => 'bi bi-people',
                    "iconColorClass" => 'text-success'
                ],
            ];

            $sectionM = [
                [
                    "title" => "Свежие запчасти",
                    "text" => "Добавлено в этом месяце",
                    "result" => $newAutoPartsMouth,
                    "colorClass" => "text-primary",
                    "iconClass" => "bi bi-cloud-plus"
                ],
                [
                    "title" => "Проданные запчасти",
                    "text" => "Продано в этом месяце",
                    "result" => $saleAutoPartsMouth,
                    "colorClass" => "text-danger",
                    "iconClass" => "bi bi-award-fill"
                ],
                [
                    "title" => "Всего заказов",
                    "text" => "Заказов через корзину",
                    "result" => $totalOrders,
                    "colorClass" => "text-success",
                    "iconClass" => "bi bi-basket2-fill"
                ],
                [
                    "title" => "В архиве",
                    "text" => "Сейчас запчастей в архиве",
                    "result" => $arhiveAutoParts,
                    "colorClass" => "text-orange",
                    "iconClass" => "bi bi-archive"
                ]
            ];

            $dashboardInformations = array(
                'sectionS' => $sectionS,
                'sectionM' => $sectionM,
                'currency' => $currency
            );

            $this->cache->set('dashboardInformations', $dashboardInformations);
        }

        $json['dashboardInformations'] = $dashboardInformations;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to set currency
     * */
    private function _setDashboardCurrency($param) {
        $json = [];

        $currency = $param['currency'];
        $value = $param['value'];

        if($currency && $value) {
            $this->load->model('catalog/dashboard_admin');

            if($currency == "USD") {
                $currency = "BYN";
            }

            $this->cache->delete('dashboardInformations');
            $this->model_catalog_dashboard_admin->setCurrency($currency, $value);

            $json['currencyPrice'] = true;
        } else {
            $json['currencyPrice'] = $currency;
        }

        $this->response->setOutput(json_encode($json));

    }
    
    /*
     * @route: api/dashboard_admin/index/
     * Url information to dashboard
     * */
    private function isDashboardAdmin($path) {
        return !isset($path[3]) && $path[2] == 'index';
    }

    /*
     * @route: api/dashboard_admin/index/currency
     * Url set currency
     * */
    private function isSetDashboardCurrency($path) {
        return !isset($path[4]) && $path[3] == 'currency';
    }


}
?>