<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiJumlahProduk extends Model
{
    protected $table            = 'transaksi_produk';
    protected $primaryKey       = 'id';
  
    protected $allowedFields    = ['nama_mold','jumlah_produk','user_id','is_seen'];


    public function countDataPerUser()
    {
        $builder = $this->db->table('users u')
        ->select('u.id AS user_id, 
              COUNT(CASE WHEN pd.is_seen = \'no\' THEN 1 END) AS total_data_no, 
              COUNT(CASE WHEN pd.is_seen = \'yes\' THEN 1 END) AS total_data_yes')
        ->join('transaksi_produk pd', 'u.id = pd.user_id', 'left')
        ->groupBy('u.id')
        ->orderBy('total_data_no', 'DESC');


        return $builder->get()->getResultArray();
    }

    public function countisSeen()
    {

        $builder = $this->db->table($this->table)
            ->select('SUM(CASE WHEN is_seen = \'no\' THEN 1 ELSE 0 END) AS is_seen_0')
            ->select('SUM(CASE WHEN is_seen = \'yes\' THEN 1 ELSE 0 END) AS is_seen_1');

        return $builder->get()->getRowArray();
    }

    public function countHasilVerifikasiByItem($item)
    {
        $query = $this->select('transaksi_produk.is_seen')
        ->join('mold_item', 'transaksi_produk.nama_mold = mold_item.ITEM', 'left')
        ->where('mold_item.ITEM', $item)
            ->where('transaksi_produk.is_seen', 'no')
            ->countAllResults();

        $countYes = $this->select('transaksi_produk.is_seen')
        ->join('mold_item', 'transaksi_produk.nama_mold = mold_item.ITEM', 'left')
        ->where('mold_item.ITEM', $item)
            ->where('transaksi_produk.is_seen', 'yes')
            ->countAllResults();

        return [
            'count_no' => $query,
            'count_yes' => $countYes
        ];
    }
    public function updateAllIsSeen($ids)
    {
        // Validate that $ids is an array and not empty
        if (!is_array($ids) || empty($ids)) {
            return false;
        }

        // Ensure IDs are integers
        $ids = array_map('intval', $ids);

        // Perform the update operation
        return $this->set('is_seen', 'yes')
        ->whereIn('id', $ids)
            ->update();
    }

    public function getItemsreportDaily($supplier)
    {
        $suplierModel = new SupplierModel();
        $latestYear = $suplierModel->getLatestYear();

        // Ambil data mold_name dari suplier berdasarkan supplier dan tahun terbaru
        $query = $this->db->table('suplier')
        ->select('mold_name, jumlah_produk,id_mold')
        ->where('suplier', $supplier)
            ->where('tahun', $latestYear['tahun'])
            ->get();

        // Ambil hasil query sebagai array
        $moldNames = $query->getResultArray();

        $transaksi = new TransaksiJumlahProduk();
        $results = [];

        // Loop melalui setiap mold_name
        foreach ($moldNames as $moldName) {
            $verificationCount = $transaksi->countHasilVerifikasiByItem($moldName['mold_name']);
            $results[] = [
                'ITEM' => $moldName['mold_name'],
                'Hasil_Verifikasi_Count_No' => $verificationCount['count_no'],
                'Hasil_Verifikasi_Count_Yes' => $verificationCount['count_yes'],
                'Total_Produk' => $moldName['jumlah_produk'],
                'id' => $moldName['id_mold']

            ];
        }

        // Mengurutkan hasil berdasarkan Hasil_Verifikasi_Count secara descending
        usort($results, function ($a, $b) {
            return $b['Hasil_Verifikasi_Count_No'] - $a['Hasil_Verifikasi_Count_No'];
        });

        return $results;
    }
    public function getTransaksiByMoldName($moldName)
    {
        return $this->where('nama_mold', $moldName)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
}
