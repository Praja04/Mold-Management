<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table            = 'suplier';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'tahun',
        'suplier',
        'id_mold',
        'mold_name',
        'jumlah_produk'
    ];

    public function getLatestYear()
    {
        return $this->selectMax('tahun')->first();
    }

    public function updateJumlahProduk($id, $jumlah)
    {
        return $this->where('id', $id)
            ->set('jumlah_produk', $jumlah)
            ->update();
    }
}
