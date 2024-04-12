document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let now = new Date();
    let formattedDate = now.toISOString().split('T')[0];

    let calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'en',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        slotDuration: '00:15:00',
        nowIndicator: true,
        slotMinTime: "00:00:00",
        slotMaxTime: "24:00:00",
        allDaySlot: false,
        initialDate: formattedDate,
        navLinks: true,
        selectable: true,
        selectMirror: true,
        selectAllow: function (selectInfo) {
            let now = new Date();
            return selectInfo.start >= now;
        },
        select: function (arg) {
            $('#date').html(dater(arg));
            $('#offcanvasScrollingUpdate').removeClass('show');
            $('#offcanvasScrolling').addClass('show');
            $('#calendar').addClass('lefter');
        },
        eventClick: function (arg) {
            $('#offcanvasScrolling').removeClass('show');
            $('#offcanvasScrollingUpdate').addClass('show');
            $('#calendar').addClass('lefter');

            $('#updateDate').html(dater(arg.event));
            $('#update_title').val(arg.event.title);
            $('#updateDescription').val(arg.event.extendedProps.description);
            $('#updateStartDateTime').val(date2HourMin(arg.event.start));
            $('#updateEndDateTime').val(date2HourMin(arg.event.end));
            $('#updateEventForm').attr('action', '/calendar/' + arg.event.id);
            $('#deleteEvent').attr('data-id', arg.event.id);
        },
        editable: true,
        droppable: true,
        eventDrop: function (info) {
            updateCalendar(info);
        },
        eventResize: function (info) {
            updateCalendar(info);
        },
        dayMaxEvents: true,
        events: events,
    });

    $('#saveEvent').click(function () {
        $('.error').html('');
        $(this).prop('disabled', true);
        let createEventForm = document.getElementById("createEventForm");
        let data = new FormData(createEventForm);
        data.append('current_date', $('#date').html());

        $.ajax({
            url: $('#createEventForm').attr('action'),
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (response) {
                $('#createEventForm')[0].reset();
                $('#closeEventCreateCanvas').click();

                calendar.addEvent({
                    id: response.googleEvent.id,
                    title: response.googleEvent.summary,
                    description: response.googleEvent.description,
                    start: response.googleEvent.start.dateTime,
                    end: response.googleEvent.end.dateTime
                });

                $('#saveEvent').prop('disabled', false);
                toastr.success('Event updated successfully!');
            },
            error: function (myErrors) {
                $.each(myErrors.responseJSON.errors, function (key, value) {
                    $('#' + key + '-error').html('').html(value);
                });

                $('#saveEvent').prop('disabled', false);
            }
        });
    });

    $('#updateEvent').click(function () {
        $('.error').html('');
        $(this).prop('disabled', true);
        let updateEventForm = document.getElementById("updateEventForm");
        let data = new FormData(updateEventForm);
        data.append('current_date', $('#updateDate').html());

        $.ajax({
            url: $('#updateEventForm').attr('action'),
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (response) {
                calendar.getEventById(response.googleEvent.id).setProp('title', response.googleEvent.summary);
                calendar.getEventById(response.googleEvent.id).setStart(response.googleEvent.start.dateTime);
                calendar.getEventById(response.googleEvent.id).setEnd(response.googleEvent.end.dateTime);
                calendar.getEventById(response.googleEvent.id).setProp('description', response.googleEvent.description);
                calendar.getEventById(response.googleEvent.id).setExtendedProp('description', 'Yeni açıklama');

                $('#updateEvent').prop('disabled', false);
                toastr.success('Event updated successfully!');
            },
            error: function (myErrors) {
                $.each(myErrors.responseJSON.errors, function (key, value) {
                    $('#' + key + '-error').html('').html(value);
                });

                $('#updateEvent').prop('disabled', false);
            }
        });
    });

    $('#deleteEvent').click(function () {
        $(this).prop('disabled', true);
        let event_id = $(this).attr('data-id');
        if (confirm('Are you sure you want to delete the event?')) {
            $.ajax({
                url: '/calendar/' + event_id,
                type: 'DELETE',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#offcanvasScrollingUpdate').removeClass('show');
                    $('#deleteEvent').prop('disabled', false);
                    let eventToRemove = calendar.getEventById(event_id);
                    if (eventToRemove) {
                        eventToRemove.remove();
                    }
                    $('#calendar').removeClass('lefter');
                    toastr.success('Event deleted successfully!');
                },
                error: function (xhr, status, error) {
                    toastr.error(xhr.responseText);
                    $('#deleteEvent').prop('disabled', false);
                }
            });
        }
    });

    calendar.render();
});

function updateCalendar(info) {
    let event = info.event;
    $.ajax({
        url: '/calendar/' + info.event.id,
        type: 'PUT',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            action: 'resize',
            update_title: event.title,
            updateStartDateTime: event.start.toISOString(),
            updateEndDateTime: event.end.toISOString()
        },
        success: function (response) {
            toastr.success('Event updated successfully!');
        },
        error: function (xhr, status, error) {
            toastr.error(xhr.responseText);
        }
    });
}

function dater(arg) {
    let startDate = arg.start;

    let startYear = startDate.getFullYear();
    let startMonth = (startDate.getMonth() + 1).toString().padStart(2, '0');
    let startDay = startDate.getDate().toString().padStart(2, '0');
    return startYear + '-' + startMonth + '-' + startDay;
}

function date2HourMin(time) {
    let date = new Date(time);

    return time.toLocaleTimeString('en-GB', {hour: '2-digit', minute: '2-digit'});
}

function formatDate(date) {
    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();

    day = day < 10 ? '0' + day : day;
    month = month < 10 ? '0' + month : month;

    return day + '-' + month + '-' + year;
}


$(document).ready(function () {
    $('#closeEventCreateCanvas').click(function () {
        $('#offcanvasScrolling').removeClass('show');
        $('#calendar').removeClass('lefter');
    });

    $('#closeEventUpdateCanvas').click(function () {
        $('#offcanvasScrollingUpdate').removeClass('show');
        $('#calendar').removeClass('lefter');
    });
});

