<?php

namespace App\Controllers\Admin;

/**
 * Description of Customer
 *
 * @author yassuki
 */
use App\Models\RolesPermissionsModel;
use App\Models\AddressBookModel;
use App\Models\UserModel;
use App\Models\ClientModel;

class Customer extends AdminController {

    private $AddressBookModel;
    private $ClientModel;

    function __construct() {
        $this->AddressBookModel = new AddressBookModel();
        $this->UserModel = new UserModel();
        $this->ClientModel = new ClientModel();
    }

    function index() {

        $this->RolesPermissionsModel = new RolesPermissionsModel();

        $logged_user = (Array) $this->UserModel->get_logged_user();
        $client_code = $logged_user['client_id'];
        $reseller_code = $logged_user['reseller_code'];
        $data = [
            'title' => "Customers",
            'subsegment' => "List",
            'user' => "yassuki",
            'segment' => "List",
            'MenuCategory' => $this->RolesPermissionsModel->getAccessMenuCategory(user()->role),
            'addressbook' => $this->ClientModel->list_by_reseller($reseller_code)
        ];

        return view("admin/address-book/customers", $data);
    }

    function delete() {

        $logged_user = (Array) $this->UserModel->get_logged_user();
        $client_code = $this->generateRandomString();
        $reseller_code = $logged_user['reseller_code'];

        $data = [
            'title' => "Customers",
            'subsegment' => "List",
            'user' => "yassuki",
            'segment' => "List",
            'MenuCategory' => $this->RolesPermissionsModel->getAccessMenuCategory(user()->role),
            'addressbook' => $this->ClientModel->list_by_reseller($reseller_code)
        ];

        $client_id = strtolower($this->request->getVar('client_id'));
        $this->ClientModel->ClientDelete($client_id);
        return view("admin/address-book/customers", $data);
    }

    function save() {

        $logged_user = (Array) $this->UserModel->get_logged_user();
        $client_code = $this->generateRandomString();
        $reseller_code = $logged_user['reseller_code'];

        $client_name = strtolower($this->request->getVar('customer_name'));
        $contact_display_name = strtolower($this->request->getVar('contact_name'));

        $this->ClientModel->NewClient($client_code, $client_name, $reseller_code, $contact_display_name);
        $this->RolesPermissionsModel = new RolesPermissionsModel();

        $data = [
            'title' => "Customers",
            'subsegment' => "List",
            'user' => "yassuki",
            'segment' => "List",
            'display_name' => $this->ClientModel->getClient($client_code)[0]['contact_display_name'],
            'MenuCategory' => $this->RolesPermissionsModel->getAccessMenuCategory(user()->role),
            'addressbook' => $this->ClientModel->list_by_reseller($reseller_code)
        ];
        return view("admin/address-book/customers", $data);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
