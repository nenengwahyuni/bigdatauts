<?php
// file: viewfilterbukuterbaru.php
require 'koneksi.php';

$active_page = 'terbaru';
$page_title  = 'Filter Data Buku "Terbaru"';
$breadcrumb  = 'Buku Terbaru (> 2020)';

$sql = "SELECT p.id, p.kode_buku, p.judul_buku, p.pengarang, p.penerbit, p.tahun_terbit, k.nama_kategori_buku
        FROM tb_perpus p
        LEFT JOIN tb_kategori_buku k ON p.id_kategori_buku = k.id_kategori_buku
        WHERE p.tahun_terbit > 2020
        ORDER BY p.tahun_terbit DESC, p.id ASC";

$result = mysqli_query($koneksi, $sql);
$total_terbaru = $result ? mysqli_num_rows($result) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Buku Terbaru (&gt; 2020) - Aplikasi Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app-shell">
<?php require 'sidebar.php'; ?>

    <section class="kpi-grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));">
        <div class="kpi-card spotlight-card">
            <div>
                <div class="kpi-label">Total Buku Terbaru</div>
                <div class="kpi-value"><span data-count="<?= (int)$total_terbaru ?>">0</span> Buku</div>
                <div class="kpi-sub">Terbit setelah tahun 2020</div>
            </div>
            <div class="kpi-icon-box bg-emerald">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card spotlight-card">
            <div>
                <div class="kpi-label">Parameter Query Filter</div>
                <div class="kpi-value" style="font-size: 18px; font-family: 'JetBrains Mono', monospace; padding-top: 6px; color: var(--accent);">tahun_terbit &gt; 2020</div>
                <div class="kpi-sub">Diurutkan dari tahun terbit paling baru</div>
            </div>
            <div class="kpi-icon-box bg-indigo">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                </svg>
            </div>
        </div>
    </section>

    <div class="surface-card">
        <div class="card-head">
            <h3>Daftar Koleksi Terbitan Terbaru (&gt; Tahun 2020) <span style="font-size: 11px; color: var(--text-muted); font-weight: 500;">(Klik baris untuk detail)</span></h3>
            <span style="font-size: 13px; color: var(--text-muted);">
                Menampilkan <strong id="visibleCount"><?= $total_terbaru ?></strong> buku
            </span>
        </div>

        <div class="toolbar">
            <div class="search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="searchInput" class="search-input" placeholder="Cari judul buku, pengarang, penerbit, atau tahun..." onkeyup="filterTable('searchInput', 'terbaruTable', 'visibleCount')">
            </div>
        </div>

        <div class="table-responsive">
            <table id="terbaruTable">
                <thead>
                    <tr>
                        <th class="sortable" onclick="sortTable('terbaruTable', 0, true)" style="width: 75px; text-align: center;">ID <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('terbaruTable', 1, false)" style="width: 130px;">Kode Buku <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('terbaruTable', 2, false)">Judul Buku <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('terbaruTable', 3, false)">Pengarang <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('terbaruTable', 4, false)">Penerbit <span class="sort-ind">↕</span></th>
                        <th class="sortable" onclick="sortTable('terbaruTable', 5, true)" style="width: 140px; text-align: center;">Tahun Terbit <span class="sort-ind">↕</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($total_terbaru > 0): ?>
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
                                <td><?= htmlspecialchars($row['penerbit']) ?></td>
                                <td style="text-align: center;">
                                    <span class="badge badge-year-new">
                                        ✓ <?= htmlspecialchars($row['tahun_terbit']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 36px; color: var(--text-muted);">
                                Tidak ada buku dengan tahun terbit di atas 2020.
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
                SQL Query Inspector (Soal No. 5 - Filter Tahun &gt; 2020)
            </div>
            <span id="sqlToggleText" style="font-size: 12px; color: #94a3b8; font-weight: 600;">Tampilkan SQL ▼</span>
        </div>
        <div class="sql-body" id="sqlBody">
            <button type="button" class="btn-copy-sql" onclick="copySql(this)">Salin SQL</button>
            <pre>SELECT id, kode_buku, judul_buku, pengarang, penerbit, tahun_terbit
FROM tb_perpus
WHERE tahun_terbit &gt; 2020
ORDER BY tahun_terbit DESC, id ASC;</pre>
        </div>
    </div>

<?php
mysqli_close($koneksi);
require 'footer.php';
?>
