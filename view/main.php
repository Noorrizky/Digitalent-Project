<?php
include "../config/koneksi.php";

if ($_GET['page'] == 'beranda') {
    // Ambil data dari database
    $query = "SELECT * FROM pariwisata";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        ?>
        <!-- Beranda Start ------------------------------------------------------------------------------------------------------------->
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-7">
                    <div class="row">
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <a href="<?= $row['link_info'] ?>" target="_blank">
                                        <div class="resolusi-gambar-card">
                                            <img src="<?= $row['gambar'] ?>" class="card-img-top" alt="Gambar <?= $row['nama'] ?>" />
                                        </div>
                                    </a>
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?= $row['nama'] ?></h5>
                                        <p class="card-text"><?= $row['deskripsi'] ?></p>
                                        <a href="<?= $row['link_video'] ?>" class="btn btn-primary" target="_blank">Informasi Lebih Lanjut</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <!-- Video Youtube  -->
                <div class="col-md-5">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe width="949" height="534" src="https://www.youtube.com/embed/ojQbArbuN4E" title="Wonderful Indonesia : A Visual Journey" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="embed-responsive embed-responsive-16by9" style="margin-top: 20px; margin-bottom: 20px">
                        <iframe width="949" height="534" src="https://www.youtube.com/embed/KAhWQclewoE" title="Video Kreatif BBWI - Desinasi Wisata Unggulan Kalimantan Selatan" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- Beranda End ------------------------------------------------------------------------------------------------------------->
        <?php
    } else {
        echo "Tidak ada data.";
    }
} elseif ($_GET['page'] == 'daftarPaket') {
    ?>
    <!-- Page Daftar Paket  ------------------------------------------------------------->
    <div class="container mt-5">
        <h2>Form Pemesanan Paket Perjalanan</h2>
        <form action="../aksi/simpan_paket.php" method="post" id="formPaket">
            <div class="form-group">
                <label for="nama_pemesanan">Nama Pemesanan</label>
                <input type="text" class="form-control" id="nama_pemesanan" name="nama_pemesanan" required>
            </div>
            <div class="form-group">
                <label for="nomor_hp">Nomor HP</label>
                <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" required>
            </div>
            <div class="form-group">
                <label for="tanggal_pesan">Tanggal Pesan</label>
                <input type="date" class="form-control" id="tanggal_pesan" name="tanggal_pesan" required>
            </div>

            <div class="form-group">
                <label for="pelayanan_paket">Pelayanan Paket Perjalanan</label><br>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="penginapan" name="pelayanan_paket[]" value="Penginapan">
                    <label class="form-check-label" for="penginapan">Penginapan Rp.1.000.000</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="transportasi" name="pelayanan_paket[]" value="Transportasi">
                    <label class="form-check-label" for="transportasi">Transportasi Rp.1.200.000</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="servis_makan" name="pelayanan_paket[]" value="Servis/Makan">
                    <label class="form-check-label" for="servis_makan">Servis/Makan Rp.500.000</label>
                </div>
            </div>
            <div class="form-group">
                <label for="jumlah_hari">Jumlah Hari</label>
                <input type="number" class="form-control" id="jumlah_hari" name="jumlah_hari" required>
            </div>
            <div class="form-group">
                <label for="total_harga_paket">Total Harga Paket</label>
                <input type="number" class="form-control" id="total_harga_paket" name="total_harga_paket" required readonly>
            </div>
            <div class="form-group">
                <label for="jumlah_peserta">Jumlah Peserta</label>
                <input type="number" class="form-control" id="jumlah_peserta" name="jumlah_peserta" required>
            </div>
            <div class="form-group">
                <label for="total_jumlah_tagihan">Total Jumlah Tagihan</label>
                <input type="number" class="form-control" id="total_jumlah_tagihan" name="total_jumlah_tagihan" required readonly>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-warning">Reset</button>
        </form>
    </div>
    <!-- Page Daftar Paket  ------------------------------------------------------------->
    <script>
    document.getElementById('formPaket').addEventListener('input', calculateTotal);
    document.getElementById('formPaket').addEventListener('change', calculateTotal);

    function calculateTotal() {
        const checkboxes = document.querySelectorAll('input[name="pelayanan_paket[]"]:checked');
        const jumlahPeserta = document.getElementById('jumlah_peserta').value;
        const jumlahHari = document.getElementById('jumlah_hari').value;

        let hargaPaketPerDay = 0;

        checkboxes.forEach((checkbox) => {
            if (checkbox.value === 'Penginapan') {
                hargaPaketPerDay += 1000000;
            } else if (checkbox.value === 'Transportasi') {
                hargaPaketPerDay += 1200000;
            } else if (checkbox.value === 'Servis/Makan') {
                hargaPaketPerDay += 500000;
            }
        });

        const totalHargaPaket = jumlahHari * hargaPaketPerDay; // Total cost per day
        const totalJumlahTagihan = totalHargaPaket * jumlahPeserta; // Total cost for all days

        document.getElementById('total_harga_paket').value = totalHargaPaket;
        document.getElementById('total_jumlah_tagihan').value = totalJumlahTagihan;
    }
    </script>

    <!-- Page Pesanan  --------------------------------------------------------------------------------------------------------------------->
    <?php
} elseif ($_GET['page'] == 'pesanan') {
    $query = "SELECT * FROM daftar_paket";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        ?>
        <div class="container mt-5">
            <h2>Detail Paket Perjalanan</h2>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nama Pemesanan</th>
                        <th>Nomor HP</th>
                        <th>Tanggal Pesan</th>
                        <th>Pelayanan Paket</th>
                        <th>Jumlah Peserta</th>
                        <th>Jumlah Hari</th>
                        <th>Total Jumlah Tagihan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['nama_pemesanan'] ?></td>
                            <td><?= $row['nomor_hp'] ?></td>
                            <td><?= $row['tanggal_pesan'] ?></td>
                            <td><?= $row['pelayanan_paket'] ?></td>
                            <td><?= $row['jumlah_peserta'] ?></td>
                            <td><?= $row['jumlah_hari'] ?></td>
                            <td><?= number_format($row['total_jumlah_tagihan'], 0, ',', '.') ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    } else {
        echo "<div class='container mt-5'>Tidak ada data untuk ditampilkan.</div>";
    }
}
?>
