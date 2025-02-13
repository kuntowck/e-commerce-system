<?php

namespace App\Entities;

class Pesanan
{
    private $id, $produk, $total, $status, $kuantitas;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? '';
        $this->produk = $data['produk'] ?? '';
        $this->status = $data['status'] ?? '';
        $this->kuantitas = $data['kuantitas'] ?? '';
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

    public function getKuantitas()
    {
        return $this->kuantitas;
    }

    public function setKuantitas($kuantitas)
    {
        $this->kuantitas = $kuantitas;
    }
}
