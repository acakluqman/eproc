<?php
$id_vendor = $_SESSION['id_vendor'];

$penawaranSql = $conn->prepare("SELECT
        t.id_tender,
        t.judul,
        t.id_jenis,
        t.nilai_hps,
        tp.harga_penawaran,
        tp.tgl_daftar,
        jt.nama as jenis_tender
    FROM
        tender t
    LEFT JOIN tender_peserta tp ON tp.id_tender = t.id_tender
    LEFT JOIN jenis_tender jt ON jt.id_jenis = t.id_jenis
    WHERE tp.id_vendor = :id_vendor
    ORDER BY tp.tgl_daftar DESC");
$penawaranSql->execute(['id_vendor' => $id_vendor]);
$penawaran = $penawaranSql->fetchAll();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Penawaran Saya</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Penawaran Saya</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover" id="penawaran">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th>Judul</th>
                        <th>Harga HPS</th>
                        <th>Penawaran Saya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($penawaran as $key => $row) { ?>
                        <tr>
                            <td class="text-center align-middle"><?= ($key + 1) ?>.</td>
                            <td class="align-middle">
                                <?php
                                // jenis tender
                                if ($row['id_jenis'] == 1) {
                                    echo '<span class="badge bg-purple">' . $row['jenis_tender'] . '</span> ';
                                }
                                if ($row['id_jenis'] == 2) {
                                    echo '<span class="badge bg-teal">' . $row['jenis_tender'] . '</span> ';
                                }


                                echo '<p><a href="' . base_url('app/tender/detail/' . md5($row['id_tender'])) . '">' . $row['judul'] . '</a></p>';
                                ?>
                            </td>
                            <td class="align-middle"><?= rupiah($row['nilai_hps']) ?></td>
                            <td class="align-middle"><?= rupiah($row['harga_penawaran']) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>