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
    <title>Riwayat Laporan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/petugas.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<div class="d-flex">

    <!-- SIDEBAR -->
    <?php include ROOT . '/App/views/dashboard/sidebar_petugas.php'; ?>

    <!-- CONTENT -->
    <div class="content">
        <h5 class="fw-bold mb-3">Riwayat Laporan</h5>

        <div class="card">
            <div class="card-body">

                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Pelapor</th>
                            <th>Jenis Masalah</th>
                            <th>Uraian Singkat</th>
                            <th>Status</th>
                            <th>Solusi</th>
                            <th>Detail</th>
                        </tr>
                    </thead>

                   <tbody>
                    <?php if (!empty($laporan)) : ?>
                    <?php $no = 1; foreach ($laporan as $row) : ?>
              <tr>
    <td><?= $no++ ?></td>
    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
    <td><?= htmlspecialchars($row['nama_pelapor']) ?></td>
    <td><?= htmlspecialchars($row['jenis_masalah']) ?></td>
    <td><?= htmlspecialchars(substr($row['deskripsi'], 0, 50)) ?>...</td>

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
            <div class="modal fade" id="modalSolusi<?= $row['id_laporan']; ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Solusi Laporan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="alert alert-success mb-0" style="white-space: pre-line;">
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
    <td colspan="8" class="text-center text-muted">
        Belum ada laporan
    </td>
</tr>
<?php endif; ?>
</tbody>
