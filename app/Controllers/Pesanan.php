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
        $products = json_decode($this->request->getPost('selectedProducts'));
        $status = $this->request->getPost('status');
        $kuantitas = $this->request->getPost('kuantitas');

        $orders = new PesananEntity($id, $products, $status, $kuantitas);


        echo "<pre>";
        var_dump($orders);
        echo "</pre>";
        // die();
        // $this->pesananModel->calculateTotal($orders);
        $this->pesananModel->addOrder($orders);

        return redirect()->to('/pesanan');
    }

    public function updateStatus()
    {
        $id = $this->request->getPost('id');
        $produk = $this->request->getPost('produk');
        $status = $this->request->getPost('status');
        $kuantitas = $this->request->getPost('kuantitas');

        $updatedOrder = new PesananEntity($id, $produk, $status, $kuantitas);

        echo "<pre>";
        var_dump($updatedOrder);
        echo "</pre>";
        die();

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
        echo "<pre>";
        var_dump($id);
        echo "</pre>";
        // die();

        $this->pesananModel->deleteOrder($id);

        return redirect()->to('/pesanan');
    }
}
