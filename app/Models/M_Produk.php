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
        $this->products = [
            new Produk(['id' => '1', 'nama' => 'Nasi Goreng', 'harga' => 30000, 'stok' => 15, 'kategori' => 'Makanan', 'status' => 'Active']),
            new Produk(['id' => '2', 'nama' => 'Sate Ayam', 'harga' => 40000, 'stok' => 25, 'kategori' => 'Makanan', 'status' => 'Active']),
            new Produk(['id' => '3', 'nama' => 'Takoyaki', 'harga' => 50000, 'stok' => 0, 'kategori' => 'Makanan', 'status' => 'Inactive']),
        ];
    }

    private function saveData()
    {
        $this->session->set('produk', $this->products);
    }

    public function getAllProducts()
    {
        return $this->products;
    }

    public function getAllProductsArray()
    {
        $products = [];

        foreach ($this->products as $product) {
            $products[] = [
                'id' => $product->getId(),
                'name' => $product->getNama(),
                'price' => $product->getHarga(),
                'stock' => $product->getStok(),
                'category' => $product->getKategori(),
                'status' => $product->getStatus(),
            ];
        }

        return $products;
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

    public function getCategoriesByProductId($productId)
    {
        $categories = [
            1 => ['Makanan', 'Rice'],
            2 => ['Makanan', 'Sate'],
            3 => ['Makanan', 'Snacks'],
        ];

        return $categories[$productId];
    }
}
