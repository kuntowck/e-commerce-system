<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;

class M_User extends Model
{
    private $session;

    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\User::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'username', 'email', 'password', 'full_name', 'role', 'status', 'last_login'];

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
        $growthPercentage = $newUsersLastMonth > 0 ? (($stats['new_user_this_month'] - $newUsersLastMonth) / $newUsersLastMonth) * 100 : 0;
        $stats['growth_percentage'] = $growthPercentage;

        return $stats;
    }

    public function updateLastLogin($userId, $lastLoginTime)
    {
        return $this->update($userId, ['last_login' => $lastLoginTime]);
    }

    public function setAdminRole()
    {
        $this->session = session();

        $this->session->set('role', 'admin');
        $this->session->set('isLoggedIn', true);
    }
}
