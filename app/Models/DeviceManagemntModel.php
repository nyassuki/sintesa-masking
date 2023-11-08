<?php

namespace App\Models;

/**
 * Description of DeviceManagemntModel
 *
 * @author yassuki
 */
use CodeIgniter\Model;

class DeviceManagemntModel extends Model {

    function deviceList($client_code) {
        return $this->db->table("device_management")
                        ->where(["client_code" => $client_code])->get()->getResultArray();
    }

}
