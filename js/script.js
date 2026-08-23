document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();

    // TAB NAVIGATION SYSTEM
    const navItems = document.querySelectorAll('.nav-item');
    const tabContents = document.querySelectorAll('.tab-content');

    navItems.forEach(item => {
        item.addEventListener('click', () => {
            const tabId = item.getAttribute('data-tab');
            navItems.forEach(nav => nav.classList.remove('active'));
            tabContents.forEach(tab => tab.classList.remove('active'));
            item.classList.add('active');
            const targetTab = document.getElementById(`tab-${tabId}`);
            if (targetTab) targetTab.classList.add('active');
        });
    });

    // REAL-TIME CLOCK
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const clockElem = document.getElementById('live-clock');
        if (clockElem) clockElem.textContent = `${hours}:${minutes}:${seconds} WIB`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // COUNTER ANIMATION FOR PIN FAILED COUNT
    function animateCounter(element, start, end, duration) {
        if (!element) return;
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            element.textContent = Math.floor(progress * (end - start) + start);
            if (progress < 1) window.requestAnimationFrame(step);
        };
        window.requestAnimationFrame(step);
    }

    // IMAGE MODAL SYSTEM
    const modal = document.getElementById('image-modal');
    const modalImg = document.getElementById('modal-img');
    const closeModal = document.querySelector('.close-modal');

    document.querySelectorAll('.gallery-img').forEach(img => {
        img.addEventListener('click', () => {
            if (modal && modalImg) {
                modal.style.display = "flex";
                modalImg.src = img.src;
            }
        });
    });

    if (closeModal) {
        closeModal.addEventListener('click', () => {
            modal.style.display = "none";
        });
    }

    // LIVE LOG FEED GENERATOR
    function addLogEntry(type, message) {
        const feedList = document.getElementById('live-feed-list');
        if (!feedList) return;

        const now = new Date();
        const timeStr = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}:${String(now.getSeconds()).padStart(2, '0')}`;

        const li = document.createElement('li');
        let badgeClass = 'info';
        if (type === 'DANGER') badgeClass = 'danger';
        if (type === 'SUCCESS') badgeClass = 'success';

        li.innerHTML = `
            <span class="badge ${badgeClass}">${type}</span>
            <span class="log-text">${message}</span>
            <span class="log-time">${timeStr}</span>
        `;

        feedList.insertBefore(li, feedList.firstChild);

        // Limit list to 10 items
        if (feedList.children.length > 10) {
            feedList.removeChild(feedList.lastChild);
        }
    }

    // AUTO-FETCH DATA SENSOR
    let previousPinFailed = -1;
    let previousMotionState = false;
    let previousDoorState = false;

    async function fetchSensorData() {
        try {
            const response = await fetch('data_sensor.json');
            if (!response.ok) throw new Error('Network response error');
            const data = await response.json();

            // Status Hero Banner
            const heroStatus = document.getElementById('hero-status');
            const isAlert = data.pin_failed >= 3 || data.motion_detected;
            if (heroStatus) {
                heroStatus.textContent = isAlert ? 'DETEKSI ANCAMAN ILLEGAL!' : 'TERPROTEKSI AMAN';
                heroStatus.className = isAlert ? 'badge-status-danger' : 'badge-status-safe';
            }

            // Status Solenoid
            const lockStatusElem = document.getElementById('dash-lock-status');
            const solenoidStatusElem = document.getElementById('solenoid-status');
            const actuatorSolenoidText = document.getElementById('actuator-solenoid-text');
            const solenoidText = data.solenoid_open ? 'TERBUKA' : 'TERKUNCI';

            if (lockStatusElem) lockStatusElem.textContent = solenoidText;
            if (solenoidStatusElem) {
                solenoidStatusElem.textContent = solenoidText;
                solenoidStatusElem.className = data.solenoid_open ? 'val highlight-green' : 'val highlight-red';
            }
            if (actuatorSolenoidText) {
                actuatorSolenoidText.textContent = data.solenoid_open ? 'Solenoid Terbuka (Akses Diterima)' : 'Solenoid Terkunci';
            }

            // Status Sensor Pintu (Magnetic Switch)
            const dashDoor = document.getElementById('dash-door-status');
            const doorSwitch = document.getElementById('door-switch-status');
            const doorText = data.door_open ? 'TERBUKA' : 'TERTUTUP';
            
            if (dashDoor) dashDoor.textContent = doorText;
            if (doorSwitch) {
                doorSwitch.textContent = doorText;
                doorSwitch.className = data.door_open ? 'val highlight-red' : 'val highlight-cyan';
            }

            if (previousDoorState !== data.door_open && previousDoorState !== false) {
                addLogEntry(data.door_open ? 'DANGER' : 'INFO', `Pintu brankas terdeteksi ${doorText.toLowerCase()}.`);
            }
            previousDoorState = data.door_open;

            // Counter PIN Gagal
            if (data.pin_failed !== previousPinFailed) {
                const dashPin = document.getElementById('dash-pin-failed');
                const pinFailedElem = document.getElementById('pin-failed-count');
                if (dashPin) dashPin.textContent = data.pin_failed;
                if (pinFailedElem) {
                    animateCounter(pinFailedElem, previousPinFailed < 0 ? 0 : previousPinFailed, data.pin_failed, 800);
                }
                if (data.pin_failed === 3 && previousPinFailed !== 3) {
                    addLogEntry('DANGER', 'Akses Ilegal: PIN Salah 3x! ESP32-CAM mengambil foto.');
                }
                previousPinFailed = data.pin_failed;
            }

            // MPU6050 Accelerometer
            const accXVal = document.getElementById('acc-x-val');
            const accYVal = document.getElementById('acc-y-val');
            const accZVal = document.getElementById('acc-z-val');
            if (accXVal) accXVal.textContent = Number(data.accel_x).toFixed(2);
            if (accYVal) accYVal.textContent = Number(data.accel_y).toFixed(2);
            if (accZVal) accZVal.textContent = Number(data.accel_z).toFixed(2);

            const barX = document.getElementById('bar-x');
            const barY = document.getElementById('bar-y');
            const barZ = document.getElementById('bar-z');
            if (barX) barX.style.width = `${Math.min(Math.abs(data.accel_x) * 50, 100)}%`;
            if (barY) barY.style.width = `${Math.min(Math.abs(data.accel_y) * 50, 100)}%`;
            if (barZ) barZ.style.width = `${Math.min(Math.abs(data.accel_z) * 50, 100)}%`;

            // MPU State
            const dashMpu = document.getElementById('dash-mpu-status');
            const mpuState = document.getElementById('mpu-state');
            const mpuText = data.motion_detected ? 'PERPINDAHAN TERDETEKSI' : 'STABIL / AMAN';
            if (dashMpu) dashMpu.textContent = data.motion_detected ? 'WARNING' : 'STABIL';
            if (mpuState) {
                mpuState.textContent = mpuText;
                mpuState.className = data.motion_detected ? 'val highlight-red' : 'val highlight-green';
            }

            if (data.motion_detected && !previousMotionState) {
                addLogEntry('DANGER', 'Sensor MPU6050 mendeteksi guncangan/perpindahan brankas!');
            }
            previousMotionState = data.motion_detected;

            // Kamera Status & Foto
            const camReadyState = document.getElementById('cam-ready-state');
            const camLastTime = document.getElementById('cam-last-time');
            const imgTime1 = document.getElementById('img-time-1');
            const latestCamImg = document.getElementById('latest-cam-img');

            if (camReadyState) camReadyState.textContent = data.cam_status || 'READY';
            if (camLastTime) camLastTime.textContent = data.last_capture_time || 'Belum Ada Tangkapan';
            if (imgTime1) imgTime1.textContent = data.last_capture_time || '--:-- WIB';
            
            if (latestCamImg && data.image_url) {
                latestCamImg.src = data.image_url;
            }

            // Buzzer & LED Indikator
            const buzzerState = document.getElementById('buzzer-state');
            const ledState = document.getElementById('led-indicator-state');
            const actuatorBuzzerText = document.getElementById('actuator-buzzer-text');
            const actuatorLedText = document.getElementById('actuator-led-text');

            if (buzzerState) buzzerState.textContent = data.buzzer_active ? 'ALARM AKTIF (ON)' : 'SILENT';
            if (actuatorBuzzerText) actuatorBuzzerText.textContent = data.buzzer_active ? 'Buzzer Berbunyi (Alarm)' : 'Buzzer Non-Aktif';

            if (ledState) {
                ledState.textContent = data.led_red_active ? 'MERAH (WARNING)' : 'HIJAU (STANDBY)';
                ledState.className = data.led_red_active ? 'val highlight-red' : 'val highlight-green';
            }
            if (actuatorLedText) {
                actuatorLedText.textContent = data.led_red_active ? 'LED Merah Menyala (Peringatan)' : 'LED Hijau Menyala (Normal)';
            }

        } catch (error) {
            console.log('Menunggu sinkronisasi data_sensor.json...');
        }
    }

    setInterval(fetchSensorData, 1500);
    fetchSensorData();
});