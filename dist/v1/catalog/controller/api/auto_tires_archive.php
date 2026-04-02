<?php
class ControllerApiAutoTiresArchive extends Controller
{
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
    private function findRenderComponent($path, $postRead) {
        if($this->isAutoTiresArchive($path)) {
            $this->_getAutoTiresArchive($postRead);
        } elseif($this->isAutoTiresArchiveTotals($path)) {
            $this->_getAutoTiresArchiveTotals();
        } elseif($this->isAutoTiresArchiveRestore($path)) {
            $this->_setAutoTiresArchiveRestore($path[4], $postRead);
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
    private function _getAutoTiresArchive($param){
        $json = [];

        if(isset($param['page'])) {
            $page = (int)$param['page'];
        } else {
            $page = 1;
        }

        $filter_data = array(
            'sort'        => 'p.date_delete',
            'order'       => 'DESC',
            'start'       => ($page - 1) * 20,
            'limit'       => 20
        );

        $this->load->model('tool/image');
        $this->load->model('catalog/auto_tires_archive');

        $results = $this->model_catalog_auto_tires_archive->getProducts($filter_data);

        foreach ($results as $result) {
            $images = array();
            $i = 1;

            $imagesThumb = $this->model_catalog_auto_tires_archive->getProductImages($result['product_id']);

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
            
            $auto_tires_description = $this->model_catalog_auto_tires_archive->getAutoTiresArchiveDescription($result['product_id']);

            $date_available = new DateTime($result['date_available']);
            $date_available = $date_available->format("d.m.Y");

            $date_deleted = new DateTime($result['date_delete']);
            $date_deleted = $date_deleted->format("d.m.Y");

            $autoTiresArchive[] = array(
                'product_id' => $result['product_id'],
                'model'      => $result['model'],
                'images'    => $images,
                'name'      => $result['ean'] . ' ' . $result['upc'] . ' ' . $result['jan'] . '/' . $result['isbn'] . ' ' . $result['mpn'] . ', ' . $result['quantity'] . ' шт., ' . $result['sku'] . ' ' . $result['location'],
                'imagesShowAllImage' => (count($images) > 6) ? false : true,
                'year'      => ($result['length'] != 0) ? $result['length'] : '',
                'priceUSD'      => $result['price'],
                'dateAvailable'      => $date_available,
                'dateDeleted'      => $date_deleted,
                'linkToSite'      => '/index.php?route=product/shiny_form&product_id=' . $result['product_id'],
                'status'      => $result['status'],
                'description'      => $auto_tires_description

            );
        }

        $json['autoTiresArchive'] = $autoTiresArchive;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Functuin to restore deleted auto tires
     * */
    private function _setAutoTiresArchiveRestore($id){
        $json = [];

        $this->load->model('catalog/auto_tires_archive');

        $restore_product_id = $this->model_catalog_auto_tires_archive->restoreProduct((int)$id);


        $json['autoTiresArchiveRestore'] = $restore_product_id;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * Function to get auto parts totals
     * */
    private function _getAutoTiresArchiveTotals(){
        $json = [];

        $this->load->model('catalog/auto_tires_archive');

        $autoTiresArchiveTotals = $this->model_catalog_auto_tires_archive->getTotalsAutoTires();

        $json['autoTiresArchiveTotals'] = (int)$autoTiresArchiveTotals;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * @route: api/auto_tires_archive/tires
     * Url settings for get all auto tires
     * */
    private function isAutoTiresArchive($path) {
        return !isset($path[3]) && $path[2] == 'tires';
    }

    /*
     * @route: api/auto_tires_archive/tires/totals
     * Url settings for get auto tires totals
     * */
    private function isAutoTiresArchiveTotals($path){
        return !isset($path[4]) && $path[3] == 'totals';
    }

    /*
     * @route: api/auto_tires_archive/tires/restore/:product_id
     * Url settings restore product by id
     * */
    private function isAutoTiresArchiveRestore($path) {
        return !isset($path[5]) && is_numeric(trim($path[4])) && $path[3] == 'restore';
    }
}