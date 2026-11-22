<?php
// file: sidebar.php
if (!isset($active_page)) $active_page = 'home';
if (!isset($page_title)) $page_title = 'Aplikasi Perpustakaan Sederhana';
if (!isset($breadcrumb)) $breadcrumb = 'Dashboard';

function getInitials($name) {
    $words = explode(' ', trim($name));
    $initials = '';
    foreach (array_slice($words, 0, 2) as $w) {
        if (!empty($w)) $initials .= strtoupper($w[0]);
    }
    return $initials ?: 'BK';
}

function getKategoriBadgeClass($kategori) {
    $k = strtolower($kategori);
    if (strpos($k, 'referensi') !== false) return 'badge-ref';
    if (strpos($k, 'ajar') !== false) return 'badge-ajar';
    return 'badge-prak';
}
?>
<canvas id="bgParticles"></canvas>
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>
                <path d="M8 7h8"/>
                <path d="M8 11h6"/>
            </svg>
        </div>
        <div class="brand-text">
            <h2>PERPUS DIGITAL</h2>
            <div class="brand-status">
                <span class="status-dot"></span>
                <span>DB: myperpus</span>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">URL Hyperlink &amp; Menu</div>

        <a href="index.php" class="nav-item <?= $active_page === 'home' ? 'active' : '' ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            <div class="nav-meta">
                <span class="nav-title">HOME</span>
                <span class="nav-url">localhost/bigdatauts</span>
            </div>
        </a>

        <a href="viewbuku.php" class="nav-item <?= $active_page === 'viewbuku' ? 'active' : '' ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
            </svg>
            <div class="nav-meta">
                <span class="nav-title">DATA BUKU</span>
                <span class="nav-url">localhost/bigdatauts/viewbuku.php</span>
            </div>
        </a>

        <a href="viewfilterbukuterbaru.php" class="nav-item <?= $active_page === 'terbaru' ? 'active' : '' ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
            <div class="nav-meta">
                <span class="nav-title">FILTER DATA BUKU "TERBARU"</span>
                <span class="nav-url">localhost/bigdatauts/viewfilterbukuterbaru.php</span>
            </div>
        </a>

        <a href="viewfilterbukuummetropress.php" class="nav-item <?= $active_page === 'umpress' ? 'active' : '' ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="2" width="16" height="20" rx="2" ry="2"/>
                <path d="M9 22v-4h6v4"/>
                <path d="M8 6h.01"/><path d="M16 6h.01"/>
                <path d="M12 6h.01"/><path d="M12 10h.01"/>
                <path d="M12 14h.01"/><path d="M16 10h.01"/>
                <path d="M16 14h.01"/><path d="M8 10h.01"/>
                <path d="M8 14h.01"/>
            </svg>
            <div class="nav-meta">
                <span class="nav-title">UM Metro Press</span>
                <span class="nav-url">localhost/bigdatauts/viewfilterbukuummetropress.php</span>
            </div>
        </a>

        <a href="me.php" class="nav-item <?= $active_page === 'me' ? 'active' : '' ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <div class="nav-meta">
                <span class="nav-title">ABOUT PEMBUAT PROGRAM</span>
                <span class="nav-url">localhost/bigdatauts/me.php</span>
            </div>
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="me.php" class="mini-profile">
            <img src="profil.jpeg" alt="Neneng Wahyuni">
            <div class="mini-profile-info">
                <span class="mini-profile-name">Neneng Wahyuni</span>
                <span class="mini-profile-npm">NPM: 24430123</span>
            </div>
        </a>
    </div>
</aside>

<div class="main-workspace">
    <header class="topbar">
        <div class="topbar-left">
            <div class="breadcrumb">
                <span>Aplikasi Perpustakaan Sederhana</span>
                <span>/</span>
                <span style="color: var(--accent);"><?= htmlspecialchars($breadcrumb) ?></span>
            </div>
            <div class="topbar-title"><?= htmlspecialchars($page_title) ?></div>
        </div>
        <div class="topbar-actions">
            <span class="pill-db pill-clock" id="liveClock">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                <span id="clockText">--:--:--</span>
            </span>
            <span class="pill-db">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <ellipse cx="12" cy="5" rx="9" ry="3"/>
                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/>
                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
                </svg>
                MySQL • myperpus
            </span>
            <button type="button" id="themeToggle" onclick="toggleTheme()" class="btn btn-outline btn-theme" title="Ganti Tema Gelap / Terang">
                <span id="themeIcon">☀️</span>
            </button>
            <button type="button" onclick="window.print()" class="btn btn-outline">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 6 2 18 2 18 9"/>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                    <rect x="6" y="14" width="12" height="8"/>
                </svg>
                Cetak Laporan
            </button>
        </div>
    </header>
    <main class="content-body">
