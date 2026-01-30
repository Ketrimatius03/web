<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header('Location: ' . BASEURL . '/auth/login');
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Petugas</title>

    <!-- Bootstrap & Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- CSS khusus dashboard -->
    <link rel="stylesheet" href="/web_ms/public/assets/css/petugas.css">
</head>
<body>

<div class="d-flex">

    <!-- SIDEBAR -->
   <div class="sidebar d-flex flex-column">
    <h4 class="text-center fw-bold mb-4">SIMS</h4>

    <ul class="nav flex-column px-2">
        <li class="nav-item">
            <a href="<?= BASEURL ?>/dashboard/petugas" class="nav-link active">
                <i class="fa fa-gauge"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASEURL ?>/laporan/tambah" class="nav-link">
                <i class="fa fa-plus"></i> Buat Laporan
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASEURL ?>/laporan/riwayat" class="nav-link">
                <i class="fa fa-clock"></i> Riwayat Laporan
            </a>
        </li>
    </ul>

    <div class="mt-auto px-3 pb-3">
        <a href="<?= BASEURL ?>/auth/logout" class="logout">Logout</a><br>
        <span class="role">Petugas</span>
    </div>
</div>


    <!-- CONTENT -->
    <div class="content">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-0">Dashboard Pelapor</h5>
                <small class="text-muted">
                    Sistem Informasi Manajemen Penyelesaian Masalah
                </small>
            </div>
            <span class="badge bg-primary">User</span>
        </div>

        <!-- CARD STATISTIK -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card card-stat">
                    <p>Total Laporan</p>
                    <h3><?= $total_laporan ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat">
                    <p>Sedang Diproses</p>
                    <h3><?= $diproses ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat">
                    <p>Selesai</p>
                    <h3><?= $selesai ?></h3>
                </div>
            </div>
        </div>

        <!-- LAPORAN TERAKHIR -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h6 class="fw-bold">Laporan Terakhir</h6>
                </div>

                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Judul Masalah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
<?php if (!empty($laporanTerakhir)) : ?>
<?php foreach ($laporanTerakhir as $row) : ?>
<tr>
    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
    <td><?= htmlspecialchars($row['jenis_masalah']) ?></td>
    <td>
        <?php if ($row['status_laporan'] == 'Diajukan') : ?>
            <span class="badge bg-secondary">Diajukan</span>
        <?php elseif ($row['status_laporan'] == 'Diproses') : ?>
            <span class="badge bg-warning">Diproses</span>
        <?php else : ?>
            <span class="badge bg-success">Selesai</span>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
<?php else : ?>
<tr>
    <td colspan="3" class="text-center text-muted">
        Belum ada laporan
    </td>
</tr>
<?php endif; ?>
</tbody>

                </table>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
