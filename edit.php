<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'config/database.php';
    
    $errors = [];
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    if (empty($id)) {
        header("Location: index.php?pesan=ID tidak ditemukan");
        exit();
    }

    $stmt_get = $conn->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
    $stmt_get->bind_param("i", $id);
    $stmt_get->execute();
    $result = $stmt_get->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        header("Location: index.php?pesan=Data tidak ditemukan di database");
        exit();
    }
    $stmt_get->close();

  
    $kode = $data['kode_kategori'];
    $nama = $data['nama_kategori'];
    $deskripsi = $data['deskripsi'];
    $status = $data['status'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $kode = strtoupper(trim($_POST['kode_kategori']));
        $nama = trim($_POST['nama_kategori']);
        $deskripsi = trim($_POST['deskripsi']);
        $status = $_POST['status'];

        if (empty($kode)) {
            $errors[] = "Kode kategori wajib diisi.";
        } elseif (substr($kode, 0, 4) !== "KAT-") {
            $errors[] = "Kode harus diawali 'KAT-'.";
        } else {

            $stmt_check = $conn->prepare("SELECT id_kategori FROM kategori WHERE kode_kategori = ? AND id_kategori != ?");
            $stmt_check->bind_param("si", $kode, $id);
            $stmt_check->execute();
            $stmt_check->store_result();
            if ($stmt_check->num_rows > 0) {
                $errors[] = "Kode kategori sudah digunakan oleh data lain.";
            }
            $stmt_check->close();
        }

        if (empty($nama) || strlen($nama) < 3) {
            $errors[] = "Nama kategori minimal 3 karakter.";
        }

        if (empty($errors)) {
            $sql = "UPDATE kategori SET kode_kategori = ?, nama_kategori = ?, deskripsi = ?, status = ? WHERE id_kategori = ?";
            $stmt_upd = $conn->prepare($sql);
            $stmt_upd->bind_param("ssssi", $kode, $nama, $deskripsi, $status, $id);

            if ($stmt_upd->execute()) {
                header("Location: index.php?pesan=Data kategori berhasil diperbarui&type=info");
                exit();
            } else {
                $errors[] = "Gagal memperbarui data: " . $conn->error;
            }
            $stmt_upd->close();
        }
    }
    ?>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-warning">
                        <h4 class="mb-0">Edit Kategori</h4>
                    </div>
                    <div class="card-body">
                        
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <!-- B. Form Pre-filled -->
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Kode Kategori</label>
                                <input type="text" name="kode_kategori" class="form-control" value="<?php echo htmlspecialchars($kode); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <input type="text" name="nama_kategori" class="form-control" value="<?php echo htmlspecialchars($nama); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3"><?php echo htmlspecialchars($deskripsi); ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="aktif" value="Aktif" <?php echo ($status == 'Aktif') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="aktif">Aktif</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="nonaktif" value="Nonaktif" <?php echo ($status == 'Nonaktif') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="nonaktif">Nonaktif</label>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning">Perbarui Data</button>
                                <a href="index.php" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>