<?php

namespace App\Controllers;

use App\Models\M_Produk;
use App\Entities\Produk as ProdukEntity;
use App\Libraries\DataParams;
use App\Models\M_Category;
use App\Models\M_ProductImage;
use App\Models\M_User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\Style\Alignment as Alignment;

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
        $images = $this->productImageModel->where('product_id', $id)->where('is_primary', 0)->findAll();

        $data = [
            'title' => 'Detail Product',
            'product' => $product,
            'images' => $images
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

        $this->uploadProductImage($product_id);

        $addedProduct = $this->produkModel->getProductJoinCategoriesImages()->where('products.id', $product_id)->first();

        $this->sendEmail($addedProduct);

        return redirect()->to('product-manager/products')->with('message', 'Product has been successfully added,  and a notification email has been sent.');
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

        $this->uploadProductImage($id);

        return redirect()->to('product-manager/products')->with('message', 'Product has been successfully updated.');
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
            $product['image_path'] = base_url('uploads/product-images/' . $product['id'] . '/original/' . $product['image_path']);
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

    private function uploadProductImage($product_id)
    {
        $validationRules = [
            'imagePath' => [
                'label' => 'Gambar',
                'rules' => [
                    'uploaded[image_path]',
                    'is_image[image_path]',
                    'mime_in[image_path,image/jpg,image/jpeg,image/png,image/webp]',
                    'max_size[image_path,5120]', // 5MB dalam KB (5 * 1024)
                    'max_dims[image_path,600,600]'
                ],
                'errors' => [
                    'uploaded' => 'Please select a file to upload.',
                    'is_image' => 'File must be image.',
                    'mime_in' => 'File must be in JPG, JPEG, PNG, atau WebP format.',
                    'max_size' => 'File size must not exceed 5MB.',
                    'max_dims' => 'Minimum size 600x600px/'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->with(
                'validation_errors',
                $this->validator->getErrors()
            );
        }

        $imagePath = $this->request->getFile('image_path');

        if (!$imagePath->isValid()) {
            return redirect()->back()->with(
                'error',
                $imagePath->getErrorString()
            );
        }

        $uploadPath = FCPATH . 'uploads/product-images/' . $product_id . '/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $nameFile = 'product' . '_' . $product_id . '_' . date('Y-m-d_H-i-s') . '.' . $imagePath->getExtension();
        $imagePath->move($uploadPath . 'original', $nameFile);
        $filePath = $uploadPath . 'original/' . $nameFile;

        $this->createImageVersions($filePath, $nameFile, $uploadPath);

        $productImage = $this->productImageModel->where('product_id', $product_id)->first();

        $data = [
            'product_id' => $product_id,
            'image_path' => $nameFile,
        ];

        // other image for store multiple images
        if (!empty($productImage->is_primary)) {
            $data['is_primary'] = 0;
        } elseif (!empty($productImage->id)) {
            // update image primary
            $data['id'] = $productImage->id;
            $data['is_primary'] = 1;
        } else {
            // create image primary
            $data['is_primary'] = 1;
        }

        if (!$this->productImageModel->save($data)) {
            return redirect()->to('product-manager/products/new')->withInput()->with('errors', $this->produkModel->errors());
        }
    }

    private function createImageVersions($filePath, $fileName, $uploadPath)
    {
        $image = service('image');

        // thumbnail (150x150px) for catalog display
        $thumbnail = $uploadPath . 'thumbnail/';
        if (!is_dir($thumbnail)) {
            mkdir($thumbnail, 0777, true);
        }

        $image->withFile($filePath)->fit(150, 150, 'center')->save($thumbnail . $fileName);

        // medium (500x500px) for product detail pages and add watermark
        $medium = $uploadPath . 'medium/';
        if (!is_dir($medium)) {
            mkdir($medium, 0777, true);
        }
        $image->withFile($filePath)->text('Copyright 2025 E-Commerce System', [
            'color' => '#fff',
            'opacity' => 0.8,
            'withShadow' => true,
            'hAlign' => 'center',
            'vAlign' => 'top',
            'fontSize' => 50,
        ])->resize(500, 500, true, 'height')->save($medium . $fileName);

        // compress 80% quality and add watermark
        $image->withFile($filePath)->text('Copyright 2025 E-Commerce System', [
            'color' => '#fff',
            'opacity' => 0.8,
            'withShadow' => true,
            'hAlign' => 'center',
            'vAlign' => 'top',
            'fontSize' => 50,
        ])->save($filePath, 80);
    }

    public function dashboard()
    {
        $productsByCategory = $this->getProductsByCategory();
        $top5CategoriesOfProducts = $this->getTop5CategoriesOfProducts();
        $productGrowth = $this->getProductGrowth();

        return view('produk/dashboard', [
            'title' => 'Dashboard Products',
            'productsByCategory' => json_encode($productsByCategory),
            'top5CategoriesOfProducts' => json_encode($top5CategoriesOfProducts),
            'productGrowth' => json_encode($productGrowth)
        ]);
    }

    // pie chart
    private function getProductsByCategory()
    {
        $productCategories = $this->produkModel->select('products.name as product_name, count(products.category_id) as category_count, categories.name as category_name, (COUNT(products.category_id) * 100 / (SELECT COUNT(*) FROM products)) AS product_percentage')
            ->join('categories', 'categories.id = products.category_id',)
            ->groupBy('categories.name')
            ->asArray()
            ->findAll();

        $bgColors = [];
        foreach ($productCategories as $row) {
            $bgColors[$row['category_name']] = "rgb(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ')";
        }

        foreach ($productCategories as $row) {
            $categoryLabels[] = $row['product_name'] . ' = ' . $row['category_name'] . ' Category';
            $productsPercentage[] = (int)round($row['product_percentage'], 2);
            $colors[] = $bgColors[$row['category_name']];
        }

        return [
            'labels' => $categoryLabels,
            'datasets' => [
                [
                    'label' => 'Percentage of product',
                    'data' => $productsPercentage,
                    'bgColor' => $colors,
                    'hoverOffset' => 4
                ]
            ]
        ];
    }

    // bar chart
    private function getTop5CategoriesOfProducts()
    {
        $productCategories = $this->produkModel->select('products.name as product_name, categories.name as category_name, count(products.category_id) as category_count')
            ->join('categories', 'categories.id = products.category_id',)
            ->groupBy('categories.name')
            ->orderBy('category_count', 'DESC')
            ->limit(5)
            ->asArray()
            ->findAll();

        foreach ($productCategories as $row) {
            $labels[] = 'Category: ' . $row['category_name'];
            $categoryCount[] = (int) $row['category_count'];
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Products',
                    'data' => $categoryCount,
                    'bgColor' => 'rgba(54,162,235,0.5)',
                    'borderColor' => 'rgb(54,162,235)',
                    'borderWidth' => 1,
                ]
            ]
        ];
    }

    // line chart
    private function getProductGrowth()
    {
        $products = $this->produkModel->select("DATE_FORMAT(created_at, '%m/%y') as month_year, COUNT(*) as total_products")
            ->where('created_at >=', date('Y-m-d', strtotime('-12 months')))
            ->groupBy('month_year')
            ->orderBy('month_year', 'ASC')
            ->asArray()
            ->findAll();

        foreach ($products as $row) {
            $month_years[] = $row['month_year'];
            $total_products[] = (int) $row['total_products'];
        }

        return [
            'labels' => $month_years,
            'datasets' => [
                [
                    'label' => 'Month',
                    'data' => $total_products,
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'tension' => 0.1,
                    'fill' => false
                ]
            ]
        ];
    }

    public function productReportForm()
    {
        $category_id = $this->request->getGet('category_id');

        $categories = $this->categoryModel->findAll();

        $filteredData = $this->filterDataReport($category_id);

        $data = [
            'title' => 'Products Report',
            'categories' => $categories,
            'products' => $filteredData['products'],
            'filter' => $filteredData['category'],
        ];

        // dd($filteredData, $data);

        return view('produk/report_form', $data);
    }

    private function filterDataReport($category_id = '')
    {
        $products = $this->produkModel->getProductsByCategoryReport($category_id);

        $category = [];
        if (!empty($category_id)) {
            foreach ($products as $data) {
                if ($category_id === $data->category_id) {
                    $category['category_id'] = $data->category_id ?? [];
                    $category['category_name'] = $data->category_name ?? [];
                    break;
                }
            }
        }
        // dd($category);

        return [
            'products' => $products,
            'category' => $category,
        ];
    }

    public function productReportExcel()
    {
        $category_id = $this->request->getGet('category_id');

        $results = $this->filterDataReport($category_id);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Products Report');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Filter:');
        $sheet->setCellValue('B3', 'Category: ' . ($results['category']['category_name'] ?? 'All'));
        $sheet->getStyle('A3:B3')->getFont()->setBold(true);

        $headers = [
            'A5' => 'No.',
            'B5' => 'Product Name',
            'C5' => 'Category',
            'D5' => 'Price',
            'E5' => 'Stock',
            'F5' => 'Date Added'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        $row = 6;
        $no = 1;
        foreach ($results['products'] as $product) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $product->name);
            $sheet->setCellValue('C' . $row, $product->category_name);
            $sheet->setCellValue('D' . $row, $product->price);
            $sheet->getStyle('C' . $row)->getNumberFormat()->setFormatCode('"Rp" #,##0.00');
            $sheet->setCellValue('E' . $row, $product->stock);
            $sheet->setCellValue('F' . $row, $product->created_at);

            $row++;
            $no++;
        }

        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Buat border untuk seluruh tabel
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->getStyle('A5:F' . ($row - 1))->applyFromArray($styleArray);

        $filename = 'Products_Report_' . date('Y-m-d-His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
}
