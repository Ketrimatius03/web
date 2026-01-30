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

    // STAT KARTU
    $total  = $master->countAll();
    $status = $master->countByStatus();

    $stat = [
        'Diajukan' => 0,
        'Diproses' => 0,
        'Selesai'  => 0
    ];

    foreach ($status as $s) {
        $stat[$s['status_laporan']] = $s['total'];
    }

    // DATA CHART 7 HARI TERAKHIR
    $chartData = $master->laporan7Hari();
    $hari = [];
    $dataLaporan = [];

    foreach ($chartData as $row) {
        $hari[] = date('d M', strtotime($row['hari']));
        $dataLaporan[] = $row['total'];
    }

    $this->view('dashboard/admin', [
        'total'        => $total['total'],
        'stat'         => $stat,
        'hari'         => $hari,
        'dataLaporan'  => $dataLaporan,
        'laporanMasuk' => $stat['Diajukan'],
        'dalamProses'  => $stat['Diproses'],
        'selesai'      => $stat['Selesai'],
        'diarsipkan'   => 0
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

        $stat = [
            'Diajukan' => 0,
            'Diproses' => 0,
            'Selesai'  => 0
        ];

        foreach ($status as $s) {
            $stat[$s['status_laporan']] = $s['total'];
        }

        $this->view('dashboard/petugas', [
            'total_laporan'   => $total['total'],
            'diproses'        => $stat['Diproses'],
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
