<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AdminModel;
use App\Models\PerbaikanBesarModel;
use App\Models\short_akumulasiModel;
use App\Models\MoldItemModel;
use App\Models\SupplierModel;

class PerbaikanBesar extends BaseController
{

    public function showAccumulatePerbaikan()
    {
        $model = new SupplierModel();
        $data['jumlah_perbaikan'] = $model->getTotalPerbaikanByMold();

        return $this->response->setJSON($data);
    }
    public function getLatestData()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        $partName = $this->request->getGet('partName');
        $idMold = $this->request->getGet('id');

        $model = new PerbaikanBesarModel();
        $data = $model->getLatestData($partName, $idMold);

        return $this->response->setJSON($data);
    }

    public function submit_perbaikan()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        try {
            $perbaikan = new PerbaikanBesarModel();
            $admin = new AdminModel();
            $userID = session()->get('user_id');
            $gambar_rusak = $this->request->getFile('gambar_rusak');
            $nama_mold = $this->request->getPost('part_name');
            $kondisi_mold = $this->request->getPost('kondisi_perbaikan');
            $suplier = $this->request->getPost('suplier');
            $keterangan = $this->request->getPost('keterangan') ?? 0;
            // Check if the file is valid and has been uploaded
            if (!$gambar_rusak->isValid()) {
                throw new \RuntimeException($gambar_rusak->getErrorString() . '(' . $gambar_rusak->getError() . ')');
            }

            $gambar_rusak_name = $gambar_rusak->getRandomName();
            $gambar_rusak->move(ROOTPATH . 'public/uploads', $gambar_rusak_name);

            $data = [
                'user_id' => $userID,
                'id_mold' => $this->request->getPost('moldId'),
                'nama_mold' => $nama_mold,
                'suplier' => $suplier,
                'tanggal_pengajuan' => $this->request->getPost('tanggal_pengajuan'),
                'kondisi_mold' => $kondisi_mold,
                'keterangan' => $keterangan,
                'gambar_rusak' => $gambar_rusak_name
            ];

            $perbaikan->save($data);

            // Data untuk email
            $penerima = $admin->select('name, email')->findAll();
            $gambar_mold_rusak = 'https://portal3.incoe.astra.co.id/pce-mold-management/public/uploads/'. $gambar_rusak_name;
            // URL API untuk mengirim email
            $api_url = "https://portal2.incoe.astra.co.id/vendor_rating_infor/api/send_email_text";

            foreach ($penerima as $person) {
                $email_to = $person['email'];  // Mengambil email tiap admin
                $nama_person = $person['name'];  // Mengambil nama tiap admin

                // Subjek dan pesan email
                $email_subject = "Problem Mold CBI";
                $email_message = "Halo " . $nama_person . ",\n\n" .
                    "Kami menginformasikan bahwa ada kerusakan pada mold  " .  $nama_mold . ".\n" .
                    "suplier : " . $suplier . ".\n\n" .
                    "kondisi kerusakan mold : " . $kondisi_mold . ".\n\n" .
                    "keterangan kerusakan mold : " . $keterangan . ".\n\n" .
                    "gambar kerusakan mold : " .  $gambar_mold_rusak . ".\n\n" .
                    "Cek keadaan mold pada link berikut https://portal3.incoe.astra.co.id/pce-mold-management/public/report/perbaikan/besar\n" .
                    "Terima kasih,\n" . 
                    "from PCE";

                // Data yang akan dikirim ke API
                $post_data = [
                    'to' => $email_to,
                    'cc' => '', // Kosongkan CC
                    'subject' => $email_subject,
                    'message' => $email_message
                ];

                // Melakukan POST request ke API untuk setiap admin
                $ch = curl_init($api_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

                $response = curl_exec($ch);
                $error = curl_error($ch);
                curl_close($ch);

                // Cek apakah ada error dalam pengiriman email
                if ($error) {
                    return $this->response->setJSON(['error' => 'Gagal mengirim email ke ' . $email_to . ': ' . $error]);
                }
            }
            return $this->response->setJSON(['message' => 'Data submitted successfully!']);
        } catch (\Exception $e) {
            log_message('error', 'Error in submit_perbaikan: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Data yang anda masukan tidak valid !']);
        }
    }


    public function getPerbaikan($userID)
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        try {
            $perbaikan = new PerbaikanBesarModel();
            $data['data'] = $perbaikan->getPerbaikan($userID);
            $data['All_data'] = $perbaikan->getAllPerbaikan($userID);
            return view('pages/admin/perbaikan/perbaikan_user', $data);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function updateGambar()
    {
        // Cek apakah pengguna sudah login
        if (!session()->get('user_nama')) {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        try {
            // Inisialisasi model
            $perbaikan = new PerbaikanBesarModel();

            // Ambil data dari POST request
            $id_perbaikan = $this->request->getPost('id_perbaikan');
            $gambar_diperbaiki = $this->request->getFile('gambar_perbaikan');

            // Validasi file upload
            if ($gambar_diperbaiki && $gambar_diperbaiki->isValid() && !$gambar_diperbaiki->hasMoved()) {
                // Validasi ukuran dan tipe file
                $maxSize = 2 * 1024 * 1024; // 2MB
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                if ($gambar_diperbaiki->getSize() > $maxSize) {
                    return $this->response->setJSON(['error' => 'Ukuran file terlalu besar. Maksimal 2MB.']);
                }

                if (!in_array($gambar_diperbaiki->getMimeType(), $allowedTypes)) {
                    return $this->response->setJSON(['error' => 'Format file tidak didukung. Hanya JPEG, PNG, dan GIF.']);
                }

                // Generate nama file yang unik dan pindahkan file ke folder uploads
                $gambar_diperbaiki_name = $gambar_diperbaiki->getRandomName();
                $gambar_diperbaiki->move(ROOTPATH . 'public/uploads', $gambar_diperbaiki_name);

                // Update data di database
                $data = [
                    'gambar_diperbaiki' => $gambar_diperbaiki_name,
                    'status_perbaikan' => 1
                ];
                $perbaikan->update($id_perbaikan, $data);

                // Kirim respons sukses
                return $this->response->setJSON(['message' => 'Data berhasil diperbarui!']);
            } else {
                return $this->response->setJSON(['error' => 'Gagal mengunggah file.']);
            }
        } catch (\Exception $e) {
            // Log error dan kirim pesan kesalahan ke klien
            log_message('error', $e->getMessage());
            return $this->response->setJSON(['error' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }


    public function dataLogBook()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $user_id = session()->get('user_id');
        $model = new PerbaikanBesarModel();
        $data = $model->getAllLogbook($user_id);
        return $this->response->setJSON($data);
    }

    public function updateTerimaPerbaikan($moldID)
    {
        // Panggil model untuk melakukan update hasil verifikasi
        $perbaikan = new PerbaikanBesarModel();
        $data = [
            'terima_perbaikan' => 1 // Ubah hasil verifikasi menjadi 1 (true)
        ];
        $result = $perbaikan->update($moldID, $data);
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

    public function approved_perbaikan()
    {
        // if (session()->get('admin_nama') == '') {
        //     session()->setFlashdata('gagal', 'Anda belum login');
        //     return redirect()->to(base_url('/'));
        // }

        if (session()->get('role') != 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete! You dont have access']);
        }

        try {
            $perbaikanBesarModel = new PerbaikanBesarModel();
            $UserModel = new UserModel();

            $id_perbaikan = $this->request->getPost('id_perbaikan');
            $id_suplier = $this->request->getPost('user_id');
            $nama_mold = $this->request->getPost('nama_mold');
            $rencana_perbaikan = $this->request->getPost('rencana_perbaikan');

            $data = [
                'rencana_perbaikan' => $rencana_perbaikan,
                'terima_perbaikan' => 'yes'
            ];

            $perbaikanBesarModel->update($id_perbaikan, $data);

            $Emailsuplier = $UserModel->select('email')->where('id', $id_suplier)->first();

            if (is_null($Emailsuplier)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data sudah diperbarui namun notifikasi email tidak dikirim karena user belum mendaftarkan email.'
                ]);
            } else {
                $email_to = $Emailsuplier['email'];
                $email_subject = "Perbaikan Besar Mold " . $nama_mold;
                $email_message = "Halo,\n\nRencana perbaikan untuk mold " . $nama_mold . " telah diperbarui.\n\nRencana: " . $rencana_perbaikan;

                $api_url = "https://portal2.incoe.astra.co.id/vendor_rating_infor/api/send_email_text";
                $post_data = [
                    'to' => $email_to,
                    'cc' => '',
                    'subject' => $email_subject,
                    'message' => $email_message
                ];

                $ch = curl_init($api_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

                $response = curl_exec($ch);
                $error = curl_error($ch);
                curl_close($ch);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data sudah diperbarui dan email telah dikirim.'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'File upload error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Error: ' . $e->getMessage()]);
        }
    }


    public function verifikasi_perbaikan_user()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        try {
            $perbaikanBesarModel = new PerbaikanBesarModel();
            $id_perbaikan = $this->request->getPost('id_perbaikan');

            // Update kolom visit di database
            $data = ['visit' => 1];
            $perbaikanBesarModel->update($id_perbaikan, $data);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Kolom visit telah diperbarui.'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Update visit error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    public function verifikasi_perbaikan_admin()
    {
        // if (session()->get('admin_nama') == '') {
        //     session()->setFlashdata('gagal', 'Anda belum login');
        //     return redirect()->to(base_url('/'));
        // }
        if (session()->get('role') != 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete! You dont have access']);
        }
        try {
            $perbaikanBesarModel = new PerbaikanBesarModel();
            $id_perbaikan = $this->request->getPost('id_perbaikan');

            // Update kolom visit di database
            $data = ['visit' => 1];
            $perbaikanBesarModel->update($id_perbaikan, $data);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Kolom visit telah diperbarui.'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Update visit error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    public function upload_perbaikan_admin()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }


        try {
            // Inisialisasi model
            $perbaikan = new PerbaikanBesarModel();

            // Ambil data dari POST request
            $id_perbaikan = $this->request->getPost('id_perbaikan');
            $gambar_diperbaiki = $this->request->getFile('gambar_diperbaiki');

            // Validasi file upload
            if ($gambar_diperbaiki && $gambar_diperbaiki->isValid() && !$gambar_diperbaiki->hasMoved()) {
                // Validasi ukuran dan tipe file
                $maxSize = 10 * 1024 * 1024; // 10MB
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                if ($gambar_diperbaiki->getSize() > $maxSize) {
                    return $this->response->setJSON(['error' => 'Ukuran file terlalu besar. Maksimal 2MB.']);
                }

                if (!in_array($gambar_diperbaiki->getMimeType(), $allowedTypes)) {
                    return $this->response->setJSON(['error' => 'Format file tidak didukung. Hanya JPEG, PNG, dan GIF.']);
                }

                // Generate nama file yang unik dan pindahkan file ke folder uploads
                $gambar_diperbaiki_name = $gambar_diperbaiki->getRandomName();
                $gambar_diperbaiki->move(ROOTPATH . 'public/uploads', $gambar_diperbaiki_name);

                // Update data di database
                $data = [
                    'gambar_diperbaiki' => $gambar_diperbaiki_name,
                ];
                $perbaikan->update($id_perbaikan, $data);

                // Kirim respons sukses
                return $this->response->setJSON(['message' => 'Data berhasil diperbarui!']);
            } else {
                return $this->response->setJSON(['error' => 'Gagal mengunggah file.']);
            }
        } catch (\Exception $e) {
            // Log error dan kirim pesan kesalahan ke klien
            log_message('error', $e->getMessage());
            return $this->response->setJSON(['error' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }
    public function upload_perbaikan_user()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        try {
            // Inisialisasi model
            $perbaikan = new PerbaikanBesarModel();

            // Ambil data dari POST request
            $id_perbaikan = $this->request->getPost('id_perbaikan');
            $gambar_diperbaiki = $this->request->getFile('gambar_diperbaiki');

            // Validasi file upload
            if ($gambar_diperbaiki && $gambar_diperbaiki->isValid() && !$gambar_diperbaiki->hasMoved()) {
                // Validasi ukuran dan tipe file
                $maxSize = 10 * 1024 * 1024; // 10MB
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                if ($gambar_diperbaiki->getSize() > $maxSize) {
                    return $this->response->setJSON(['error' => 'Ukuran file terlalu besar. Maksimal 2MB.']);
                }

                if (!in_array($gambar_diperbaiki->getMimeType(), $allowedTypes)) {
                    return $this->response->setJSON(['error' => 'Format file tidak didukung. Hanya JPEG, PNG, dan GIF.']);
                }

                // Generate nama file yang unik dan pindahkan file ke folder uploads
                $gambar_diperbaiki_name = $gambar_diperbaiki->getRandomName();
                $gambar_diperbaiki->move(ROOTPATH . 'public/uploads', $gambar_diperbaiki_name);

                // Update data di database
                $data = [
                    'gambar_diperbaiki' => $gambar_diperbaiki_name,
                ];
                $perbaikan->update($id_perbaikan, $data);

                // Kirim respons sukses
                return $this->response->setJSON(['message' => 'Data berhasil diperbarui!']);
            } else {
                return $this->response->setJSON(['error' => 'Gagal mengunggah file.']);
            }
        } catch (\Exception $e) {
            // Log error dan kirim pesan kesalahan ke klien
            log_message('error', $e->getMessage());
            return $this->response->setJSON(['error' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }
    public function upload_dokumen_admin()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        try {
            // Inisialisasi model
            $perbaikan = new PerbaikanBesarModel();

            // Ambil data dari POST request
            $id_perbaikan = $this->request->getPost('id_perbaikan');
            $dokumen_pendukung = $this->request->getFile('dokumen_pendukung');

            // Validasi file upload
            if ($dokumen_pendukung && $dokumen_pendukung->isValid() && !$dokumen_pendukung->hasMoved()) {
                // Validasi ukuran dan tipe file
                $maxSize = 10 * 1024 * 1024; // Maksimal ukuran file 10MB
                $allowedTypes = ['application/pdf']; // Hanya izinkan file PDF

                // Cek ukuran file
                if ($dokumen_pendukung->getSize() > $maxSize) {
                    return $this->response->setJSON(['success' => false, 'error' => 'Ukuran file terlalu besar. Maksimal 10MB.']);
                }

                // Cek tipe file
                if (!in_array($dokumen_pendukung->getMimeType(), $allowedTypes)) {
                    return $this->response->setJSON(['success' => false, 'error' => 'Format file tidak didukung. Hanya file PDF yang diizinkan.']);
                }

                // Generate nama file yang unik dan pindahkan file ke folder uploads
                $dokumen_pendukung_name = $dokumen_pendukung->getRandomName();
                $dokumen_pendukung->move(ROOTPATH . 'public/uploads', $dokumen_pendukung_name);

                // Update data di database
                $data = [
                    'dokumen_pendukung' => $dokumen_pendukung_name,
                ];
                $perbaikan->update($id_perbaikan, $data);

                // Kirim respons sukses
                return $this->response->setJSON(['success' => true, 'message' => 'Dokumen berhasil diunggah dan data diperbarui.']);
            } else {
                // Kirim pesan error jika file tidak valid atau gagal diunggah
                return $this->response->setJSON(['success' => false, 'error' => 'Gagal mengunggah file.']);
            }
        } catch (\Exception $e) {
            // Log error dan kirim pesan kesalahan ke klien
            log_message('error', $e->getMessage());
            return $this->response->setJSON(['success' => false, 'error' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    public function status_temporary_admin()
    {
        // if (session()->get('admin_nama') == '') {
        //     session()->setFlashdata('gagal', 'Anda belum login');
        //     return redirect()->to(base_url('/'));
        // }

        if (session()->get('role') != 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete! You dont have access']);
        }
        try {
            $perbaikanBesarModel = new PerbaikanBesarModel();
            $id_perbaikan = $this->request->getPost('id_perbaikan');

            // Update kolom visit di database
            $data = [
                'permanen' => 'no',
                'temporary' => 'yes'
            ];
            $perbaikanBesarModel->update($id_perbaikan, $data);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status Diperbarui.'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Update status perbaikan error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    public function status_permanen_admin()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }


        try {
            $perbaikanBesarModel = new PerbaikanBesarModel();
            $id_perbaikan = $this->request->getPost('id_perbaikan');

            // Update kolom visit di database
            $data = [
                'permanen' => 'yes',
                'temporary' => 'no'
            ];
            $perbaikanBesarModel->update($id_perbaikan, $data);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status Diperbarui.'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Update status perbaikan error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
