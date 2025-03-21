<?php

namespace App\Controllers;

use App\Models\M_Produk;
use App\Entities\Produk as ProdukEntity;
use App\Libraries\DataParams;
use App\Models\M_Category;
use App\Models\M_ProductImage;
use App\Models\M_User;

class Produk extends BaseController
{
    protected $produkModel, $produkEntity, $categoryModel, $productImageModel;

    public function __construct()
    {
        $this->produkModel = new M_Produk();
        $this->produkEntity = new ProdukEntity();
        $this->categoryModel = new M_Category();
        $this->productImageModel = new M_ProductImage();
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
            'title' => 'Product Management',
            'products' => $result['products'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'categories' => $this->categoryModel->findAll(),
            'priceRange' => $this->produkModel->getAllPriceRange(),
            'baseURL' => base_url('product-manager/products'),
        ];

        return view('produk/index', $data);
    }

    public function show($id = null)
    {
        $product = $this->produkModel->getProductJoinCategoriesImages()->find($id);

        $data = [
            'title' => 'Detail Product',
            'product' => $product
        ];

        return view('produk/detail', $data);
    }

    public function new()
    {
        $categories = $this->categoryModel->select('id, name')->findAll();

        $data = [
            'title' => 'Add Product',
            'categories' => $categories
        ];

        return view('produk/create', $data);
    }

    public function create()
    {
        $dataProduct = $this->request->getPost();
        $dataProduct['price'] = $this->produkEntity->getPriceToInt($dataProduct['price']);

        if (!$this->produkModel->save($dataProduct)) {
            return redirect()->back()->withInput()->with('errors', $this->produkModel->errors());
        }

        $product_id = $this->produkModel->getInsertID();

        // $this->uploadProductImage($product_id);

        $addedProduct = $this->produkModel->getProductJoinCategoriesImages()->where('products.id', $product_id)->first();

        $this->sendEmail($addedProduct);

        return redirect()->to('product-manager/products')->with('message', 'Product has been successfully added,  and a notification email has been sent.');;
    }

    public function edit($id = null)
    {
        $product = $this->produkModel->find($id);
        $categories = $this->categoryModel->select('id, name')->findAll();
        $productImage = $this->productImageModel->where('product_id', $product->id)->first();

        $data = [
            'title' => 'Edit Product',
            'product' => $product,
            'categories' => $categories,
            'productImage' => $productImage
        ];

        return view('produk/update', $data);
    }

    public function update($id = null)
    {
        $dataProduct = $this->request->getPost();
        $dataProduct['price'] = $this->produkEntity->getPriceToInt($dataProduct['price']);

        if (!$this->produkModel->update($id, $dataProduct)) {
            return redirect()->back()->withInput()->with('errors', $this->produkModel->errors());
        }

        // $this->uploadProductImage($id);

        return redirect()->to('product-manager/products');
    }

    public function delete($id = null)
    {
        $this->produkModel->delete($id);

        return redirect()->to('product-manager/products');
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
            // $product['image_path'] = base_url('uploads/product-images/' . $product['id'] . '/original/' . $product['image_path']);
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
            'baseURL' => base_url('customer/catalog'),
        ];

        $data['content'] = $parser->setData($dataParser)->render('components/parser_product_list');

        return view('produk/product_list', $data);
    }

    private function sendEmail($product)
    {
        $userModel = new M_User();
        $user = $userModel->where('id', user_id())->first();
        $roles = $userModel->getUserJoinGroup()
            ->where('auth_groups.name', 'admin')
            ->orWhere('auth_groups.name', 'product-manager')
            ->findAll();

        $ccList = array_column($roles, 'email');

        $data = [
            'title' => 'New Prodcut has been Added',
            'product' => $product,
            'link' => base_url('product-manager/products/' . $product->id . '/show')
        ];

        $email = service('email');

        $email->setFrom('kuntowck@gmail.com', 'E-Commerce System');
        $email->setTo($user->email);
        $email->setCC($ccList);
        $email->setSubject('There is a New Product');
        $email->setMessage(view('email/newproduct_email', $data));

        $filePath = ROOTPATH . 'public/uploads/product-images/' . $product->id . '/thumbnail/' . $product->image_path;
        if (file_exists($filePath)) {
            $email->attach($filePath);
        }

        if (!$email->send()) {
            return redirect()->back()->with('error', $email->printDebugger());
        }
    }

    // private function uploadProductImage($product_id)
    // {
    //     $productImage = $this->productImageModel->where('product_id', $product_id)->first();

    //     $validationRules = [
    //         'imagePath' => [
    //             'label' => 'Gambar',
    //             'rules' => [
    //                 'uploaded[image_path]',
    //                 'is_image[image_path]',
    //                 'mime_in[image_path,image/jpg,image/jpeg,image/png,image/webp]',
    //                 'max_size[image_path,5120]', // 5MB dalam KB (5 * 1024)
    //                 'max_dims[image_path,600,600]'
    //             ],
    //             'errors' => [
    //                 'uploaded' => 'Please select a file to upload.',
    //                 'is_image' => 'File must be image.',
    //                 'mime_in' => 'File must be in JPG, JPEG, PNG, atau WebP format.',
    //                 'max_size' => 'File size must not exceed 5MB.',
    //                 'max_dims' => 'Minimum size 600x600px/'
    //             ]
    //         ]
    //     ];

    //     if (!$this->validate($validationRules)) {
    //         return redirect()->back()->with(
    //             'validation_errors',
    //             $this->validator->getErrors()
    //         );
    //     }

    //     $imagePath = $this->request->getFile('image_path');

    //     if (!$imagePath->isValid()) {
    //         return redirect()->back()->with(
    //             'error',
    //             $imagePath->getErrorString()
    //         );
    //     }

    //     $uploadPath = FCPATH . 'uploads/product-images/' . $product_id . '/';

    //     if (!is_dir($uploadPath)) {
    //         mkdir($uploadPath, 0777, true);
    //     }

    //     $nameFile = 'product' . '_' . $product_id . '_' . date('Y-m-d_H-i-s') . '.' . $imagePath->getExtension();
    //     $imagePath->move($uploadPath . 'original', $nameFile);
    //     $filePath = $uploadPath . 'original/' . $nameFile;

    //     $this->createImageVersions($filePath, $nameFile, $uploadPath);

    //     if (!empty($productImage->is_primary)) {
    //         $data = [
    //             // 'id' => $productImage->id,
    //             'product_id' => $product_id,
    //             'image_path' => $nameFile,
    //             'is_primary' => 0
    //         ];
    //     } else {
    //         $data = [
    //             'product_id' => $product_id,
    //             'image_path' => $nameFile,
    //             'is_primary' => 1
    //         ];
    //     }


    //     if (!$this->productImageModel->save($data)) {
    //         return redirect()->to('product-manager/products/new')->withInput()->with('errors', $this->produkModel->errors());
    //     }
    // }

    // private function createImageVersions($filePath, $fileName, $uploadPath)
    // {
    //     $image = service('image');

    //     // thumbnail (150x150px) for catalog display
    //     $thumbnail = $uploadPath . 'thumbnail/';
    //     if (!is_dir($thumbnail)) {
    //         mkdir($thumbnail, 0777, true);
    //     }

    //     $image->withFile($filePath)->fit(150, 150, 'center')->save($thumbnail . $fileName);

    //     // medium (500x500px) for product detail pages and add watermark
    //     $medium = $uploadPath . 'medium/';
    //     if (!is_dir($medium)) {
    //         mkdir($medium, 0777, true);
    //     }
    //     $image->withFile($filePath)->text('Copyright 2025 E-Commerce System', [
    //         'color' => '#fff',
    //         'opacity' => 0.8,
    //         'withShadow' => true,
    //         'hAlign' => 'center',
    //         'vAlign' => 'top',
    //         'fontSize' => 50,
    //     ])->resize(500, 500, true, 'height')->save($medium . $fileName);

    //     // compress 80% quality and add watermark
    //     $image->withFile($filePath)->text('Copyright 2025 E-Commerce System', [
    //         'color' => '#fff',
    //         'opacity' => 0.8,
    //         'withShadow' => true,
    //         'hAlign' => 'center',
    //         'vAlign' => 'top',
    //         'fontSize' => 50,
    //     ])->save($filePath, 80);
    // }
}
