<?php
// pages/peminjaman/kembalikan.php
session_start();
require_once '../../config/database.php';
$pdo = getDB();
$id  = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT p.*, b.judul, a.nama AS nama_anggota FROM peminjaman p JOIN buku b ON p.id_buku = b.id JOIN anggota a ON p.id_anggota = a.id WHERE p.id = :id AND p.status = 'dipinjam'");
$stmt->execute([':id' => $id]);
$pinjam = $stmt->fetch();
if (!$pinjam) { $_SESSION['error'] = "Data tidak ditemukan atau sudah dikembalikan."; header('Location: index.php'); exit; }

// Hitung denda
$hari_terlambat = max(0, (int) ((strtotime('today') - strtotime($pinjam['tgl_kembali'])) / 86400));
$denda = $hari_terlambat * 1000;

try {
    $pdo->beginTransaction();

    $status_baru = $hari_terlambat > 0 ? 'terlambat' : 'dikembalikan';
    $stmt = $pdo->prepare("UPDATE peminjaman SET status = :status, tgl_dikembalikan = CURDATE(), denda = :denda WHERE id = :id");
    $stmt->execute([':status' => $status_baru, ':denda' => $denda, ':id' => $id]);

    $stmt = $pdo->prepare("UPDATE buku SET stok = stok + 1 WHERE id = :id");
    $stmt->execute([':id' => $pinjam['id_buku']]);

    $pdo->commit();

    $pesan = "Buku \"{$pinjam['judul']}\" berhasil dikembalikan.";
    if ($denda > 0) $pesan .= " Denda: Rp " . number_format($denda);
    $_SESSION['success'] = $pesan;
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['error'] = "Gagal memproses pengembalian.";
}

header('Location: index.php'); exit;