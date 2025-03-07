<?php

namespace App\Controllers;

use App\Models\M_Produk;
use App\Entities\Produk as ProdukEntity;
use App\Libraries\DataParams;
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
        $params = new DataParams([
            "search" => $this->request->getGet("search"),
            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_products"),
            "category_id" => $this->request->getGet("category_id"),
            "price_range" => $this->request->getGet("price_range"),
        ]);

        $result = $this->produkModel->getFilteredProducts($params);

        $data = [
            'products' => $result['products'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'categories' => $this->categoryModel->findAll(),
            'priceRange' => $this->produkModel->getAllPriceRange(),
            'baseURL' => base_url('produk'),
        ];

        return view('produk/index', $data);
    }

    public function show($id = null)
    {
        $data['product'] = $this->produkModel->getProductJoinCategoriesImages()->find($id);

        return view('produk/detail', $data);
    }

    public function new()
    {
        $data['categories'] = $this->categoryModel->select('id, name')->findAll();

        return view('produk/create', $data);
    }

    public function create()
    {
        $dataProduct = $this->request->getPost();
        $dataProduct['price'] = $this->produkEntity->getPriceToInt($dataProduct['price']);

        if (!$this->produkModel->save($dataProduct)) {
            return redirect()->back()->withInput()->with('errors', $this->produkModel->errors());
        }

        return redirect()->to('/produk');
    }

    public function edit($id = null)
    {
        $product = $this->produkModel->find($id);
        $categories = $this->categoryModel->select('id, name')->findAll();
        d($product);

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

        $params = new DataParams([
            'search' => $this->request->getGet("search"),
            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_products"),
            'price_range' => $this->request->getGet('price_range'),
            'category_id' => $this->request->getGet("category_id"),
        ]);

        $results = $this->produkModel->asArray()->getFilteredProducts($params);

        foreach ($results['products'] as &$product) {
            $product['price'] = $this->produkEntity->getFormattedPrice($product['price']);
            $product['category'] = $product['category_name'];
            $product['image_path'] = base_url('assets/img/' . $product['image_path']);
            $product['badgeNew'] = $product['is_new'] ? view_cell('BadgeCell', ['text' => 'New']) : '';
            $product['badgeSale'] = $product['is_sale'] ? view_cell('BadgeCell', ['text' => 'Sale']) : '';
        }

        $dataParser = [
            'products' => $results['products'],
            'tableHeaderPrice' => [
                'name' => 'Price',
                'href' => $params->getSortUrl('price', base_url('produk')),
                'is_sorted' => $params->isSortedBy('price') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : ''
            ],
            'tableHeaderName' => [
                'name' => 'Name',
                'href' => $params->getSortUrl('name', base_url('produk')),
                'is_sorted' => $params->isSortedBy('name') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : ''
            ],
            'tableHeaderDate' => [
                'name' => 'Created at',
                'href' => $params->getSortUrl('created_at', base_url('produk')),
                'is_sorted' => $params->isSortedBy('created_at') ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : ''
            ]
        ];

        $data = [
            'title' => 'Product Catalog',
            'params' => $params,
            'pager' => $results['pager'],
            'total' => $results['total'],
            'countData' => count($results['products']),
            'categories' => $this->produkModel->getProductJoinCategories()->findAll(),
            'priceRange' => $this->produkModel->getAllPriceRange(),
            'baseURL' => base_url('product/list'),
        ];

        $data['content'] = $parser->setData($dataParser)->render('components/parser_product_list');

        return view('produk/product_list', $data);
    }
}
