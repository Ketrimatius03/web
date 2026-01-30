<?php

class LaporanModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

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


    public function getByUser($userId)
    {
        $query = "SELECT * FROM master_laporan
                  WHERE id_user = ?
                  ORDER BY created_at DESC";

        $this->db->query($query);
        $this->db->bind("i", $userId);

        return $this->db->resultSet();
    }

    public function getById($id)
    {
    $query = "SELECT *
              FROM master_laporan
              WHERE id_laporan = ?";

    $this->db->query($query);
    $this->db->bind("i", $id);

    return $this->db->single();
  }

  public function getLatestByUser($userId, $limit = 5)
{
    $query = "SELECT *
              FROM master_laporan
              WHERE id_user = ?
              ORDER BY created_at DESC
              LIMIT ?";

    $this->db->query($query);
    $this->db->bind("ii", $userId, $limit);

    return $this->db->resultSet();
}

public function getByStatus($status)
{
    $query = "SELECT *
              FROM master_laporan
              WHERE status_laporan = ?
              ORDER BY created_at DESC";

    $this->db->query($query);
    $this->db->bind("s", $status);

    return $this->db->resultSet();
}


public function getRiwayatAdmin()
{
    $query = "SELECT *
              FROM master_laporan
              WHERE status_laporan IN ('Proses', 'Selesai')
              ORDER BY created_at DESC";
    $this->db->query($query);
    return $this->db->resultSet();
}

public function updateStatus($id, $status)
{
    $query = "UPDATE master_laporan
              SET status_laporan = ?
              WHERE id_laporan = ?";

    $this->db->query($query);
    $this->db->bind("si", $status, $id);

    return $this->db->execute();
}
public function getRiwayat()
{
    $query = "SELECT *
              FROM master_laporan
              WHERE status_laporan IN ('Selesai', 'Arsip')
              ORDER BY created_at DESC";

    $this->db->query($query);
    return $this->db->resultSet();
}



}
