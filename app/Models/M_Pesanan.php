<?php

namespace App\Models;

use App\Entities\Pesanan;

class M_Pesanan
{
    private $orders = [];

    public function __construct()
    {
        $this->orders = [
            new Pesanan(1, 'Pending'),
            new Pesanan(2, 'Completed'),
        ];
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

    public function addOrder(Pesanan $order)
    {
        $this->orders[] = $order;
        return true;
    }

    public function updateStatus(Pesanan $order, $status)
    {
        foreach ($this->orders as $key => $existingOrder) {
            if ($existingOrder->getId() === $order->getId()) {
                $existingOrder->setStatus($status);
                return true;
            }
        }
        return false;
    }

    public function addItem(Pesanan $pesanan, $item)
    {
        $produk = $pesanan->getProduk();
        $produk[] = $item;
        $pesanan->setProduk($produk);
        $this->calculateTotal($pesanan);
    }

    public function removeProduct(Pesanan $pesanan, $produkId)
    {
        $produk = $pesanan->getProduk();
        foreach ($produk as $key => $item) {
            if ($item['id'] == $produkId) {
                unset($produk[$key]);
                break;
            }
        }
        $pesanan->setProduk($produk);
        $this->calculateTotal($pesanan);
    }

    public function calculateTotal(Pesanan $pesanan)
    {
        $total = 0;
        foreach ($pesanan->getProduk() as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $pesanan->setTotal($total);
    }
}
