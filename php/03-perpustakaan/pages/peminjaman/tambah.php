<?php
// pages/peminjaman/tambah.php
session_start();
require_once '../../config/database.php';
$pdo = getDB(); $page_title = "Catat Peminjaman"; $errors = []; $data = [];

$anggota_list = $pdo->query("SELECT id, nama, no_anggota FROM anggota WHERE aktif = 1 ORDER BY nama")->fetchAll();
$buku_list    = $pdo->query("SELECT id, judul, stok FROM buku WHERE stok > 0 ORDER BY judul")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = ['id_anggota' => (int)($_POST['id_anggota'] ?? 0), 'id_buku' => (int)($_POST['id_buku'] ?? 0), 'tgl_pinjam' => $_POST['tgl_pinjam'] ?? date('Y-m-d'), 'durasi' => (int)($_POST['durasi'] ?? 7)];

    if (!$data['id_anggota']) $errors['id_anggota'] = "Pilih anggota.";
    if (!$data['id_buku'])    $errors['id_buku']    = "Pilih buku.";
    if ($data['durasi'] < 1 || $data['durasi'] > 30) $errors['durasi'] = "Durasi 1-30 hari.";

    if (empty($errors)) {
        // Cek stok buku
        $stmt = $pdo->prepare("SELECT stok FROM buku WHERE id = :id");
        $stmt->execute([':id' => $data['id_buku']]);
        $stok = $stmt->fetchColumn();
        if ($stok < 1) $errors['id_buku'] = "Stok buku habis.";
    }

    if (empty($errors)) {
        try {
            $pdo->beginTransaction();
            $tgl_kembali = date('Y-m-d', strtotime($data['tgl_pinjam'] . " + {$data['durasi']} days"));

            $stmt = $pdo->prepare("INSERT INTO peminjaman (id_anggota, id_buku, tgl_pinjam, tgl_kembali) VALUES (:a, :b, :tp, :tk)");
            $stmt->execute([':a' => $data['id_anggota'], ':b' => $data['id_buku'], ':tp' => $data['tgl_pinjam'], ':tk' => $tgl_kembali]);

            $stmt = $pdo->prepare("UPDATE buku SET stok = stok - 1 WHERE id = :id");
            $stmt->execute([':id' => $data['id_buku']]);

            $pdo->commit();
            $_SESSION['success'] = "Peminjaman berhasil dicatat! Batas kembali: " . date('d/m/Y', strtotime($tgl_kembali));
            header('Location: index.php'); exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $errors['general'] = "Gagal menyimpan: " . $e->getMessage();
        }
    }
}

require_once '../../includes/header.php';
?>
<div class="page-header"><h1>📖 Catat Peminjaman</h1><a href="index.php" class="btn btn-secondary">← Kembali</a></div>
<div class="card">
  <?php if (isset($errors['general'])): ?><div class="alert alert-error"><?= $errors['general'] ?></div><?php endif; ?>
  <form method="POST">
    <div class="form-grid">
      <div class="form-group">
        <label>Anggota <span style="color:var(--merah)">*</span></label>
        <select name="id_anggota" style="<?= isset($errors['id_anggota'])?'border-color:var(--merah)':'' ?>">
          <option value="">-- Pilih Anggota --</option>
          <?php foreach ($anggota_list as $a): ?>
            <option value="<?= $a['id'] ?>" <?= ($data['id_anggota'] ?? 0) == $a['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($a['nama']) ?> (<?= $a['no_anggota'] ?>)
            </option>
          <?php endforeach; ?>
        </select>
        <?php if (isset($errors['id_anggota'])): ?><small style="color:var(--merah)"><?= $errors['id_anggota'] ?></small><?php endif; ?>
      </div>
      <div class="form-group">
        <label>Buku <span style="color:var(--merah)">*</span></label>
        <select name="id_buku" style="<?= isset($errors['id_buku'])?'border-color:var(--merah)':'' ?>">
          <option value="">-- Pilih Buku --</option>
          <?php foreach ($buku_list as $b): ?>
            <option value="<?= $b['id'] ?>" <?= ($data['id_buku'] ?? 0) == $b['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($b['judul']) ?> (stok: <?= $b['stok'] ?>)
            </option>
          <?php endforeach; ?>
        </select>
        <?php if (isset($errors['id_buku'])): ?><small style="color:var(--merah)"><?= $errors['id_buku'] ?></small><?php endif; ?>
      </div>
      <div class="form-group">
        <label>Tanggal Pinjam</label>
        <input type="date" name="tgl_pinjam" value="<?= $data['tgl_pinjam'] ?? date('Y-m-d') ?>">
      </div>
      <div class="form-group">
        <label>Durasi (hari) <span style="color:var(--merah)">*</span></label>
        <input type="number" name="durasi" value="<?= $data['durasi'] ?? 7 ?>" min="1" max="30" style="<?= isset($errors['durasi'])?'border-color:var(--merah)':'' ?>">
        <?php if (isset($errors['durasi'])): ?><small style="color:var(--merah)"><?= $errors['durasi'] ?></small><?php endif; ?>
        <small style="color:var(--teks-abu)">Denda Rp 1.000/hari jika terlambat</small>
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">💾 Catat Peminjaman</button>
      <a href="index.php" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
<?php require_once '../../includes/footer.php'; ?>