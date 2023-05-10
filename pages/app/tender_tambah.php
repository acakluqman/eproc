<?php
// ambil data satuan kerja
$sqlSatker = $conn->prepare("SELECT * FROM satker ORDER BY nama ASC");
$sqlSatker->execute();
$satker = $sqlSatker->fetchAll();

// ambil data jenis tender
$sqlJenis = $conn->prepare("SELECT * FROM jenis_tender ORDER BY nama ASC");
$sqlJenis->execute();
$jenis = $sqlJenis->fetchAll();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tender Pengadaan</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-body">
            <form class="form">
                <div class="form-group">
                    <label class="form-label">Judul Pengadaan</label>
                    <input type="text" class="form-control" name="judul" id="judul" value="<?= isset($_POST['judul']) ? $_POST['judul'] : '' ?>" placeholder="Judul" required>
                </div>

                <div class="form-group row">
                    <div class="col-md-3">
                        <label class="form-label">Satuan Kerja</label>
                        <select name="id_satker" id="id_satker" class="form-control" required="required">
                            <?php foreach ($satker as $s) { ?>
                                <option value="<?= $s['id_satker'] ?>"><?= $s['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Jenis Tender</label>
                        <select name="jenis_tender" id="jenis_tender" class="form-control" required="required">
                            <?php foreach ($jenis as $j) { ?>
                                <option value="<?= $j['id_jenis'] ?>"><?= $j['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nilai Pagu Paket</label>
                        <input type="number" class="form-control" name="nilai_pagu" id="nilai_pagu" value="<?= isset($_POST['nilai_pagu']) ? $_POST['nilai_pagu'] : '' ?>" placeholder="Nilai Pagu Paket" inputmode="numeric" step="1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nilai HPS</label>
                        <input type="number" class="form-control" name="nilai_hps" id="nilai_hps" value="<?= isset($_POST['nilai_hps']) ? $_POST['nilai_hps'] : '' ?>" placeholder="Nilai HPS" inputmode="numeric" step="1" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir Pendaftaran</label>
                        <input type="date" class="form-control" name="tgl_akhir_daftar" id="tgl_akhir_daftar" min="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <a href="<?= base_url('app/tender') ?>" class="btn btn-danger"><i class="fas fa-arrow-left mr-2"></i> Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    $(function() {
        $('#id_satker, #jenis_tender').select2({
            theme: 'bootstrap4',
        });
    })
</script>