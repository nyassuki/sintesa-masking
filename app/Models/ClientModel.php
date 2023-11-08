<?php

namespace App\Models;

/**
 * Description of ClientModel
 *
 * @author yassuki
 */
use CodeIgniter\Model;

class ClientModel extends Model {

    function list($client_id) {
        return $this->db->table("client")->select("*")->where(["client_id" => $client_id])->get()->getResultArray();
    }

    function list_by_reseller($reseller_code) {
        return $this->db->table("client")->select("*")->where(["reseller_code" => $reseller_code])->get()->getResultArray();
    }

    function NewClient($client_id, $client_name, $reseller_code, $contact_display_name) {
        $data = array(
            "client_id" => $client_id,
            "client_name" => $client_name,
            "reseller_code" => $reseller_code,
            "client_name" => $client_name,
            "contact_display_name" => $contact_display_name,
            "pusher_app_id" => "1629807",
            "pusher_key" => "75f52badaf3ca79b84f4",
            "pusher_secret" => "10db69acd61370289a01",
            "pusher_cluster" => "eu"
        );
        return $this->db->table("client")->insert($data);
    }

    function UpdateClient($client_id, $contact_display_name, $pusher_app_id, $pusher_key, $pusher_secret, $pusher_cluster) {
        $data = array(
            "client_id" => $client_id,
            "contact_display_name" => $contact_display_name,
            "pusher_app_id" => "1629807",
            "pusher_key" => "75f52badaf3ca79b84f4",
            "pusher_secret" => "10db69acd61370289a01",
            "pusher_cluster" => "eu",
        );
        return $this->db->table("client")->where(["client_id" => $client_id])->update($data);
    }

    function UpdateClientImage($client_id, $contact_logo) {
        $data = array(
            "contact_logo" => $contact_logo
        );
        return $this->db->table("client")->where(["client_id" => $client_id])->update($data);
    }

    function getClient($client_id) {
        $data = $this->db->table("client")->where(["client_id" => $client_id])->select("*")->get()->getResultArray();
        if (count($data) > 0) {
            return $data;
        } else {
            return array();
        }
    }

    function ClientDelete($client_id) {
        return $this->db->table("client")->where(["client_id" => $client_id])->delete();
    }

}
