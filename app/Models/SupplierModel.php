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

    public function getTotalReportByMold()
    {
        return $this->select('suplier.mold_name, COALESCE(COUNT(report_daily.id), 0) as total_reports')
        ->join('report_daily', 'report_daily.nama_mold = suplier.mold_name AND report_daily.problem_harian != \'\'', 'left')
        ->groupBy('suplier.mold_name')
        ->findAll();
    }
    public function getTotalPerbaikanByMold()
    {
        return $this->select('suplier.mold_name, COALESCE(COUNT(perbaikan_besar.id_perbaikan), 0) as total_perbaikan')
        ->join('perbaikan_besar', 'perbaikan_besar.nama_mold = suplier.mold_name ', 'left')
        ->groupBy('suplier.mold_name')
        ->findAll();
    }

    public function getSupplierDataWithMoldItems($suplier)
    {
        // Load the TransaksiJumlahProduk model
        $transaksiModel = new TransaksiJumlahProduk();

        // Query to fetch supplier data with matching mold_item data
        $query = $this->db->query("
            SELECT s.*, mi.*
            FROM suplier s
            JOIN mold_item mi ON s.mold_name = mi.ITEM
            WHERE s.suplier = ?
        ", [$suplier]);

        $results = $query->getResultArray();

        // Loop through the results to add total 'jumlah_produk' for each 'mold_name'
        foreach ($results as &$result) {
            $result['total_jumlah_produk'] = $transaksiModel->getTotalJumlahProdukByMold($result['mold_name']);
        }

        return $results;
    }

    public function getLatestYear()
    {
        return $this->selectMax('tahun')->first();
    }

    public function updateJumlahProduk($id, $jumlah)
    {
        return $this->where('id_mold', $id)
            ->set('jumlah_produk', $jumlah)
            ->update();
    }
    public function getjumlahByMoldName($moldName)
    {
        return $this->where('mold_name', $moldName)
            ->first();
    }
}
