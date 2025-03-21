<?php

namespace App\Controllers;

use App\Models\M_User;
use Myth\Auth\Controllers\AuthController as MythAuthController;
use Myth\Auth\Models\GroupModel;

class Auth extends MythAuthController

{
    protected $auth, $config, $userModel, $groupModel, $mUser;

    public function __construct()
    {
        parent::__construct();

        $this->userModel = new M_User();
        $this->groupModel = new GroupModel();

        $this->auth = service('authentication');
    }

    public function login()
    {
        return parent::login();
    }

    public function attemptLogin()
    {
        parent::attemptLogin();

        if (!user_id()) {
            return redirect()->back()->withInput()->with('error', 'Please check your credentials.');
        }

        return $this->redirectBasedOnRole();
    }

    public function register()
    {
        return parent::register();
    }

    public function attemptRegister()
    {
        parent::attemptRegister();

        if ($this->users->errors()) {
            return redirect()->back()->withInput()->with('errors', $this->users->errors());
        }

        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();

        if ($user) {
            $customerGroup = $this->groupModel->where('name', 'customer')->first();

            if ($customerGroup) {
                $this->groupModel->addUserToGroup($user->id, $customerGroup->id);
            }
        }

        return redirect()->route('login')->with('message', lang('Auth.activationSuccess'));
    }

    public function activateAccount()
    {
        return parent::activateAccount();
    }

    public function resendActivateAccount()
    {
        return parent::resendActivateAccount();
    }

    private function redirectBasedOnRole()
    {
        $userId = user_id();

        if ($userId === null) {
            return redirect()->back();
        }

        $this->userModel->updateLastLogin($userId);

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
