<?php
/*
  File   : index.php (root)
  Topik  : Dashboard Sistem Perpustakaan
  Folder : php/03-perpustakaan/
  Author : Muhammad Alfarezzi Fallevi (50421905)
*/

session_start();
require_once 'config/database.php';

$pdo         = getDB();
$page_title  = "Dashboard";

// Ambil statistik
$total_buku      = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
$total_anggota   = $pdo->query("SELECT COUNT(*) FROM anggota WHERE aktif = 1")->fetchColumn();
$total_dipinjam  = $pdo->query("SELECT COUNT(*) FROM peminjaman WHERE status = 'dipinjam'")->fetchColumn();
$total_terlambat = $pdo->query("SELECT COUNT(*) FROM peminjaman WHERE status = 'terlambat'")->fetchColumn();

// Peminjaman aktif terbaru
$stmt = $pdo->query("
    SELECT p.id, a.nama AS nama_anggota, b.judul AS judul_buku,
           p.tgl_pinjam, p.tgl_kembali, p.status,
           DATEDIFF(CURDATE(), p.tgl_kembali) AS hari_terlambat
    FROM peminjaman p
    JOIN anggota a ON p.id_anggota = a.id
    JOIN buku    b ON p.id_buku    = b.id
    WHERE p.status = 'dipinjam'
    ORDER BY p.tgl_kembali ASC
    LIMIT 5
");
$peminjaman_aktif = $stmt->fetchAll();

require_once 'includes/header.php';
?>

<div class="page-header">
  <h1>📊 Dashboard</h1>
  <span style="color: var(--teks-abu); font-size: 0.9rem;">
    <?= date('l, d F Y') ?>
  </span>
</div>

<!-- Statistik -->
<div class="stats-grid">
  <a href="pages/buku/index.php" class="stat-card" style="text-decoration:none;">
    <div class="stat-icon">📚</div>
    <div>
      <div class="stat-label">Total Buku</div>
      <div class="stat-value"><?= $total_buku ?></div>
    </div>
  </a>
  <a href="pages/anggota/index.php" class="stat-card" style="text-decoration:none;">
    <div class="stat-icon">👥</div>
    <div>
      <div class="stat-label">Total Anggota</div>
      <div class="stat-value"><?= $total_anggota ?></div>
    </div>
  </a>
  <a href="pages/peminjaman/index.php" class="stat-card" style="text-decoration:none;">
    <div class="stat-icon">📖</div>
    <div>
      <div class="stat-label">Sedang Dipinjam</div>
      <div class="stat-value"><?= $total_dipinjam ?></div>
    </div>
  </a>
  <div class="stat-card" style="border-color: <?= $total_terlambat > 0 ? '#fca5a5' : 'var(--border)' ?>;">
    <div class="stat-icon">⚠️</div>
    <div>
      <div class="stat-label">Terlambat</div>
      <div class="stat-value" style="color: <?= $total_terlambat > 0 ? 'var(--merah)' : 'var(--teks)' ?>;">
        <?= $total_terlambat ?>
      </div>
    </div>
  </div>
</div>

<!-- Peminjaman Aktif -->
<div class="card">
  <div class="page-header" style="margin-bottom: 1rem;">
    <h2 style="margin:0;">📋 Peminjaman Aktif</h2>
    <a href="pages/peminjaman/tambah.php" class="btn btn-primary">+ Tambah Peminjaman</a>
  </div>

  <?php if (empty($peminjaman_aktif)): ?>
    <div class="empty-state">
      <div class="empty-icon">📭</div>
      <p>Tidak ada peminjaman aktif.</p>
    </div>
  <?php else: ?>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Anggota</th>
            <th>Buku</th>
            <th>Tgl Pinjam</th>
            <th>Batas Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($peminjaman_aktif as $p): ?>
            <?php
              $terlambat = $p['hari_terlambat'] > 0;
              $statusBadge = $terlambat
                ? "<span class='badge badge-danger'>Terlambat {$p['hari_terlambat']} hari</span>"
                : "<span class='badge badge-info'>Dipinjam</span>";
            ?>
            <tr>
              <td><?= htmlspecialchars($p['nama_anggota']) ?></td>
              <td><?= htmlspecialchars($p['judul_buku']) ?></td>
              <td><?= date('d/m/Y', strtotime($p['tgl_pinjam'])) ?></td>
              <td style="color: <?= $terlambat ? 'var(--merah)' : 'inherit' ?>; font-weight: <?= $terlambat ? '600' : 'normal' ?>;">
                <?= date('d/m/Y', strtotime($p['tgl_kembali'])) ?>
              </td>
              <td><?= $statusBadge ?></td>
              <td>
                <a href="pages/peminjaman/kembalikan.php?id=<?= $p['id'] ?>"
                   class="btn btn-success btn-sm">Kembalikan</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div style="margin-top: 1rem; text-align: right;">
      <a href="pages/peminjaman/index.php" class="btn btn-secondary btn-sm">Lihat Semua →</a>
    </div>
  <?php endif; ?>
</div>

<!-- Quick Links -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
  <a href="pages/buku/tambah.php" class="card" style="text-decoration:none; text-align:center; padding: 1.5rem;">
    <div style="font-size: 2rem; margin-bottom: 0.5rem;">➕📚</div>
    <p style="font-weight: 600; color: var(--teks);">Tambah Buku</p>
  </a>
  <a href="pages/anggota/tambah.php" class="card" style="text-decoration:none; text-align:center; padding: 1.5rem;">
    <div style="font-size: 2rem; margin-bottom: 0.5rem;">➕👤</div>
    <p style="font-weight: 600; color: var(--teks);">Tambah Anggota</p>
  </a>
  <a href="pages/peminjaman/tambah.php" class="card" style="text-decoration:none; text-align:center; padding: 1.5rem;">
    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📖✅</div>
    <p style="font-weight: 600; color: var(--teks);">Catat Peminjaman</p>
  </a>
</div>

<?php require_once 'includes/footer.php'; ?>