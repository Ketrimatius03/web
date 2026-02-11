<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/petugas.css">
</head>
<body>

<div class="d-flex">
    <?php include ROOT . '/App/views/dashboard/sidebar_petugas.php'; ?>

    <div class="content">
        <h5 class="fw-bold mb-3">Detail Laporan</h5>

       <div class="card detail-card">
    <div class="card-body">

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="detail-label">Nama Pelapor</div>
                <div class="detail-value"><?= htmlspecialchars($laporan['nama_pelapor']) ?></div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">Asal Kantor</div>
                <div class="detail-value"><?= htmlspecialchars($laporan['asal_kantor']) ?></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="detail-label">Kategori Masalah</div>
                <div class="detail-value"><?= $laporan['kategori_masalah'] ?></div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">Jenis Masalah</div>
                <div class="detail-value"><?= $laporan['jenis_masalah'] ?></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="detail-label">Tanggal Kejadian</div>
                <div class="detail-value"><?= $laporan['tanggal_kejadian'] ?></div>
            </div>
            <div class="col-md-6">
                <div class="detail-label">Status</div>
                <span class="badge badge-status bg-info">
                    <?= $laporan['status_laporan'] ?>
                </span>
            </div>
        </div>

        <hr>

       <div class="detail-label mb-2">Solusi dari Admin</div>

       <?php if (!empty($laporan['solusi'])) : ?>
       <div class="alert alert-success">
        <?= nl2br(htmlspecialchars($laporan['solusi'])) ?>
       </div>
      <?php else : ?>
      <div class="alert alert-warning">
        Solusi belum diberikan oleh admin.
       </div>
      <?php endif; ?>


        <a href="<?= BASEURL ?>/laporan/riwayat"
           class="btn btn-secondary mt-4">
            Kembali
        </a>

    </div>
</div>

</body>
</html>
