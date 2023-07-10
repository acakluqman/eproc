<?php
// detail tender
$id_tender = escape($_GET['id_tender']);
$detailSql = $conn->prepare("SELECT
    t.*,
    s.nama as nama_satker,
    st.nama as status,
    jt.nama as jenis_tender,
    p.jml_peserta,
    u.nama as validator
    FROM tender t
    LEFT JOIN satker s ON s.id_satker = t.id_satker
    LEFT JOIN status_tender st ON st.id_status = t.id_status
    LEFT JOIN jenis_tender jt ON jt.id_jenis = t.id_jenis
    LEFT JOIN (SELECT id_tender, COUNT(*) as jml_peserta FROM tender_peserta GROUP BY id_tender) p ON p.id_tender = t.id_tender
    LEFT JOIN user u ON u.id_user = t.id_user_setuju
    WHERE md5(t.id_tender) = '" . $id_tender . "'
    ORDER BY t.tgl_buat DESC");
$detailSql->execute();
$detail = $detailSql->fetchObject();

// peserta tender
$pesertaSql = $conn->prepare("SELECT
    tp.*,
    v.*
    FROM tender_peserta tp
    LEFT JOIN vendor v ON v.id_vendor = tp.id_vendor
    WHERE md5(tp.id_tender) = '" . $id_tender . "'
    ORDER BY tp.is_pemenang DESC, tp.tgl_daftar ASC");
$pesertaSql->execute();
$peserta = $pesertaSql->fetchAll();

$jadwalSql = $conn->prepare("SELECT * FROM tender_jadwal WHERE md5(id_tender) = :id_tender ORDER BY tgl_mulai ASC");
$jadwalSql->execute(['id_tender' => $id_tender]);
$jadwal = $jadwalSql->fetchAll();

// setuju
if (isset($_POST['setuju'])) {
    $id_tender = $_POST['id_tender'];

    $sqlSetuju = $conn->prepare("UPDATE tender SET id_status = :id_status, tgl_setuju = :tgl_setuju, id_user_setuju = :id_user_setuju, catatan_persetujuan = :catatan_persetujuan WHERE id_tender = :id_tender");
    $setuju = $sqlSetuju->execute(['id_tender' => $id_tender, 'id_status' => 2, 'tgl_setuju' => date('Y-m-d H:i:s'), 'id_user_setuju' => $_SESSION['id_user'], 'catatan_persetujuan' => null]);

    if ($setuju) {
        $flash->success("Berhasil disetujui!");
    } else {
        $flash->warning("Gagal menyetujui. Silahkan ulangi lagi!");
    }

    header('Location:' . base_url('app/tender/detail/' . md5($id_tender)));
    exit();
}

// tolak
if (isset($_POST['tolak'])) {
    $id_tender = $_POST['id_tender'];
    $catatan_persetujuan = $_POST['catatan_persetujuan'];

    $sqlTolak = $conn->prepare("UPDATE tender SET id_status = :id_status, tgl_setuju = :tgl_setuju, id_user_setuju = :id_user_setuju, catatan_persetujuan = :catatan_persetujuan WHERE id_tender = :id_tender");
    $tolak = $sqlTolak->execute(['id_tender' => $id_tender, 'id_status' => 3, 'tgl_setuju' => date('Y-m-d H:i:s'), 'id_user_setuju' => $_SESSION['id_user'], 'catatan_persetujuan' => $catatan_persetujuan]);

    if ($tolak) {
        $flash->success("Persetujuan berhasil ditolak!");
    } else {
        $flash->warning("Gagal menolak. Silahkan ulangi lagi!");
    }

    header('Location:' . base_url('app/tender/detail/' . md5($id_tender)));
    exit();
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail Tender</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <?= $flash->display() ?>
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#detail" data-toggle="tab">Detail</a></li>
                <li class="nav-item"><a class="nav-link" href="#peserta" data-toggle="tab">Peserta</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="active tab-pane" id="detail">
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="tgl_setuju">Judul</label>
                        <div class="col-md-10">
                            <p><?= $detail->judul ?></p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="tgl_setuju">Jenis Tender</label>
                        <div class="col-md-10">
                            <p><?= $detail->jenis_tender ?></p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="tgl_setuju">Satuan Kerja</label>
                        <div class="col-md-10">
                            <p><?= $detail->nama_satker ?></p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="tgl_setuju">Deskripsi</label>
                        <div class="col-md-10">
                            <p><?= html_entity_decode($detail->deskripsi) ?></p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="tgl_setuju">Nilai Pagu</label>
                        <div class="col-md-10">
                            <p><?= rupiah($detail->nilai_pagu) ?></p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="tgl_setuju">Nilai HPS</label>
                        <div class="col-md-10">
                            <p><?= rupiah($detail->nilai_hps) ?></p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="tgl_setuju">Tanggal Akhir Pendaftaran</label>
                        <div class="col-md-10">
                            <p><?= tanggal(date_format(date_create($detail->tgl_akhir_daftar), 'Y-m-d')) ?></p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="tgl_setuju">Tanggal Pengajuan</label>
                        <div class="col-md-10">
                            <p><?= tanggal(date_format(date_create($detail->tgl_buat), 'Y-m-d H:i A')) ?></p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="tgl_setuju">Keterangan</label>
                        <div class="col-md-10">
                            <p><?= ($detail->keterangan) ?: '-' ?></p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="tgl_setuju">Kualifikasi</label>
                        <div class="col-md-10">
                            <p><?= ($detail->kualifikasi) ?: '-' ?></p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="tgl_setuju">Jadwal Tender</label>
                        <div class="col-md-10">
                            <table class="table table-sm table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%;">No.</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($jadwal as $key => $jad) { ?>
                                        <tr>
                                            <td class="text-center"><?= ($key + 1) ?>.</td>
                                            <td><?= $jad['nama_kegiatan'] ?></td>
                                            <td>
                                                <?= tanggal(date_format(date_create($jad['tgl_mulai']), 'Y-m-d')) ?>
                                                <?= $jad['tgl_selesai'] ? ' s.d. ' . tanggal(date_format(date_create($jad['tgl_selesai']), 'Y-m-d')) : '' ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane table-responsive" id="peserta">
                    <table class="table table-striped" id="tpeserta">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5px;">No.</th>
                                <th style="width: 5px;">Nama Peserta</th>
                                <th>Jumlah Penawaran</th>
                                <th title="Evaluasi Kualifikasi" style="width: 5px;"><span class="badge badge-danger">K</span></th>
                                <th title="Pembuktian Kualifikasi" style="width: 5px;"><span class="badge badge-danger">B</span></th>
                                <th title="Evaluasi Administrasi" style="width: 5px;"><span class="badge badge-info">A</span></th>
                                <th title="Evaluasi Teknis" style="width: 5px;"><span class="badge badge-info">T</span></th>
                                <th title="Evaluasi Harga dan Biaya" style="width: 5px;"><span class="badge badge-success">H</span></th>
                                <th title="Pemenang" style="width: 5px;"><span class="badge badge-warning">P</span></th>
                                <th>Tanggal Bid</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($peserta as $key => $ps) : ?>
                                <tr>
                                    <td class="align-middle text-center">
                                        <?= $key + 1 ?>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-muted"><?= $ps['npwp'] ?></span>
                                        <p><?= $ps['nama'] ?></p>
                                    </td>
                                    <td class="align-middle">
                                        <?= rupiah($ps['harga_penawaran']) ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php
                                        if (is_null($ps['is_kualifikasi'])) {
                                            echo '<i class="fas fa-minus-circle text-muted"></i>';
                                        } elseif ($ps['is_kualifikasi']) {
                                            echo '<i class="fas fa-check-circle text-success"></i>';
                                        } else {
                                            echo '<i class="fas fa-times-circle text-danger"></i>';
                                        }
                                        ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php
                                        if (is_null($ps['is_bukti_kualifikasi'])) {
                                            echo '<i class="fas fa-minus-circle text-muted"></i>';
                                        } elseif ($ps['is_bukti_kualifikasi']) {
                                            echo '<i class="fas fa-check-circle text-success"></i>';
                                        } else {
                                            echo '<i class="fas fa-times-circle text-danger"></i>';
                                        }
                                        ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php
                                        if (is_null($ps['is_eval_administrasi'])) {
                                            echo '<i class="fas fa-minus-circle text-muted"></i>';
                                        } elseif ($ps['is_eval_administrasi']) {
                                            echo '<i class="fas fa-check-circle text-success"></i>';
                                        } else {
                                            echo '<i class="fas fa-times-circle text-danger"></i>';
                                        }
                                        ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php
                                        if (is_null($ps['is_eval_teknis'])) {
                                            echo '<i class="fas fa-minus-circle text-muted"></i>';
                                        } elseif ($ps['is_eval_teknis']) {
                                            echo '<i class="fas fa-check-circle text-success"></i>';
                                        } else {
                                            echo '<i class="fas fa-times-circle text-danger"></i>';
                                        }
                                        ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php
                                        if (is_null($ps['is_eval_harga'])) {
                                            echo '<i class="fas fa-minus-circle text-muted"></i>';
                                        } elseif ($ps['is_eval_harga']) {
                                            echo '<i class="fas fa-check-circle text-success"></i>';
                                        } else {
                                            echo '<i class="fas fa-times-circle text-danger"></i>';
                                        }
                                        ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php
                                        if ($ps['is_pemenang']) {
                                            echo '<i class="fas fa-check-circle text-success"></i>';
                                        }
                                        ?>
                                    </td>
                                    <td class="align-middle"><?= tanggal(date_format(date_create($ps['tgl_daftar']), 'Y-m-d H:i A')) ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php if ($_SESSION['jenis_user'] == 1) { ?>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Status Persetujuan</h5>
            </div>
            <div class="card-body">
                <div class="row form-group">
                    <label class="control-label col-md-2" for="status">Status</label>
                    <div class="col-md-5">
                        <p><?= $detail->status ?> <?= $detail->id_user_setuju ? ' - ' . $detail->validator : '' ?></p>
                    </div>
                </div>
                <?php if ($detail->id_status == 1) { ?>
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="tgl_dibuat">Tanggal Diajukan</label>
                        <div class="col-md-5">
                            <p><?= tanggal(date_format(date_create($detail->tgl_buat), 'Y-m-d H:i A')) ?></p>
                        </div>
                    </div>
                    <form method="post" action="">
                        <div class="row form-group">
                            <label class="control-label col-md-2" for="tgl_dibuat">&nbsp;</label>
                            <div class="col-md-5">
                                <input type="hidden" name="id_tender" value="<?= $detail->id_tender ?>" readonly>
                                <button type="submit" name="setuju" class="btn btn-success">Setujui</button>
                                <button type="button" data-toggle="modal" data-target="#tolak" class="btn btn-danger">Tolak</button>
                            </div>
                        </div>
                    </form>
                <?php } elseif ($detail->id_status == 2) { ?>
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="tgl_setuju">Tanggal Disetujui</label>
                        <div class="col-md-5">
                            <p><?= tanggal(date_format(date_create($detail->tgl_setuju), 'Y-m-d H:i A')) ?></p>
                        </div>
                    </div>
                <?php } elseif ($detail->id_status == 3) { ?>
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="tgl_setuju">Tanggal Penolakan</label>
                        <div class="col-md-5">
                            <p><?= tanggal(date_format(date_create($detail->tgl_setuju), 'Y-m-d H:i A')) ?></p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="control-label col-md-2" for="catatan">Catatan Penolakan</label>
                        <div class="col-md-5">
                            <p><?= $detail->catatan_persetujuan ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="modal fade" id="tolak">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title">Alasan Penolakan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="catatan" class="control-label">Alasan Penolakan</label>
                                <input type="hidden" name="id_tender" value="<?= $detail->id_tender ?>" readonly>
                                <textarea placeholder="Masukkan alasan penolakan" name="catatan_persetujuan" id="catatan_persetujuan" class="form-control" rows="3" required="required"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" name="tolak" class="btn btn-danger">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php
    if ($_SESSION['jenis_user'] == 3) {
        $isDaftarSql = $conn->prepare("SELECT id_tender FROM tender_peserta WHERE id_vendor = :id_vendor AND md5(id_tender) = :id_tender");
        $isDaftarSql->execute(['id_vendor' => $_SESSION['id_vendor'], 'id_tender' => $id_tender]);
        $isDaftar = $isDaftarSql->fetchObject();

        $dokumenSql = $conn->prepare("SELECT
                td.*,
                jd.jns_dok,
                jd.ekstensi,
                tdp.id_dok_peserta,
                tdp.filepath,
                tdp.tgl_unggah
            FROM
                tender_dokumen td
            LEFT JOIN jenis_dok jd ON
                jd.id_jns_dok = td.id_jenis_dok
            LEFT JOIN tender_dok_peserta tdp ON
                tdp.id_tender_dokumen = td.id_tender_dokumen
            WHERE
                md5(td.id_tender) = :id_tender
                AND tdp.id_vendor = :id_vendor");
        $dokumenSql->execute(['id_tender' => $id_tender, 'id_vendor' => $_SESSION['id_vendor']]);
        $dokumen = $dokumenSql->fetchAll();

        if ($isDaftar) { ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Unggah Dokumen</h5>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_POST['upload'])) {
                        $conn->beginTransaction();
                        try {
                            foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
                                $file_name = $key . $_FILES['file']['name'][$key];
                                $file_size = $_FILES['file']['size'][$key];
                                $file_tmp = $_FILES['file']['tmp_name'][$key];
                                $file_type = $_FILES['file']['type'][$key];

                                $filepath = "upload/" . time() . $file_name;

                                if (move_uploaded_file($file_tmp, $filepath)) {
                                    $updateDokSql = $conn->prepare("UPDATE tender_dok_peserta SET filepath = :filepath, tgl_unggah = :tgl_unggah WHERE id_vendor = :id_vendor AND id_tender_dokumen = :id_tender_dokumen");
                                    $updateDokSql->execute(['filepath' => $filepath, 'tgl_unggah' => date('Y-m-d H:i:s'), 'id_vendor' => $_SESSION['id_vendor'], 'id_tender_dokumen' => $_POST['id_tender_dokumen'][$key]]);
                                }
                            }

                            $conn->commit();
                            $flash->success('Berhasil unggah dokumen!');
                        } catch (PDOExecption $e) {
                            $flash->error('Gagal mengunggah dokumen!' . $e->getMessage());
                            $conn->rollBack();
                        }
                        header('Location: ' . base_url('app/tender/detail/' . $id_tender));
                    }
                    ?>
                    <form method="post" action="" enctype="multipart/form-data">
                        <?php
                        $up = 0;
                        foreach ($dokumen as $key => $dok) {
                            if ($dok['filepath'] != '') { ?>
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="upload_<?= $dok['id_tender_dokumen'] ?>"><?= $dok['jns_dok'] ?></label>
                                            <p><a href="<?= base_url($dok['filepath']) ?>" target="_blank">Lihat Dokumen</a></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-xs btn-danger">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <?php $up++ ?>
                                <div class="form-group">
                                    <label for="upload_<?= $dok['id_tender_dokumen'] ?>"><?= $dok['jns_dok'] ?></label>
                                    <div class="col-md-5">
                                        <input type="hidden" name="id_tender_dokumen[]" value="<?= $dok['id_tender_dokumen'] ?>">
                                        <input type="file" name="file[]" id="upload_<?= $dok['id_tender_dokumen'] ?>" required>
                                    </div>
                                </div>
                            <?php
                            }
                        }

                        if ($up > 0) { ?>
                            <div class="form-group">
                                <button type="submit" name="upload" class="btn btn-primary">Unggah</button>
                            </div>
                        <?php }
                        ?>
                    </form>
                </div>
            </div>
    <?php
        }
    }
    ?>
</section>

<script>
    let peserta;

    $(function() {
        peserta = $('#tpeserta').DataTable({
            language: {
                processing: 'Loading...',
                searchPlaceholder: 'Cari...',
                sSearch: '',
                lengthMenu: '_MENU_'
            },
            columnDefs: [{
                targets: [3, 4, 5, 6, 7, 8],
                className: "text-center",
                orderable: false
            }]
        });
    });
</script>