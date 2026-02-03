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
    <title>Dashboard | BAPENDA</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/web_ms/public/assets/css/style.css">

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="d-flex">
 <aside class="sidebar">
    <h4 class="text-white text-center mb-4">BAPENDA</h4>

    <ul class="nav flex-column">

        <li class="nav-item">
            <a href="<?= BASEURL ?>/dashboard/admin" class="sidebar-link active">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASEURL ?>/dashboard/laporanMasuk" class="sidebar-link">
                <i class="fa fa-inbox"></i> Laporan Masuk
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASEURL ?>/adminlaporan/riwayat" class="sidebar-link">
                <i class="bi bi-archive"></i> Riwayat & Arsip
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASEURL ?>/masterdata" class="sidebar-link">
                <i class="bi bi-database"></i> Master Data
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASEURL ?>/pengaturan" class="sidebar-link">
                <i class="bi bi-gear"></i> Pengaturan
            </a>
        </li>

        <li class="nav-item mt-4">
            <a href="<?= BASEURL ?>/auth/logout"
               class="sidebar-link text-warning"
               onclick="return confirm('Yakin ingin logout?')">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>

    </ul>
</aside>


    <!-- CONTENT -->
    <main class="content flex-fill">
        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>Dashboard</h4>
                <small>Badan Pendapatan Daerah</small>
            </div>
            <div class="text-end">
                <strong>Admin Sistem</strong><br>
                <small><?= date('l, d F Y'); ?></small>
            </div>
        </div>

       <div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-stat blue">
            <div>
                <small>Laporan Masuk</small>
                <h3><?= $laporanMasuk ?></h3>
            </div>
            <i class="bi bi-inbox"></i>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-stat yellow">
            <div>
                <small>Dalam Proses</small>
                <h3><?= $dalamProses ?></h3>
            </div>
            <i class="bi bi-hourglass-split"></i>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-stat green">
            <div>
                <small>Selesai</small>
                <h3><?= $selesai ?></h3>
            </div>
            <i class="bi bi-check-circle"></i>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-stat gray">
            <div>
                <small>Diarsipkan</small>
                <h3><?= $diarsipkan ?></h3>
            </div>
            <i class="bi bi-archive"></i>
        </div>
    </div>
</div>


        <!-- CHART -->
        <div class="card p-4">
            <h5>Statistik Laporan (7 Hari Terakhir)</h5>
            <canvas id="laporanChart"></canvas>
        </div>
    </main>
</div>

<script>
const ctx = document.getElementById('laporanChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($hari) ?>,
        datasets: [{
            label: 'Laporan Masuk',
            data: <?= json_encode($dataLaporan) ?>,
            borderWidth: 3,
            tension: 0.4,
            fill: false
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>
