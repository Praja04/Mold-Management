<?php

namespace App\Controllers;

use App\Models\JenisPerbaikanModel;
use App\Models\ReportModel;
use App\Models\MoldItemModel;
use App\Models\SupplierModel;
use App\Models\TransaksiJumlahProduk;

use CodeIgniter\Exceptions\PageNotFoundException;


class ReportDaily extends BaseController
{
    protected $jenisperbaikan;
    protected $reportPerbaikan;
    protected $moldTotalProduk;
    protected $transaksiProduk;

    public function __construct()
    {
        $this->jenisperbaikan = new JenisPerbaikanModel();
        $this->reportPerbaikan = new ReportModel();
        $this->moldTotalProduk = new SupplierModel();
        $this->transaksiProduk = new TransaksiJumlahProduk();
    }

    public function index()
    {
        if (!session()->has('user_nama')) {
            session()->setFlashdata('error', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $item = $this->request->getGet('item');
        $id = $this->request->getGet('id');
        return view('pages/user/report/report_daily', ['item' => $item, 'id' => $id]);
    }

    public function getJenisPerbaikan()
    {
        $item = $this->jenisperbaikan->getjenisperbaikan();
        return $this->response->setJSON($item);
    }

    public function submit_report()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        $userID = session()->get('user_id');

        try {
            // Ambil data dari request
            $setup_mesin = $this->request->getPost('setup_mesin') ?? 0;
            $cuci_barel = $this->request->getPost('cuci_barel') ?? 0;
            $cuci_mold = $this->request->getPost('cuci_mold') ?? 0;
            $unfil = $this->request->getPost('unfil') ?? 0;
            $bubble = $this->request->getPost('bubble') ?? 0;
            $crack = $this->request->getPost('crack') ?? 0;
            $blackdot = $this->request->getPost('blackdot') ?? 0;
            $undercut = $this->request->getPost('undercut') ?? 0;
            $belang = $this->request->getPost('belang') ?? 0;
            $scratch = $this->request->getPost('scratch') ?? 0;
            $ejector_mark = $this->request->getPost('ejector_mark') ?? 0;
            $flashing = $this->request->getPost('flashing') ?? 0;
            $bending = $this->request->getPost('bending') ?? 0;
            $weldline = $this->request->getPost('weldline') ?? 0;
            $sinkmark = $this->request->getPost('sinkmark') ?? 0;
            $silver = $this->request->getPost('silver') ?? 0;
            $flow_material = $this->request->getPost('flow_material') ?? 0;
            $bushing = $this->request->getPost('bushing') ?? 0;

            // Hitung jumlah_ng
            $jumlah_ng = $setup_mesin + $cuci_barel + $cuci_mold + $unfil + $bubble + $crack +
                $blackdot + $undercut + $belang + $scratch + $ejector_mark + $flashing +
                $bending + $weldline + $sinkmark + $silver + $flow_material + $bushing;

            $nama_mold = $this->request->getPost('nama_mold');
            $jumlah_ok = $this->request->getPost('jumlah_ok');

            $data = [
                'user_id' => $userID,
                'id_mold' => $this->request->getPost('moldId'),
                'nama_mold' => $nama_mold,
                'jumlah_ok' => $jumlah_ok,
                'material' => $this->request->getPost('material'),
                'tanggal_pengajuan' => $this->request->getPost('tanggal_report'),
                'problem_harian' => $this->request->getPost('problem_harian'),
                'setup_mesin' => $setup_mesin,
                'cuci_barel' => $cuci_barel,
                'cuci_mold' => $cuci_mold,
                'unfil' => $unfil,
                'bubble' => $bubble,
                'crack' => $crack,
                'blackdot' => $blackdot,
                'undercut' => $undercut,
                'belang' => $belang,
                'scratch' => $scratch,
                'ejector_mark' => $ejector_mark,
                'flashing' => $flashing,
                'bending' => $bending,
                'weldline' => $weldline,
                'sinkmark' => $sinkmark,
                'silver' => $silver,
                'flow_material' => $flow_material,
                'bushing' => $bushing,
                'jumlah_ng' => $jumlah_ng
            ];

            // Simpan data ke report_perbaikan
            $this->reportPerbaikan->save($data);

            // Perbarui atau buat entri di mold_total_produk
            $mold = $this->moldTotalProduk->where('mold_name', $nama_mold)->first();

            if ($mold) {
                // Jika entri sudah ada, tambahkan jumlah_ok ke total_produk
                $newTotal = $mold['jumlah_produk'] + $jumlah_ok;
                $this->moldTotalProduk->update($mold['id'], ['jumlah_produk' => $newTotal]);
            } else {
                // Jika entri belum ada, buat entri baru
                $this->moldTotalProduk->save([
                    'nama_mold' => $nama_mold,
                    'jumlah_produk' => $jumlah_ok
                ]);
            }

            return $this->response->setJSON(['message' => 'Data submitted successfully!']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Data yang anda masukan tidak valid !']);
        }
    }

    public function kirim_produk()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        $userID = session()->get('user_id');

        try {
            $nama_mold = $this->request->getPost('nama_mold');
            $jumlah_produk = $this->request->getPost('jumlah_produk');

            // Cek apakah mold dengan nama tersebut ada di database
            $mold = $this->moldTotalProduk->where('mold_name', $nama_mold)->first();

            if ($mold) {
                // Cek apakah jumlah produk mencukupi
                if ($mold['jumlah_produk'] >= $jumlah_produk) {
                    // Update jumlah produk 
                    $newTotal = $mold['jumlah_produk'] - $jumlah_produk;
                    $this->moldTotalProduk->update($mold['id'], ['jumlah_produk' => $newTotal]);

                    // Simpan data ke transaksi_produk
                    $data = [
                        'user_id' => $userID,
                        'nama_mold' => $nama_mold,
                        'jumlah_produk' => $jumlah_produk,
                        'tanggal' => date('Y-m-d H:i:s')
                    ];
                    $this->transaksiProduk->save($data);

                    return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil dimasukan!']);
                } else {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Jumlah produk tidak mencukupi!']);
                }
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Mold tidak ditemukan!']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data yang anda masukan tidak valid!']);
        }
    }



    public function showAccumulatedShots()
    {
        $data['accumulatedShots'] = $this->reportPerbaikan->getTotalByMold();

        return $this->response->setJSON($data);
    }
    public function showAccumulatereport()
    {
        $data['jumlah_report'] = $this->moldTotalProduk->getTotalReportByMold();

        return $this->response->setJSON($data);
    }

    public function list_mold_daily()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $supplierId = $this->request->getGet('supplier');
        if ($supplierId) {

            $data['data'] = $this->transaksiProduk->getItemsreportDaily($supplierId);
        }

        return view('pages/admin/perbaikan_daily/list_mold', $data);
    }

    public function manageis_seen()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $nama_mold = $this->request->getGet('namaMold');
        $moldData['nama_mold']=$nama_mold;
        $moldData['historymoldData'] = $this->reportPerbaikan->getMoldDataWithSupplier($nama_mold);
        return view('pages/admin/perbaikan_daily/perbaikan_detail', $moldData);
    }

    public function manageis_seen_no()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $nama_mold = $this->request->getGet('namaMold');
        // Lakukan query untuk mengambil data mold berdasarkan User_ID
        $moldData['moldData'] = $this->transaksiProduk->where('nama_mold', $nama_mold)
            ->where('is_seen', 'no')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('pages/admin/perbaikan_daily/pengiriman_no_seen', $moldData);
    }

    public function manageis_seen_yes()
    {
        if (session()->get('admin_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }
        $nama_mold = $this->request->getGet('namaMold');

        $moldData['historymoldData'] = $this->transaksiProduk->where('nama_mold', $nama_mold)
            ->where('is_seen', 'yes')
            ->orderBy('created_at', 'DESC')
            ->findAll();
        return view('pages/admin/perbaikan_daily/pengiriman_seen', $moldData);
    }



    public function updateIsSeen()
    {
        $id = $this->request->getPost('id');
        $is_seen = $this->request->getPost('is_seen');

        $data = [
            'is_seen' => $is_seen
        ];

        if ($this->transaksiProduk->update($id, $data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }

    public function update_all_is_seen()
    {
        // Ambil data ID yang dikirimkan melalui POST
        $ids = $this->request->getPost('ids');

        // Validasi input
        if (empty($ids) || !is_array($ids)) {
            return $this->response->setJSON(['success' => false, 'message' => 'No valid IDs provided']);
        }


        // Pastikan IDs adalah array dari integer
        $ids = array_map('intval', $ids);

        // Update status is_seen
        $result = $this->transaksiProduk->updateAllIsSeen($ids);

        // Kirim respons JSON
        if ($result) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }

    public function getQuantityPerJenis()
    {
        $reportModel = new ReportModel();
        $quantityPerJenis = $reportModel->getTotalCounts();

        // Mengembalikan data dalam format JSON
        return $this->response->setJSON(['data' => $quantityPerJenis]);
    }

    public function getReportMold()
    {
        $item = '';
        $data = $this->reportPerbaikan->getReportMold($item);
        return $this->response->setJSON(['data' => $data]);
    }

    public function getrejectionBySuplier()
    {
        $data['reject'] = $this->reportPerbaikan->getUserCategoryTotals();
        return $this->response->setJSON($data);
    }

    public function update_report($id)
    {
         if (session()->get('role') != 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete! You dont have access']);
        }
        $allowed_roles = ['admin'];
        $user_role = session()->get('role');
        if (!in_array($user_role, $allowed_roles)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tidak memiliki akses untuk mengubah ']);
        }

        // $userID = session()->get('user_id');

        try {
            // Ambil data lama dari report_perbaikan
            $oldReport = $this->reportPerbaikan->find($id);

            if (!$oldReport) {
                return $this->response->setJSON(['error' => 'Data tidak ditemukan!']);
            }

            // Ambil data dari request
            $setup_mesin = $this->request->getPost('setup_mesin') ?? 0;
            $cuci_barel = $this->request->getPost('cuci_barel') ?? 0;
            $cuci_mold = $this->request->getPost('cuci_mold') ?? 0;
            $unfil = $this->request->getPost('unfil') ?? 0;
            $bubble = $this->request->getPost('bubble') ?? 0;
            $crack = $this->request->getPost('crack') ?? 0;
            $blackdot = $this->request->getPost('blackdot') ?? 0;
            $undercut = $this->request->getPost('undercut') ?? 0;
            $belang = $this->request->getPost('belang') ?? 0;
            $scratch = $this->request->getPost('scratch') ?? 0;
            $ejector_mark = $this->request->getPost('ejector_mark') ?? 0;
            $flashing = $this->request->getPost('flashing') ?? 0;
            $bending = $this->request->getPost('bending') ?? 0;
            $weldline = $this->request->getPost('weldline') ?? 0;
            $sinkmark = $this->request->getPost('sinkmark') ?? 0;
            $silver = $this->request->getPost('silver') ?? 0;
            $flow_material = $this->request->getPost('flow_material') ?? 0;
            $bushing = $this->request->getPost('bushing') ?? 0;

            // Hitung jumlah_ng
            $jumlah_ng = $setup_mesin + $cuci_barel + $cuci_mold + $unfil + $bubble + $crack +
                $blackdot + $undercut + $belang + $scratch + $ejector_mark + $flashing +
                $bending + $weldline + $sinkmark + $silver + $flow_material + $bushing;

            $nama_mold = $this->request->getPost('nama_mold');
            $jumlah_ok = $this->request->getPost('jumlah_ok');

            // Update data di report_perbaikan
            $data = [
                // 'user_id' => $userID,
                'id_mold' => $this->request->getPost('moldId'),
                'nama_mold' => $nama_mold,
                'jumlah_ok' => $jumlah_ok,
                //'material' => $this->request->getPost('material'),
                //'tanggal_pengajuan' => $this->request->getPost('tanggal_report'),
                'problem_harian' => $this->request->getPost('problem_harian'),
                'setup_mesin' => $setup_mesin,
                'cuci_barel' => $cuci_barel,
                'cuci_mold' => $cuci_mold,
                'unfil' => $unfil,
                'bubble' => $bubble,
                'crack' => $crack,
                'blackdot' => $blackdot,
                'undercut' => $undercut,
                'belang' => $belang,
                'scratch' => $scratch,
                'ejector_mark' => $ejector_mark,
                'flashing' => $flashing,
                'bending' => $bending,
                'weldline' => $weldline,
                'sinkmark' => $sinkmark,
                'silver' => $silver,
                'flow_material' => $flow_material,
                'bushing' => $bushing,
                'jumlah_ng' => $jumlah_ng
            ];

            // Kurangi jumlah_ok lama dari mold_total_produk
            $mold = $this->moldTotalProduk->where('mold_name', $nama_mold)->first();

            if ($mold) {
                $newTotal = $mold['jumlah_produk'] - $oldReport['jumlah_ok'] + $jumlah_ok;
                $this->moldTotalProduk->update($mold['id'], ['jumlah_produk' => $newTotal]);
            }

            // Update report_perbaikan
            $this->reportPerbaikan->update($id, $data);

            return $this->response->setJSON(['message' => 'Data updated successfully!']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Data yang anda masukan tidak valid!']);
        }
    }
    public function delete_report($id)
    {
        if (session()->get('role') != 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete! You dont have access']);
        }

        // $userID = session()->get('user_id');

        try {
            // Ambil data lama dari report_perbaikan
            $oldReport = $this->reportPerbaikan->find($id);

            if (!$oldReport) {
                return $this->response->setJSON(['error' => 'Data tidak ditemukan!']);
            }

            $nama_mold = $oldReport['nama_mold'];
            // Kurangi jumlah_ok lama dari mold_total_produk
            $mold = $this->moldTotalProduk->where('mold_name', $nama_mold)->first();

            if ($mold) {
                $newTotal = $mold['jumlah_produk'] - $oldReport['jumlah_ok'];
                $this->moldTotalProduk->update($mold['id'], ['jumlah_produk' => $newTotal]);
            }

            // Update report_perbaikan
            $this->reportPerbaikan->delete($id);

            return $this->response->setJSON(['success' => true, 'message' => 'Data deleted successfully!']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete!']);
        }
    }
}
