var Calendar = tui.Calendar;

// Event Colors
const eventTypeColors = {
    1: { bgColor: "#ffd97d", color: "#ffffff" },
    2: { bgColor: "#57cc99", color: "#ffffff" },
    3: { bgColor: "#859FF6", color: "#ffffff" },
    4: { bgColor: "#F68585", color: "#ffffff" },
    5: { bgColor: "#36A2EB", color: "#ffffff" }
};

// Event ID names translated
var calendarInstance = new Calendar("#calendar", {
    calendars: [
        {
            id: "1",
            name: "Настани",
            color: eventTypeColors[1].color,
            bgColor: eventTypeColors[1].bgColor,
            dragBgColor: eventTypeColors[1].color,
            borderColor: eventTypeColors[1].bgColor
        },
        {
            id: "2",
            name: "Состаноци",
            color: eventTypeColors[2].color,
            bgColor: eventTypeColors[2].bgColor,
            dragBgColor: eventTypeColors[2].bgColor,
            borderColor: eventTypeColors[2].bgColor
        },
        {
            id: "3",
            name: "Упис на факултет",
            color: eventTypeColors[3].color,
            bgColor: eventTypeColors[3].bgColor,
            dragBgColor: eventTypeColors[3].bgColor,
            borderColor: eventTypeColors[3].bgColor
        },
        {
            id: "4",
            name: "Студентски културен настан",
            color: eventTypeColors[4].color,
            bgColor: eventTypeColors[4].bgColor,
            dragBgColor: eventTypeColors[4].bgColor,
            borderColor: eventTypeColors[4].bgColor
        }
    ],
    defaultView: "month",
    taskView: true,
    useCreationPopup: false,
    useDetailPopup: false,
    template: {
        monthDayname: function(dayname) {
            return (
                '<span class="calendar-week-dayname-name">' +
                dayname.label +
                "</span>"
            );
        }
    }
});

const dateObj = new Date()
let year = dateObj.getFullYear()
let month = dateObj.getMonth()

function monthNameEdit(month) {
    switch (month) {
        case 0:
            return 'January';
        case 1:
            return 'February';
        case 2:
            return 'March';
        case 3:
            return 'April';
        case 4:
            return 'May';
        case 5:
            return 'June';
        case 6:
            return 'July';
        case 7:
            return 'August';
        case 8:
            return 'September';
        case 9:
            return 'October';
        case 10:
            return 'November';
        case 11:
            return 'December';
    }
}

function checkYear(year, month) {
    if(month > 11) {
        return ++year
    } else if(month < 0) {
        return --year
    } else {
        return year;
    }
}

function checkMonth(month) {
    if(month > 11) {
        return 0
    } else if(month < 0) {
        return 11
    } else {
        return month
    }
}

