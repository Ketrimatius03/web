<div class="sidebar d-flex flex-column">
    <h4 class="text-center fw-bold mb-4">SIMS</h4>

    <ul class="nav flex-column px-2">
        <li class="nav-item">
            <a href="<?= BASEURL ?>/dashboard/admin" class="nav-link">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASEURL ?>/dashboard/laporanMasuk" class="nav-link">
                <i class="bi bi-inbox"></i> Laporan Masuk
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASEURL ?>/dashboard/riwayat" class="nav-link">
                <i class="bi bi-archive"></i> Riwayat & Arsip
            </a>
        </li>
    </ul>

    <div class="mt-auto px-3 pb-3">
        <a href="<?= BASEURL ?>/auth/logout" class="logout">Logout</a><br>
        <span class="role">Admin</span>
    </div>
</div>
