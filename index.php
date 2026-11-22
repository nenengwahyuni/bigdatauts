<?php
// file: index.php
require 'koneksi.php';

$active_page = 'home';
$page_title  = 'Dashboard Perpustakaan';
$breadcrumb  = 'Home';

// Statistik KPI
$total_buku    = (int)(mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS t FROM tb_perpus"))['t'] ?? 0);
$total_terbaru = (int)(mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS t FROM tb_perpus WHERE tahun_terbit > 2020"))['t'] ?? 0);
$total_ump     = (int)(mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS t FROM tb_perpus WHERE penerbit = 'UM Metro Press'"))['t'] ?? 0);
$total_kat     = (int)(mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS t FROM tb_kategori_buku"))['t'] ?? 0);

// Preview buku lengkap
$q_preview = mysqli_query($koneksi, "SELECT p.id, p.kode_buku, p.judul_buku, p.pengarang, p.penerbit, p.tahun_terbit, k.nama_kategori_buku
                                      FROM tb_perpus p
                                      INNER JOIN tb_kategori_buku k ON p.id_kategori_buku = k.id_kategori_buku
                                      ORDER BY p.id ASC");

// Distribusi per kategori untuk Donut Chart
$q_dist_kat = mysqli_query($koneksi, "SELECT k.nama_kategori_buku, COUNT(p.id) AS jumlah
                                       FROM tb_kategori_buku k
                                       LEFT JOIN tb_perpus p ON k.id_kategori_buku = p.id_kategori_buku
                                       GROUP BY k.id_kategori_buku, k.nama_kategori_buku
                                       ORDER BY jumlah DESC");
$kat_data = [];
while ($dk = mysqli_fetch_assoc($q_dist_kat)) {
    $kat_data[] = $dk;
}

// Distribusi per penerbit
$q_dist_pub = mysqli_query($koneksi, "SELECT penerbit, COUNT(*) AS jumlah
                                       FROM tb_perpus
                                       GROUP BY penerbit
                                       ORDER BY jumlah DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Perpustakaan Sederhana</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app-shell">
<?php require 'sidebar.php'; ?>

    <!-- Hero Banner -->
    <section class="hero-banner">
        <div class="hero-orb-1"></div>
        <div class="hero-orb-2"></div>

        <div class="hero-content">
            <div class="hero-tag">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
                UTS MK BIG DATA • ILMU KOMPUTER UM METRO
            </div>
            <h1>Selamat Datang di Aplikasi Perpustakaan Sederhana</h1>
            <p id="typewriterText" data-text="Portal manajemen & analitik koleksi buku berbasis PHP & MySQL (myperpus). Klik baris buku untuk detail interaktif atau jelajahi filter relasional."></p>
            <div class="hero-actions">
                <a href="viewbuku.php" class="btn btn-hero-light">Jelajahi Katalog Buku →</a>
                <a href="viewfilterbukuterbaru.php" class="btn btn-hero-glass">Filter Terbitan Terbaru</a>
            </div>
        </div>

        <div class="hero-visual">
            <svg width="145" height="145" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="20" y="22" width="100" height="96" rx="22" fill="rgba(255,255,255,0.08)" stroke="rgba(255,255,255,0.2)" stroke-width="1.5"/>
                <path d="M40 44C40 40.6863 42.6863 38 46 38H67C68.6569 38 70 39.3431 70 41V97C70 95.3431 68.6569 94 67 94H46C42.6863 94 40 96.6863 40 100V44Z" fill="url(#bookGrad1)" stroke="rgba(255,255,255,0.45)" stroke-width="1.5"/>
                <path d="M100 44C100 40.6863 97.3137 38 94 38H73C71.3431 38 70 39.3431 70 41V97C70 95.3431 71.3431 94 73 94H94C97.3137 94 100 96.6863 100 100V44Z" fill="url(#bookGrad2)" stroke="rgba(255,255,255,0.45)" stroke-width="1.5"/>
                <path d="M48 52H62M48 61H60M48 70H58" stroke="#E0F2FE" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M78 52H92M78 61H90M78 70H88" stroke="#E0E7FF" stroke-width="2.5" stroke-linecap="round"/>
                <circle cx="106" cy="34" r="7" fill="#38BDF8"/>
                <circle cx="34" cy="102" r="5" fill="#A855F7"/>
                <defs>
                    <linearGradient id="bookGrad1" x1="40" y1="38" x2="70" y2="97" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#38BDF8" stop-opacity="0.6"/>
                        <stop offset="1" stop-color="#6366F1" stop-opacity="0.8"/>
                    </linearGradient>
                    <linearGradient id="bookGrad2" x1="70" y1="38" x2="100" y2="97" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#818CF8" stop-opacity="0.65"/>
                        <stop offset="1" stop-color="#0EA5E9" stop-opacity="0.5"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
    </section>

    <!-- 4 KPI Metrics (Spotlight + Count-Up) -->
    <section class="kpi-grid">
        <div class="kpi-card spotlight-card">
            <div>
                <div class="kpi-label">Total Koleksi</div>
                <div class="kpi-value" data-count="<?= $total_buku ?>">0</div>
                <div class="kpi-sub">Buku terdaftar di database</div>
            </div>
            <div class="kpi-icon-box bg-indigo">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card spotlight-card">
            <div>
                <div class="kpi-label">Terbitan Terbaru</div>
                <div class="kpi-value" data-count="<?= $total_terbaru ?>">0</div>
                <div class="kpi-sub">Tahun terbit &gt; 2020</div>
            </div>
            <div class="kpi-icon-box bg-emerald">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card spotlight-card">
            <div>
                <div class="kpi-label">UM Metro Press</div>
                <div class="kpi-value" data-count="<?= $total_ump ?>">0</div>
                <div class="kpi-sub">Koleksi penerbit kampus</div>
            </div>
            <div class="kpi-icon-box bg-amber">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="4" y="2" width="16" height="20" rx="2"/>
                    <path d="M9 22v-4h6v4"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card spotlight-card">
            <div>
                <div class="kpi-label">Kategori Buku</div>
                <div class="kpi-value" data-count="<?= $total_kat ?>">0</div>
                <div class="kpi-sub">Klasifikasi aktif</div>
            </div>
            <div class="kpi-icon-box bg-cyan">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                    <line x1="7" y1="7" x2="7.01" y2="7"/>
                </svg>
            </div>
        </div>
    </section>

    <!-- Bento Grid: Preview Table + Animated Donut Chart & Bars -->
    <section class="bento-grid">
        <div class="surface-card" style="margin-bottom: 0;">
            <div class="card-head">
                <h3>Ringkasan Katalog Buku <span style="font-size: 11px; color: var(--text-muted); font-weight: 500;">(Klik baris untuk detail)</span></h3>
                <a href="viewbuku.php" class="btn btn-outline" style="padding: 6px 12px; font-size: 12px;">Buka Katalog →</a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Judul &amp; Pengarang</th>
                            <th>Kategori</th>
                            <th style="text-align: center;">Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($q_preview && mysqli_num_rows($q_preview) > 0): ?>
                            <?php while ($b = mysqli_fetch_assoc($q_preview)): ?>
                                <tr data-book='<?= htmlspecialchars(json_encode($b), ENT_QUOTES, "UTF-8") ?>' onclick="openBookModal(this)">
                                    <td><span class="code-badge"><?= htmlspecialchars($b['kode_buku']) ?></span></td>
                                    <td>
                                        <div class="book-title"><?= htmlspecialchars($b['judul_buku']) ?></div>
                                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 2px;"><?= htmlspecialchars($b['pengarang']) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge <?= getKategoriBadgeClass($b['nama_kategori_buku']) ?>">
                                            <?= htmlspecialchars($b['nama_kategori_buku']) ?>
                                        </span>
                                    </td>
                                    <td style="text-align: center; font-weight: 700;"><?= htmlspecialchars($b['tahun_terbit']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- Animated SVG Donut Chart -->
            <div class="surface-card spotlight-card" style="margin-bottom: 0;">
                <div class="card-head">
                    <h3>Analitik Kategori (Donut Chart)</h3>
                </div>
                <div class="card-pad">
                    <?php
                    $colors = ['#38bdf8', '#2dd4bf', '#818cf8', '#0ea5e9'];
                    $circumference = 2 * M_PI * 56; // r=56 -> ~351.86
                    $offset = 0;
                    ?>
                    <div class="donut-wrap">
                        <div class="donut-svg-box">
                            <svg width="150" height="150" viewBox="0 0 150 150" style="transform: rotate(-90deg);">
                                <circle cx="75" cy="75" r="56" fill="none" stroke="rgba(148,163,184,0.15)" stroke-width="14"/>
                                <?php foreach ($kat_data as $idx => $kd):
                                    $val = (int)$kd['jumlah'];
                                    $segLen = $total_buku > 0 ? ($val / $total_buku) * $circumference : 0;
                                    $dashArray = $segLen . ' ' . $circumference;
                                    $color = $colors[$idx % count($colors)];
                                ?>
                                <circle class="donut-segment"
                                    cx="75" cy="75" r="56"
                                    fill="none"
                                    stroke="<?= $color ?>"
                                    stroke-width="14"
                                    stroke-dasharray="<?= $dashArray ?>"
                                    stroke-dashoffset="<?= -$circumference ?>"
                                    data-target-offset="<?= -$offset ?>"
                                    stroke-linecap="butt">
                                    <title><?= htmlspecialchars($kd['nama_kategori_buku']) ?>: <?= $val ?> buku</title>
                                </circle>
                                <?php $offset += $segLen; endforeach; ?>
                            </svg>
                            <div class="donut-center">
                                <strong data-count="<?= $total_buku ?>">0</strong>
                                <span>Total Buku</span>
                            </div>
                        </div>

                        <div class="donut-legend">
                            <?php foreach ($kat_data as $idx => $kd):
                                $color = $colors[$idx % count($colors)];
                                $pct = $total_buku > 0 ? round(($kd['jumlah'] / $total_buku) * 100) : 0;
                            ?>
                                <div class="legend-row">
                                    <div class="legend-left">
                                        <span class="legend-dot" style="background: <?= $color ?>;"></span>
                                        <span><?= htmlspecialchars($kd['nama_kategori_buku']) ?></span>
                                    </div>
                                    <span style="color: var(--text-muted);"><?= $kd['jumlah'] ?> (<?= $pct ?>%)</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Proporsi Penerbit -->
            <div class="surface-card spotlight-card" style="margin-bottom: 0;">
                <div class="card-head">
                    <h3>Proporsi Penerbit</h3>
                </div>
                <div class="card-pad">
                    <?php while ($dp = mysqli_fetch_assoc($q_dist_pub)): ?>
                        <?php $pct = $total_buku > 0 ? round(($dp['jumlah'] / $total_buku) * 100) : 0; ?>
                        <div class="dist-item">
                            <div class="dist-top">
                                <span><?= htmlspecialchars($dp['penerbit']) ?></span>
                                <span style="color: var(--text-muted);"><?= $dp['jumlah'] ?> buku (<?= $pct ?>%)</span>
                            </div>
                            <div class="dist-track">
                                <div class="dist-fill" data-width="<?= $pct ?>%" style="background: linear-gradient(90deg, #2dd4bf, #38bdf8);"></div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>

<?php
mysqli_close($koneksi);
require 'footer.php';
?>
