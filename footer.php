    </main>
</div>
</div>

<!-- Book Detail Interactive Modal -->
<div class="modal-backdrop" id="bookModal" onclick="if(event.target===this) closeBookModal()">
    <div class="modal-box">
        <div class="modal-top">
            <div>
                <span class="code-badge" id="mKode" style="margin-bottom: 8px;">K00001</span>
                <h3 id="mJudul" style="font-size: 20px; font-weight: 800; color: var(--text-main);">Judul Buku</h3>
            </div>
            <button type="button" class="modal-close" onclick="closeBookModal()">&times;</button>
        </div>
        <div class="modal-grid">
            <div class="modal-cell">
                <span>ID Record</span>
                <strong id="mId">#1</strong>
            </div>
            <div class="modal-cell">
                <span>Tahun Terbit</span>
                <strong id="mTahun">2025</strong>
            </div>
            <div class="modal-cell">
                <span>Pengarang</span>
                <strong id="mPengarang">-</strong>
            </div>
            <div class="modal-cell">
                <span>Penerbit</span>
                <strong id="mPenerbit">-</strong>
            </div>
            <div class="modal-cell" style="grid-column: span 2;">
                <span>Kategori Buku</span>
                <strong id="mKategori">-</strong>
            </div>
        </div>
        <div style="margin-top: 20px; text-align: right;">
            <button type="button" class="btn btn-outline" onclick="closeBookModal()">Tutup Detail</button>
        </div>
    </div>
</div>

<script>
// 1. Theme Persistence (Midnight Aurora Glassmorphism Default vs Optional Light)
(function initTheme() {
    const saved = localStorage.getItem('perpusThemeV3');
    const icon = document.getElementById('themeIcon');
    if (saved === 'light') {
        document.body.classList.add('theme-light');
        if (icon) icon.textContent = '🌙';
    } else {
        if (icon) icon.textContent = '☀️';
    }
})();

function toggleTheme() {
    document.body.classList.toggle('theme-light');
    const isLight = document.body.classList.contains('theme-light');
    localStorage.setItem('perpusThemeV3', isLight ? 'light' : 'dark');
    const icon = document.getElementById('themeIcon');
    if (icon) icon.textContent = isLight ? '🌙' : '☀️';
}

// 2. Live Clock WIB
function updateClock() {
    const el = document.getElementById('clockText');
    if (!el) return;
    const now = new Date();
    const pad = n => String(n).padStart(2, '0');
    el.textContent = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())} WIB`;
}
updateClock();
setInterval(updateClock, 1000);

// 3. Interactive Big Data Particle Mesh Canvas
(function initParticles() {
    const canvas = document.getElementById('bgParticles');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    let w, h, particles = [];
    const mouse = { x: null, y: null };

    function resize() {
        w = canvas.width = window.innerWidth;
        h = canvas.height = window.innerHeight;
    }
    resize();
    window.addEventListener('resize', resize);
    window.addEventListener('mousemove', e => { mouse.x = e.clientX; mouse.y = e.clientY; });

    const count = Math.min(55, Math.floor((window.innerWidth * window.innerHeight) / 24000));
    for (let i = 0; i < count; i++) {
        particles.push({
            x: Math.random() * w,
            y: Math.random() * h,
            vx: (Math.random() - 0.5) * 0.55,
            vy: (Math.random() - 0.5) * 0.55,
            r: Math.random() * 2 + 1.2
        });
    }

    function animate() {
        ctx.clearRect(0, 0, w, h);
        const isLight = document.body.classList.contains('theme-light');
        const dotColor = isLight ? 'rgba(2, 132, 199, 0.28)' : 'rgba(56, 189, 248, 0.48)';
        const lineRgb  = isLight ? '2, 132, 199' : '45, 212, 191';

        for (let i = 0; i < particles.length; i++) {
            const p = particles[i];
            p.x += p.vx;
            p.y += p.vy;
            if (p.x < 0 || p.x > w) p.vx *= -1;
            if (p.y < 0 || p.y > h) p.vy *= -1;

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = dotColor;
            ctx.fill();

            for (let j = i + 1; j < particles.length; j++) {
                const q = particles[j];
                const dx = p.x - q.x, dy = p.y - q.y;
                const dist = Math.hypot(dx, dy);
                if (dist < 135) {
                    ctx.beginPath();
                    ctx.moveTo(p.x, p.y);
                    ctx.lineTo(q.x, q.y);
                    ctx.strokeStyle = `rgba(${lineRgb}, ${(1 - dist / 135) * 0.18})`;
                    ctx.lineWidth = 1;
                    ctx.stroke();
                }
            }

            if (mouse.x !== null) {
                const md = Math.hypot(p.x - mouse.x, p.y - mouse.y);
                if (md < 140) {
                    ctx.beginPath();
                    ctx.moveTo(p.x, p.y);
                    ctx.lineTo(mouse.x, mouse.y);
                    ctx.strokeStyle = `rgba(56, 189, 248, ${(1 - md / 140) * 0.3})`;
                    ctx.lineWidth = 1;
                    ctx.stroke();
                }
            }
        }
        requestAnimationFrame(animate);
    }
    animate();
})();

// 4. DOM Ready: Count-Up, Donut Chart, Bars, Typewriter, Spotlight & 3D Tilt
document.addEventListener('DOMContentLoaded', () => {
    // Count-Up KPI
    document.querySelectorAll('[data-count]').forEach(el => {
        const target = parseInt(el.getAttribute('data-count'), 10) || 0;
        const duration = 750;
        const start = performance.now();
        function step(now) {
            const p = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(target * eased).toLocaleString('id-ID');
            if (p < 1) requestAnimationFrame(step);
            else el.textContent = target.toLocaleString('id-ID');
        }
        requestAnimationFrame(step);
    });

    // Progress Bars & SVG Donut Segments
    setTimeout(() => {
        document.querySelectorAll('.dist-fill[data-width]').forEach(bar => {
            bar.style.width = bar.getAttribute('data-width');
        });
        document.querySelectorAll('.donut-segment[data-target-offset]').forEach(seg => {
            seg.style.strokeDashoffset = seg.getAttribute('data-target-offset');
        });
    }, 150);

    // Typewriter Hero Subtitle
    const tw = document.getElementById('typewriterText');
    if (tw) {
        const full = tw.getAttribute('data-text') || '';
        let idx = 0;
        function typeNext() {
            if (idx <= full.length) {
                tw.textContent = full.slice(0, idx);
                idx++;
                setTimeout(typeNext, 14);
            }
        }
        typeNext();
    }

    // Cursor Spotlight on Cards
    document.querySelectorAll('.spotlight-card').forEach(card => {
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            card.style.setProperty('--mx', (e.clientX - rect.left) + 'px');
            card.style.setProperty('--my', (e.clientY - rect.top) + 'px');
        });
    });

    // 3D Tilt on Profile Card (me.php)
    const tiltCard = document.getElementById('tiltProfileCard');
    if (tiltCard) {
        tiltCard.addEventListener('mousemove', e => {
            const r = tiltCard.getBoundingClientRect();
            const x = (e.clientX - r.left) / r.width - 0.5;
            const y = (e.clientY - r.top) / r.height - 0.5;
            tiltCard.style.transform = `perspective(700px) rotateY(${x * 8}deg) rotateX(${-y * 8}deg) translateY(-3px)`;
        });
        tiltCard.addEventListener('mouseleave', () => {
            tiltCard.style.transform = 'perspective(700px) rotateY(0deg) rotateX(0deg)';
        });
    }
});

// 5. Book Detail Modal
function openBookModal(tr) {
    try {
        const data = JSON.parse(tr.getAttribute('data-book'));
        document.getElementById('mKode').textContent = data.kode_buku || '-';
        document.getElementById('mJudul').textContent = data.judul_buku || '-';
        document.getElementById('mId').textContent = '#' + (data.id || '-');
        document.getElementById('mTahun').textContent = data.tahun_terbit || '-';
        document.getElementById('mPengarang').textContent = data.pengarang || '-';
        document.getElementById('mPenerbit').textContent = data.penerbit || '-';
        document.getElementById('mKategori').textContent = data.nama_kategori_buku || 'Koleksi Perpustakaan';
        document.getElementById('bookModal').classList.add('open');
    } catch (err) {}
}

function closeBookModal() {
    document.getElementById('bookModal').classList.remove('open');
}

// 6. Interactive Table Column Sorting
const sortState = {};
function sortTable(tableId, colIdx, isNumeric) {
    const table = document.getElementById(tableId);
    if (!table) return;
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr[data-row]'));
    const key = `${tableId}_${colIdx}`;
    sortState[key] = !sortState[key];
    const asc = sortState[key];

    rows.sort((a, b) => {
        let va = a.cells[colIdx].textContent.replace(/[#✓]/g, '').trim();
        let vb = b.cells[colIdx].textContent.replace(/[#✓]/g, '').trim();
        if (isNumeric) {
            return asc ? (parseFloat(va) - parseFloat(vb)) : (parseFloat(vb) - parseFloat(va));
        }
        return asc ? va.localeCompare(vb) : vb.localeCompare(va);
    });

    rows.forEach(r => tbody.appendChild(r));
}

// 7. SQL Inspector Toggle & Copy
function toggleSql() {
    const body = document.getElementById('sqlBody');
    const icon = document.getElementById('sqlToggleText');
    if (!body) return;
    body.classList.toggle('open');
    if (icon) icon.textContent = body.classList.contains('open') ? 'Sembunyikan ▲' : 'Tampilkan SQL ▼';
}

function copySql(btn) {
    const pre = btn.parentElement.querySelector('pre');
    if (!pre) return;
    navigator.clipboard.writeText(pre.textContent).then(() => {
        const old = btn.textContent;
        btn.textContent = '✓ Tersalin!';
        setTimeout(() => btn.textContent = old, 1500);
    });
}

// 8. Realtime Search & Category Pills
function filterTable(inputId, tableId, countId) {
    const input = document.getElementById(inputId);
    const table = document.getElementById(tableId);
    if (!input || !table) return;
    const query = input.value.toLowerCase();
    const rows = table.querySelectorAll('tbody tr[data-row]');
    let visible = 0;

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const activeCat = window.activeCategoryFilter || 'all';
        const rowCat = (row.getAttribute('data-category') || '').toLowerCase();
        if (text.indexOf(query) > -1 && (activeCat === 'all' || rowCat === activeCat.toLowerCase())) {
            row.style.display = '';
            visible++;
        } else {
            row.style.display = 'none';
        }
    });

    const countEl = document.getElementById(countId);
    if (countEl) countEl.textContent = visible;
}

function setCategoryFilter(cat, btnEl, inputId, tableId, countId) {
    window.activeCategoryFilter = cat;
    document.querySelectorAll('.pill-btn').forEach(b => b.classList.remove('active'));
    if (btnEl) btnEl.classList.add('active');
    filterTable(inputId, tableId, countId);
}
</script>
</body>
</html>
