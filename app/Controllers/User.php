<?php

namespace App\Controllers;

use App\Models\M_User;
use App\Entities\User as UserEntity;
use App\Libraries\DataParams;

class User extends BaseController
{
    private $userModel, $userEntity;

    public function __construct()
    {
        $this->userModel = new M_User;
        $this->userEntity = new UserEntity;
    }

    public function index()
    {
        $data['user'] = $this->userModel->findAll();

        $params = new DataParams([
            'search' => $this->request->getGet('search'),
            'role' => $this->request->getGet('role'),
            'status' => $this->request->getGet('status'),
            'sort' => $this->request->getGet('sort'),
            'order' => $this->request->getGet('order'),
            'page' => $this->request->getGet('page_users'),
            'perPage' => $this->request->getGet('perPage')
        ]);

        $results = $this->userModel->getFilteredUsers($params);

        foreach ($results['users'] as &$user) {
            $user->status_cell = view_cell('BadgeCell', ['text' => $user->status]);
        }

        $data = [
            'users' => $results['users'],
            'pager' => $results['pager'],
            'total' => $results['total'],
            'params' => $params,
            'roles' => $this->userModel->getAllRoles(),
            'statuses' => $this->userModel->getAllStatus(),
            'baseURL' => base_url('admin/user')
        ];

        $output = view('user/index', $data);
        cache()->save('admin_user_list', $output, 900);
        return $output;
    }

    public function show($id)
    {
        $user = $this->userModel->find($id);

        return view('user/detail', ['users' => $user]);
    }

    public function profile($id)
    {
        $parser = service('parser');

        $user = $this->userModel->asArray()->find($id);
        $this->userModel->updateLastLogin($id);

        $data = [
            'title' => 'User Detail',
            'user' => [$user],
            'userProfileCell' => [
                [
                    'login' => view_cell('UserProfileCell', ['text' => 'Logged in'], 300, 'user_profile_cell'),
                    'updated' => view_cell('UserProfileCell', ['text' => 'Updated profile']),
                    'ordered' => view_cell('UserProfileCell', ['text' => 'Place an order'])
                ]
            ],
            'accountStatus' => $user['status'],
        ];
        $data['content'] = $parser->setData($data)->render('components/parser_user_profile');

        return view('user/profile', $data);
    }

    public function new()
    {
        return view('user/create');
    }

    public function create()
    {
        $dataUser = $this->request->getPost();
        $dataUser['password'] = $this->userEntity->setPassword($dataUser['password']);

        if (!$this->userModel->save($dataUser)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        return redirect()->to('admin/user');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        return view('user/update', ["user" => $user]);
    }

    public function update($id)
    {
        $dataUser = $this->request->getPost();

        $this->userModel->setValidationRule("username", "required|is_unique[users.username,id,{$id}]|min_length[3]|max_length[255]");
        $this->userModel->setValidationRule("email", "required|is_unique[users.email,id,{$id}]|valid_email|max_length[255]");

        if (!$this->userModel->update($id, $dataUser)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        return redirect()->to('admin/user');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);

        return redirect()->to('admin/user');
    }

    public function settings($setting)
    {
        return view('user/settings', ['data' => $setting]);
    }
}
