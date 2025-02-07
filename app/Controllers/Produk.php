<?php

namespace App\Controllers;

use App\Models\M_Produk;
use App\Entities\Produk as ProdukEntity;

class Produk extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new M_Produk();
    }

    public function index()
    {
        $products = $this->produkModel->getAllProducts();
        return view('produk/index', ['products' => $products]);
    }

    public function detail($id)
    {
        $product = $this->produkModel->getProductById($id);
        
        return view('produk/detail', ['product' => $product]);
    }

    public function create()
    {
        return view('produk/create');
    }

    public function store()
    {
        $id = $this->request->getPost('id');
        $nama = $this->request->getPost('nama');
        $harga = $this->request->getPost('harga');
        $kategori = $this->request->getPost('kategori');
        $stok = $this->request->getPost('stok');

        $produk = new ProdukEntity($id, $nama, $harga, $stok, $kategori);
        $this->produkModel->addProduct($produk);

        return redirect()->to('/produk');
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $nama = $this->request->getPost('nama');
        $harga = $this->request->getPost('harga');
        $kategori = $this->request->getPost('kategori');
        $stok = $this->request->getPost('stok');

        $updatedProduct = new ProdukEntity($id, $nama, $harga, $stok, $kategori);
        $this->produkModel->updateProduct($updatedProduct);

        return redirect()->to('/produk');
    }

    public function edit($id)
    {
        $product = $this->produkModel->getProductById($id);
        return view('produk/update', ["product" => $product]);
    }

    public function delete($id)
    {
        $this->produkModel->deleteProduct($id);
        return redirect()->to('/produk');
    }
}
