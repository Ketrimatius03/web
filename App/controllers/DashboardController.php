<?php

class DashboardController extends Controller
{
    /**
     * Redirect otomatis sesuai role user
     */
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        if ($_SESSION['user']['role'] === 'admin') {
            header('Location: ' . BASEURL . '/dashboard/admin');
        } else {
            header('Location: ' . BASEURL . '/dashboard/petugas');
        }
        exit;
    }

    /**
     * ==========================
     * DASHBOARD ADMIN
     * ==========================
     */
  public function admin()
{
    $this->auth('admin');

    $master = $this->model('Master');

    // AMBIL DATA STATUS
    $status = $master->countByStatus();

    // DEFAULT NILAI (WAJIB)
    $laporanMasuk = 0;
    $dalamProses  = 0;
    $selesai      = 0;
    $diarsipkan   = 0;

    foreach ($status as $s) {
        switch ($s['status_laporan']) {
            case 'Diajukan':
                $laporanMasuk = $s['total'];
                break;
            case 'Proses':
                $dalamProses = $s['total'];
                break;
            case 'Selesai':
                $selesai = $s['total'];
                break;
            case 'Arsip':
                $diarsipkan = $s['total'];
                break;
        }
    }

    // DATA CHART
    $chartData = $master->laporan7Hari();
    $hari = [];
    $dataLaporan = [];

    foreach ($chartData as $row) {
        $hari[] = date('d M', strtotime($row['hari']));
        $dataLaporan[] = $row['total'];
    }

    // KIRIM KE VIEW (SESUAI admin.php)
    $this->view('dashboard/admin', [
        'laporanMasuk' => $laporanMasuk,
        'dalamProses'  => $dalamProses,
        'selesai'      => $selesai,
        'diarsipkan'   => $diarsipkan,
        'hari'         => $hari,
        'dataLaporan'  => $dataLaporan
    ]);
}


    /**
     * ==========================
     * DASHBOARD PETUGAS / USER
     * ==========================
     */
    public function petugas()
{
    $this->auth('user');

    $userId = $_SESSION['user']['id'];

    // LAPORAN TERAKHIR USER
    $laporanTerakhir = $this->model('LaporanModel')
                            ->getLatestByUser($userId);

    // STATISTIK USER
    $master = $this->model('Master');
    $total  = $master->countByUser($userId);
    $status = $master->countByStatusUser($userId);

    // ⬇️ SESUAIKAN DENGAN STATUS ASLI DI DATABASE
    $stat = [
        'Diajukan'      => 0,
        'Proses'  => 0,
        'Selesai'       => 0
    ];

    foreach ($status as $s) {
        if (isset($stat[$s['status_laporan']])) {
            $stat[$s['status_laporan']] = $s['total'];
        }
    }

    $this->view('dashboard/petugas', [
        'total_laporan'   => $total['total'],
        'diproses'        => $stat['Proses'], 
        'selesai'         => $stat['Selesai'],
        'laporanTerakhir' => $laporanTerakhir
    ]);
}

    /**
     * ==========================
     * LOGOUT
     * ==========================
     */
    public function logout()
    {
        session_destroy();
        header('Location: ' . BASEURL . '/auth/login');
        exit;
    }

    // LAPORAN MASUK ADMIN
public function laporanMasuk()
{
    $this->auth('admin');

    $laporan = $this->model('LaporanModel')->getByStatus('Diajukan');

    $this->view('admin/laporan/masuk', [
        'laporan' => $laporan
    ]);
}

}
