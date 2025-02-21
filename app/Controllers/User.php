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
        $parser = service('parser');

        $users = $this->userModel->getUserArrayById($id);
        $activityHistory = $this->userModel->getActivityHistoryById();
        $accountStatus = 'Active';

        $data = [
            'title' => 'User Profile',
            'users' => $users,
            'activityHistory' => [$activityHistory],
            'accountStatus' => $accountStatus,
        ];
        $data['content'] = $parser->setData($data)->render('components/parser_user_profile');

        return view('user/profile', $data);
    }

    public function settings($setting)
    {
        return view('user/settings', ['data' => $setting]);
    }

    public function role()
    {
        $this->userModel->setAdminRole();

        return redirect()->to('/admin/dashboard')->with('message', 'Role set to admin');
    }
}
