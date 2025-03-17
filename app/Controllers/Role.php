<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_User;
use Myth\Auth\Entities\Group;
use Myth\Auth\Models\GroupModel;

class Role extends BaseController
{
    protected $groupModel, $groupEntity, $userModel;

    public function __construct()
    {
        $this->groupModel = new GroupModel();
        $this->groupEntity = new Group();
        $this->userModel = new M_User();
    }

    public function index()
    {
        // $roles = $this->userModel->getUserJoinGroup()->findAll();
        $roles = $this->groupModel->findAll();

        $data = [
            'title' => 'Role Management',
            'roles' => $roles
        ];

        return view('role/index', $data);
    }

    public function new()
    {
        $data = ['title' => 'Create Role'];

        return view('role/create', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();

        if (!$this->groupModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        return redirect()->to('admin/roles')->with('message', 'role has been successfully added.');
    }

    public function edit($id = null)
    {
        $role = $this->groupModel->find($id);

        $data = [
            'title' => 'Update Role',
            'role' => $role
        ];

        return view('role/update', $data);
    }

    public function update($id = null)
    {
        $data = $this->request->getPost();

        if (!$this->groupModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->groupModel->errors());
        }

        return redirect()->to('admin/roles')->with('message', 'Role has been successfully updated.');
    }

    public function delete($id = null)
    {
        $this->groupModel->delete($id);

        return redirect()->to('admin/roles')->with('message', 'Role has been successfully deleted.');
    }
}
