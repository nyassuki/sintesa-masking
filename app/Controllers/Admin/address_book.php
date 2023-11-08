<?php

namespace App\Controllers\Admin;

/**
 * Description of address_book
 *
 * @author yassuki
 */
use App\Models\RolesPermissionsModel;
use App\Models\AddressBookModel;
use App\Models\UserModel;
use App\Models\ClientModel;

class address_book extends AdminController {

    private $AddressBookModel;

    function __construct() {
        $this->AddressBookModel = new AddressBookModel();
        $this->UserModel = new UserModel();
        $this->ClientModel = new ClientModel();
    }

    function list() {
        $this->RolesPermissionsModel = new RolesPermissionsModel();

        $logged_user = (Array) $this->UserModel->get_logged_user();
        $client_code = $logged_user['client_id'];
        $reseller_code = $logged_user['reseller_code'];
        $role = $logged_user['role'];
        if ($role == '3') {
            $address_book_list = $this->AddressBookModel->listByReseller($reseller_code);
        } else {
            $address_book_list = $this->AddressBookModel->list($client_code);
        }

        $data = [
            'title' => "Address book",
            'subsegment' => "List",
            'user' => "yassuki",
            'segment' => "List",
            'display_name' => "",
            'MenuCategory' => $this->RolesPermissionsModel->getAccessMenuCategory(user()->role),
            'addressbook' => $address_book_list
        ];
        return view("admin/address-book/address-book", $data);
    }

    function save() {
        $logged_user = (Array) $this->UserModel->get_logged_user();
        $client_code = $logged_user['client_id'];
        $reseller_code = $logged_user['reseller_code'];

        $phone_number = strtolower($this->request->getVar('phone_number'));
        $contact_name = strtolower($this->request->getVar('contact_name'));

        $this->AddressBookModel->Add($client_code, $phone_number, $contact_name, $reseller_code);
        $this->RolesPermissionsModel = new RolesPermissionsModel();

        $data = [
            'title' => "Address book",
            'subsegment' => "List",
            'user' => "yassuki",
            'segment' => "List",
            'display_name' => $this->ClientModel->getClient($client_code)[0]['contact_display_name'],
            'MenuCategory' => $this->RolesPermissionsModel->getAccessMenuCategory(user()->role),
            'addressbook' => $this->AddressBookModel->list($client_code)
        ];
        return view("admin/address-book/address-book", $data);
    }

    function delete() {
        $logged_user = (Array) $this->UserModel->get_logged_user();
        $client_code = $logged_user['client_id'];
        $phone_number = strtolower($this->request->getVar('phone_number'));
        $this->AddressBookModel->PhoneDelete($phone_number);

        $data = [
            'title' => $phone_number,
            'subsegment' => "List",
            'user' => "yassuki",
            'segment' => "List",
            'MenuCategory' => $this->RolesPermissionsModel->getAccessMenuCategory(user()->role),
            'addressbook' => $this->AddressBookModel->list($client_code)
        ];
        return view("admin/address-book/address-book", $data);
    }

    function update() {
        
    }

    function push() {
        
    }

}
