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
        $dataProduct = $this->request->getPost();
        $product = new ProdukEntity($dataProduct);
        $this->produkModel->addProduct($product);

        return redirect()->to('/produk');
    }

    public function update()
    {
        $dataProduct = $this->request->getPost();
        $updatedProduct = new ProdukEntity($dataProduct);
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
