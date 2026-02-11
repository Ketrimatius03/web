<?php

class DashboardController extends Controller
{
    /* ===============================
       INDEX
    ================================ */
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

    /* ===============================
       DASHBOARD ADMIN
    ================================ */
    public function admin()
    {
        $this->auth('admin');

        $master = $this->model('Master');
        $status = $master->countByStatus();

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

        $chartData = $master->laporan7Hari();
        $hari = [];
        $dataLaporan = [];

        foreach ($chartData as $row) {
            $hari[] = date('d M', strtotime($row['hari']));
            $dataLaporan[] = $row['total'];
        }

        $this->view('dashboard/admin', [
            'laporanMasuk' => $laporanMasuk,
            'dalamProses'  => $dalamProses,
            'selesai'      => $selesai,
            'diarsipkan'   => $diarsipkan,
            'hari'         => $hari,
            'dataLaporan'  => $dataLaporan
        ]);
    }

    /* ===============================
       DASHBOARD PETUGAS
    ================================ */
    public function petugas()
    {
        $this->auth('user');

        $userId = $_SESSION['user']['id'];

        $laporanTerakhir = $this->model('LaporanModel')
                                ->getLatestByUser($userId);

        $master = $this->model('Master');
        $total  = $master->countByUser($userId);
        $status = $master->countByStatusUser($userId);

        $stat = [
            'Diajukan' => 0,
            'Proses'   => 0,
            'Selesai'  => 0
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

    /* ===============================
       LAPORAN MASUK ADMIN (PAGINATION)
       - HANYA Diajukan & Proses
    ================================ */
   public function laporanMasuk()
{
    $limit = 10;

    // AMBIL PAGE DARI URL
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($currentPage < 1) $currentPage = 1;

    $offset = ($currentPage - 1) * $limit;

    $laporan = $this->model('LaporanModel')
                    ->getLaporanMasukLimit($limit, $offset);

    $totalData = $this->model('LaporanModel')->countLaporanMasuk();
    $totalPage = ceil($totalData / $limit);

    $this->view('admin/laporan/masuk', [
        'laporan'     => $laporan,
        'currentPage'=> $currentPage, // 🔥 WAJIB
        'totalPage'  => $totalPage
    ]);
}



    /* ===============================
       KIRIM SOLUSI (ADMIN)
       - Solusi WAJIB jika Selesai
    ================================ */
    public function kirimSolusi()
    {
        $this->auth('admin');

        $id     = $_POST['id_laporan'];
        $status = $_POST['status'];

        if ($status === 'Selesai') {

            if (empty($_POST['solusi'])) {
                $_SESSION['error'] = 'Solusi wajib diisi jika status selesai';
                header('Location: ' . BASEURL . '/dashboard/laporanMasuk');
                exit;
            }

            $this->model('LaporanModel')
                 ->updateSolusi($id, $_POST['solusi'], 'Selesai');

        } else {
            $this->model('LaporanModel')
                 ->updateStatus($id, 'Proses');
        }

        header('Location: ' . BASEURL . '/dashboard/laporanMasuk');
        exit;
    }

    /* ===============================
       LIHAT SOLUSI (PETUGAS)
       - HANYA JIKA SELESAI
    ================================ */
    public function lihatSolusi($id)
    {
        $this->auth('user');

        $laporan = $this->model('LaporanModel')->getById($id);

        if ($laporan['id_user'] != $_SESSION['user']['id']) {
            die('Akses ditolak');
        }

        if ($laporan['status_laporan'] !== 'Selesai') {
            die('Solusi belum tersedia');
        }

        if (empty($laporan['solusi_file'])) {
            die('Solusi belum tersedia');
        }

        $path = ROOT . '/../storage/solusi/' . $laporan['solusi_file'];

        if (!file_exists($path)) {
            die('File tidak ditemukan');
        }

        header('Content-Type: ' . mime_content_type($path));
        header('Content-Disposition: inline; filename="' . basename($path) . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    /* ===============================
       RIWAYAT & ARSIP PETUGAS
       - HANYA STATUS SELESAI
       - PAGINATION
    ================================ */
    public function riwayat()
    {
        $this->auth('user');

        $userId = $_SESSION['user']['id'];
        $page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit  = 10;
        $offset = ($page - 1) * $limit;

        $model = $this->model('LaporanModel');

        $laporan = $model->getRiwayatByUser($userId, $limit, $offset);
        $total   = $model->countRiwayatByUser($userId);

        $this->view('laporan/riwayat', [
            'laporan'     => $laporan,
            'totalPage'   => ceil($total / $limit),
            'currentPage' => $page
        ]);
    }

    /* ===============================
       LOGOUT
    ================================ */
    public function logout()
    {
        session_destroy();
        header('Location: ' . BASEURL . '/auth/login');
        exit;
    }
}
