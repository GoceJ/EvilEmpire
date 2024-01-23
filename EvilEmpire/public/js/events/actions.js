$(function() {
    $('#renderRange').text(year + ' ' + monthNameEdit(month))

    // Show all events
    getAllEvents();

    // Calendar create events istances when date clicked
    calendarInstance.on("beforeCreateSchedule", e => {
        showEventCreationForm(e);
    });

    calendarInstance.on("clickSchedule", e => {
        showEventUpdateForm(e);
    });

    // Cancel button event listener on create modal
    $("#createCancelButton").on("click", () => {
        hideEventCreationForm('createEventModal')
        $(
            "#title_error, #event_type_id_error, #url_error, #start_date_error, #end_date_error"
        ).html("");
    });

    // Cancel button event listener on edit modal
    $("#updateCancelButton").on("click", () => {
        hideEventCreationForm('updateEventModal')
    });

    // Delete button event listener on edit modal
    $('#eventDeleteButton').on('click', deleteEvent)

    // Create event submit form
    document.getElementById("createEventForm").addEventListener("submit", e => {
        e.preventDefault();
        submitEventCreationForm();
    });
    
    // Edit event submit form
    document.getElementById("updateEventForm").addEventListener("submit", e => {
        e.preventDefault();
        submitEventUpdateForm();
    });
    
    // Button Next Meny
    $('#next').on('click', (e) => {
        calendarInstance.next()
        month++
        year = checkYear(year, month)
        month = checkMonth(month)
        $('#renderRange').text(year + ' ' + monthNameEdit(month))
    })

    // Button Prev Meny
    $('#prev').on('click', () => {
        calendarInstance.prev()
        month--
        year = checkYear(year, month)
        month = checkMonth(month)
        $('#renderRange').text(year + ' ' + monthNameEdit(month))
    })
    
    // Button Today Meny
    $('#today').on('click', () => {
        calendarInstance.today()
        year = dateObj.getFullYear()
        month = dateObj.getMonth()
        $('#renderRange').text(year + ' ' + monthNameEdit(month))
    })
})


