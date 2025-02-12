<?php

namespace App\Entities;

class Produk
{
    private $id, $nama, $harga, $stok, $kategori;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? '';
        $this->nama = $data['nama'] ?? '';
        $this->harga = $data['harga'] ?? '';
        $this->stok = $data['stok'] ?? '';
        $this->kategori = $data['kategori'] ?? '';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNama()
    {
        return $this->nama;
    }

    public function setNama($nama)
    {
        $this->nama = $nama;
    }

    public function getHarga()
    {
        return $this->harga;
    }

    public function setHarga($harga)
    {
        $this->harga = $harga;
    }

    public function getStok()
    {
        return $this->stok;
    }

    public function setStok($stok)
    {
        $this->stok = $stok;
    }

    public function kurangiStok($jumlah)
    {
        if ($this->stok < 0) {
            $this->stok -= $jumlah;
        } else {
            $this->stok = 0;
        }
    }

    public function tambahStok($jumlah)
    {
        $this->stok += $jumlah;
    }

    public function getKategori()
    {
        return $this->kategori;
    }

    public function setKategori($kategori)
    {
        $this->kategori = $kategori;
    }
}
