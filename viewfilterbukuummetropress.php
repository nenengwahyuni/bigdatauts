<?php
// file: viewfilterbukuummetropress.php
require 'koneksi.php';

$active_page = 'umpress';
$page_title  = 'Filter Penerbit: UM Metro Press';
$breadcrumb  = 'UM Metro Press';

// Query 1: Menghitung informasi total buku terbitan UM Metro Press
$sql_total = "SELECT COUNT(*) AS total_buku 
              FROM tb_perpus 
              WHERE penerbit = 'UM Metro Press'";
$res_total = mysqli_query($koneksi, $sql_total);
$total_buku = mysqli_fetch_assoc($res_total)['total_buku'] ?? 0;

// Query 2: Mengambil daftar informasi buku terbitan UM Metro Press
$sql = "SELECT p.id, p.kode_buku, p.judul_buku, p.pengarang, p.penerbit, p.tahun_terbit, k.nama_kategori_buku
        FROM tb_perpus p
        LEFT JOIN tb_kategori_buku k ON p.id_kategori_buku = k.id_kategori_buku
        WHERE p.penerbit = 'UM Metro Press'
        ORDER BY p.id ASC";
$result = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Penerbit UM Metro Press - Aplikasi Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app-shell">
<?php require 'sidebar.php'; ?>

    <section class="hero-banner" style="padding: 26px 32px;">
        <div class="hero-orb-1"></div>
        <div class="hero-orb-2"></div>
        <div class="hero-content">
            <div class="hero-tag">PENERBIT KAMPUS TERVERIFIKASI</div>
            <h1 style="font-size: 23px; margin-bottom: 6px;">Koleksi Terbitan "UM Metro Press"</h1>
            <p style="font-size: 13.5px; min-height: auto;">Menampilkan informasi total agregasi koleksi dan daftar buku resmi yang diterbitkan oleh <strong>UM Metro Press</strong>.</p>
        </div>
        <div class="hero-visual" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(56,189,248,0.35); border-radius: 16px; padding: 18px 28px; text-align: center; flex-shrink: 0; box-shadow: 0 10px 25px rgba(0,0,0,0.25);">
            <span style="display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 0.9px; color: #7dd3fc; font-weight: 700;">Total Buku</span>
            <span style="font-size: 38px; font-weight: 800; color: #ffffff; line-height: 1.15; display: block;" data-count="<?= (int)$total_buku ?>">0</span>
            <span style="display: block; font-size: 12px; color: #cbd5e1;">Judul Tersedia</span>
        </div>
    </section>

    <div class="surface-card">
        <div class="card-head">
            <h3>Daftar Buku Terbitan UM Metro Press <span style="font-size: 11px; color: var(--text-muted); font-weight: 500;">(Klik baris untuk detail)</span></h3>
            <span style="font-size: 13px; color: var(--text-muted);">
                Menampilkan <strong id="visibleCount"><?= $total_buku ?></strong> dari <strong><?= $total_buku ?></strong> buku
            </span>
        </div>

        <div class="toolbar">
            <div class="search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="searchInput" class="search-input" placeholder="Cari kode, judul buku, pengarang, atau tahun..." onkeyup="filterTable('searchInput', 'umpTable', 'visibleCount')">
            </div>
        </div>

        <div class="table-responsive">
            <table id="umpTable">
                <thead>
                    <tr>
                        <th class="sortable" onclick="sortTable('umpTable', 0, true)" style="width: 75px; text-align: center;">ID <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('umpTable', 1, false)" style="width: 130px;">Kode Buku <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('umpTable', 2, false)">Judul Buku <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('umpTable', 3, false)">Pengarang <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('umpTable', 4, false)">Penerbit <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('umpTable', 5, true)" style="width: 130px; text-align: center;">Tahun Terbit <span class="sort-ind">↕</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr data-row data-book='<?= htmlspecialchars(json_encode($row), ENT_QUOTES, "UTF-8") ?>' onclick="openBookModal(this)">
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
                                <td>
                                    <span class="badge badge-pub"><?= htmlspecialchars($row['penerbit']) ?></span>
                                </td>
                                <td style="text-align: center; font-weight: 700;">
                                    <?= htmlspecialchars($row['tahun_terbit']) ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 36px; color: var(--text-muted);">
                                Tidak ada data buku dari penerbit UM Metro Press.
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
                SQL Query Inspector (Soal No. 6 - Total &amp; Filter Penerbit)
            </div>
            <span id="sqlToggleText" style="font-size: 12px; color: #94a3b8; font-weight: 600;">Tampilkan SQL ▼</span>
        </div>
        <div class="sql-body" id="sqlBody">
            <button type="button" class="btn-copy-sql" onclick="copySql(this)">Salin SQL</button>
            <pre>-- 1. Menghitung total buku terbitan UM Metro Press
SELECT COUNT(*) AS total_buku 
FROM tb_perpus 
WHERE penerbit = 'UM Metro Press';

-- 2. Menampilkan daftar informasi buku terbitan UM Metro Press
SELECT id, kode_buku, judul_buku, pengarang, penerbit, tahun_terbit
FROM tb_perpus
WHERE penerbit = 'UM Metro Press'
ORDER BY id ASC;</pre>
        </div>
    </div>

<?php
mysqli_close($koneksi);
require 'footer.php';
?>
