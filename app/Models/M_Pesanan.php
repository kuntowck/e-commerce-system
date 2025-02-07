<?php

namespace App\Models;

use App\Entities\Pesanan;

class M_Pesanan
{
    private $orders = [];
    private $session;

    public function __construct()
    {
        $this->session = session();
        $this->orders = $this->session->get('pesanan') ?? [];
    }

    private function saveData()
    {
        $this->session->set('pesanan', $this->orders);
    }


    public function getAllOrders()
    {
        return $this->orders;
    }

    public function getOrderById($id)
    {
        foreach ($this->orders as $order) {
            if ($order->getId() === $id) {
                return $order;
            }
        }
        return null;
    }

    public function addOrder(Pesanan $pesanan)
    {
        $this->orders[] = $pesanan;
        $this->saveData();

        return true;
    }

    public function updateStatus(Pesanan $pesanan)
    {
        foreach ($this->orders as $key => $order) {
            if ($order->getId() === $pesanan->getId()) {
                $this->orders[$key] = $pesanan;
                $this->saveData();

                return true;
            }
        }
        return false;
    }

    public function deleteOrder($id)
    {
        foreach ($this->orders as $key => $order) {
            if ($order->getId() == $id) {
                unset($this->orders[$key]);

                return true;
            }
        }

        return false;
    }

    // public function calculateTotal(Pesanan $pesanan)
    // {
    //     $total = 0;
    //     foreach ($pesanan->getProduk() as $item) {
    //         $total += $item['price'] * $item['quantity'];
    //     }
    //     $pesanan->setTotal($total);
    // }
}
