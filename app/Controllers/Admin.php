<?php

namespace App\Controllers;

use App\Models\ReportModel;
use App\Models\UserModel;
use App\Models\MoldItemModel;
use App\Models\DetailMold;
use App\Models\PerbaikanBesarModel;
use App\Models\TransaksiJumlahProduk;
use App\Models\SupplierModel;

class Admin extends BaseController
{
    //private function
    private function setAndRedirect($status, $message)
    {
        session()->setFlashdata($status, $message);
        return redirect()->to(base_url('register/new/mold'));
    }

    private function redirectLogin()
    {
        session()->setFlashdata('gagal', 'Anda belum login');
        return redirect()->to(base_url('/'));
    }
    public function updateProdukById()
    {
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }
        $model = new SupplierModel();
        $id = $this->request->getPost('id_mold');
        $jumlah = $this->request->getPost('jumlah');

        $model = new SupplierModel();
        if ($model->updateJumlahProduk($id, $jumlah)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Jumlah produk berhasil diupdate untuk entri ']);
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
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }

        $namaAdmin = session()->get('admin_nama');
        $moldItemModel = new MoldItemModel();
        $suplier = new UserModel();

        // Mengambil semua item dari model
        $items = $moldItemModel->getAllItems();
        $suplier = $suplier->getUser();
        // Meneruskan data ke tampilan
        $Data['items'] = $items;
        $Data['suplier'] = $suplier;
        $TotalItems = new MoldItemModel();
        $TotalUser = new UserModel();
        $GetTotalItem = $TotalItems->TotalAllItems();
        $GetTotalUser = $TotalUser->TotalUser();
        $Data['totalItem'] = $GetTotalItem;
        $Data['totalUser'] = $GetTotalUser;
        $Data['adminName'] = $namaAdmin;

        return view('pages/admin/dashboard/dashboard', $Data);
    }

    public function report_perbaikan_besar()
    {

        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
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
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
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
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
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
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
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
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
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
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
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
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
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
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
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
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
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
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
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
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
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
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }
        // Membuat instance model FormModel
        $moldDetail = new DetailMold();
        $moldItem = new MoldItemModel();
        $nama_mold = $this->request->getGet('namaMold');
        // Lakukan query untuk mengambil data mold berdasarkan User_ID
        $moldData['moldData'] = $moldDetail->where('Part_Name', $nama_mold)
            ->orderBy('created_at', 'DESC')
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


    //submit form verifikasi
    public function submit_verifikasi()
    {
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }

        try {
            $moldModel = new DetailMold();

            // Ambil file PDF yang diunggah
            //$lampiran_drawing = $this->request->getFile('drawing_produk');
            $gambar_mold = $this->request->getFile('gambar_mold');
            // $gambar_part = $this->request->getFile('gambar_part');
            // $gambar_runner = $this->request->getFile('gambar_runner');

            // Validasi file PDF
            if ($gambar_mold->isValid() && !$gambar_mold->hasMoved()) {
                // Pindahkan file PDF ke direktori yang tepat
                // $drawingname = $lampiran_drawing->getRandomName();
                // $lampiran_drawing->move(ROOTPATH . 'public/uploads', $drawingname);

                $gambarmold = $gambar_mold->getRandomName();
                $gambar_mold->move(ROOTPATH . 'public/uploads', $gambarmold);

                // $gambarpart = $gambar_part->getRandomName();
                // $gambar_part->move(ROOTPATH . 'public/uploads', $gambarpart);

                // $gambarRunner = $gambar_runner->getRandomName();
                // $gambar_runner->move(ROOTPATH . 'public/uploads', $gambarRunner);


                $datamold = [
                    'User_ID' => $this->request->getPost('user_id'),
                    'Mold_Id' => $this->request->getPost('moldIdContent'),
                    'Part_Name' => $this->request->getPost('partname'),
                    'Gambar_Mold' =>  $gambarmold
                    // 'Gambar_Part' => $gambarpart,
                    // 'Gambar_Runner' => $gambarRunner,
                    // 'Drawing_Produk' => $drawingname
                ];

                $moldModel->save($datamold);



                return $this->response->setJSON(['message' => 'Data submitted successfully!']);
            } else {
                // File tidak valid atau bukan file PDF
                return $this->response->setJSON(['error' => 'Invalid or non-PDF file uploaded!']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
    public function update_data_mold()
    {
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }

        try {
            $moldModel = new MoldItemModel();
            $id = $this->request->getPost('id');

            // Cek apakah ID valid
            $existingMold = $moldModel->find($id);
            if (!$existingMold) {
                return $this->response->setJSON(['error' => 'ID tidak ditemukan']);
            }

            $datamold = [
                'Material' => $this->request->getPost('material'),
                'PART' => $this->request->getPost('part'),
                'CYCLE_TIME' => $this->request->getPost('cycle_time'),
                'CAVITY' => $this->request->getPost('cavity'),
                'TONNAGE' => $this->request->getPost('tonase'),
                'DIMENSI_MOLD' => $this->request->getPost('dimensi'),
                'CORE' => $this->request->getPost('core')
            ];

            // Debugging: Log data yang akan diupdate
            log_message('info', 'Updating mold with ID: ' . $id);
            log_message('info', 'Data to update: ' . print_r($datamold, true));

            // Lakukan update
            $moldModel->update($id, $datamold);

            return $this->response->setJSON(['message' => 'Data submitted successfully!']);
        } catch (\Exception $e) {
            log_message('error', 'Update error: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
    public function update_status_mold()
    {
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }

        try {
            $moldModel = new MoldItemModel();
            $id = $this->request->getPost('id');

            // Cek apakah ID valid
            $existingMold = $moldModel->find($id);
            if (!$existingMold) {
                return $this->response->setJSON(['error' => 'ID tidak ditemukan']);
            }

            $datamold = [
                'STATUS' => $this->request->getPost('status')
            ];

            // Debugging: Log data yang akan diupdate
            log_message('info', 'Updating mold with ID: ' . $id);
            log_message('info', 'Data to update: ' . print_r($datamold, true));

            // Lakukan update
            $moldModel->update($id, $datamold);

            return $this->response->setJSON(['message' => 'Data submitted successfully!']);
        } catch (\Exception $e) {
            log_message('error', 'Update error: ' . $e->getMessage());
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

    public function register_suplier()
    {
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }
        return view('pages/admin/registration/register_suplier',);
    }
    public function register_new_mold()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $supplier = new UserModel();
        $data['suppliers'] = $supplier->getUser();
        return view('pages/admin/registration/new_mold', $data);
    }

    public function register_mold()
    {
        // Cek apakah user sudah login
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }
        try {
            $supplierModel = new SupplierModel();
            $moldItem = new MoldItemModel();
            $detail_mold = new DetailMold();

            // Mengambil data dari form
            $postData = $this->request->getPost([
                'ITEM', 'MADE_IN', 'STATUS', 'Material', 'TONNAGE', 'PART',
                'RUNNER', 'CYCLE_TIME', 'DIMENSI_MOLD', 'CAVITY', 'CORE', 'KETERANGAN'
            ]);

            // Cek apakah ITEM sudah terdaftar
            if ($moldItem->where('ITEM', $postData['ITEM'])->countAllResults() > 0) {
                return $this->response->setJSON(['error' => 'Nama Mold sudah terdaftar, gunakan Nama lain.']);
            }

            // Mendapatkan NO terakhir
            $lastNo = $moldItem->selectMax('NO')->first();
            $newNo = isset($lastNo['NO']) ? $lastNo['NO'] + 1 : 1;

            // Menyimpan data mold ke database dengan NO baru
            $postData['NO'] = $newNo;
            $moldItem->insert($postData);

            // Menyimpan data supplier ke database
            $supplierModel->insert([
                'tahun' => date('Y-m-d'),
                'suplier' => $this->request->getPost('supplier'),
                'id_mold' => $newNo,
                'mold_name' => $postData['ITEM'],
                'jumlah_produk' => 0
            ]);

            // Handle dokumen_mold2 dan dokumen_mold3 (opsional)
            $dokumen_mold2 = $this->request->getFile('dokumen_mold2');
            $dokumen_mold3 = $this->request->getFile('dokumen_mold3');
            $Gambar_mold = $this->request->getFile('Gambar_Mold');
            $dokumen_mold = $this->request->getFile('dokumen_mold');

            $dokumenmold2 = null; // Default to null
            $dokumenmold3 = null; // Default to null
            $gambarmold = null; // Default to null
            $dokumenmold = null; // Default to null

            // Memproses dokumen_mold1 (wajib)
            if ($dokumen_mold && $dokumen_mold->isValid() && !$dokumen_mold->hasMoved()
            ) {
                $dokumenmold = $dokumen_mold->getRandomName();
                $dokumen_mold->move(ROOTPATH . 'public/uploads', $dokumenmold);
            } else {
                return $this->response->setJSON(['error' => 'Dokumen Mold 1 is required and must be a valid file.']);
            }

            // Memproses dokumen_mold2 (jika ada)
            if ($dokumen_mold2 && $dokumen_mold2->isValid() && !$dokumen_mold2->hasMoved()
            ) {
                $dokumenmold2 = $dokumen_mold2->getRandomName();
                $dokumen_mold2->move(ROOTPATH . 'public/uploads', $dokumenmold2);
            }

            // Memproses dokumen_mold3 (jika ada)
            if ($dokumen_mold3 && $dokumen_mold3->isValid() && !$dokumen_mold3->hasMoved()
            ) {
                $dokumenmold3 = $dokumen_mold3->getRandomName();
                $dokumen_mold3->move(ROOTPATH . 'public/uploads', $dokumenmold3);
            }

            // Memproses gambar mold (jika ada)
            if ($Gambar_mold && $Gambar_mold->isValid() && !$Gambar_mold->hasMoved()) {
                $gambarmold = $Gambar_mold->getRandomName();
                $Gambar_mold->move(ROOTPATH . 'public/uploads', $gambarmold);
            }

            // Menyimpan data detail mold ke database
            $detail_mold->insert([
                'Part_Name' => $postData['ITEM'],
                'User_ID' =>  $this->request->getPost('user_id'),
                'Mold_Id' => $newNo,
                'Gambar_Mold' => $gambarmold,
                'dokumen_mold' => $dokumenmold,
                'dokumen_mold2' => $dokumenmold2,
                'dokumen_mold3' => $dokumenmold3
            ]);

            return $this->response->setJSON(['message' => 'Data updated successfully!']);
        } catch (\Exception $e) {
            log_message('error',
                'Update error: ' . $e->getMessage()
            );
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }


    public function all_product_mold()
    {
        // Cek apakah user sudah login
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }
        $moldItem = new MoldItemModel();
        $data['molds'] = $moldItem->getAllItems();
        return view('pages/admin/list_mold/all_product_mold', $data);
    }
    public function detail_mold()
    {
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }
        $mold = new MoldItemModel();
        $detail = new DetailMold();
        $jumlah = new SupplierModel();
        $supplier = new UserModel();
        $report = new ReportModel();
        $perbaikan = new PerbaikanBesarModel();
        $nama_mold = $this->request->getGet('namaMold');
        $result = $mold->getDataByItem($nama_mold);
        // Memisahkan data mold dan suplier untuk efisiensi
        $data['suppliers'] = $supplier->getUser();
        $data['detail'] = $detail->getLatestByPartName($nama_mold);
        $data['moldData'] = $result['moldData'];
        $data['suplierData'] = $result['suplierData'];
        $data['userData'] = $result['userData'];
        $data['jumlah'] = $jumlah->getjumlahByMoldName($nama_mold);
        $data['report'] = $report->countDailyReportsByMold($nama_mold);
        $data['report'] = $report->countDailyReportsByMold($nama_mold);
        $data['perbaikan'] = $perbaikan->countPerbaikanBesarByMold($nama_mold);
        return view('pages/admin/list_mold/detail_mold', $data);
    }

    public function delete($id)
    {
        $model = new PerbaikanBesarModel(); // Replace with your actual model name

        // Retrieve the record to be deleted
        $record = $model->find($id);

        if ($record) {
            // Delete the associated image and PDF files
            $filesToDelete = ['gambar_rusak', 'gambar_diperbaiki', 'dokumen_pendukung'];
            foreach ($filesToDelete as $fileField) {
                if (!empty($record[$fileField])) {
                    $filePath = ROOTPATH . 'public/uploads/' . $record[$fileField];
                    if (file_exists($filePath)) {
                        unlink($filePath); // Delete the file
                    }
                }
            }

            // Delete the record from the database
            if ($model->delete($id)) {
                // If deletion is successful, return success response
                return $this->response->setJSON(['success' => true, 'message' => 'Record and associated files deleted successfully!']);
            } else {
                // If deletion failed, return error response
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete the record from the database.']);
            }
        } else {
            // If the record is not found, return error response
            return $this->response->setJSON(['success' => false, 'message' => 'Record not found.']);
        }
    }
    public function delete_mold($id)
    {
        // Initialize models
        $mold = new MoldItemModel();
        $supplier = new SupplierModel();
        $detail = new DetailMold();

        // Retrieve the record from DetailMold using Mold_Id
        $record = $detail->where('Mold_Id', $id)->first();

        if ($record) {
            // Delete the associated image files
            $filesToDelete = ['Gambar_Mold'];

            foreach ($filesToDelete as $fileField) {
                if (!empty($record[$fileField])) {
                    $filePath = ROOTPATH . 'public/uploads/' . $record[$fileField];
                    if (file_exists($filePath)) {
                        unlink($filePath); // Delete the file
                    }
                }
            }

            // Delete related records from SupplierModel based on id_mold
            $supplier->where('id_mold', $id)->delete();

            // Delete the record from DetailMold using Mold_Id
            $detail->where('Mold_Id', $id)->delete();

            // Delete the record from MoldItemModel using NO
            $mold->where('NO', $id)->delete();

            // If deletion is successful, return success response
            return $this->response->setJSON(['success' => true, 'message' => 'Record and associated files deleted successfully!']);
        } else {
            // If the record is not found, return error response
            return $this->response->setJSON(['success' => false, 'message' => 'Record not found.']);
        }
    }


    public function updatePerbaikan()
    {
        $id_perbaikan = $this->request->getPost('id_perbaikan');
        $status_perbaikan = $this->request->getPost('status_perbaikan');

        // Ambil data lama dari database
        $model = new PerbaikanBesarModel();
        $existingData = $model->find($id_perbaikan);


        // Handle file uploads
        $gambar_diperbaiki = $this->request->getFile('gambar_diperbaiki');
        $dokumen_pendukung = $this->request->getFile('dokumen_pendukung');

        // Hapus gambar diperbaiki lama jika ada file baru yang diupload
        if ($gambar_diperbaiki && $gambar_diperbaiki->isValid()) {
            if (!empty($existingData['gambar_diperbaiki']) && file_exists(ROOTPATH . 'public/uploads/' . $existingData['gambar_diperbaiki'])) {
                unlink(ROOTPATH . 'public/uploads/' . $existingData['gambar_diperbaiki']); // Hapus file lama
            }
            $gambar_diperbaikiname = $gambar_diperbaiki->getRandomName();
            $gambar_diperbaiki->move(ROOTPATH . 'public/uploads', $gambar_diperbaikiname);
        }

        // Hapus dokumen pendukung lama jika ada file baru yang diupload
        if ($dokumen_pendukung && $dokumen_pendukung->isValid()) {
            if (!empty($existingData['dokumen_pendukung']) && file_exists(ROOTPATH . 'public/uploads/' . $existingData['dokumen_pendukung'])) {
                unlink(ROOTPATH . 'public/uploads/' . $existingData['dokumen_pendukung']); // Hapus file lama
            }
            $dokumen_pendukungname = $dokumen_pendukung->getRandomName();
            $dokumen_pendukung->move(ROOTPATH . 'public/uploads', $dokumen_pendukungname);
        }
        $data = [
            'temporary' => ($status_perbaikan == 'temporary') ? 'yes' : 'no',
            'permanen' => ($status_perbaikan == 'permanen') ? 'yes' : 'no',
            'gambar_diperbaiki' => $gambar_diperbaikiname,
            'dokumen_pendukung' => $dokumen_pendukungname
        ];

        // Update the database
        $updated = $model->update($id_perbaikan, $data);

        if ($updated) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }

    public function update_data_ITEM()
    {
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }

        try {
            $moldModel = new MoldItemModel();
            $suplierModel = new SupplierModel();
            $detailModel = new DetailMold();
            $id = $this->request->getPost('id');

            // Cek apakah ID valid
            $existingMold = $moldModel->find($id);
            if (!$existingMold) {
                return $this->response->setJSON(['error' => 'ID tidak ditemukan']);
            }

            $datamold = [
                'ITEM' => $this->request->getPost('ITEM'),

            ];
            $datasuplier = [
                'mold_name' => $this->request->getPost('ITEM'),
            ];
            $datadetail = [
                'Part_Name' => $this->request->getPost('ITEM'),
            ];

            // Lakukan update
            $moldModel->update($id, $datamold);
            $suplierModel->where('id_mold', $id)->set($datasuplier)->update();
            $detailModel->where('Mold_Id', $id)->set($datadetail)->update();

            return $this->response->setJSON(['message' => 'Data updated successfully!']);
        } catch (\Exception $e) {
            log_message('error', 'Update error: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
    public function pemindahan_mold()
    {
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }

        try {
            $suplierModel = new SupplierModel();
            $id = $this->request->getPost('id');

            // Cek apakah ID valid

            $datasuplier = [
                'suplier' => $this->request->getPost('suplier'),

            ];
            $suplierModel->where('id_mold', $id)->set($datasuplier)->update();

            return $this->response->setJSON(['message' => 'Data updated successfully!']);
        } catch (\Exception $e) {
            log_message('error', 'Update error: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }


    public function submit_dokumen()
    {
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }

        try {
            $detail_mold = new DetailMold();
            $id = $this->request->getPost('id');
            $datamold = [];

            // Handle dokumen_mold (wajib)
            $dokumen_mold = $this->request->getFile('dokumen_mold');
            if ($dokumen_mold && $dokumen_mold->isValid() && !$dokumen_mold->hasMoved()) {
                $dokumenmold = $dokumen_mold->getRandomName();
                $dokumen_mold->move(ROOTPATH . 'public/uploads', $dokumenmold);
                $datamold['dokumen_mold'] = $dokumenmold;
            } else {
                return $this->response->setJSON(['error' => 'Dokumen Mold 1 is required and must be a valid file.']);
            }

            // Handle dokumen_mold2 (opsional)
            $dokumen_mold2 = $this->request->getFile('dokumen_mold2');
            if ($dokumen_mold2 && $dokumen_mold2->isValid() && !$dokumen_mold2->hasMoved()) {
                $dokumenmold2 = $dokumen_mold2->getRandomName();
                $dokumen_mold2->move(ROOTPATH . 'public/uploads', $dokumenmold2);
                $datamold['dokumen_mold2'] = $dokumenmold2;
            }

            // Handle dokumen_mold3 (opsional)
            $dokumen_mold3 = $this->request->getFile('dokumen_mold3');
            if ($dokumen_mold3 && $dokumen_mold3->isValid() && !$dokumen_mold3->hasMoved()) {
                $dokumenmold3 = $dokumen_mold3->getRandomName();
                $dokumen_mold3->move(ROOTPATH . 'public/uploads', $dokumenmold3);
                $datamold['dokumen_mold3'] = $dokumenmold3;
            }

            // Update data jika dokumen_mold (wajib) sudah terisi
            $detail_mold->update($id, $datamold);
            return $this->response->setJSON(['message' => 'Data updated successfully!']);
        } catch (\Exception $e) {
            log_message('error', 'Update error: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function update_dokumen()
    {
        try {
            $id_dokumen = $this->request->getPost('id');

            // Ambil data lama dari database
            $model = new DetailMold();
            $existingData = $model->find($id_dokumen);


            // Handle file uploads
            $dokumen_mold = $this->request->getFile('dokumen_mold');
            $dokumen_mold2 = $this->request->getFile('dokumen_mold2');
            $dokumen_mold3 = $this->request->getFile('dokumen_mold3');
            // Hapus gambar diperbaiki lama jika ada file baru yang diupload
            if ($dokumen_mold && $dokumen_mold->isValid()) {
                if (!empty($existingData['dokumen_mold']) && file_exists(ROOTPATH . 'public/uploads/' . $existingData['dokumen_mold'])) {
                    unlink(ROOTPATH . 'public/uploads/' . $existingData['dokumen_mold']); // Hapus file lama
                }
                $dokumen_moldname = $dokumen_mold->getRandomName();
                $dokumen_mold->move(ROOTPATH . 'public/uploads', $dokumen_moldname);
            } else {
                return $this->response->setJSON(['error' => 'Dokumen Mold 1 harus diisi']);
            }

            if ($dokumen_mold2 && $dokumen_mold2->isValid()) {
                if (!empty($existingData['dokumen_mold2']) && file_exists(ROOTPATH . 'public/uploads/' . $existingData['dokumen_mold2'])) {
                    unlink(ROOTPATH . 'public/uploads/' . $existingData['dokumen_mold2']); // Hapus file lama
                }
                $dokumen_mold2name = $dokumen_mold2->getRandomName();
                $dokumen_mold2->move(ROOTPATH . 'public/uploads', $dokumen_mold2name);
            } else {
                return $this->response->setJSON(['error' => 'Dokumen Mold 2 harus diisi']);
            }

            if ($dokumen_mold3 && $dokumen_mold3->isValid()) {
                if (!empty($existingData['dokumen_mold3']) && file_exists(ROOTPATH . 'public/uploads/' . $existingData['dokumen_mold3'])) {
                    unlink(ROOTPATH . 'public/uploads/' . $existingData['dokumen_mold3']); // Hapus file lama
                }
                $dokumen_mold3name = $dokumen_mold3->getRandomName();
                $dokumen_mold3->move(ROOTPATH . 'public/uploads', $dokumen_mold3name);
            } else {
                return $this->response->setJSON(['error' => 'Dokumen Mold 3 harus diisi']);
            }


            $data = [
                'dokumen_mold' => $dokumen_moldname,
                'dokumen_mold2' => $dokumen_mold2name,
                'dokumen_mold3' => $dokumen_mold3name,
            ];

            // Update the database
            $model->update($id_dokumen, $data);
            return $this->response->setJSON(['message' => 'Data updated successfully!']);
        } catch (\Exception $e) {
            log_message('error', 'Update error: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function suplier_cbi()
    {
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }
        $user = new UserModel();
        $GetUser = $user->getUser();
        $dataUser['data'] = $GetUser;
        return view('pages/admin/dashboard/suplier', $dataUser);
    }
    public function detail_suplier_cbi()
    {
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }
        $moldItem = new MoldItemModel();
        $user = new UserModel();
        $supplierId = $this->request->getGet('supplier');
        if ($supplierId) {
            $data['data_profil'] = $user->getUserByUsername($supplierId);
            $data['data_mold'] = $moldItem->getItemBySupplier($supplierId);
        }

        return view('pages/admin/dashboard/detail_suplier', $data);
    }
    public function updateAddressSupplier()
    {
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }
        $userModel = new UserModel();
        $address = $this->request->getPost('address');
        $supplier = $this->request->getPost('supplier');
        $username = $this->request->getPost('username'); // Pastikan username dikirim dari form
        // Update password di database berdasarkan username
        $userModel->where('username', $username)
            ->set('suplier', $supplier)
            ->set('address', $address)
            ->update();

        // Kembalikan notifikasi sukses
        return redirect()->to(base_url("detail/suplier?supplier=" . urlencode((string)$supplier)))
        ->with('success', 'Data updated successfully.');
    }

    public function deleteAccount()
    {
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        // Hapus akun berdasarkan session user_id
        $userModel->where('username', $username)
            ->delete();
        return redirect()->to(base_url("suplier/cbi"))->with('status', 'Account deleted successfully!');
    }

    public function changePassword()
    {
        if (!session()->has('admin_nama')) {
            return $this->redirectLogin();
        }
        // Mendapatkan data dari form
        $username = $this->request->getPost('username');
        $suplier = $this->request->getPost('suplier');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validasi jika password baru dan konfirmasi password cocok
        if (
            $newPassword !== $confirmPassword
        ) {
            // Password tidak sama, kembalikan error
            return redirect()->back()->with('error', 'New password and confirmation do not match.');
        }

        // Hash password baru
        $hashedPassword = password_hash((string)$newPassword, PASSWORD_DEFAULT);

        // Load model user
        $userModel = new UserModel();

        // Update password di database berdasarkan username
        $userModel->where('username', $username)
            ->set('password', $hashedPassword)
            ->update();

        // Kembalikan notifikasi sukses
        return redirect()->to(base_url("detail/suplier?supplier=" . urlencode((string)$suplier)))
        ->with('success', 'Password updated successfully.');
      
    }
}
