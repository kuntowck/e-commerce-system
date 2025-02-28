<?php

namespace App\Controllers;

use App\Models\M_Produk;
use App\Entities\Produk as ProdukEntity;
use App\Models\M_Category;
use CodeIgniter\RESTful\ResourceController;

class Produk extends ResourceController
{
    protected $produkModel, $produkEntity, $categoryModel;

    public function __construct()
    {
        $this->produkModel = new M_Produk();
        $this->produkEntity = new ProdukEntity();
        $this->categoryModel = new M_Category();
    }

    public function index()
    {
        $products = $this->produkModel->findAll();
        $categories = $this->categoryModel->findAll();

        return view('produk/index', ['products' => $products, 'categories' => $categories]);
    }

    public function show($id = null)
    {
        $product = $this->produkModel->find($id);

        return view('produk/detail', ['product' => $product]);
    }

    public function new()
    {
        $categories = $this->categoryModel->findAll();

        return view('produk/create', ['categories' => $categories]);
    }

    public function create()
    {
        $dataProduct = $this->request->getPost();
        $dataProduct['price'] = $this->produkEntity->getPriceToInt($dataProduct['price']);
        $dataProduct['category_id'] = $this->produkEntity->getPriceToInt($dataProduct['category_id']);
        // dd($dataProduct);

        if ($this->produkModel->save($dataProduct) === false) {
            return view('produk/create', ['errors' => $this->produkModel->errors()]);
        }

        $this->produkModel->save($dataProduct);
        return redirect()->to('/produk');
    }

    public function edit($id = null)
    {
        $product = $this->produkModel->find($id);
        $categories = $this->categoryModel->findAll();

        return view('produk/update', ["product" => $product, 'categories' => $categories]);
    }

    public function update($id = null)
    {
        $dataProduct = $this->request->getPost();
        $dataProduct['price'] = $this->produkEntity->getPriceToInt($dataProduct['price']);

        if ($this->produkModel->update($id, $dataProduct) === false) {
            return redirect()->back()->withInput()->with('errors', $this->produkModel->errors());
        }

        $this->produkModel->update($id, $dataProduct);
        return redirect()->to('/produk');
    }

    public function delete($id = null)
    {
        $this->produkModel->delete($id);

        return redirect()->to('/produk');
    }

    public function productList()
    {
        $parser = service('parser');

        $products = $this->produkModel->asArray()->findAll();
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
                $categories = $this->categoryModel->find($product['id']);

                return in_array($categoryFilter, $categories);
            });
        }

        foreach ($products as $key => &$product) {
            $product['price'] = number_format($product['price'], 0, ',', '.');
            $product['stockStatus'] = $product['stock'] > 0 ? 'Available' : 'Out of Stock';
            $product['category'] = [$this->categoryModel->find($product['id'])];

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
        d($data);
        $data['content'] = $parser->setData($data)->render('components/parser_product_list');

        cache()->save($cacheKey, $data['content'], 3600);
        return view('produk/product_list', $data);
    }
}
