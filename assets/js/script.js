document.addEventListener('DOMContentLoaded', function() {
      const calendarEl = document.getElementById('calendar');
      const today = new Date();                   
      const tomorrow = new Date(today);
      tomorrow.setDate(tomorrow.getDate() + 1); 


      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridDay',
        slotMinTime: '08:00:00',
        slotMaxTime: '20:00:00',
        allDaySlot: false,
        initialDate: today,
        validRange: {
          start: today,
          end: tomorrow
        },
        events:
          {
            url: '/bazesportive_website/fetch-reservations.php',
            method: 'GET',
            failure: function() {
              alert('there was an error while fetching events!');
            }
          }
      });
      calendar.render();
    });