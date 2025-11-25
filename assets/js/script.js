document.addEventListener('DOMContentLoaded', function () {
    /* ===========================
       INITIALIZARE CALENDAR
    ============================ */
    const calendarEl = document.getElementById('calendar');
    const today = new Date();
    const endDate = new Date();
    endDate.setDate(today.getDate() + 14);

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        slotMinTime: '19:00:00',
        slotMaxTime: '22:00:00',
        allDaySlot: false,
        initialDate: today,
        hiddenDays: [0, 2, 3, 4, 6],

        headerToolbar: {
            left: 'prev,next',
            center: '',
            right: 'title'
        },

        businessHours: [
            { daysOfWeek: [1], startTime: '20:00', endTime: '21:30' },
            { daysOfWeek: [5], startTime: '19:00', endTime: '21:00' }
        ],

        validRange: {
            start: today,
            end: endDate
        },

        events: {
            url: '/bazesportive_website/fetch-reservations.php',
            method: 'GET',
            failure: () => alert('Eroare la încărcarea rezervărilor!')
        },

        slotDuration: '00:30:00',
        selectable: true,

        /* ===========================
           VALIDARE SELECTARE INTERVAL
        ============================ */
        selectAllow: function (selectInfo) {
            const start = selectInfo.start;
            const day = start.getDay();
            const hour = start.getHours();
            const minute = start.getMinutes();
            const startMinutes = hour * 60 + minute;

            if (day === 1) return startMinutes >= 20 * 60 && startMinutes < 21 * 60 + 30;
            if (day === 5) return startMinutes >= 19 * 60 && startMinutes < 21 * 60;
            return false;
        },


        select: function (info) {

            const start = new Date(info.start);
            const date = start.toISOString().split("T")[0];
            const startTime = start.toTimeString().split(" ")[0];

            fetch(`/bazesportive_website/check-availability.php?date=${date}&start=${startTime}`)
                .then(res => res.json())
                .then(data => {

                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    const diffMinutes = data.max_minutes;
                    if (diffMinutes < 30) {
                        alert("Nu există suficient timp liber pentru o rezervare în acest interval.");
                        return;
                    }

                    /* DURATE DISPONIBILE */
                    let durationoptions = `<option value="30">30 minute</option>`;
                    if (diffMinutes >= 60) durationoptions += `<option value="60">O oră</option>`;
                    if (diffMinutes >= 90) durationoptions += `<option value="90">O oră și jumătate</option>`;
                    if (diffMinutes >= 120) durationoptions += `<option value="120">Două ore</option>`;

                    const startISO = info.start.toLocaleString('sv-SE').replace(' ', 'T').slice(0, 16);

                    /* FORMULAR HTML PENTRU REZERVARE NOUA*/
                    const formHtml = `
                        <div id="reservation-form" class="reservation-form">
                            <div class="form-content">
                                <h3>Fă o rezervare</h3>

                                <form id="reservationForm">

                                    <div>
                                        <label>Data și ora începutului:</label>
                                        <input type="datetime-local" name="start_time" value="${startISO}" readonly>
                                    </div>

                                    <div>
                                        <label>Durata:</label>
                                        <select name="duration">${durationoptions}</select>
                                    </div>

                                    <div class="multi-select-container">
                                        <label>Selectează participanții:</label>

                                        <div id="multiSelect" class="multi-select">
                                            <div class="multi-select-header">
                                                <p>Selecteaza participantii 
                                                   <img src="assets/icons/dropdown-icon.png" alt="...">
                                                </p>
                                            </div>

                                            <div class="multi-select-list">
                                                <input 
                                                    type="text" 
                                                    id="participantSearch" 
                                                    class="search-input" 
                                                    placeholder="Caută participant...">

                                                <div class="participants-box" id="participants-box"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <button type="submit">Confirmă rezervarea</button>
                                        <button type="button" id="close-form">Anulează</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    `;

                    document.body.insertAdjacentHTML('beforeend', formHtml);

                    document.querySelector(".multi-select-header").addEventListener("click", () => {
                        document.querySelector(".multi-select-list").classList.toggle("show");
                    });

                    document.addEventListener("click", (e) => {
                        const box = document.querySelector(".multi-select");
                        const list = document.querySelector(".multi-select-list");
                        if (!box.contains(e.target)) list.classList.remove("show");
                    });

                    const participants_box = document.getElementById("participants-box");

                    fetch("/bazesportive_website/fetch-acc.php")
                        .then(res => res.json())
                        .then(accounts => {

                            participants_box.innerHTML = "";

                            accounts.forEach(acc => {
                                const item = document.createElement("div");
                                item.classList.add("participant-item");
                                item.dataset.name = acc.full_name.toLowerCase();

                                item.innerHTML = `
                                    <input type="checkbox" name="participants[]" value="${acc.account_id}">
                                    <span>${acc.full_name}</span>
                                `;
                                participants_box.appendChild(item);
                            });

                            const searchInput = document.getElementById("participantSearch");
                            searchInput.addEventListener("input", () => {

                                const term = searchInput.value.toLowerCase().trim();

                                document.querySelectorAll(".participant-item").forEach(item => {
                                    const name = item.dataset.name;
                                    if (!name) return;
                                    item.style.display = name.includes(term) ? "flex" : "none";
                                });
                            });
                        })
                        .catch(err => {
                            participants_box.innerHTML = "<p>Eroare la încărcarea participanților.</p>";
                            console.error(err);
                        });

                    document.getElementById('close-form').onclick = () => {
                        document.getElementById('reservation-form').remove();
                    };

                    document.getElementById('reservationForm').onsubmit = async (e) => {
                        e.preventDefault();
                        const formData = new FormData(e.target);

                        const response = await fetch('/bazesportive_website/make-reservation.php', {
                            method: 'POST',
                            body: formData
                        });

                        const result = await response.json();
                        alert(result.message);

                        document.getElementById('reservation-form').remove();
                        calendar.refetchEvents();
                    };

                });
        }
    });

    calendar.render();

});


/* ===========================
   LOADING SCREEN
=========================== */
window.onload = () => {
    document.getElementById("loading").style.display = "none";
};


/* ===========================
   ANULARE REZERVARE
=========================== */
document.querySelectorAll('.btn-cancel-res').forEach(btn => {

    btn.addEventListener('click', () => {
        const id = btn.dataset.id;

        const popup = document.getElementById("confirm-popup");
        const yesBtn = document.getElementById("confirm-yes");
        const noBtn = document.getElementById("confirm-no");

        popup.classList.remove("hidden");

        noBtn.onclick = () => popup.classList.add("hidden");

        yesBtn.onclick = () => {
            popup.classList.add("hidden");

            fetch('delete-reservation.php', {
                method: 'POST',
                headers: { "Content-type": "application/x-www-form-urlencoded" },
                body: "reservation_id=" + id
            })
            .then(res => res.json())
            .then(data => {

                showToast(data.message, data.status);

                if (data.status === "success") {
                    document.querySelector(`tr[data-row-id="${id}"]`)?.remove();
                }
            });
        };
    });

});

function showToast(message, status = "success") {
    const toast = document.getElementById("toast");
    toast.textContent = message;

    toast.classList.remove("hidden", "error");
    if (status === "error") toast.classList.add("error");

    setTimeout(() => toast.classList.add("show"), 10);

    setTimeout(() => {
        toast.classList.remove("show");
        setTimeout(() => toast.classList.add("hidden"), 400);
    }, 2500);
}



/* ===========================
   MOBILE NAV MENU
=========================== */
    const menuToggle = document.getElementById("menuToggle");
    const navbar = document.querySelector(".navbar");

    menuToggle.addEventListener("click", (e) => {
        e.preventDefault();
        navbar.classList.toggle("show");
    });
