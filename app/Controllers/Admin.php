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

    public function dashboard()
    {
        $parser = service('parser');

        $users = count($this->userModel->getUser());
        $products = count($this->productModel->getAllProducts());
        $orders = count($this->orderModel->getAllOrders());

        $data = [
            'title' => 'Dashboard',
            'users' => $users,
            'products' => $products,
            'orders' => $orders
        ];
        $data['content'] = $parser->setData($data)->render('components/parser_admin_stats');

        return view('admin/dashboard', $data);
    }
}
