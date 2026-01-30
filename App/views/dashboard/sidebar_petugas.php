<div class="sidebar d-flex flex-column">
    <h4 class="text-center fw-bold mb-4">SIMS</h4>

    <ul class="nav flex-column px-2">
        <li class="nav-item">
            <a href="<?= BASEURL ?>/dashboard/petugas" class="nav-link">
                <i class="fa fa-gauge"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL ?>/laporan/tambah" class="nav-link">
                <i class="fa fa-plus"></i> Buat Laporan
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL ?>/laporan/riwayat" class="nav-link active">
                <i class="fa fa-clock"></i> Riwayat Laporan
            </a>
        </li>
    </ul>

    <div class="mt-auto px-3 pb-3">
        <a href="<?= BASEURL ?>/auth/logout" class="logout">Logout</a><br>
        <span class="role">Petugas</span>
    </div>
</div>
