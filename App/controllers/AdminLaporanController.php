<?php

class AdminLaporanController extends Controller
{
    // Default, redirect ke Laporan Masuk
    public function index()
    {
        header('Location: ' . BASEURL . '/adminlaporan/masuk');
        exit;
    }

    // ===============================
    // Halaman Dashboard Admin
    // ===============================
    public function admin()
    {
        $this->auth('admin'); // pastikan hanya admin yang bisa akses

        global $db; // PDO connection

        // Hitung jumlah laporan
        $laporanMasukQuery = $db->query("SELECT COUNT(*) as total FROM laporan");
        $laporanMasuk = $laporanMasukQuery->fetch(PDO::FETCH_ASSOC)['total'];

        $prosesQuery = $db->query("SELECT COUNT(*) as total FROM laporan WHERE status_laporan = 'Proses'");
        $proses = $prosesQuery->fetch(PDO::FETCH_ASSOC)['total'];

        $selesaiQuery = $db->query("SELECT COUNT(*) as total FROM laporan WHERE status_laporan = 'Selesai'");
        $selesai = $selesaiQuery->fetch(PDO::FETCH_ASSOC)['total'];

        $arsipQuery = $db->query("SELECT COUNT(*) as total FROM laporan WHERE status_laporan = 'Arsip'");
        $arsip = $arsipQuery->fetch(PDO::FETCH_ASSOC)['total'];

        // Data chart 7 hari terakhir (optional)
        $hari = [];        // array tanggal
        $dataLaporan = []; // array jumlah laporan per tanggal
        // --- bisa ditambahkan query chart jika dibutuhkan ---

        // Kirim data ke view
        $data = [
            'laporanMasuk' => $laporanMasuk,
            'proses'       => $proses,
            'selesai'      => $selesai,
            'arsip'        => $arsip,
            'hari'         => $hari,
            'dataLaporan'  => $dataLaporan
        ];

        $this->view('dashboard/admin', $data);
    }

    // ===============================
    // Halaman Laporan Masuk
    // ===============================
    public function laporanMasuk()
{
    $perPage = 5;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;

    $offset = ($page - 1) * $perPage;

    $model = new LaporanModel();

    $data['laporan'] = $model->getPaginate($perPage, $offset);
    $total = $model->countAll();

    $data['currentPage'] = $page;
    $data['totalPage'] = ceil($total / $perPage);

    $this->view('admin/laporan/riwayat', $data);
}

    // ===============================
    // Halaman Riwayat / Arsip
    // ===============================
    public function riwayat()
    {
        $this->auth('admin');

        // Ambil semua laporan (Proses, Selesai, Arsip)
        $laporan = $this->model('LaporanModel')->getRiwayat();

        $data = [
            'laporan' => $laporan
        ];

        $this->view('admin/laporan/riwayat', $data);
    }

    // ===============================
    // Update Status Laporan
    // ===============================
    public function updateStatus()
    {
        $this->auth('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_laporan'];
            $status = $_POST['status']; 

            $this->model('LaporanModel')->updateStatus($id, $status);

            header('Location: ' . BASEURL . '/adminlaporan/masuk');
            exit;
        }
    }
}
