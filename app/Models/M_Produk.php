<?php

namespace App\Models;

use App\Entities\Produk;

class M_Produk
{
    private $products = [];
    private $session;

    public function __construct()
    {
        $this->session = session();
        $this->products = $this->session->get('produk') ?? [];
        // $this->products = [
        //     new Produk(1, 'Sepatu Bola', 600000, 10, 'Sepatu'),
        //     new Produk(2, 'Sepatu Running', 800000, 20, 'Sepatu'),
        // ];
    }

    private function saveData()
    {
        $this->session->set('produk', $this->products);
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
        $this->saveData();

        return true;
    }

    public function updateProduct(Produk $produk)
    {
        foreach ($this->products as $key => $product) {
            if ($product->getId() === $produk->getId()) {
                $this->products[$key] = $produk;
                $this->saveData();

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
                $this->saveData();

                return true;
            }
        }

        return false;
    }
}
