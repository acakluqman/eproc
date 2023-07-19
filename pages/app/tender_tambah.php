<?php
// ambil data satuan kerja
$sqlSatker = $conn->prepare("SELECT * FROM satker ORDER BY nama ASC");
$sqlSatker->execute();
$satker = $sqlSatker->fetchAll();

// ambil data jenis tender
$sqlJenis = $conn->prepare("SELECT * FROM jenis_tender ORDER BY nama ASC");
$sqlJenis->execute();
$jenis = $sqlJenis->fetchAll();

// proses tambah data
if (isset($_POST['tambah'])) {
    try {
        $conn->beginTransaction();

        $id_tender = uniqid();
        $judul = escape($_POST['judul']);
        $deskripsi = htmlentities($_POST['deskripsi']);
        $id_satker = escape($_POST['id_satker']);
        $nilai_pagu = escape($_POST['nilai_pagu']);
        $nilai_hps = escape($_POST['nilai_hps']);
        $id_jenis = escape($_POST['jenis_tender']);
        $tgl_akhir_daftar = escape($_POST['tgl_akhir_daftar']);
        $id_status = 1;
        $tgl_setuju = $id_user_setuju = $catatan_persetujuan = $keterangan = $kualifikasi = null;
        $tgl_buat = date('Y-m-d');
        $jadwal = $_POST['jadwal'];
        $dokumen = $_POST['dokumen'];

        $sqlTambahTender = $conn->prepare("INSERT INTO tender (id_tender, judul, deskripsi, id_satker, nilai_pagu, nilai_hps, id_jenis, tgl_akhir_daftar, id_status, tgl_setuju, id_user_setuju, catatan_persetujuan, keterangan, kualifikasi, tgl_buat) VALUES (:id_tender, :judul, :deskripsi, :id_satker, :nilai_pagu, :nilai_hps, :id_jenis, :tgl_akhir_daftar, :id_status, :tgl_setuju, :id_user_setuju, :catatan_persetujuan, :keterangan, :kualifikasi, :tgl_buat)");
        $tambahTender = $sqlTambahTender->execute([
            'id_tender' => $id_tender,
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'id_satker' => $id_satker,
            'nilai_pagu' => preg_replace('/\D/', '', $nilai_pagu),
            'nilai_hps' => preg_replace('/\D/', '', $nilai_hps),
            'id_jenis' => $id_jenis,
            'tgl_akhir_daftar' => $tgl_akhir_daftar,
            'id_status' => $id_status,
            'tgl_setuju' => $tgl_setuju,
            'id_user_setuju' => $id_user_setuju,
            'catatan_persetujuan' => $catatan_persetujuan,
            'keterangan' => $keterangan,
            'kualifikasi' => $kualifikasi,
            'tgl_buat' => $tgl_buat
        ]);

        foreach ($jadwal as $j) {
            $sqlTambahJadwal = $conn->prepare("INSERT INTO tender_jadwal (id_tender, nama_kegiatan, tgl_mulai, tgl_selesai) VALUES (:id_tender, :nama_kegiatan, :tgl_mulai, :tgl_selesai)");
            $tambahJadwal = $sqlTambahJadwal->execute([
                'id_tender' => $id_tender,
                'nama_kegiatan' => escape($j['nama']),
                'tgl_mulai' => escape(date_format(date_create($j['mulai']), 'Y-m-d H:i:s')),
                'tgl_selesai' => $j['akhir'] ? escape(date_format(date_create($j['akhir']), 'Y-m-d H:i:s')) : null
            ]);
        }

        foreach ($dokumen as $dok) {
            $sqlTambahDokumen = $conn->prepare("INSERT INTO tender_dokumen (id_tender, id_jenis_dok) VALUES (:id_tender, :id_jenis_dok)");
            $tambahDokumen = $sqlTambahDokumen->execute([
                'id_tender' => $id_tender,
                'id_jenis_dok' => $dok,
            ]);
        }

        $conn->commit();
        $flash->success('Berhasil menyimpan data! Pengajuan saat ini menunggu persetujuan admin!');
    } catch (PDOException $e) {
        $conn->rollBack();

        $flash->warning('Gagal menyimpan data. Silahkan ulangi kembali! ' . $e->getMessage());
    }

    header("Location: " . base_url('app/tender/tambah'));
    exit();
}
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
    <?= $flash->display() ?>
    <div class="card">
        <div class="card-body">
            <form action="" class="form" method="post">
                <h5>Data Tender</h5>
                <div class="form-group">
                    <label class="form-label">Judul Pengadaan</label>
                    <input type="text" class="form-control" name="judul" id="judul" value="<?= isset($_POST['judul']) ? $_POST['judul'] : '' ?>" placeholder="Judul" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi" class="control-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi"></textarea>
                </div>

                <div class="form-group row">
                    <div class="col-md-3">
                        <label class="form-label">Satuan Kerja</label>
                        <select name="id_satker" id="id_satker" class="form-control" required="required">
                            <?php
                            foreach ($satker as $s) {
                                if ($_SESSION['jenis_user'] == 2 && $s['id_satker'] != $_SESSION['id_satker']) continue;
                            ?>
                                <option value="<?= $s['id_satker'] ?>">
                                    <?= $s['nama'] ?>
                                </option>
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
                        <input type="text" class="form-control" name="nilai_pagu" id="nilai_pagu" data-type="rupiah" value="<?= isset($_POST['nilai_pagu']) ? $_POST['nilai_pagu'] : '' ?>" placeholder="Nilai Pagu Paket" inputmode="numeric" step="1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nilai HPS</label>
                        <input type="text" class="form-control" name="nilai_hps" id="nilai_hps" data-type="rupiah" value="<?= isset($_POST['nilai_hps']) ? $_POST['nilai_hps'] : '' ?>" placeholder="Nilai HPS" inputmode="numeric" step="1" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir Pendaftaran</label>
                        <input type="date" class="form-control" name="tgl_akhir_daftar" id="tgl_akhir_daftar" min="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>

                <h5>Jadwal</h5>
                <div class="form-group row">
                    <div class="col-md-3">
                        <label class="form-label">Nama Kegiatan</label>
                        <input type="text" class="form-control" name="jadwal[0][nama]" id="nama_kegiatan" placeholder="Nama Kegiatan" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai Kegiatan</label>
                        <input type="datetime-local" class="form-control" name="jadwal[0][mulai]" id="tgl_kegiatan" placeholder="Tanggal Mulai Kegiatan" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir Kegiatan</label>
                        <input type="datetime-local" class="form-control" name="jadwal[0][akhir]" id="tgl_kegiatan" placeholder="Tanggal Akhir Kegiatan">
                    </div>
                </div>

                <div id="kegiatan"></div>

                <div class="form-group row">
                    <div class="col-12">
                        <button type="button" id="add-row" class="btn btn-default"><i class="fas fa-plus-circle mr-2"></i>Tambah Kegiatan</button>
                    </div>
                </div>

                <?php
                $dokumenSql = $conn->prepare("SELECT * FROM jenis_dok");
                $dokumenSql->execute();
                $dokumen = $dokumenSql->fetchAll();
                ?>
                <h5>Dokumen</h5>
                <?php
                foreach ($dokumen as $dok) { ?>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="dokumen[]" id="dok_<?= $dok['id_jns_dok'] ?>" value="<?= $dok['id_jns_dok'] ?>">
                            <label for="dok_<?= $dok['id_jns_dok'] ?>" class="custom-control-label"><?= $dok['jns_dok'] ?></label>
                        </div>
                    </div>
                <?php } ?>

                <div class="form-group">
                    <a href="<?= base_url('app/tender') ?>" class="btn btn-danger"><i class="fas fa-arrow-left mr-2"></i> Batal</a>
                    <button type="submit" name="tambah" class="btn btn-primary"><i class="fas fa-save mr-2"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    let jadwal = 0;

    $(function() {
        $('#id_satker, #jenis_tender').select2({
            theme: 'bootstrap4',
        });

        $('#deskripsi').summernote({
            height: 150,
            placeholder: 'Masukkan deskripsi tender disini...',
            toolbar: [
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph', 'link']],
            ]
        })

        $("input[data-type='rupiah']").on({
            keyup: function() {
                $(this).val(formatRupiah($(this).val()));
            },
            blur: function() {
                $(this).val(formatRupiah($(this).val(), "blur"));
            }
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    })

    // add row
    $("#add-row").click(function() {
        jadwal++;
        let html = '';

        html += '<div class="form-group row" id="inputFormRow">';
        html += '<div class="col-md-3">';
        html += '<label class="form-label">Nama Kegiatan</label>';
        html += '<input type="text" class="form-control" name="jadwal[' + jadwal + '][nama]" id="nama_kegiatan" placeholder="Nama Kegiatan" required>';
        html += '</div>';
        html += '<div class="col-md-3">';
        html += '<label class="form-label">Tanggal Mulai Kegiatan</label>';
        html += '<input type="datetime-local" class="form-control" name="jadwal[' + jadwal + '][mulai]" id="tgl_kegiatan" placeholder="Tanggal Mulai Kegiatan" required>';
        html += '</div>';
        html += '<div class="col-md-3">';
        html += '<label class="form-label">Tanggal Akhir Kegiatan</label>';
        html += '<input type="datetime-local" class="form-control" name="jadwal[' + jadwal + '][akhir]" id="tgl_kegiatan" placeholder="Tanggal Akhir Kegiatan">';
        html += '</div>';
        html += '<div class="col-md-3">';
        html += '<label class="form-label">&nbsp;</label><br/>';
        html += '<button type="button" id="removeRow" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>';
        html += '</div>';
        html += '</div>';

        $('#kegiatan').append(html);
    })

    $(document).on('click', '#removeRow', function() {
        $(this).closest('#inputFormRow').remove();
    });
</script>