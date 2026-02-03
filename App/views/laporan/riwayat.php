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

<div class="d-flex">

    <!-- SIDEBAR -->
    <?php include ROOT . '/App/views/dashboard/sidebar_petugas.php'; ?>

    <!-- CONTENT -->
    <div class="content">
        <h5 class="fw-bold mb-3">Riwayat Laporan</h5>

        <div class="card">
            <div class="card-body">
       <table class="table table-hover align-middle">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
             <th>Nama_Pelapor</th>
            <th>Jenis Masalah</th>
            <th>Uraian Singkat</th>
            <th>Status</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
<?php if (!empty($laporan)) : ?>
    <?php $no = 1; foreach ($laporan as $row) : ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>

        <!-- NAMA PELAPOR (FIX DI SINI) -->
        <td><?= htmlspecialchars($row['nama_pelapor']) ?></td>

        <td><?= htmlspecialchars($row['jenis_masalah']) ?></td>

        <td><?= htmlspecialchars(substr($row['deskripsi'], 0, 50)) ?>...</td>

        <td>
            <?php if ($row['status_laporan'] == 'Diajukan') : ?>
                <span class="badge bg-secondary">Diajukan</span>
            <?php elseif ($row['status_laporan'] == 'Diproses') : ?>
                <span class="badge bg-warning">Diproses</span>
            <?php else : ?>
                <span class="badge bg-success">Selesai</span>
            <?php endif; ?>
        </td>

        <td>
            <a href="<?= BASEURL ?>/laporan/detail/<?= $row['id_laporan']; ?>"
               class="btn btn-sm btn-primary">
                Detail
            </a>
        </td>

        <?php if (!empty($row['solusi'])) : ?>
    <a href="<?= BASEURL ?>/uploads/solusi/<?= $row['solusi'] ?>"
       target="_blank"
       class="btn btn-sm btn-outline-success">
        <i class="bi bi-file-earmark"></i> Lihat Solusi
    </a>
<?php else : ?>
    <span class="text-muted">Belum ada</span>
<?php endif; ?>


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

</body>
</html>
