$(document).ready(function () {
    const loggedInUserId = '{{USER_ID}}'; // Ensure proper sanitization of USER_ID

    if (loggedInUserId) { // Checking if logged in user ID exists
        $.ajax({
            url: 'getAppointment.php',
            method: 'GET',
            success: function (response) {
                if (!response || response.error) {
                    console.error('Error fetching appointments or empty response from server.');
                    return;
                }

                // Render appointments on the patient calendar
                renderAppointments(response);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching appointments:', error);
            }
        });
    }
});

function renderAppointments(appointments) {
    $('#patientCalendar').fullCalendar({ // Use #patientCalendar instead of #calendar
        defaultView: 'month',
        defaultDate: '2024-03-12',
        events: appointments,
        eventRender: function (event, element) {
            // Create a custom tooltip using Popper.js
            var tooltip = $('<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>');
            tooltip.find('.tooltip-inner').text(event.description); // Set the event description as tooltip content

            new Popper(element, tooltip, {
                placement: 'top',
                modifiers: {
                    offset: {
                        offset: '0, 10'
                    }
                }
            });

            $(element).append(tooltip);

            $(element).removeAttr('title');
        }
    });
}
