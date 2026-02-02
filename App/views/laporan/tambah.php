<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Laporan</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- CSS Petugas -->
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/petugas.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- CONTENT -->
        <div class="col-md-8 offset-md-2 mt-4">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fa fa-plus"></i> Buat Laporan
                    </h5>
                </div>

                <div class="card-body">

                    <form method="post" enctype="multipart/form-data">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Pelapor</label>
                                <input type="text" name="nama_pelapor" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No Telepon</label>
                                <input type="text" name="no_telepon" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Asal Kantor</label>
                            <input type="text" name="asal_kantor" class="form-control" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Kategori Masalah</label>
                                <select name="kategori_masalah" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Hardware">Hardware</option>
                                    <option value="Software">Software</option>
                                    <option value="Software">Gangguan Jaringan</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jenis Masalah</label>
                                <input type="text" name="jenis_masalah" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Kejadian</label>
                            <input type="date" name="tanggal_kejadian" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Permasalahan</label>
                            <textarea name="deskripsi" rows="4" class="form-control" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Lampiran (Opsional)</label>
                            <input type="file" name="lampiran" class="form-control">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= BASEURL ?>/dashboard/petugas" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-paper-plane"></i> Kirim Laporan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
