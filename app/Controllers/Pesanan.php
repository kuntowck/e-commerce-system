<?php

namespace App\Controllers;

use App\Models\M_Pesanan;
use App\Models\M_Produk;
use App\Entities\Pesanan as PesananEntity;

class Pesanan extends BaseController
{
    protected $pesananModel;
    protected $produkModel;

    public function __construct()
    {
        $this->pesananModel = new M_Pesanan();
        $this->produkModel = new M_Produk();
    }

    public function index()
    {
        $orders = $this->pesananModel->getAllOrders();
        return view('pesanan/index', ['orders' => $orders]);
    }

    public function detail($id)
    {
        $order = $this->pesananModel->getOrderById($id);

        return view('pesanan/detail', ['order' => $order]);
    }
    
    public function create()
    {
        $produk = $this->produkModel->getAllProducts();
        return view('pesanan/create', ['produk' => $produk]);
    }

    public function store()
    {
        $id = $this->request->getPost('id');
        $produk = $this->request->getPost('produk');
        $total = $this->request->getPost('total');
        $status = $this->request->getPost('status');

        $orders = new PesananEntity($id, $produk, $total, $status);
        $this->pesananModel->addOrder($orders);

        return redirect()->to('/pesanan');
    }

    public function updateStatus()
    {
        $id = $this->request->getPost('id');
        $produk = $this->request->getPost('produk');
        $total = $this->request->getPost('total');
        $status = $this->request->getPost('status');

        $updatedOrder = new PesananEntity($id, $produk, $total, $status);
        $this->pesananModel->updateStatus($updatedOrder);

        return redirect()->to('/pesanan');
    }

    public function editStatus($id)
    {
        $order = $this->pesananModel->getOrderById($id);
        return view('pesanan/update', ["order" => $order]);
    }

    public function delete($id)
    {
        $this->pesananModel->deleteOrder($id);
        return redirect()->to('/pesanan');
    }
}
