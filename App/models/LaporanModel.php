<?php

class LaporanModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /* ===============================
       INSERT LAPORAN
    =============================== */
    public function insertLaporan($data)
    {
        $query = "INSERT INTO master_laporan (
            id_user, nama_pelapor, no_telepon, asal_kantor,
            kategori_masalah, jenis_masalah, tanggal_kejadian,
            deskripsi, lampiran, status_laporan
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $this->db->query($query);
        $this->db->bind(
            "isssssssss",
            $data['id_user'],
            $data['nama_pelapor'],
            $data['no_telepon'],
            $data['asal_kantor'],
            $data['kategori_masalah'],
            $data['jenis_masalah'],
            $data['tanggal_kejadian'],
            $data['deskripsi'],
            $data['lampiran'],
            'Diajukan'
        );

        return $this->db->execute();
    }

    /* ===============================
       DATA LAPORAN
    =============================== */
    public function getAll()
    {
        $this->db->query("SELECT * FROM master_laporan ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

  public function getLatestByUser($userId, $limit = 5)
{
    $query = "
        SELECT *
        FROM master_laporan
        WHERE id_user = ?
        ORDER BY created_at DESC
        LIMIT ?
    ";

    $this->db->query($query);
    $this->db->bind("ii", $userId, $limit);

    return $this->db->resultSet();
}
public function getByUser($userId)
{
    $this->db->query("
        SELECT *
        FROM master_laporan
        WHERE id_user = ?
        ORDER BY created_at DESC
    ");
    $this->db->bind("i", $userId);

    return $this->db->resultSet();
}

public function getById($id)
{
    $this->db->query("
        SELECT id_laporan, id_user, solusi_file
        FROM master_laporan
        WHERE id_laporan = ?
    ");
    $this->db->bind("i", $id);
    return $this->db->single();
}



    public function getByStatus($status)
    {
        $this->db->query("
            SELECT * FROM master_laporan
            WHERE status_laporan = ?
            ORDER BY created_at DESC
        ");
        $this->db->bind("s", $status);
        return $this->db->resultSet();
    }

    /* ===============================
       UPDATE STATUS (INI YANG ERROR TADI)
    =============================== */
    public function updateStatus($id_laporan, $status)
    {
        $this->db->query("
            UPDATE master_laporan
            SET status_laporan = ?
            WHERE id_laporan = ?
        ");
        $this->db->bind("si", $status, $id_laporan);
        return $this->db->execute();
    }

    /* ===============================
       RIWAYAT & ARSIP ADMIN
    =============================== */
    public function getRiwayat()
    {
        $this->db->query("
            SELECT * FROM master_laporan
            WHERE status_laporan IN ('Proses', 'Selesai', 'Arsip')
            ORDER BY created_at DESC
        ");
        return $this->db->resultSet();
    }
public function updateSolusi($id, $file, $status)
{
    $this->db->query("
        UPDATE master_laporan
        SET solusi_file = ?, status_laporan = ?
        WHERE id_laporan = ?
    ");
   $this->model->updateSolusi($id, $file, $status);
    return $this->db->execute();
}




}
