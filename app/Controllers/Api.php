<?php

namespace App\Controllers;

use App\Models\M_Produk;
use App\Models\M_User;

class Api extends BaseController
{
    private $userModel;
    private $produkModel;
    public function __construct()
    {
        $this->userModel = new M_User();
        $this->produkModel = new M_Produk();
    }

    public function listProducts()
    {
        $dataProduk = $this->produkModel->getAllProducts();
        $data = array_map(function ($product) {
            return [
                "id" => $product->getId(),
                "nama" => $product->getNama(),
                "harga" => $product->getHarga(),
                "stok" => $product->getStok(),
                "kategori" => $product->getKategori(),

            ];
        }, $dataProduk);
        return $this->response->setJSON(['status' => 200, 'data' => $data]);
    }

    public function detailProduct($id)
    {
        $product = $this->produkModel->getProductById($id);
        $data =
            [
                "id" => $product->getId(),
                "nama" => $product->getNama(),
                "harga" => $product->getHarga(),
                "stok" => $product->getStok(),
                "kategori" => $product->getKategori(),

            ];
        return $this->response->setJSON(['status' => 200, 'data' => $data]);
    }

    public function listUsers()
    {
        $dataUser = $this->userModel->getUser();
        $data = array_map(function ($user) {
            return [
                "id" => $user->getId(),
                "name" => $user->getName(),
                "role" => $user->getRole(),
            ];
        }, $dataUser);
        return $this->response->setJSON(['status' => 200, 'data' => $data]);
    }

    public function detailUser($id)
    {
        $user = $this->userModel->getUserById(intval($id));
        $data =
            [
                "id" => $user->getId(),
                "name" => $user->getName(),
                "email" => $user->getEmail(),
                "role" => $user->getRole(),
            ];
        return $this->response->setJSON(['status' => 200, 'data' => $data]);
    }
}
