<?php

namespace App\Controllers\Admin;

/**
 * Description of PushNumber
 *
 * @author yassuki
 */
use App\Models\UserModel;
use App\Models\AddressBookModel;
use App\Models\ClientModel;

class PushNumber extends AdminController {

    function __construct() {
        $this->UserModel = new UserModel();
        $this->ClientModel = new ClientModel();

        $this->AddressBookModel = new AddressBookModel();
    }

    function push() {
        $logged_user = (Array) $this->UserModel->get_logged_user();
        $client_code = $logged_user['client_id'];
        $client = $this->ClientModel->list($client_code)[0];

        $cluster = $client['pusher_cluster'];
        $key = $client['pusher_key'];
        $secret = $client['pusher_secret'];
        $appid = $client['pusher_app_id'];
        $contact_id = strtolower($this->request->getVar('contact_id'));
        $options = array(
            'cluster' => $cluster,
            'useTLS' => true
        );

        $pusher = new \Pusher\Pusher($key, $secret, $appid, $options);
        $addr = $this->AddressBookModel->getContactByid($contact_id);
        $contact_display = $client['contact_logo'];

        $phone_number = $addr[0]["phone_number"];
        $contact_name = $addr[0]["contact_name"];
        $event_data = json_encode(array("Phonenumber" => $phone_number, "Contact_name" => $contact_name, "Contact_display" => $contact_display));

        $data["Phonenumber"] = $phone_number;
        $data["Contact_name"] = $contact_name;
        $data["Contact_display"] = $contact_display;
        $pusher->trigger($client_code, "push-contact", $data);
    }

}
