<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Category extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $attributes =[
        'id' => null, 
        'name' => null, 
        'description' => null, 
        'status' => null
    ];
}
