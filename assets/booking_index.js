import './styles/booking_index.css';
let request = new XMLHttpRequest();
let formData = new FormData();
let bookingId;
let newBookingStartAt;
let newBookingEndAt;
moment.locale('fr');
/* FullCalendar_integration */

import { Calendar } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import dayGridPlugin from '@fullcalendar/daygrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';
import frLocale from '@fullcalendar/core/locales/fr';
import moment from "moment";


document.addEventListener('DOMContentLoaded', function() {

    let calendarEl = document.getElementById('calendar');

    let calendar = new Calendar(calendarEl, {
        plugins: [ timeGridPlugin, dayGridPlugin, interactionPlugin, listPlugin],
        locale:frLocale,
        timeZone: 'Europe/Paris',
        selectable: true,
        allDaySlot:false,
        headerToolbar: {
            start:'prev,next today',
            center: 'title',
            end: 'dayGridMonth,timeGridDay,listYear',
        },
        select: function(info) {
            if(document.getElementById('bookingAdd')){
                $("#bookingCreation").modal();
                setBookingStartEndDateTime(info);
            }
        },
        height:'auto',
        navLinks: 'true',
        eventClick: function(info) {
            $("#bookingOptions").modal();
            setBookingId(info);
        },
        eventSources: [
            {
                url: '/api/calendar/read/' + activityId,
                method: 'GET',
            }
        ],

    });
    calendar.render();

    request.addEventListener('load', function () {
        calendar.refetchEvents();
    });

    function setBookingId(info){
        bookingId = info.event.id
        document.getElementById('bookingEdition').setAttribute('href', bookingId + '/edit')
        document.getElementById('bookingOptionsTitle').innerText = moment(info.event.start).format('LLL');
    }

    function setBookingStartEndDateTime(info){
        newBookingStartAt = info.startStr;
        newBookingEndAt = info.endStr;
    }
    if(document.getElementById('bookingAdd')){
        document.getElementById('bookingAdd').addEventListener('click', function bookingAdd() {
            //ici mon ajax
            let newEvent = document.getElementById("bookingCreation")
            formData.append('newBookingStartAt', newBookingStartAt);
            formData.append('newBookingEndAt', newBookingEndAt);
            request.open('POST', '/api/bookingCreation/' + activityId);
            request.send(formData);
            $("#bookingCreation .close").click();
        });
    }

    if(document.getElementById('bookingReservation')) {
        document.getElementById('bookingReservation').addEventListener('click', function bookingReserve() {
            formData.append('bookingId', bookingId);
            request.open('POST', '/api/bookingReservation/' + bookingId);
            request.send(formData);
            $("#bookingOptions .close").click();

        });
    }

    if(document.getElementById('bookingCancellation')){
        document.getElementById('bookingCancellation').addEventListener('click',function bookingCancel(){
            formData.append('bookingId', bookingId);
            request.open('POST', '/api/bookingCancellation/' + bookingId);
            request.send(formData);
            $("#bookingOptions .close").click();
        })
    }

    if(document.getElementById('bookingRemoval')) {
        document.getElementById('bookingRemoval').addEventListener('click', function bookingDelete() {
            formData.append('bookingId', bookingId);
            request.open('POST', '/api/bookingDelete/' + bookingId);
            request.send(formData);
            $("#bookingOptions .close").click();
        })
    }
});
/* /fullCalendar_integration */


/* fullCalendar_user_interactions */


/* /fullCalendar_user_interactions */