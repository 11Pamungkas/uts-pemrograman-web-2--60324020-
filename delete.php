<?php
require_once 'config/database.php';


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $stmt_check = $conn->prepare("SELECT id_kategori FROM kategori WHERE id_kategori = ?");
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $stmt_del = $conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
        $stmt_del->bind_param("i", $id);
        
        if ($stmt_del->execute()) {
   s
            if ($stmt_del->affected_rows > 0) {
                $pesan = "Kategori berhasil dihapus.";
                $pesanType = 'info';
            } else {
                $pesan = "Gagal menghapus data kategori.";
                $pesanType = 'error';
            }
        } else {
            $pesan = "Terjadi kesalahan sistem saat menghapus data.";
            $pesanType = 'error';
        }
        $stmt_del->close();
    } else {
        $pesan = "Data tidak ditemukan, gagal menghapus.";
        $pesanType = 'error';
    }
    $stmt_check->close();
} else {
    $pesan = "ID tidak valid.";
    $pesanType = 'error';
}

header("Location: index.php?pesan=" . urlencode($pesan) . "&type=" . $pesanType);
exit();
?>