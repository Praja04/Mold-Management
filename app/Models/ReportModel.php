<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table            = 'report_daily';
    protected $primaryKey       = 'id';

    protected $allowedFields = [
        'user_id',
        'id_mold',
        'nama_mold',
        'jumlah_ok',
        'jumlah_ng',
        'material',
        'tanggal_pengajuan',
        'created_at',
        'is_seen',
        'setup_mesin',
        'cuci_barel',
        'cuci_mold',
        'unfil',
        'bubble',
        'crack',
        'blackdot',
        'undercut',
        'belang',
        'scratch',
        'ejector_mark',
        'flashing',
        'bending',
        'weldline',
        'sinkmark',
        'silver',
        'flow_material',
        'bushing',
        'problem_harian',
        'created_at'
    ];

    public function getMoldDataWithSupplier($nama_mold)
    {
        return $this->select('report_daily.*, users.suplier')
        ->join('users', 'users.id = report_daily.user_id')
        ->where('report_daily.nama_mold', $nama_mold)
            ->orderBy('report_daily.created_at', 'DESC')
            ->findAll();
    }

    public function existsTodayReport($namaMold)
    {
        $today = date('Y-m-d'); // Ambil tanggal hari ini
        $query = $this->db->query("
        SELECT COALESCE(SUM(jumlah_ok), 0) as total_jumlah_ok
        FROM report_daily
        WHERE nama_mold = ? AND CONVERT(date, tanggal_pengajuan) = ?
    ", [$namaMold, $today]);

        $result = $query->getRow();
        return $result ? (int) $result->total_jumlah_ok : 0; // Kembalikan jumlah_ok hari ini atau 0 jika tidak ada
    }



    public function getUserCategoryTotals()
    {
        // Get the current month and year
        $currentMonth = date('m');
        $currentYear = date('Y');

        $builder = $this->db->table('report_daily');
        $builder->select('users.suplier, 
                          MONTH(report_daily.tanggal_pengajuan) as bulan, 
                          YEAR(report_daily.tanggal_pengajuan) as tahun, 
                          SUM(report_daily.jumlah_ng) as total_jumlah_ng');
        $builder->join('users', 'users.id = report_daily.user_id');
        // $builder->where('MONTH(report_daily.tanggal_pengajuan)', $currentMonth);
        // $builder->where('YEAR(report_daily.tanggal_pengajuan)', $currentYear);
        // Use full expressions in GROUP BY for SQL Server
        $builder->groupBy('users.suplier, 
                           MONTH(report_daily.tanggal_pengajuan), 
                           YEAR(report_daily.tanggal_pengajuan)');

        return $builder->get()->getResultArray();
    }
    public function getTotalByMold()
    {
        return $this->select('
            nama_mold, 
            YEAR(tanggal_pengajuan) as year, 
            MONTH(tanggal_pengajuan) as month,
            SUM(jumlah_ok) as total_ok, 
            SUM(jumlah_ng) as total_ng, 
            (SUM(jumlah_ok) + SUM(jumlah_ng)) as total')
        ->groupBy('nama_mold, YEAR(tanggal_pengajuan), MONTH(tanggal_pengajuan)')
        ->findAll();
    }



    public function getReportsByMoldName($moldName)
    {
        return $this->where('nama_mold', $moldName)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function countisSeen()
    {

        $builder = $this->db->table($this->table)
            ->select('SUM(CASE WHEN is_seen = \'no\' THEN 1 ELSE 0 END) AS is_seen_0')
            ->select('SUM(CASE WHEN is_seen = \'yes\' THEN 1 ELSE 0 END) AS is_seen_1');

        return $builder->get()->getRowArray();
    }

    public function countDataPerUser()
    {
        $builder = $this->db->table('users u')
            ->select('u.id AS user_id, 
              COUNT(CASE WHEN pd.is_seen = \'no\' THEN 1 END) AS total_data_no, 
              COUNT(CASE WHEN pd.is_seen = \'yes\' THEN 1 END) AS total_data_yes')
            ->join('report_daily pd', 'u.id = pd.user_id', 'left')
            ->groupBy('u.id')
            ->orderBy('total_data_no', 'DESC');


        return $builder->get()->getResultArray();
    }


    public function countHasilVerifikasiByItem($item)
    {
        $query = $this->select('report_daily.is_seen')
            ->join('mold_item', 'report_daily.nama_mold = mold_item.ITEM', 'left')
            ->where('mold_item.ITEM', $item)
            ->where('report_daily.is_seen', 'no')
            ->countAllResults();

        $countYes = $this->select('report_daily.is_seen')
            ->join('mold_item', 'report_daily.nama_mold = mold_item.ITEM', 'left')
            ->where('mold_item.ITEM', $item)
            ->where('report_daily.is_seen', 'yes')
            ->countAllResults();

        return [
            'count_no' => $query,
            'count_yes' => $countYes
        ];
    }


    public function updateAllIsSeen($ids)
    {
        // Validate that $ids is an array and not empty
        if (!is_array($ids) || empty($ids)) {
            return false;
        }

        // Ensure IDs are integers
        $ids = array_map('intval', $ids);

        // Perform the update operation
        return $this->set('is_seen', 'yes')
            ->whereIn('id', $ids)
            ->update();
    }
    public function getakumulasishotperITEM($nama_mold)
    {
        $builder = $this->db->table($this->table);
        $builder->select('nama_mold, SUM(jumlah_ok) as total_ok, SUM(jumlah_ng) as total_ng')
            ->where('nama_mold', $nama_mold)
            ->groupBy('nama_mold')
            ->orderBy('nama_mold'); // Pastikan kolom yang digunakan dalam ORDER BY juga ada dalam GROUP BY
        return $builder->get()->getFirstRow();
    }

    public function getpengajuanUser($user_id)
    {
        return $this->select('report_daily.*')
            ->where('user_id', $user_id)
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->findAll();
    }

    public function getTotalCounts()
    {
        return $this->db->table($this->table)
            ->select('
                COALESCE(SUM(setup_mesin), 0) AS total_setup_mesin,
                COALESCE(SUM(cuci_barel), 0) AS total_cuci_barel,
                COALESCE(SUM(cuci_mold), 0) AS total_cuci_mold,
                COALESCE(SUM(unfil), 0) AS total_unfil,
                COALESCE(SUM(bubble), 0) AS total_bubble,
                COALESCE(SUM(crack), 0) AS total_crack,
                COALESCE(SUM(blackdot), 0) AS total_blackdot,
                COALESCE(SUM(undercut), 0) AS total_undercut,
                COALESCE(SUM(belang), 0) AS total_belang,
                COALESCE(SUM(scratch), 0) AS total_scratch,
                COALESCE(SUM(ejector_mark), 0) AS total_ejector_mark,
                COALESCE(SUM(flashing), 0) AS total_flashing,
                COALESCE(SUM(bending), 0) AS total_bending,
                COALESCE(SUM(weldline), 0) AS total_weldline,
                COALESCE(SUM(sinkmark), 0) AS total_sinkmark,
                COALESCE(SUM(silver), 0) AS total_silver,
                COALESCE(SUM(flow_material), 0) AS total_flow_material,
                COALESCE(SUM(bushing), 0) AS total_bushing
            ')
            ->get()
            ->getRowArray();
    }

    public function countDailyReportsByMold($nama_mold)
    {
        return $this->where('nama_mold', $nama_mold)
            ->where('problem_harian !=', '-')
            ->countAllResults();
    }

    public function getNGByMoldName($moldName)
    {
        return $this->select('setup_mesin,cuci_barel,cuci_mold,unfil,bubble,crack,blackdot,undercut,belang,scratch,ejector_mark,flashing,bending,weldline,sinkmark,silver,flow_material,bushing')
            ->where('nama_mold', $moldName)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
}
