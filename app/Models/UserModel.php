<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role', 'suplier', 'address','email'];

    public function cek_login($username, $password)
    {
        $user = $this->where('username', $username)->first();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }


    public function getUserById($userId)
    {
        return $this->where('id', $userId)->first();
    }
    public function getUser()
    {
        return $this->findAll();
    }
    public function getitemUser($userId)
    {
        return $this->select('detail_mold.*, 
        lampiran_dimensi.*, 
        lampiran_visual.*, 
        history_perbaikan.*')
            ->join('lampiran_dimensi', 'lampiran_dimensi.id_detail = detail_mold.Id', 'left')
            ->join('lampiran_visual', 'lampiran_visual.id_detail = detail_mold.Id', 'left')
            ->join('history_perbaikan', 'history_perbaikan.id_detail = detail_mold.Id', 'left')
            ->where('detail_mold.Hasil_Verifikasi', 2)
            ->where('detail_mold.User_ID', $userId)
            ->orderBy('detail_mold.Tanggal_Update', 'DESC')
            ->findAll();
    }
    public function get_notifUser($userId)
    {
        return $this->select('detail_mold.Hasil_Verifikasi , users.id')
            ->join('detail_mold', 'users.id = detail_mold.User_ID', 'left')
            ->where('detail_mold.Hasil_Verifikasi', '0')
            ->orderBy('detail_mold.Tanggal_Update', 'DESC')
            ->where('detail_mold.User_ID', $userId)
            ->findAll();
    }

    public function getUsersWithNotifications()
    {
        // Ambil semua data user
        $users = $this->findAll();

        // Inisialisasi array untuk hasil gabungan
        $result = [];

        // Loop melalui setiap user
        foreach ($users as $user) {
            // Ambil notifikasi untuk setiap user
            $notif = $this->select('detail_mold.Hasil_Verifikasi, detail_mold.Tanggal_Update')
                ->join('detail_mold', 'users.id = detail_mold.User_ID', 'left')
                ->where('detail_mold.Hasil_Verifikasi', '0')
                ->where('users.id', $user['id'])
                ->orderBy('detail_mold.Tanggal_Update', 'DESC')
                ->findAll();

            // Tambahkan notifikasi ke data user
            $user['notifications'] = $notif;

            // Tambahkan data user ke hasil
            $result[] = $user;
        }

        return $result;
    }

    public function TotalUser()
    {
        return $this->db->table('users')->countAllResults();
    }

    public function getUserByUsername($username)
    {
        return $this->select('username , role , suplier , address ,email')
        ->where('suplier', $username)
            ->first();
    }
}
