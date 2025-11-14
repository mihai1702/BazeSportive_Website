<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Baze Sportive UMFST – Rezervări</title>
    <link rel="stylesheet" href="assets/style/style.css">

    <style>
        :root {
            --primary: #003366;
            --secondary: #cc9933;
            --bg: #eef1f5;
            --card-bg: #ffffff;
            --text: #1d1d1d;
            --radius: 14px;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* DARK MODE */
        body.dark {
            --bg: #0f1116;
            --card-bg: #1a1d24;
            --text: #e6e6e6;
            --shadow: 0 4px 12px rgba(255, 255, 255, 0.08);
        }

        body {
            font-family: "Inter", sans-serif;
            margin: 0;
            background: var(--bg);
            color: var(--text);
            transition: background 0.3s, color 0.3s;
        }

        /* HEADER */
        /* header {
            background: var(--primary);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow);
        } */
        header h1 { margin: 0; font-size: 26px; font-weight: 600; }

        .theme-toggle {
            background: var(--secondary);
            padding: 10px 14px;
            border-radius: 8px;
            cursor: pointer;
            color: white;
            font-weight: bold;
        }

        /* LOADING SCREEN */
        #loading {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 200;
        }
        .spinner {
            width: 70px;
            height: 70px;
            border: 8px solid #fff;
            border-top-color: var(--secondary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ANIMATION FADE-IN */
        .fade-in {
            animation: fade 0.5s ease forwards;
            opacity: 0;
        }
        @keyframes fade {
            to { opacity: 1; }
        }

        /* CONTAINER + CARDS */
        .container {
            max-width: 1250px;
            margin: 40px auto;
            padding: 20px;
        }

        .card {
            background: var(--card-bg);
            box-shadow: var(--shadow);
            border-radius: var(--radius);
            padding: 30px;
            margin-bottom: 30px;
            transition: background 0.3s, color 0.3s;
        }

        h2 { margin-top: 0; color: var(--primary); font-size: 24px; }

        .bases-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .base-item {
            background: var(--card-bg);
            padding: 25px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border-top: 6px solid var(--primary);
            transition: 0.25s;
        }
        .base-item:hover {
            transform: translateY(-6px);
        }

        .reserve-btn {
            width: 100%;
            margin-top: 15px;
            background: var(--primary);
            padding: 12px;
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        .reserve-btn:hover { background: #00264d; }

        /* MODAL */
        #modal {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            display: none;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-content {
            width: 420px;
            background: var(--card-bg);
            padding: 25px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            animation: pop 0.25s ease;
        }

        @keyframes pop {
            from { transform: scale(0.85); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-close { float:right; cursor:pointer; font-size:20px; }

        .input-group { margin-bottom: 15px; }

        .confirm-btn {
            width: 100%;
            background: var(--secondary);
            padding: 12px;
            border-radius: 10px;
            border: none;
            color:white;
            cursor:pointer;
        }

        footer {
            margin-top: 40px;
            text-align: center;
            padding: 20px;
            background: var(--primary);
            color: white;
        }
    </style>
</head>
<body>
<!-- LOADING -->
<div id="loading">
    <div class="spinner"></div>
</div>

<?php include "assets/components/header.php";?>

<div class="container fade-in">

    <div class="card">
        <h2>Bun venit!</h2>
        <p>Astăzi este <strong id="today-date"></strong>.</p>
    </div>

    <div class="card">
        <h2>Baze sportive</h2>
        <div class="bases-grid" id="bases-container"></div>
    </div>

</div>

<!-- MODAL -->
<div id="modal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <h3>Rezervare</h3>
        <div id="modal-baza-name"></div>

        <div class="input-group">
            <label>Data:</label>
            <input type="date" id="res-date" />
        </div>

        <div class="input-group">
            <label>Ora:</label>
            <select id="res-time">
                <option>08:00 - 09:00</option>
                <option>09:00 - 10:00</option>
                <option>10:00 - 11:00</option>
                <option>17:00 - 18:00</option>
                <option>18:00 - 19:00</option>
                <option>19:00 - 20:00</option>
            </select>
        </div>

        <button class="confirm-btn" onclick="finalizeReservation()">Confirmă</button>
    </div>
</div>

<footer>
    © 2025 UMFST „George Emil Palade” – Rezervări
</footer>

<script>
    // Fake data
    const bazeSportive = [
        { id: 1, nume: "Sala Sporturilor", totalLocuri: 30, ocupate: 12 },
        { id: 2, nume: "Teren Fotbal Sintetic", totalLocuri: 20, ocupate: 8 },
        { id: 3, nume: "Fitness Hall", totalLocuri: 15, ocupate: 4 },
        { id: 4, nume: "Teren Baschet Exterior", totalLocuri: 12, ocupate: 5 }
    ];

    let selectedBase = null;

    /* LOADING */
    window.onload = () => {
        setTimeout(() => {
            document.getElementById("loading").style.display = "none";
        }, 900);
    };

    /* DARK MODE */
    function toggleTheme() {
        document.body.classList.toggle("dark");
    }

    /* DATE */
    document.getElementById("today-date").innerText = new Date().toLocaleDateString("ro-RO", {
        weekday: "long", year: "numeric", month: "long", day: "numeric"
    });

    /* LIST AREA */
    const container = document.getElementById("bases-container");
    bazeSportive.forEach(baza => {
        const libere = baza.totalLocuri - baza.ocupate;

        const div = document.createElement("div");
        div.className = "base-item fade-in";
        div.innerHTML = `
            <div class="base-title">${baza.nume}</div>
            <p>Locuri totale: ${baza.totalLocuri}</p>
            <p><strong>${libere}</strong> libere</p>
            <button class="reserve-btn" onclick="openModal(${baza.id})">Rezervă</button>`;

        container.appendChild(div);
    });

    /* MODAL FUNCTIONS */
    function openModal(id) {
        const baza = bazeSportive.find(b => b.id === id);
        selectedBase = baza;
        document.getElementById("modal-baza-name").innerHTML = `<strong>${baza.nume}</strong>`;
        document.getElementById("modal").style.display = "flex";
    }

    function closeModal() { document.getElementById("modal").style.display = "none"; }

    function finalizeReservation() {
        closeModal();
        alert("Rezervare efectuată pentru " + selectedBase.nume);
    }
</script>
<script src="assets/js/script.js"></script>
</body>
</html>