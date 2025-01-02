<?php

namespace App\Controllers;

use App\Models\JenisPerbaikanModel;
use App\Models\ReportModel;
use App\Models\MoldItemModel;
use App\Models\SupplierModel;
use App\Models\TransaksiJumlahProduk;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\Exceptions\PageNotFoundException;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    //report excel fitur
    public function downloadTemplate()
    {
        $supplierModel = new SupplierModel();
        $moldItemModel = new MoldItemModel();
        $userSupplier = session()->get('user_suplier'); // Ambil suplier dari sesi pengguna

        if (!$userSupplier) {
            return redirect()->to('/dashboard')->with('error', 'Suplier tidak ditemukan.');
        }

        // Ambil mold_name berdasarkan suplier pengguna
        $molds = $supplierModel->where('suplier', $userSupplier)->findAll();

        if (!$molds) {
            return redirect()->to('/dashboard')->with('error', 'Tidak ada mold untuk suplier ini.');
        }

        // Ambil mold yang aktif dari MoldItemModel berdasarkan mold_name dan STATUS = 'aktif'
        $activeMolds = [];
        foreach ($molds as $mold) {
            $item = $moldItemModel->where('ITEM', $mold['mold_name'])->where('STATUS', 'ACTIVE')->first();
            if ($item) {
                $activeMolds[] = $item['ITEM'];
                $idMolds[] = $item['NO'];
            }
        }

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $headers = [
            'A' => 'Nama Mold',
            'B' => 'Jumlah OK',
            'C' => 'Material',
            'D' => 'Problem Harian',
            'E' => 'Setup Mesin',
            'F' => 'Cuci Barel',
            'G' => 'Cuci Mold',
            'H' => 'Unfil',
            'I' => 'Bubble',
            'J' => 'Crack',
            'K' => 'Blackdot',
            'L' => 'Undercut',
            'M' => 'Belang',
            'N' => 'Scratch',
            'O' => 'Ejector Mark',
            'P' => 'Flashing',
            'Q' => 'Bending',
            'R' => 'Weldline',
            'S' => 'Sinkmark',
            'T' => 'Silver',
            'U' => 'Flow Material',
            'V' => 'Bushing',
            'W' => 'Overcut',
            'X' => 'Dirty',
            'Y' => 'Watermark'
            // 'W' => 'id mold',
        ];

        foreach ($headers as $column => $header) {
            $sheet->setCellValue($column . '1', $header);
        }

        // Isi data nama mold yang aktif
        $row = 2; // Mulai dari baris kedua
        foreach ($activeMolds as $moldName) {
            $sheet->setCellValue('A' . $row, $moldName); // Nama mold aktif
            $row++;
        }
        // $rowid_mold =2;
        // foreach ($idMolds as $idmold) {
        //     $sheet->setCellValue('W' . $rowid_mold, $idmold); // Nama mold aktif
        //     $rowid_mold++;
        // }

        // Set auto-size untuk semua kolom
        foreach (array_keys($headers) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Simpan file Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Template_Laporan_Mold.xlsx';

        // Unduh file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }


    public function uploadExcel()
    {
        $reportModel = new ReportModel();
        $supplierModel = new SupplierModel();

        // Ambil data suplier dari sesi
        $userSuplier = session()->get('user_suplier');

        if ($this->request->getFile('excel_file')->isValid()) {
            $file = $this->request->getFile('excel_file');

            try {
                $spreadsheet = IOFactory::load($file->getTempName());
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray();

                if (count($rows) > 1) {
                    for ($i = 1; $i < count($rows); $i++) {
                        $row = $rows[$i];

                        if (!empty($row[0])) {
                            $nama_mold = $row[0];

                            // Cari suplier berdasarkan mold_name
                            $supplier = $supplierModel->where('mold_name', $nama_mold)->first();

                            if (!$supplier) {
                                return $this->response->setJSON([
                                    'status' => 'error',
                                    'message' => "Mold dengan nama '$nama_mold' tidak ditemukan."
                                ])->setStatusCode(400);
                            }

                            // Validasi apakah suplier sesuai dengan sesi pengguna
                            if ($supplier['suplier'] !== $userSuplier) {
                                return $this->response->setJSON([
                                    'status' => 'error',
                                    'message' => "Mold '$nama_mold' tidak sesuai dengan suplier Anda."
                                ])->setStatusCode(403);
                            }

                            $id_mold = $supplier['id_mold'] ?? null;

                            // Hitung jumlah_ng sebagai total semua nilai kolom terkait
                            $jumlah_ng =
                                ($row[4] ?? 0) + ($row[5] ?? 0) + ($row[6] ?? 0) +
                                ($row[7] ?? 0) + ($row[8] ?? 0) + ($row[9] ?? 0) +
                                ($row[10] ?? 0) + ($row[11] ?? 0) + ($row[12] ?? 0) +
                                ($row[13] ?? 0) + ($row[14] ?? 0) + ($row[15] ?? 0) +
                                ($row[16] ?? 0) + ($row[17] ?? 0) + ($row[18] ?? 0) +
                                ($row[19] ?? 0) + ($row[20] ?? 0) + ($row[21] ?? 0);

                            $jumlah_ok = $row[1] ?? 0;

                            $data = [
                                'id_mold'        => $id_mold,
                                'nama_mold'      => $nama_mold,
                                'jumlah_ok'      => $jumlah_ok,
                                'jumlah_ng'      => $jumlah_ng,
                                'material'       => $row[2] ?? '',
                                'problem_harian' => $row[3] ?? '',
                                'setup_mesin'    => $row[4] ?? 0,
                                'cuci_barel'     => $row[5] ?? 0,
                                'cuci_mold'      => $row[6] ?? 0,
                                'unfil'          => $row[7] ?? 0,
                                'bubble'         => $row[8] ?? 0,
                                'crack'          => $row[9] ?? 0,
                                'blackdot'       => $row[10] ?? 0,
                                'undercut'       => $row[11] ?? 0,
                                'belang'         => $row[12] ?? 0,
                                'scratch'        => $row[13] ?? 0,
                                'ejector_mark'   => $row[14] ?? 0,
                                'flashing'       => $row[15] ?? 0,
                                'bending'        => $row[16] ?? 0,
                                'weldline'       => $row[17] ?? 0,
                                'sinkmark'       => $row[18] ?? 0,
                                'silver'         => $row[19] ?? 0,
                                'flow_material'  => $row[20] ?? 0,
                                'bushing'        => $row[21] ?? 0,
                                'overcut'        => $row[22] ?? 0,
                                'dirty'          => $row[23] ?? 0,
                                'watermark'      => $row[24] ?? 0,
                                'user_id'        => session()->get('user_id'),
                                'tanggal_pengajuan' => date('Y-m-d'),
                            ];

                            $reportModel->insert($data);

                            if ($id_mold) {
                                $currentJumlahProduk = $supplier['jumlah_produk'] ?? 0;
                                $newJumlahProduk = $currentJumlahProduk + $jumlah_ok;

                                $supplierModel->update($supplier['id'], [
                                    'jumlah_produk' => $newJumlahProduk
                                ]);
                            }
                        }
                    }

                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'Data berhasil diunggah.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'File Excel kosong.'
                    ])->setStatusCode(400);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal memproses file Excel.'
                ])->setStatusCode(500);
            }
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal mengunggah file.'
            ])->setStatusCode(400);
        }
    }




}
