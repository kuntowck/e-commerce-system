<?php

namespace App\Controllers;

use App\Models\M_User;
use App\Entities\User as UserEntity;
use App\Libraries\DataParams;
use Myth\Auth\Models\GroupModel;

class User extends BaseController
{
    private $userModel, $groupModel;

    public function __construct()
    {
        $this->userModel = new M_User;
        $this->groupModel = new GroupModel();
    }

    public function index()
    {
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
            $user->groups = $this->groupModel->getGroupsForUser($user->id)[0];
        }

        $data = [
            'title' => 'User Management',
            'users' => $results['users'],
            'pager' => $results['pager'],
            'total' => $results['total'],
            'params' => $params,
            'roles' =>  $this->groupModel->findAll(),
            'statuses' => $this->userModel->getAllStatus(),
            'baseURL' => base_url('admin/users')
        ];

        $output = view('user/index', $data);
        cache()->save('admin_user_list', $output, 900);
        return $output;
    }

    public function show($id)
    {
        $user = $this->userModel->find($id);

        $data = [
            'title' => 'Detail User',
            'users' => $user
        ];

        return view('user/profile', $data);
    }

    public function profile($id)
    {
        $parser = service('parser');

        $user = $this->userModel->getUserJoinGroup()->where('user_id', $id)->first();
        $activityHistory = $this->userModel->select('last_login, updated_at,created_at')->where('id', $id)->first();

        $data = [
            'title' => 'User Profile',
            'user' => [
                [
                    'email' => $user->email,
                    'username' => $user->username,
                    'full_name' => $user->full_name,
                    'role' => view_cell('BadgeCell', ['text' => $user->group_name])
                ]
            ],
            'userProfileCell' => [
                [
                    'login' => view_cell('UserProfileCell', ['text' => 'Logged in', 'date' => $activityHistory->last_login]),
                    'updated' => view_cell('UserProfileCell', ['text' => 'Updated profile', 'date' => $activityHistory->updated_at]),
                    'created' => view_cell('UserProfileCell', ['text' => 'Created profile', 'date' => $activityHistory->created_at]),
                ]
            ],
            'accountStatus' => view_cell('BadgeCell', ['text' => $user->status])
        ];
        $data['content'] = $parser->setData($data)->render('components/parser_user_profile');

        return view('user/profile', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Create User',
            'roles' =>  $this->groupModel->findAll(),
        ];

        return view('user/create', $data);
    }

    public function create()
    {
        $user = new \Myth\Auth\Entities\User();

        $user->username = $this->request->getVar('username');
        $user->email = $this->request->getVar('email');
        $user->full_name = $this->request->getVar('full_name');
        $user->password = $this->request->getVar('password');
        $user->active = 1;

        if (!$this->userModel->save($user)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        // tambahkan user ke dalam group
        $newUser = $this->userModel->where('email', $user->email)->first();
        $userId = $newUser->id;

        $groupId = $this->request->getVar('group');
        $this->groupModel->addUserToGroup($userId, $groupId);

        return redirect()->to('admin/users')->with('message', 'User has been successfully added.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Update User',
            'user' => $this->userModel->find($id),
            'groups' => $this->groupModel->findAll(),
            'userGroups' => $this->groupModel->getGroupsForUser($id),
        ];

        if (empty($data['user'])) {
            return redirect()->to('/users')->with('error', 'User is not found.');
        }

        return view('user/update', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/users')->with('error', 'User is not found.');
        }

        $username = $this->request->getVar('username');
        $email = $this->request->getVar('email');
        $full_name = $this->request->getVar('full_name');
        $password = $this->request->getVar('password');
        $passConfirm = $this->request->getVar('pass_confirm');
        $groupId = $this->request->getVar('group');

        // check unique username
        if ($user->username !== $username) {
            $existingUser = $this->userModel->where('email', $username)->first();

            if ($existingUser) {
                return redirect()->back()->withInput()->with('error', 'Username already used.');
            }
        }

        // check unique email
        if ($user->email !== $email) {
            $existingEmail = $this->userModel->where('email', $email)->first();

            if ($existingEmail) {
                return redirect()->back()->withInput()->with('error', 'Email already used.');
            }
        }

        // check password = password confirm
        if (!empty($password)) {
            if ($password != $passConfirm) {
                return redirect()->back()->withInput()->with('error', 'Password dan konfirmasi tidak sama');
            }
        }

        $newUser = new \Myth\Auth\Entities\User();

        $newUser->id = $id;
        $newUser->username = $username;
        $newUser->email = $email;
        $newUser->full_name = $full_name;
        $newUser->active = $this->request->getVar('status') ? 1 : 0;

        // Update password jika diisi
        if (!empty($password)) {
            $newUser->password = $password;
        }

        if (!$this->userModel->save($newUser)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        // update user ke dalam group
        if (!empty($groupId)) {
            $currentGroup = $this->groupModel->getGroupsForUser($id);

            foreach ($currentGroup as $group) {
                $this->groupModel->removeUserFromGroup($id, $group['group_id']);
            }

            $this->groupModel->addUserToGroup($id, $groupId);
        }

        return redirect()->to('admin/users')->with('message', 'User has been successfully updated.');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (empty($user)) {
            return redirect()->to('/users')->with('error', 'User is not found.');
        }

        $this->userModel->delete($id);

        return redirect()->to('admin/users')->with('message', 'User has been successfully deleted.');
    }

    public function settings($setting)
    {
        return view('user/settings', ['data' => $setting]);
    }
}
