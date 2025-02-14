<?php

namespace App\Controllers;

use App\Models\M_User;

class Admin extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new M_User;
    }

    public function index()
    {
        $dataUser = $this->userModel->getUser();

        return view('user/index', ['users' => $dataUser]);
    }

    public function dashboard()
    {
        echo 'Admin controller | Dashboard';
    }

}
