<?php

namespace App\Controllers;

use App\Models\M_Produk;
use App\Entities\Produk as ProdukEntity;
use CodeIgniter\RESTful\ResourceController;

class Produk extends ResourceController
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

    public function show($id = null)
    {
        $product = $this->produkModel->getProductById($id);

        echo "<pre>";
        var_dump($id);
        echo "</pre>";
        // die();

        return view('produk/detail', ['product' => $product]);
    }

    public function new()
    {
        return view('produk/create');
    }

    public function create()
    {
        $dataProduct = $this->request->getPost();
        $product = new ProdukEntity($dataProduct);
        $this->produkModel->addProduct($product);

        return redirect()->to('/produk');
    }

    public function update($id = null)
    {
        $dataProduct = $this->request->getPost();
        $updatedProduct = new ProdukEntity($dataProduct);
        $this->produkModel->updateProduct($updatedProduct);

        return redirect()->to('/produk');
    }

    public function edit($id = null)
    {
        $product = $this->produkModel->getProductById($id);

        return view('produk/update', ["product" => $product]);
    }

    public function delete($id = null)
    {
        $this->produkModel->deleteProduct($id);

        return redirect()->to('/produk');
    }
}
