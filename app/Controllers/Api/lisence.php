<?php

namespace App\Controllers\Api;

/**
 * Description of lisence
 *
 * @author yassuki
 */
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ClientModel;

class lisence extends ResourceController {

    use ResponseTrait;

    function __construct() {
        $this->ClientModel = new ClientModel();
    }

    function index() {
        $requestBody = json_decode($this->request->getBody());
        $client_code = $requestBody->server_name;
        $response = $this->ClientModel->getClient($client_code)[0];
        return $this->respond($response);
    }

}
