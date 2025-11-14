document.addEventListener('DOMContentLoaded', function() {
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
      center: 'title',
      right: 'timeGridWeek,timeGridDay'
    },
    businessHours: [
      {
        daysOfWeek: [1],
        startTime: '20:00',
        endTime: '21:30'
      },
      {
        daysOfWeek: [5],
        startTime: '19:00',
        endTime: '21:00'
      }
    ],
    validRange: {
      start: today,
      end: endDate
    },
    events: {
      url: '/bazesportive_website/fetch-reservations.php',
      method: 'GET',
      failure: function() {
        alert('Eroare la încărcarea rezervărilor!');
      }
    },
    slotDuration: '00:30:00',
    selectable: true,
    selectAllow: function(selectInfo) {
      const start = selectInfo.start;
      const day = start.getDay(); // 1 = luni, 5 = vineri
      const hour = start.getHours();
      const minute = start.getMinutes();

      // Luni: 20:00 - 21:30
      if (day === 1) {
        const startMinutes = hour * 60 + minute;
        return startMinutes >= 20 * 60 && startMinutes < 21 * 60 + 30;
      }

      // Vineri: 19:00 - 21:00
      if (day === 5) {
        const startMinutes = hour * 60 + minute;
        return startMinutes >= 19 * 60 && startMinutes < 21 * 60;
      }

      // Orice altă zi: nu permite selectarea
      return false;
    },

    select: function(info) {
      const start = new Date(info.start);
      const day = start.getDay();
      let maxEndTime;

      if (day === 1) {
        maxEndTime = new Date(start);
        maxEndTime.setHours(21, 30, 0);
      } else if (day === 5) {
        maxEndTime = new Date(start);
        maxEndTime.setHours(21, 0, 0);
      } else {
        alert("Programările sunt deschise doar luni și vineri în intervalul orar specificat.");
        return;
      }

      const diffMinutes = Math.floor((maxEndTime - start) / 60000);

      let durationoptions = `<option value="30">30 minute</option>`;
      if (diffMinutes >= 60) durationoptions += `<option value="60">O oră</option>`;
      if (diffMinutes >= 90) durationoptions += `<option value="90">O oră și jumătate</option>`;
      if (diffMinutes >= 120) durationoptions += `<option value="120">Două ore</option>`;

      const startISO = info.start.toLocaleString('sv-SE').replace(' ', 'T').slice(0, 16);

      const formHtml = `
        <div id="reservation-form" class="reservation-form">
          <div class="form-content">
            <h3>Fă o rezervare</h3>
            <form id="reservationForm">
              <label>Data și ora începutului:</label>
              <input type="datetime-local" name="start_time" value="${startISO}" readonly><br>
              
              <label>Durata:</label>
              <select name="duration">${durationoptions}</select><br>
              
              <label>Număr de persoane:</label>
              <input type="number" name="nr_participants" min="1" max="10" value="1" required><br>
              
              <button type="submit">Confirmă rezervarea</button>
              <button type="button" id="close-form">Anulează</button>
            </form>
          </div>
        </div>
      `;

      document.body.insertAdjacentHTML('beforeend', formHtml);
      document.getElementById('close-form').onclick = () => {
        document.getElementById('reservation-form').remove();
      };
      document.getElementById('reservationForm').onsubmit = async (e)=> {
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
      }
    }
  });

  calendar.render();
});
