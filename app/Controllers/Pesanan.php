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
        $dataOrder = $this->request->getPost();
        $selectedProducts = json_decode($dataOrder['selectedProducts']);
        $dataOrder['produk'] = $selectedProducts;

        $orders = new PesananEntity($dataOrder);
        $this->pesananModel->addOrder($orders);

        return redirect()->to('/pesanan');
    }

    public function updateStatus()
    {
        $dataOrder = $this->request->getPost();
        // $selectedProducts = json_decode($dataOrder['selectedProducts']);
        // $dataOrder['produk'] = $selectedProducts;

        $updatedOrder = new PesananEntity($dataOrder);
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
