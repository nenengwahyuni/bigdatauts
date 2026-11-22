<?php
// file: me.php
$active_page = 'me';
$page_title  = 'About Pembuat Program';
$breadcrumb  = 'Profil Penyusun';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Pembuat Program - Neneng Wahyuni</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app-shell">
<?php require 'sidebar.php'; ?>

    <section class="profile-layout">
        <!-- Kartu Foto & Identitas Utama (3D Tilt + Spotlight) -->
        <div class="profile-card spotlight-card" id="tiltProfileCard">
            <div class="profile-cover"></div>
            <div class="profile-avatar-wrap">
                <img src="profil.jpeg" alt="Foto Neneng Wahyuni" class="profile-avatar">
            </div>
            <div class="profile-name">Neneng Wahyuni</div>
            <div class="profile-npm">NPM. 24430123</div>

            <div class="profile-badges">
                <span class="badge badge-ref">Ilmu Komputer</span>
                <span class="badge badge-ajar">UM Metro</span>
                <span class="badge badge-year-new">✓ Mahasiswa Aktif</span>
            </div>
        </div>

        <!-- Kartu Detail Akademik & Project Info -->
        <div class="surface-card spotlight-card" style="margin-bottom: 0;">
            <div class="card-head">
                <h3>Profil Penyusun Laporan UTS</h3>
                <a href="index.php" class="btn btn-outline" style="padding: 6px 12px; font-size: 12px;">← Kembali ke Home</a>
            </div>
            <div class="card-pad">
                <div class="info-grid">
                    <div class="info-field">
                        <span>Nama Mahasiswa</span>
                        <strong>Neneng Wahyuni</strong>
                    </div>
                    <div class="info-field">
                        <span>NPM</span>
                        <strong style="font-family: 'JetBrains Mono', monospace; color: var(--accent);">24430123</strong>
                    </div>
                    <div class="info-field">
                        <span>Program Studi</span>
                        <strong>Ilmu Komputer</strong>
                    </div>
                    <div class="info-field">
                        <span>Universitas</span>
                        <strong>Universitas Muhammadiyah Metro</strong>
                    </div>
                    <div class="info-field">
                        <span>Mata Kuliah</span>
                        <strong>Big Data (Ujian Tengah Semester)</strong>
                    </div>
                    <div class="info-field">
                        <span>Database Project</span>
                        <strong style="font-family: 'JetBrains Mono', monospace;">myperpus (MySQL)</strong>
                    </div>
                </div>

                <div style="margin-top: 22px; padding-top: 18px; border-top: 1px solid var(--border-subtle);">
                    <div style="font-size: 11.5px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 10px;">
                        Teknologi &amp; Fitur Aplikasi
                    </div>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <span class="code-badge">PHP 8 Native</span>
                        <span class="code-badge">MySQLi Relational</span>
                        <span class="code-badge">SQL INNER JOIN</span>
                        <span class="code-badge">SQL COUNT()</span>
                        <span class="code-badge">Interactive Particle UI</span>
                        <span class="code-badge">SVG Donut Analytics</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
require 'footer.php';
?>
