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
        $dataUser = $this->userModel->findAll();

        $output = view('user/index', ['users' => $dataUser]);
        cache()->save('admin_user_list', $output, 900);
        return $output;
    }

    public function role()
    {
        $this->userModel->setAdminRole();

        return redirect()->to('/admin/dashboard')->with('message', 'Role set to admin');
    }

    public function dashboard()
    {
        $parser = service('parser');

        // $users = $this->userModel->getUserStatistics();
        // d($users);
        $orders = count($this->orderModel->getAllOrders());
        $products = $this->productModel->getProductStatistics();

        $data = [
            'title' => 'Dashboard',
            // 'users' => [$users],
            'products' => [$products],
            'orders' => $orders,
            // 'productStats' => view_cell('ProductStatisticsCell', ['growthPercentage'=> $users['growth_percentage']], 3600, 'product_stats_cell')
        ];
        $data['content'] = $parser->setData($data)->render('components/parser_admin_stats');

        return view('admin/dashboard', $data);
    }
}
