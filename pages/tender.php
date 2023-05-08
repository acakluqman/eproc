<?php
// ambil data jenis tender
$jenisSql = $conn->prepare("SELECT * FROM jenis_tender ORDER BY id_jenis ASC");
$jenisSql->execute();
$jenis = $jenisSql->fetchAll();

// ambil data tender
$filter = "";
if (isset($_POST["search"])) {
    if (!empty($_POST["id_jenis"])) {
        $filter .= " AND tender.id_jenis = " . $_POST['id_jenis'] . " ";
    }
}

$tenderSql = $conn->prepare("SELECT 
    tender.*,
    status_tender.nama as status,
    jenis_tender.nama as jenis,
    satker.nama as satker
    FROM tender
    LEFT JOIN satker ON satker.id_satker = tender.id_satker
    LEFT JOIN jenis_tender ON jenis_tender.id_jenis = tender.id_jenis
    LEFT JOIN status_tender ON status_tender.id_status = tender.id_status
    WHERE tender.id_status = :id_status " . $filter . "
    ORDER BY tender.tgl_setuju DESC");
$tenderSql->execute(['id_status' => 2]);
$tender = $tenderSql->fetchAll();
?>
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tender</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
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
                                                <option value="<?= $jn['id_jenis'] ?>" <?= (isset($_POST['id_jenis']) && $_POST['id_jenis'] == $jn['id_jenis']) ? 'selected' : '' ?>>
                                                    <?= $jn['nama'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="search" class="btn btn-primary">
                                <i class="fas fa-search mr-2"></i> Tampilkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-striped" id="tender">
                            <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th>Judul Tender</th>
                                <th>Satuan Kerja</th>
                                <th>HPS</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($tender as $t): ?>
                                <tr>
                                    <td class="text-center align-middle">
                                        <a href="<?= base_url('tender/detail/' . $t['id_tender']) ?>">
                                            <?= $t['id_tender'] ?>
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        <?php
                                        // jenis tender
                                        if ($t['id_jenis'] == 1) {
                                            echo '<span class="badge bg-purple">' . $t['jenis'] . '</span> ';
                                        }
                                        if ($t['id_jenis'] == 2) {
                                            echo '<span class="badge bg-teal">' . $t['jenis'] . '</span> ';
                                        }
                                        ?>

                                        <p class="pt-0 pb-0"><?= $t['judul'] ?></p>
                                    </td>
                                    <td class="align-middle">
                                        <?= $t['satker'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?= rupiah($t['nilai_hps']) ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let tender;

    $(function () {
        tender = $('#tender').DataTable({
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