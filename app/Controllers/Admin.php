<?php

namespace App\Controllers;

use App\Models\ReportModel;
use App\Models\UserModel;
use App\Models\MoldItemModel;
use App\Models\DetailMold;
use App\Models\PerbaikanBesarModel;
use App\Models\RejectMoldModel;
use App\Models\TransaksiJumlahProduk;
use App\Models\SupplierModel;

class Admin extends BaseController
{

    public function updateProdukById()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        $model = new SupplierModel();
        $id = $this->request->getPost('id_mold');
        $jumlah = $this->request->getPost('jumlah');

        $model = new SupplierModel();
        if ($model->updateJumlahProduk($id, $jumlah)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Jumlah produk berhasil diupdate untuk entri ' ]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal mengupdate jumlah produk untuk entri  ']);
        }
    }

    public function downloadPdf($filename)
    {
        $filePath = ROOTPATH . 'public/uploads/' . $filename;
        if (file_exists($filePath)) {
            return $this->response->download($filePath, null)->setFileName($filename);
        } else {
            return $this->response->setStatusCode(404, 'File not found');
        }
    }

    public function dashboard()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $password = 'NATAMAS123';
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $namaAdmin = session()->get('admin_nama');
        $moldItemModel = new MoldItemModel();
        $suplier = new UserModel();

        // Mengambil semua item dari model
        $items = $moldItemModel->getAllItems();
        $suplier = $suplier->getUser();
        // Meneruskan data ke tampilan
        $Data['items'] = $items;
        $Data['suplier'] = $suplier;
        $TotalReject = new RejectMoldModel();
        $TotalItems = new MoldItemModel();
        $TotalUser = new UserModel();
        $GetTotalItem = $TotalItems->TotalAllItems();
        $GetTotalReject = $TotalReject->TotalAllItems();
        $GetTotalUser = $TotalUser->TotalUser();
        $Data['totalItem'] = $GetTotalItem;
        $Data['PASSWORD'] = $hashed_password;
        $Data['totalUser'] = $GetTotalUser;
        $Data['totalReject'] = $GetTotalReject;
        $Data['adminName'] = $namaAdmin;

        return view('pages/admin/dashboard/dashboard', $Data);
    }

    public function report_perbaikan_besar()
    {

        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $user = new UserModel();
        $perbaikan = new PerbaikanBesarModel();
        $GetUser = $user->getUser();
        $TotalPerbaikan = $perbaikan->countisSeen();
        $GetPerbaikan = $perbaikan->countDataPerUser();
        $perbaikanCounts = [];
        foreach ($GetPerbaikan as $repair) {
            $perbaikanCounts[$repair['user_id']] = $repair['total_data_no'];
            $perbaikanDoneCounts[$repair['user_id']] = $repair['total_data_yes'];
        }

        $dataUser['data'] = $GetUser;
        $dataUser['perbaikanBesarCounts'] = $perbaikanCounts;
        $dataUser['perbaikanBesarDoneCounts'] = $perbaikanDoneCounts;
        $dataUser['totalTerima'] = $TotalPerbaikan;
        return view('pages/admin/perbaikan_besar/report_perbaikan_besar', $dataUser);
    }
    public function listMold_perbaikanBesar()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $supplierId = $this->request->getGet('supplier');


        if ($supplierId) {
            $model = new MoldItemModel();
            $data = $model->getItemsperbaikanBesar($supplierId);
        }
        return view('pages/admin/perbaikan_besar/list_mold_perbaikan', ['data' => $data]);
    }

    public function perbaikanBesar_detail_no()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $perbaikan = new PerbaikanBesarModel();
        $nama_mold = $this->request->getGet('namaMold');
        // Lakukan query untuk mengambil data mold berdasarkan User_ID
        $moldData['moldData'] = $perbaikan->where('nama_mold', $nama_mold)
            ->where('terima_perbaikan', 'no')
            ->where('temporary', null)
            ->where('permanen', null)
            ->orderBy('created_at', 'DESC')
            ->findAll();
       
        return view('pages/admin/perbaikan_besar/detail_perbaikan_no', $moldData);
    }
    public function perbaikanBesar_detail_yes()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $perbaikan = new PerbaikanBesarModel();
        $nama_mold = $this->request->getGet('namaMold');
        // Lakukan query untuk mengambil data mold berdasarkan User_ID
        $moldData['moldData'] = $perbaikan->where('nama_mold', $nama_mold)
            ->where('terima_perbaikan', 'yes')
            ->where('temporary', null)
            ->where('permanen', null)
            ->orderBy('created_at', 'DESC')
            ->findAll();
       
        return view('pages/admin/perbaikan_besar/detail_perbaikan_yes', $moldData);
    }
    public function perbaikanBesar_detail()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $perbaikan = new PerbaikanBesarModel();
        $nama_mold = $this->request->getGet('namaMold');
        // Lakukan query untuk mengambil data mold berdasarkan User_ID
        $moldData['moldData'] = $perbaikan->where('nama_mold', $nama_mold)
            ->orderBy('created_at', 'DESC')
            ->findAll();
        return view('pages/admin/perbaikan_besar/perbaikan_besar_detail', $moldData);
    }


    public function report_perbaikan_daily()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $user = new UserModel();
        $report = new TransaksiJumlahProduk();
        $GetUser = $user->getUser();
        $TotalPerbaikan = $report->countisSeen();
        $GetPerbaikan = $report->countDataPerUser();
        $perbaikanCounts = [];
        $perbaikanDoneCounts = [];
        foreach ($GetPerbaikan as $repair) {
            $perbaikanCounts[$repair['user_id']] = $repair['total_data_no'];
            $perbaikanDoneCounts[$repair['user_id']] = $repair['total_data_yes'];
        }

        $dataUser['data'] = $GetUser;
        $dataUser['perbaikanCounts'] = $perbaikanCounts;
        $dataUser['perbaikanDoneCounts'] = $perbaikanDoneCounts;
        $dataUser['totalTerima'] = $TotalPerbaikan;
        return view('pages/admin/perbaikan_daily/report_perbaikan', $dataUser);
    }

    public function notif_perbaikan()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $PerbaikanModel = new PerbaikanBesarModel();
        $reportModel = new ReportModel();
        $count['jumlah'] = $reportModel->countisSeen();
        $count['total'] = $PerbaikanModel->countTerimaPerbaikan();
        // Mengembalikan hasil dalam format JSON
        return $this->response->setJSON($count);
    }

    public function logBook_perbaikan()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        try {
            $perbaikan = new PerbaikanBesarModel();
            $data['data'] = $perbaikan->getAllLogbookadmin();
            $data['All_data'] = $perbaikan->getAllLogbookadmin();
            return view('pages/admin/logbook/logbook_perbaikan', $data);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
    public function logBook_mold()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $moldItemModel = new MoldItemModel();
        $reportModel = new ReportModel();
        // Mengambil semua item dari model
        $items = $moldItemModel->getAllItems();
        // Menggabungkan data dengan akumulasi shot
        foreach ($items as &$item) {
            $accumulatedShots = $reportModel->getakumulasishotperITEM($item['ITEM']);
            $item['total_ok'] = $accumulatedShots ? $accumulatedShots->total_ok : 0;
            $item['total_ng'] = $accumulatedShots ? $accumulatedShots->total_ng : 0;
        }
        $dataUser['data'] = $items;
        return view('pages/admin/logbook/logbook_mold', $dataUser);
    }
   

   

    public function Form_Verifikasi()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $moldItemModel = new MoldItemModel();

        // Mengambil semua item dari model
        $items = $moldItemModel->getAllItems();

        // Meneruskan data ke tampilan
        $data['items'] = $items;


        return view('pages/admin/verifikasi/form', $data);
    }

    //menampilkan list user suplier cbi di dashboard
    public function userlist()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $userId = 3;
        $user = new UserModel();
        $GetUser = $user->getUsersWithNotifications();
        $Getnotif = $user->get_notifUser($userId);
        $dataUser['data'] = $GetUser;
        $dataUser['notif'] = $Getnotif;
        return view('pages/admin/verifikasi/userlist', $dataUser);
    }
    //ketika salah satu list user diklik
    public function manage()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $supplierId = $this->request->getGet('supplier');



        if ($supplierId) {
            $model = new MoldItemModel();
            $data = $model->getItemsWithVerificationCount($supplierId);
        }
        return view('pages/admin/verifikasi/list_moldverif', ['data' => $data]);
    }

    public function manageMold()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        // Membuat instance model FormModel
        $moldDetail = new DetailMold();
        $moldItem = new MoldItemModel();
        $nama_mold = $this->request->getGet('namaMold');
        // Lakukan query untuk mengambil data mold berdasarkan User_ID
        $moldData['moldData'] = $moldDetail->where('Part_Name', $nama_mold)
            ->orderBy('Tanggal_Update', 'DESC')
            ->first();
        $moldItems = $moldItem->getAllByPartname($nama_mold);
        $moldData['Item'] = $moldItems[0];
        return view('pages/admin/verifikasi/manage_mold', $moldData);
    }
    public function getUserMold()
    {

        $user = new UserModel();
        $GetUser = $user->getUser();
        $this->response->setContentType('application/json');
        return $this->response->setJSON($GetUser);
    }


    public function getMoldByUser($userId)
    {
        // Membuat instance model MoldModel
        $moldModel = new DetailMold();

        // Mengambil data mold_cbi berdasarkan User_ID dengan urutan tanggal update desc   $moldData = $moldModel->where('User_ID', $userId)->findAll();
        $moldData = $moldModel->where('User_ID', $userId)
            ->orderBy('Tanggal_Update', 'DESC')
            ->first();;

        // Mengatur jenis konten respons menjadi JSON
        $this->response->setContentType('application/json');

        // Mengembalikan data mold dalam format JSON
        return $this->response->setJSON($moldData);
    }

    //acc dan not acc
    public function updateHasilVerifikasi()
    {
        $moldModel = new DetailMold();
        $moldID = $this->request->getPost('moldID');
        $file = $this->request->getFile('verifikasi_pdf');

        if (!$file->isValid()) {
            return $this->response->setStatusCode(400, 'File not valid');
        }

        try {
            if (!$file->hasMoved()) {
                $filename = $file->getRandomName();
                $file->move(ROOTPATH . 'public/uploads', $filename);

                $datamold = [
                    'Hasil_Verifikasi' => $filename
                ];
                $moldModel->update($moldID, $datamold);

                return $this->response->setJSON(['message' => 'Data submitted successfully!']);
            } else {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'File has already been moved!']);
            }
        } catch (\Exception $e) {
            log_message('error', 'File upload error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }


    public function updateHasilVerifikasi2($moldID)
    {
        // Panggil model untuk melakukan update hasil verifikasi
        $moldModel = new DetailMold();
        $data = [
            'Hasil_Verifikasi' => 2 // Ubah hasil verifikasi 
        ];
        $result = $moldModel->update($moldID, $data);
        // Buat respons JSON
        $response = array();
        if ($result) {
            $response['success'] = true;
            $response['message'] = 'Perubahan berhasil disimpan.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Gagal menyimpan perubahan.';
        }

        // Kembalikan respons sebagai JSON
        return $this->response->setJSON($response);
    }

    //submit form verifikasi
    public function submit_verifikasi()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        try {
            $moldModel = new DetailMold();

            // Ambil file PDF yang diunggah
            $lampiran_drawing = $this->request->getFile('drawing_produk');
            $gambar_mold = $this->request->getFile('gambar_mold');
            $gambar_part = $this->request->getFile('gambar_part');
            $gambar_runner = $this->request->getFile('gambar_runner');

            // Validasi file PDF
            if ($lampiran_drawing->isValid() && !$lampiran_drawing->hasMoved() && $lampiran_drawing->getExtension() === 'pdf') {
                // Pindahkan file PDF ke direktori yang tepat
                $drawingname = $lampiran_drawing->getRandomName();
                $lampiran_drawing->move(ROOTPATH . 'public/uploads', $drawingname);

                $gambarmold = $gambar_mold->getRandomName();
                $gambar_mold->move(ROOTPATH . 'public/uploads', $gambarmold);

                $gambarpart = $gambar_part->getRandomName();
                $gambar_part->move(ROOTPATH . 'public/uploads', $gambarpart);

                $gambarRunner = $gambar_runner->getRandomName();
                $gambar_runner->move(ROOTPATH . 'public/uploads', $gambarRunner);

                // detail_mold
                $datamold = [
                    'User_ID' => $this->request->getPost('user_id'),
                    'Mold_Id' => $this->request->getPost('moldIdContent'),
                    'Part_Name' => $this->request->getPost('partname'),
                    'Gambar_Mold' =>  $gambarmold,
                    'Deskripsi_Mold' => $this->request->getPost('deskripsi_mold'),
                    'Gambar_Part' => $gambarpart,
                    'Deskripsi_Part' => $this->request->getPost('deskripsi_part'),
                    'Gambar_Runner' => $gambarRunner,
                    'Deskripsi_Runner' => $this->request->getPost('deskripsi_runner'),
                    'Tanggal_Update' => $this->request->getPost('tanggal_update'),
                    'Posisi_Mold' => $this->request->getPost('posisi_mold'),
                    'Drawing_Produk' => $drawingname,
                    'Subject_Mold' => $this->request->getPost('subject_mold'),
                    'Subject_Tool' => $this->request->getPost('tools'),
                    'Subject_Mesin' => $this->request->getPost('mesin'),
                    'Subject_Produk' => $this->request->getPost('produk'),
                    'Subject_Proses' => $this->request->getPost('proses'),
                    'Subcount_Suplier' => $this->request->getPost('subcount'),
                    'Validasi_Ke' => $this->request->getPost('verif_ke'),
                    'LK3' => $this->request->getPost('lk3'),
                    'Spesifikasi' => $this->request->getPost('spek'),
                    'Hasil_Verifikasi' => 0
                ];

                $moldModel->save($datamold);
                


                return $this->response->setJSON(['message' => 'Data submitted successfully!']);
            } else {
                // File tidak valid atau bukan file PDF
                return $this->response->setJSON(['error' => 'Invalid or non-PDF file uploaded!']);
            }
        } catch (\Exception $e) {
            // Tangkap dan cetak pesan kesalahan
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
    public function getItemsBySupplier()
    {
        $supplierId = $this->request->getGet('supplier');

        if ($supplierId) {
            $model = new MoldItemModel();
            $items = $model->getItemBySupplierforAdmin($supplierId);
            return $this->response->setJSON($items);
        }

        return $this->response->setJSON(['error' => 'ID tidak valid']);
    }

   
}
