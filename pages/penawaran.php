<?php
$penawaranSql = $conn->prepare("SELECT
    tender.*,
    vendor.nama as nama_vendor,
    tender_peserta.harga_penawaran,
    tender_peserta.is_kualifikasi,
    tender_peserta.is_bukti_kualifikasi,
    tender_peserta.is_eval_harga,
    tender_peserta.is_eval_administrasi,
    tender_peserta.is_eval_teknis,
    tender_peserta.is_pemenang,
    tender_peserta.keterangan,
    status_tender.nama as status,
    jenis_tender.nama as jenis
    FROM tender_peserta
    LEFT JOIN tender ON tender.id_tender = tender_peserta.id_tender
    LEFT JOIN vendor ON vendor.id_vendor = tender_peserta.id_vendor
    LEFT JOIN jenis_tender ON jenis_tender.id_jenis = tender.id_jenis
    LEFT JOIN status_tender ON status_tender.id_status = tender.id_status
    WHERE tender_peserta.id_vendor = :id_vendor");
$penawaranSql->execute(['id_vendor' => $_SESSION['id_vendor']]);
$penawaran = $penawaranSql->fetchAll();

//echo '<pre>';
//var_dump($penawaran);
//echo '</pre>';
?>
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Penawaran Saya</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <?php if (empty($penawaran)): ?>
                    <p>Anda belum pernah melakukan penawaran!</p>
                <?php else: ?>
                    <table class="table table-striped" id="penawaran">
                        <thead>
                        <tr>
                            <th class="text-center">ID Tender</th>
                            <th>Judul</th>
                            <th>Nilai HPS</th>
                            <th>Nilai Penawaran</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($penawaran as $row): ?>
                            <tr>
                                <td class="text-center align-middle">
                                    <a href="<?= base_url('tender/detail/' . $row['id_tender']) ?>" target="_blank">
                                        <?= $row['id_tender'] ?>
                                    </a>
                                </td>
                                <td class="align-middle">
                                    <?php
                                    // jenis tender
                                    if ($row['id_jenis'] == 1) {
                                        echo '<span class="badge bg-purple">' . $row['jenis'] . '</span> ';
                                    }
                                    if ($row['id_jenis'] == 2) {
                                        echo '<span class="badge bg-teal">' . $t['jenis'] . '</span> ';
                                    }

                                    echo '<p>' . $row['judul'] . '</p>';
                                    ?>
                                </td>
                                <td class="align-middle">
                                    <?= rupiah($row['nilai_hps']) ?>
                                </td>
                                <td class="align-middle">
                                    <?= rupiah($row['harga_penawaran']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    let penawaran;

    $(function () {
        penawaran = $('#penawaran').DataTable({
            language: {
                processing: 'Loading...',
                searchPlaceholder: 'Cari...',
                sSearch: '',
                lengthMenu: '_MENU_'
            },
        });

        $('#id_jenis').select2({
            theme: 'bootstrap4',
            minimumResultsForSearch: -1
        });
    })
</script>