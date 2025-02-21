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
        $dataUser = $this->userModel->getUser();

        return view('user/index', ['users' => $dataUser]);
    }

    public function role()
    {
        $this->userModel->setAdminRole();

        return redirect()->to('/admin/dashboard')->with('message', 'Role set to admin');
    }

    public function dashboard()
    {
        $parser = service('parser');

        $users = count($this->userModel->getUser());
        $products = count($this->productModel->getAllProducts());
        $orders = count($this->orderModel->getAllOrders());
        $salesTrends = [
            'Product A: +20% increase in sales',
            'Product B: -10% decrease in sales',
            'Product C: +5% increase in sales',
        ];

        $inventoryLevels = [
            'Product A: 50 units in stock',
            'Product B: 20 units in stock',
            'Product C: 100 units in stock',
        ];

        $data = [
            'title' => 'Dashboard',
            'users' => $users,
            'products' => $products,
            'orders' => $orders,
            'productStats' => view_cell('ProductStatisticsCell', ['salesTrends' => $salesTrends, 'inventoryLevels' => $inventoryLevels], 3600, 'product_stats_cell')
        ];
        $data['content'] = $parser->setData($data)->render('components/parser_admin_stats');

        return view('admin/dashboard', $data);
    }
}
