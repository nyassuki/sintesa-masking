<?php

namespace App\Controllers\Admin;

/**
 * Description of contact_display
 *
 * @author yassuki
 */
use App\Models\RolesPermissionsModel;
use App\Models\ClientModel;
use App\Models\UserModel;

class contact_display extends AdminController {

    function __construct() {
        $this->ClientModel = new ClientModel();
        $this->UserModel = new UserModel();
    }

    function index() {
        $this->RolesPermissionsModel = new RolesPermissionsModel();
        $logged_user = (Array) $this->UserModel->get_logged_user();
        $client_code = $logged_user['client_id'];
        $data = [
            'title' => "Contact display",
            'subsegment' => "List",
            'user' => "yassuki",
            'segment' => "List",
            'client_code' => $client_code,
            'MenuCategory' => $this->RolesPermissionsModel->getAccessMenuCategory(user()->role),
            'client' => $this->ClientModel->list($client_code)
        ];
        return view("admin/address-book/contact_display", $data);
    }

    function UpdateClient() {
        $logged_user = (Array) $this->UserModel->get_logged_user();
        $client_code = $logged_user['client_id'];
        
        $contact_display_name = strtolower($this->request->getVar('contact_display_name'));
        $client_id = strtolower($this->request->getVar('client_id'));

        $pusher_app_id = strtolower($this->request->getVar('pusher_app_id'));
        $pusher_key = strtolower($this->request->getVar('pusher_key'));
        $pusher_secret = strtolower($this->request->getVar('pusher_secret'));
        $pusher_cluster = strtolower($this->request->getVar('pusher_cluster'));
        $this->ClientModel->UpdateClient($client_id, $contact_display_name, $pusher_app_id, $pusher_key, $pusher_secret, $pusher_cluster);
        $data = [
            'title' => "Contact display",
            'subsegment' => "List",
            'user' => "yassuki",
            'segment' => "List",
            'client_code' => $client_code,
            'MenuCategory' => $this->RolesPermissionsModel->getAccessMenuCategory(user()->role),
            'client' => $this->ClientModel->list($client_code)
        ];
        return view("admin/address-book/contact_display", $data);
    }

    function UpdateClientImage() {
        $contact_logo = strtolower($this->request->getVar('contact_logo'));
        
        $logged_user = (Array) $this->UserModel->get_logged_user();
        $client_code = $logged_user['client_id'];
        
        
        $this->ClientModel->UpdateClientImage($client_code, $contact_logo);
    }

}
