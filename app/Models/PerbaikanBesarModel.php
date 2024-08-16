<?php

namespace App\Models;

use CodeIgniter\Model;

class PerbaikanBesarModel extends Model
{
    protected $table = 'perbaikan_besar';
    protected $primaryKey = 'id_perbaikan';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'user_id',
        'id_mold',
        'nama_mold',
        'suplier',
        'tanggal_pengajuan',
        'kondisi_mold',
        'gambar_rusak',
        'keterangan',
        'rencana_perbaikan',
        'terima_perbaikan',
        'visit',
        'gambar_diperbaiki',
        'dokumen_pendukung',
        'temporary',
        'permanen',
        'created_at'
    ];

    public function countPerbaikanBesarByMold($nama_mold)
    {
        return $this->where('nama_mold', $nama_mold)
            ->countAllResults();
    }
  

    public function getPerbaikanByMoldName($moldName)
    {
        return $this->where('nama_mold', $moldName)
            ->where('visit', 0)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
    public function getPerbaikanByMoldNameAll($moldName)
    {
        return $this->where('nama_mold', $moldName)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
    public function countHasilVerifikasiByItem($item)
    {

        $query = $this->select('perbaikan_besar.terima_perbaikan')
            ->join('mold_item', 'perbaikan_besar.nama_mold = mold_item.ITEM', 'left')
            ->where('mold_item.ITEM', $item)
            ->where('perbaikan_besar.terima_perbaikan', 'no')
            ->where('perbaikan_besar.visit', 0)
            ->countAllResults();

        $countYes = $this->select('perbaikan_besar.terima_perbaikan')
            ->join('mold_item', 'perbaikan_besar.nama_mold = mold_item.ITEM', 'left')
            ->where('mold_item.ITEM', $item)
            ->where('perbaikan_besar.terima_perbaikan', 'yes')
            ->where('perbaikan_besar.visit', 0)
            ->countAllResults();

        return [
            'count_no' => $query,
            'count_yes' => $countYes
        ];
    }

    public function countisSeen()
    {

        $builder = $this->db->table($this->table)
            ->select('SUM(CASE WHEN terima_perbaikan = \'no\' THEN 1 ELSE 0 END) AS terima_perbaikan_0')
            ->select('SUM(CASE WHEN terima_perbaikan = \'yes\' AND visit = 0 THEN 1 ELSE 0 END) AS terima_perbaikan_1');

        return $builder->get()->getRowArray();
    }



    public function getPerbaikan($userId)
    {
        return $this->select('perbaikan_besar.*')
            ->where('user_id', $userId)
            ->where('terima_perbaikan', 0)
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->findAll();
    }
    public function getAllPerbaikan($userId)
    {
        return $this->select('perbaikan_besar.*')
            ->where('user_id', $userId)
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->findAll();
    }
    public function countDataPerUser()
    {
        // $builder = $this->db->table('users u')
        //     ->select('u.id AS user_id, COUNT(pd.user_id) AS total_data')
        //     ->join('perbaikan_besar pd', 'u.id = pd.user_id AND pd.terima_perbaikan = \'no\'', 'left')
        //     ->groupBy('u.id');

        $builder = $this->db->table('users u')
            ->select('u.id AS user_id, 
              COUNT(CASE WHEN pd.terima_perbaikan = \'no\' THEN 1 END) AS total_data_no, 
              COUNT(CASE WHEN pd.terima_perbaikan = \'yes\' THEN 1 END) AS total_data_yes')
            ->join('perbaikan_besar pd', 'u.id = pd.user_id AND pd.visit = 0', 'left')
            ->groupBy('u.id')
            ->orderBy('total_data_no', 'DESC');

        return $builder->get()->getResultArray();
    }


    public function countTerimaPerbaikan()
    {

        $builder = $this->db->table('perbaikan_besar pd')
            ->select('SUM(CASE WHEN pd.terima_perbaikan = \'no\' THEN 1 ELSE 0 END) AS terima_perbaikan_0')
            ->select('SUM(CASE WHEN pd.terima_perbaikan = \'yes \' THEN 1 ELSE 0 END) AS terima_perbaikan_1');

        return $builder->get()->getRowArray();
    }

    public function notif_perbaikan()
    {
        $builder = $this->db->table($this->table);
        $builder->where('terima_perbaikan', 0);
        $query = $builder->countAllResults();

        return $query;
    }

    public function getLatestData($namaMold, $idMold)
    {
        return $this->where('nama_mold', $namaMold)
            ->where('id_mold', $idMold)
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->first();
    }

    public function getUploadAcc($user_id)
    {
        $data = $this->select('perbaikan_besar.*')
            ->where('gambar_diperbaiki', null)
            ->where('terima_perbaikan', 'yes')
            ->where('user_id', $user_id)
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->findAll();

        $jumlah = $this
            ->where('terima_perbaikan', 'no')
            ->where('user_id', $user_id)
            ->countAllResults();

        return ['data' => $data, 'jumlah' => $jumlah];
    }
 

    public function getAllLogbook($user_id)
    {
        return $this->select('perbaikan_besar.*')
            ->where('gambar_diperbaiki IS NOT NULL')
            ->where('terima_perbaikan', 1)
            ->where('user_id', $user_id)
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->findAll();
    }

    public function getAllLogbookadmin()
    {
        return $this->select('perbaikan_besar.*')
            ->where('gambar_diperbaiki IS NOT NULL')
            ->where('terima_perbaikan', 1)
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->findAll();
    }


    public function countNewUploads()
    {
        return $this->selectCount('*')
            ->where('gambar_diperbaiki', null)
            ->where('terima_perbaikan', 1)
            ->countAllResults();
    }
}
