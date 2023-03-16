<?php
// ambil data jenis tender
$jenisSql = $conn->prepare("SELECT * FROM jenis_tender ORDER BY id_jenis ASC");
$jenisSql->execute();
$jenis = $jenisSql->fetchAll();

// ambil data status pengajuan tender
$statusSql = $conn->prepare("SELECT * FROM status_tender ORDER BY id_status ASC");
$statusSql->execute();
$status = $statusSql->fetchAll();

// ambil data tender
$filter = "";
if (isset($_POST["search"])) {
    if (!empty($_POST["id_jenis"])) {
        $filter .= " AND t.id_jenis = " . $_POST['id_jenis'] . " ";
    }
    if (!empty($_POST["id_status"])) {
        $filter .= " AND t.id_status = " . $_POST['id_status'] . " ";
    }
}

$tenderSql = $conn->prepare("SELECT
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
    WHERE 1 = 1 " . $filter . "
    ORDER BY t.tgl_buat DESC");
$tenderSql->execute();
$tender = $tenderSql->fetchAll();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Tender</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <form action="" class="form" method="post">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Jenis Tender</label>
                            <select class="form-control" name="id_jenis" id="id_jenis">
                                <option value="">Semua Jenis</option>
                                <?php foreach ($jenis as $jn) : ?>
                                    <option value="<?= $jn['id_jenis'] ?>" <?= (isset($_POST['id_jenis']) && $_POST['id_jenis'] == $jn['id_jenis']) ? 'selected' : '' ?>><?= $jn['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="id_status" id="id_status">
                                <option value="">Semua Status</option>
                                <?php foreach ($status as $st) : ?>
                                    <option value="<?= $st['id_status'] ?>" <?= (isset($_POST['id_status']) && $_POST['id_status'] == $st['id_status']) ? 'selected' : '' ?>><?= $st['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" name="search" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan</button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="<?= base_url('app/tender/tambah') ?>" class="btn btn-primary">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Tender
                </a>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-striped" id="tender">
                <thead>
                    <tr>
                        <th style="width: 10%;">ID Tender</th>
                        <th>Judul</th>
                        <th>Satker</th>
                        <th style="width: 15%;">HPS</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tender as $t) : ?>
                        <tr>
                            <td class="align-middle">
                                <a href="<?= base_url('app/tender/detail/' . $t['id_tender']) ?>">
                                    <?= $t['id_tender'] ?>
                                </a>
                            </td>
                            <td class="align-middle">
                                <?php
                                // jenis tender
                                if ($t['id_jenis'] == 1) {
                                    echo '<span class="badge bg-purple">' . $t['jenis_tender'] . '</span>&nbsp;';
                                }
                                if ($t['id_jenis'] == 2) {
                                    echo '<span class="badge bg-teal">' . $t['jenis_tender'] . '</span>&nbsp;';
                                }

                                // status tender
                                if ($t['id_status'] == 1) {
                                    echo '<span class="badge badge-warning">' . $t['status'] . '</span>&nbsp;';
                                }
                                if ($t['id_status'] == 2) {
                                    echo '<span class="badge badge-success">' . $t['status'] . '</span>&nbsp;';
                                }
                                if ($t['id_status'] == 3) {
                                    echo '<span class="badge badge-danger">' . $t['status'] . '</span>&nbsp;';
                                }

                                // jumlah peserta
                                if ($t['id_status'] == 2) {
                                    echo '<span class="badge badge-info">' . $t['jml_peserta'] . ' Peserta</span>&nbsp;';
                                }

                                // judul
                                echo '<p>' . $t['judul'] . '</p>';
                                ?>
                            </td>
                            <td class="align-middle">
                                <?= $t['nama_satker'] ?>
                            </td>
                            <td class="align-middle">
                                <?= rupiah($t['nilai_hps']) ?>
                            </td>
                            <td class="align-middle">
                                <button title="Hapus" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    let tender;

    $(function() {
        tender = $('#tender').DataTable({
            language: {
                processing: 'Loading...',
                searchPlaceholder: 'Cari...',
                sSearch: '',
                lengthMenu: '_MENU_'
            },
            order: [0, 'desc'],
            columnDefs: [{
                targets: [0],
                className: "text-center",
                orderable: false
            }, {
                targets: [-1],
                orderable: false
            }]
        })

        $('#id_status, #id_jenis').select2({
            theme: 'bootstrap4',
            minimumResultsForSearch: -1

        });
    })
</script>