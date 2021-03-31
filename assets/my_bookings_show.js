import './styles/my_bookings_show.css';

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
import interactionPlugin from '@fullcalendar/interaction';
import frLocale from '@fullcalendar/core/locales/fr';
import listPlugin from '@fullcalendar/list';
import moment from "moment";


document.addEventListener('DOMContentLoaded', function() {

    let calendarEl = document.getElementById('calendar');

    let calendar = new Calendar(calendarEl, {
        plugins: [ timeGridPlugin, dayGridPlugin,interactionPlugin, listPlugin],
        initialView: 'listYear',
        locale:frLocale,
        timeZone: 'Europe/Paris',
        selectable: true,
        allDaySlot:false,
        headerToolbar: {
            start:'prev,next',
            center: 'title',
            end: 'dayGridMonth,timeGridDay,listYear',
        },
        height:'auto',
        navLinks: 'true',
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            $("#bookingOptions").modal();
            setBookingId(info);

        },
        eventSources: [
            {
                url: '/api/calendar/readMyBookings/' + user,
                method: 'GET',
            }
        ],

    });
    calendar.render();

    request.addEventListener('load', function () {
        calendar.refetchEvents();
    });

    function setBookingId(info){
        bookingId = info.event.id ;
        console.log(moment(info.event.start).format('LLLL'));
        document.getElementById('activityLink').href = info.event.url
        document.getElementById('bookingOptionsTitle').innerText = moment(info.event.start).format('LLLL');


    }

    if(document.getElementById('bookingCancellation')){
        document.getElementById('bookingCancellation').addEventListener('click',function bookingCancel(){
            formData.append('bookingId', bookingId);
            request.open('POST', '/api/bookingCancellation/' + bookingId);
            request.send(formData);
            $("#bookingOptions .close").click();
        })
    }
});