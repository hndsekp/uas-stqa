<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'home';

// ambil data mahasiswa
$query = mysqli_query($koneksi, "SELECT * FROM tb_mhs");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --navy: #0f1b2d;
            --navy-mid: #1a2d4a;
            --navy-light: #243856;
            --accent: #3b82f6;
            --accent-hover: #2563eb;
            --accent-soft: rgba(59, 130, 246, 0.12);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border: rgba(255, 255, 255, 0.07);
            --border-soft: rgba(255, 255, 255, 0.04);
            --surface: rgba(255, 255, 255, 0.04);
            --surface-hover: rgba(255, 255, 255, 0.07);
            --radius-sm: 8px;
            --radius-lg: 16px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--navy);
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* HEADER */
        header {
            background: var(--navy-mid);
            border-bottom: 1px solid var(--border);
            height: 64px;
            position: sticky;
            top: 0;
            z-index: 100;

            display: flex;
            align-items: center;
            justify-content: center;

            position: relative;
        }

        .header-title {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .header-profile {
            position: absolute;
            right: 32px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--accent-soft);
            border: 1.5px solid var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
            overflow: hidden;
        }

        .avatar:hover {
            background: var(--accent);
            transform: scale(1.05);
        }

        .avatar-icon {
            width: 18px;
            height: 18px;
            object-fit: contain;
            user-select: none;
            pointer-events: none;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .username {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .avatar-container {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 48px;
            right: 0;

            width: 160px;

            background: var(--navy-light);
            border: 1px solid var(--border);

            border-radius: 12px;

            overflow: hidden;

            display: none;

            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: block;

            padding: 12px 16px;

            color: var(--text-secondary);
            text-decoration: none;

            font-size: 13px;
            font-weight: 500;

            transition: 0.15s;
        }

        .dropdown-item:hover {
            background: var(--surface-hover);
            color: white;
        }

        /* NAV */
        nav {
            background: var(--navy-mid);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;

            display: flex;
            justify-content: flex-end;
            align-items: center;

            height: 48px;
        }

        .menu {
            display: flex;
            gap: 2px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 6px;

            text-decoration: none;
            color: var(--text-secondary);

            font-size: 13px;
            font-weight: 500;

            padding: 6px 14px;
            border-radius: var(--radius-sm);

            transition: all 0.15s ease;
        }

        .menu a:hover {
            color: var(--text-primary);
            background: var(--surface-hover);
        }

        .menu a.active {
            color: var(--accent);
            background: var(--accent-soft);
        }

        .nav-icon {
            width: 16px;
            height: 16px;
        }

        /* CONTAINER */
        .container {
            padding: 32px;
            max-width: 900px;
            margin: 0 auto;
        }

        /* SLIDER */
        .slider-wrapper {
            background: var(--navy-mid);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .slider {
            position: relative;
        }

        .slider img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            display: block;
        }

        .slider-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 120px;
            background: linear-gradient(to top, rgba(15, 27, 45, 0.95), transparent);
        }

        /* CARD */
        .card {
            padding: 20px 24px;
            border-top: 1px solid var(--border);
        }

        .card h3 {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .card p {
            font-size: 13.5px;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 12px;
        }

        .card a {
            color: var(--accent);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        /* CONTROLS */
        .controls {
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 16px 24px;
            border-top: 1px solid var(--border-soft);
        }

        button {
            padding: 8px 20px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--surface);
            color: var(--text-secondary);
            cursor: pointer;
        }

        button:hover {
            background: var(--surface-hover);
            color: white;
        }

        /* DOTS */
        .slide-dots {
            display: flex;
            justify-content: center;
            gap: 6px;
            padding: 12px 0 4px;
        }

        .dot {
            width: 6px;
            height: 6px;
            border-radius: 99px;
            background: var(--border);
        }

        .dot.active {
            width: 18px;
            background: var(--accent);
        }

        /* CRUD */
        .crud-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .crud-header h2 {
            font-size: 18px;
        }

        .section-sub {
            font-size: 13px;
            color: var(--text-muted);
        }

        .btn-tambah {
            background: var(--accent);
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
        }

        .btn-tambah:hover {
            background: var(--accent-hover);
        }

        /* TABLE */
        .table-wrapper {
            background: var(--navy-mid);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: var(--navy-light);
        }

        th {
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            color: var(--text-muted);
        }

        td {
            padding: 14px 16px;
            font-size: 13px;
            border-top: 1px solid var(--border-soft);
        }

        tbody tr:hover {
            background: var(--surface);
        }

        .td-nama {
            color: white;
            font-weight: 500;
        }

        .td-nim {
            color: var(--accent);
        }

        .badge-fakultas {
            background: var(--accent-soft);
            color: #93c5fd;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
        }

        .action-group {
            display: flex;
            gap: 6px;
        }

        .btn-edit {
            background: rgba(245, 158, 11, 0.12);
            color: #fbbf24;
            padding: 5px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 12px;
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
            padding: 5px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 12px;
        }

        .footer {
            margin-top: 48px;
            padding: 20px;
            border-top: 1px solid var(--border);
            text-align: center;
            color: var(--text-muted);
            font-size: 12px;
        }
    </style>
</head>

<body>

    <header>
        <h2 class="header-title">Our Project</h2>

        <div class="header-profile">

            <div class="user-info">
                <span class="username">
                    <?= $_SESSION['username']; ?>
                </span>

                <div class="avatar-container">

                    <div class="avatar" onclick="toggleDropdown()">
                        <img
                            src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                            alt="User"
                            class="avatar-icon">
                    </div>

                    <div class="dropdown-menu" id="dropdownMenu">

                        <a href="logout.php" class="dropdown-item">
                            Logout
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </header>

    <nav>
        <div class="menu">

            <a href="dashboard.php?tab=home"
                class="<?= $activeTab == 'home' ? 'active' : '' ?>">

                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                </svg>

                Profile
            </a>

            <a href="dashboard.php?tab=crud"
                class="<?= $activeTab == 'crud' ? 'active' : '' ?>">

                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <path d="M3 9h18M9 21V9" />
                </svg>

                CRUD
            </a>

        </div>
    </nav>

    <div class="container">

        <!-- HOME -->
        <div id="home"
            style="<?= $activeTab == 'home' ? 'display:block;' : 'display:none;' ?>">

            <div class="slider-wrapper">

                <div class="slider">
                    <img id="sliderImage" src="">
                    <div class="slider-overlay"></div>
                </div>

                <div class="slide-dots">
                    <div class="dot active" id="dot-0"></div>
                    <div class="dot" id="dot-1"></div>
                    <div class="dot" id="dot-2"></div>
                </div>

                <div class="card">
                    <h3 id="title"></h3>

                    <p id="description"></p>

                    <a href="#" onclick="toggleText(event)" id="btnText">
                        Selengkapnya
                    </a>
                </div>

                <div class="controls">
                    <button onclick="prevSlide()">← Prev</button>
                    <button onclick="nextSlide()">Next →</button>
                </div>

            </div>

        </div>

        <!-- CRUD -->
        <div id="crud"
            style="<?= $activeTab == 'crud' ? 'display:block;' : 'display:none;' ?>">

            <div class="crud-header">

                <div>
                    <h2>Data Mahasiswa</h2>
                    <div class="section-sub">
                        Kelola data mahasiswa terdaftar
                    </div>
                </div>

                <a href="tambah.php" class="btn-tambah">
                    Tambah Data
                </a>

            </div>

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Fakultas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $no = 1;

                        while ($dataMhs = mysqli_fetch_assoc($query)) {
                        ?>

                            <tr>

                                <td><?= $no++; ?></td>

                                <td class="td-nama">
                                    <?= $dataMhs['nama']; ?>
                                </td>

                                <td class="td-nim">
                                    <?= $dataMhs['nim']; ?>
                                </td>

                                <td>
                                    <span class="badge-fakultas">
                                        <?= $dataMhs['fakultas']; ?>
                                    </span>
                                </td>

                                <td>

                                    <div class="action-group">

                                        <a class="btn-edit"
                                            href="edit.php?id=<?= $dataMhs['id']; ?>">
                                            Edit
                                        </a>

                                        <a class="btn-delete"
                                            href="delete.php?id=<?= $dataMhs['id']; ?>"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">

                                            Hapus
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="footer">
        <p>© 2026 Dashboard Anda</p>
    </div>

    <script>
        const data = [{
                image: "gambar_1.jpeg",
                title: "Dashboard Monitoring Aset",
                short: "Dashboard untuk memantau aset IT secara real-time...",
                full: "Dashboard untuk memantau aset IT secara real-time. Menampilkan status perangkat, lokasi penempatan, dan kondisi operasional secara terpusat."
            },
            {
                image: "gambar_2.jpeg",
                title: "Manajemen User & Keamanan",
                short: "Sistem autentikasi dengan JWT dan RBAC...",
                full: "Sistem autentikasi modern menggunakan JWT dan Role-Based Access Control (RBAC)."
            },
            {
                image: "gambar_3.jpeg",
                title: "Visualisasi Data Interaktif",
                short: "Grafik interaktif untuk analisis data...",
                full: "Grafik interaktif untuk analisis data merupakan visualisasi dinamis yang dirancang untuk membantu pengguna memahami pola, tren, dan hubungan antar data secara lebih efektif. Dengan fitur interaktif seperti filter, zoom, hover information, dan pemilihan kategori secara real-time, pengguna dapat mengeksplorasi data dari berbagai sudut pandang tanpa harus membaca tabel yang kompleks. Penggunaan grafik interaktif tidak hanya meningkatkan kemudahan interpretasi data, tetapi juga mendukung proses pengambilan keputusan yang lebih cepat, akurat, dan berbasis informasi."
            }
        ];

        let index = 0;
        let expanded = false;

        function renderSlide() {

            document.getElementById("sliderImage").src = data[index].image;

            document.getElementById("title").innerText =
                data[index].title;

            expanded = false;

            document.getElementById("description").innerText =
                data[index].short;

            document.getElementById("btnText").innerText =
                "Selengkapnya";

            for (let i = 0; i < data.length; i++) {

                const dot = document.getElementById("dot-" + i);

                dot.className =
                    "dot" + (i === index ? " active" : "");
            }
        }

        function toggleText(e) {

            e.preventDefault();

            if (!expanded) {

                document.getElementById("description").innerText =
                    data[index].full;

                document.getElementById("btnText").innerText =
                    "Sembunyikan";

                expanded = true;

            } else {

                document.getElementById("description").innerText =
                    data[index].short;

                document.getElementById("btnText").innerText =
                    "Selengkapnya";

                expanded = false;
            }
        }

        function nextSlide() {
            index = (index + 1) % data.length;
            renderSlide();
        }

        function prevSlide() {
            index = (index - 1 + data.length) % data.length;
            renderSlide();
        }

        renderSlide();

        function toggleDropdown() {

            document
                .getElementById("dropdownMenu")
                .classList
                .toggle("show");
        }

        window.onclick = function(e) {

            if (!e.target.closest('.avatar-container')) {

                const dropdown =
                    document.getElementById("dropdownMenu");

                if (dropdown.classList.contains('show')) {

                    dropdown.classList.remove('show');
                }
            }
        }
    </script>

</body>

</html>