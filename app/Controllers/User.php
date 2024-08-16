<?php

namespace App\Controllers;

use App\Models\MoldItemModel;
use App\Models\UserModel;
use App\Models\PerbaikanBesarModel;
use App\Models\ReportModel;
use App\Models\SupplierModel;
use App\Models\TransaksiJumlahProduk;

class User extends BaseController
{

    public function getUserDataTotal()
    {
        $usermodel = new UserModel();
        $UserID = session()->get('user_id');
        $latestDetailMold = $usermodel
            ->where('id', $UserID)
            ->first();

        $supplier = $latestDetailMold['suplier'];
        // Membuat instance model MoldItemModel
        $moldItemModel = new MoldItemModel();

        // Memanggil method untuk mengambil data ITEM berdasarkan SUPPLIER
        $items = $moldItemModel->getItemBySupplier($supplier);

        $this->response->setContentType('application/json');
        return $this->response->setJSON($items);
    }

    public function pengajuan_harian()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        $reportModel = new ReportModel();
        $moldItemModel = new MoldItemModel();
        $jumlahtotal = new SupplierModel();
        $jumlahDikirim = new TransaksiJumlahProduk();

        $user_id = session()->get('user_id');
        $reports = $reportModel->where('user_id', $user_id)->findAll();

        // Menghitung jumlah mold yang dibaca dan belum
        $moldCounts = [];

        foreach ($reports as $report) {
            $moldName = $report['nama_mold'];

            if (!isset($moldCounts[$moldName])) {
                $moldCounts[$moldName] = ['no' => 0, 'yes' => 0];
            }

            $moldCounts[$moldName][$report['is_seen']]++;
        }

        // Menghitung jumlah total produksi setiap mold
        $molds = $moldItemModel->findAll();
        foreach ($molds as $mold) {
            if (isset($moldCounts[$mold['ITEM']])) {
                $moldCounts[$mold['ITEM']]['mold_name'] = $mold['ITEM'];
            }
        }

        foreach ($moldCounts as $moldName => &$counts) {
            $moldTotal = $jumlahtotal->where('mold_name', $moldName)->first();
            if ($moldTotal) {
                $counts['jumlah_produk'] = $moldTotal['jumlah_produk'];
            } else {
                $counts['jumlah_produk'] = 0; // Set default to 0 if not found
            }
        }

        // Menghitung jumlah yang dikirim dari tiap mold
        $jumlahDikirimData = $jumlahDikirim->findAll();
        $groupedData = [];
        foreach ($jumlahDikirimData as $data) {
            $moldName = $data['nama_mold'];
            if (!isset($groupedData[$moldName])) {
                $groupedData[$moldName] = 0;
            }
            $groupedData[$moldName] += $data['jumlah_produk'];
        }

        foreach ($moldCounts as $moldName => &$counts) {
            if (isset($groupedData[$moldName])) {
                $counts['jumlah_dikirim'] = $groupedData[$moldName];
            } else {
                $counts['jumlah_dikirim'] = 0; // Set default to 0 if not found
            }
        }

        $data['moldCounts'] = $moldCounts;

        return view('pages/user/pengajuan/report_daily/pengajuan_harian', $data);
    }


    public function historyReportMold()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $reportModel = new ReportModel();
        $transaksi = new TransaksiJumlahProduk();
        $nama_mold = $this->request->getGet('namaMold');
        $history['transaksiReport'] = $transaksi->getTransaksiByMoldName($nama_mold);
        $history['historyReport'] = $reportModel->getReportsByMoldName($nama_mold);
        return view('pages/user/pengajuan/report_daily/detail_pengajuan_harian', $history);
    }

    public function pengajuan_perbaikanBesar()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $PerbaikanBesar = new PerbaikanBesarModel();
        $moldItemModel = new MoldItemModel();

        $user_id = session()->get('user_id');
        $reports = $PerbaikanBesar->where('user_id', $user_id)->findAll();


        // Siapkan array untuk menampung data teragregasi
        $moldCounts = [];

        foreach ($reports as $report) {
            $moldName = $report['nama_mold'];

            if (!isset($moldCounts[$moldName])) {
                $moldCounts[$moldName] = ['no' => 0, 'yes' => 0];
            }

            if ($report['terima_perbaikan'] == 'no') {
                $moldCounts[$moldName]['no']++;
            } elseif ($report['terima_perbaikan'] == 'yes' && $report['visit'] == 0) {
                $moldCounts[$moldName]['yes']++;
            }
        }

        // Opsional: ambil detail mold jika diperlukan
        $molds = $moldItemModel->findAll();
        foreach ($molds as $mold) {
            if (isset($moldCounts[$mold['ITEM']])) {
                $moldCounts[$mold['ITEM']]['ITEM'] = $mold['ITEM'];
            }
        }

        $data['moldCounts'] = $moldCounts;
        return view('pages/user/pengajuan/perbaikan_besar/pengajuan_perbaikan', $data);
    }


    public function PerbaikanBesar_notAcc()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $PerbaikanBesar = new PerbaikanBesarModel();
        $nama_mold = $this->request->getGet('namaMold');
        $history['historyPerbaikan'] = $PerbaikanBesar->getPerbaikanByMoldName($nama_mold);
        $history['nama_mold'] = $nama_mold;
        return view('pages/user/pengajuan/perbaikan_besar/detail_not_acc', $history);
    }
    public function PerbaikanBesar_Acc()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $PerbaikanBesar = new PerbaikanBesarModel();
        $nama_mold = $this->request->getGet('namaMold');
        $history['historyPerbaikan'] = $PerbaikanBesar->getPerbaikanByMoldName($nama_mold);
        $history['nama_mold'] = $nama_mold;
        return view('pages/user/pengajuan/perbaikan_besar/detail_acc', $history);
    }

    public function historyPerbaikanBesar()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $PerbaikanBesar = new PerbaikanBesarModel();
        $nama_mold = $this->request->getGet('namaMold');
        $history['historyPerbaikan'] = $PerbaikanBesar->getPerbaikanByMoldNameAll($nama_mold);
        $history['nama_mold'] = $nama_mold;
        return view('pages/user/pengajuan/perbaikan_besar/detail_pengajuan_perbaikan', $history);
    }

    public function perbaikan()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $item = $this->request->getGet('item');
        $id = $this->request->getGet('id');
        return view('pages/user/perbaikan/perbaikan', ['item' => $item, 'id' => $id]);
    }

    public function logBook_perbaikan()
    {
        if (!session()->has('user_nama')) {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        $user_id = session()->get('user_id');
        $model = new PerbaikanBesarModel();
        $data['data'] = $model->getAllLogbook($user_id);

        return view('pages/user/perbaikan/perbaikan_logbook', $data);
    }


    public function notif_perbaikan()
    {
        if (!session()->has('user_nama')) {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        $reportModel = new ReportModel();
        $moldItemModel = new MoldItemModel();

        $user_id = session()->get('user_id');
        $reports = $reportModel->where('user_id', $user_id)->findAll();

        // Prepare an array to hold the aggregated data
        $moldCounts = [];
        $totalNo = 0; // Variable to hold the sum of 'no' values

        foreach ($reports as $report) {
            $moldName = $report['nama_mold'];

            if (!isset($moldCounts[$moldName])) {
                $moldCounts[$moldName] = ['no' => 0, 'yes' => 0];
            }

            $moldCounts[$moldName][$report['is_seen']]++;
        }

        // Optionally get mold details if needed
        $molds = $moldItemModel->findAll();
        foreach ($molds as $mold) {
            if (isset($moldCounts[$mold['ITEM']])) {
                $moldCounts[$mold['ITEM']]['ITEM'] = $mold['ITEM'];
            }
        }

        // Calculate the total 'no' value
        foreach ($moldCounts as $counts) {
            $totalNo += $counts['no'];
        }

        $model = new PerbaikanBesarModel();
        $result = $model->getUploadAcc($user_id);
        $jumlah = $result['jumlah'];

        return $this->response->setJSON([
            'jumlah' => $jumlah,
            'totalNo' => $totalNo // Add the total 'no' value to the response
        ]);
    }


    public function upload_perbaikan()
    {
        if (!session()->has('user_nama')) {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        $user_id = session()->get('user_id');
        $model = new PerbaikanBesarModel();
        $result = $model->getUploadAcc($user_id);
        $data = $result['data'];
        $jumlah = $result['jumlah'];

        return view('pages/user/pengajuan/upload_perbaikan', [
            'data' => $data,
            'jumlah' => $jumlah,
        ]);
    }

    public function reject()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $item = $this->request->getGet('item');
        $id = $this->request->getGet('id');
        return view('pages/user/reject/reject', ['item' => $item, 'id' => $id]);
    }

    public function dashboard()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $supplier = new SupplierModel();
        $username = session()->get('user_suplier');
        $items['data'] = $supplier->getSupplierDataWithMoldItems($username);
        return view('pages/user/dashboard/dashboard',$items);
    }




    public function getUserData()
    {
        // Periksa apakah pengguna telah login
        if (!session()->has('user_nama')) {
            // Jika pengguna belum login, arahkan ke halaman login
            session()->setFlashdata('error', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        // Dapatkan User_ID pengguna dari sesi
        $userId = session()->get('user_id');

        // Instansiasi model UserModel
        $formModel = new UserModel();
        // Panggil fungsi dari model untuk mendapatkan data berdasarkan User_ID
        $userData['data_user'] = $formModel->getUserByUsername($userId);

        // Periksa apakah data ditemukan
        if ($userData) {
            // Kembalikan data sebagai JSON
            $this->response->setContentType('application/json');
            return $this->response->setJSON($userData);
        } else {
            // Kembalikan pesan error jika data tidak ditemukan
            return $this->response->setJSON(['error' => 'Data tidak ditemukan untuk User_ID yang diberikan.']);
        }
    }


    //ambil data mold apa saja yang ada di satu suplier
    public function getItemBySupplier()
    {
        $usermodel = new usermodel();
        $UserID = session()->get('user_id');
        $latestDetailMold = $usermodel
            ->where('id', $UserID)
            ->first();

        $supplier = $latestDetailMold['suplier'];
        // Membuat instance model MoldItemModel
        $moldItemModel = new MoldItemModel();

        // Memanggil method untuk mengambil data ITEM berdasarkan SUPPLIER
        $items = $moldItemModel->getItemBySupplier($supplier);

        $this->response->setContentType('application/json');
        return $this->response->setJSON($items);
    }
}
