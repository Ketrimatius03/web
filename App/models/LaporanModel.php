<?php

class LaporanModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /* =========================
       INSERT LAPORAN
    ========================= */
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

    /* =========================
       GET DATA
    ========================= */
    public function getById($id)
    {
        $this->db->query("SELECT * FROM master_laporan WHERE id_laporan = ?");
        $this->db->bind("i", $id);
        return $this->db->single();
    }

    public function getByUser($userId)
    {
        $this->db->query("
            SELECT * FROM master_laporan
            WHERE id_user = ?
            ORDER BY created_at DESC
        ");
        $this->db->bind("i", $userId);
        return $this->db->resultSet();
    }

    public function getLatestByUser($userId, $limit = 5)
    {
        $this->db->query("
            SELECT * FROM master_laporan
            WHERE id_user = ?
            ORDER BY created_at DESC
            LIMIT ?
        ");
        $this->db->bind("ii", $userId, $limit);
        return $this->db->resultSet();
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

    public function getRiwayat()
    {
        $this->db->query("
            SELECT * FROM master_laporan
            WHERE status_laporan IN ('Selesai','Arsip')
            ORDER BY created_at DESC
        ");
        return $this->db->resultSet();
    }

    /* =========================
       UPDATE
    ========================= */
    public function updateStatus($id, $status)
    {
        $this->db->query("
            UPDATE master_laporan
            SET status_laporan = ?
            WHERE id_laporan = ?
        ");
        $this->db->bind("si", $status, $id);
        return $this->db->execute();
    }

    public function updateSolusi($id, $solusi, $status)
    {
        $this->db->query("
            UPDATE master_laporan
            SET solusi = ?, status_laporan = ?
            WHERE id_laporan = ?
        ");
        $this->db->bind("ssi", $solusi, $status, $id);
        return $this->db->execute();
    }

    /* =========================
       LAPORAN MASUK (TANPA PAGINATION)
    ========================= */
    public function getLaporanMasuk()
    {
        $this->db->query("
            SELECT * FROM master_laporan
            WHERE status_laporan IN ('Diajukan','Proses')
            ORDER BY created_at DESC
        ");
        return $this->db->resultSet();
    }

    /* =========================
       PAGINATION ADMIN
    ========================= */
public function getLaporanMasukLimit($limit, $offset)
{
    $sql = "
        SELECT *
        FROM master_laporan
        WHERE status_laporan IN ('Diajukan','Proses')
        ORDER BY id_laporan DESC
        LIMIT ? OFFSET ?
    ";

    $this->db->query($sql);

    $this->db->bind("ii", $limit, $offset);

    return $this->db->resultSet();
}


    public function countLaporanMasuk()
    {
        $this->db->query("
            SELECT COUNT(*) AS total
            FROM master_laporan
            WHERE status_laporan IN ('Diajukan','Proses')
        ");
        return $this->db->single()['total'];
    }

    /* =========================
       FIX TOTAL (JANGAN HAPUS)
    ========================= */
    public function countAll()
    {
        $this->db->query("SELECT COUNT(*) as total FROM master_laporan");
        return $this->db->single()['total'];
    }
}
