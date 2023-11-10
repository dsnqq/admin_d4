<?php
class ControllerApiAutoPartsArchive extends Controller
{
    /*
     * Main function to handle HTTP request
     * */
    public function auto() {
        $postRead  = json_decode(file_get_contents('php://input'),true);
        $postWrite = $this->request->post;

        $route = $this->request->get['route'];
        $path = explode('/', $route);
        $login = $this->_getAuth($postRead, $this->request->server);

        $login = true; // NO AUTH

        try {
            if($login){
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
        if($this->isAutoPartsArchive($path)) {
            $this->_getAutoPartsArchive($postRead);
        } elseif($this->isAutoPartsArchiveTotals($path)) {
            $this->_getAutoPartsArchiveTotals($postRead);
        } elseif($this->isAutoPartsArchiveIndex($path)) {
            $this->_getAutoPartsArchiveIndex($path[4]);
        } elseif($this->isAutoPartsArchiveHistory($path)) {
            $this->_getAutoPartsArchiveHistory($path[4]);
        } elseif ($this->isAutoPartsArchiveRestore($path)) {
            $this->_setAutoPartsArchiveRestore($path[4], $postRead);
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
     * Function to get all auto parts
     * */
    private function _getAutoPartsArchive($param){
        $json = [];
        $i = 1;

        if(isset($param['page'])) {
            $page = (int)$param['page'];
        } else {
            $page = 1;
        }

        if(isset($param['filter_sparePartNumber'])){
            $filter_sparePartNumber = $param['filter_sparePartNumber'];
        } else {
            $filter_sparePartNumber = '';
        }

        if(isset($param['filter_model'])){
            $filter_model = $param['filter_model'];
        } else {
            $filter_model = '';
        }

        if(isset($param['filter_types'])){
            $filter_types = $param['filter_types'];
        } else {
            $filter_types = '';
        }

        if(isset($param['filter_value'])){
            $filter_value = $param['filter_value'];
        } else {
            $filter_value = '';
        }

        if(isset($param['filter_year_start'])){
            $filter_year_start = $param['filter_year_start'];
        } else {
            $filter_year_start = '';
        }

        if(isset($param['filter_year_last'])){
            $filter_year_last = $param['filter_year_last'];
        } else {
            $filter_year_last = '';
        }

        if(isset($param['filter_category'])){
            $filter_category = $param['filter_category'];
        } else {
            $filter_category = '';
        }

        if(isset($param['filter_fuel']) && !($param['filter_fuel'] == 'Не выбрано')){
            $filter_fuel = $param['filter_fuel'];
        } else {
            $filter_fuel = '';
        }

        $filter_data = array(
            'filter_sparePartNumber' => $filter_sparePartNumber,
            'filter_year_start'      => $filter_year_start,
            'filter_year_last'       => $filter_year_last,
            'filter_model'           => $filter_model,
            'filter_fuel'            => $filter_fuel,
            'filter_value'           => $filter_value,
            'filter_types'           => $filter_types,
            'filter_category'        => $filter_category,
            'start'                  => ($page - 1) * 20,
            'limit'                  => 20,
            'sort'                   => 'p.date_added',
            'order'                  => 'DESC'
        );

        $this->load->model('tool/image');
        $this->load->model('catalog/auto_parts_archive');

        $results = $this->model_catalog_auto_parts_archive->getProducts($filter_data);

        foreach ($results as $result) {
            $images = array();
            $i = 1;

            $name =  $this->model_catalog_auto_parts_archive->getAutoName($result['product_id']);

            $imagesThumb = $this->model_catalog_auto_parts_archive->getProductImages($result['product_id']);

            if($result['image']) {
                $image = $result['image'];
            } else {
                $image = 'no_image.png';
            }

            $images[] = array(
                'imageMini' => $this->model_tool_image->resize($image, 150, 150),
                'imageBig' => $result['image'],
                'imageShow' => true
            );

            foreach ($imagesThumb as $image) {
                if($image['image'] != $result['image']) {
                    $images[] = array(
                        'imageMini' => $this->model_tool_image->resize($image['image'], 150, 150),
                        'imageBig' => $image['image'],
                        'imageShow' => ($i > 5) ? false : true
                    );

                    $i++;
                }
            }

            $auto_stax_view = $this->model_catalog_auto_parts_archive->getProductCountStaxView($result['product_id']);

            $auto_parts_archive_description = $this->model_catalog_auto_parts_archive->getAutoPartsDescription($result['product_id']);
            $auto_parts_archive = $this->model_catalog_auto_parts_archive->getAutoPartsName($result['manufacturer_id']);

            $date_available = new DateTime($result['date_available']);
            $date_available = $date_available->format("d.m.Y");

            $date_deleted = new DateTime($result['date_deleted']);
            $date_deleted = $date_deleted->modify('+3 hours')->format("d.m.Y H:i:s");

            $autoPartsArchive[] = array(
                'product_id' => $result['product_id'],
                'model'      => $result['model'],
                'images'    => $images,
                'title'     => $name['marka'] . ' ' . $name['model'],
                'imagesShowAllImage' => (count($images) > 6) ? false : true,
                'name'      => $name,
                'autoParts' => $auto_parts_archive,
                'year'      => $result['length'],
                'modification'      => $result['version'],
                'fuel'      => $result['isbn'],
                'value'      => $result['jan'],
                'typeEngines'      => $result['mpn'],
                'transmission'      => $result['upc'],
                'typeBody'      => $result['ean'],
                'wheelDiameterR'      => $result['location'],
                'wheelWidthJ'      => $result['width'],
                'numberOfHoles'      => $result['height'],
                'departureE'      => $result['etvylet'],
                'diameter'      => $result['diadiametr'],
                'pcd'      => $result['weight'],
                'sparePartNumber'      => $result['sku'],
                'priceUSD'      => $result['price'],
                'dateAvailable'      => $date_available,
                'dateDeleted'      => $date_deleted,
                'view' => $auto_stax_view,
                'linkToSite'      => '/index.php?route=product/product&product_id=' . $result['product_id'],
                'status'      => $result['status'],
                'description'      => $auto_parts_archive_description

            );
        }

        $json['autoPartsArchive'] = $autoPartsArchive;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to get auto parts totals
     * */
    private function _getAutoPartsArchiveTotals($param){
        $json = [];

        $this->load->model('catalog/auto_parts_archive');

        if(isset($param['filter_sparePartNumber'])){
            $filter_sparePartNumber = $param['filter_sparePartNumber'];
        } else {
            $filter_sparePartNumber = '';
        }

        if(isset($param['filter_model'])){
            $filter_model = $param['filter_model'];
        } else {
            $filter_model = '';
        }

        if(isset($param['filter_year_start'])){
            $filter_year_start = $param['filter_year_start'];
        } else {
            $filter_year_start = '';
        }

        if(isset($param['filter_year_last'])){
            $filter_year_last = $param['filter_year_last'];
        } else {
            $filter_year_last = '';
        }

        if(isset($param['filter_category'])){
            $filter_category = $param['filter_category'];
        } else {
            $filter_category = '';
        }

        if(isset($param['filter_types'])){
            $filter_types = $param['filter_types'];
        } else {
            $filter_types = '';
        }

        if(isset($param['filter_value'])){
            $filter_value = $param['filter_value'];
        } else {
            $filter_value = '';
        }

        if(isset($param['filter_fuel']) && !($param['filter_fuel'] == 'Не выбрано')){
            $filter_fuel = $param['filter_fuel'];
        } else {
            $filter_fuel = '';
        }

        $filter_data = array(
            'filter_sparePartNumber' => $filter_sparePartNumber,
            'filter_model'           => $filter_model,
            'filter_fuel'            => $filter_fuel,
            'filter_value'           => $filter_value,
            'filter_year_start'      => $filter_year_start,
            'filter_year_last'       => $filter_year_last,
            'filter_types'           => $filter_types,
            'filter_category'        => $filter_category,
        );

        $autoPartsArchiveTotals = $this->model_catalog_auto_parts_archive->getTotalsAutoParts($filter_data);

        $json['autoPartsArchiveTotals'] = (int)$autoPartsArchiveTotals;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Functuin to restore deleted product
     * */
    private function _setAutoPartsArchiveRestore($id, $post){
        $json = [];

        $this->load->model('catalog/auto_parts_archive');

        $user_id = (int)$post['user_id'];

        if($user_id && $user_id != 0) {
            $restore_product_id = $this->model_catalog_auto_parts_archive->restoreProduct((int)$id);

            $this->model_catalog_auto_parts_archive->addChangeProductData("", "", "Восстановил З/Ч", $restore_product_id, $user_id);
        }

        $json['autoPartsArchiveRestore'] = $restore_product_id;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to get auto parts index
     * */
    private function _getAutoPartsArchiveIndex($id){
        $json = [];

        $this->load->model('catalog/auto_parts_archive');

        $results = $this->model_catalog_auto_parts_archive->getAutoPartsIndex($id);

        $autoPartsArchiveIndex = array(
            'product_id' => $results['product_id'],
            'model'      => $results['model'],
            //'images'    => $images,
            //'imagesShowAllImage' => (count($images) > 6) ? false : true,
            //'name'      => $name,
            //'autoParts' => $auto_parts,
            'year'      => $results['length'],
            'modification'      => $results['version'],
            'fuel'      => $results['isbn'],
            'value'      => $results['jan'],
            'typeEngines'      => $results['mpn'],
            'transmission'      => $results['upc'],
            'typeBody'      => $results['ean'],
            'wheelDiameterR'      => $results['location'],
            'wheelWidthJ'      => $results['width'],
            'numberOfHoles'      => $results['height'],
            'departureE'      => $results['etvylet'],
            'diameter'      => $results['diadiametr'],
            'pcd'      => $results['weight'],
            'sparePartNumber'      => $results['sku'],
            'priceUSD'      => $results['price'],
            //'dateAvailable'      => $date_available,
            //'view' => $auto_stax_view,
            'linkToSite'      => '',
            'status'      => $results['status'],
            'youtube'      => $results['youtube'],
            //'description'      => $auto_parts_description
        );


        $json['autoPartsArchiveIndex'] = $autoPartsArchiveIndex;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to get auto parts history
     * */
    private function _getAutoPartsArchiveHistory($id) {
        $json = [];
        $autoPartsArchiveHistory = [];

        $this->load->model('catalog/auto_parts_archive');

        $this->response->setOutput(json_encode($json));

        $history = $this->model_catalog_auto_parts_archive->getAutoParstHistory($id);

        foreach ($history as &$item) {
            if($item["data_change"]) {
                $date2 = new DateTime($item["data_change"]);
                $data_change = $date2->format("d.m.Y H:i:s");
            }

            $autoPartsArchiveHistory[] = array(
                'valueName' => $item['value_name'],
                'valueOld' => $item['value_old'],
                'valueNew' => $item['value_new'],
                'firstName' => $item['firstname'],
                'lastName' => $item['lastname'],
                'dataChange' => $data_change,
            );
        }

        $json['autoPartsArchiveHistory'] = $autoPartsArchiveHistory;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * @route: api/auto_parts_archive/auto
     * Url settings for get all auto parts
     * */
    private function isAutoPartsArchive($path) {
        return !isset($path[3]) && $path[2] == 'auto';
    }

    /*
     * @route: api/auto_parts_archive/auto/totals
     * Url settings for get auto parts totals
     * */
    private function isAutoPartsArchiveTotals($path){
        return !isset($path[4]) && $path[3] == 'totals';
    }

    /*
     * @route: api/auto_parts_archive/auto/index/:product_id
     * Url settings for get auto part index
     * */
    private function isAutoPartsArchiveIndex($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'index';
    }

    /*
     * @route: api/auto_parts_archive/auto/history/:product_id
     * Url settings for get auto part history
     * */
    private function isAutoPartsArchiveHistory($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'history';
    }

    /*
     * @route: api/auto_parts_archive/auto/restore/:product_id
     * Url settings restore product by id
     * */
    private function isAutoPartsArchiveRestore($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'restore';
    }
}