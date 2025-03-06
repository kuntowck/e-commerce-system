<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;


class Produk extends Entity
{

    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $attributes = [
        'id' => null,
        'name' => null,
        'description' => null,
        'price' => null,
        'stock' => null,
        'category_id' => null,
        'status' => null,
        'is_new' => null,
        'is_sale' => null,
    ];

    public function getFormattedPrice()
    {
        return 'Rp' . number_format($this->attributes['price'], 0, ',', '.');
    }

    public function getPriceToInt($price)
    {
        $priceInt = str_replace(['Rp', '.', ','], '', $price);

        return $priceInt;
    }

    public function isInStock()
    {
        return $this->stok > 0;
    }

    public function getStatus()
    {
        return $this->attributes['status'] === 'available' ? 'Available' : 'Unavailable';
    }

    public function isSale()
    {
        return $this->attributes['is_sale'] === true;
    }
}
