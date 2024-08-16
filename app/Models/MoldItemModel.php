<?php

namespace App\Models;

use App\Models\ReportModel;
use App\Models\SupplierModel;
use CodeIgniter\Model;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class MoldItemModel extends Model
{
    protected $table            = 'mold_item';
    protected $primaryKey       = 'NO';
    protected $allowedFields = [
        'NO',
        'ITEM',
        'MADE_IN',
        'STATUS',
        'Material',
        'TONNAGE',
        'PART',
        'RUNNER',
        'CYCLE_TIME',
        'DIMENSI_MOLD',
        'CAVITY',
        'CORE',
        'KETERANGAN'
    ];

    public function getAllByPartname($nama_mold)
    {
        return $this->where('ITEM', $nama_mold)
            ->find();
    }

    public function updateKeteranganByMoldID($moldId, $keterangan)
    {
        // Validasi data input
        if (empty($moldId) || !is_numeric($moldId)) {
            throw new \InvalidArgumentException('ID tidak valid.');
        }

        if (empty($keterangan)) {
            throw new \InvalidArgumentException('Keterangan tidak boleh kosong.');
        }

        // Data yang akan diupdate
        $data = [
            'KETERANGAN' => $keterangan
        ];

        // Lakukan update
        try {
            $this->update($moldId, $data);
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Gagal memperbarui KETERANGAN untuk NO: ' . $moldId . '. Error: ' . $e->getMessage());
            return false;
        }
    }

    public function getAllItems()
    {
        return $this->select('mold_item.*, suplier.suplier')
        ->join('suplier', 'mold_item.ITEM = suplier.mold_name', 'left')
        ->findAll();
    }

    public function TotalAllItems()
    {
        return $this->db->table('mold_item')->countAllResults();
    }

    public function getItemBySupplier($supplier2)
    {
        $suplierModel = new SupplierModel();
        $latestYear = $suplierModel->getLatestYear();

        if ($latestYear) {
            // Query kedua: Mencocokkan semua mold_name di tabel mold_item dan menampilkan suplier
            $query = $this->db->query("
            SELECT mi.ITEM, mi.NO, mi.MADE_IN, mi.STATUS, mi.MATERIAL, mi.DIMENSI_MOLD, s.suplier
            FROM mold_item mi
            JOIN suplier s ON mi.ITEM = s.mold_name
            WHERE s.suplier = ?
              AND s.tahun = (
                SELECT MAX(tahun) 
                FROM suplier 
                WHERE suplier = ?
              )
        ", [$supplier2, $supplier2]);

            $result = $query->getResultArray();
            $totalData = count($result);

            return [
                'data' => $result,
                'total' => $totalData
            ];
        }

        return [
            'data' => [],
            'total' => 0
        ];
    }


    public function getItemBySupplierforAdmin($supplier2)
    {
        $suplierModel = new SupplierModel();
        $latestYear = $suplierModel->getLatestYear();

        if ($latestYear) {
            // Query pertama: Mendapatkan semua mold_name yang bersuplier $supplier2 pada tahun terbaru
            $moldNames = $this->db->table('suplier')
                ->select('mold_name')
                ->where('suplier', $supplier2)
                ->where('tahun', $latestYear['tahun'])
                ->get()
                ->getResultArray();

            if (!empty($moldNames)) {
                // Extract all mold_name into an array
                $moldNameArray = array_column($moldNames, 'mold_name');

                // Query kedua: Mencocokkan semua mold_name di tabel mold_item
                $query = $this->select('ITEM, NO, MADE_IN, STATUS, MATERIAL, DIMENSI_MOLD')
                    ->whereIn('ITEM', $moldNameArray)
                    ->findAll();

                $totalData = count($query);

                return [
                    'data' => $query,
                    'total' => $totalData
                ];
            }
        }
    }


    public function getItemsWithVerificationCount($supplier)
    {
        $suplierModel = new SupplierModel();
        $latestYear = $suplierModel->getLatestYear();

        // Ambil data mold_name dari suplier berdasarkan supplier dan tahun terbaru
        $query = $this->db->table('suplier')
            ->select('mold_name')
            ->where('suplier', $supplier)
            ->where('tahun', $latestYear['tahun'])
            ->get();

        // Ambil hasil query sebagai array
        $moldNames = $query->getResultArray();

        $detailMoldModel = new DetailMold();
        $results = [];

        // Loop melalui setiap mold_name
        foreach ($moldNames as $moldName) {
            $verificationCount = $detailMoldModel->countHasilVerifikasiByItem($moldName['mold_name']);
            $results[] = [
                'ITEM' => $moldName['mold_name'], // Ubah 'ITEM' menjadi 'mold_name'
                'Hasil_Verifikasi_Count' => $verificationCount
            ];
        }

        return $results;
    }

    public function getItemsreportDaily($supplier)
    {
        $suplierModel = new SupplierModel();
        $latestYear = $suplierModel->getLatestYear();

        // Ambil data mold_name dari suplier berdasarkan supplier dan tahun terbaru
        $query = $this->db->table('suplier')
        ->select('mold_name, jumlah_produk')
        ->where('suplier', $supplier)
            ->where('tahun', $latestYear['tahun'])
            ->get();

        // Ambil hasil query sebagai array
        $moldNames = $query->getResultArray();

        $reportdaily = new ReportModel();
        $results = [];

        // Loop melalui setiap mold_name
        foreach ($moldNames as $moldName) {
            $verificationCount = $reportdaily->countHasilVerifikasiByItem($moldName['mold_name']);
            $results[] = [
                'ITEM' => $moldName['mold_name'],
                'Hasil_Verifikasi_Count_No' => $verificationCount['count_no'],
                'Hasil_Verifikasi_Count_Yes' => $verificationCount['count_yes'],
                'Total_Produk' => $moldName['jumlah_produk']

            ];
        }

        // Mengurutkan hasil berdasarkan Hasil_Verifikasi_Count secara descending
        usort($results, function ($a, $b) {
            return $b['Hasil_Verifikasi_Count_No'] - $a['Hasil_Verifikasi_Count_No'];
        });

        return $results;
    }

    public function getItemsperbaikanBesar($supplier)
    {
        $suplierModel = new SupplierModel();
        $latestYear = $suplierModel->getLatestYear();

        // Ambil data mold_name dari suplier berdasarkan supplier dan tahun terbaru
        $query = $this->db->table('suplier')
        ->select('mold_name')
        ->where('suplier', $supplier)
            ->where('tahun', $latestYear['tahun'])
            ->get();

        // Ambil hasil query sebagai array
        $moldNames = $query->getResultArray();

        $reportdaily = new PerbaikanBesarModel();
        $results = [];

        // Loop melalui setiap mold_name
        foreach ($moldNames as $moldName) {
            $verificationCount = $reportdaily->countHasilVerifikasiByItem($moldName['mold_name']);
            $results[] = [
                'ITEM' => $moldName['mold_name'],
                'Hasil_Verifikasi_Count_No' => $verificationCount['count_no'],
                'Hasil_Verifikasi_Count_Yes' => $verificationCount['count_yes']
            ];
        }

        // Mengurutkan hasil berdasarkan Hasil_Verifikasi_Count secara descending
        usort($results, function ($a, $b) {
            return $b['Hasil_Verifikasi_Count_No'] - $a['Hasil_Verifikasi_Count_No'];
        });

        return $results;
    }

    public function getDataByItem($itemName)
    {
        // Dapatkan semua data dari tabel mold_item berdasarkan ITEM
        $moldData = $this->where('ITEM', $itemName)->findAll();

        // Dapatkan nama suplier dari tabel suplier berdasarkan mold_name yang sesuai dengan ITEM
        $suplierModel = new \App\Models\SupplierModel();
        $userModel = new UserModel();
        $suplierData = $suplierModel->select('suplier')->where('mold_name', $itemName)->findAll();
        $userData = [];

        // Fetch user IDs based on suplier values
        foreach ($suplierData as $suplier) {
            $users = $userModel->select('id')
            ->where('suplier', $suplier['suplier'])
                ->findAll();
            // Add user IDs to the userData array
            foreach ($users as $user) {
                $userData[] = $user['id'];
            }
        }

        return [
            'moldData' => $moldData,
            'suplierData' => $suplierData,
            'userData' => $userData
        ];
    }

    
}
