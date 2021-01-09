import './styles/booking_index.css';

import { Calendar } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import dayGridPlugin from '@fullcalendar/daygrid';
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [ timeGridPlugin, dayGridPlugin ],
        locale:'fr',
        timeZone: 'Europe/Paris',
        headerToolbar: {
            start:'prev,next today',
            center: 'title',
            end: 'dayGridMonth,timeGridDay',
        },
        navLinks: 'true',
        eventSources: [
            {
                url: 'calendar/read/' + activityId,
                method: 'GET',
            }
        ],

    });
    calendar.render();
});