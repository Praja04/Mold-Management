<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailMold extends Model
{
    protected $table = 'detail_mold';
    protected $primaryKey = 'Id';
    protected $allowedFields = ['Mold_Id', 'User_ID', 'Part_Name', 'Gambar_Mold','dokumen_mold','dokumen_mold2','dokumen_mold3','created_at'];
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;

    public function getLatestByPartName($partName)
    {
        // Fetch the latest record based on Part_Name and Tanggal_Update
        return $this->where('Part_Name', $partName)
            ->orderBy('created_at', 'DESC') // Order by Tanggal_Update in descending order
            ->first(); // Get the first result (most recent one)
    }
 
    public function getDataByUserId($userId)
    {
        return $this->where('User_ID', $userId)
            ->orderBy('created_at', 'DESC')
            ->first();
    }

    public function getItemData()
    {
        // Membuat instance dari MoldItemModel
        $moldItemModel = new MoldItemModel();

        // Mendapatkan data ITEM dari tabel mold_item
        return $moldItemModel->findAll();
    }

    public function notif_verifikasi(){
        $builder = $this->db->table($this->table);
        $builder->where('Hasil_Verifikasi', 0);
        $query = $builder->countAllResults();

        return $query;
    }
}
