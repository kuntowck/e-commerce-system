<?php

namespace App\Controllers;

use App\Models\M_User;
use Myth\Auth\Controllers\AuthController as MythAuthController;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\GroupModel;

class Auth extends MythAuthController

{
    protected $auth, $config, $userModel, $groupModel, $mUser;

    public function __construct()
    {
        parent::__construct();

        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->mUser = new M_User();

        $this->auth = service('authentication');
    }

    public function login()
    {
        return parent::login();
    }

    public function attemptLogin()
    {
        parent::attemptLogin();

        return $this->redirectBasedOnRole();
    }

    public function register()
    {
        return parent::register();
    }

    public function attemptRegister()
    {
        return parent::attemptRegister();
    }

    private function redirectBasedOnRole()
    {
        $userId = user_id();

        if ($userId === null) {
            return redirect()->back();
        }

        $this->mUser->updateLastLogin($userId);
        $userGroups = $this->groupModel->getGroupsForUser($userId);

        foreach ($userGroups as $group) {
            if ($group['name'] === 'admin') {

                return redirect()->to('admin/dashboard');
            } else if ($group['name'] === 'product-manager') {

                return redirect()->to('product-manager/dashboard');
            } else if ($group['name'] === 'customer') {

                return redirect()->to('customer/dashboard');
            }
        }

        return redirect()->to('/');
    }
}
