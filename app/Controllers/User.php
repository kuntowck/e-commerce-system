<?php

namespace App\Controllers;

use App\Models\M_User;

class User extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new M_User;
    }

    public function index()
    {
        return view('user/dashboard');
    }

    public function profile($id)
    {
        return view('user/profile', ['data' => $id]);
    }

    public function settings($setting)
    {
        return view('user/settings', ['data' => $setting]);
    }

    public function role($role)
    {
        $this->userModel->setAdminRole();

        return redirect()->to('/user/dashboard')->with('message', 'Role set to admin');
        // return view('user/role', ['data' => $role]);
    }
}
