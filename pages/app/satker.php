<?php
// ambil data satker dari database
$sqlSatker = $conn->prepare("SELECT * FROM satker ORDER BY nama ASC");
$sqlSatker->execute();
$satker = $sqlSatker->fetchAll();

// tambah satker
if (isset($_POST['submit'])) {
    $nama = escape($_POST['nama']);

    $sqlTambah = $conn->prepare("INSERT INTO satker (nama) VALUES (:nama)");
    $tambah = $sqlTambah->execute(['nama' => $nama]);

    if ($tambah) {
        $flash->success("Berhasil menambahkan data satuan kerja!");
    } else {
        $flash->warning("Gagal menambahkan data satuan kerja. Silahkan ulangi kembali!");
    }

    header('Location:' . base_url('app/satker'));
    exit();
}

// edit satker
if (isset($_POST['edit'])) {
    $id_satker = escape($_POST['id_satker']);
    $nama = escape($_POST['nama']);

    $sqlEdit = $conn->prepare("UPDATE satker SET nama = :nama WHERE md5(id_satker) = :id_satker");
    $edit = $sqlEdit->execute(['id_satker' => $id_satker, 'nama' => $nama]);

    if ($edit) {
        $flash->success("Berhasil memperbarui data satuan kerja!");
    } else {
        $flash->warning("Gagal memperbarui data satuan kerja. Silahkan ulangi kembali!");
    }

    header('Location:' . base_url('app/satker'));
    exit();
}

// hapus satker
if (isset($_POST['delete'])) {
    $id_satker = escape($_POST['id_satker']);

    $sqlHapus = $conn->prepare("DELETE FROM satker WHERE md5(id_satker) = :id_satker");
    $hapus = $sqlHapus->execute(['id_satker' => $id_satker]);

    if ($hapus) {
        $flash->success("Berhasil menghapus data satuan kerja!");
    } else {
        $flash->warning("Gagal menghapus data satuan kerja. Silahkan ulangi kembali!");
    }

    header('Location:' . base_url('app/satker'));
    exit();
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Satuan Kerja</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <?= $flash->display() ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
                    <i class="fas fa-plus-circle mr-2"></i>Tambah
                </button>
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="satker">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">No.</th>
                        <th>Nama</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($satker as $s) {
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++ . "." ?></td>
                            <td><?= $s['nama'] ?></td>
                            <td>
                                <button type="button" id="btn-edit" data-id="<?= md5($s['id_satker']) ?>" data-nama="<?= $s['nama'] ?>" class="btn btn-xs btn-success" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                                <button type="button" id="btn-delete" data-id="<?= md5($s['id_satker']) ?>" class="btn btn-xs btn-danger" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header">
                    <h6 class="modal-title">Tambah Satuan Kerja</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama" class="control-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Satker" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header">
                    <h6 class="modal-title">Edit Satuan Kerja</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_satker" id="id_satker" value="" readonly>
                    <div class="form-group">
                        <label for="nama" class="control-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Satker" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" name="edit" class="btn btn-success"><i class="fas fa-save mr-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header">
                    <h6 class="modal-title">Hapus Satuan Kerja?</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_satker" id="id_satker" value="" readonly>
                    <p>Data satuan kerja akan dihapus, termasuk semua data tender dan user yang telah dibuat. Lanjutkan?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" name="delete" class="btn btn-danger"><i class="fas fa-trash-alt mr-2"></i>Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#satker').DataTable({
            language: {
                processing: 'Loading...',
                searchPlaceholder: 'Cari...',
                sSearch: '',
                lengthMenu: '_MENU_'
            },
            columnDefs: [{
                targets: [-1],
                className: 'text-center',
                orderable: false
            }]
        });

        $('#satker').on('click', '#btn-edit', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');

            $('#modal-edit').modal('show');
            $('#modal-edit #id_satker').val(id);
            $('#modal-edit #nama').val(nama);
        })

        $('#satker').on('click', '#btn-delete', function() {
            var id = $(this).data('id');

            $('#modal-delete').modal('show');
            $('#modal-delete #id_satker').val(id);
        })
    })
</script>