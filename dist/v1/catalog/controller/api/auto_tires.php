<?php
class ControllerApiAutoTires extends Controller {
    /*
     * Main function to handle HTTP request
     * */
    public function tires() {
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
        if($this->isAutoTires($path)) {
            $this->_getAutoTires($postRead);
        } elseif($this->isAutoTiresTotals($path)) {
            $this->_getAutoTiresTotals();
        } elseif($this->isAutoTiresIndex($path)) {
            $this->_getAutoTiresIndex($path[4]);
        } elseif($this->isAutoTiresHistory($path)) {
            $this->_getAutoTiresHistory($path[4]);
        } elseif($this->isAutoTiresDelete($path)) {
            $this->_removeAutoTires($path[4]);
        } elseif($this->isAutoTiresStatusChange($path)) {
            $this->_setAutoTiresStatusChange($path[4], $postRead);
        } elseif($this->isAutoTiresImagesFromList($path)) {
            $this->_setAutoTiresImagesFromList($path[4], $postRead);
        } elseif($this->isAutoTiresPriceChange($path)) {
            $this->_setAutoTiresPriceChange($path[4], $postRead);
        } elseif($this->isAutoTiresEdit($path)) {
            $this->_setAutoTiresEdit($path[3], $postWrite);
        } elseif($this->isAutoTiresCreate($path)) {
            $this->_setAutoTiresCreate($postWrite, $postRead);
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
     * Function to create new auto tires
     * */
    private function _setAutoTiresCreate($post, $data){
        $json = [];
        $this->load->model('catalog/auto_tires');

        if($this->request->server['REQUEST_METHOD'] == 'POST') {
            $validate = $this->isCheckedModel($post['model']);

            if ($validate == "") {
                $date_now = date("d.m.Y");
                $time = strtotime($date_now);
                $auto_tires_images = [];

                $post['model'] = $this->generateAutoTiresModel();

                if ($post["images"]) {
                    foreach (explode(",", $post["images"]) as $image) {
                        $auto_tires_images[] = "catalog/d4_img/" . $time . "/" . $image;
                    }
                }

                if ($post["imagesMain"]) {
                    $post["imagesMain"] = "catalog/d4_img/" . $time . "/" . $post["imagesMain"];
                }

                $product_id = $this->model_catalog_auto_tires->addAutoTires($post, $auto_tires_images);

                $json['autoTiresCreate'] = (int)$product_id;
            } else {
                $json['autoTiresCreate'] = $validate;
            }
        }

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to generate model for auto tire
     * */
    private function generateAutoTiresModel() {
        $this->load->model('catalog/auto_tires');

        $chekMaxModel = $this->model_catalog_auto_tires->chekMaxModel();
        $chekMaxModel['MAX(product_id)'] = $chekMaxModel['MAX(product_id)'] + 2;
        $model = $chekMaxModel['MAX(product_id)'];

        return $model;
    }


    /*
     * Function to checked model for auto tires
     * */
    private function isCheckedModel($model) {
        $error = '';
        $this->load->model('catalog/auto_tires');

        if ($model != "") {
            $model_product_info = $this->model_catalog_auto_tires->getModelProduct($model);
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
     * Function to set edited auto tires
     * */
    private function _setAutoTiresEdit($id, $post) {
        $json = [];
        $json['autoTiresEdit'] = false;

        if($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load->model('catalog/auto_tires');

            if($post["images"]){
                $date_now = date("d.m.Y");
                $time = strtotime($date_now);

                $auto_tires_images = [];

                foreach (explode(",", $post["images"]) as $image) {
                    $auto_tires_images[] = "catalog/d4_img/" . $time . "/" . $image;
                }
            }

            $this->model_catalog_auto_tires->editAutoTires($id, $post, $auto_tires_images, $post['imagesMain']);

            $json['autoTiresEdit'] = true;
        }

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to set images for auto tires by list
     * */
    private function _setAutoTiresImagesFromList($id, $param) {
        $json = [];
        $auto_tires_images = [];

        $date_now = date("d.m.Y");
        $time = strtotime($date_now);

        $this->load->model('catalog/auto_tires');

        if ($param["images"]) {
            foreach (explode(",", $param["images"]) as $image) {
                $auto_tires_images[] = "catalog/d4_img/" . $time . "/" . $image;
            }

            $this->model_catalog_auto_tires->addAutoTiresImagesFromList($id, $auto_tires_images);
        }

        $json['autoTiresImagesFromList'] = $id;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to change status auto parts by ID
     * */
    private function _setAutoTiresPriceChange($id, $param) {
        $json = [];

        $this->load->model('catalog/auto_tires');

        $this->model_catalog_auto_tires->autoTiresPriceChange($id, $param['price']);

        $priceBYN = round($this->currency->convert($param['price'], "USD", 'BYN'), '0');

        $price_change = array(
            'priceUSD' => $param['price'],
            'priceBYN' => $priceBYN
        );

        $json['autoTiresPriceChange'] = $price_change;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to get all auto tires
     * */
    private function _getAutoTires($param){
        $json = [];

        if(isset($param['page'])) {
            $page = (int)$param['page'];
        } else {
            $page = 1;
        }

        $filter_data = array(
            'sort'        => 'p.date_added',
            'order'       => 'DESC',
            'start'       => ($page - 1) * 20,
            'limit'       => 20
        );

        $this->load->model('tool/image');
        $this->load->model('catalog/auto_tires');

        $results = $this->model_catalog_auto_tires->getProducts($filter_data);

        foreach ($results as $result) {
            $images = array();
            $i = 1;

            $name =  $this->model_catalog_auto_tires->getAutoName($result['product_id']);

            $imagesThumb = $this->model_catalog_auto_tires->getProductImages($result['product_id']);

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

            $auto_tires_description = $this->model_catalog_auto_tires->getAutoTiresDescription($result['product_id']);

            $date_added = new DateTime($result['date_added']);
            $date_added = $date_added->format("d.m.Y H:i:s");

            $qr_param = array(
                'product_id' => $result['product_id'],
                'ean' => $result['ean'],
                'upc' => $result['upc'],
                'jan' => $result['jan'],
                'isbn' => $result['isbn'],
                'mpn'      => $result['mpn'],
                'quantity'      => $result['quantity'],
                'sku'      => $result['sku'],
                'model'      => $result['model'],
                'location'     => $name['location']

            );

            $qr_code = $this->createAutoPartsQrCode($qr_param);

            $priceBYN = round($this->currency->convert($result['price'], "USD", 'BYN'), '0');

            $autoTires[] = array(
                'product_id' => $result['product_id'],
                'model'      => $result['model'],
                'images'    => $images,
                'name'      => $result['ean'] . ' ' . $result['upc'] . $result['jan'] . '/' . $result['isbn'] . ' ' . $result['mpn'] . ', ' . $result['quantity'] . ' шт., ' . $result['sku'] . ' ' . $result['location'],
                'imagesShowAllImage' => (count($images) > 6) ? false : true,
                'year'      => ($result['length'] != 0) ? $result['length'] : '',
                'priceUSD'      => $result['price'],
                'priceBYN'      => $priceBYN,
                'dateAdded'      => $date_added,
                'linkToSite'      => '/index.php?route=product/shiny_form&product_id=' . $result['product_id'],
                'status'      => $result['status'],
                'qrCode' => $qr_code,
                'description'      => $auto_tires_description

            );
        }

        $json['autoTires'] = $autoTires;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to create QR code for auto tires
     * */
    private function createAutoPartsQrCode($qr) {
        require_once '/home/dby/sites/d4.by/gd/phpqrcode/qrlib.php';
        QRcode::png('https://d4.by/gd/?product_id='.$qr['product_id'], $_SERVER["DOCUMENT_ROOT"].'/gd/qr_shiny/'.$qr['model'].'_tmp.png', 'Q', 6, 1);

        $im = imagecreatefrompng($_SERVER["DOCUMENT_ROOT"].'/gd/qr_shiny/'.$qr['model'].'_tmp.png');
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
        imagepng($dst,$_SERVER["DOCUMENT_ROOT"].'/gd/qr_shiny/' . $qr['model'] . '_main.png',3);

        unlink($_SERVER["DOCUMENT_ROOT"].'/gd/qr_shiny/' . $qr['model'] . '_tmp.png');

        $img_sm_qr1 = '<img src="https://d4.by/gd/qr_shiny/' . $qr['model'] . '_main.png" style="width:110px;">';
        $qr_title = "<div>" . $qr['ean'] . " " . $qr['upc'] .", " . $qr['jan'] . "/" . $qr['isbn']  . "</div><div>" .$qr['mpn'] . " " . $qr['quantity'] . " шт., " . $qr['sku'] . " " . $qr['location'] . "</div><div>" . $qr['name'] . "</div><div>" . '<span style="font-size:17px;">' . $qr['model'] . '</span></div>';

        $qr_code = '<div style="display:flex;align-items:center;width:275px;border:1px solid #000;"><div>'.$img_sm_qr1.'</div><div style="text-align:center;font-size:12px;padding-left:10px;margin:0 auto;font-weight:bold;line-height:18px;">'.$qr_title.'</div></div>';

        $qr_code_result = '<html><head><style>@print{@page :footer {color: #fff }@page :header {color: #fff}}</style></head><body style="font-family: Open Sans, sans-serif;" onload="window.print()"><div style="margin:0 auto;color:#000;display:flex;align-items:center;width:275px;"><div style="text-align:center;font-size:12px;margin:0 auto;padding-left:10px;font-weight:bold;line-height:18px;">' . $qr_code . '</div></div></body></html>';

        return $qr_code_result;
    }

    /*
     * Function to get auto tires totals
     * */
    private function _getAutoTiresTotals(){
        $json = [];

        $this->load->model('catalog/auto_tires');

        $autoTiresTotals = $this->model_catalog_auto_tires->getTotalsAutoTires();

        $json['autoTiresTotals'] = (int)$autoTiresTotals;

        $this->response->setOutput(json_encode($json));
    }



    /*
     * Function to change status auto tires by ID
     * */
    private function _setAutoTiresStatusChange($id, $param) {
        $json = [];

        $this->load->model('catalog/auto_tires');

        if(isset($param['status'])) {
            $status = !(int)$param['status'];
        } else {
            $status = 1;
        }

        $product_id = $this->model_catalog_auto_tires->autoTiresStatusChange($id, $status);

        $json['autoTiresStatusChange'] = $product_id;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to delete auto tires by ID
     * */
    private function _removeAutoTires($id) {
        $json = [];

        $this->load->model('catalog/auto_tires');

        $old_product_id = $this->model_catalog_auto_tires->deleteProduct($id);

        $json['autoTiresDelete'] = $old_product_id;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to get auto tires index
     * */
    private function _getAutoTiresIndex($id){
        $json = [];
        $images = array();
        $additional_fields = [];
        $image = null;
        $i = 1;
        $telephone = "";
        $firstname = "";
        $stock = "";

        $this->load->model('tool/image');
        $this->load->model('catalog/auto_tires');

        $results = $this->model_catalog_auto_tires->getAutoTiresIndex($id);

        $results_additional_fields = $this->model_catalog_auto_tires->getAutoTiresAdditionalFields($id);
        $auto_tires_description = $this->model_catalog_auto_tires->getAutoTiresDescription($results['product_id']);

        foreach ($results_additional_fields as $field) {
            if($field['attribute_id'] == 13) {
                $telephone = $field['text'];
            }
            if($field['attribute_id'] == 12) {
                $firstname = $field['text'];
            }
            if($field['attribute_id'] == 17) {
                $stock = $field['text'];
            }
        }

        $imagesThumb = $this->model_catalog_auto_tires->getProductImages($results['product_id']);

        if($results['image']) {
            foreach ($imagesThumb as $image) {
                $im = explode("/", $image['image']);
                $imagesServer[] = end($im);
                $images[] = $image['image'];
            }
        }

        $name =  $this->model_catalog_auto_tires->getAutoName($results['product_id']);

        $qr_param = array(
            'product_id' => $results['product_id'],
            'ean' => $results['ean'],
            'upc' => $results['upc'],
            'jan' => $results['jan'],
            'isbn' => $results['isbn'],
            'mpn'      => $results['mpn'],
            'quantity'      => $results['quantity'],
            'sku'      => $results['sku'],
            'model'      => $results['model'],
            'location'     => $name['location']

        );

        $qr_code = $this->createAutoPartsQrCode($qr_param);

        $autoTiresIndex = array(
            'length'     => $results['length'],
            'images'    => $images,
            'mainImage' => $results['image'],
            'imagesServer'  => $imagesServer,
            'name'       => $name['location'],
            'model'      => $results['model'],
            'priceUSD'      => $results['price'],
            'width'	 => $results['jan'],
            'height'	 => $results['isbn'],
            'rSize'	 => $results['mpn'],
            'marka'	     => $results['ean'],
            'modelS'	 => $results['upc'],
            'condition'	 => $results['location'],
            'season'	 => $results['sku'],
            'type'	 => $results['version'],
            'year'	 => $results['length'],
            'telephone'     => $telephone,
            'stock'     => $stock,
            'firstname'     => $firstname,
            'description'      => $auto_tires_description,
            'qrCode'        => $qr_code,
            'quantity'   => $results['quantity'],
            'status'      => ($results['status'] == 1) ? 'Активно' : 'Неактивно'
        );


        $json['autoTiresIndex'] = $autoTiresIndex;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to get auto tires history
     * */
    private function _getAutoTiresHistory($id) {
        $json = [];
        $autoTiresHistory = [];

        $this->load->model('catalog/auto_tires');

        $this->response->setOutput(json_encode($json));

        $history = $this->model_catalog_auto_tires->getAutoParstHistory($id);

        foreach ($history as &$item) {
            if($item["data_change"]) {
                $date2 = new DateTime($item["data_change"]);
                $data_change = $date2->format("d.m.Y H:i:s");
            }

            $autoTiresHistory[] = array(
                'valueName' => $item['value_name'],
                'valueOld' => $item['value_old'],
                'valueNew' => $item['value_new'],
                'firstName' => $item['firstname'],
                'lastName' => $item['lastname'],
                'dataChange' => $data_change,
            );
        }

        $json['autoTiresHistory'] = $autoTiresHistory;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * @route: api/auto_tires/tires
     * Url settings for get all auto tires
     * */
    private function isAutoTires($path) {
        return !isset($path[3]) && $path[2] == 'tires';
    }

    /*
     * @route: api/auto_tires/tires/totals
     * Url settings for get auto tires totals
     * */
    private function isAutoTiresTotals($path){
        return !isset($path[4]) && $path[3] == 'totals';
    }

    /*
     * @route: api/auto_tires/tires/index/:product_id
     * Url settings for get auto tires index
     * */
    private function isAutoTiresIndex($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'index';
    }

    /*
     * @route: api/auto_tires/tires/history/:product_id
     * Url settings for get auto tires history
     * */
    private function isAutoTiresHistory($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'history';
    }

    /*
     * @route: api/auto_tires/tires/delete/:product_id
     * Url settings delete product
     * */
    private function isAutoTiresDelete($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'delete';
    }

    /*
     * @route: api/auto_tires/tires/change_status/:id
     * Url settings change status by auto parts ID
     * */
    private function isAutoTiresStatusChange($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'change_status';
    }

    /*
     * @route: api/auto_tires/tires/add_images/:id
     * Url auto parts set images from list
     * */
    private function isAutoTiresImagesFromList($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'add_images';
    }

    /*
     * @route: api/auto_tires/tires/change_price/:id
     * Url settings change price by auto tires ID
     * */
    private function isAutoTiresPriceChange($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'change_price';
    }

    /*
     * @route: api/auto_tires/tires/create
     * Url settings set auto tires new
     * */
    private function isAutoTiresCreate($path) {
        return !isset($path[4]) && $path[3] == 'create';
    }

    /*
     * @route: api/auto_tires/tires/:id/edit
     * Url settings get edit auto tires
     * */
    private function isAutoTiresEdit($path) {
        return !isset($path[5]) && is_numeric(trim($path[3])) && $path[4] == 'edit';
    }

}
?>