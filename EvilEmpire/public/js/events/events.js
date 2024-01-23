// Convert data to show all events
function convertData(inputData) {
    let result = [];
    inputData.forEach(element => {
        result.push({
            isReadOnly: true,
            id: element.id,
            calendarId: element.event_type.id,
            title: element.title,
            body: element.event_type.type,
            category: "time",
            dueDateClass: "",
            start: element.start_date,
            // end: element.end_date,
            raw: { url: element.url, event_type: element.event_type.id }
        });
    });
    return result;
}

// Show All Events
function getAllEvents() {
    $.ajax({
        method: "GET",
        url: "events/recent",
        dataType: "json",
        success: function(data) {
            let convertedData = convertData(data);
            calendarInstance.clear();
            calendarInstance.createSchedules(convertedData);
        },
        error: function (data) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '500 Internal Server Error. Please try again later'
            })
        }
    });
}

// Create Event - check if clicked date is equal or greater than today of not return error
function showEventCreationForm(clickedDate) {
    clearEventCreationForm();

    let date = new Date(clickedDate["start"]["_date"].toISOString());
    date.setHours(date.getHours() + 2);

    let currentDate = new Date()
    if(currentDate >= date) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please enter date equal or greater than today.'
        })
    
        if (localStorage.getItem('dark') == 'true') {
            $('.swal2-modal').css('background-color', '#1A1C23')
        } else {
            $('.swal2-modal').css('background-color', 'white')
        }
        getAllEvents()
        return -1;
    } else {
        toggleCreateModel();
    }

    let start_date = document.getElementById("startDate");
    start_date.value = date.toISOString().slice(0, 16);
}

// Create Event
function submitEventCreationForm() {
    const event_data = $("#createEventForm").serializeArray();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: "events",
        type: "POST",
        data: event_data,
        success: function() {
            getAllEvents();
            displayCreateNotification();
            toggleCancelCreateButtonModel();
            $("#title_error, #event_type_id_error, #url_error, #start_date_error, #end_date_error").html("");
        },
        error: function(data) {
            let errors = Object.values(data.responseJSON);
            $(
                "#title_error, #event_type_id_error, #url_error, #start_date_error, #end_date_error"
            ).html("");
            $.each(errors[1], function(index, value) {
                $(`#${index}_error`).html(
                    `<div class="text-red-700">${value}</div>`
                );
            });
            return -1;
        }
    });
}

// Edit Event Modal Input
function showEventUpdateForm(event) {
    $( "#title_errorEdit, #event_type_id_errorEdit, #url_errorEdit, #start_date_errorEdit, #end_date_errorEdit" ).html("");

    let dateForDateTimeInputValue = date => {
        return new Date(
            date.getTime() + new Date().getTimezoneOffset() * -60 * 1000
        )
            .toISOString()
            .slice(0, 19);
    };

    toggleEditModel();

    let id = event.schedule.id;
    let title = event.schedule.title;
    let url = event.schedule.url;
    let startDate = dateForDateTimeInputValue(event.schedule.start.toDate());
    // let endDate = dateForDateTimeInputValue(event.schedule.end.toDate());

    let currentDate = new Date();
    if (currentDate.toISOString().slice(0, 19) >= startDate) {
        let button = document.getElementById("updateSubmitButton");
        button.disabled = "disabled";
        $("#updateSubmitButton").addClass("opacity-50 cursor-not-allowed");
    } else {
        let button = document.getElementById("updateSubmitButton");
        button.disabled = "";
        $("#updateSubmitButton").removeClass("opacity-50 cursor-not-allowed");
    }

    document.getElementById("updateId").value = id;
    document.getElementById("updateTitle").value = title;
    document.getElementById("updateStartDate").value = startDate;
    // document.getElementById("updateEndDate").value = endDate;
    document.getElementById("updateUrl").value = event.schedule.raw.url;
    document.getElementById("updateEventType").value = event.schedule.raw.event_type;
}

// Update event record
function submitEventUpdateForm() {
    const event_data = $("#updateEventForm").serializeArray();
    event_data[3].value = event_data[3].value.slice(0, 16);
    event_data[4].value = event_data[4].value.slice(0, 16);
    // event_data[5].value = event_data[5].value.slice(0, 16);
    // console.log(event_data);
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    let updateId = document.getElementById("updateId").value;
    $.ajax({
        url: "events/" + updateId,
        type: "PUT",
        data: event_data,
        success: function() {
            displayEditNotification();
            toggleCancelEditButtonModel();
            getAllEvents();
        },
        error: function(data) {
            let errors = Object.values(data.responseJSON);
            $.each(errors[1], function(index, value) {
                $(`#${index}_errorEdit`).html(
                    `<div class="text-red-700">${value}</div>`
                );
                $("#title").addClass("border-red-400");
            });
            return -1;
        }
    });
}

// Delete event button
function deleteEvent() {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "error",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(result => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });
            const id = $("#updateId").val();
            $.ajax({
                type: "POST",
                url: `events/${id}`,
                data: { _method: "DELETE" },
                dataType: "json",
                error: function(xhr) {
                    Swal.fire("Error!", "Event could not be deleted.", "error");
                }
            }).then(response => {
                if (response.status != 200) {
                    Swal.fire("Error!", "Event could not be deleted.", "error");
                    return -1;
                }
                Swal.fire(
                    "Deleted!",
                    "Event has been deleted.",
                    "success"
                ).then(() => {
                    displayDeleteNotification()
                    toggleCancelEditButtonModel();
                    getAllEvents();
                });
            });
        }
    });
}

// Hide Modals
function hideEventCreationForm(modalName) {
    let modal = document.getElementById(modalName);
    // modal.classList.add("hidden");
    calendarInstance.render();
}

// Clear events input form
function clearEventCreationForm() {
    let formInputs = document.querySelectorAll(".create-event-modal-input");
    formInputs.forEach(formInput => {
        formInput.value = "";
    });
    hideErrors();
}

function toggleCreateModel() {
    $('#toggle-modal-create').click()
    hideErrors();
}

function toggleEditModel() {
    $('#toggle-modal-edit').click()
    // hideErrors();
}

function toggleCancelCreateButtonModel() {
    $('#createCancelButton').click()
    hideErrors();
}

function toggleCancelEditButtonModel() {
    $('#updateCancelButton').click()
    // hideErrors();
}

function displayCreateNotification() {
    document.getElementById('notification').innerHTML = `
        <div class="alert alert-success" style="width: 95%; margin: 20px auto 0px;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
            <span>Event successfuly created.</span>
        </div>`;
}

function displayEditNotification() {
    document.getElementById('notification').innerHTML = `
        <div class="alert alert-warning" style="width: 95%; margin: 20px auto 0px;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
            <span>Event successfuly edited.</span>
        </div>`;
}

function displayDeleteNotification() {
    document.getElementById('notification').innerHTML = `
        <div class="alert alert-danger" style="width: 95%; margin: 20px auto 0px;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
            <span>Event successfuly deleted.</span>
        </div>`;
}

function hideErrors() {
    document.querySelectorAll('.error').forEach(element => {
        element.innerHTML = ''
    })
} 