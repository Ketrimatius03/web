<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASEURL . '/auth/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Masuk | Admin</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/masuk.css">
</head>
<body>

<div class="d-flex">

    <main class="content flex-fill p-4">

        <h4 class="mb-3">Laporan Masuk</h4>

        <div class="card">
            <div class="card-body p-0">

                <table class="table table-hover table-bordered m-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Pelapor</th>
                            <th>Asal Kantor</th>
                            <th>Kategori</th>
                            <th>Jenis Masalah</th>
                            <th>Tanggal</th>
                            <th class="text-center">Lampiran</th>
                            <th>Status</th>
                            <th width="220">Ubah Status</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (!empty($laporan)) : ?>

                        <?php
                        // NOMOR SESUAI PAGINATION
                        $no = ($currentPage - 1) * 10 + 1;
                        ?>

                        <?php foreach ($laporan as $row) : ?>

                            <?php
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
                                <td><?= date('d M Y', strtotime($row['tanggal_kejadian'])) ?></td>

                                <!-- LAMPIRAN -->
                                <td class="text-center">
                                    <?php if (!empty($row['lampiran'])) : ?>
                                        <a href="<?= BASEURL ?>/uploads/<?= htmlspecialchars($row['lampiran']) ?>"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-paperclip"></i>
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>

                                <!-- STATUS -->
                                <td>
                                    <span class="badge bg-<?= $badge ?>">
                                        <?= $row['status_laporan'] ?>
                                    </span>
                                </td>

                                <!-- UBAH STATUS -->
                                <td>
                                    <form action="<?= BASEURL ?>/dashboard/kirimSolusi" method="post">

                                        <input type="hidden" name="id_laporan" value="<?= $row['id_laporan'] ?>">

                                        <textarea
                                            name="solusi"
                                            class="form-control form-control-sm mb-2"
                                            placeholder="Tulis solusi..."
                                            <?= $row['status_laporan'] !== 'Selesai' ? 'disabled' : '' ?>
                                        ><?= htmlspecialchars($row['solusi'] ?? '') ?></textarea>

                                        <select name="status" class="form-select form-select-sm mb-2" required>
                                            <option value="Proses" <?= $row['status_laporan']=='Proses'?'selected':'' ?>>
                                                Dalam Proses
                                            </option>
                                            <option value="Selesai" <?= $row['status_laporan']=='Selesai'?'selected':'' ?>>
                                                Selesai
                                            </option>
                                        </select>

                                        <button type="submit" class="btn btn-success btn-sm w-100">
                                            Simpan
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else : ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                Tidak ada laporan masuk
                            </td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAGINATION -->
        <?php if ($totalPage > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">

                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link"
                       href="<?= BASEURL ?>/dashboard/laporanMasuk?page=<?= $currentPage - 1 ?>">
                        &laquo;
                    </a>
                </li>

                <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                        <a class="page-link"
                           href="<?= BASEURL ?>/dashboard/laporanMasuk?page=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= $currentPage >= $totalPage ? 'disabled' : '' ?>">
                    <a class="page-link"
                       href="<?= BASEURL ?>/dashboard/laporanMasuk?page=<?= $currentPage + 1 ?>">
                        &raquo;
                    </a>
                </li>

            </ul>
        </nav>
        <?php endif; ?>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
