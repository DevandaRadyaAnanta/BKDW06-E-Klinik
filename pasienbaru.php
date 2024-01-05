<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];

    // Check if the No KTP already exists
    $checkNoKTP = mysqli_query($mysqli, "SELECT * FROM pasien WHERE no_ktp = '$no_ktp'");
    if (mysqli_num_rows($checkNoKTP) > 0) {
        // No KTP already exists, show an alert
        echo "<script>alert('No KTP sudah terdaftar. Pasien dengan No KTP tersebut tidak dapat mendaftar.');</script>";
    } else {
        // No KTP doesn't exist, proceed with insert or update
        if (isset($_POST['id'])) {
            // Update existing patient
            $ubah = mysqli_query($mysqli, "UPDATE pasien SET 
                                              nama = '$nama',
                                              alamat = '$alamat',
                                              no_ktp = '$no_ktp',
                                              no_hp = '$no_hp'
                                              WHERE
                                              id = '" . $_POST['id'] . "'");
        } else {
            // Generate No Rekam Medis
            $date = date('Ym'); // Get current year and month

            // Get the latest sequential number for the current month
            $result = mysqli_query($mysqli, "SELECT MAX(SUBSTRING_INDEX(no_rm, '-', -1)) as max_count FROM pasien WHERE no_rm LIKE '$date%'");
            $data = mysqli_fetch_assoc($result);
            $count = ($data['max_count'] != null) ? $data['max_count'] + 1 : 1;
            $formattedCount = sprintf('%03d', $count); // Format count to have leading zeros
            $no_rm = $date . '-' . $formattedCount;

            // Insert new patient with Nomor Rekam Medis
            $tambah = mysqli_query($mysqli, "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) 
                                              VALUES (
                                                  '$nama',
                                                  '$alamat',
                                                  '$no_ktp',
                                                  '$no_hp',
                                                  '$no_rm'
                                              )");

            if (!$tambah) {
                // Handle insertion error
                echo "<script>alert('Error: " . mysqli_error($mysqli) . "');</script>";
            }
        }

        echo "<script>alert('Berhasil mendaftar. No Rekam Medis: $no_rm'); document.location='index.php?page=pasienbaru';</script>";
    }
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM pasien WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
              document.location='index.php?page=pasienbaru';
              </script>";
}
?>
    <div class="container" style="margin-top: 5.5rem;">
        <div class="row justify-content-center">
            <h2 class="text-center mb-4">Pasien Baru</h2>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center fw-bold" style="font-size: 1.5rem; background-color: #50E2FF;">MASUKKAN DATA ANDA</div>
                    <div class="card-body my-4">
                    <form class="form col" method="POST" action="" name="myForm" onsubmit="return(validate());">
                            <!-- Kode php untuk menghubungkan form dengan database -->
                            <?php
                            $nama = '';
                            $alamat = '';
                            $no_ktp = '';
                            $no_hp = '';
                            if (isset($_GET['id'])) {
                                $ambil = mysqli_query($mysqli, "SELECT * FROM pasien WHERE id='" . $_GET['id'] . "'");
                                while ($row = mysqli_fetch_array($ambil)) {
                                    $nama = $row['nama'];
                                    $alamat = $row['alamat'];
                                    $no_ktp = $row['no_ktp'];
                                    $no_hp = $row['no_hp'];
                                }
                            ?>
                                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                            <?php
                            }
                            ?>
                            <div class="form-group">
                                <label for="inputNama">Nama</label>
                                <input type="text" name="nama" class="form-control" id="inputNama" required placeholder="Masukkan nama anda" value="<?php echo $nama ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputalamat">Alamat</label>
                                <input type="text" name="alamat" class="form-control" id="inputalamat" required placeholder="Masukkan alamat anda" value="<?php echo $alamat ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputNoKtp">No KTP</label>
                                <input type="text" name="no_ktp" class="form-control" id="inputNoKtp" required placeholder="Masukkan nomor KTP" value="<?php echo $no_ktp ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputNoHp">No HP</label>
                                <input type="text" name="no_hp" class="form-control" id="inputNoHp" required placeholder="Masukkan nomor HP" value="<?php echo $no_hp ?>">
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-outline-primary px-4 btn-block" name="simpan">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
