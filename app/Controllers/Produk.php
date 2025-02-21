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

    public function productList()
    {
        $parser = service('parser');

        $products = $this->produkModel->getAllProductsArray();
        $inputSearch = $this->request->getGet("search");
        $categoryFilter = $this->request->getGet("category");

        $cacheKey = 'product_list_search_filter' . md5($inputSearch . '_' . $categoryFilter);

        if ($inputSearch) {
            $products = array_filter($products, function ($product) use ($inputSearch) {
                return stripos($product['name'], $inputSearch) !== false;
            });
        }

        if ($categoryFilter && $categoryFilter !== 'All') {
            $products = array_filter($products, function ($product) use ($categoryFilter) {
                $categories = $this->produkModel->getCategoriesByProductId($product['id']);

                return in_array($categoryFilter, $categories);
            });
        }

        foreach ($products as $key => &$product) {
            $product['price'] = number_format($product['price'], 0, ',', '.');
            $product['stockStatus'] = $product['stock'] > 0 ? 'Available' : 'Out of Stock';
            $product['categories'] = [$this->produkModel->getCategoriesByProductId($product['id'])];

            if ($key === count($products) - 1) {
                $product['badgeCell'] = view_cell('ProductBadgeCell', ['text' => 'Sale']);
            } else {
                $product['badgeCell'] = view_cell('ProductBadgeCell', ['text' => 'New']);
            }
        }

        $data = [
            'title' => 'Product Catalog',
            'products' => $products,
        ];
        $data['content'] = $parser->setData($data)->render('components/parser_product_list');

        cache()->save($cacheKey, $data['content'], 3600);
        return view('produk/product_list', $data);
    }
}
