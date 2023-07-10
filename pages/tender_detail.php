<?php
// detail tender
$detailSql = $conn->prepare("SELECT
    t.*,
    s.nama as nama_satker,
    st.nama as status,
    jt.nama as jenis_tender,
    p.jml_peserta
    FROM tender t
    LEFT JOIN satker s ON s.id_satker = t.id_satker
    LEFT JOIN status_tender st ON st.id_status = t.id_status
    LEFT JOIN jenis_tender jt ON jt.id_jenis = t.id_jenis
    LEFT JOIN (SELECT id_tender, COUNT(*) as jml_peserta FROM tender_peserta GROUP BY id_tender) p ON p.id_tender = t.id_tender
    WHERE t.id_tender = '" . $_GET['id_tender'] . "'
    ORDER BY t.tgl_buat DESC");
$detailSql->execute();
$detail = $detailSql->fetch();

// peserta tender
$pesertaSql = $conn->prepare("SELECT
    tp.*,
    v.*
    FROM tender_peserta tp
    LEFT JOIN vendor v ON v.id_vendor = tp.id_vendor
    WHERE tp.id_tender = '" . $_GET['id_tender'] . "'
    ORDER BY tp.is_pemenang DESC, tp.tgl_daftar ASC");
$pesertaSql->execute();
$peserta = $pesertaSql->fetchAll();

$isDaftarSql = $conn->prepare("SELECT id_tender FROM tender_peserta WHERE id_vendor = :id_vendor AND id_tender = :id_tender");
$isDaftarSql->execute(['id_vendor' => $_SESSION['id_vendor'], 'id_tender' => $detail['id_tender']]);
$isDaftar = $isDaftarSql->fetchObject();

if (isset($_POST['harga_penawaran'])) {
    $conn->beginTransaction();
    try {
        $harga_penawaran = preg_replace('/\D/', '', $_POST['harga_penawaran']);
        $daftarSql = $conn->prepare("INSERT INTO tender_peserta (id_tender, id_vendor, harga_penawaran, tgl_daftar) VALUES (:id_tender, :id_vendor, :harga_penawaran, :tgl_daftar)");
        $daftar = $daftarSql->execute(['id_tender' => $detail['id_tender'], 'id_vendor' => $_SESSION['id_vendor'], 'harga_penawaran' => $harga_penawaran, 'tgl_daftar' => date('Y-m-d H:i:s')]);

        $dokSql = $conn->prepare("SELECT * FROM tender_dokumen WHERE id_tender = :id_tender");
        $dokSql->execute(['id_tender' => $detail['id_tender']]);
        $dok = $dokSql->fetchAll();

        foreach ($dok as $key => $value) {
            $insSql = $conn->prepare("INSERT INTO tender_dok_peserta (id_vendor, id_tender_dokumen) VALUES (:id_vendor, :id_tender_dokumen)");
            $insSql->execute(['id_vendor' => $_SESSION['id_vendor'], 'id_tender_dokumen' => $value['id_tender_dokumen']]);
        }

        $conn->commit();
        $flash->success('Berhasil daftar tender. Silahkan lengkapi dokumen yang diperlukan!');
    } catch (PDOExecption $e) {
        $flash->error('Gagal mendaftar tender. Silahkan ulangi kembali!');
        $conn->rollBack();
    }



    header('Location: ' . base_url('tender/detail/' . $detail['id_tender']));
    exit();
}
?>
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Tender</small></h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <?= $flash->display() ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#detail" data-toggle="tab">
                                    Detail Tender
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#peserta" data-toggle="tab">
                                    Peserta
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#evaluasi" data-toggle="tab">
                                    Hasil Evaluasi
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body table-responsive">
                        <div class="tab-content">
                            <div class="active tab-pane" id="detail">
                                <table class="table table-striped table-sm">
                                    <tr>
                                        <td>
                                            <strong>Jenis Pengadaan</strong>
                                        </td>
                                        <td colspan="3">
                                            <?= $detail['jenis_tender'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%;">
                                            <strong>Judul Tender</strong>
                                        </td>
                                        <td colspan="3">
                                            <?= $detail['judul'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Tanggal Akhir Pendaftaran</strong>
                                        </td>
                                        <td colspan="3">
                                            <?= tanggal(date_format(date_create($detail['tgl_akhir_daftar']), 'Y-m-d')) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Tahap Saat Ini</strong>
                                        </td>
                                        <td colspan="3">
                                            <?= $detail['status'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Satuan Kerja</strong>
                                        </td>
                                        <td colspan="3">
                                            <?= $detail['nama_satker'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Nilai Pagu</strong>
                                        </td>
                                        <td>
                                            <?= rupiah($detail['nilai_pagu']) ?>
                                        </td>
                                        <td>
                                            <strong>Nilai HPS</strong>
                                        </td>
                                        <td>
                                            <?= rupiah($detail['nilai_hps']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Syarat Kualifikasi</strong>
                                        </td>
                                        <td colspan="3">
                                            <?= ($detail['kualifikasi']) ? $detail['kualifikasi'] : '-' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Jumlah Peserta</strong>
                                        </td>
                                        <td colspan="3">
                                            <?= (sizeof($peserta) > 0) ? sizeof($peserta) . ' Peserta' : 'Belum ada peserta' ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="tab-pane" id="peserta">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 5%;">No.</th>
                                            <th>Nama Peserta</th>
                                            <th>NPWP</th>
                                            <th>Harga Penawaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($peserta as $key => $p) : ?>
                                            <tr>
                                                <td class="text-center"><?= $key + 1 ?>.</td>
                                                <td><?= $p['nama'] ?></td>
                                                <td><?= $p['npwp'] ?></td>
                                                <td><?= rupiah($p['harga_penawaran']) ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="evaluasi">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 5%;">No.</th>
                                            <th>Nama Peserta</th>
                                            <th title="Harga Penawaran">
                                                Harga Penawaran
                                            </th>
                                            <th class="text-center" title="Evaluasi Kualifikasi" style="width: 5%;">
                                                <span class="badge badge-danger">K</span>
                                            </th>
                                            <th class="text-center" title="Pembuktian Kualifikasi" style="width: 5%;">
                                                <span class="badge badge-danger">B</span>
                                            </th>
                                            <th class="text-center" title="Evaluasi Administrasi" style="width: 5%;">
                                                <span class="badge badge-info">A</span>
                                            </th>
                                            <th class="text-center" title="Evaluasi Teknis" style="width: 5%;">
                                                <span class="badge badge-info">T</span>
                                            </th>
                                            <th class="text-center" title="Evaluasi Harga dan Biaya" style="width: 5%;">
                                                <span class="badge badge-success">H</span>
                                            </th>
                                            <th class="text-center" title="Pemenang" style="width: 5%;">
                                                <span class="badge badge-warning">P</span>
                                            </th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($peserta as $key => $p) : ?>
                                            <tr>
                                                <td class="text-center"><?= $key + 1 ?>.</td>
                                                <td>
                                                    <?= $p['nama'] ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?= rupiah($p['harga_penawaran']) ?>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <?php
                                                    if (is_null($p['is_kualifikasi'])) {
                                                        echo '<i class="fas fa-minus-circle text-muted"></i>';
                                                    } elseif ($p['is_kualifikasi']) {
                                                        echo '<i class="fas fa-check-circle text-success"></i>';
                                                    } else {
                                                        echo '<i class="fas fa-times-circle text-danger"></i>';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <?php
                                                    if (is_null($p['is_bukti_kualifikasi'])) {
                                                        echo '<i class="fas fa-minus-circle text-muted"></i>';
                                                    } elseif ($p['is_bukti_kualifikasi']) {
                                                        echo '<i class="fas fa-check-circle text-success"></i>';
                                                    } else {
                                                        echo '<i class="fas fa-times-circle text-danger"></i>';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <?php
                                                    if (is_null($p['is_eval_administrasi'])) {
                                                        echo '<i class="fas fa-minus-circle text-muted"></i>';
                                                    } elseif ($p['is_eval_administrasi']) {
                                                        echo '<i class="fas fa-check-circle text-success"></i>';
                                                    } else {
                                                        echo '<i class="fas fa-times-circle text-danger"></i>';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <?php
                                                    if (is_null($p['is_eval_teknis'])) {
                                                        echo '<i class="fas fa-minus-circle text-muted"></i>';
                                                    } elseif ($p['is_eval_teknis']) {
                                                        echo '<i class="fas fa-check-circle text-success"></i>';
                                                    } else {
                                                        echo '<i class="fas fa-times-circle text-danger"></i>';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <?php
                                                    if (is_null($p['is_eval_harga'])) {
                                                        echo '<i class="fas fa-minus-circle text-muted"></i>';
                                                    } elseif ($p['is_eval_harga']) {
                                                        echo '<i class="fas fa-check-circle text-success"></i>';
                                                    } else {
                                                        echo '<i class="fas fa-times-circle text-danger"></i>';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <?php
                                                    if ($p['is_pemenang']) {
                                                        echo '<i class="fas fa-check-circle text-success"></i>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= $p['keterangan'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <br>
                                <span class="badge badge-danger">K</span> Evaluasi Kualifikasi
                                <span class="badge badge-danger">B</span> Pembuktian Kualifikasi
                                <span class="badge badge-info">A</span> Evaluasi Administrasi
                                <span class="badge badge-info">T</span> Evaluasi Teknis
                                <span class="badge badge-success">H</span> Evaluasi Harga dan Biaya
                                <span class="badge badge-warning">P</span> Pemenang
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ikuti Tender</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($isDaftar)) { ?>
                            <p>Anda telah terdaftar untuk mengikuti tender ini. Silahkan lengkapi dokumen <a href="<?= base_url('app/tender/detail/' . md5($detail['id_tender'])) ?>">di halaman ini</a>!</p>
                        <?php } else { ?>
                            <p>Silahkan masukkan harga penawaran Anda dan klik tombol <strong>Ikuti Tender</strong> untuk mendaftar menjadi peserta tender. Setelah terdaftar menjadi peserta, Anda diharuskan untuk upload dokumen yang diperlukan!</p>

                            <form class="form" method="post" action="">
                                <div class="form-group">
                                    <label for="harga_penawaran">Harga Penawaran</label>
                                    <input type="text" class="form-control" name="harga_penawaran" id="harga_penawaran" placeholder="Harga Penawaran">
                                </div>
                                <button type="submit" class="btn btn-success">Ikuti Tender</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var rupiah = document.getElementById('harga_penawaran');

    $(function() {
        rupiah.addEventListener("keyup", function(e) {
            rupiah.value = formatRupiah(this.value, "Rp. ");
        });


        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }

    })
</script>