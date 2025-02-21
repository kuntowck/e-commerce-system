<?php

namespace App\Models;

use App\Entities\User;

class M_User
{
    private $users;
    private $session;

    public function __construct()
    {
        $this->users = [
            new User(['id' => 1, 'name' => 'Kunto', 'email' => 'kunto@a.b', 'role' => 'admin']),
            new User(['id' => 2, 'name' => 'Sultan', 'email' => 'sultan@a.b', 'role' => 'admin1'])
        ];

        $this->session = session();
    }

    private function saveData()
    {
        $this->session->set('users', $this->users);
    }

    public function setAdminRole()
    {
        $this->session->set('role', 'admin');
        $this->session->set('isLoggedIn', true);
    }

    public function getUser()
    {
        return $this->users;
    }

    public function getUserById($id)
    {
        foreach ($this->users as $user) {
            if ($user->getId() == $id) {
                return $user;
            }
        }
        return null;
    }

    public function getUserArrayById($id)
    {
        $user = [];

        foreach ($this->users as $value) {
            if ($value->getId() == $id) {
                $user[] = [
                    'id' => $value->getId(),
                    'name' => $value->getName(),
                    'email' => $value->getEmail(),
                    'role' => $value->getRole()
                ];
            }
        }
        return $user;
    }

    public function addUser(User $user)
    {
        $this->users[] = $user;
        $this->saveData();
    }

    public function updateUser(User $user)
    {
        foreach ($this->users as $key => $value) {
            if ($value->getId() == $user->getId()) {
                $this->users[$key] = $user;
                $this->saveData();
            }
        }
    }

    public function deleteUser($userId)
    {
        foreach ($this->users as $key => $value) {
            if ($value->getId() == $userId) {
                unset($this->user[$key]);
                $this->saveData();
            }
        }
    }
}
