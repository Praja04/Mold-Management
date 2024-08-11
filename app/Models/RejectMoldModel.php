<?php

namespace App\Models;

use CodeIgniter\Model;

class RejectMoldModel extends Model
{
    protected $table = 'reject_mold';
    protected $primaryKey = 'id_reject';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'user_id',
        'id_mold',
        'nama_mold',
        'suplier',
        'tanggal_pengajuan',
        'kondisi_mold',
        'jumlah_reject',
        'keterangan',
        'jumlah_ok'
    ];

    public function getLatestData($namaMold, $idMold)
    {
        return $this->where('nama_mold', $namaMold)
            ->where('id_mold', $idMold)
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->first();
    }

    public function TotalAllItems()
    {
        return $this->db->table('reject_mold')->countAllResults();
    }

    public function reject_OK_NG($namaMold, $idMold)
    {
        return $this->select('id_reject,id_mold, nama_mold, jumlah_reject,jumlah_ok')
            ->where('nama_mold', $namaMold)
            ->where('id_mold', $idMold)
            ->groupBy('id_reject, id_mold, nama_mold, jumlah_reject, jumlah_ok, tanggal_pengajuan')
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->first();
    }

    public function All_reject_user($userId)
    {
        return $this->select('reject_mold.*')

            ->where('user_id', $userId)
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->findAll();
    }
    public function All_rejectProduct()
    {
        return $this->select('reject_mold.*')
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->findAll();
    }

    public function getTotalJumlahOkByIdMold($namaMold, $idMold)
    {
        $result = $this->where('id_mold', $idMold)
            ->where('nama_mold', $namaMold)
            ->select('nama_mold')
            ->groupBy('nama_mold')
            ->selectSum('jumlah_ok')
            ->selectSum('jumlah_reject')
            ->get()
            ->getRow();

        return [
            'nama_mold' => $result->nama_mold,
            'total_jumlah_ok' => $result->jumlah_ok,
            'total_jumlah_reject' => $result->jumlah_reject,
        ];
    }

    public function getAllLogbook($userId)
    {
        return $this->select('reject_mold.*')
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->where('user_id', $userId)
            ->findAll();
    }
}
