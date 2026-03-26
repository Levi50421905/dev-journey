<?php
/*
  File   : pages/buku/tambah.php
  Topik  : Form Tambah Buku + Validasi + Insert ke DB
  Author : Muhammad Alfarezzi Fallevi (50421905)
*/

session_start();
require_once '../../config/database.php';

$pdo        = getDB();
$page_title = "Tambah Buku";
$errors     = [];
$data       = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*
      $_SERVER['REQUEST_METHOD'] === 'POST'
      → cek apakah form sudah di-submit
      Lebih aman daripada cek isset($_POST['submit'])
    */

    // Ambil & bersihkan input
    $data = [
        'judul'        => trim($_POST['judul']        ?? ''),
        'pengarang'    => trim($_POST['pengarang']    ?? ''),
        'penerbit'     => trim($_POST['penerbit']     ?? ''),
        'tahun_terbit' => trim($_POST['tahun_terbit'] ?? ''),
        'isbn'         => trim($_POST['isbn']         ?? ''),
        'stok'         => trim($_POST['stok']         ?? '0'),
        'kategori'     => trim($_POST['kategori']     ?? ''),
    ];

    // Validasi
    if (empty($data['judul'])) {
        $errors['judul'] = "Judul wajib diisi.";
    } elseif (strlen($data['judul']) > 200) {
        $errors['judul'] = "Judul maksimal 200 karakter.";
    }

    if (empty($data['pengarang'])) {
        $errors['pengarang'] = "Pengarang wajib diisi.";
    }

    if (!empty($data['tahun_terbit']) && (!is_numeric($data['tahun_terbit']) || $data['tahun_terbit'] < 1900 || $data['tahun_terbit'] > date('Y'))) {
        $errors['tahun_terbit'] = "Tahun terbit tidak valid.";
    }

    if (!is_numeric($data['stok']) || $data['stok'] < 0) {
        $errors['stok'] = "Stok harus angka positif.";
    }

    if (!empty($data['isbn'])) {
        // Cek ISBN unik
        $stmt = $pdo->prepare("SELECT id FROM buku WHERE isbn = :isbn");
        $stmt->execute([':isbn' => $data['isbn']]);
        if ($stmt->fetch()) {
            $errors['isbn'] = "ISBN sudah terdaftar.";
        }
    }

    // Jika tidak ada error → simpan ke database
    if (empty($errors)) {
        $stmt = $pdo->prepare("
            INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, isbn, stok, kategori)
            VALUES (:judul, :pengarang, :penerbit, :tahun_terbit, :isbn, :stok, :kategori)
        ");

        $stmt->execute([
            ':judul'        => $data['judul'],
            ':pengarang'    => $data['pengarang'],
            ':penerbit'     => $data['penerbit'] ?: null,
            ':tahun_terbit' => $data['tahun_terbit'] ?: null,
            ':isbn'         => $data['isbn'] ?: null,
            ':stok'         => (int) $data['stok'],
            ':kategori'     => $data['kategori'] ?: null,
        ]);

        $_SESSION['success'] = "Buku \"" . htmlspecialchars($data['judul']) . "\" berhasil ditambahkan!";
        header('Location: index.php');
        exit;
        /*
          Header redirect + exit — PENTING!
          Tanpa exit setelah header(), kode di bawah tetap dijalankan.
          Redirect mencegah form di-submit ulang saat refresh halaman (PRG pattern).
          PRG = Post/Redirect/Get
        */
    }
}

require_once '../../includes/header.php';
?>

<div class="page-header">
  <h1>➕ Tambah Buku</h1>
  <a href="index.php" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card">
  <form method="POST" action="">
    <div class="form-grid">

      <!-- Judul -->
      <div class="form-group" style="grid-column: 1 / -1;">
        <label for="judul">Judul Buku <span style="color:var(--merah);">*</span></label>
        <input type="text" id="judul" name="judul"
               value="<?= htmlspecialchars($data['judul'] ?? '') ?>"
               placeholder="Masukkan judul buku"
               style="<?= isset($errors['judul']) ? 'border-color: var(--merah);' : '' ?>">
        <?php if (isset($errors['judul'])): ?>
          <small style="color: var(--merah);"><?= $errors['judul'] ?></small>
        <?php endif; ?>
      </div>

      <!-- Pengarang -->
      <div class="form-group">
        <label for="pengarang">Pengarang <span style="color:var(--merah);">*</span></label>
        <input type="text" id="pengarang" name="pengarang"
               value="<?= htmlspecialchars($data['pengarang'] ?? '') ?>"
               placeholder="Nama pengarang"
               style="<?= isset($errors['pengarang']) ? 'border-color: var(--merah);' : '' ?>">
        <?php if (isset($errors['pengarang'])): ?>
          <small style="color: var(--merah);"><?= $errors['pengarang'] ?></small>
        <?php endif; ?>
      </div>

      <!-- Penerbit -->
      <div class="form-group">
        <label for="penerbit">Penerbit</label>
        <input type="text" id="penerbit" name="penerbit"
               value="<?= htmlspecialchars($data['penerbit'] ?? '') ?>"
               placeholder="Nama penerbit">
      </div>

      <!-- Tahun Terbit -->
      <div class="form-group">
        <label for="tahun_terbit">Tahun Terbit</label>
        <input type="number" id="tahun_terbit" name="tahun_terbit"
               value="<?= htmlspecialchars($data['tahun_terbit'] ?? '') ?>"
               placeholder="<?= date('Y') ?>" min="1900" max="<?= date('Y') ?>"
               style="<?= isset($errors['tahun_terbit']) ? 'border-color: var(--merah);' : '' ?>">
        <?php if (isset($errors['tahun_terbit'])): ?>
          <small style="color: var(--merah);"><?= $errors['tahun_terbit'] ?></small>
        <?php endif; ?>
      </div>

      <!-- ISBN -->
      <div class="form-group">
        <label for="isbn">ISBN</label>
        <input type="text" id="isbn" name="isbn"
               value="<?= htmlspecialchars($data['isbn'] ?? '') ?>"
               placeholder="978-xxxxxxxxxx"
               style="<?= isset($errors['isbn']) ? 'border-color: var(--merah);' : '' ?>">
        <?php if (isset($errors['isbn'])): ?>
          <small style="color: var(--merah);"><?= $errors['isbn'] ?></small>
        <?php endif; ?>
      </div>

      <!-- Stok -->
      <div class="form-group">
        <label for="stok">Stok <span style="color:var(--merah);">*</span></label>
        <input type="number" id="stok" name="stok"
               value="<?= htmlspecialchars($data['stok'] ?? '0') ?>"
               min="0" placeholder="0"
               style="<?= isset($errors['stok']) ? 'border-color: var(--merah);' : '' ?>">
        <?php if (isset($errors['stok'])): ?>
          <small style="color: var(--merah);"><?= $errors['stok'] ?></small>
        <?php endif; ?>
      </div>

      <!-- Kategori -->
      <div class="form-group">
        <label for="kategori">Kategori</label>
        <select id="kategori" name="kategori">
          <option value="">-- Pilih Kategori --</option>
          <?php
          $kategori_opt = ['Pemrograman', 'Database', 'Web Development', 'Data Science', 'Ilmu Komputer', 'Lainnya'];
          foreach ($kategori_opt as $opt):
          ?>
            <option value="<?= $opt ?>" <?= ($data['kategori'] ?? '') === $opt ? 'selected' : '' ?>>
              <?= $opt ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

    </div><!-- end form-grid -->

    <div class="form-actions">
      <button type="submit" class="btn btn-primary">💾 Simpan Buku</button>
      <a href="index.php" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

<?php require_once '../../includes/footer.php'; ?>