<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PerbaikanDailyModel;
use App\Models\RejectMoldModel;
use App\Models\short_akumulasiModel;
use App\Models\MoldItemModel;

class RejectMold extends BaseController
{
    public function getLatestData()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        $partName = $this->request->getGet('partName');
        $idMold = $this->request->getGet('id');

        $model = new RejectMoldModel();
        $data = $model->getLatestData($partName, $idMold);

        return $this->response->setJSON($data);
    }
    public function submit_reject()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        try {
            $reject = new RejectMoldModel();
            $userID = session()->get('user_id');
            $data = [
                'user_id' => $userID,
                'id_mold' => $this->request->getPost('moldId'),
                'nama_mold' => $this->request->getPost('part_name'),
                'suplier' => $this->request->getPost('suplier'),
                'tanggal_pengajuan' => $this->request->getPost('tanggal_pengajuan'),
                'kondisi_mold' => $this->request->getPost('kondisi_mold'),
                'jumlah_reject' => $this->request->getPost('jumlah_reject'),
                'keterangan' => $this->request->getPost('keterangan'),
                'jumlah_ok' => $this->request->getPost('jumlah_ok')
            ];


            $reject->save($data);
            return $this->response->setJSON(['message' => 'Data submitted successfully!']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
    public function getData_reject()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        try {
            $partName = $this->request->getGet('partName');
            $idMold = $this->request->getGet('id');
            $Reject = new RejectMoldModel();
            $TotalReject = $Reject->getTotalJumlahOkByIdMold($partName, $idMold);
            return $this->response->setJSON($TotalReject);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }


    public function getuserReject($userId)
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        try {
            $reject = new RejectMoldModel();
            $data['data'] = $reject->All_reject_user($userId);
            return view('pages/admin/reject/reject_user', $data);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
}
