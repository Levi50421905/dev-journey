<?php
/*
  File   : pages/buku/index.php
  Topik  : Daftar Buku — Search & Pagination
  Author : Muhammad Alfarezzi Fallevi (50421905)
*/

session_start();
require_once '../../config/database.php';

$pdo        = getDB();
$page_title = "Daftar Buku";

// Search
$cari      = trim($_GET['cari'] ?? '');
$kategori  = $_GET['kategori'] ?? '';

// Pagination
$per_page    = 7;
$halaman     = max(1, (int) ($_GET['hal'] ?? 1));
$offset      = ($halaman - 1) * $per_page;

// Query dinamis
$where  = "WHERE 1=1";
$params = [];

if ($cari !== '') {
    $where .= " AND (judul LIKE :cari OR pengarang LIKE :cari2)";
    $params[':cari']  = "%$cari%";
    $params[':cari2'] = "%$cari%";
}

if ($kategori !== '') {
    $where .= " AND kategori = :kategori";
    $params[':kategori'] = $kategori;
}

// Hitung total
$stmt        = $pdo->prepare("SELECT COUNT(*) FROM buku $where");
$stmt->execute($params);
$total       = $stmt->fetchColumn();
$total_hal   = ceil($total / $per_page);

// Ambil data dengan limit
$stmt = $pdo->prepare("SELECT * FROM buku $where ORDER BY judul ASC LIMIT :limit OFFSET :offset");
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}
$stmt->bindValue(':limit',  $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset,   PDO::PARAM_INT);
$stmt->execute();
$buku_list = $stmt->fetchAll();

// Ambil semua kategori untuk filter
$kategori_list = $pdo->query("SELECT DISTINCT kategori FROM buku WHERE kategori IS NOT NULL ORDER BY kategori")->fetchAll();

require_once '../../includes/header.php';
?>

<div class="page-header">
  <h1>📚 Daftar Buku</h1>
  <a href="tambah.php" class="btn btn-primary">+ Tambah Buku</a>
</div>

<!-- Search & Filter -->
<div class="card">
  <form method="GET" class="search-bar">
    <input type="text" name="cari" value="<?= htmlspecialchars($cari) ?>"
           placeholder="Cari judul atau pengarang...">
    <select name="kategori" style="padding: 0.55rem 0.875rem; border: 1.5px solid var(--border); border-radius: var(--radius); font-family: var(--font); background: white;">
      <option value="">Semua Kategori</option>
      <?php foreach ($kategori_list as $kat): ?>
        <option value="<?= htmlspecialchars($kat['kategori']) ?>"
          <?= $kategori === $kat['kategori'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($kat['kategori']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-primary">🔍 Cari</button>
    <?php if ($cari || $kategori): ?>
      <a href="index.php" class="btn btn-secondary">Reset</a>
    <?php endif; ?>
  </form>
  <p style="font-size: 0.85rem; color: var(--teks-abu); margin-top: 0.5rem;">
    Menampilkan <?= count($buku_list) ?> dari <?= $total ?> buku
  </p>
</div>

<!-- Tabel Buku -->
<div class="card">
  <?php if (empty($buku_list)): ?>
    <div class="empty-state">
      <div class="empty-icon">📭</div>
      <p>Tidak ada buku ditemukan.</p>
      <?php if ($cari || $kategori): ?>
        <a href="index.php" class="btn btn-secondary" style="margin-top: 1rem;">Lihat Semua</a>
      <?php endif; ?>
    </div>
  <?php else: ?>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Kategori</th>
            <th>Tahun</th>
            <th>Stok</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($buku_list as $i => $buku): ?>
            <tr>
              <td style="color: var(--teks-abu);"><?= $offset + $i + 1 ?></td>
              <td>
                <strong><?= htmlspecialchars($buku['judul']) ?></strong>
                <?php if ($buku['isbn']): ?>
                  <br><small style="color: var(--teks-abu);">ISBN: <?= htmlspecialchars($buku['isbn']) ?></small>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($buku['pengarang']) ?></td>
              <td>
                <?php if ($buku['kategori']): ?>
                  <span class="badge badge-info"><?= htmlspecialchars($buku['kategori']) ?></span>
                <?php else: ?>
                  <span style="color: var(--teks-abu);">—</span>
                <?php endif; ?>
              </td>
              <td><?= $buku['tahun_terbit'] ?? '—' ?></td>
              <td>
                <span class="badge <?= $buku['stok'] > 0 ? 'badge-success' : 'badge-danger' ?>">
                  <?= $buku['stok'] ?> <?= $buku['stok'] > 0 ? 'tersedia' : 'habis' ?>
                </span>
              </td>
              <td>
                <div style="display:flex; gap:0.35rem;">
                  <a href="edit.php?id=<?= $buku['id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                  <a href="hapus.php?id=<?= $buku['id'] ?>"
                     class="btn btn-danger btn-sm"
                     onclick="return confirm('Yakin hapus buku ini?')">🗑️ Hapus</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <?php if ($total_hal > 1): ?>
      <div class="pagination">
        <?php if ($halaman > 1): ?>
          <a href="?hal=<?= $halaman - 1 ?>&cari=<?= urlencode($cari) ?>&kategori=<?= urlencode($kategori) ?>">‹</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_hal; $i++): ?>
          <a href="?hal=<?= $i ?>&cari=<?= urlencode($cari) ?>&kategori=<?= urlencode($kategori) ?>"
             class="<?= $i === $halaman ? 'active' : '' ?>">
            <?= $i ?>
          </a>
        <?php endfor; ?>
        <?php if ($halaman < $total_hal): ?>
          <a href="?hal=<?= $halaman + 1 ?>&cari=<?= urlencode($cari) ?>&kategori=<?= urlencode($kategori) ?>">›</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>

<?php require_once '../../includes/footer.php'; ?>