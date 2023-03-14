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
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-sm" id="tender">
                    <thead>
                        <tr>
                            <th class="text-center">Kode Tender</th>
                            <th>Judul Tender</th>
                            <th>Satuan Kerja</th>
                            <th>HPS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < 5; $i++) : ?>
                            <tr>
                                <td class="text-center align-middle">
                                    <a href="./tender/detail/<?= strtotime('now') + $i ?>">
                                        <?= strtotime('now') + $i ?>
                                    </a>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-warning text-light">Tender Ulang</span>
                                    <p class="pt-0 pb-0">Renovasi Interior Ruang Rektor, Plafon, Lantai Koridor dan Kamar Mandi Gedung Rektorat</p>
                                </td>
                                <td class="align-middle">Universitas Wijaya Kusuma</td>
                                <td class="align-middle">Rp. 7.800.000.000</td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

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
        });
    })
</script>