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
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/petugas.css">
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
        <div class="card-stat stat-total">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p>Total Laporan</p>
                    <h3><?= $total_laporan ?></h3>
                </div>
                <i class="fa fa-file-alt stat-icon"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-stat stat-proses">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p>Dalam Proses</p>
                    <h3><?= $diproses ?></h3>
                </div>
                <i class="fa fa-spinner fa-spin stat-icon"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-stat stat-selesai">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p>Selesai</p>
                    <h3><?= $selesai ?></h3>
                </div>
                <i class="fa fa-check-circle stat-icon"></i>
            </div>
        </div>
    </div>
</div>

        <!-- LAPORAN TERAKHIR + SOLUSI -->
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Laporan Terakhir</h6>

                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                             <th>Nama Pelapor</th>
                            <th>Judul Masalah</th>
                            <th>Uraian Singkat</th>
                            <th>Status</th>
                            <th>Solusi</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                  <tbody>
<?php if (!empty($laporanTerakhir)) : ?>
<?php $no = 1; foreach ($laporanTerakhir as $row) : ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
    <td><?= htmlspecialchars($row['nama_pelapor']) ?></td>
    <td><?= htmlspecialchars($row['jenis_masalah']) ?></td>
    <td><?= htmlspecialchars(substr($row['deskripsi'], 0, 40)) ?>...</td>

    <!-- STATUS -->
    <td>
        <?php if ($row['status_laporan'] == 'Diajukan') : ?>
            <span class="badge bg-secondary">Diajukan</span>
        <?php elseif ($row['status_laporan'] == 'Proses') : ?>
            <span class="badge bg-warning">Diproses</span>
        <?php else : ?>
            <span class="badge bg-success">Selesai</span>
        <?php endif; ?>
    </td>

    <!-- SOLUSI -->
    <td>
    <?php if (!empty($row['solusi'])) : ?>
        <button
            class="btn btn-sm btn-outline-success"
            data-bs-toggle="modal"
            data-bs-target="#modalSolusi<?= $row['id_laporan']; ?>">
            Lihat Solusi
        </button>

        <!-- MODAL SOLUSI -->
        <div class="modal fade"
             id="modalSolusi<?= $row['id_laporan']; ?>"
             tabindex="-1"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Solusi Laporan</h5>
                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-success mb-0"
                             style="white-space: pre-line;">
                            <?= htmlspecialchars($row['solusi']) ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php else : ?>
        <span class="text-muted">Belum ada</span>
    <?php endif; ?>
    </td>

    <!-- DETAIL -->
    <td>
        <a href="<?= BASEURL ?>/laporan/detail/<?= $row['id_laporan']; ?>"
           class="btn btn-sm btn-primary">
            Detail
        </a>
    </td>
</tr>
<?php endforeach; ?>
<?php else : ?>
<tr>
    <td colspan="7" class="text-center text-muted">
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
<script>
function toggleSolusi(id) {
    const el = document.getElementById(id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>
</body>
</html>
