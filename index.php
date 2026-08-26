<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BRANKAS PINTAR | SMKN 1 NGLEGOK</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="bg-grid"></div>
<div class="glow glow-one"></div>
<div class="glow glow-two"></div>

<div class="app-container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="sidebar-top-logos">
            <img src="img/logosmk.png" class="school-logo" alt="SMKN 1 Nglegok">
            <div class="logo-divider"></div>
            <img src="img/logoteismk.png" class="school-logo" alt="TEI">
        </div>

        <div class="sidebar-brand">
            <div class="brand-icon-wrapper">
                <i data-lucide="shield-check"></i>
            </div>

            <div class="brand-text">
                <h2>BRANKAS PINTAR</h2>
                <p>KELOMPOK 3 • TEI</p>
            </div>
        </div>

        <div class="menu-label">MAIN MENU</div>

        <nav class="nav-menu">

            <button class="nav-item active" data-tab="dashboard">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </button>

            <button class="nav-item" data-tab="sensor">
                <i data-lucide="activity"></i>
                <span>Data Sensor</span>
            </button>

            <button class="nav-item" data-tab="keamanan">
                <i data-lucide="camera"></i>
                <span>Keamanan & Foto</span>
            </button>

            <button class="nav-item" data-tab="output">
                <i data-lucide="zap"></i>
                <span>Output & Aktuator</span>
            </button>

            <button class="nav-item" data-tab="about">
                <i data-lucide="users"></i>
                <span>About Project</span>
            </button>

        </nav>

        <div class="sidebar-footer">

            <div class="connection-box">
                <span class="dot online pulse"></span>

                <div>
                    <strong>ONLINE</strong>
                    <small>I2C Gateway Active</small>
                </div>
            </div>

        </div>

    </aside>


    <!-- MAIN -->
    <main class="main-content">

        <!-- HEADER -->
        <header class="top-header">

            <div class="header-title">

                <div class="eyebrow">
                    <span class="live-dot"></span>
                    LIVE MONITORING
                </div>

                <h1 id="page-title">Real-time Security Dashboard</h1>

                <p id="page-desc">
                    BRANKAS PINTAR — Ringkasan Utama Keamanan & Sistem IoT
                </p>

            </div>

            <div class="header-right">

                <button class="refresh-btn" id="refresh-btn" title="Refresh data">
                    <i data-lucide="refresh-cw"></i>
                    <span>Refresh</span>
                </button>

                <div class="clock-card">
                    <i data-lucide="clock"></i>
                    <span id="live-clock">--:--:-- WIB</span>
                </div>

                <div class="header-profile">

                    <div class="avatar">
                        <i data-lucide="shield"></i>
                    </div>

                    <div class="user-info">
                        <span class="user-name">TEI CONTROL HUB</span>
                        <span class="user-role">IoT Monitoring System</span>
                    </div>

                </div>

            </div>

        </header>


        <!-- DASHBOARD -->
        <section id="tab-dashboard" class="tab-content active">

            <!-- HERO -->
            <div class="hero-banner">

                <div class="hero-text">

                    <div class="hero-small">
                        <span class="status-light"></span>
                        SECURITY STATUS
                    </div>

                    <h2>
                        Sistem Keamanan:
                        <span id="hero-status" class="badge-status-safe">
                            TERPROTEKSI AMAN
                        </span>
                    </h2>

                    <p>
                        ATmega328 mengontrol sistem keamanan melalui komunikasi I2C
                        dengan ESP32 sebagai gateway monitoring.
                    </p>

                    <div class="hero-meta">
                        <span>
                            <i data-lucide="radio"></i>
                            I2C ACTIVE
                        </span>

                        <span>
                            <i data-lucide="wifi"></i>
                            ESP32 ONLINE
                        </span>

                        <span>
                            <i data-lucide="refresh-cw"></i>
                            <span id="last-update">Belum diperbarui</span>
                        </span>
                    </div>

                </div>


                <!-- ILLUSTRATION BRANKAS -->
                <div class="safe-illustration">

                    <div class="safe-glow"></div>

                    <div class="safe-body">

                        <div class="safe-top"></div>

                        <div class="safe-door">

                            <div class="safe-screen">
                                <i data-lucide="shield-check"></i>
                                <span>SECURE</span>
                            </div>

                            <div class="safe-wheel">
                                <div class="wheel-center">
                                    <i data-lucide="lock"></i>
                                </div>
                            </div>

                            <div class="safe-led"></div>

                        </div>

                        <div class="safe-side-light"></div>

                    </div>

                    <div class="safe-shadow"></div>

                </div>

            </div>


            <!-- STATUS CARDS -->
            <div class="cards-grid">

                <div class="card status-card">

                    <div class="card-icon red">
                        <i data-lucide="lock"></i>
                    </div>

                    <div class="card-info">
                        <span class="card-label">SOLENOID DOOR</span>
                        <strong id="dash-lock-status">TERKUNCI</strong>
                        <small>Electronic Lock</small>
                    </div>

                    <span class="mini-status danger">LOCK</span>

                </div>


                <div class="card status-card">

                    <div class="card-icon cyan">
                        <i data-lucide="door-closed"></i>
                    </div>

                    <div class="card-info">
                        <span class="card-label">SENSOR PINTU</span>
                        <strong id="dash-door-status">TERTUTUP</strong>
                        <small>Magnetic Switch</small>
                    </div>

                    <span class="mini-status success">SAFE</span>

                </div>


                <div class="card status-card">

                    <div class="card-icon green">
                        <i data-lucide="move-3d"></i>
                    </div>

                    <div class="card-info">
                        <span class="card-label">MPU6050</span>
                        <strong id="dash-mpu-status">STABIL</strong>
                        <small>Motion Detection</small>
                    </div>

                    <span class="mini-status success">OK</span>

                </div>


                <div class="card status-card">

                    <div class="card-icon orange">
                        <i data-lucide="key-round"></i>
                    </div>

                    <div class="card-info">
                        <span class="card-label">PIN FAILED</span>
                        <strong>
                            <span id="dash-pin-failed">0</span>
                            <small>/ 3</small>
                        </strong>
                        <small>Failed Attempts</small>
                    </div>

                    <span class="mini-status warning">LIMIT</span>

                </div>

            </div>


            <!-- CONTENT -->
            <div class="content-grid">

                <!-- LOG -->
                <div class="panel">

                    <div class="panel-header">

                        <div>
                            <span class="panel-kicker">SYSTEM EVENT</span>
                            <h2>
                                <i data-lucide="activity"></i>
                                Live Security Log
                            </h2>
                        </div>

                        <span class="live-badge">
                            <span></span>
                            LIVE
                        </span>

                    </div>

                    <div class="panel-body">

                        <ul class="log-list" id="live-feed-list">

                            <li>

                                <span class="badge info">SYSTEM</span>

                                <span class="log-text">
                                    Sistem siap. Jalur I2C ATmega328 & ESP32 aktif.
                                </span>

                                <span class="log-time">NOW</span>

                            </li>

                        </ul>

                    </div>

                </div>


                <!-- HARDWARE -->
                <div class="panel">

                    <div class="panel-header">

                        <div>
                            <span class="panel-kicker">HARDWARE</span>
                            <h2>
                                <i data-lucide="cpu"></i>
                                System Components
                            </h2>
                        </div>

                        <span class="system-ok">
                            ALL OK
                        </span>

                    </div>

                    <div class="panel-body device-status-grid">

                        <div class="device-item">

                            <div class="device-info">

                                <div class="device-icon">
                                    <i data-lucide="cpu"></i>
                                </div>

                                <div>
                                    <h4>ATmega328</h4>
                                    <p>Master Controller</p>
                                </div>

                            </div>

                            <span class="dot online pulse"></span>

                        </div>


                        <div class="device-item">

                            <div class="device-info">

                                <div class="device-icon">
                                    <i data-lucide="network"></i>
                                </div>

                                <div>
                                    <h4>I2C Communication</h4>
                                    <p>Master ↔ Gateway</p>
                                </div>

                            </div>

                            <span class="dot online pulse"></span>

                        </div>


                        <div class="device-item">

                            <div class="device-info">

                                <div class="device-icon">
                                    <i data-lucide="wifi"></i>
                                </div>

                                <div>
                                    <h4>ESP32 Gateway</h4>
                                    <p>IoT Data Transmission</p>
                                </div>

                            </div>

                            <span class="dot online pulse"></span>

                        </div>


                        <div class="device-item">

                            <div class="device-info">

                                <div class="device-icon">
                                    <i data-lucide="camera"></i>
                                </div>

                                <div>
                                    <h4>ESP32-CAM</h4>
                                    <p>Security Capture</p>
                                </div>

                            </div>

                            <span class="dot online pulse"></span>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- SENSOR -->
        <section id="tab-sensor" class="tab-content">

            <div class="section-heading">
                <div>
                    <span class="eyebrow">TELEMETRY</span>
                    <h2>Monitoring Data Sensor</h2>
                    <p>Data sensor diperbarui otomatis dari sistem IoT.</p>
                </div>

                <button class="refresh-btn" onclick="manualRefresh()">
                    <i data-lucide="refresh-cw"></i>
                    Refresh Sensor
                </button>
            </div>


            <div class="sensor-groups-grid">

                <div class="panel">

                    <div class="panel-header">
                        <h2>
                            <i data-lucide="key-round"></i>
                            Input Access
                        </h2>
                    </div>

                    <div class="panel-body sensor-card-body">

                        <div class="sensor-metric">
                            <span class="label">Solenoid Lock</span>
                            <span class="val highlight-red" id="solenoid-status">
                                TERKUNCI
                            </span>
                        </div>

                        <div class="sensor-metric">
                            <span class="label">Magnetic Door</span>
                            <span class="val highlight-cyan" id="door-switch-status">
                                TERTUTUP
                            </span>
                        </div>

                        <div class="sensor-metric">
                            <span class="label">PIN Failed</span>
                            <span class="val counter" id="pin-failed-count">
                                0
                            </span>
                        </div>

                    </div>

                </div>


                <!-- MPU -->
                <div class="panel">

                    <div class="panel-header">
                        <h2>
                            <i data-lucide="move-3d"></i>
                            MPU6050 Motion
                        </h2>
                    </div>

                    <div class="panel-body">

                        <div class="sensor-metric">

                            <span class="label">
                                Motion Status
                            </span>

                            <span class="val highlight-green" id="mpu-state">
                                STABIL / AMAN
                            </span>

                        </div>


                        <div class="gauge-group">

                            <div class="gauge-item">

                                <div class="gauge-label">
                                    <span>ACCEL X</span>
                                    <b id="acc-x-val">0.00</b>
                                </div>

                                <div class="progress-bar">
                                    <div class="fill" id="bar-x"></div>
                                </div>

                            </div>


                            <div class="gauge-item">

                                <div class="gauge-label">
                                    <span>ACCEL Y</span>
                                    <b id="acc-y-val">0.00</b>
                                </div>

                                <div class="progress-bar">
                                    <div class="fill" id="bar-y"></div>
                                </div>

                            </div>


                            <div class="gauge-item">

                                <div class="gauge-label">
                                    <span>ACCEL Z</span>
                                    <b id="acc-z-val">1.00</b>
                                </div>

                                <div class="progress-bar">
                                    <div class="fill" id="bar-z"></div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- CAMERA -->
                <div class="panel">

                    <div class="panel-header">
                        <h2>
                            <i data-lucide="camera"></i>
                            ESP32-CAM
                        </h2>
                    </div>

                    <div class="panel-body sensor-card-body">

                        <div class="sensor-metric">
                            <span class="label">Camera Status</span>
                            <span class="val highlight-cyan" id="cam-ready-state">
                                READY
                            </span>
                        </div>

                        <div class="sensor-metric">
                            <span class="label">Last Capture</span>
                            <span class="val-sub" id="cam-last-time">
                                Belum Ada Tangkapan
                            </span>
                        </div>

                    </div>

                </div>


                <!-- OUTPUT -->
                <div class="panel">

                    <div class="panel-header">
                        <h2>
                            <i data-lucide="volume-2"></i>
                            Output Status
                        </h2>
                    </div>

                    <div class="panel-body sensor-card-body">

                        <div class="sensor-metric">
                            <span class="label">Buzzer</span>
                            <span class="val" id="buzzer-state">
                                SILENT
                            </span>
                        </div>

                        <div class="sensor-metric">
                            <span class="label">LED Indicator</span>
                            <span class="val highlight-green" id="led-indicator-state">
                                HIJAU
                            </span>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- KEAMANAN -->
        <section id="tab-keamanan" class="tab-content">

            <div class="section-heading">
                <div>
                    <span class="eyebrow">SURVEILLANCE</span>
                    <h2>Security Camera</h2>
                    <p>Dokumentasi akses ilegal dari ESP32-CAM.</p>
                </div>
            </div>

            <div class="panel">

                <div class="panel-header">

                    <div>
                        <span class="panel-kicker">ESP32-CAM</span>
                        <h2>
                            <i data-lucide="image"></i>
                            Tangkapan Keamanan
                        </h2>
                    </div>

                    <span class="cam-online">
                        <span></span>
                        CAMERA READY
                    </span>

                </div>

                <div class="panel-body">

                    <div class="cam-gallery">

                        <div class="cam-card">

                            <div class="img-wrapper">

                                <img
                                    src="https://via.placeholder.com/800x500/07111f/38bdf8?text=ESP32-CAM+READY"
                                    alt="ESP32 CAM"
                                    class="gallery-img"
                                    id="latest-cam-img"
                                >

                                <div class="image-overlay">
                                    <i data-lucide="scan"></i>
                                    SECURITY CAMERA
                                </div>

                            </div>

                            <div class="cam-info">

                                <div>
                                    <strong>Latest Security Capture</strong>
                                    <span>Pemicu: PIN Salah 3x / Perpindahan</span>
                                </div>

                                <small id="img-time-1">
                                    --:-- WIB
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- OUTPUT -->
        <section id="tab-output" class="tab-content">

            <div class="section-heading">

                <div>
                    <span class="eyebrow">ACTUATOR</span>
                    <h2>Output & Actuator</h2>
                    <p>Status perangkat output sistem keamanan.</p>
                </div>

            </div>


            <div class="cards-grid output-grid">

                <div class="panel actuator-panel">

                    <div class="panel-header">
                        <h2>
                            <i data-lucide="lock"></i>
                            Solenoid Lock
                        </h2>
                    </div>

                    <div class="panel-body actuator-card">

                        <div class="actuator-icon red" id="actuator-solenoid-icon">
                            <i data-lucide="lock"></i>
                        </div>

                        <h3 id="actuator-solenoid-text">
                            Solenoid Terkunci
                        </h3>

                        <p>
                            Electronic door lock brankas.
                        </p>

                    </div>

                </div>


                <div class="panel actuator-panel">

                    <div class="panel-header">
                        <h2>
                            <i data-lucide="bell"></i>
                            Buzzer Alarm
                        </h2>
                    </div>

                    <div class="panel-body actuator-card">

                        <div class="actuator-icon green" id="actuator-buzzer-icon">
                            <i data-lucide="bell-off"></i>
                        </div>

                        <h3 id="actuator-buzzer-text">
                            Buzzer Non-Aktif
                        </h3>

                        <p>
                            Alarm aktif saat terjadi ancaman.
                        </p>

                    </div>

                </div>


                <div class="panel actuator-panel">

                    <div class="panel-header">
                        <h2>
                            <i data-lucide="lightbulb"></i>
                            LED Indicator
                        </h2>
                    </div>

                    <div class="panel-body actuator-card">

                        <div class="actuator-icon green" id="actuator-led-icon">
                            <i data-lucide="check-circle"></i>
                        </div>

                        <h3 id="actuator-led-text">
                            LED Hijau (Standby)
                        </h3>

                        <p>
                            Menampilkan status sistem.
                        </p>

                    </div>

                </div>

            </div>

        </section>


        <!-- ABOUT -->
        <section id="tab-about" class="tab-content">

            <div class="section-heading">

                <div>
                    <span class="eyebrow">PROJECT</span>
                    <h2>About Project</h2>
                    <p>Informasi sistem dan anggota kelompok.</p>
                </div>

            </div>


            <div class="about-grid">

                <div class="about-photo-card">

                    <img
                        src="img/kelompok.jpg"
                        alt="Foto Kelompok"
                        onerror="this.src='https://via.placeholder.com/700x700/07111f/38bdf8?text=TEAM+TEI'"
                    >

                    <div class="photo-overlay-tag">
                        <i data-lucide="award"></i>
                        SMKN 1 NGLEGOK • TEI
                    </div>

                </div>


                <div class="panel">

                    <span class="eyebrow">SMART SECURITY SYSTEM</span>

                    <h2 class="about-title">
                        Sistem Monitoring Keamanan
                        Brankas Pintar Berbasis IoT
                    </h2>

                    <p class="about-desc">

                        Menggunakan ATmega328 dan ESP32 dengan Komunikasi Data I2C serta User Interface Web Online dengan
                         Fitur Deteksi Akses Ilegal dan Perpindahan Posisi Menggunakan ESP32-CAM dan MPU6050.

                        <br><br>

                        Sistem dilengkapi keypad 4x4, solenoid lock,
                        magnetic switch, MPU6050, buzzer, LED,
                        dan ESP32-CAM untuk mendeteksi serta
                        mendokumentasikan akses ilegal.

                    </p>


                    <h3 class="team-title">
                        Anggota Kelompok
                    </h3>


                    <div class="team-list">

                        <div class="team-card">
                            <span class="num">01</span>
                            <div class="member-info">
                                <h4>Arfa Bentur Rohman</h4>
                                <p>No. 12</p>
                            </div>
                        </div>

                        <div class="team-card">
                            <span class="num">02</span>
                            <div class="member-info">
                                <h4>Chika Anggraini</h4>
                                <p>No. 20</p>
                            </div>
                        </div>

                        <div class="team-card">
                            <span class="num">03</span>
                            <div class="member-info">
                                <h4>Dika Yoga Pratama</h4>
                                <p>No. 26</p>
                            </div>
                        </div>

                        <div class="team-card">
                            <span class="num">04</span>
                            <div class="member-info">
                                <h4>Faida Trisma Amelia</h4>
                                <p>No. 30</p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>

</div>


<!-- IMAGE MODAL -->
<div class="modal" id="image-modal">

    <button class="close-modal" aria-label="Close">
        <i data-lucide="x"></i>
    </button>

    <img class="modal-content-img" id="modal-img">

</div>


<!-- TOAST -->
<div class="toast" id="toast">

    <div class="toast-icon">
        <i data-lucide="check"></i>
    </div>

    <div>
        <strong id="toast-title">System</strong>
        <span id="toast-message">Data berhasil diperbarui.</span>
    </div>

</div>


<script src="js/script.js"></script>

</body>
</html>
