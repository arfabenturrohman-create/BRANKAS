document.addEventListener("DOMContentLoaded", () => {

    lucide.createIcons();

    const DATA_URL = "data_sensor.json";

    let previousPinFailed = null;
    let previousMotionState = null;
    let previousDoorState = null;
    let refreshTimer = null;


    /* =========================
       PAGE HEADER
    ========================= */

    const pageHeaders = {

        dashboard: {
            title: "Real-time Security Dashboard",
            desc: "BRANKAS PINTAR — Ringkasan Utama Keamanan & Sistem IoT"
        },

        sensor: {
            title: "Monitoring Telemetri Sensor",
            desc: "Data Real-time Keypad, MPU6050, Sensor Pintu & ESP32-CAM"
        },

        keamanan: {
            title: "Security Camera & Detection",
            desc: "Dokumentasi akses ilegal dan kejadian keamanan"
        },

        output: {
            title: "Status Aktuator & Output",
            desc: "Monitoring Solenoid Lock, Buzzer dan LED Indicator"
        },

        about: {
            title: "Informasi Project & Profil Tim",
            desc: "Teknik Elektronika Industri — SMKN 1 NGLEGOK"
        }

    };


    /* =========================
       TAB NAVIGATION
    ========================= */

    const navItems = document.querySelectorAll(".nav-item");
    const tabs = document.querySelectorAll(".tab-content");

    const pageTitle = document.getElementById("page-title");
    const pageDesc = document.getElementById("page-desc");

    navItems.forEach(item => {

        item.addEventListener("click", () => {

            const tabName = item.dataset.tab;

            navItems.forEach(nav => {
                nav.classList.remove("active");
            });

            tabs.forEach(tab => {
                tab.classList.remove("active");
            });

            item.classList.add("active");

            const target = document.getElementById(`tab-${tabName}`);

            if (target) {
                target.classList.add("active");
            }

            if (pageHeaders[tabName]) {

                pageTitle.textContent =
                    pageHeaders[tabName].title;

                pageDesc.textContent =
                    pageHeaders[tabName].desc;

            }

        });

    });


    /* =========================
       CLOCK
    ========================= */

    function updateClock() {

        const now = new Date();

        const h = String(now.getHours()).padStart(2, "0");
        const m = String(now.getMinutes()).padStart(2, "0");
        const s = String(now.getSeconds()).padStart(2, "0");

        const clock = document.getElementById("live-clock");

        if (clock) {
            clock.textContent = `${h}:${m}:${s} WIB`;
        }

    }

    updateClock();

    setInterval(updateClock, 1000);


    /* =========================
       TOAST
    ========================= */

    function showToast(title, message) {

        const toast = document.getElementById("toast");
        const titleElement = document.getElementById("toast-title");
        const messageElement = document.getElementById("toast-message");

        if (!toast) return;

        titleElement.textContent = title;
        messageElement.textContent = message;

        toast.classList.add("show");

        setTimeout(() => {
            toast.classList.remove("show");
        }, 2500);

    }


    /* =========================
       LOG SYSTEM
    ========================= */

    function addLog(type, message) {

        const list =
            document.getElementById("live-feed-list");

        if (!list) return;

        const now = new Date();

        const time =
            `${String(now.getHours()).padStart(2, "0")}:` +
            `${String(now.getMinutes()).padStart(2, "0")}:` +
            `${String(now.getSeconds()).padStart(2, "0")}`;

        let badgeClass = "info";

        if (type === "DANGER") {
            badgeClass = "danger";
        }

        if (type === "SUCCESS") {
            badgeClass = "success";
        }

        const li = document.createElement("li");

        li.innerHTML = `
            <span class="badge ${badgeClass}">
                ${type}
            </span>

            <span class="log-text">
                ${message}
            </span>

            <span class="log-time">
                ${time}
            </span>
        `;

        list.insertBefore(li, list.firstChild);

        while (list.children.length > 10) {
            list.removeChild(list.lastChild);
        }

    }


    /* =========================
       COUNTER
    ========================= */

    function animateCounter(element, start, end) {

        if (!element) return;

        const duration = 500;
        const startTime = performance.now();

        function animate(currentTime) {

            const progress =
                Math.min((currentTime - startTime) / duration, 1);

            const value =
                Math.floor(start + (end - start) * progress);

            element.textContent = value;

            if (progress < 1) {
                requestAnimationFrame(animate);
            }

        }

        requestAnimationFrame(animate);

    }


    /* =========================
       SAFE STATUS
    ========================= */

    function updateHeroStatus(data) {

        const hero =
            document.getElementById("hero-status");

        if (!hero) return;

        const danger =
            Number(data.pin_failed) >= 3 ||
            Boolean(data.motion_detected);

        if (danger) {

            hero.textContent =
                "DETEKSI ANCAMAN ILLEGAL!";

            hero.className =
                "badge-status-danger";

        } else {

            hero.textContent =
                "TERPROTEKSI AMAN";

            hero.className =
                "badge-status-safe";

        }

    }


    /* =========================
       SENSOR UPDATE
    ========================= */

    function updateSensor(data) {

        /* SOLENOID */

        const solenoidOpen =
            Boolean(data.solenoid_open);

        const lockText =
            solenoidOpen ? "TERBUKA" : "TERKUNCI";

        const dashLock =
            document.getElementById("dash-lock-status");

        const solenoidStatus =
            document.getElementById("solenoid-status");

        const actuatorSolenoid =
            document.getElementById("actuator-solenoid-text");

        if (dashLock) {
            dashLock.textContent = lockText;
        }

        if (solenoidStatus) {

            solenoidStatus.textContent = lockText;

            solenoidStatus.className =
                solenoidOpen
                    ? "val highlight-green"
                    : "val highlight-red";

        }

        if (actuatorSolenoid) {

            actuatorSolenoid.textContent =
                solenoidOpen
                    ? "Solenoid Terbuka"
                    : "Solenoid Terkunci";

        }


        /* DOOR */

        const doorOpen =
            Boolean(data.door_open);

        const doorText =
            doorOpen ? "TERBUKA" : "TERTUTUP";

        const dashDoor =
            document.getElementById("dash-door-status");

        const doorStatus =
            document.getElementById("door-switch-status");

        if (dashDoor) {
            dashDoor.textContent = doorText;
        }

        if (doorStatus) {

            doorStatus.textContent = doorText;

            doorStatus.className =
                doorOpen
                    ? "val highlight-red"
                    : "val highlight-cyan";

        }

        if (
            previousDoorState !== null &&
            previousDoorState !== doorOpen
        ) {

            addLog(
                doorOpen ? "DANGER" : "INFO",
                `Pintu brankas ${doorText.toLowerCase()}.`
            );

        }

        previousDoorState = doorOpen;


        /* PIN */

        const pinFailed =
            Number(data.pin_failed) || 0;

        const dashPin =
            document.getElementById("dash-pin-failed");

        const pinCounter =
            document.getElementById("pin-failed-count");

        if (dashPin) {
            dashPin.textContent = pinFailed;
        }

        if (pinCounter) {

            const oldValue =
                previousPinFailed === null
                    ? pinFailed
                    : previousPinFailed;

            animateCounter(
                pinCounter,
                oldValue,
                pinFailed
            );

        }

        if (
            previousPinFailed !== null &&
            pinFailed > previousPinFailed
        ) {

            addLog(
                "DANGER",
                `Percobaan PIN gagal bertambah menjadi ${pinFailed}.`
            );

        }

        if (
            pinFailed >= 3 &&
            previousPinFailed !== 3
        ) {

            addLog(
                "DANGER",
                "PIN salah 3x! ESP32-CAM siap mengambil foto."
            );

            showToast(
                "SECURITY ALERT",
                "Percobaan PIN mencapai batas keamanan."
            );

        }

        previousPinFailed = pinFailed;


        /* MPU6050 */

        const x =
            Number(data.accel_x) || 0;

        const y =
            Number(data.accel_y) || 0;

        const z =
            Number(data.accel_z) || 0;

        document.getElementById("acc-x-val").textContent =
            x.toFixed(2);

        document.getElementById("acc-y-val").textContent =
            y.toFixed(2);

        document.getElementById("acc-z-val").textContent =
            z.toFixed(2);

        document.getElementById("bar-x").style.width =
            `${Math.min(Math.abs(x) * 50, 100)}%`;

        document.getElementById("bar-y").style.width =
            `${Math.min(Math.abs(y) * 50, 100)}%`;

        document.getElementById("bar-z").style.width =
            `${Math.min(Math.abs(z) * 50, 100)}%`;


        const motion =
            Boolean(data.motion_detected);

        const dashMpu =
            document.getElementById("dash-mpu-status");

        const mpuState =
            document.getElementById("mpu-state");

        if (dashMpu) {

            dashMpu.textContent =
                motion ? "WARNING" : "STABIL";

        }

        if (mpuState) {

            mpuState.textContent =
                motion
                    ? "PERPINDAHAN TERDETEKSI"
                    : "STABIL / AMAN";

            mpuState.className =
                motion
                    ? "val highlight-red"
                    : "val highlight-green";

        }

        if (
            motion &&
            previousMotionState === false
        ) {

            addLog(
                "DANGER",
                "MPU6050 mendeteksi guncangan/perpindahan brankas!"
            );

            showToast(
                "MOTION ALERT",
                "Perpindahan brankas terdeteksi."
            );

        }

        previousMotionState = motion;


        /* CAMERA */

        const camState =
            document.getElementById("cam-ready-state");

        const camLast =
            document.getElementById("cam-last-time");

        const imageTime =
            document.getElementById("img-time-1");

        const cameraImage =
            document.getElementById("latest-cam-img");

        if (camState) {
            camState.textContent =
                data.cam_status || "READY";
        }

        if (camLast) {
            camLast.textContent =
                data.last_capture_time ||
                "Belum Ada Tangkapan";
        }

        if (imageTime) {
            imageTime.textContent =
                data.last_capture_time ||
                "--:-- WIB";
        }

        if (
            cameraImage &&
            data.image_url
        ) {

            cameraImage.src =
                data.image_url;

        }


        /* BUZZER */

        const buzzer =
            Boolean(data.buzzer_active);

        const buzzerState =
            document.getElementById("buzzer-state");

        const actuatorBuzzer =
            document.getElementById("actuator-buzzer-text");

        if (buzzerState) {

            buzzerState.textContent =
                buzzer
                    ? "ALARM AKTIF"
                    : "SILENT";

            buzzerState.className =
                buzzer
                    ? "val highlight-red"
                    : "val highlight-green";

        }

        if (actuatorBuzzer) {

            actuatorBuzzer.textContent =
                buzzer
                    ? "Buzzer Berbunyi"
                    : "Buzzer Non-Aktif";

        }


        /* LED */

        const redLed =
            Boolean(data.led_red_active);

        const led =
            document.getElementById("led-indicator-state");

        const actuatorLed =
            document.getElementById("actuator-led-text");

        if (led) {

            led.textContent =
                redLed
                    ? "MERAH (WARNING)"
                    : "HIJAU (NORMAL)";

            led.className =
                redLed
                    ? "val highlight-red"
                    : "val highlight-green";

        }

        if (actuatorLed) {

            actuatorLed.textContent =
                redLed
                    ? "LED Merah Menyala"
                    : "LED Hijau Menyala";

        }

    }


    /* =========================
       FETCH DATA
    ========================= */

    async function fetchSensorData(showMessage = false) {

        const refreshButton =
            document.getElementById("refresh-btn");

        try {

            if (refreshButton) {
                refreshButton.classList.add("loading");
            }

            const response =
                await fetch(
                    `${DATA_URL}?t=${Date.now()}`,
                    {
                        cache: "no-store"
                    }
                );

            if (!response.ok) {
                throw new Error("Data tidak tersedia");
            }

            const data =
                await response.json();

            updateHeroStatus(data);
            updateSensor(data);

            const update =
                document.getElementById("last-update");

            if (update) {

                const now = new Date();

                update.textContent =
                    `Update ${String(now.getHours()).padStart(2,"0")}:` +
                    `${String(now.getMinutes()).padStart(2,"0")}:` +
                    `${String(now.getSeconds()).padStart(2,"0")}`;

            }

            if (showMessage) {

                showToast(
                    "DATA UPDATED",
                    "Data sensor berhasil diperbarui."
                );

            }

        } catch (error) {

            console.log(
                "Menunggu data_sensor.json...",
                error
            );

        } finally {

            if (refreshButton) {
                setTimeout(() => {
                    refreshButton.classList.remove("loading");
                }, 300);
            }

        }

    }


    /* =========================
       MANUAL REFRESH
    ========================= */

    window.manualRefresh = function () {
        fetchSensorData(true);
    };


    const refreshButton =
        document.getElementById("refresh-btn");

    if (refreshButton) {

        refreshButton.addEventListener(
            "click",
            () => fetchSensorData(true)
        );

    }


    /* =========================
       AUTO REFRESH
    ========================= */

    fetchSensorData();

    refreshTimer =
        setInterval(
            () => fetchSensorData(false),
            1500
        );


    /* =========================
       IMAGE MODAL
    ========================= */

    const modal =
        document.getElementById("image-modal");

    const modalImage =
        document.getElementById("modal-img");

    const closeModal =
        document.querySelector(".close-modal");

    document.querySelectorAll(".gallery-img")
        .forEach(image => {

            image.addEventListener("click", () => {

                modalImage.src =
                    image.src;

                modal.classList.add("show");

            });

        });


    function hideModal() {

        modal.classList.remove("show");

    }

    if (closeModal) {
        closeModal.addEventListener(
            "click",
            hideModal
        );
    }

    if (modal) {

        modal.addEventListener(
            "click",
            event => {

                if (event.target === modal) {
                    hideModal();
                }

            }
        );

    }

});
