<?php

namespace App\Models;

/**
 * Description of AddressBookModel
 *
 * @author yassuki
 */
use CodeIgniter\Model;

class AddressBookModel extends Model {

    function Add($client_code, $phone_number, $contact_name,$reseller_code) {
        $datax = $this->db->table("contact")->where(["phone_number" => $phone_number])->select("*")->get()->getResultArray();
        $data = array(
            "client_code" => $client_code,
            "reseller_code" => $reseller_code,
            "phone_number" => $phone_number,
            "contact_name" => $contact_name
        );
        if ($datax) {
            return $this->db->table("contact")->where(["phone_number" => $phone_number])->update($data);
        } else {

            return $this->db->table("contact")->insert($data);
        }
    }

    function list($client_code) {
        return $this->db->table("contact")->where(["client_code" => $client_code])->select("*")->get()->getResultArray();
    }
      function listByReseller($reseller_code) {
        return $this->db->table("contact")->where(["reseller_code" => $reseller_code])->select("*")->get()->getResultArray();
    }

    function PhoneDelete($phone_number) {
        return $this->db->table("contact")->where(["phone_number" => $phone_number])->delete();
    }

    function getContactByid($id) {
        return $this->db->table("contact")->where(["id" => $id])->select("*")->get()->getResultArray();
    }

    function AddCustomer() {
        
    }

}
