<?php

namespace App\Controllers\Admin;

use App\Models\Locations\CityModel;
use App\Models\Locations\CountryModel;
use App\Models\Locations\StateModel;
use App\Models\RolesPermissionsModel;
use App\Models\UsersModel;
use App\Models\Company;

class UserManagement extends AdminController {

    protected $cityModel;
    protected $stateModel;
    protected $countryModel;
    protected $Company;

    public function __construct() {
        $this->cityModel = new CityModel();
        $this->stateModel = new StateModel();
        $this->countryModel = new CountryModel();
        $this->userModel = new UsersModel();
        $this->RolesPermissionsModel = new RolesPermissionsModel();
        $this->Company = new Company();
    }

    public function administrators() {


        $data = array_merge($this->data, [
            'title' => trans('administrators'),
        ]);

        $pagination = $this->paginate($this->userModel->get_paginated_admin_count());
        $data['users'] = $this->userModel->get_paginated_admin($pagination['per_page'], $pagination['offset']);

        $data['paginations'] = $pagination['pagination'];

        return view('admin/users/administrators', $data);
    }

    public function users() {
        $data = array_merge($this->data, [
            'title' => trans('users'),
        ]);

        //paginate
        $data['paginate'] = $this->userModel->userPaginate();
        $data['pager'] = $data['paginate']['pager'];

        return view('admin/users/users', $data);
    }

    public function add_user() {
        $data = array_merge($this->data, [
            'title' => trans('add_user'),
            'company' => $this->Company->list(),
            'roles' => $this->RolesPermissionsModel->getRole(),
            'countries' => $this->countryModel->asObject()->where('status', 1)->findAll(),
        ]);

        return view('admin/users/add_users', $data);
    }

    /**
     * Add User Post
     */
    public function add_user_post() {
        $validation = \Config\Services::validation();

        //validate inputs

        $rules = [
            'fullname' => [
                'label' => trans('fullname'),
                'rules' => 'required|min_length[4]|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'username' => [
                'label' => trans('username'),
                'rules' => 'required|min_length[4]|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'email' => [
                'label' => trans('email'),
                'rules' => 'required|max_length[200]|valid_email',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                ],
            ],
            'password' => [
                'label' => trans('password'),
                'rules' => 'required|min_length[4]|max_length[200]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'role' => [
                'label' => trans('role'),
                'rules' => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $email = $this->request->getVar('email');
            $username = $this->request->getVar('username');

            //is username unique
            if (!$this->userModel->is_unique_username($username)) {
                $this->session->setFlashData('form_data', $this->userModel->input_values());
                $this->session->setFlashData('error', trans("msg_username_unique_error"));
                return redirect()->back()->withInput();
            }
            //is email unique
            if (!$this->userModel->is_unique_email($email)) {
                $this->session->setFlashData('form_data', $this->userModel->input_values());
                $this->session->setFlashData('error', trans("message_email_unique_error"));
                return redirect()->back()->withInput();
            }

            //add user
            $id = $this->userModel->add_user();
            if ($id) {
                reset_cache_data_on_change();
                $this->session->setFlashData('success', trans("msg_user_added"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back();
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    /**
     * Edit User
     */
    public function edit_user($id) {

        $data = array_merge($this->data, [
            'title' => trans('update_profile'),
            'user' => $this->userModel->get_user($id),
            'roles' => $this->RolesPermissionsModel->getRole(),
            'countries' => $this->countryModel->asObject()->where('status', 1)->findAll(),
        ]);

        $data["states"] = $this->stateModel->asObject()->where('country_id', $data['user']->country_id)->findAll();
        $data["cities"] = $this->cityModel->asObject()->where('state_id', $data['user']->state_id)->findAll();

        if (empty($data['user']->id)) {
            return redirect()->back();
        }

        return view('admin/users/edit_user', $data);
    }

    /**
     * Edit User Post
     */
    public function edit_user_post() {


        $validation = \Config\Services::validation();

        //validate inputs
        $rules = [
            'fullname' => [
                'label' => trans('fullname'),
                'rules' => 'required|min_length[4]|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'username' => [
                'label' => trans('username'),
                'rules' => 'required|min_length[4]|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'email' => [
                'label' => trans('email'),
                'rules' => 'required|max_length[200]|valid_email',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                ],
            ],
            'role' => [
                'label' => trans('role'),
                'rules' => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],
        ];

        if (!empty($this->request->getVar('password'))) {
            $rules['password'] = [
                'label' => trans('password'),
                'rules' => 'required|min_length[4]|max_length[50]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                ]
            ];
        }

        if ($this->validate($rules)) {
            $data = array(
                'id' => $this->request->getVar('id'),
                'username' => $this->request->getVar('username'),
                'slug' => $this->request->getVar('slug'),
                'email' => $this->request->getVar('email')
            );

            //is email unique
            if (!$this->userModel->is_unique_username($data["email"], $data["id"])) {
                $this->session->setFlashData('errors_form', trans("message_email_unique_error"));
                return redirect()->back()->withInput();
            }
            //is username unique
            if (!$this->userModel->is_unique_username($data["username"], $data["id"])) {
                $this->session->setFlashData('errors_form', trans("msg_username_unique_error"));
                return redirect()->back()->withInput();
            }
            //is slug unique
            if ($this->userModel->check_is_slug_unique($data["slug"], $data["id"])) {
                $this->session->setFlashData('errors_form', trans("msg_slug_used"));
                return redirect()->back()->withInput();
            }

            if ($this->userModel->edit_user($data["id"])) {
                reset_cache_data_on_change();
                $this->session->setFlashData('success', trans("msg_updated"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('errors', trans("msg_error"));
                return redirect()->back();
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    /**
     * Delete User Post
     */
    public function delete_user_post() {

        $id = $this->request->getVar('id');
        $user = $this->userModel->asObject()->find($id);

        if ($user->id == 1 || $user->id == user()->id) {
            $this->session->setFlashData('error', trans("msg_error"));
        }


        if ($this->userModel->delete_user($id)) {
            reset_cache_data_on_change();
            $this->session->setFlashData('success', trans("user") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    /**
     * Ban User Post
     */
    public function ban_user_post() {

        $option = $this->request->getVar('option');
        $id = $this->request->getVar('id');

        $user = $this->userModel->asObject()->find($id);
        if ($user->id == 1 || $user->id == user()->id) {
            $this->session->setFlashData('error', trans("msg_error"));
        }

        //if option ban
        if ($option == 'ban') {
            if ($this->userModel->ban_user($id)) {
                $this->session->setFlashData('success', trans("msg_user_banned"));
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
            }
        }

        //if option remove ban
        if ($option == 'remove_ban') {
            if ($this->userModel->remove_user_ban($id)) {
                $this->session->setFlashData('success', trans("msg_ban_removed"));
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
            }
        }
    }

    /**
     * Confirm User Email
     */
    public function confirm_user_email() {
        $id = $this->request->getVar('id');
        $user = $this->userModel->asObject()->find($id);
        if ($this->userModel->verify_email($user)) {
            $this->session->setFlashData('success', trans("msg_updated"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    /**
     * Change User Role
     */
    public function change_user_role_post() {
        if (!is_admin()) {
            return redirect()->to(admin_url());
        }
        $id = $this->request->getVar('user_id');
        $role = $this->request->getVar('role');
        $user = $this->userModel->asObject()->find($id);

        //check if exists
        if (empty($user)) {
            return redirect()->back();
        } else {
            if ($user->id == 1 || $user->id == user()->id) {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back();
            }

            if ($this->userModel->change_user_role($id, $role)) {
                $this->session->setFlashData('success', trans("msg_role_changed"));
                return redirect()->back();
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->back();
            }
        }
    }

}
