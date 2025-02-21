<?php

namespace App\Controllers;

use App\Models\M_User;
use App\Entities\User as UserEntity;


class User extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new M_User;
    }

    public function index()
    {
        $users = $this->userModel->getUser();

        return view('user/index', ['users' => $users]);
    }

    public function show($id)
    {
        $user = $this->userModel->getUserById($id);

        return view('user/detail', ['users' => $user]);
    }

    public function new()
    {
        return view('user/create');
    }

    public function create()
    {
        $dataUser = $this->request->getPost();

        $user = new UserEntity($dataUser);
        $this->userModel->addUser($user);

        return redirect()->to('user');
    }

    public function edit($id)
    {
        $user = $this->userModel->getUserById($id);

        return view('produk/update', ["data" => $user]);
    }

    public function update()
    {
        $dataUser = $this->request->getPost();

        $updatedUser = new UserEntity($dataUser);
        $this->userModel->updateUser($updatedUser);

        return redirect()->to('user');
    }

    public function delete($id)
    {
        $this->userModel->deleteUser($id);

        return redirect()->to('user');
    }

    public function profile($id)
    {
        $parser = service('parser');

        $user = $this->userModel->getUserArrayById($id);
        $accountStatus = [1 => 'Active', 2 => 'Inactive'];

        $data = [
            'title' => 'User Detail',
            'user' => $user,
            'userProfileCell' => [
                [
                    'login' => view_cell('UserProfileCell', ['text' => 'Logged in'], 300, 'user_profile_cell'),
                    'updated' => view_cell('UserProfileCell', ['text' => 'Updated profile']),
                    'ordered' => view_cell('UserProfileCell', ['text' => 'Place an order'])
                ]
            ],
            'accountStatus' => [$accountStatus],
        ];
        $data['content'] = $parser->setData($data)->render('components/parser_user_profile');

        return view('user/profile', $data);
    }

    public function settings($setting)
    {
        return view('user/settings', ['data' => $setting]);
    }
}
