<?php

class LaporanController extends Controller
{
    public function tambah()
{
    $this->auth('user');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $data = [
            'id_user'          => $_SESSION['user']['id'],
            'nama_pelapor'     => $_POST['nama_pelapor'],
            'no_telepon'       => $_POST['no_telepon'],
            'asal_kantor'      => $_POST['asal_kantor'],
            'kategori_masalah' => $_POST['kategori_masalah'],
            'jenis_masalah'    => $_POST['jenis_masalah'],
            'tanggal_kejadian' => $_POST['tanggal_kejadian'],
            'deskripsi'        => $_POST['deskripsi'],
            'lampiran'         => null,

            // 🔥 TAMBAHKAN INI
            'status'           => 'masuk',
            'role_pengirim'    => 'petugas'
        ];

        if (!empty($_FILES['lampiran']['name'])) {
            $fileName = time() . '_' . $_FILES['lampiran']['name'];
            move_uploaded_file(
                $_FILES['lampiran']['tmp_name'],
                ROOT . '/public/uploads/' . $fileName
            );
            $data['lampiran'] = $fileName;
        }

        $this->model('LaporanModel')->insertLaporan($data);

        header('Location: ' . BASEURL . '/laporan/riwayat');
        exit;
    }

    $this->view('laporan/tambah');
}

public function riwayat()
{
    $this->auth('user');

    $laporan = $this->model('LaporanModel')->getRiwayat();

    $this->view('laporan/riwayat', [
        'laporan' => $laporan
    ]);
}

    public function detail($id)
{
    $this->auth('user');

    $laporan = $this->model('LaporanModel')->getById($id);

    if (!$laporan || $laporan['id_user'] != $_SESSION['user']['id']) {
        die('Akses ditolak');
    }

    $this->view('laporan/detail', [
        'laporan' => $laporan
    ]);
}

public function simpanSolusi()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'];
        $solusi = $_POST['solusi'];

        $this->model('LaporanModel')->updateSolusi($id, $solusi);

        header('Location: ' . BASEURL . '/dashboard/laporanMasuk');
        exit;
    }
}

public function getById($id)
{
    $this->db->query("SELECT * FROM laporan WHERE id = :id");
    $this->db->bind('id', $id);
    return $this->db->single();
}



}
