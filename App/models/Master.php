<?php

class Master
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // total semua laporan
    public function countAll()
    {
        $this->db->query("SELECT COUNT(*) AS total FROM master_laporan");
        return $this->db->single();
    }

    // jumlah laporan per status
    public function countByStatus()
    {
        $this->db->query("
            SELECT status_laporan, COUNT(*) AS total
            FROM master_laporan
            GROUP BY status_laporan
        ");
        return $this->db->resultSet();
    }

// total laporan milik petugas
public function countByUser($id_user)
{
    $this->db->query("
        SELECT COUNT(*) AS total 
        FROM master_laporan 
        WHERE id_user = ?
    ");
    $this->db->bind("i", $id_user);
    return $this->db->single();
}

// status laporan milik petugas
public function countByStatusUser($id_user)
{
    $this->db->query("
        SELECT status_laporan, COUNT(*) AS total
        FROM master_laporan
        WHERE id_user = ?
        GROUP BY status_laporan
    ");
    $this->db->bind('i', $id_user);
    return $this->db->resultSet();
}
// laporan masuk 7 hari terakhir (BERDASARKAN created_at)
public function laporan7Hari()
{
    $this->db->query("
        SELECT 
            DATE(created_at) AS hari,
            COUNT(*) AS total
        FROM master_laporan
        WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
        GROUP BY DATE(created_at)
        ORDER BY hari ASC
    ");

    return $this->db->resultSet();
}
public function tambahLaporan($data)
{
    $this->db->query("
        INSERT INTO master_laporan
        (
            id_user,
            nama_pelapor,
            no_telepon,
            asal_kantor,
            kategori_masalah,
            jenis_masalah,
            tanggal_kejadian,
            deskripsi,
            lampiran,
            status_laporan
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Diajukan')
    ");

    $this->db->bind(
        'issssssss',
        $data['id_user'],
        $data['nama_pelapor'],
        $data['no_telepon'],
        $data['asal_kantor'],
        $data['kategori_masalah'],
        $data['jenis_masalah'],
        $data['tanggal_kejadian'],
        $data['deskripsi'],
        $data['lampiran']
    );

    return $this->db->execute();
}

// ===============================
// SEARCH LAPORAN (ADMIN)
// ===============================
public function searchLaporan($keyword)
{
    $this->db->query("
        SELECT *
        FROM master_laporan
        WHERE 
            jenis_masalah LIKE ?
            OR kategori_masalah LIKE ?
            OR deskripsi LIKE ?
        ORDER BY created_at DESC
    ");

    $like = "%$keyword%";
    $this->db->bind('sss', $like, $like, $like);

    return $this->db->resultSet();
}

public function updateSolusiFile($id, $file, $status)
{
    $this->db->query("
        UPDATE master_laporan
        SET solusi_file = ?, status_laporan = ?
        WHERE id_laporan = ?
    ");

    $this->db->bind('ssi', $file, $status, $id);
    return $this->db->execute();
}


public function kirimSolusi()
{
    $this->auth('admin');

    $id = $_POST['id_laporan'];
    $status = $_POST['status'];

    $fileName = null;

    if (!empty($_FILES['solusi']['name'])) {

        $ext = pathinfo($_FILES['solusi']['name'], PATHINFO_EXTENSION);
        $fileName = 'solusi_' . time() . '.' . $ext;

        $target = ROOT . '/public/uploads/solusi/' . $fileName;
        move_uploaded_file($_FILES['solusi']['tmp_name'], $target);
    }

    $this->model('Master')->updateSolusiFile(
        $id,
        $fileName,
        $status
    );

    header('Location: ' . BASEURL . '/dashboard/laporanMasuk');
    exit;
}

public function getLaporanByUser($id_user)
{
    $this->db->query("
        SELECT 
            id_laporan,
            jenis_masalah,
            kategori_masalah,
            status_laporan,
            solusi_file,
            created_at
        FROM master_laporan
        WHERE id_user = ?
        ORDER BY created_at DESC
    ");

    $this->db->bind('i', $id_user);
    return $this->db->resultSet();
}



}