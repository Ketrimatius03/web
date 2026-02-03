<?php

class DashboardController extends Controller
{
    /**
     * ==========================
     * REDIRECT SESUAI ROLE
     * ==========================
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

    /**
     * ==========================
     * DASHBOARD PETUGAS
     * ==========================
     */
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

    /**
     * ==========================
     * LAPORAN MASUK ADMIN
     * ==========================
     */
    public function laporanMasuk()
    {
        $this->auth('admin');

        $laporan = $this->model('LaporanModel')->getByStatus('Diajukan');

        $this->view('admin/laporan/masuk', [
            'laporan' => $laporan
        ]);
    }

    /**
     * ==========================
     * KIRIM SOLUSI 
     * ==========================
     */
public function kirimSolusi()
{
    $this->auth('admin');

    $id     = $_POST['id_laporan'];
    $status = $_POST['status'];

    // solusi teks (boleh kosong)
    $solusiText = $_POST['solusi'] ?? null;

    $fileName = null;

    if (!empty($_FILES['solusi_file']['name'])) {

        $allowed = ['jpg','jpeg','png','pdf'];
        $ext = strtolower(pathinfo($_FILES['solusi_file']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            die('Format file tidak didukung');
        }

        $folder = ROOT . '/../storage/solusi/';

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $fileName = 'solusi_' . time() . '.' . $ext;

        move_uploaded_file(
            $_FILES['solusi_file']['tmp_name'],
            $folder . $fileName
        );
    }

    // 🔥 INI YANG PENTING (4 PARAMETER)
    $this->model('LaporanModel')->updateSolusi(
        $id,
        $solusiText,
        $fileName,
        $status
    );

    header('Location: ' . BASEURL . '/dashboard/laporanMasuk');
    exit;
}



public function lihatSolusi($id)
{
    $this->auth('user');

    $laporan = $this->model('LaporanModel')->getById($id);

    // cek kepemilikan laporan
    if ($laporan['id_user'] != $_SESSION['user']['id']) {
        die('Akses ditolak');
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
}
