<?php

namespace App\Controllers;

class User extends BaseController
{
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
        return view('user/role', ['data' => $role]);
    }
}
