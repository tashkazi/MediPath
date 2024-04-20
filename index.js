document.addEventListener('DOMContentLoaded', function() {
    var menuIcon = document.getElementById('menu-icon');
    var dropdownMenu = document.getElementById('dropdown-menu');


    menuIcon.addEventListener('click', function() {
        dropdownMenu.classList.toggle('show');
    });

    document.addEventListener('click', function(event) {
        if (!menuIcon.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove('show');
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        // Your FullCalendar options here
        // For example:
        plugins: [ 'dayGrid' ],
        events: [
            {
                title: 'Appointment 1',
                start: '2024-03-26'
            },
            {
                title: 'Appointment 2',
                start: '2024-03-27'
            }

        ]
    });
    calendar.render();
});
