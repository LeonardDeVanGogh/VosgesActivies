import './styles/booking_index.css';
let request = new XMLHttpRequest();
let formData = new FormData();
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
            $("#bookingCreation").modal();
            setBookingStartEndDateTime(info);
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


function setBookingId(info){
    document.getElementById("bookingOptions").dataset.bookingId = info.event.id;
}
function setBookingStartEndDateTime(info){
    document.getElementById("bookingCreation").dataset.start = info.startStr;
    document.getElementById("bookingCreation").dataset.end = info.endStr;
}

document.getElementById('bookingAdd').addEventListener('click', function bookingAdd() {
        //ici mon ajax
        let newEvent = document.getElementById("bookingCreation")
        console.log('Create from ' + newEvent.dataset.start + " to " + newEvent.dataset.end);
    }
)

if(document.getElementById('bookingReservation')) {
    document.getElementById('bookingReservation').addEventListener('click', function bookingReserve() {
        //ici mon ajax
        console.log('Reserve ' + document.getElementById('bookingOptions').dataset.bookingId);
        formData.append('bookingId', document.getElementById('bookingOptions').dataset.bookingId);
        request.open('POST', '/api/bookingReservation/' + document.getElementById('bookingOptions').dataset.bookingId);
        request.addEventListener('load', function () {
            calendar.refetchEvents();
        });
        request.send(formData);
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
