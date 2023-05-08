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
$detail = $detailSql->fetchObject();

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
                    <?php

                    echo "<pre>";
                    print_r($detail);
                    echo "</pre>";

                    ?>
                </div>

                <div class="tab-pane table-responsive" id="peserta">
                    <table class="table table-striped" id="tpeserta">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 5px;">No.</th>
                            <th style="width: 5px;">Nama Peserta</th>
                            <th>Jumlah Penawaran</th>
                            <th title="Evaluasi Kualifikasi" style="width: 5px;"><span
                                        class="badge badge-danger">K</span></th>
                            <th title="Pembuktian Kualifikasi" style="width: 5px;"><span
                                        class="badge badge-danger">B</span></th>
                            <th title="Evaluasi Administrasi" style="width: 5px;"><span
                                        class="badge badge-info">A</span></th>
                            <th title="Evaluasi Teknis" style="width: 5px;"><span class="badge badge-info">T</span></th>
                            <th title="Evaluasi Harga dan Biaya" style="width: 5px;"><span
                                        class="badge badge-success">H</span></th>
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
                                <td class="align-middle"><?= tanggal($ps['tgl_daftar']) ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let peserta;

    $(function () {
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