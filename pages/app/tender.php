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
        <div class="card-header">
            <div class="card-tools">
                <a href="<?= base_url('app/tender/tambah') ?>" class="btn btn-primary">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Tender
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="tender">
                <thead>
                    <tr>
                        <th>Kode Tender</th>
                        <th>Judul</th>
                        <th>Satker</th>
                        <th>Status</th>
                        <th>HPS</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
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
        })
    })
</script>