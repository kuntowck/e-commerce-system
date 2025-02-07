<?php

namespace App\Controllers;

use App\Models\M_Pesanan;
use App\Entities\Pesanan as PesananEntity;
use CodeIgniter\Controller;

class Pesanan extends Controller
{
    protected $pesananModel;

    public function __construct()
    {
        $this->pesananModel = new M_Pesanan();
    }

    public function index()
    {
        $data['pesanan'] = $this->pesananModel->getAllOrders();
        return view('pesanan/index', $data);
    }

    public function detail($id)
    {
        $order = $this->pesananModel->getOrderById($id);
        if ($order) {
            return view('pesanan/detail', ['order' => $order]);
        } else {
            return redirect()->to('/pesanan');
        }
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            $status = $this->request->getPost('status');
            $pesanan = new PesananEntity(null, $status);
            $this->pesananModel->addOrder($pesanan);

            return redirect()->to('/pesanan');
        }

        return view('pesanan/create');
    }

    public function updateStatus($id)
    {
        if ($this->request->getMethod() === 'post') {
            $status = $this->request->getPost('status');
            $order = $this->pesananModel->getOrderById($id);
            if ($order) {
                $this->pesananModel->updateStatus($order, $status);
                return redirect()->to('/pesanan');
            } else {
                return redirect()->to('/pesanan');
            }
        }

        $order = $this->pesananModel->getOrderById($id);
        if ($order) {
            return view('pesanan/update_status', ['order' => $order]);
        } else {
            return redirect()->to('/pesanan');
        }
    }
}