import './styles/booking_index.css';

/* FullCalendar_integration */

import { Calendar } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');

    let calendar = new Calendar(calendarEl, {
        plugins: [ timeGridPlugin, dayGridPlugin,interactionPlugin],
        locale:'fr',
        timeZone: 'Europe/Paris',
        selectable: true,
        headerToolbar: {
            start:'prev,next today',
            center: 'title',
            end: 'dayGridMonth,timeGridDay',
        },
        select: function(info) {
            bookingCreate(info);
        },
        navLinks: 'true',
        eventClick: function(info) {
            $("#bookingOptions").modal();
           setBookingId(info);
        },
        eventSources: [
            {
                url: 'calendar/read/' + activityId,
                method: 'GET',
            }
        ],

    });
    calendar.render();
});
/* /fullCalendar_integration */

/* fullCalendar_user_interactions */
function bookingCreate(info){
    console.log('Create from ' + info.startStr + " to " + info.endStr);
}

function setBookingId(info){
    document.getElementById("bookingOptions").dataset.bookingId = info.event.id;
}
if(document.getElementById('bookingReservation')) {
    document.getElementById('bookingReservation').addEventListener('click', function bookingReserve() {
            //ici mon ajax
            console.log('Reserve');
        }
    )
}
if(document.getElementById('bookingCancellation')){
    document.getElementById('bookingCancellation').addEventListener('click',function bookingCancel(){
            //ici mon ajax
            console.log('Cancel');
        }
    )
}
if(document.getElementById('bookingRemoval')) {
    document.getElementById('bookingRemoval').addEventListener('click', function bookingDelete() {
            //ici mon ajax
            console.log('Delete');
        }
    )
}
/* /fullCalendar_user_interactions */
