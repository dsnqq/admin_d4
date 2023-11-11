<?php
class ControllerApiUser extends Controller
{
    /*
     * Main function to handle HTTP request
     * */
    public function login()
    {
        $postRead = json_decode(file_get_contents('php://input'), true);
        $postWrite = $this->request->post;

        $route = $this->request->get['route'];
        $path = explode('/', $route);
        $login = $this->_getAuth($postRead, $this->request->server);

        $login = true; // NO AUTH

        try {
            if ($login) {
                //@ api/user/login
                if(!isset($path[3]) && $path[2] == 'login' && $path[1] == 'user') {
                    $this->getLogin($postRead);
                } else {
                    return false;
                }

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
     * Function login start admin
     * */
    private function getLogin($param) {
        $json = [];

        $this->load->model('catalog/user');

        $user = $this->model_catalog_user->checkUserInBD($param);

        $user_data = array(
            'user_id' => $user['user_id'],
            'lastname' => $user['lastname'],
            'firstname' => $user['firstname'],
            'username' => $user['username'],
        );

        $json['user'] = $user_data;

        $this->response->setOutput(json_encode($json));
    }
}