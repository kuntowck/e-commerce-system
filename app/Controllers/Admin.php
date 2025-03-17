<?php

namespace App\Controllers;

use App\Models\M_Pesanan;
use App\Models\M_Produk;
use App\Models\M_User;

class Admin extends BaseController
{
    private $userModel, $productModel, $orderModel;

    public function __construct()
    {
        $this->userModel = new M_User;
        $this->productModel = new M_Produk;
        $this->orderModel = new M_Pesanan;
    }

    public function index()
    {
        $parser = service('parser');

        $users = $this->userModel->getUserStatistics();
        $orders = count($this->orderModel->getAllOrders());
        $products = $this->productModel->getProductStatistics();

        $data = [
            'title' => 'Dashboard',
            'users' => [$users],
            'products' => [$products],
            'orders' => $orders,
            'productStats' => view_cell('ProductStatisticsCell', ['growthPercentage' => $users['growth_percentage']], 3600, 'product_stats_cell')

        ];
        $data['content'] = $parser->setData($data)->render('components/parser_admin_stats');

        return view('admin/dashboard', $data);
    }
}
