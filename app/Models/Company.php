<?php

namespace App\Models;

/**
 * Description of Company
 *
 * @author yassuki
 */
use CodeIgniter\Model;

class Company extends Model {

    //put your code here

    function list() {
        return $this->db->table("client")->select("*")->where(["active" => 1])->get()->getResult();
    }

    function ArrayList() {
        return $this->db->table("client")->select("*")->where(["active" => 1])->get()->getResultArray();
    }

    function ArrayListByID($company_code) {
        return $this->db->table("client")->select("*")->where(["active" => 1, "client_id" => $company_code])->get()->getResultArray();
    }

}
