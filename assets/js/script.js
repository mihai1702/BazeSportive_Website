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