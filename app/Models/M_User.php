<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\DataParams;
use CodeIgniter\I18n\Time;

class M_User extends Model
{
    private $session;

    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\User::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'username', 'email', 'password', 'full_name', 'status', 'last_login'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|is_unique[users.username]|min_length[3]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]',
    ];
    protected $validationMessages = [
        'username' => [
            'required'   => 'Username is required.',
            'is_unique'  => 'Username must be unique.',
            'min_length' => 'Username must be at least 3 characters long.',
        ],
        'email' => [
            'required'    => 'Email is required.',
            'valid_email' => 'Please provide a valid email address.',
            'is_unique'   => 'Email must be unique.',
        ],
        'password' => [
            'required'   => 'Password is required.',
            'min_length' => 'Password must be at least 8 characters long.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function findActiveUsers()
    {
        return $this->where('status', 'active')->countAllResults();
    }

    public function getTotalUsers()
    {
        return $this->countAllResults();
    }

    public function getNewUsersThisMonth()
    {
        $currentMonth = date('Y-m');

        return $this->where('created_at >=', "$currentMonth-01 00:00:00")
            ->where('created_at <=', "$currentMonth-31 23:59:59")
            ->countAllResults();
    }

    public function getUserStatistics()
    {
        $stats['total_users'] = $this->getTotalUsers();
        $stats['active_users'] = $this->findActiveUsers();
        $stats['new_users_this_month'] = $this->getNewUsersThisMonth();

        $previousMonth = date('Y-m', strtotime('-1 month'));
        $newUsersLastMonth = $this->where('created_at >=', "$previousMonth-01 00:00:00")
            ->where('created_at <=', "$previousMonth-31 23:59:59")
            ->countAllResults();

        $stats['growth_percentage'] = '30%';

        return $stats;
    }

    public function updateLastLogin($userId)
    {
        return $this->where('id', $userId)
            ->set('last_login', date('Y-m-d H:i:s'))
            ->update();
    }

    public function getUserJoinGroup()
    {
        return $this->select('users.*, auth_groups_users.*, auth_groups.name as group_name')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
            ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id', 'left')->asObject();
    }

    public function getFilteredUsers(DataParams $params)
    {
        // Apply search
        if (!empty($params->search)) {
            $this->groupStart()
                ->like('full_name', $params->search, 'both', null, true)
                ->orLike('username', $params->search, 'both', null, true)
                ->orLike('email', $params->search, 'both', null, true)
                ->orLike('status', $params->search, 'both', null, true);

            if (is_numeric($params->search)) {
                $this->orWhere('CAST (id as TEXT) LIKE', "%$params->search%");
            }
            $this->groupEnd();
        }

        // Apply role filter
        if (!empty($params->role)) {
            $this->getUserJoinGroup()
                ->where('group_id', $params->role);
        }

        // Apply status filter
        if (!empty($params->status)) {
            $this->where('status', $params->status);
        }

        // Apply sort
        $allowedSortColumns = ['id', 'full_name', 'email', 'role', 'status', 'last_login'];
        $sort = in_array($params->sort, $allowedSortColumns) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'desc' : 'asc';

        $this->orderBy($sort, $order);

        $result = [
            'users' => $this->paginate($params->perPage, 'users', $params->page),
            'pager' => $this->pager,
            'total' => $this->countAllResults(false)
        ];
        return $result;
    }

    public function getAllRoles()
    {
        $roles = $this->select('role')->distinct()->findAll();

        return array_column($roles, 'role');
    }

    public function getAllStatus()
    {
        $statuses = $this->select('status')->distinct()->findAll();

        return array_column($statuses, 'status');
    }
}
