<?php
session_start();
if (!isset($_SESSION['user_id']) or empty($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/booking.js"></script>
</head>

<body>
    <h2>Available Events</h2>
    <div id="message"></div>

    <table border="1" id="events-table">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Date</th>
                <th>Venue</th>
                <th>Available Seats</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="events-body">
            <!-- Event rows will be injected here by JavaScript -->
        </tbody>
    </table>

    <p><a href="bookings.php">View My Bookings</a> | <a href="../auth/logout.php">Logout</a></p>

    <script>
        // Fetch and display events when the page is loaded
        $(document).ready(function() {
            fetchEvents();

            // Function to fetch events via AJAX
            function fetchEvents() {
                $.ajax({
                    url: '../ajax/fetch_events.php', // Endpoint to fetch events
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            $('#message').html('<span style="color:red;">' + response.error + '</span>');
                        } else {
                            // Empty the table body first
                            $('#events-body').empty();

                            // Loop through each event and append it to the table
                            response.forEach(function(event) {
                                $('#events-body').append(`
                                    <tr id="event-${event.id}">
                                        <td>${event.name}</td>
                                        <td>${event.event_date}</td>
                                        <td>${event.venue}</td>
                                        <td class="available-seats">${event.available_seats}</td>
                                        <td><button onclick="bookTicket(${event.id})">Book Ticket</button></td>
                                    </tr>
                                `);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#message').html('<span style="color:red;">An error occurred while fetching events.</span>');
                    }
                });
            }

            // Book ticket function (as described earlier)
            window.bookTicket = function(eventId) {
                $.ajax({
                    url: '../ajax/book_ticket.php',
                    method: 'POST',
                    data: {
                        event_id: eventId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#message').html('<span style="color:green;">' + response.success + '</span>');
                            fetchEvents();
                        } else {
                            $('#message').html('<span style="color:red;">' + response.error + '</span>');
                        }
                    },
                    error: function() {
                        $('#message').html('<span style="color:red;">An error occurred. Please try again.</span>');
                    }
                });
            };
        });
    </script>
</body>

</html>