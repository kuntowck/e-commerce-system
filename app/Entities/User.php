<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $datamap = [];
    protected $dates   = ['last_login', 'created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'last_login' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $attributes = [
        'id' => null,
        'username' => null,
        'email' => null,
        'password' => null,
        'full_name' => null,
        'role' => null,
        'status' => null,
        'last_login' => null,
    ];

    public function setPassword(string $password)
    {
        return $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword(string $password)
    {
        return password_verify($password, $this->attributes['password']);
    }

    public function isAdmin()
    {
        return $this->attributes['role'] === 'admin';
    }

    public function getFullName()
    {
        return $this->attributes['full_name'];
    }

    public function getFormattedLastLogin()
    {
        $timestamp = strtotime($this->attributes['last_login']);
        $timeDiff = time() - $timestamp;

        $units = [
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        ];

        if ($this->attributes['last_login'] == null) {
            return 'Never';
        }

        foreach ($units as $seconds => $unit) {
            $interval = floor($timeDiff / $seconds);
            if ($interval >= 1) {
                return $interval . ' ' . $unit . 's ago';
            }
        }

        return 'Just now';
    }
}
