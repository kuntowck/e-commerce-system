<?php

namespace App\Entities;

class Pesanan
{
    private $id, $produk = [], $total = 0, $status;

    public function __construct($id, $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProduk()
    {
        return $this->produk;
    }

    public function setProduk($produk)
    {
        $this->produk = $produk;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
}
