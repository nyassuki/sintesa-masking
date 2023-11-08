<?php

namespace App\Controllers\Admin;

/**
 * Description of device_management
 *
 * @author yassuki
 */
use App\Models\RolesPermissionsModel;
use App\Models\DeviceManagemntModel;
use App\Models\UserModel;


class device_management extends AdminController {
    function __construct() {
        $this->DeviceManagemntModel = new DeviceManagemntModel();
        $this->UserModel = new UserModel();
    }
    function list() {
        $this->RolesPermissionsModel = new RolesPermissionsModel();
        $logged_user = (Array) $this->UserModel->get_logged_user();
        $client_code = $logged_user['client_id'];
        $data = [
            'title' => "Device list",
            'subsegment' => "List",
            'user' => "yassuki",
            'segment' => "List",
            'MenuCategory' => $this->RolesPermissionsModel->getAccessMenuCategory(user()->role),
            'addressbook' => $this->DeviceManagemntModel->deviceList($client_code)
        ];
        return view("admin/device-management/device_list", $data);
    }

}
