<?php

namespace App\Models;

use App\Entities\Produk;

class M_Produk
{
    private $products = [];

    public function __construct()
    {
        $this->products = [
            new Produk(1, 'Sepatu Bola', 600000, 10, 'Sepatu'),
            new Produk(2, 'Sepatu Running', 800000, 20, 'Sepatu'),
        ];
    }

    public function getAllProducts()
    {
        return $this->products;
    }

    public function getProductById($id)
    {
        foreach ($this->products as $product) {
            if ($product->getId() === $id) {
                return $product;
            }
        }
        return null;
    }

    public function addProduct(Produk $produk)
    {
        $this->products[] = $produk;

        return true;
    }

    public function updateProduct(Produk $produk)
    {
        foreach ($this->products as $product) {
            if ($product->getId() === $produk->getId()) {
                $product = $produk;

                return true;
            }
        }

        return false;
    }

    public function deleteProduct($id)
    {
        foreach ($this->products as $key => $product) {
            if ($product->getId() === $id) {
                unset($this->products[$key]);

                return true;
            }
        }

        return false;
    }
}
