<?php
class ControllerApiGeneral extends Controller
{
    /*
     * Main function to handle HTTP request
     * */
    public function information()
    {
        $postRead = json_decode(file_get_contents('php://input'), true);
        $postWrite = $this->request->post;

        $route = $this->request->get['route'];
        $path = explode('/', $route);
        $login = $this->_getAuth($postRead, $this->request->server);

        $login = true; // NO AUTH

        try {
            if ($login) {
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
    private function findRenderComponent($path, $postRead, $postWrite)
    {

        if ($this->isGetNotification($path)) {
            $this->_getNotification();
        }
    }

    /*
     * Function to Auth
     * Add token and session['api_id']
     * */
    private function _getAuth($post, $serve)
    {
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
     * Function to get notification cart
     * */
    private function _getNotification() {
        $json = [];

        $this->load->model('catalog/general');

        $notification = $this->model_catalog_general->getNotification(array('filter_order_status' => implode(',', $this->config->get('config_processing_status'))));

        $json['notification'] = $notification;

        $this->response->setOutput(json_encode($json));
    }

    /*
     * @route: api/general/information/notifacation
     * Url settings get notification cart
     * */
    private function isGetNotification($path) {
        return !isset($path[4]) && $path[2] == 'information' && $path[3] == 'notifacation';
    }
}
