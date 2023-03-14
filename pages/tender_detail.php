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
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#detail" data-toggle="tab">Detail Tender</a></li>
                    <li class="nav-item"><a class="nav-link" href="#peserta" data-toggle="tab">Peserta</a></li>
                    <li class="nav-item"><a class="nav-link" href="#evaluasi" data-toggle="tab">Hasil Evaluasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pemenang" data-toggle="tab">Pemenang Tender</a></li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="detail">
                        <table class="table table-sm">
                            <tr>
                                <td class="tx-medium" style="width: 15%;">Kode Tender</td>
                                <td colspan="3"><?= $_GET['id_tender'] ?></td>
                            </tr>
                            <tr>
                                <td>Judul Tender</td>
                                <td colspan="3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi, quos quaerat deserunt deleniti maiores aliquid amet repellendus velit praesentium fuga dignissimos, temporibus, excepturi aperiam fugiat reprehenderit exercitationem provident obcaecati consequatur.</td>
                            </tr>
                            <tr>
                                <td>Tanggal Pembuatan</td>
                                <td colspan="3">27 Januari 2023</td>
                            </tr>
                            <tr>
                                <td>Tahap Saat Ini</td>
                                <td colspan="3">Tender Sudah Selesai</td>
                            </tr>
                            <tr>
                                <td>Satuan Kerja</td>
                                <td colspan="3">Universitas Wijaya Kusuma Surabaya</td>
                            </tr>
                            <tr>
                                <td>Jenis Pengadaan</td>
                                <td colspan="3">Pekerjaan Konstruksi</td>
                            </tr>
                            <tr>
                                <td>Nilai Pagu</td>
                                <td>Rp. 8.700.000.000,00</td>
                                <td>Nilai HPS</td>
                                <td>Rp. 7.840.110.000,00</td>
                            </tr>
                            <tr>
                                <td>Jumlah Peserta</td>
                                <td colspan="3">146 Peserta</td>
                            </tr>
                        </table>
                    </div>

                    <div class="tab-pane" id="peserta">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%;">No.</th>
                                    <th>Nama Peserta</th>
                                    <th>NPWP</th>
                                    <th>Harga Penawaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 1; $i <= 25; $i++) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?>.</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php endfor ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane" id="evaluasi">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%;">No.</th>
                                    <th>Nama Peserta</th>
                                    <th class="text-center" title="Evaluasi Kualifikasi" style="width: 5%;"><span class="badge badge-danger">K</span></th>
                                    <th class="text-center" title="Pembuktian Kualifikasi" style="width: 5%;"><span class="badge badge-danger">B</span></th>
                                    <th class="text-center" title="Evaluasi Administrasi" style="width: 5%;"><span class="badge badge-info">A</span></th>
                                    <th class="text-center" title="Evaluasi Teknis" style="width: 5%;"><span class="badge badge-info">T</span></th>
                                    <th title="Harga Penawaran">Harga Penawaran</th>
                                    <th class="text-center" title="Evaluasi Harga dan Biaya" style="width: 5%;"><span class="badge badge-success">H</span></th>
                                    <th class="text-center" title="Pemenang" style="width: 5%;"><span class="badge badge-warning">P</span></th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 1; $i <= 25; $i++) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?>.</td>
                                        <td>Nama</td>
                                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                        <td class="text-center">A</td>
                                        <td class="text-center">T</td>
                                        <td>Rp. 6.849.040.481,73</td>
                                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                        <td class="text-center"><?= ($i == 1) ? '<i class="fas fa-star text-warning"></i>' : '' ?></td>
                                        <td>Alasan</td>
                                    </tr>
                                <?php endfor ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane" id="pemenang">
                        <p>Lorem ipsum sdjfkds fsdjkf fsdkjf pemenang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>