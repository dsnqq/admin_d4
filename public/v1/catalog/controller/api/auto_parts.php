<?php
class ControllerApiAutoParts extends Controller {
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
        if($this->isAutoParts($path)) {
            $this->_getAutoParts($postRead);
        } elseif($this->isAutoPartsTotals($path)) {
            $this->_getAutoPartsTotals($postRead);
        } elseif($this->isAutoPartsIndex($path)) {
            $this->_getAutoPartsIndex($path[4]);
        } elseif($this->isAutoPartsHistory($path)) {
            $this->_getAutoPartsHistory($path[4]);
        } elseif($this->isAutoPartsDelete($path)) {
            $this->_removeAutorParts($path[4], $postRead);
        } elseif($this->isTypesOfAutoParts($path)) {
            $this->_getTypesOfAutoParts();
        } elseif($this->isBrandModelCarAutoParts($path)) {
            $this->_getBrandModelCarAutoParts();
        } elseif($this->isAutoPartsEdit($path)) {
            $this->_setAutoPartsEdit($path[3], $postWrite);
        } elseif($this->isAutoPartsStatusChange($path)) {
            $this->_setAutoPartsStatusChange($path[4], $postRead);
        } elseif($this->isAutoPartsPriceChange($path)) {
            $this->_setAutoPartsPriceChange($path[4], $postRead);
        } elseif($this->isAutoPartsCreate($path)) {
            $this->_setAutoPartsCreate($postWrite, $postRead);
        } elseif($this->isAutoPartsImagesFromList($path)) {
            $this->_setAutoPartsImagesFromList($path[4], $postRead);
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
    private function _getAutoParts($param){
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

        if(isset($param['filter_status']) && $param['filter_status'] == 'Активно') {
            $filter_status = 1;
        } elseif(isset($param['filter_status']) && $param['filter_status'] == 'Неактивно'){
            $filter_status = 0;
        }

        $filter_data = array(
            'sort'                   => 'p.date_added',
            'order'                  => 'DESC',
            'filter_sparePartNumber' => $filter_sparePartNumber,
            'filter_year_start'      => $filter_year_start,
            'filter_year_last'       => $filter_year_last,
            'filter_model'           => $filter_model,
            'filter_status'          => $filter_status,
            'filter_fuel'            => $filter_fuel,
            'filter_value'           => $filter_value,
            'filter_types'           => $filter_types,
            'filter_category'        => $filter_category,
            'start'                  => ($page - 1) * 20,
            'limit'                  => 20
        );

        $this->load->model('tool/image');
        $this->load->model('catalog/auto_parts');

        $results = $this->model_catalog_auto_parts->getProducts($filter_data);

        foreach ($results as $result) {
            $images = array();
            $i = 1;
            $theNote = "";

            $name =  $this->model_catalog_auto_parts->getAutoName($result['product_id']);

            $imagesThumb = $this->model_catalog_auto_parts->getProductImages($result['product_id']);

            if($result['image']) {
                $image = $result['image'];
            } else {
                $image = 'no_image.png';
            }

            $images[] = array(
                'imageMini' => str_replace('admin.d4.by/v1', 'd4.by', $this->model_tool_image->resize($image, 150, 150)),
                'imageBig' => $result['image'],
                'imageShow' => true
            );

            foreach ($imagesThumb as $image) {
                if($image['image'] != $result['image']) {
                    $images[] = array(
                        'imageMini' => str_replace('admin.d4.by/v1', 'd4.by', $this->model_tool_image->resize($image['image'], 150, 150)),
                        'imageBig' => $image['image'],
                        'imageShow' => ($i > 5) ? false : true
                    );

                    $i++;
                }
            }

            $auto_stax_view = $this->model_catalog_auto_parts->getProductCountStaxView($result['product_id']);

            $auto_parts_description = $this->model_catalog_auto_parts->getAutoPartsDescription($result['product_id']);
            $auto_parts = $this->model_catalog_auto_parts->getAutoPartsName($result['manufacturer_id']);

            $results_additional_fields = $this->model_catalog_auto_parts->getAutoPartsAdditionalFields($result['product_id']);

            foreach ($results_additional_fields as $field) {
                if($field['attribute_id'] == 12) {
                    $theNote = $field['text'];
                }
            }

            $date_added = new DateTime($result['date_added']);
            $date_added = $date_added->format("d.m.Y H:i:s");

            $priceBYN = round($this->currency->convert($result['price'], "USD", 'BYN'), '0');

            $qr_param = array(
                'id' => $result['product_id'],
                'model' => $result['model'],
                'jan' => $result['jan'],
                'ean' => $result['ean'],
                'length' => $result['length'],
                'mpn'      => $result['mpn'],
                'isbn'      => $result['isbn'],
                'upc'      => $result['upc'],
                'markaX'     => $name['marka'],
                'modelX'     => $name['model'],
                'name'     => $auto_parts['name']

            );

            $qr_code = $this->createAutoPartsQrCode($qr_param);

            $autoParts[] = array(
                'product_id' => $result['product_id'],
                'model'      => $result['model'],
                'images'    => $images,
                'imagesShowAllImage' => (count($images) > 6) ? false : true,
                'title'     => $name['marka'] . ' ' . $name['model'],
                'name'      => $name,
                'autoParts' => $auto_parts,
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
                'priceBYN'      => $priceBYN,
                'dateAdded'      => $date_added,
                'view' => $auto_stax_view,
                'qrCode' => $qr_code,
                'theNote' => $theNote,
                'linkToSite'      => '/index.php?route=product/product&product_id=' . $result['product_id'],
                'status'      => $result['status'],
                'description'      => $auto_parts_description

            );
        }

        $json['autoParts'] = $autoParts;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to get auto parts totals
     * */
    private function _getAutoPartsTotals($param){
        $json = [];

        $this->load->model('catalog/auto_parts');

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

        if(isset($param['filter_status']) && $param['filter_status'] == 'Активно') {
            $filter_status = 1;
        } elseif(isset($param['filter_status']) && $param['filter_status'] == 'Неактивно'){
            $filter_status = 0;
        } else {
            $filter_status = '';
        }

        $filter_data = array(
            'filter_sparePartNumber' => $filter_sparePartNumber,
            'filter_model'           => $filter_model,
            'filter_fuel'            => $filter_fuel,
            'filter_status'          => $filter_status,
            'filter_value'           => $filter_value,
            'filter_year_start'      => $filter_year_start,
            'filter_year_last'       => $filter_year_last,
            'filter_types'           => $filter_types,
            'filter_category'        => $filter_category,
        );

        $autoPartsTotals = $this->model_catalog_auto_parts->getTotalsAutoParts($filter_data);

        $json['autoPartsTotals'] = (int)$autoPartsTotals;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to delete auto parts by ID
     * */
    private function _removeAutorParts($id, $post) {
        $json = [];

        $this->load->model('catalog/auto_parts');

        $user_id = (int)$post['user_id'];

        if($user_id && $user_id != 0) {
            $old_product_id = $this->model_catalog_auto_parts->deleteProduct($id);

            $this->model_catalog_auto_parts->addChangeProductData("", "", "Удалил З/Ч", $old_product_id, $user_id);
        }

        $json['autoPartsDelete'] = $old_product_id;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to checked model for auto parts
     * */
    private function isCheckedModel($model) {
        $error = '';
        $this->load->model('catalog/auto_parts');

        if ($model != "") {
            $model_product_info = $this->model_catalog_auto_parts->getModelProduct($model);
            if (($model_product_info['model'] == $model) && ($model_product_info['product_id'] != $this->request->get['product_id'])) {
                $error = "Такой артикул ext_id уже существует!";
            }
            if (preg_match("/[А-Яа-я]/", $model)) {
                $error = "Такой артикул ext_id содержит русские буквы в написании!";
            }
        }

        return $error;
    }

    /*
     * Function to generate model for auto parts
     * */
    private function generateAutoPartsModel() {
        $this->load->model('catalog/auto_parts');

        $chekMaxModel = $this->model_catalog_auto_parts->chekMaxModel();
        $chekMaxModel['MAX(product_id)'] = $chekMaxModel['MAX(product_id)'] + 2;
        $model = $chekMaxModel['MAX(product_id)'];

        return $model;
    }

    /*
     * Function to create new auto parts
     * */
    private function _setAutoPartsCreate($post, $data){
        $json = [];
        $this->load->model('catalog/auto_parts');
        $user_id = (int)$post['user_id'];

        if($this->request->server['REQUEST_METHOD'] == 'POST') {
            if (!$post['autoPartsModelBrandsObject']) { // Тут вариант если добавляем 1 запчасть
                $validate = $this->isCheckedModel($post['model']);

                if ($validate == "") {
                    $date_now = date("d.m.Y");
                    $time = strtotime($date_now);
                    $auto_parts_images = [];

                    $post['model'] = $this->generateAutoPartsModel();

                    if ($post["images"]) {
                        foreach (explode(",", $post["images"]) as $image) {
                            $auto_parts_images[] = "catalog/d4_img/" . $time . "/" . $image;
                        }
                    }

                    if ($post["imagesMain"]) {
                        $post["imagesMain"] = "catalog/d4_img/" . $time . "/" . $post["imagesMain"];
                    }

                    $post['autoPartsNameForBd'] = $post["autoPartsNameForBd"][0];

                    $product_id = $this->model_catalog_auto_parts->addAutoParts($post, $auto_parts_images);

                    if ($user_id && $user_id != 0) {
                        $this->model_catalog_auto_parts->addChangeProductData("", "", "Добавил запчасть", $product_id, $user_id);
                    }

                    $json['autoPartsCreate'] = (int)$product_id;
                } else {
                    $json['autoPartsCreate'] = $validate;
                }
            } else { // тут если прилетает несколько
                $article_dop = 1;
                $article_dop_2 = 0;
                $auto_parts_list = $post['autoPartsModelBrandsObject'];
                $autoPartsNameForBd = $post['autoPartsNameForBd'];

                $validate = $this->isCheckedModel($post['model']);
                if ($validate == "") {
                    $model = $this->generateAutoPartsModel();
                    $post['model'] = $model;

                    foreach($auto_parts_list as $auto_parts_item){ // добавляем доп. з/ч
                        $post['model'] = "";

                        if($article_dop != 1){
                            $post['model'] = $model . '_' . $article_dop_2;
                        } else {
                            $post['model'] = $model;
                        }

                        $post['autoPartsCategoryId'] = $auto_parts_item;
                        $post['autoPartsNameForBd'] = $autoPartsNameForBd[$article_dop_2];

                        $new_product_id = $this->model_catalog_auto_parts->addAutoParts($post, []);

                        if($user_id && $user_id != 0) {
                            $this->model_catalog_auto_parts->addChangeProductData("", "", "Добавил З/Ч", $new_product_id, $user_id);
                        }
                        $article_dop++;
                        $article_dop_2++;
                    }

                    $json['autoPartsCreate'] = [];
                } else {
                    $json['autoPartsCreate'] = $validate;
                }
            }
        }

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to set images for auto parts by list
     * */
    private function _setAutoPartsImagesFromList($id, $param) {
        $json = [];
        $auto_parts_images = [];

        $date_now = date("d.m.Y");
        $time = strtotime($date_now);

        $this->load->model('catalog/auto_parts');

        if ($param["images"]) {
            foreach (explode(",", $param["images"]) as $image) {
                $auto_parts_images[] = "catalog/d4_img/" . $time . "/" . $image;
            }

            $this->model_catalog_auto_parts->addAutoPartsImagesFromList($id, $auto_parts_images);
        }

        $json['autoPartsImagesFromList'] = $id;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to change status auto parts by ID
     * */
    private function _setAutoPartsStatusChange($id, $param) {
        $json = [];

        $this->load->model('catalog/auto_parts');

        $old_status = (int)$param['status'];
        $new_status = !(int)$param['status'];

        if(isset($param['status'])) {
            $status = !(int)$param['status'];
        } else {
            $status = 1;
        }

        $user_id = (int)$param['user_id'];

        if($user_id && $user_id != 0) {
            $this->model_catalog_auto_parts->addChangeProductData($old_status, $new_status, "Статус", $id, $user_id);
        }

        $product_id = $this->model_catalog_auto_parts->autoPartsStatusChange($id, $status);

        $json['autoPartsStatusChange'] = $product_id;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to change status auto parts by ID
     * */
    private function _setAutoPartsPriceChange($id, $param) {
        $json = [];

        $this->load->model('catalog/auto_parts');

        $user_id = (int)$param['user_id'];

        $old_price = $this->model_catalog_auto_parts->getAutoPartsPrice($id);

        $this->model_catalog_auto_parts->autoPartsPriceChange($id, $param['price']);

        $priceBYN = round($this->currency->convert($param['price'], "USD", 'BYN'), '0');

        $price_change = array(
            'priceUSD' => $param['price'],
            'priceBYN' => $priceBYN
        );

        if($user_id && $user_id != 0) {
            $this->model_catalog_auto_parts->addChangeProductData($old_price, $param['price'], "Цена", $id, $user_id);
        }

        $json['autoPartsPriceChange'] = $price_change;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to set edited auto parts
     * */
    private function _setAutoPartsEdit($id, $post) {
        $json = [];
        $json['autoPartsEdit'] = false;

        if($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load->model('catalog/auto_parts');

            if($post["images"]){
                $date_now = date("d.m.Y");
                $time = strtotime($date_now);

                $auto_parts_images = [];

                foreach (explode(",", $post["images"]) as $image) {
                    $auto_parts_images[] = "catalog/d4_img/" . $time . "/" . $image;
                }
            }

            $this->model_catalog_auto_parts->editAutoParts($id, $post, $auto_parts_images, $post['imagesMain']);

            $json['autoPartsEdit'] = true;
        }

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to get auto parts index
     * */
    private function _getAutoPartsIndex($id){
        $json = [];
        $images = array();
        $additional_fields = [];
        $image = null;
        $i = 1;
        $telephone = "";
        $firstname = "";
        $stock = "";
        $theNote = "";

        $this->load->model('tool/image');
        $this->load->model('catalog/auto_parts');

        $results = $this->model_catalog_auto_parts->getAutoPartsIndex($id);

        $results_additional_fields = $this->model_catalog_auto_parts->getAutoPartsAdditionalFields($id);

        foreach ($results_additional_fields as $field) {
            if($field['attribute_id'] == 13) {
                $telephone = $field['text'];
            }
            if($field['attribute_id'] == 14) {
                $firstname = $field['text'];
            }
            if($field['attribute_id'] == 17) {
                $stock = $field['text'];
            }
            if($field['attribute_id'] == 12) {
                $theNote = $field['text'];
            }
        }

        $auto_parts_model_brand = array(
            'name' => $this->model_catalog_auto_parts->getAutoPartsCategoryName($results['product_id']),
            'code' => $this->model_catalog_auto_parts->getAutoCategoryId($results['product_id'])
        );

        $autoPartsName = $this->model_catalog_auto_parts->getAutoPartsName($results['manufacturer_id']);
        $auto_parts_description = $this->model_catalog_auto_parts->getAutoPartsDescription($results['product_id']);

        $imagesThumb = $this->model_catalog_auto_parts->getProductImages($results['product_id']);

        if($results['image']) {
            foreach ($imagesThumb as $image) {
                $im = explode("/", $image['image']);
                $imagesServer[] = end($im);
                $images[] = $image['image'];
            }
        }

        $qr_param = array(
            'id' => $results['product_id'],
            'model' => $results['model'],
            'jan' => $results['jan'],
            'ean' => $results['ean'],
            'length' => $results['length'],
            'mpn'      => $results['mpn'],
            'isbn'      => $results['isbn'],
            'upc'      => $results['upc'],
            'markaX'     => explode(' > ', $auto_parts_model_brand['name'])[0],
            'modelX'     => explode(' > ', $auto_parts_model_brand['name'])[1],
            'name'     => $autoPartsName['name']

        );

        $qr_code = $this->createAutoPartsQrCode($qr_param);

        $autoPartsIndex = array(
            'product_id' => $results['product_id'],
            'model'      => $results['model'],
            'images'    => $images,
            'mainImage' => $results['image'],
            'imagesServer'  => $imagesServer,
            'telephone'     => $telephone,
            'stock'     => $stock,
            'firstname'     => $firstname,
            'theNote'     => $theNote,
            'autoPartsModelBrand'      => $auto_parts_model_brand,
            'autoPartsName' => $autoPartsName,
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
            'qrCode'        => $qr_code,
            'linkToSite'      => '/index.php?route=product/product&product_id=' . $results['product_id'],
            'status'      => ($results['status'] == 1) ? 'Активно' : 'Неактивно',
            'youtube'      => $results['youtube'],
            'description'      => $auto_parts_description
        );


        $json['autoPartsIndex'] = $autoPartsIndex;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to get auto parts history
     * */
    private function _getAutoPartsHistory($id) {
        $json = [];
        $autoPartsHistory = [];

        $this->load->model('catalog/auto_parts');

        $this->response->setOutput(json_encode($json));

        $history = $this->model_catalog_auto_parts->getAutoParstHistory($id);

        foreach ($history as &$item) {
            if($item["data_change"]) {
                $date2 = new DateTime($item["data_change"]);
                $data_change = $date2->format("d.m.Y H:i:s");
            }

            $autoPartsHistory[] = array(
                'valueName' => $item['value_name'],
                'valueOld' => $item['value_old'],
                'valueNew' => $item['value_new'],
                'firstName' => $item['firstname'],
                'lastName' => $item['lastname'],
                'dataChange' => $data_change,
            );
        }

        $json['autoPartsHistory'] = $autoPartsHistory;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to get types auto parts
     * */
    private function _getTypesOfAutoParts() {
        $json = [];

        $typesOfAutoParts = $this->cache->get('typesOfAutoParts');

        if (!$typesOfAutoParts) {
            $this->load->model('catalog/auto_parts');

            $results = $this->model_catalog_auto_parts->getTypesOfAutoParst();

            foreach ($results as $result) {
                $typesOfAutoParts[] = array(
                    'name' => $result['name'],
                    'code' => $result['manufacturer_id'],
                );
            }

            $this->cache->set('typesOfAutoParts', $typesOfAutoParts);
        }

        $json['typesOfAutoParts'] = $typesOfAutoParts;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to get brand and model car
     * */
    private function _getBrandModelCarAutoParts() {
        $json = [];

        $brandAndModelCar = $this->cache->get('brandAndModelCar');

        if (!$brandAndModelCar) {
            $this->load->model('catalog/auto_parts');

            $this->response->setOutput(json_encode($json));

            $results_brand = $this->model_catalog_auto_parts->getBrandAndModelCarAutoParst();

            foreach ($results_brand as $result_brand) {
                $results_model = $this->model_catalog_auto_parts->getBrandAndModelCarAutoParst($result_brand['category_id']);

                $brandAndModelCar[] = array(
                    'name' => $result_brand['name'],
                    'code' => $result_brand['category_id']
                );

                foreach ($results_model as $result_model) {
                    $brandAndModelCar[] = array(
                        'name' => $result_brand['name'] . ' > ' . $result_model['name'],
                        'code' => $result_model['category_id']
                    );
                }
            }

            $this->cache->set('brandAndModelCar', $brandAndModelCar);
        }

        $json['brandAndModelCar'] = $brandAndModelCar;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to create QR code for auto parts
     * */
    private function createAutoPartsQrCode($qr) {
        require_once '/home/dby/sites/d4.by/gd/phpqrcode/qrlib.php';
        QRcode::png('https://d4.by/gd/?product_id='.$qr['product_id'], $_SERVER["DOCUMENT_ROOT"].'/gd/qr/'.$qr['model'].'_tmp.png', 'Q', 6, 1);

        $im = imagecreatefrompng($_SERVER["DOCUMENT_ROOT"].'/gd/qr/'.$qr['model'].'_tmp.png');
        $width = imagesx($im);
        $height = imagesy($im);

        $rgba_oux = explode(',', '255,255,255');

        $bg_color = imageColorAllocate($im, (int)$rgba_oux[0], (int)$rgba_oux[1], (int)$rgba_oux[2]);
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $color = imagecolorat($im, $x, $y);
                if ($color == 0) {
                    imageSetPixel($im, $x, $y, $bg_color);
                }
            }
        }

        $dst = imagecreatetruecolor($width, $height);
        imagecopy($dst, $im, 0, 0, 0, 0, $width, $height);
        imagedestroy($im);

        $logo = imagecreatefrompng($_SERVER["DOCUMENT_ROOT"].'/gd/logo.png');
        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);

        $new_width = $width / 3;
        $new_height = $logo_height / ($logo_width / $new_width);

        $x = ceil(($width - $new_width) / 2);
        $y = ceil(($height - $new_height) / 2);

        imagecopyresampled($dst, $logo, $x, $y, 0, 0, $new_width, $new_height, $logo_width, $logo_height);
        imagepng($dst,$_SERVER["DOCUMENT_ROOT"].'/gd/qr/' . $qr['model'] . '_main.png',3);

        unlink($_SERVER["DOCUMENT_ROOT"].'/gd/qr/' . $qr['model'] . '_tmp.png');

        $img_sm_qr1 = '<img src="https://d4.by/gd/qr/' . $qr['model'] . '_main.png" style="width:110px;">';

        $qr_title = "<div>" . $qr['markaX'] . " " . $qr['modelX'] . ", " . $qr['length'] . "г. " . $qr['ean'] . "</div><div>" . $qr['jan'] . " " .$qr['isbn'] . " " . $qr['mpn'] . " " . $qr['upc'] . "</div><div>" . $qr['name'] . "</div><div>" . '<span style="font-size:17px;">' . $qr['model'] . '</span></div>';

        $qr_code = '<div style="display:flex;align-items:center;width:275px;border:1px solid #000;"><div>'.$img_sm_qr1.'</div><div style="text-align:center;font-size:12px;padding-left:10px;margin:0 auto;font-weight:bold;line-height:18px;">'.$qr_title.'</div></div>';

        $qr_code_result = '<html><head><style>@print{@page :footer {color: #fff }@page :header {color: #fff}}</style></head><body style="font-family: Open Sans, sans-serif;" onload="window.print()"><div style="margin:0 auto;color:#000;display:flex;align-items:center;width:275px;"><div style="text-align:center;font-size:12px;margin:0 auto;padding-left:10px;font-weight:bold;line-height:18px;">' . $qr_code . '</div></div></body></html>';

        return $qr_code_result;
    }

    /*
     * @route: api/auto_parts/auto
     * Url settings for get all auto parts
     * */
    private function isAutoParts($path) {
        return !isset($path[3]) && $path[2] == 'auto';
    }

    /*
     * @route: api/auto_parts/auto/totals
     * Url settings for get auto parts totals
     * */
    private function isAutoPartsTotals($path){
        return !isset($path[4]) && $path[3] == 'totals';
    }

    /*
     * @route: api/auto_parts/auto/index/:product_id
     * Url settings for get auto part index
     * */
    private function isAutoPartsIndex($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'index';
    }

    /*
     * @route: api/auto_parts/auto/history/:product_id
     * Url settings for get auto part history
     * */
    private function isAutoPartsHistory($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'history';
    }

    /*
     * @route: api/auto_parts/auto/delete/:product_id
     * Url settings delete product
     * */
    private function isAutoPartsDelete($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'delete';
    }

    /*
     * @route: api/auto_parts/auto/types
     * Url settings get types auto parts
     * */
    private function isTypesOfAutoParts($path) {
        return !isset($path[4]) && $path[3] == 'types';
    }

    /*
     * @route: api/auto_parts/auto/category
     * Url settings get brand and model car
     * */
    private function isBrandModelCarAutoParts($path) {
        return !isset($path[4]) && $path[3] == 'category';
    }

    /*
     * @route: api/auto_parts/auto/:id/edit
     * Url settings get edit auto parts
     * */
    private function isAutoPartsEdit($path) {
        return !isset($path[5]) && is_numeric(trim($path[3])) && $path[4] == 'edit';
    }

    /*
     * @route: api/auto_parts/auto/change_status/:id
     * Url settings change status by auto parts ID
     * */
    private function isAutoPartsStatusChange($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'change_status';
    }

    /*
     * @route: api/auto_parts/auto/change_price/:id
     * Url settings change price by auto parts ID
     * */
    private function isAutoPartsPriceChange($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'change_price';
    }

    /*
     * @route: api/auto_parts/auto/create
     * Url settings set auto parts new
     * */
    private function isAutoPartsCreate($path) {
        return !isset($path[4]) && $path[3] == 'create';
    }

    /*
     * @route: api/auto_parts/auto/add_images/:id
     * Url auto parts set images from list
     * */
    private function isAutoPartsImagesFromList($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'add_images';
    }
}
?>