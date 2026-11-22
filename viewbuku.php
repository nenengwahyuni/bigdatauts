<?php
// file: viewbuku.php
require 'koneksi.php';

$active_page = 'viewbuku';
$page_title  = 'Daftar Data Buku & Kategori';
$breadcrumb  = 'Data Buku';

$sql = "SELECT 
            tb_perpus.id, 
            tb_perpus.kode_buku, 
            tb_perpus.judul_buku, 
            tb_perpus.pengarang, 
            tb_perpus.penerbit, 
            tb_perpus.tahun_terbit,
            tb_kategori_buku.nama_kategori_buku
        FROM tb_perpus
        INNER JOIN tb_kategori_buku 
            ON tb_perpus.id_kategori_buku = tb_kategori_buku.id_kategori_buku
        ORDER BY tb_perpus.id ASC";

$result = mysqli_query($koneksi, $sql);
$total_rows = $result ? mysqli_num_rows($result) : 0;

$q_kat = mysqli_query($koneksi, "SELECT nama_kategori_buku FROM tb_kategori_buku ORDER BY id_kategori_buku ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku - Aplikasi Perpustakaan Sederhana</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app-shell">
<?php require 'sidebar.php'; ?>

    <div class="surface-card">
        <div class="card-head">
            <h3>Katalog Koleksi Buku (Relasi INNER JOIN Kategori) <span style="font-size: 11px; color: var(--text-muted); font-weight: 500;">(Klik header untuk sort • klik baris untuk detail)</span></h3>
            <span style="font-size: 13px; color: var(--text-muted);">
                Menampilkan <strong id="visibleCount"><?= $total_rows ?></strong> dari <strong><?= $total_rows ?></strong> buku
            </span>
        </div>

        <div class="toolbar">
            <div class="search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="searchInput" class="search-input" placeholder="Cari kode, judul buku, pengarang, atau penerbit..." onkeyup="filterTable('searchInput', 'bookTable', 'visibleCount')">
            </div>

            <div class="filter-pills">
                <button type="button" class="pill-btn active" onclick="setCategoryFilter('all', this, 'searchInput', 'bookTable', 'visibleCount')">Semua</button>
                <?php if ($q_kat): ?>
                    <?php while ($kat = mysqli_fetch_assoc($q_kat)): ?>
                        <button type="button" class="pill-btn" onclick="setCategoryFilter('<?= htmlspecialchars($kat['nama_kategori_buku'], ENT_QUOTES) ?>', this, 'searchInput', 'bookTable', 'visibleCount')">
                            <?= htmlspecialchars($kat['nama_kategori_buku']) ?>
                        </button>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="table-responsive">
            <table id="bookTable">
                <thead>
                    <tr>
                        <th class="sortable" onclick="sortTable('bookTable', 0, true)" style="width: 75px; text-align: center;">ID <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('bookTable', 1, false)" style="width: 130px;">Kode Buku <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('bookTable', 2, false)">Judul Buku <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('bookTable', 3, false)">Pengarang <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('bookTable', 4, false)">Penerbit <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('bookTable', 5, false)">Kategori Buku <span class="sort-ind">↕</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($total_rows > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr data-row data-category="<?= htmlspecialchars($row['nama_kategori_buku']) ?>" data-book='<?= htmlspecialchars(json_encode($row), ENT_QUOTES, "UTF-8") ?>' onclick="openBookModal(this)">
                                <td style="text-align: center;">
                                    <span class="id-badge">#<?= htmlspecialchars($row['id']) ?></span>
                                </td>
                                <td>
                                    <span class="code-badge"><?= htmlspecialchars($row['kode_buku']) ?></span>
                                </td>
                                <td>
                                    <span class="book-title"><?= htmlspecialchars($row['judul_buku']) ?></span>
                                </td>
                                <td>
                                    <div class="author-cell">
                                        <span class="avatar-initial"><?= getInitials($row['pengarang']) ?></span>
                                        <span><?= htmlspecialchars($row['pengarang']) ?></span>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($row['penerbit']) ?></td>
                                <td>
                                    <span class="badge <?= getKategoriBadgeClass($row['nama_kategori_buku']) ?>">
                                        <?= htmlspecialchars($row['nama_kategori_buku']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 36px; color: var(--text-muted);">
                                Tidak ada data buku di database.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SQL Query Inspector -->
    <div class="sql-card">
        <div class="sql-header" onclick="toggleSql()">
            <div class="sql-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
                </svg>
                SQL Query Inspector (Soal No. 4 - INNER JOIN)
            </div>
            <span id="sqlToggleText" style="font-size: 12px; color: #94a3b8; font-weight: 600;">Tampilkan SQL ▼</span>
        </div>
        <div class="sql-body" id="sqlBody">
            <button type="button" class="btn-copy-sql" onclick="copySql(this)">Salin SQL</button>
            <pre>SELECT 
    tb_perpus.id, 
    tb_perpus.kode_buku, 
    tb_perpus.judul_buku, 
    tb_perpus.pengarang, 
    tb_perpus.penerbit, 
    tb_kategori_buku.nama_kategori_buku
FROM tb_perpus
INNER JOIN tb_kategori_buku 
    ON tb_perpus.id_kategori_buku = tb_kategori_buku.id_kategori_buku
ORDER BY tb_perpus.id ASC;</pre>
        </div>
    </div>

<?php
mysqli_close($koneksi);
require 'footer.php';
?>
