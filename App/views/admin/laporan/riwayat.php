<?php
// ==================
// AUTH ADMIN
// ==================
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASEURL . '/auth/login');
    exit;
}

$judul = $judul ?? 'Riwayat & Arsip Laporan';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $judul ?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/style.css">
</head>
<body>

<div class="d-flex">

    <!-- CONTENT -->
    <main class="content flex-fill p-4">

        <h4 class="mb-3">📚 <?= $judul ?></h4>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelapor</th>
                            <th>Asal Kantor</th>
                            <th>Kategori</th>
                            <th>Jenis Masalah</th>
                            <th>Tanggal Kejadian</th>
                            <th>Status</th>
                            <th>Solusi</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (!empty($laporan)) : ?>
                        <?php $no = 1; foreach ($laporan as $row) : ?>

                        <?php
                        // ==================
                        // BADGE STATUS
                        // ==================
                        switch ($row['status_laporan']) {
                            case 'Proses':
                                $badge = 'warning';
                                break;
                            case 'Selesai':
                                $badge = 'success';
                                break;
                            case 'Arsip':
                                $badge = 'secondary';
                                break;
                            default:
                                $badge = 'primary';
                        }
                        ?>

                        <tr>
                            <td><?= $no++ ?></td>

                            <td><?= htmlspecialchars($row['nama_pelapor']) ?></td>
                            <td><?= htmlspecialchars($row['asal_kantor']) ?></td>
                            <td><?= htmlspecialchars($row['kategori_masalah']) ?></td>
                            <td><?= htmlspecialchars($row['jenis_masalah']) ?></td>

                            <!-- TANGGAL KEJADIAN -->
                            <td>
                                <?= date('d M Y', strtotime($row['tanggal_kejadian'])) ?>
                            </td>

                            <!-- STATUS -->
                            <td>
                                <span class="badge bg-<?= $badge ?>">
                                    <?= $row['status_laporan'] ?>
                                </span>
                            </td>

                            <!-- SOLUSI -->
                            <td style="max-width:300px">
                                <?php if (!empty($row['solusi_text'])) : ?>
                                    <div class="small text-success">
                                        <?= nl2br(htmlspecialchars($row['solusi_text'])) ?>
                                    </div>
                                <?php else : ?>
                                    <span class="text-muted small">
                                        Belum ada solusi
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Tidak ada data riwayat atau arsip
                            </td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
