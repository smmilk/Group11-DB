<?php
$feedbackCursor = $feedbackCollection->find();

// Initialize arrays for bar chart
$roomTypesBarChart = [];
$averageRatings = [];

// Process feedback data for bar chart
foreach ($feedbackCursor as $feedback) {
    $bookingId = $feedback['feedback_id'];
    $rating = $feedback['rating'];

    // Query MySQL to get room type
    $bookingQuery = "SELECT rooms.type FROM booking
                     INNER JOIN rooms ON booking.room_id = rooms.room_id
                     WHERE booking.booking_id = '$bookingId'";
    $bookingResult = mysqli_query($con, $bookingQuery);

    if ($bookingResult->num_rows > 0) {
        $row = mysqli_fetch_assoc($bookingResult);
        $roomType = $row['type'];

        // Initialize arrays for room types if not already done
        if (!isset($roomTypesBarChart[$roomType])) {
            $roomTypesBarChart[$roomType] = [];
            $averageRatings[$roomType] = 0;
        }

        // Add rating to the array for the corresponding room type
        $roomTypesBarChart[$roomType][] = $rating;
    }
}

// Calculate average ratings for each room type
foreach ($roomTypesBarChart as $roomType => $ratings) {
    $averageRatings[$roomType] = array_sum($ratings) / count($ratings);
}

// Convert bar chart data to JSON for use in JavaScript
$roomTypesBarChartJson = json_encode(array_keys($roomTypesBarChart));
$averageRatingsJson = json_encode(array_values($averageRatings));

// Query MySQL to get booking data for line chart
$bookingQueryLineChart = "SELECT MONTH(check_in_date) AS month, COUNT(*) AS num_bookings
                          FROM booking
                          GROUP BY month
                          ORDER BY month";
$bookingResultLineChart = mysqli_query($con, $bookingQueryLineChart);

// Initialize arrays for line chart
$months = [];
$numBookings = [];

// Process booking data for line chart
while ($row = mysqli_fetch_assoc($bookingResultLineChart)) {
    $months[] = date('F', mktime(0, 0, 0, $row['month'], 1));
    $numBookings[] = $row['num_bookings'];
}

// Convert line chart data to JSON for use in JavaScript
$monthsJson = json_encode($months);
$numBookingsJson = json_encode($numBookings);
?>

<!-- Create a canvas for the bar chart -->
<canvas id="roomRatingsChart" width="400" height="200"></canvas><hr>

<!-- Create a canvas for the line chart -->
<canvas id="bookingLineChart" width="400" height="200"></canvas>

<script>
    // Retrieve data from PHP and create a bar chart using Chart.js
    var roomTypesBarChart = <?php echo $roomTypesBarChartJson; ?>;
    var averageRatings = <?php echo $averageRatingsJson; ?>;
    var selectedRoomType = 'all';

    var ctxBarChart = document.getElementById('roomRatingsChart').getContext('2d');
    var barChart = new Chart(ctxBarChart, {
        type: 'bar',
        data: {
            labels: roomTypesBarChart,
            datasets: [{
                label: 'Average Rating',
                data: averageRatings,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Average Ratings by Room Type',
                    font: {
                        size: 16
                    }
                }
            }
        }
    });

    // Retrieve data from PHP and create a line chart using Chart.js
    var months = <?php echo $monthsJson; ?>;
    var numBookings = <?php echo $numBookingsJson; ?>;

    var ctxLineChart = document.getElementById('bookingLineChart').getContext('2d');
    var lineChart = new Chart(ctxLineChart, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Number of Bookings',
                data: numBookings,
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Total Bookings per Month',
                    font: {
                        size: 16
                    }
                }
            }
        }
    });
</script>